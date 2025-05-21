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
        <img src="{{ asset('storage/avatars/' . $user->avatar) }}" alt="Foto Profil" width="150" class="rounded mb-3">
    @else
        <img src="{{ asset('default-avatar.png') }}" alt="Default Avatar" width="150" class="rounded mb-3">
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="username">Username</label>
            <input type="text" name="username" value="{{ old('username', $user->username) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label for="email">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label for="avatar">Upload Foto Profil</label>
            <input type="file" name="avatar" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update Profil</button>
    </form>
</div>
@endsection
