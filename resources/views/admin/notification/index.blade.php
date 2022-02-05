@extends('layouts.app')

@section('content')
<div class="px-4 main-content-container container-fluid">
  <!-- Page Header -->
  <div class="py-4 page-header row no-gutters">
    <div class="mb-0 text-center col-12 col-sm-4 text-sm-left">
      <span class="text-uppercase page-subtitle">Overview</span>
      <h3 class="page-title">Notifikasi</h3>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <div class="mb-4 card card-small">
        <div class="card-header border-bottom">
        </div>
        <div class="p-0 pb-3 text-center card-body">
          <table class="table mb-0">
            <thead class="bg-light">
              <tr>
                <th scope="col" class="border-0">Tipe Transaksi</th>
                <th scope="col" class="border-0">Tanggal</th>
                <th scope="col" class="border-0">Pesan</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($notif as $item)
              <tr>
                <td>{{ $item->type }}</td>
                <td>{{ date('d F Y', strtotime($item->created_at)) }}</td>
                <td>
                  {{ $item->user->name }} {!! \Illuminate\Support\Str::words($item->message, 3,'...') !!}
                  <a href="{{ route('detail.notif',$item->slug) }}">Read more</a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      {{ $notif->links() }}
    </div>
  </div>
</div>
@endsection