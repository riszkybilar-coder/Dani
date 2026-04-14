<?php


namespace App\Http\Controllers;


use App\Models\Saran;

use App\Models\Siswa;

use Illuminate\Http\Request;


class SaranController extends Controller

{

    public function create()

    {

        $siswa = Siswa::all();

        return view('siswa.saran', compact('siswa'));

    }


    public function store(Request $request)

    {

        $request->validate([

            'nis'       => 'required|exists:siswas,nis',

            'judul'     => 'required|max:100',

            'isi_saran' => 'required|max:1000',

        ]);


        Saran::create([

            'nis'       => $request->nis,

            'judul'     => $request->judul,

            'isi_saran' => $request->isi_saran,

        ]);


        return back()->with('success', 'Saran berhasil dikirim, terima kasih!');

    }

}

