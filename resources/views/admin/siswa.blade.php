@extends('layouts.admin')

@section('content')


<h3>Data Siswa</h3>


<form action="/admin/siswa/store" method="POST" class="mb-3">

@csrf

<input type="number" name="nis" class="form-control mb-2" placeholder="NIS">

<input type="text" name="kelas" class="form-control mb-2" placeholder="Kelas">

<button class="btn btn-success btn-sm">Tambah</button>

</form>


<table class="table table-bordered">

<tr>

<th>No</th>

<th>NIS</th>

<th>Kelas</th>

</tr>


@foreach($siswa as $s)

<tr>

<td>{{$loop->iteration}}</td>

<td>{{$s->nis}}</td>

<td>{{$s->kelas}}</td>

</tr>

@endforeach


</table>


@endsection
