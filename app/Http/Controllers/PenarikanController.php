<?php

namespace App\Http\Controllers;

use App\Notification;
use Illuminate\Http\Request;
use App\User;
use App\Simpanan;
use Auth;
use Illuminate\Support\Str;

class PenarikanController extends Controller
{
    public function index()
    {
        return view('penarikan.index');
    }

    public function store(Request $request)
    {
        $saldo = Simpanan::whereUserId($request->user_id)->sum('debit') - Simpanan::whereUserId($request->user_id)->sum('kredit');

        if ($saldo < $request->kredit) {
            return \Response::json(array(
                'message'   =>  'Maaf, Tidak bisa melakukan penarikan. Saldo anda kurang ' . ($request->kredit - $saldo)
            ), 404);
        }

        $simpanan = new Simpanan;
        $simpanan->fill($request->all());
        $simpanan->saldo = $saldo - $request->kredit;
        $simpanan->pengelola = Auth::user()->name;
        $simpanan->save();

        Notification::create([
            'user_id' => $request->user_id,
            'type' => 'penarikan',
            'slug' => Str::random(6) . "==",
            'message' => "telah melakukan transaksi penarikan, sebesar Rp " . number_format($request->kredit, 0, ',', '.'),
            'read' => 'false',
        ]);

        return $simpanan;
    }

    public function update(Request $request, $id)
    {
        $saldo = Simpanan::whereUserId($request->user_id)->sum('debit') - Simpanan::whereUserId($request->user_id)->sum('kredit');

        $simpanan = Simpanan::find($id);
        $simpanan->fill($request->except('kode_transaksi'));
        $simpanan->saldo = $saldo - $request->kredit;
        $simpanan->save();

        return $simpanan;
    }

    public function report(Request $request)
    {
        $data['report'] = Simpanan::whereBetween('tanggal', [$request->tgl_awal, $request->tgl_akhir])->where('user_id', 'like', '%' . $request->user_id)->get();
        $data['periode'] = $request->tgl_awal . ' - ' . $request->tgl_akhir;

        return view('penarikan.report', $data);
    }

    public function struk($id)
    {
        $data['struk'] = Simpanan::find($id);

        return view('penarikan.struk', $data);
    }
}
