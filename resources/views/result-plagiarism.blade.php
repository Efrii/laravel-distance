@extends('layouts/main')

@section('container')
    <div class="text-center mb-3">
        <div class="rounded p-2 text-center text-light bg-jaro" style="display: inline-block;">
            Hasil Plagiarisme
        </div>
    </div>
    <div class="row text-center">
        <div class="col">
            <div class="rounded mb-3 p-2 text-center text-light bg-jaro" style="display: inline-block;">
                Berita 1
            </div>
            <br>
            <textarea name="" id="" disabled style="width: 100%; height: 200px">{{ $string1 }}</textarea>
        </div>
        <div class="col">
            <div class="rounded mb-3 p-2 text-center text-light bg-jaro" style="display: inline-block;">
                Berita 2
            </div>
            <br>
            <textarea name="" id="" disabled style="width: 100%; height: 200px">{{ $string2 }}</textarea>
        </div>
    </div>
    @if ($similarity > 60 && $similarity <= 100)
        <div class='progress' style='height:30px'>
            <div class='progress-bar bg-danger progress-bar-striped progress-bar-animated' style='width:{{ $similarity }}%;height:30px'><span class="fs-5">{{ $similarity }}%</span></div>
        </div>
    @elseif ($similarity > 20 && $similarity <=60 )
        <div class='progress' style='height:30px'>
            <div class='progress-bar bg-warning progress-bar-striped progress-bar-animated' style='width:{{ $similarity }}%;height:30px'><span class="fs-5">{{ $similarity }}%</span></div>
        </div>
    @elseif ($similarity >=0 && $similarity <=20)
        <div class='progress' style='height:30px'>
            <div class='progress-bar bg-success progress-bar-striped progress-bar-animated' style='width:{{ $similarity }}%;height:30px'><span class="fs-5">{{ $similarity }}%</span></div>
        </div>
    @endif
    <p><i class="fas fa-stopwatch"></i> {{ $waktu }}</p>

    <h2>Jaro Distance</h2>

    <h2>$$d _j = {1 \over 3} \times \biggl({m \over s_1}+{m \over s_2}+{m - t \over m}\biggr) $$</h2>
    <h2>$$d _j = {1 \over 3} \times \biggl({ {{ $commonCar }} \over {{ $length1 }} }+{ {{ $commonCar }} \over {{ $length2 }} }+{ {{ $commonCar }} - {{ $transposisi }} \over {{ $commonCar }} }\biggr) $$</h2>
    <h2>$$d _j = {{ $distance }} $$</h2>
    
    <h2>Jaro Winkler Distance</h2>
    <h2>$$d_w = d_j + ( l  \times p (1 - d_j)) $$</h2>
    <h2>$$d_w = {{ $distance }} + ( {{ $prefix }}  \times  0.1 (1 - {{ $distance }})) $$</h2>
    <h2>$$d_w = {{ $similarity }} $$</h2>

    <p>Case Folding</p>
    <p>{{ $caseFolding1 }}</p>
    <p>{{ $caseFolding2 }}</p>
    <br>
    <p>Number Removal</p>
    <p>{{ $numberRemoval1 }}</p>
    <p>{{ $numberRemoval2 }}</p>
    <br>
    <p>Filtering</p>
    <p>{{ $filtering1 }}</p>
    <p>{{ $filtering2 }}</p>
    <p>------</p>
    <br>
    <p>Steming</p>
    <p>{{ $steming1 }}</p>
    <p>{{ $steming2 }}</p>
    <br>
    <p>Space Removal</p>
    <p>{{ $removeSpace1 }}</p>
    <p>{{ $removeSpace2 }}</p>
    <br>
    <p>{{ $length1 }}</p>
    <p>{{ $length2 }}</p>
    <p>Com Char</p>
    <p>{{ $commonChar }}</p>
    <p>{{ $commonCar }}</p>
    <p>tran</p>
    <p>{{ $transposisi }}</p>
    <p>{{ $distance }}</p>
    <p>{{ $similirity_no }}</p>


@endsection