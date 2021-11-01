@extends('layouts.main')

@section('container')

    <form action="/web" method="post">
        @csrf
        <div class="mb-3">
            <label for="formGroupExampleInput" class="form-label">Example label</label>
            <input name="nama" type="text" class="form-control" id="formGroupExampleInput" placeholder="Example input placeholder">
          </div>
          <div class="mb-3">
            <label for="formGroupExampleInput2" class="form-label">Another label</label>
            <input name="url" type="text" class="form-control" id="formGroupExampleInput2" placeholder="Another input placeholder">
          </div>
          <div class="mb-3">
            <label for="formGroupExampleInput2" class="form-label">Another label</label>
            <input name="url_img" type="text" class="form-control" id="formGroupExampleInput2" placeholder="Another input placeholder">
          </div>
          <input type="submit" >
    </form>
    
@endsection