<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notification;
use App\Simpanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SimpananController extends Controller
{
  public function index()
  {
    $depo = Simpanan::where('user_id', Auth::user()->id)->paginate(5);
    return view('user.simpanan', compact('depo'));
  }

  public function store(Request $request)
  {
    $saldo = Simpanan::whereUserId(auth()->user()->id)->sum('debit') - Simpanan::whereUserId(auth()->user()->id)->sum('kredit');

    $simpanan = new Simpanan;
    $simpanan->fill($request->all());
    $simpanan->user_id = auth()->user()->id;
    $simpanan->saldo = $saldo + $request->jumlah;
    $simpanan->pengelola = Auth::user()->name;
    $simpanan->kode_transaksi = $request->jenis;
    $simpanan->debit = $request->jumlah;
    $simpanan->save();

    if ($request->jenis == 'SP') {
      $jenis = 'simpanan pokok';
    } else if ($request->jenis == 'SW') {
      $jenis = 'simpanan wajib';
    } else if ($request->jenis == 'SS') {
      $jenis = 'simpanan sukarela';
    }
    Notification::create([
      'user_id' => auth()->user()->id,
      'type' => 'simpanan',
      'slug' => Str::random(6) . "==",
      'message' => "telah melakukan transaksi " . $jenis . " sebesar Rp " . number_format($request->jumlah, 0, ',', '.'),
      'read' => 'false',
    ]);

    return redirect(route('simpanan.nasabah'))->with('success', 'Simpanan berhasil ditambah!');
  }

  public function edit(Request $request, $id)
  {
    $depo = Simpanan::find($id);
    return view('user.simpanan-edit', compact('depo'));
  }

  public function update(Request $request, $id)
  {
    $saldo = (Simpanan::whereUserId(auth()->user()->id)->sum('debit') - Simpanan::whereUserId(auth()->user()->id)->sum('kredit')) - Simpanan::where('id', $id)->first()->saldo;

    Simpanan::where('id', $id)->update([
      'jenis' => $request->jenis,
      'debit' => $request->jumlah,
      'saldo' => $saldo + $request->jumlah,
      'tanggal' => $request->tanggal,
    ]);
    // dd($saldo);
    return redirect(route('simpanan.nasabah'))->with('success', 'Simpanan berhasil diubah!');
  }

  public function destroy($id)
  {
    Simpanan::where('id', $id)->delete();
    return redirect(route('simpanan.nasabah'))->with('success', 'Simpanan berhasil dihapus!');
  }
}
