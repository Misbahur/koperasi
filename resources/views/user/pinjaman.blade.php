@extends('layouts.app')

@section('content')
<div class="px-4 main-content-container container-fluid">
  <!-- Page Header -->
  <div class="py-4 page-header row no-gutters">
    <div class="mb-0 text-center col-12 col-sm-4 text-sm-left">
      <span class="text-uppercase page-subtitle">Overview</span>
      <h3 class="page-title">Pinjaman Saya</h3>
    </div>
  </div>
  <!-- Default Light Table -->

  <div class="row">
    <div class="col">
      <div class="mb-4 card card-small">
        <div class="card-header">
          <a href="#" class="btn btn-sm btn-pill btn-outline-primary" data-toggle="modal" data-target="#myModal">
            <i class="mr-1 material-icons">note_add</i>
            <span> Pinjaman</span>
          </a>
        </div>
        <div class="pb-3 text-center card-body">
          <table class="table mb-0 table-striped table-hover table-bordered">
            <thead class="bg-light">
              <tr>
                <th>No.</th>
                <th>Kode Transaksi</th>
                <th>Nama Nasabah</th>
                <th>Uang dipinjam</th>
                <th>Telah dibayar</th>
                <th>Sisa Pembayaran</th>
                <th>Durasi / Bulan</th>
                <th>Tanggal</th>
                <th>Pengelola</th>
                <th>#</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($loan as $item)
              <tr>
                <td>{{ $loop->iteration }}.</td>
                <td>{{ $item->kode_transaksi }}</td>
                <td>{{ $item->user->name }}</td>
                <td>{{ "Rp " . number_format($item->jumlah,0,',','.') }}</td>
                <td>{{ "Rp " . number_format($item->detail()->sum('bayar_bulanan'),0,',','.') }}</td>
                <td>
                  @if ($item->jumlah == $item->detail()->sum('bayar_bulanan'))
                  {!! '<span class="badge badge-success">Lunas</span>' !!}
                  @else
                  {!! '<span class="badge badge-danger">&ndash; Rp ' . number_format($item->jumlah -
                    $item->detail()->sum('bayar_bulanan'),0,',','.').'</span>' !!}
                  @endif
                </td>
                <td>{{ $item->durasi }}</td>
                <td>{{ $item->tanggal }}</td>
                <td>{{ $item->pengelola }}</td>
                <td>
                  <a href="{{ route('angsuran',$item->id) }}" class="mb-1 text-white btn btn-warning btn-sm">
                    <i class="mr-1 material-icons">credit_card</i>
                    <span>Bayar</span>
                  </a>
                  {{-- <a href="{{ route('simpanan.edit',$item->id) }}" class="btn btn-warning btn-sm">
                    <i class="mr-1 material-icons">edit</i>
                    <span>Edit</span>
                  </a> --}}
                  <form onsubmit="return confirm('Apakah anda yakin ingin menghapus data ini?');"
                    action="{{ route('pinjaman.destroy', $item->id) }}" method="POST">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger" id="confirm_delete">
                      <i class="mr-1 material-icons">delete</i>
                      <span>Hapus</span>
                    </button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <div class="p-1">
            {{ $loan->links() }}
          </div>
        </div>
        @if(session()->get('success'))
        <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          {{ session()->get('success') }}
        </div><br />
        @endif
      </div>
    </div>
  </div>
  <!-- End Default Light Table -->
</div>

{{-- modal --}}
<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <form action="{{ route('pinjaman.save') }}" method="POST" class="modal-content">
      @csrf
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Tambah Simpanan</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <div class="form-group">
          <label for="jumlah">Jumlah</label>
          <input type="number" name="jumlah" id="jumlah" class="form-control">
        </div>
        <div class="form-group">
          <label for="durasi">Durasi</label>
          <select name="durasi" id="durasi" class="form-control">
            <option value="">-- Pilih Durasi --</option>
            <option value="6">6 Bulan</option>
            <option value="12">12 Bulan</option>
            <option value="24">24 Bulan</option>
          </select>
        </div>
        <div class="form-group">
          <label for="tanggal">Tanggal</label>
          <input type="date" name="tanggal" id="tanggal" class="form-control">
        </div>
      </div>
      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button>
        <button type="submit" class="btn btn-success">Simpan</button>
      </div>
    </form>
  </div>
</div>
@endsection