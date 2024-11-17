<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Laravolt\Avatar\Facade as Avatar;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function index()
    {
        $data['profile'] = Auth::user();

        return view('backend.profile.index', $data);
    }

    public function store(Request $request)
    {
        $profile = Auth::user();

        $data = $request->validate([
            'avatar' => 'mimes:jpg,png,jpeg|image|max:2048',
            'name' => 'required',
            'email' => $profile->email === $request->email ? 'required|email' : 'required|email|unique:users,email',
        ]);

        if ($request->hasFile('avatar')) {
            if ($profile->avatar) {
                Storage::disk('public')->delete('avatars/' . $profile->avatar);
            }

            $data['avatar'] = basename($request->file('avatar')->store('avatars', 'public'));
        }

        $profile->update($data);

        return redirect()->back()->with('message', 'Data berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $profile = Auth::user();

        Storage::disk('public')->delete('avatars/' . $profile->avatar);

        // Create an avatar from the first letter of the name
        $initials = strtoupper($profile->name[0]);

        $avatarImage = Avatar::create($initials)
            ->setBackground(sprintf('#%06X', mt_rand(0, 0xFFFFFF))) // Random background color
            ->setDimension(100, 100) // Avatar size
            ->getImageObject(); // Generates the image as a GD object

        $avatarName = Str::random(10) . '.png';
        $avatarPath = 'avatars/' . $avatarName;
    
        Storage::disk('public')->put($avatarPath, $avatarImage->encode('png'));

        $profile->update(['avatar' => $avatarName]);

        return redirect()->back()->with('message', 'Foto berhasil dihapus!');
    }
}
