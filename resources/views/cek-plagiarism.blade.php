@extends('layouts/main')

@section('container')

   <div class="row align-items-md-stretch mb-5">
      <div class="col-md-6">
         <div class="h-100 p-5 text-white bg-jaro rounded-3">
            <h2>Cek Plagiarisme Wartawan</h2>
            <p>p the jumbotron look. Then, mix and match with additional component themes and more.</p>
            <button class="btn btn-outline-light" type="button">Example button</button>
         </div>
      </div>
      <div class="col-md-6">
         <div class="h-100 p-5 bg-jaro rounded-3">
            <h2 class="text-white">Data Website</h2>
            <div class="row mb-3">
               <div class="col-sm-4 p-1">
                  <a href="http://www.borneonews.co.id/" target="_blank">
                     <img src="https://www.borneonews.co.id/assets/images/logo.png" alt="Borneonews" class="img-fluid">
                  </a>
               </div>
               <div class="col-sm-4 p-1">
                  <a href="http://www.radarsampit.com/" target="_blank">
                     <img src="https://www.radarsampit.com/wp-content/uploads/2021/03/RADAR-SAMPIT-DOT-COM-gradasi.png" alt="Radar-Sampit" class="img-fluid">
                  </a>
               </div>
               <div class="col-sm-4 p-1">
                  <a href="http://prokal.co/" target="_blank">
                     <img src="https://prokal.co/assets/img/logoheadprokal.jpg" alt="Prokal" class="img-fluid">
                  </a>
               </div>
               <div class="col-sm-4 p-1">
                  <a href="http://www.matakalteng.com/" target="_blank">
                     <img src="https://www.matakalteng.com/wp-content/uploads/2020/10/logo-HEADER.png" alt="Matakalteng" class="img-fluid">
                  </a>
               </div>
               <div class="col-sm-4 p-1">
                  <a href="http://beritasampit.co.id/" target="_blank">
                     <img src="https://prokalteng.co/portal/img/130047-prokalteng-jpc_2b.png" alt="Beitasampit" class="img-fluid">
                  </a>
               </div>
               <div class="col-sm-4 p-1">
                  <a href="http://beritasampit.co.id/" target="_blank">
                     <img src="https://kaltengonline.com/wp-content/uploads/2021/06/pp.png" alt="Beitasampit" class="img-fluid">
                  </a>
               </div>
               <div class="col-sm-4 p-1">
                  <a href="http://beritasampit.co.id/" target="_blank">
                     <img src="https://kalteng.co/wp-content/uploads/2021/03/LOGO-KALTENG.CO-02-02.png" alt="Beitasampit" class="img-fluid">
                  </a>
               </div>
               <div class="col-sm-4 p-1">
                  <a href="http://beritasampit.co.id/" target="_blank">
                     <img src="https://kaltengoke.com/wp-content/uploads/2021/04/logo-KaltengOke3.png" alt="Beitasampit" class="img-fluid">
                  </a>
               </div>
               <div class="col-sm-4 p-1">
                  <a href="http://beritasampit.co.id/" target="_blank">
                     <img src="https://sp-ao.shortpixel.ai/client/to_webp,q_glossy,ret_img/https://dayaknews.com/wp-content/uploads/2019/01/dayaknews2.png" alt="Beitasampit" class="img-fluid">
                  </a>
               </div>
               <div class="col-sm-4 p-1">
                  <a href="http://beritasampit.co.id/" target="_blank">
                     <img src="https://cdn.klikkalteng.id/kkid/images/icons/logo-besar.png?v=0.1.1" alt="Beitasampit" class="img-fluid">
                  </a>
               </div>
               <div class="col-sm-4 p-1">
                  <a href="http://beritasampit.co.id/" target="_blank">
                     <img src="https://kaltengekspres.com/wp-content/uploads/2020/12/LOGO-KALTENG-EKSPRES.png" alt="Beitasampit" class="img-fluid">
                  </a>
               </div>
               <div class="col-sm-4 p-1">
                  <a href="http://beritasampit.co.id/" target="_blank">
                     <img src="https://kalteng.antaranews.com/img/kalteng.antaranews.com-2.png" alt="Beitasampit" class="img-fluid">
                  </a>
               </div>
               <div class="col-sm-4 p-1">
                  <a href="http://beritasampit.co.id/" target="_blank">
                     <img src="https://www.tabengan.com/wp-content/uploads/2021/08/logotabengan.png" alt="Beitasampit" class="img-fluid">
                  </a>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="mb-5">
      <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist">
         <li class="nav-item p-1" role="presentation">
           <button class="btn btn-jaro active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Ambil Data Dengan Url</button>
         </li>
         <li class="nav-item p-1" role="presentation">
           <button class="btn btn-jaro" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Ambil Data Dengan Text</button>
         </li>
         <li class="nav-item p-1" role="presentation">
           <button class="btn btn-jaro" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Ambil Data Dengan Docx</button>
         </li>
       </ul>
       <div class="tab-content" id="pills-tabContent">
         <div class="tab-pane fade show active mt-4" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
            <div class="row justify-content-center">
               <div class="col-6">
                  <div class="accordion mb-4" id="accordionExample">
                     <div class="accordion-item">
                       <h2 class="accordion-header" id="headingOne">
                         <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                           Petunjunk
                         </button>
                       </h2>
                       <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                         <div class="accordion-body">
                           <p class="mb-0 text-danger">* Inputkan Link berita 1 link berita dari Klikkalteng.id </p>
                           <p class="mb-0 text-danger">* Inputkan Link berita 2 link berita dari Kompetitor atau  </p>
                           <p class="mb-0 text-danger">* Button + untuk menambahkan link berita jika berita menggunakan slug halaman selanjutnya </p>
                           <p class="mb-0 text-danger">* Button - untuk menghapus form input yang telah di tambah sebelumnya </p>  
                         </div>
                       </div>
                     </div>
                  </div>
               </div>
            </div>
            <form class="text-center" action="{{ url('cek-from-url') }}" method="post">
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
                        <input name="link1" type="text" class="form-control" placeholder="Link Berita 1">
                        <button id="btn-link1" class="btn btn-outline-secondary" type="button" id="button-addon2">+</button>
                        <button id="btn-link3" class="btn btn-outline-secondary" type="button" id="button-addon2"> - </button>
                     </div>
                  </div>
               </div>
               <button id="submit" type="submit" class="btn btn-jaro mt-3">Ambil Data <i class="fas fa-arrow-circle-right"></i> </button>
            </form>
         </div>
         <div class="tab-pane fade mt-4" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
            <div class="row justify-content-center">
               <div class="col-6">
                  <div class="accordion mb-4" id="accordionExample">
                     <div class="accordion-item">
                       <h2 class="accordion-header" id="headingOne">
                         <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                           Petunjunk 
                         </button>
                       </h2>
                       <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                         <div class="accordion-body">
                           <p class="mb-0 text-danger">* Inputkan Text 1 berita dari Klikkalteng.id atau sebaliknya</p>
                           <p class="mb-0 text-danger">* Inputkan Text 2 berita dari Kompetitor</p>
                         </div>
                       </div>
                     </div>
                  </div>
               </div>
            </div>
            <form class="text-center" action="{{ url('result-plagiarism') }}" method="post">
               @csrf
               <div class="row">
                  @error('string1')
                     <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                        {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                     </div>
                  @enderror
                  @error('string2')
                     <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                        {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                     </div>
                  @enderror
                  <div class="col">
                     <div class="input-group">
                        <span class="input-group-text">Text 1 </span>
                        <textarea onkeydown="countWords1();" onmousemove="countWords1();" onkeyup="countWords1();" id="textBox1" class="form-control" name="string1" style="height:200px" aria-label="With textarea"></textarea>
                     </div>
                     <div class="text-center fs-6 badge fw-light rounded-pill bg-jaro m-3">
                        <span id="word-count1" class="me-2 fs-6">
                           0
                        </span>
                        <i class="fas fa-file-word"></i>
                     </div>
                  </div>
                  <div class="col">
                     <div class="input-group">
                        <span class="input-group-text">Text 2</span>
                        <textarea onkeydown="countWords2();" onmousemove="countWords2();" onkeyup="countWords2();" id="textBox2" class="form-control" name="string2" style="height:200px" aria-label="With textarea"></textarea>
                      </div>
                      <div class="text-center fs-6 fw-light badge rounded-pill bg-jaro m-3">
                        <span id="word-count2" class="me-2 fs-6">
                           0
                        </span>
                        <i class="fas fa-file-word"></i>
                     </div>
                  </div>
               </div>
               <button id="submit" type="submit" class="btn btn-jaro mt-3">Cek Plagiarisme <i class="fas fa-arrow-circle-right"></i></button>
            </form>
         </div>
         <div class="tab-pane fade mt-4" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
            <div class="row justify-content-center">
               <div class="col-6">
                  <div class="accordion mb-4" id="accordionExample">
                     <div class="accordion-item">
                       <h2 class="accordion-header" id="headingOne">
                         <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                           Petunjunk
                         </button>
                       </h2>
                       <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                         <div class="accordion-body">
                           <p class="mb-0 text-danger">* Format file yang bisa di akses doc dan docx</p>
                         </div>
                       </div>
                     </div>
                  </div>
               </div>
            </div>
            <form class="text-center" action="{{ url('result-plagiarism') }}" method="post">
               @csrf
               <div class="row">
                  @error('file1')
                     <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                        {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                     </div>
                  @enderror
                  @error('file2')
                     <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <svg class="bi flex-shrink-0 me-2" width="24" height="24" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                        {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                     </div>
                  @enderror
                  <div class="col">
                     <div class="mb-3">
                        <label for="formFileSm" class="form-label">File Docx Berita 1</label>
                        <input name="file1" accept=".doc,.docx" onchange='openFile1(event)' class="form-control form-control-sm" id="formFileSm" type="file" required>
                        <br>
                        <div id="isi1" style="display: none;">
                           <div class="form-floating">
                              <textarea onkeydown="countWords5();" onmousemove="countWords5();" onkeyup="countWords5();" name="string1" id="output1" class="form-control" placeholder="Leave a comment here" style="height: 200px"></textarea>
                              <label for="output1">Text Berita 1</label>
                           </div>
                           <div class="text-center fs-6 fw-light badge rounded-pill bg-jaro m-3">
                              <span id="word-count5" class="m-3 fs-6 text-center">
                                 0
                              </span>
                              <i class="fas fa-file-word"></i>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col">
                     <div class="mb-3">
                        <label for="formFileSm" class="form-label">File Docx Berita 2</label>
                        <input name="file2" accept=".doc,.docx" onchange='openFile2(event)' class="form-control form-control-sm" id="formFileSm" type="file" required>
                        <br>
                        <div id="isi2" style="display: none;">
                           <div class="form-floating">
                              <textarea onkeydown="countWords6();" onmousemove="countWords6();" onkeyup="countWords6();" name="string2" id="output2" class="form-control" placeholder="Leave a comment here" style="height: 200px"></textarea>
                              <label for="output2">Text Berita 2</label>
                           </div>
                           <div class="text-center fs-6 fw-light badge rounded-pill bg-jaro m-3">
                              <span id="word-count6" class="m-3 fs-6 text-center">
                                 0
                              </span>
                              <i class="fas fa-file-word"></i>
                           </div>
                        </div>
                      </div>
                  </div>
               </div>
               <button id="submit" type="submit" class="btn btn-jaro mt-3">Cek Plagiarisme <i class="fas fa-arrow-circle-right"></i></button>
            </form>
         </div>
       </div>
   </div>
        


@endsection