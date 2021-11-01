@extends('layouts/main')

@section('container')
    
    <div class="row mb-4">
        <div class="col-md bg-text">
            <div class="text-center mb-5">
                <h1 class="cek">{{ $data['cek'] }}</h1>
                <h2 class="plagiat">{{ $data['plagiat'] }}</h2>
                <h3 class="wartawan">{{ $data['wartawan'] }}</h3>
            </div>
            <div class="text-center mb-5">
                <p class="mb-4">
                {{ $data['content'] }}
                </p>
                <div class="d-grid gap-2 col-6 mx-auto">
                    <a href="{{ url('cek-plagiarism') }}" class="btn btn-jaro">CEK SEKARANG</a>
                </div>
            </div>
            <div class="text-center">
                <a class="me-3 bg-link" href="{{ $data['instagram'] }}" target="_blank">
                    <span class="fab fa-instagram-square size">
                </a>
                <a class="me-3 bg-link" href="{{ $data['linkind'] }}" target="_blank">
                    <span class="fab fa-linkedin size">
                </a>
                <a class="me-3 bg-link" href="{{ $data['facebook'] }}" target="_blank">
                    <span class="fab fa-facebook-square size">
                </a>
            </div>
        </div>
        <div class="col-md">
            <div class="text-center">
                <img class="img" src="img/pelagiat.jpg" alt="" srcset="">
            </div>
        </div>
    </div>

@endsection