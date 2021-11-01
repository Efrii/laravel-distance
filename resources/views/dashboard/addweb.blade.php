@extends('layouts.main')

@section('container')

    <section>
        <div class="shadow p-3 mb-5 rounded text-center">
            <p class="position-relative">
                Stopword adalah kata umum yang biasanya muncul dalam jumlah besar dan dianggap tidak memiliki makna. Contoh stopword dalam bahasa Indonesia adalah “yang”, “dan”, “di”, “dari”, dll. Makna di balik penggunaan stopword yaitu dengan menghapus kata-kata yang memiliki informasi rendah dari sebuah teks, kita dapat fokus pada kata-kata penting sebagai gantinya.
                <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-danger">
                    Materi
                    <span class="visually-hidden">unread messages</span>
                </span>
            </p>
        </div>
    
        <div class="shadow p-3 mb-5 rounded">
            {{-- ADD TAG HTML UNTUK DI REMOVE --}}
            <button type="button" class="btn btn-jaro mb-3" data-bs-toggle="modal" data-bs-target="#addtaghtml">
                Tambah Website
            </button>
    
            <div class="modal fade" id="addtaghtml" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Tambah Tag Html</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ url('dashboard/addweb') }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="formGroupExampleInput" class="form-label">Tag Html :</label>
                                    <input autofocus name="taghtml" type="text" class="form-control" id="formGroupExampleInput" placeholder="Example input placeholder">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-jaro" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-jaro">Ubah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    
            {{-- <table class="table table-striped table-hover" id="taghtml">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Taghtml</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $taghtml )
                        <tr>
                            <td>{{ $taghtml->id }}</td>
                            <td>{{ $taghtml->taghtml }}</td>
                            <td>{{ $taghtml->created_at }}</td>
                            <td>{{ $taghtml->updated_at }}</td>
                            <td>
                                <a class="btn btn-jaro" data-bs-toggle="modal" data-bs-target="#edittaghtml{{ $taghtml->id }}"><i class="fas fa-edit"></i></a>
                                    <div class="modal fade" id="edittaghtml{{ $taghtml->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="staticBackdropLabel">Ubah Tag Html</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ url('dashboard/addweb', $taghtml->id) }}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <input type="hidden" name="id"  value="{{ $taghtml->id }}">
                                                            <label for="formGroupExampleInput" class="form-label">Tag Html :</label>
                                                            <input autofocus name="taghtml" value="{{ $taghtml->taghtml }}" type="text" class="form-control" id="formGroupExampleInput" placeholder="Example input placeholder">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-jaro" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-jaro">Ubah</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <a class="btn btn-jaro" data-bs-toggle="modal" data-bs-target="#hapustaghtml{{ $taghtml->id }}"><i class="fas fa-trash-alt"></i></a>
                                <div class="modal fade" id="hapustaghtml{{ $taghtml->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Hapus Tag Html</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <button type="button" class="btn btn-jaro" data-bs-dismiss="modal">Batal</button>
                                                <a class="btn btn-jaro" href="{{ url('/dashboard/addweb', $taghtml->id ) }}">Hapus</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table> --}}
        </div>
    </section>
    <section>
        <div class="shadow p-3 mb-5 rounded text-center">
            <p class="position-relative">
                Stopword adalah kata umum yang biasanya muncul dalam jumlah besar dan dianggap tidak memiliki makna. Contoh stopword dalam bahasa Indonesia adalah “yang”, “dan”, “di”, “dari”, dll. Makna di balik penggunaan stopword yaitu dengan menghapus kata-kata yang memiliki informasi rendah dari sebuah teks, kita dapat fokus pada kata-kata penting sebagai gantinya.
                <span class="position-absolute top-0 start-0 translate-middle badge rounded-pill bg-danger">
                    Materi
                    <span class="visually-hidden">unread messages</span>
                </span>
            </p>
        </div>
    
        <div class="shadow p-3 mb-5 rounded">
            {{-- ADD TAG HTML UNTUK DI REMOVE --}}
            <button type="button" class="btn btn-jaro mb-3" data-bs-toggle="modal" data-bs-target="#addtaghtml">
                Tambah Taghtml
            </button>
    
            <div class="modal fade" id="addtaghtml" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Tambah Tag Html</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="{{ url('dashboard/addweb') }}" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="formGroupExampleInput" class="form-label">Tag Html :</label>
                                    <input autofocus name="taghtml" type="text" class="form-control" id="formGroupExampleInput" placeholder="Example input placeholder">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-jaro" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-jaro">Ubah</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    
            <table class="table table-striped table-hover" id="taghtml">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Taghtml</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $taghtml )
                        <tr>
                            <td>{{ $taghtml->id }}</td>
                            <td>{{ $taghtml->taghtml }}</td>
                            <td>{{ $taghtml->created_at }}</td>
                            <td>{{ $taghtml->updated_at }}</td>
                            <td>
                                <a class="btn btn-jaro" data-bs-toggle="modal" data-bs-target="#edittaghtml{{ $taghtml->id }}"><i class="fas fa-edit"></i></a>
                                    <div class="modal fade" id="edittaghtml{{ $taghtml->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="staticBackdropLabel">Ubah Tag Html</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form action="{{ url('dashboard/addweb', $taghtml->id) }}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <input type="hidden" name="id"  value="{{ $taghtml->id }}">
                                                            <label for="formGroupExampleInput" class="form-label">Tag Html :</label>
                                                            <input autofocus name="taghtml" value="{{ $taghtml->taghtml }}" type="text" class="form-control" id="formGroupExampleInput" placeholder="Example input placeholder">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-jaro" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-jaro">Ubah</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <a class="btn btn-jaro" data-bs-toggle="modal" data-bs-target="#hapustaghtml{{ $taghtml->id }}"><i class="fas fa-trash-alt"></i></a>
                                <div class="modal fade" id="hapustaghtml{{ $taghtml->id }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="staticBackdropLabel">Hapus Tag Html</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body text-center">
                                                <button type="button" class="btn btn-jaro" data-bs-dismiss="modal">Batal</button>
                                                <a class="btn btn-jaro" href="{{ url('/dashboard/addweb', $taghtml->id ) }}">Hapus</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

@endsection