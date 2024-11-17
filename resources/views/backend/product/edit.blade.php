@extends('layouts.backend.main')

@section('title', 'Edit Paket')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">@yield('title')</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="{{ route('dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>-</li>
        <li class="fw-medium">@yield('title')</li>
    </ul>
</div>

<div class="row gy-4">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body mt-3">
                <form action="{{ route('products.update', $product) }}" class="row gy-3 needs-validation" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="col-sm-12">
                        <label class="form-label">Gambar</label>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="text-center mb-4">
                                    <img src="{{ asset('storage/products/' . $product->image) }}" alt="image"class="img-thumbnail img-preview" width="100px">
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="form-group">
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" name="image" id="image"  accept="image/*" onchange="previewImg()">
                                    @error('image')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Nama Produk</label>
                        <div class="form-group">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $product->name }}" placeholder="Nama Produk">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Stok</label>
                        <div class="form-group">
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" name="stock" value="{{ $product->stock }}" placeholder="Stok">
                            @error('stock')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <label class="form-label">Harga</label>
                        <div class="form-group">
                            <input type="text" class="form-control @error('price') is-invalid @enderror" name="price" id="price" value="{{ intval($product->price) }}" placeholder="Harga">
                            @error('price')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 mb-3 mt-3">
                        <button class="btn btn-primary-600 w-100" type="submit">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>      
</div>
@endsection

@section('js')
<script src="{{ asset('backend') }}/assets/plugins/autoNumeric/autoNumeric.min.js"></script>
<script>
    new AutoNumeric('#price', {
        currencySymbol : 'Rp ',
        decimalCharacter : ',',
        digitGroupSeparator : '.',
        decimalPlaces: 0,
    });

    function previewImg() {
        const image = document.querySelector('#image');
        const imgPreview = document.querySelector('.img-preview');
        const fileImg = new FileReader();
        fileImg.readAsDataURL(image.files[0]);
        fileImg.onload = function(e) {
            imgPreview.src = e.target.result;
        }
    }

    function hotel1(starCount) {
        const stars = document.querySelectorAll('.star-hotel-1 i');
        stars.forEach((star, index) => {
            if (index < starCount) {
                star.classList.add('active');
            } else {
                star.classList.remove('active');
            }
        });
        // Set the hidden input value
        document.getElementById('hotel1').value = starCount;
    }

    function hotel2(starCount) {
        const stars = document.querySelectorAll('.star-hotel-2 i');
        stars.forEach((star, index) => {
            if (index < starCount) {
                star.classList.add('active');
            } else {
                star.classList.remove('active');
            }
        });
        // Set the hidden input value
        document.getElementById('hotel2').value = starCount;
    }
</script>
@endsection