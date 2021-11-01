  <nav class="navbar navbar-expand-lg navbar-dark bg-jaro">
    <div class="container">
      <a class="navbar-brand" href="#">
        <img src="{{ url('img/logo.png') }}" alt="" width="30" height="24">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarScroll">
        <ul class="navbar-nav px-3 my-2 my-lg-0 navbar-nav-scroll">
          <li class="nav-item">
            <a class="nav-link {{ ($title === "Home") ? 'active' : '' }}" aria-current="page" href="/">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ ($title === "Cek Plagiarism") ? 'active' : '' }} {{ ($title === "Cek From Url") ? 'active' : '' }} {{ ($title === "Hasil Plagiarism") ? 'active' : '' }}" aria-current="page" href="/cek-plagiarism">Cek Plagiarism</a>
          </li>
          {{-- <li class="nav-item">
            <a class="nav-link {{ ($title === "Data") ? 'active' : '' }}" aria-current="page" href="/web">Data Web</a>
          </li> --}}
          <li class="nav-item">
            <a class="nav-link {{ ($title === "About") ? 'active' : '' }}" href="/about">About</a>
          </li>
        </ul>
        @auth
          <ul class="navbar-nav">
            <li class="nav-item">
              <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                  <img src="https://avatars.githubusercontent.com/u/62926625?v=4" alt="" width="32" height="32" class="rounded-circle me-2">
                  <strong class="fw-light">Teguh Efriyanto</strong>
                </a>
                <ul class="dropdown-menu dropdown-menu-light text-small shadow" aria-labelledby="dropdownUser1">
                  <li><a class="dropdown-item" href="{{ url('dashboard/addweb') }}">Tambah Data Website</a></li>
                  <li><a class="dropdown-item" href="{{ url('dashboard/stopword') }}">Tambah Stopword</a></li>
                  <li><a class="dropdown-item" href="#">Profile</a></li>
                  <li><hr class="dropdown-divider"></li>
                  <li>
                    <form action="/logout" method="post">
                      @csrf

                      <button class="dropdown-item" type="submit">Logout</button>
                    </form>
                  </li>
                </ul>
              </div>
            </li>
          </ul>
        @else
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="btn btn-merah" href="{{ url('/admin') }}">Login</a>
            </li>
          </ul>
        @endauth
      </div>
    </div>
  </nav>