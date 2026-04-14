@extends('layouts.admin')

@section('content')


<h3>Data Kategori</h3>


<form action="/admin/kategori/store" method="POST" class="mb-3">

@csrf

<input type="text" name="ket_kategori" class="form-control mb-2" placeholder="Nama Kategori">

<button class="btn btn-primary btn-sm">Tambah</button>

</form>


<table class="table table-bordered">

<tr>

<th>No</th>

<th>Nama Kategori</th>

</tr>


@foreach($kategori as $k)

<tr>

<td>{{$loop->iteration}}</td>

<td>{{$k->ket_kategori}}</td>

</tr>

@endforeach


</table>


@endsection