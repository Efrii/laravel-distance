@extends('layouts/main')

@section('container')
<div class="align-items-center p-3 my-3 text-white bg-jaro rounded shadow-sm">
    {{-- <img class="me-3" src="img/logo.png" alt="" width="48" height="38"> --}}
    <div class="lh-1 text-center">
      <h1 class="h6 mb-0 text-white lh-1">Algoritma Jaro Winkler</h1>
      {{-- <small>Periksa text yang ada jika ada kata atau kalimat yang tidak penting dan ingin di hapus silahkan bisa di hapus secara manual</small> --}}
    </div>
</div>
<div class="text-center">
    <p>{{ $waktuLoad }}</p>
</div>
<div>
    <div class="row">
        <div class="col">
            <form action="{{ url('result-plagiarism') }}" method="post">
                @csrf
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm mb-2">
                            <div class="shadow-lg text-center fs-6 rounded bg-jaro mb-3 p-2">
                                <table>
                                    <thead class="fw-light text-light">
                                        <tr style="height: 30px">
                                            <td>Judul&nbsp;</td>
                                            <td>:&nbsp;</td>
                                            <td>
                                                @if ($titlelink1 == null)
                                                    -
                                                @elseif ($titlelink1 == $titlelink1)
                                                    {{ $titlelink1 }}
                                                @endif
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody class="fw-light text-light">
                                        <tr style="height: 30px">
                                          <td>Wartawan&nbsp;</td>
                                          <td>:&nbsp;</td>
                                          <td>
                                            @if ($wartawanlink1 == null)
                                                -
                                            @elseif ($wartawanlink1 == $wartawanlink1)
                                                {{ $wartawanlink1 }}
                                            @endif
                                          </td>
                                        </tr>
                                        <tr style="height: 30px">
                                            <td>Word&nbsp;</td>
                                            <td>:&nbsp;</td>
                                            <td>
                                                <span class="me-2" id="word-count3"> 
                                                    <div class="spinner-border spinner-border-sm" role="status"></div>
                                                </span> <i class="fas fa-file-word"></i>
                                            </td>
                                        </tr>
                                      </tbody>
                                </table>
                            </div>
                            <textarea id="textBox3" style="height: 600px" class="form-control shadow-lg rounded" name="string1" rows="5" required>{{ $string1 }}</textarea>
                        </div>
                            <div class="col-sm">
                                <div class="shadow-lg card-header rounded text-white bg-jaro mb-3">Hasil Get Data Url Berita 1</div>
                                @foreach ($allData as $data)
                                    @if (!empty($data['1'][0]))
                                        <div class="shadow-lg p-3 mb-1 bg-white fs-6 rounded p-1 m-0">
                                            <div>
                                                <p class="fs-6 fw-bolder">{!! $data['1'][0]['htmlTitle'] !!}</p>
                                            </div>
                                            <div>
                                                <span>{!! $data['1'][0]['snippet'] !!}</span>
                                            </div>
                                            <div class="mb-3">
                                                <span>
                                                    <a href="{{ $data['1'][0]['link'] }}" target="_blank">{{ $data['1'][0]['link'] }}</a>
                                                </span>
                                            </div>
                                            @if ($data['3'] > 70 && $data['3'] <= 100)
                                                <div class='progress' style='height:20px'>
                                                    <div class='progress-bar bg-danger progress-bar-striped progress-bar-animated' style='width:{{ $data['3'] }}%;height:20px'><span class="fs-6">{{ $data['3'] }}%</span></div>
                                                </div>
                                            @elseif ($data['3'] > 30 && $data['3'] <=70 )
                                                <div class='progress' style='height:20px'>
                                                    <div class='progress-bar bg-warning progress-bar-striped progress-bar-animated' style='width:{{ $data['3'] }}%;height:20px'><span class="fs-6">{{ $data['3'] }}%</span></div>
                                                </div>
                                            @elseif ($data['3'] >=0 && $data['3'] <=30)
                                                <div class='progress' style='height:20px'>
                                                    <div class='progress-bar bg-success progress-bar-striped progress-bar-animated' style='width:{{ $data['3'] }}%;height:20px'><span class="fs-6">{{ $data['3'] }}%</span></div>
                                                </div>
                                            @endif
                                        <i class="fas fa-stopwatch mt-2"></i> {{ $data['4'] }}
                                    </div>
                                    @else

                                    @endif
                            
                                @endforeach                              
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="row mt-4 mb-4">
                        <div class="text-center">
                            <a class="btn btn-jaro" href="{{ url('cek-plagiarism') }}">
                                Batal
                            </a>
                            <button id="submitJaro" type="submit" value="Submit"class="btn btn-jaro">Cek Plagiarisme <i class="fas fa-arrow-circle-right"></i></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection