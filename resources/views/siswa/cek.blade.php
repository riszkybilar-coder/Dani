@extends('layouts.app')

@section('content')


<div class="row justify-content-center">

<div class="col-md-8">


<div class="card shadow">

<div class="card-header bg-primary text-white">

    <h5 class="mb-0">Cek Status Pengaduan</h5>

</div>

<div class="card-body">


<form action="{{ route('cek.status') }}" method="POST" class="mb-4">

@csrf

<div class="input-group">

    <select name="nis" class="form-select" required>

        <option value="">-- Pilih NIS --</option>

        @foreach($siswa as $s)

            <option value="{{ $s->nis }}">{{ $s->nis }} - {{ $s->kelas }}</option>

        @endforeach

    </select>

    <button class="btn btn-success">Cek Status</button>

</div>

</form>


{{-- Tampilkan notifikasi baru jika ada --}}

@if(isset($notifikasi) && $notifikasi->count() > 0)

    <div class="mb-3">

        <h6 class="text-primary">

            <span class="badge bg-danger">{{ $notifikasi->count() }}</span>

            Notifikasi Baru

        </h6>

        @foreach($notifikasi as $n)

            <div class="alert alert-info d-flex align-items-start gap-2 py-2">

                <span>&#128276;</span>

                <div>

                    <small class="text-muted">{{ $n->created_at->diffForHumans() }}</small><br>

                    {{ $n->pesan }}

                </div>

            </div>

        @endforeach

    </div>

@endif


@if(isset($data))

    @if($data->count() == 0)

        <div class="alert alert-danger">Data pengaduan tidak ditemukan.</div>

    @else

        <table class="table table-bordered table-striped">

            <thead class="table-dark">

                <tr>

                    <th>Kategori</th>

                    <th>Lokasi</th>

                    <th>Keterangan</th>

                    <th>Status</th>

                    <th>Feedback Admin</th>

                    <th>Foto Bukti</th>

                </tr>

            </thead>

            <tbody>

            @foreach($data as $d)

                <tr>

                    <td>{{ $d->kategori->ket_kategori }}</td>

                    <td>{{ $d->lokasi }}</td>

                    <td>{{ $d->ket }}</td>

                    <td>

                        @if($d->status == 'Menunggu')

                            <span class="badge bg-secondary">Menunggu</span>

                        @elseif($d->status == 'Proses')

                            <span class="badge bg-warning text-dark">Proses</span>

                        @else

                            <span class="badge bg-success">Selesai</span>

                        @endif

                    </td>


                    <td>

                        @if($d->foto)

                            <a href="{{ asset('storage/' . $d->foto) }}" target="_blank">

                                <img src="{{ asset('storage/' . $d->foto) }}"

                                    style="height:60px; width:80px; object-fit:cover; border-radius:6px; cursor:pointer;">

                            </a>

                        @else

                            <span class="text-muted fst-italic">-</span>

                        @endif

                    </td>

                   

                    <td>

                        @if($d->feedback)

                            <span class="text-success">{{ $d->feedback->isi_feedback }}</span>

                        @else

                            <span class="text-muted fst-italic">Belum ada</span>

                        @endif

                    </td>

                </tr>

            @endforeach

            </tbody>

        </table>

    @endif

@endif


</div>

</div>

</div>

</div>


@endsection