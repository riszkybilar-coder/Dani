<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Models\Siswa;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AspirasiController extends Controller
{
    // Tampilkan semua aspirasi (untuk halaman utama)
    public function index(Request $request)
    {
        $query = Aspirasi::with(['siswa', 'kategori'])->latest();

        // Filter
        if ($request->has('status') && $request->status != '') {
            $query->status($request->status);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where('nama_siswa', 'like', '%' . $request->search . '%');
        }

        if ($request->has('kategori') && $request->kategori != '') {
            $query->where('kategori_id', $request->kategori);
        }

        $aspirasis = $query->paginate(10);
        $kategoris = Kategori::all();

        return view('pengaduan.index', compact('aspirasis', 'kategoris'));
    }

    // Form tambah aspirasi (siswa)
    public function create()
    {
        $kategoris = Kategori::all();
        return view('siswa.form', compact('kategoris'));
    }

    // Simpan aspirasi baru
    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|exists:siswa,nis',
            'kategori_id' => 'required|exists:kategori,id',
            'keterangan' => 'required|string|min:10',
            'foto' => 'nullable|image|max:2048',
            'is_anonim' => 'boolean'
        ]);

        // Ambil data siswa dari NIS
        $siswa = Siswa::where('nis', $request->nis)->first();

        $aspirasi = new Aspirasi();
        $aspirasi->nis = $request->nis;
        $aspirasi->nama_siswa = $siswa->nama_siswa;
        $aspirasi->kelas = $siswa->kelas;
        $aspirasi->kategori_id = $request->kategori_id;
        $aspirasi->ket_kategori = Kategori::find($request->kategori_id)->nama_kategori;
        $aspirasi->keterangan = $request->keterangan;
        $aspirasi->status = 'Menunggu';
        $aspirasi->is_anonim = $request->has('is_anonim');

        // Upload foto
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('aspirasi', 'public');
            $aspirasi->foto = $path;
        }

        $aspirasi->save();

        return redirect()->route('pengaduan.index')
            ->with('success', 'Aspirasi berhasil dikirim!');
    }

    // Tampilkan detail
    public function show($id)
    {
        $aspirasi = Aspirasi::with(['siswa', 'kategori'])->findOrFail($id);
        return view('pengaduan.show', compact('aspirasi'));
    }

    // Form edit untuk user (verifikasi NIS)
    public function editUser($id)
    {
        $aspirasi = Aspirasi::findOrFail($id);
        return view('siswa.edit-pengaduan', compact('aspirasi'));
    }

    // Verifikasi NIS untuk edit user
    public function verifyNIS(Request $request, $id)
    {
        $request->validate([
            'nis' => 'required|string'
        ]);

        $aspirasi = Aspirasi::findOrFail($id);
        
        if ($aspirasi->nis !== $request->nis) {
            return back()->with('error', 'NIS tidak sesuai dengan data pengaduan');
        }

        // Set session untuk menandai sudah verifikasi
        session(['verified_aspirasi_' . $id => true]);
        
        return redirect()->route('pengaduan.edit-user-form', $id);
    }

    // Update dari user
    public function updateUser(Request $request, $id)
    {
        // Cek verifikasi
        if (!session('verified_aspirasi_' . $id)) {
            return redirect()->route('pengaduan.index')
                ->with('error', 'Anda harus verifikasi NIS terlebih dahulu');
        }

        $request->validate([
            'keterangan' => 'required|string|min:10',
            'is_anonim' => 'boolean'
        ]);

        $aspirasi = Aspirasi::findOrFail($id);
        $aspirasi->keterangan = $request->keterangan;
        $aspirasi->is_anonim = $request->has('is_anonim');
        $aspirasi->save();

        // Hapus session verifikasi
        session()->forget('verified_aspirasi_' . $id);

        return redirect()->route('pengaduan.index')
            ->with('success', 'Pengaduan berhasil diupdate!');
    }

    // Form edit untuk admin
    public function editAdmin($id)
    {
        $aspirasi = Aspirasi::with('siswa')->findOrFail($id);
        $kategoris = Kategori::all();
        $siswas = Siswa::orderBy('nama_siswa')->get();
        
        return view('admin.edit-aspirasi', compact('aspirasi', 'kategoris', 'siswas'));
    }

    // Update dari admin
    public function updateAdmin(Request $request, $id)
    {
        $request->validate([
            'nis' => 'required|exists:siswa,nis',
            'kategori_id' => 'required|exists:kategori,id',
            'keterangan' => 'required|string',
            'status' => 'required|in:Menunggu,Proses,Selesai',
            'feedback' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
            'is_anonim' => 'boolean'
        ]);

        $siswa = Siswa::where('nis', $request->nis)->first();
        
        $aspirasi = Aspirasi::findOrFail($id);
        $aspirasi->nis = $request->nis;
        $aspirasi->nama_siswa = $siswa->nama_siswa;
        $aspirasi->kelas = $siswa->kelas;
        $aspirasi->kategori_id = $request->kategori_id;
        $aspirasi->ket_kategori = Kategori::find($request->kategori_id)->nama_kategori;
        $aspirasi->keterangan = $request->keterangan;
        $aspirasi->status = $request->status;
        $aspirasi->feedback = $request->feedback;
        $aspirasi->is_anonim = $request->has('is_anonim');

        // Upload foto baru jika ada
        if ($request->hasFile('foto')) {
            // Hapus foto lama
            if ($aspirasi->foto) {
                Storage::disk('public')->delete($aspirasi->foto);
            }
            $path = $request->file('foto')->store('aspirasi', 'public');
            $aspirasi->foto = $path;
        }

        $aspirasi->save();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Data aspirasi berhasil diupdate!');
    }

    // Delete (admin only)
    public function destroy($id)
    {
        $aspirasi = Aspirasi::findOrFail($id);
        
        // Hapus foto
        if ($aspirasi->foto) {
            Storage::disk('public')->delete($aspirasi->foto);
        }
        
        $aspirasi->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Data aspirasi berhasil dihapus!');
    }

    // API get siswa (untuk dropdown AJAX)
    public function getSiswa(Request $request)
    {
        $search = $request->get('q', '');
        $siswas = Siswa::where('nama_siswa', 'like', "%{$search}%")
            ->orWhere('nis', 'like', "%{$search}%")
            ->limit(20)
            ->get(['nis', 'nama_siswa', 'kelas']);
        
        return response()->json($siswas);
    }
}