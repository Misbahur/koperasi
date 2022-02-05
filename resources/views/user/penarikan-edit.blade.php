@extends('layouts.app')

@section('content')
<div class="px-4 main-content-container container-fluid">
  <!-- Page Header -->
  <div class="py-4 page-header row no-gutters">
    <div class="mb-0 text-center col-12 col-sm-4 text-sm-left">
      <span class="text-uppercase page-subtitle">Overview</span>
      <h3 class="page-title">Penarikan Saya</h3>
    </div>
  </div>
  <!-- Default Light Table -->

  <div class="row">
    <div class="col">
      <div class="mb-4 card card-small">
        <div class="card-header">
          <a href="{{ route('penarikan.nasabah') }}" class="btn btn-sm btn-pill btn-outline-primary">
            <i class="mr-1 material-icons">chevron_left</i>
            <span> Kembali</span>
          </a>
        </div>
        <form action="{{ route('penarikan.update', $narik->id) }}" method="POST">
          @method('PATCH')
          @csrf
          <div class="pb-3 card-body">
            <div class="form-group">
              <label for="jumlah">Jumlah</label>
              <input type="number" name="kredit" id="jumlah" class="form-control" value="{{ $narik->kredit }}">
            </div>
            <div class="form-group">
              <label for="tanggal">Tanggal</label>
              <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $narik->tanggal }}">
            </div>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-success">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
@endsection