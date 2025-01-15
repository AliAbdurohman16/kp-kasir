<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Branch;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Laravolt\Avatar\Facade as Avatar;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['employees'] = User::whereHas('roles', function ($query) {
                    $query->where('name', '!=', 'user');
                })->orderBy('created_at', 'desc')
                ->get();

        return view('backend.employee.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = [
            'roles' => Role::where('name', '!=', 'user')->get(),
            'branches' => Branch::orderBy('created_at', 'asc')->get()
        ];

        return view('backend.employee.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required',
            'branch_id' => 'required',
        ]);

        unset($data['role']);

        $avatarImage = Avatar::create($data['name'][0])
            ->setBackground(sprintf('#%06X', mt_rand(0, 0xFFFFFF))) // Random background color
            ->setDimension(100, 100) // Avatar size
            ->getImageObject(); // Generates the image as a GD object

        $avatarName = Str::random(10) . '.png';
        $avatarPath = 'avatars/' . $avatarName;

        Storage::disk('public')->put($avatarPath, $avatarImage->encode('png'));

        $data['avatar'] = $avatarName;
        $data['password'] = Hash::make($request->password);
        
        $employee = User::create($data)->assignRole($request->role);

        return redirect('employees')->with('message', 'Berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = [
            'employee' => User::find($id),
            'roles' => Role::where('name', '!=', 'user')->get(),
            'branches' => Branch::orderBy('created_at', 'asc')->get()
        ];

        return view('backend.employee.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $employee = User::find($id);

        $data = $request->validate([
            'name' => 'required',
            'email' => $employee->email === $request->email ? 'required|email' : 'required|email|unique:users,email',
            'password' => $request->password ? 'required|min:8|confirmed' : '',
            'branch_id' => 'required',
        ]);

        $isNameChanged = $employee->name !== $request->name;

        if ($isNameChanged) {
            $avatarImage = Avatar::create($data['name'][0])
                ->setBackground(sprintf('#%06X', mt_rand(0, 0xFFFFFF))) // Random background color
                ->setDimension(100, 100) // Avatar size
                ->getImageObject(); // Generates the image as a GD object

            $avatarName = Str::random(10) . '.png';
            $avatarPath = 'avatars/' . $avatarName;

            if ($employee->avatar && Storage::disk('public')->exists('avatars/' . $employee->avatar)) {
                Storage::disk('public')->delete('avatars/' . $employee->avatar);
            }

            Storage::disk('public')->put($avatarPath, $avatarImage->encode('png'));
        }

        $data['avatar'] = $avatarName ?? $employee->avatar;
        $data['password'] = $request->password ? Hash::make($request->password) : $employee->password;
        
        $employee->update($data);

        if ($request->role !== $employee->name) {
            $employee->syncRoles($request->role);
        }

        return redirect('employees')->with('message', 'Pegawai berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = User::find($id);

        if ($employee->avatar) {
            Storage::disk('public')->delete('avatars/' . $employee->avatar);

            $employee->delete();

            return response()->json(['message' => 'Berhasil dihapus!']);
        }
    }
}
