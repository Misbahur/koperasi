<?php

namespace App\Http\Controllers;

use App\Notification;
use Illuminate\Http\Request;
use App\Pinjaman;
use App\PinjamanDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PinjamanController extends Controller
{
    public function index(Request $request)
    {
        return view('pinjaman.index');
    }

    public function store(Request $request)
    {
        $pinjaman = new Pinjaman;
        $pinjaman->fill($request->all());
        $pinjaman->pengelola = Auth::user()->name;
        $pinjaman->save();

        Notification::create([
            'user_id' => $request->user_id,
            'type' => 'pinjaman',
            'slug' => Str::random(6) . "==",
            'message' => "telah melakukan transaksi pinjaman berdurasi selama " . $request->durasi . " bulan, sebesar Rp " . number_format($request->jumlah, 0, ',', '.'),
            'read' => 'false',
        ]);
        return $pinjaman;
    }

    public function update(Request $request, $id)
    {
        $pinjaman = Pinjaman::find($id);
        $pinjaman->fill($request->except('kode_transaksi'));
        $pinjaman->save();

        return $pinjaman;
    }

    public function edit($id)
    {
        $data['pinjaman'] = Pinjaman::find($id);

        return view('pinjaman.edit', $data);
    }

    public function destroy($id)
    {
        PinjamanDetail::destroy($id);
        return back();
    }

    public function report(Request $request)
    {
        $pinjaman = Pinjaman::with(['user'])->orderBy('id', 'desc')->where('user_id', 'like', '%' . $request->user_id)->get();
        foreach ($pinjaman as $value) {
            $value->sudah_bayar = $value->detail()->sum('bayar_bulanan');
            $value->sisa_bayar = $value->jumlah - $value->detail()->sum('bayar_bulanan');
        }

        $data['report'] = $pinjaman;
        $data['periode'] = $request->tgl_awal . ' - ' . $request->tgl_akhir;

        return view('pinjaman.report', $data);
    }

    public function struk($id)
    {
        $data['struk'] = Pinjaman::find($id);

        return view('pinjaman.struk', $data);
    }
}
