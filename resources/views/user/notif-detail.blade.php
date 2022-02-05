@extends('layouts.app')

@section('content')
<div class="px-4 main-content-container container-fluid">
  <!-- Page Header -->
  <div class="py-4 page-header row no-gutters">
    <div class="mb-0 text-center col-12 col-sm-4 text-sm-left">
      <span class="text-uppercase page-subtitle">Overview</span>
      <h3 class="page-title">Detail Notifikasi</h3>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="mb-4 card card-small">
        <div class="card-header border-bottom">
          <h6 class="m-0">{{ $notif->type }}</h6>
        </div>
        <div class="p-3 pb-3 card-body">
          {{ $notif->user->name }}
          {{ $notif->message }}
        </div>
        <div class="card-footer">
          <a href="{{ route('notif.nasabah') }}" class="btn btn-info">Kembali</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection