@extends('layouts/main')

@section('container')
    <div class="align-items-center p-3 my-3 text-white bg-jaro rounded shadow-sm">
        {{-- <img class="me-3" src="img/logo.png" alt="" width="48" height="38"> --}}
        <div class="lh-1 text-center">
            <h1 class="h6 mb-0 text-white lh-1">Hasil Similarity Berita Online</h1>
            <br>
            <div>
                <span>Keterangan :</span>
                <br>
                <br>
                <div class='progress' style='height:20px'>
                    <div class='progress-bar bg-danger progress-bar-striped progress-bar-animated' style='width:100%;height:20px'><span class="fs-6">70% -> 100% Similarity Berat</span></div>
                </div>
                <br>
                <div class='progress' style='height:20px'>
                    <div class='progress-bar bg-warning progress-bar-striped progress-bar-animated' style='width:70%;height:20px'><span class="fs-6">30% -> 70% Similarity Sedang</span></div>
                </div>
                <br>
                <div class='progress' style='height:20px'>
                    <div class='progress-bar bg-success progress-bar-striped progress-bar-animated' style='width:30%;height:20px'><span class="fs-6">0% -> 30% Similarity Ringan</span></div>
                </div>
            </div>
        </div>
    </div>
    <div class="shadow-lg text-center fs-6 rounded bg-jaro mb-3 p-2">
        <table>
            <tbody class="fw-light text-light">
                <tr style="height: 30px">
                    <td>Judul&nbsp;</td>
                    <td>:&nbsp;</td>
                    <td>
                        {{ $info['title'] }}
                    </td>
                </tr>
                <tr style="height: 30px">
                  <td>Wartawan&nbsp;</td>
                  <td>:&nbsp;</td>
                  <td>
                    {{ $info['wartawan'] }}
                  </td>
                </tr>
                <tr style="height: 30px">
                    <td>Waktu&nbsp;</td>
                    <td>:&nbsp;</td>
                    <td>
                        {{ $info['waktu'] }}
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
    <textarea id="textBox3" style="height: 400px; margin-top: -16;" class="form-control shadow-lg rounded" name="string1" rows="5" required>{{ $string1 }}</textarea>
    <div class="mt-4">
        <div class="shadow-lg card-header rounded text-black mb-3">
            <p class="fs-6 fw-bolder mt-3">{{ count(array_filter($allData)) }} Hasil</p>
            <table class="table table-striped table-bordered text-center" style="width: 100%;">
                <thead>
                    <tr class="fw-bold">
                        <td>No</td>
                        <td>Judul</td>
                        <td>Similarity</td>
                        <td>Detail</td>
                    </tr>
                </thead>
                <colgroup>
                    <col span="1" style="width: 3%;">
                    <col span="1" style="width: 50%;">
                    <col span="1" style="width: 55%;">
                    <col span="1" style="width: 4%;">
                </colgroup>
                <tbody>
                    @foreach ( $allData as $data )
                        @if (!empty($data['Data']))
                            <tr>
                                <td>
                                    {{ $no++ }}
                                </td>
                                <td>
                                    <div>
                                        <a style="text-decoration: none" class="link-primary" href="{{ $data['Data']['link'] }}" target="_blank">
                                            <p class="fs-6 fw-bolder">{!! $data['Data']['htmlTitle'] !!}</p>
                                        </a>
                                    </div>
                                    <div>
                                        <span>{!! $data['Data']['snippet'] !!}</span>
                                    </div>
                                </td>
                                <td>
                                    @if ($data['Jaro_Win_Distance'] > 70 && $data['Jaro_Win_Distance'] <= 100)
                                        <div class='progress' style='height:20px'>
                                            <div class='progress-bar bg-danger progress-bar-striped progress-bar-animated' style='width:{{ $data['Jaro_Win_Distance'] }}%;height:20px'><span class="fs-6">{{ $data['Jaro_Win_Distance'] }}%</span></div>
                                        </div>
                                    @elseif ($data['Jaro_Win_Distance'] > 30 && $data['Jaro_Win_Distance'] <=70 )
                                        <div class='progress' style='height:20px'>
                                            <div class='progress-bar bg-warning progress-bar-striped progress-bar-animated' style='width:{{ $data['Jaro_Win_Distance'] }}%;height:20px'><span class="fs-6">{{ $data['Jaro_Win_Distance'] }}%</span></div>
                                        </div>
                                    @elseif ($data['Jaro_Win_Distance'] >=0 && $data['Jaro_Win_Distance'] <=30)
                                        <div class='progress' style='height:20px'>
                                            <div class='progress-bar bg-success progress-bar-striped progress-bar-animated' style='width:{{ $data['Jaro_Win_Distance'] }}%;height:20px'><span class="fs-6">{{ $data['Jaro_Win_Distance'] }}%</span></div>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <a type="button" class="btn btn-jaro" data-bs-toggle="modal" data-bs-target="#{{ $data['Id'] }}">
                                        <i class="fas fa-plus-circle"></i>
                                    </a>
                                </td>
                            </tr>
                            <div class="modal fade" id="{{ $data['Id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-xl modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">{!! $data['Data']['htmlTitle'] !!}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container row mb-2">
                                                <span><strong>Case Folding</strong></span>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <textarea  class="form-control" rows="5">{{ $casefolding }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <textarea  class="form-control" rows="5">{{ $data['CaseFolding'] }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="container row mb-2">
                                                <span><strong>Number Removal</strong></span>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <textarea  class="form-control" rows="5">{{ $numberremoval }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <textarea  class="form-control" rows="5">{{ $data['NumberRemoval'] }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="container row mb-2">
                                                <span><strong>Filtering</strong></span>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <textarea  class="form-control" rows="5">{{ $filtering }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <textarea  class="form-control" rows="5">{{ $data['Filtering'] }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="container row mb-2">
                                                <span><strong>Stemming</strong></span>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <textarea  class="form-control" rows="5">{{ $stemming }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <textarea  class="form-control" rows="5">{{ $data['Stemming'] }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="container row mb-2">
                                                <span><strong>Space Removal</strong></span>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <textarea  class="form-control" rows="5">{{ $spaceremoval }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <textarea  class="form-control" rows="5">{{ $data['SpaceRemoval'] }}</textarea>
                                                    </div>
                                                </div>
                                            </div> --}}
                                            <div class="container row mb-2">
                                                <span><strong>String Lenght</strong></span>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <textarea  class="form-control" rows="5">{{ $lenghtstring }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <textarea  class="form-control" rows="5">{{ $data['LenghtString'] }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
<div>
    <div class="row">
        <div class="col">
                <div class="form-group">
                    <div class="row">
                        <div class="col-sm mb-2">
                           
                        {{-- </div>
                            <div class="col-sm">
                                <div class="shadow-lg card-header rounded text-white bg-jaro mb-3">Hasil Similarity Berita Online</div> --}}
                                {{-- @foreach ($allData as $data)
                                    @if (!empty($data['Data']))
                                        <div class="shadow-lg p-3 mb-2 bg-white fs-6 rounded p-1 m-0">
                                            <div>
                                                <p class="fs-6 fw-bolder">{!! $data['Data']['htmlTitle'] !!}</p>
                                            </div>
                                            <div>
                                                <span>{!! $data['Data']['snippet'] !!}</span>
                                            </div>
                                            <div class="mb-3">
                                                <span>
                                                    <a href="{{ $data['Data']['link'] }}" target="_blank">{{ $data['Data']['link'] }}</a>
                                                </span>
                                            </div>
                                            @if ($data['Jaro_Win_Distance'] > 70 && $data['Jaro_Win_Distance'] <= 100)
                                                <div class='progress' style='height:20px'>
                                                    <div class='progress-bar bg-danger progress-bar-striped progress-bar-animated' style='width:{{ $data['Jaro_Win_Distance'] }}%;height:20px'><span class="fs-6">{{ $data['Jaro_Win_Distance'] }}%</span></div>
                                                </div>
                                            @elseif ($data['Jaro_Win_Distance'] > 30 && $data['Jaro_Win_Distance'] <=70 )
                                                <div class='progress' style='height:20px'>
                                                    <div class='progress-bar bg-warning progress-bar-striped progress-bar-animated' style='width:{{ $data['Jaro_Win_Distance'] }}%;height:20px'><span class="fs-6">{{ $data['Jaro_Win_Distance'] }}%</span></div>
                                                </div>
                                            @elseif ($data['Jaro_Win_Distance'] >=0 && $data['Jaro_Win_Distance'] <=30)
                                                <div class='progress' style='height:20px'>
                                                    <div class='progress-bar bg-success progress-bar-striped progress-bar-animated' style='width:{{ $data['Jaro_Win_Distance'] }}%;height:20px'><span class="fs-6">{{ $data['Jaro_Win_Distance'] }}%</span></div>
                                                </div>
                                            @endif
                                        <i class="fas fa-stopwatch mt-2"></i> {{ $data['Waktu'] }}
                                        <div>
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-jaro" data-bs-toggle="modal" data-bs-target="#{{ $data['Id'] }}">
                                                Detail
                                            </button>
                                            
                                        <!-- Modal -->
                                        
                                    </div>
                                    @else

                                    @endif
                            
                                @endforeach                               --}}
                            </div>
                        </div>
                    </div>
                </div>
                    <div class="row mt-4 mb-4">
                        {{--  --}}
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection