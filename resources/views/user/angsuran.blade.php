@extends('layouts.app')

@section('content')
<div class="px-4 main-content-container container-fluid">
  <!-- Page Header -->
  <div class="py-4 page-header row no-gutters">
    <div class="mb-0 text-center col-12 col-sm-4 text-sm-left">
      <span class="text-uppercase page-subtitle"></span>
      <h3 class="page-title">Pembayaran</h3>
    </div>
  </div>
  <!-- End Page Header -->
  <div class="row">
    <div class="col-lg-9 col-md-12">
      <!-- Add New Post Form -->
      <div class="mb-3 card card-small">
        <div class="card-header">
          <a href="{{ route('pinjaman.nasabah') }}" class="btn btn-sm btn-pill btn-outline-primary">
            <i class="mr-1 material-icons">chevron_left</i>
            <span> Kembali</span>
          </a>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Jumlah</th>
                  <th>Tanggal</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($pinjaman->detail()->get() as $key => $item)
                <tr>
                  <td>{{ $key+1 }}</td>
                  <td>{{ number_format($item->bayar_bulanan,0,',','.') }}</td>
                  <td>{{ $item->tanggal }}</td>
                  <td>
                    <a href="#" onclick="getElementById('hapus{{ $item->id }}').submit()">
                      <i class="material-icons" title="delete">delete</i>
                    </a>
                    <form action="{{ route('pinjaman.destroy',$item->id) }}" method="post" id="hapus{{ $item->id }}">
                      @method('delete')
                      @csrf
                    </form>
                  </td>
                </tr>
                @endforeach

              </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- / Add New Post Form -->
    </div>
    <div class="col-lg-3 col-md-12">
      <!-- Post Overview -->
      <div class='mb-3 card card-small'>
        <div class="card-header border-bottom">
          <h6 class="m-0">Info</h6>
        </div>
        <form action="{{ route('bayar.update', ['id'=>$pinjaman->id]) }}" method="post">
          @method('patch')
          @csrf
          <div class='p-0 card-body'>
            <ul class="list-group list-group-flush">
              <li class="p-3 list-group-item">
                <span class="mb-2 d-flex">
                  <i class="mr-1 material-icons">person</i>
                  <strong class="mr-1">Nasabah:</strong> {{ $pinjaman->user->name }}
                </span>
                <span class="mb-2 d-flex">
                  <i class="mr-1 material-icons">local_atm</i>
                  <strong class="mr-1">Jumlah Pinjaman:</strong>
                  <strong class="text-success">{{ "Rp " . number_format($pinjaman->jumlah,0,',','.') }}</strong>
                </span>
                <span class="mb-2 d-flex">
                  <i class="mr-1 material-icons">calendar_today</i>
                  <strong class="mr-1">Durasi:</strong> {{ $pinjaman->durasi }}
                </span>
                <span class="d-flex">
                  <i class="mr-1 material-icons">score</i>
                  <strong class="mr-1">Cicilan/bulan:</strong>
                  <strong class="text-warning">{{ "Rp " . number_format($pinjaman->jumlah / $pinjaman->durasi,0,',','.')
                    }}</strong>
                  <input type="hidden" name="bayar_bulanan" value="{{ $pinjaman->jumlah / $pinjaman->durasi }}">
                </span>
              </li>
              <li class="px-3 list-group-item d-flex">
                <div>
                  <input type="date" name="tanggal" class="form-control" required>
                </div>
                <button type="submit" class="ml-auto btn btn-sm btn-accent" {{ $pinjaman->durasi <= $pinjaman->
                    detail()->count() ? 'disabled' : ''}}>
                    {!! $pinjaman->durasi <= $pinjaman->detail()->count() ? '<i class="material-icons">local_atm</i>
                      Lunas' : '<i class="material-icons">local_atm</i> Bayar' !!}
                </button>
              </li>
            </ul>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection