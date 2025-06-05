@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Profil</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Tampilkan foto avatar --}}
    @if ($user->avatar)
        {{-- Path ini sudah benar jika Anda mengikuti saran controller sebelumnya dan sudah menjalankan php artisan storage:link --}}
        <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="Foto Profil" width="150" class="img-thumbnail rounded-circle mb-3" style="object-fit: cover; height: 150px;">
    @else
        {{-- Pastikan default-avatar.png ada di public/default-avatar.png atau sesuaikan pathnya --}}
        <img src="{{ asset('images/default-avatar.png') }}" alt="Default Avatar" width="150" class="img-thumbnail rounded-circle mb-3" style="object-fit: cover; height: 150px;">
        {{-- Ganti 'images/default-avatar.png' dengan 'default-avatar.png' jika file ada di root public --}}
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- Pastikan route Anda menggunakan method PUT atau PATCH --}}

        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" class="form-control @error('username') is-invalid @enderror">
            @error('username')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror">
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="avatar" class="form-label">Upload Foto Profil (Kosongkan jika tidak ingin mengganti)</label>
            <input type="file" name="avatar" id="avatar" class="form-control @error('avatar') is-invalid @enderror">
            @error('avatar')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update Profil</button>
    </form>
</div>
@endsection