@extends('layouts.master')

@section('content')
<h1>Detail Pasien</h1>
<button type="button" class="btn btn-primary">
    {{$info->nama_pasien}} <span class="badge badge-light">{{sprintf("%06s",$info->no_rm)}}</span>
</button>
<hr>
@if(session()->has('message'))
<div class="alert alert-success">
    {{ session()->get('message') }}
</div>
@endif
<table class="table table-bordered">
    <thead>
        <tr>
            <th>No. Surat</th>
            <th>No. Kartu BPJS</th>
            <th>No. Rujukan</th>
            <th>Tgl. Rujukan</th>
            <th>Tgl. Kunjungan</th>
            <th>Option</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pasien as $item)
        <tr>
            <td>{{ $item->no_surat }}</td>
            <td>{{ $item->no_kartu }}</td>
            <td>{{ $item->no_rujukan }}</td>
            <td>{{ $item->tanggal }}</td>
            <td>{{ $item->kunjungan }}</td>
        <td><a href="{{route('edit.surat',$item->id)}}" class="btn btn-info">Ubah</a>&nbsp;<a href="{{route('delete.surat',$item->id)}}" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a></td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
