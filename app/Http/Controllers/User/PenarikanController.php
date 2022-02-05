<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Notification;
use App\Simpanan;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class PenarikanController extends Controller
{
  public function index()
  {
    $narik = Simpanan::where('jenis', 'PNK')->where('user_id', Auth::user()->id)->paginate(5);
    return view('user.penarikan', compact('narik'));
  }

  public function store(Request $request)
  {
    $saldo = Simpanan::whereUserId(auth()->user()->id)->sum('debit') - Simpanan::whereUserId(auth()->user()->id)->sum('kredit');
    if ($saldo < $request->kredit) {
      // return Response::json(array(
      //   'message'   =>  'Maaf, Tidak bisa melakukan penarikan. Saldo anda kurang ' . ($request->kredit - $saldo)
      // ), 404);
      return redirect(route('penarikan.nasabah'))->with('error', 'Maaf, Tidak bisa melakukan penarikan. Saldo anda kurang Rp ' . number_format(($request->kredit - $saldo), 0, ',', '.'));
    }

    $simpanan = new Simpanan;
    $simpanan->fill($request->all());
    $simpanan->user_id = auth()->user()->id;
    $simpanan->tanggal = $request->tanggal;
    $simpanan->jenis = 'PNK';
    $simpanan->kode_transaksi = 'PNK';
    $simpanan->kredit = $request->kredit;
    $simpanan->saldo = $saldo - $request->kredit;
    $simpanan->pengelola = auth()->user()->name;
    $simpanan->save();

    Notification::create([
      'user_id' => auth()->user()->id,
      'type' => 'penarikan',
      'slug' => Str::random(6) . "==",
      'message' => "telah melakukan transaksi penarikan, sebesar Rp " . number_format($request->kredit, 0, ',', '.'),
      'read' => 'false',
    ]);
    return redirect(route('penarikan.nasabah'))->with('success', 'Penarikan berhasil ditambah!');
  }

  public function edit($id)
  {
    $narik = Simpanan::find($id);
    return view('user.penarikan-edit', compact('narik'));
  }

  public function update(Request $request, $id)
  {
    // $saldo_awal = Simpanan::whereUserId(auth()->user()->id)->sum('debit') - Simpanan::whereUserId(auth()->user()->id)->sum('kredit');
    $saldo_awal = Simpanan::where('user_id', auth()->user()->id)->where('id', $id)->sum('debit') + Simpanan::where('user_id', auth()->user()->id)->where('id', $id)->sum('kredit');
    $saldo_akhir = $saldo_awal - $request->kredit;
    Simpanan::where('id', $id)->update([
      'kredit' => $request->kredit,
      'tanggal' => $request->tanggal,
      'saldo' => $saldo_akhir
    ]);
    return redirect(route('penarikan.nasabah'))->with('success', 'Penarikan berhasil diubah!');
  }

  public function destroy($id)
  {
    Simpanan::where('id', $id)->delete();
    return redirect(route('penarikan.nasabah'))->with('success', 'Penarikan berhasil dihapus!');
  }
}
