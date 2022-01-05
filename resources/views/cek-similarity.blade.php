@extends('layouts/main')

@section('container')

   <div class="row align-items-md-stretch mb-5">
      <div class="col">
         <div class="h-100 p-5 text-white bg-jaro rounded-3">
            <h2>Cek Similarity Berita Online</h2>
            <p>Cek similarity berita online berguna untuk mengetahui seberapa besar wartawan melakukan plagiarisme ke wartawan lain dengan data 16 portal berita daerah Kalimantan Tengah dan proses perhitungan Similarity berita dilakukan dengan <strong>Algoritma Jaro Winkler</strong>.</p>
         </div>
      </div>
   </div>
   <div class="mb-5">
       <div class="tab-content" id="pills-tabContent">
         <div class="tab-pane fade show active mt-4" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <h4 class="h-100">Masukkan Link Berita :</h4>
            <form class="text-center" action="{{ url('hasil-similarity') }}" method="post">
               @csrf
               <div class="row">
                  @error('link1')
                     <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                        {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                     </div>
                  @enderror
                  <div id="input1" class="col">
                     <div class="input-group mb-3">
                        <span class="input-group-text fab fa-chrome" id="basic-addon1"></span>
                        <input name="link_uji" type="text" class="form-control" placeholder="Link Berita">
                        {{-- <button id="btn-link1" class="btn btn-outline-secondary" type="button" id="button-addon2">+</button>
                        <button id="btn-link3" class="btn btn-outline-secondary" type="button" id="button-addon2"> - </button> --}}
                     </div>
                  </div>
               </div>
               <button id="submit" type="submit" class="btn btn-jaro mt-3">Cek Plagiarisme <i class="fas fa-arrow-circle-right"></i> </button>
            </form>
         </div>
       </div>
   </div>
        


@endsection