@extends('layouts.main')

@section('container')

<main class="form-signin login">
    <form action="/admin" method="POST">
        @csrf
        <div class="text-center">
            <img class="mb-4" src="img/logo.png" alt="" width="72" height="57">
            <h1 class="h3 mb-3 fw-normal">Login Menu Admin</h1>
        </div>
        @error('username')
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Login Gagal Username Password Salah
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @enderror
        @if (session()->has('loginError'))
            <div class="alert alert-danger alert-disimssible fade show" role="alert">
                {{ session('loginError') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="form-floating mb-1">
            <input name="username" type="text" class="form-control @error('username') is-invalid @enderror" id="username" value="{{ old('username') }}" placeholder="name@example.com">
            <label for="username">Username</label>
        </div>
        <div class="form-floating">
            <input name="password" type="password" class="form-control @error('username') is-invalid @enderror" id="password" placeholder="Password">
            <label for="password">Password</label>
        </div>
            <button class="w-100 mt-2 btn btn-lg btn-jaro" type="submit">Masuk</button>
    </form>
</main>
    
@endsection