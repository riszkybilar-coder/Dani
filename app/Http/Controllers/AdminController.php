<?php


namespace App\Http\Controllers;


use App\Models\Admin;

use App\Models\Aspirasi;

use App\Models\Feedback;

use App\Models\Kategori;

use App\Models\Notifikasi;

use App\Models\Siswa;

use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

use App\Models\Saran;


class AdminController extends Controller

{

    public function login()

    {

        return view('admin.login');

    }


    public function cekLogin(Request $request)

    {

        $admin = Admin::where('username', $request->username)->first();


        if ($admin && Hash::check($request->password, $admin->password)) {

            session(['admin' => $admin->id]);

            return redirect('/admin/dashboard');

        }


        return back()->with('error', 'Login gagal');

    }


    public function dashboard()

    {

        $data = Aspirasi::with('kategori', 'siswa', 'feedback')->get();


        // Data untuk grafik per kategori

        $grafikKategori = Aspirasi::with('kategori')

            ->get()

            ->groupBy('id_kategori')

            ->map(fn($group) => [

                'label' => $group->first()->kategori->ket_kategori,

                'total' => $group->count(),

            ])->values();


        // Data untuk grafik per status

        $grafikStatus = [

            'Menunggu' => Aspirasi::where('status', 'Menunggu')->count(),

            'Proses'   => Aspirasi::where('status', 'Proses')->count(),

            'Selesai'  => Aspirasi::where('status', 'Selesai')->count(),

        ];


        // Ringkasan angka

        $totalPengaduan  = Aspirasi::count();

        $totalSelesai    = Aspirasi::where('status', 'Selesai')->count();

        $totalProses     = Aspirasi::where('status', 'Proses')->count();

        $totalMenunggu   = Aspirasi::where('status', 'Menunggu')->count();


        return view('admin.dashboard', compact(

            'data', 'grafikKategori', 'grafikStatus',

            'totalPengaduan', 'totalSelesai', 'totalProses', 'totalMenunggu'

        ));

    }


    public function kategori()

    {

        $kategori = Kategori::all();

        return view('admin.kategori', compact('kategori'));

    }


    public function siswa()

    {

        $siswa = Siswa::all();

        return view('admin.siswa', compact('siswa'));

    }


    public function saran()

    {

        $sarans = Saran::with('siswa')->latest()->get();

        return view('admin.saran', compact('sarans'));

    }



    public function updateStatus(Request $request, $id)

    {

        $request->validate([

            'status' => 'required|in:Menunggu,Proses,Selesai'

        ]);


        $aspirasi = Aspirasi::where('id_aspirasi', $id)->firstOrFail();

        $statusLama = $aspirasi->status;

        $statusBaru = $request->status;


        // Hanya buat notifikasi jika status benar-benar berubah

        if ($statusLama !== $statusBaru) {

            $aspirasi->update(['status' => $statusBaru]);


            $pesan = match($statusBaru) {

                'Proses'  => 'Pengaduan kamu sedang diproses oleh pihak sekolah.',

                'Selesai' => 'Pengaduan kamu telah selesai ditangani. Cek feedback dari admin.',

                default   => 'Status pengaduan kamu telah diperbarui menjadi ' . $statusBaru . '.',

            };


            Notifikasi::create([

                'nis'          => $aspirasi->nis,

                'id_aspirasi'  => $aspirasi->id_aspirasi,

                'pesan'        => $pesan,

                'sudah_dibaca' => false,

            ]);

        }


        return back()->with('success', 'Status berhasil diperbarui.');

    }


    // Kirim feedback — anti-spam: 1 feedback per aspirasi

    public function kirimFeedback(Request $request, $id)

    {

        $request->validate([

            'isi_feedback' => 'required|min:5|max:500'

        ]);


        $aspirasi = Aspirasi::where('id_aspirasi', $id)->firstOrFail();


        // Cek apakah feedback sudah pernah dikirim

        if ($aspirasi->feedback) {

            return back()->with('error', 'Feedback untuk pengaduan ini sudah pernah dikirim.');

        }


        // Hanya boleh kirim feedback jika status sudah Selesai

        if ($aspirasi->status !== 'Selesai') {

            return back()->with('error', 'Feedback hanya bisa dikirim jika status sudah Selesai.');

        }


        Feedback::create([

            'id_aspirasi'  => $id,

            'isi_feedback' => $request->isi_feedback,

        ]);


        return back()->with('success', 'Feedback berhasil dikirim.');

    }


    public function storeKategori(Request $request)

    {

        $request->validate([

            'ket_kategori' => 'required|max:30'

        ]);


        Kategori::create([

            'ket_kategori' => $request->ket_kategori

        ]);


        return back()->with('success', 'Kategori berhasil ditambahkan');

    }


    public function storeSiswa(Request $request)

    {

        $request->validate([

            'nis'   => 'required|unique:siswas,nis',

            'kelas' => 'required|max:10'

        ]);


        Siswa::create([

            'nis'   => $request->nis,

            'kelas' => $request->kelas

        ]);


        return back()->with('success', 'Siswa berhasil ditambahkan');

    }


    public function logout()

    {

        session()->flush(); // bug lama: sesion() → sudah diperbaiki

        return redirect('/admin');

    }

}