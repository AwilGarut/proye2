@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="container">
    <h2 class="text-center mb-4">Edit Profil</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Gambar Profil -->
   <div class="text-center mb-4">
    @if($user->avatar)
    <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="Avatar" class="rounded-circle" width="100">
@else
    <img src="{{ asset('images/default-avatar.png') }}" alt="Default Avatar" class="rounded-circle" width="100">
@endif
</div>

        <!-- Username -->
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" name="username" id="username" class="form-control" value="{{ old('username', $user->username) }}" required>
        </div>

        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <!-- Change Photo -->
        <div class="mb-3">
            <label for="avatar" class="form-label">Change Photo</label>
            <input type="file" name="avatar" id="avatar" class="form-control">
        </div>

        <!-- Tombol Submit -->
        <button type="submit" class="btn btn-success w-100">Update Profile</button>
    </form>
</div>
@endsection