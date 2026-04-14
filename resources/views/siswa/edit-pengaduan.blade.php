@extends('layouts.app')

@section('title', 'Edit Pengaduan')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h4 class="mb-0">✏️ Edit Pengaduan #{{ $aspirasi->id }}</h4>
                </div>
                
                <div class="card-body">
                    {{-- Verifikasi NIS --}}
                    @if(!session('verified_aspirasi_' . $aspirasi->id))
                        <div class="alert alert-warning">
                            <h5>🔐 Verifikasi NIS</h5>
                            <p>Masukkan NIS untuk mengedit pengaduan ini</p>
                            
                            <form action="{{ route('siswa.verify-nis', $aspirasi->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <input type="text" name="nis" class="form-control" 
                                           placeholder="Masukkan NIS Anda" required>
                                </div>
                                <button type="submit" class="btn btn-success">Verifikasi</button>
                            </form>
                        </div>
                    @else
                        {{-- Form Edit --}}
                        <div class="alert alert-info">
                            <strong>📋 Info:</strong> Anda hanya dapat mengedit keterangan dan opsi anonim
                        </div>

                        <form action="{{ route('siswa.update', $aspirasi->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" class="form-control" value="{{ $aspirasi->nama_siswa }}" readonly>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Kelas</label>
                                <input type="text" class="form-control" value="{{ $aspirasi->kelas }}" readonly>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Kategori</label>
                                <input type="text" class="form-control" value="{{ $aspirasi->ket_kategori }}" readonly>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <input type="text" class="form-control" value="{{ $aspirasi->status }}" readonly>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Keterangan (Bisa diedit) *</label>
                                <textarea name="keterangan" class="form-control" rows="5" required>{{ $aspirasi->keterangan }}</textarea>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Feedback Admin</label>
                                <textarea class="form-control" rows="3" readonly>{{ $aspirasi->feedback ?? '-' }}</textarea>
                            </div>
                            
                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" name="is_anonim" class="form-check-input" 
                                           value="1" {{ $aspirasi->is_anonim ? 'checked' : '' }}>
                                    <label class="form-check-label">Sembunyikan NIS (Anonim)</label>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-success">💾 Simpan Perubahan</button>
                            <a href="{{ route('pengaduan.index') }}" class="btn btn-secondary">← Kembali</a>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection