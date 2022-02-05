<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notification;
use App\Pinjaman;
use App\PinjamanDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PinjamanController extends Controller
{
  public function index()
  {
    // $paid = PinjamanDetail::where()
    $loan = Pinjaman::where('user_id', Auth::user()->id)->paginate(5);
    // foreach ($loan as $key => $value) {
    //   $value->
    // }
    return view('user.pinjaman', compact('loan'));
  }

  public function store(Request $request)
  {
    $pinjaman = new Pinjaman;
    $pinjaman->fill($request->all());
    $pinjaman->user_id = Auth::user()->id;
    $pinjaman->kode_transaksi = 'PJM';
    $pinjaman->jumlah = $request->jumlah;
    $pinjaman->durasi = $request->durasi;
    $pinjaman->tanggal = $request->tanggal;
    $pinjaman->pengelola = Auth::user()->name;
    $pinjaman->save();

    Notification::create([
      'user_id' => Auth::user()->id,
      'type' => 'pinjaman',
      'slug' => Str::random(6) . "==",
      'message' => "telah melakukan transaksi pinjaman berdurasi selama " . $request->durasi . " bulan, sebesar Rp " . number_format($request->jumlah, 0, ',', '.'),
      'read' => 'false',
    ]);
    return redirect(route('pinjaman.nasabah'))->with('success', 'Pinjaman berhasil ditambah!');
  }

  public function installment($id)
  {
    // $pinjaman = Pinjaman::with('user')->where('id', $id)->paginate(10);
    // foreach ($pinjaman as $value) {
    //   $value->sudah_bayar = $value->detail()->sum('bayar_bulanan');
    //   $value->sisa_bayar = $value->jumlah - $value->detail()->sum('bayar_bulanan');
    // }
    $data['pinjaman'] = Pinjaman::find($id);
    return view('user.angsuran', $data);
  }

  public function edit(Request $request, $id)
  {
    // 
  }

  public function update($id)
  {
    // 
  }

  public function destroy($id)
  {
    PinjamanDetail::where('pinjaman_id', $id)->delete();
    Pinjaman::where('id', $id)->delete();
    return redirect(route('pinjaman.nasabah'))->with('success', 'Pinjaman berhasil dihapus!');
  }
}
