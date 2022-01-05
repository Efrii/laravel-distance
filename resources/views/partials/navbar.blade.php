  <nav class="navbar navbar-expand-lg navbar-dark bg-jaro">
    <div class="container">
      <a class="navbar-brand" href="/">
        Similarity Berita Online
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navbarScroll">
        <ul class="navbar-nav px-3 my-2 my-lg-0 navbar-nav-scroll">
          <li class="nav-item">
            <a class="nav-link {{ ($title === "Cek Similarity") ? 'active' : '' }} {{ ($title === "Hasil Similarity Berita") ? 'active' : '' }}" aria-current="page" href="/">{{ ($title === "Cek Similarity") ? 'Cek Similarity' : 'Hasil Similarity Berita'  }}</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>