@extends('layouts.master')
@section('content')
<h1>Tambah Pasien dan Surat</h1>
<hr><br>
@if(session()->has('message'))
<div class="alert alert-success">
    {{ session()->get('message') }}
</div>
@endif
@if(session()->has('messageF'))
<div class="alert alert-danger">
    {{ session()->get('message') }}
</div>
@endif
<form method="post" action="{{route("store")}}">
    @csrf
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="no_surat">No Surat Kontrol</label>
        <input name="no_surat" type="text" class="form-control @error('no_surat') is-invalid @enderror" id="no_surat" @error('no_surat') value="{{old('no_surat')}}" @enderror value="{{$nosurat}}">
        {!! $errors->first('no_surat','<span class="invalid-feedback">:message</span>') !!}
    </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="norujukan">Nomor Rujukan</label>
            <input name="norujukan" type="text" class="form-control @error('norujukan') is-invalid @enderror" onkeyup="autofill()" id="norujukan" value="{{ old('norujukan') }}">
            {!! $errors->first('norujukan','<span class="invalid-feedback">:message</span>') !!}
        </div>
        <div class="form-group col-md-6">
            <label for="tgl_rujukan">Tanggal Rujukan</label>
            <input name="tgl_rujukan" type="date" class="form-control" id="tgl_rujukan" value="{{ old('tgl_rujukan') }}">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="no_rm">Nomor Rekam Medik</label>
            <input name="no_rm" type="text" class="form-control @error('no_rm') is-invalid @enderror" id="no_rm" value="{{ old('no_rm') }}">
        </div>
        <div class="form-group col-md-6">
            <label for="nama">Nama Pasien</label>
            <input name="nama_pasien" style="text-transform: uppercase" type="text" class="form-control" id="nama" value="{{ old('nama_pasien') }}">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="no_kartu">Nomor Kartu</label>
            <input name="no_kartu" type="text" class="form-control" id="no_kartu" value="{{ old('no_kartu') }}">
        </div>
        <div class="form-group col-md-6">
            <label for="tgl_kunjungan">Tanggal Kunjungan</label>
            <input name="tgl_kunjungan" type="date" class="form-control" id="tgl_kunjungan" value="{{date("Y-m-d")}}">
        </div>
    </div>
    <input type="submit" value="Submit" class="btn btn-success btn-block">
</form>
<script type="text/javascript">
    function autofill(){
      var norujukan = $('#norujukan').val();
      $.ajax({
        url : "{{route('autofill')}}",
        data : 'no='+norujukan,
        success : function(data){
          var json = data,
          obj = JSON.parse(json);
          $("#tgl_rujukan").val(obj.tanggal);
          $("#no_rm").val(obj.no_rm);
          $("#nama").val(obj.nama_pasien);
          $("#no_kartu").val(obj.no_kartu);
      } 
      })
    }
</script>
@endsection
