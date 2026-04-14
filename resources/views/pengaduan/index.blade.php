@extends('layouts.app')

@section('content')


<style>

    .hero-section {

        background: linear-gradient(135deg, #7C3AED, #A855F7);

        border-radius: 16px;

        padding: 2rem;

        margin-bottom: 2rem;

        color: white;

    }

    .hero-section h2 { font-weight: 700; margin: 0; }

    .hero-section p  { margin: 0; opacity: 0.85; }


    .badge-menunggu { background: #FEF3C7; color: #92400E; border-radius: 20px; padding: 4px 12px; font-size: 12px; font-weight: 500; }

    .badge-proses   { background: #EDE9FE; color: #5B21B6; border-radius: 20px; padding: 4px 12px; font-size: 12px; font-weight: 500; }

    .badge-selesai  { background: #D1FAE5; color: #065F46; border-radius: 20px; padding: 4px 12px; font-size: 12px; font-weight: 500; }


    .card-pengaduan {

        background: #fff;

        border: 1px solid #EDE9FE;

        border-radius: 14px;

        padding: 1.2rem 1.4rem;

        margin-bottom: 1rem;

        transition: box-shadow 0.2s;

    }

    .card-pengaduan:hover { box-shadow: 0 4px 20px rgba(124,58,237,0.10); }


    .kategori-pill {

        background: #F5F3FF;

        color: #6D28D9;

        border-radius: 20px;

        padding: 3px 12px;

        font-size: 12px;

        font-weight: 500;

        display: inline-block;

        margin-bottom: 6px;

    }

    .foto-thumb {

        height: 70px;

        width: 100px;

        object-fit: cover;

        border-radius: 10px;

        border: 2px solid #EDE9FE;

        cursor: pointer;

        transition: transform 0.2s;

    }

    .foto-thumb:hover { transform: scale(1.05); }


    .lokasi-text {

        font-size: 13px;

        color: #7C3AED;

        font-weight: 500;

    }

    .ket-text {

        font-size: 14px;

        color: #374151;

        margin: 4px 0 0;

    }

    .no-data {

        text-align: center;

        padding: 3rem;

        color: #9CA3AF;

    }

    .no-data p { margin-top: 1rem; font-size: 15px; }

</style>


{{-- Hero --}}

<div class="hero-section">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

        <div>

            <h2>📋 Daftar Pengaduan</h2>

            <p>Semua pengaduan yang masuk dari siswa ditampilkan di sini</p>

        </div>

        <a href="/form" class="btn btn-light fw-semibold" style="border-radius:10px; color:#7C3AED;">

            + Buat Pengaduan

        </a>

    </div>

</div>


{{-- Daftar --}}

@if($data->count() == 0)

    <div class="no-data">

        <svg width="64" height="64" fill="none" viewBox="0 0 24 24" stroke="#D8B4FE" stroke-width="1.5">

            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>

        </svg>

        <p>Belum ada pengaduan yang masuk.</p>

    </div>

@else

    <p class="text-muted mb-3" style="font-size:14px">Total {{ $data->count() }} pengaduan</p>


    @foreach($data as $d)

    <div class="card-pengaduan">

        <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">


            {{-- Info kiri --}}

            <div style="flex:1; min-width:200px;">

                <span class="kategori-pill">{{ $d->kategori->ket_kategori }}</span>

                <div class="lokasi-text">📍 {{ $d->lokasi }}</div>

                <div class="ket-text">{{ $d->ket }}</div>

                <div class="mt-2">

                    @if($d->status == 'Menunggu')

                        <span class="badge-menunggu">⏳ Menunggu</span>

                    @elseif($d->status == 'Proses')

                        <span class="badge-proses">🔄 Diproses</span>

                    @else

                        <span class="badge-selesai">✅ Selesai</span>

                    @endif

                </div>

                <div class="mt-1" style="font-size:12px; color:#9CA3AF;">

                    {{ $d->created_at->format('d M Y, H:i') }}

                </div>

            </div>


            {{-- Foto kanan --}}

            @if($d->foto)

            <div>

                <a href="{{ asset('storage/' . $d->foto) }}" target="_blank">

                    <img src="{{ asset('storage/' . $d->foto) }}"

                        style="height:120px; width:160px; object-fit:cover; border-radius:12px; border:2px solid #EDE9FE; cursor:pointer; transition: transform 0.2s;"

                        onmouseover="this.style.transform='scale(1.04)'"

                        onmouseout="this.style.transform='scale(1)'"

                        title="Klik untuk lihat foto penuh">

                </a>

            </div>

            @endif


        </div>

    </div>

    @endforeach

    @foreach($aspirasis as $item)
    <div class="card mb-3">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div>
                    <h5>{{ $item->is_anonim ? 'Anonim' : $item->nama_siswa }}</h5>
                    <small>{{ $item->kelas }} | {{ $item->created_at->format('d M Y') }}</small>
                </div>
                <div>
                    {{-- Tombol edit untuk user (selalu tampil) --}}
                    <a href="{{ route('siswa.edit-form', $item->id) }}" 
                    class="btn btn-sm btn-outline-success">
                        ✏️ Edit
                    </a>
                </div>
            </div>
            <p class="mt-2">{{ $item->keterangan }}</p>
            <span class="badge bg-{{ $item->status == 'Selesai' ? 'success' : 'warning' }}">
                {{ $item->status }}
            </span>
        </div>
    </div>
    @endforeach