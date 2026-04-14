@extends('layouts.admin')

@section('content')


<h3>Saran & Masukan Siswa</h3>


@if(session('success'))

    <div class="alert alert-success">{{ session('success') }}</div>

@endif


@if($sarans->count() == 0)

    <div class="alert alert-info">Belum ada saran yang masuk.</div>

@else

<table class="table table-bordered table-striped align-middle">

    <thead class="table-dark">

        <tr>

            <th>No</th>

            <th>NIS</th>

            <th>Kelas</th>

            <th>Judul</th>

            <th>Isi Saran</th>

            <th>Tanggal</th>

        </tr>

    </thead>

    <tbody>

    @foreach($sarans as $s)

        <tr>

            <td>{{ $loop->iteration }}</td>

            <td>{{ $s->nis }}</td>

            <td>{{ $s->siswa->kelas ?? '-' }}</td>

            <td>{{ $s->judul }}</td>

            <td>{{ $s->isi_saran }}</td>

            <td>{{ $s->created_at->format('d/m/Y H:i') }}</td>

        </tr>

    @endforeach

    </tbody>

</table>

@endif


@endsection