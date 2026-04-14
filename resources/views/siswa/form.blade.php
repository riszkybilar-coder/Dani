@extends('layouts.app')

@section('content')


<div class="row justify-content-center">

<div class="col-md-7">

<div class="card shadow">

<div class="card-header bg-primary text-white">

    <h5 class="mb-0">Form Pengaduan</h5>

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


<form action="/kirim" method="POST" id="formPengaduan" enctype="multipart/form-data">


@csrf


{{-- Checkbox anonim --}}

<div class="form-check mb-3">

    <input class="form-check-input" type="checkbox" id="checkAnonim" name="anonim" value="1"

           onchange="toggleNis(this.checked)">

    <label class="form-check-label" for="checkAnonim">

        Kirim sebagai <strong>anonim</strong>

        <small class="text-muted">(identitas kamu tidak akan ditampilkan)</small>

    </label>

</div>


{{-- Pilih NIS (disembunyikan jika anonim) --}}

<div class="mb-3" id="nisField">

    <label class="form-label">NIS</label>

    <select name="nis" class="form-select" id="nisSelect">

        <option value="">-- Pilih NIS --</option>

        @foreach($siswa as $s)

            <option value="{{ $s->nis }}">{{ $s->nis }} - {{ $s->kelas }}</option>

        @endforeach

    </select>

</div>


<div class="mb-3">

    <label class="form-label">Kategori</label>

    <select name="id_kategori" class="form-select" required>

        <option value="">-- Pilih Kategori --</option>

        @foreach($kategori as $k)

            <option value="{{ $k->id_kategori }}">{{ $k->ket_kategori }}</option>

        @endforeach

    </select>

</div>


<div class="mb-3">

    <label class="form-label">Lokasi Kejadian</label>

    <input type="text" name="lokasi" class="form-control" placeholder="Contoh: Kelas 12 RPL, Kantin, dll" required maxlength="50">

</div>


<div class="mb-3">

    <label class="form-label">Keterangan</label>

    <textarea name="ket" class="form-control" rows="3" placeholder="Jelaskan pengaduanmu..." required maxlength="255"></textarea>

</div>


<div class="mb-3">

    <label class="form-label fw-semibold">

        Foto Bukti <span class="text-danger">*</span>

    </label>

    <input type="file" name="foto" class="form-control" accept="image/*"

           required onchange="previewFoto(this)">

    <small class="text-muted">Format: JPG, JPEG, PNG. Maksimal 5MB.</small>


    {{-- Preview foto sebelum kirim --}}

    <div id="previewContainer" class="mt-2" style="display:none;">

        <p class="mb-1 text-muted" style="font-size:13px">Preview:</p>

        <img id="previewGambar" src="" alt="preview"

             style="max-height:200px; border-radius:8px; border:1px solid #dee2e6;">

    </div>

</div>


<div class="d-flex gap-2">

    <button type="button" class="btn btn-primary" onclick="konfirmasiKirim()">Kirim Pengaduan</button>

    <a href="{{ route('cek.form') }}" class="btn btn-secondary">Cek Status</a>

</div>


</form>

</div>

</div>

</div>

</div>


<script>

function toggleNis(isAnonim) {

    const nisField  = document.getElementById('nisField');

    const nisSelect = document.getElementById('nisSelect');

    nisField.style.display  = isAnonim ? 'none' : 'block';

    nisSelect.required      = !isAnonim;

}


function konfirmasiKirim() {

    const isAnonim = document.getElementById('checkAnonim').checked;

    const pesan = isAnonim

        ? 'Kamu akan mengirim pengaduan secara ANONIM. Identitasmu tidak akan ditampilkan. Lanjutkan?'

        : 'Apakah kamu yakin ingin mengirim pengaduan ini?';


    if (confirm(pesan)) {

        document.getElementById('formPengaduan').submit();

    }

}


function previewFoto(input) {

    const container = document.getElementById('previewContainer');

    const gambar    = document.getElementById('previewGambar');

    if (input.files && input.files[0]) {

        const reader = new FileReader();

        reader.onload = e => {

            gambar.src = e.target.result;

            container.style.display = 'block';

        };

        reader.readAsDataURL(input.files[0]);

    }

}

</script>


@endsection