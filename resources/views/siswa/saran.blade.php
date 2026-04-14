@extends('layouts.app')

@section('content')


<div class="row justify-content-center">

<div class="col-md-7">

<div class="card shadow">

<div class="card-header bg-primary text-white">

    <h5 class="mb-0">Form Saran & Masukan</h5>

</div>

<div class="card-body">


@if(session('success'))

    <div class="alert alert-success">{{ session('success') }}</div>

@endif


@if($errors->any())

    <div class="alert alert-danger">

        @foreach($errors->all() as $error)

            <li>{{ $error }}</li>

        @endforeach

    </div>

@endif


<form action="{{ route('saran.store') }}" method="POST" id="formSaran">

@csrf

<div class="mb-3">

    <label class="form-label">Pilih NIS</label>

    <select name="nis" class="form-select" required>

        <option value="">-- Pilih NIS --</option>

        @foreach($siswa as $s)

            <option value="{{ $s->nis }}">{{ $s->nis }} - {{ $s->kelas }}</option>

        @endforeach

    </select>

</div>

<div class="mb-3">

    <label class="form-label">Judul</label>

    <input type="text" name="judul" class="form-control" placeholder="Judul saran..." required maxlength="100">

</div>

<div class="mb-3">

    <label class="form-label">Isi Saran / Masukan</label>

    <textarea name="isi_saran" class="form-control" rows="4" placeholder="Tulis saran atau masukan kamu di sini..." required maxlength="1000"></textarea>

</div>


{{-- Tombol dengan konfirmasi --}}

<button type="button" class="btn btn-primary" onclick="konfirmasiSaran()">Kirim Saran</button>

</form>


</div>

</div>

</div>

</div>


<script>

function konfirmasiSaran() {

    if (confirm('Apakah kamu yakin ingin mengirim saran ini?')) {

        document.getElementById('formSaran').submit();

    }

}

</script>


@endsection