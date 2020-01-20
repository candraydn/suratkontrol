@extends('layouts.master');
@section('content')
<h1>Edit Surat</h1>
<hr><br>
<form method="post" action="{{route("edit.surat.proses",$id)}}">
    @csrf
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="no_surat">No Surat Kontrol</label>
        <input name="no_surat" type="text" class="form-control @error('no_surat') is-invalid @enderror" id="no_surat" @error('no_surat') value="{{old('no_surat')}}" @enderror value="{{$surat->no_surat}}" disabled>
        {!! $errors->first('no_surat','<span class="invalid-feedback">:message</span>') !!}
    </div>
    <div class="form-group col-md-6">
        <label for="tgl_kunjungan">Tanggal Kunjungan</label>
        <input name="tgl_kunjungan" type="date" class="form-control" id="tgl_kunjungan" value="{{$surat->kunjungan}}">
    </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="norujukan">Nomor Rujukan</label>
            <input name="norujukan" type="text" class="form-control @error('norujukan') is-invalid @enderror" onkeyup="autofill()" id="norujukan" value="{{ $surat->no_rujukan }}">
            {!! $errors->first('norujukan','<span class="invalid-feedback">:message</span>') !!}
        </div>
        <div class="form-group col-md-6">
            <label for="tgl_rujukan">Tanggal Rujukan</label>
            <input name="tgl_rujukan" type="date" class="form-control" id="tgl_rujukan" value="{{ $surat->tanggal }}">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="no_rm">Nomor Rekam Medik</label>
            <input name="no_rm" type="text" class="form-control @error('no_rm') is-invalid @enderror" id="no_rm" value="{{ $surat->no_rm }}">
        </div>
        <div class="form-group col-md-6">
            <label for="no_kartu">Nomor Kartu</label>
            <input name="no_kartu" type="text" class="form-control" id="no_kartu" value="{{ $surat->no_kartu }}">
        </div>
    </div>

    <input type="submit" value="Edit" class="btn btn-success btn-block">
</form>
@endsection