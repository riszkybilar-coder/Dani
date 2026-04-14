@extends('layouts.admin')

@section('content')


<h3 class="mb-4">Dashboard Pengaduan</h3>


@if(session('success'))

    <div class="alert alert-success">{{ session('success') }}</div>

@endif

@if(session('error'))

    <div class="alert alert-danger">{{ session('error') }}</div>

@endif


{{-- Kartu ringkasan --}}

<div class="row g-3 mb-4">

    <div class="col-6 col-md-3">

        <div class="card text-center border-0 bg-light">

            <div class="card-body">

                <h2 class="fw-bold text-dark">{{ $totalPengaduan }}</h2>

                <small class="text-muted">Total Pengaduan</small>

            </div>

        </div>

    </div>

    <div class="col-6 col-md-3">

        <div class="card text-center border-0" style="background:#fff3cd">

            <div class="card-body">

                <h2 class="fw-bold text-warning">{{ $totalMenunggu }}</h2>

                <small class="text-muted">Menunggu</small>

            </div>

        </div>

    </div>

    <div class="col-6 col-md-3">

        <div class="card text-center border-0" style="background:#cfe2ff">

            <div class="card-body">

                <h2 class="fw-bold text-primary">{{ $totalProses }}</h2>

                <small class="text-muted">Diproses</small>

            </div>

        </div>

    </div>

    <div class="col-6 col-md-3">

        <div class="card text-center border-0" style="background:#d1e7dd">

            <div class="card-body">

                <h2 class="fw-bold text-success">{{ $totalSelesai }}</h2>

                <small class="text-muted">Selesai</small>

            </div>

        </div>

    </div>

</div>


{{-- Grafik --}}

<div class="row g-3 mb-4">

    <div class="col-md-7">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <h6 class="mb-3">Pengaduan per Kategori</h6>

                <canvas id="grafikKategori" height="200"></canvas>

            </div>

        </div>

    </div>

    <div class="col-md-5">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <h6 class="mb-3">Status Pengaduan</h6>

                <canvas id="grafikStatus" height="200"></canvas>

            </div>

        </div>

    </div>

</div>


{{-- Tabel pengaduan --}}

<div class="card border-0 shadow-sm">

<div class="card-body">

<h6 class="mb-3">Daftar Pengaduan</h6>

<table class="table table-bordered table-striped align-middle">

    <thead class="table-dark">

        <tr>

            <th>NIS</th>

            <th>Kategori</th>

            <th>Lokasi</th>

            <th>Keterangan</th>

            <th>Foto Bukti</th>

            <th>Status</th>

            <th>Feedback</th>

            <th style="min-width:200px">Aksi</th>

        </tr>

    </thead>

    <tbody>

    @foreach($data as $d)

        <tr>

            <td>

                @if($d->nis)

                    {{ $d->nis }}

                    @if($d->siswa)

                        <br><small class="text-muted">{{ $d->siswa->kelas }}</small>

                    @endif

                @else

                    <span class="badge bg-secondary">Anonim</span>

                @endif

            </td>

            <td>{{ $d->kategori->ket_kategori }}</td>

            <td>{{ $d->lokasi }}</td>

            <td>{{ $d->ket }}</td>

            <td>

                @if($d->status == 'Menunggu')

                    <span class="badge bg-secondary">Menunggu</span>

                @elseif($d->status == 'Proses')

                    <span class="badge bg-primary">Proses</span>

                @else

                    <span class="badge bg-success">Selesai</span>

                @endif

            </td>

            <td>

                @if($d->feedback)

                    <span class="text-success">{{ $d->feedback->isi_feedback }}</span>

                @else

                    <span class="text-muted fst-italic">Belum ada</span>

                @endif

            </td>


            <td>

                @if($d->foto)

                    <a href="{{ asset('storage/' . $d->foto) }}" target="_blank">

                        <img src="{{ asset('storage/' . $d->foto) }}"

                            style="height:50px; width:70px; object-fit:cover; border-radius:6px; cursor:pointer;">

                    </a>

                @else

                    <span class="text-muted fst-italic">-</span>

                @endif

            </td>

           

            <td>

                <form action="{{ route('admin.updateStatus', $d->id_aspirasi) }}" method="POST" class="mb-2">

                    @csrf

                    <div class="input-group input-group-sm">

                        <select name="status" class="form-select">

                            <option {{ $d->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>

                            <option {{ $d->status == 'Proses'   ? 'selected' : '' }}>Proses</option>

                            <option {{ $d->status == 'Selesai'  ? 'selected' : '' }}>Selesai</option>

                        </select>

                        <button class="btn btn-primary btn-sm">Simpan</button>

                    </div>

                </form>

                <tr>
                    <td>{{ $index + 1 }}</td>
                        <td>
                        @if($item->is_anonim)
                            <span class="text-muted">Anonim</span>
                        @else
                            {{ $item->nama_siswa }}<br>
                            <small class="text-muted">{{ $item->kelas }}</small>
                        @endif
                            </td>
                            <td>{{ $item->ket_kategori }}</td>
                            <td>{{ Str::limit($item->keterangan, 50) }}</td>
                            <td>
                                <span class="badge bg-{{ $item->status == 'Selesai' ? 'success' : ($item->status == 'Proses' ? 'warning' : 'secondary') }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td>
                                {{-- Tombol Edit --}}
                                <a href="{{ route('admin.aspirasi.edit', $item->id) }}" 
                                class="btn btn-sm btn-success">
                                    ✏️ Edit
                        </a>
                        
                        {{-- Quick status update (opsional) --}}
                        <button class="btn btn-sm btn-info" 
                                onclick="quickUpdateStatus({{ $item->id }})">
                            🔄 Status
                        </button>
                    </td>
                </tr>

                @if($d->status === 'Selesai' && !$d->feedback)

                    <form action="{{ route('admin.kirimFeedback', $d->id_aspirasi) }}" method="POST">

                        @csrf

                        <div class="input-group input-group-sm">

                            <input type="text" name="isi_feedback" class="form-control"

                                   placeholder="Tulis feedback..." required minlength="5" maxlength="500">

                            <button class="btn btn-success btn-sm">Kirim Feedback</button>

                        </div>

                    </form>

                @elseif($d->status !== 'Selesai')

                    <small class="text-muted">Selesaikan dulu untuk kirim feedback</small>

                @endif

            </td>

        </tr>

    @endforeach

    </tbody>

</table>

</div>

</div>


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

    // Grafik batang - per kategori

    const kategoriLabels = @json($grafikKategori->pluck('label'));

    const kategoriData   = @json($grafikKategori->pluck('total'));


    new Chart(document.getElementById('grafikKategori'), {

        type: 'bar',

        data: {

            labels: kategoriLabels,

            datasets: [{

                label: 'Jumlah Pengaduan',

                data: kategoriData,

                backgroundColor: '#0d6efd',

                borderRadius: 6,

            }]

        },

        options: {

            responsive: true,

            plugins: { legend: { display: false } },

            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }

        }

    });


    // Grafik donat - per status

    new Chart(document.getElementById('grafikStatus'), {

        type: 'doughnut',

        data: {

            labels: ['Menunggu', 'Proses', 'Selesai'],

            datasets: [{

                data: [

                    {{ $grafikStatus['Menunggu'] }},

                    {{ $grafikStatus['Proses'] }},

                    {{ $grafikStatus['Selesai'] }}

                ],

                backgroundColor: ['#6c757d', '#0d6efd', '#198754'],

                borderWidth: 2,

            }]

        },

        options: {

            responsive: true,

            plugins: {

                legend: { position: 'bottom' }

            }

        }

    });

</script>


@endsection