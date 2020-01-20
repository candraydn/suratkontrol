@extends('layouts.master')

@section('content')
<h1>Data Surat Kontrol</h1>
<hr><br>
<input type="text" name="keyword" id="btnCari" class="form-control mb-4" style="background:#feffd6" placeholder="Cari No Surat / No RM . . .">
<table class="table table-striped" id="laravel_datatable">
    <thead>
      <tr>
        <th>No. Surat</th>
        <th>No RM</th>
        <th>No Rujukan</th>
        <th>Tgl. Rujukan</th>
        <th>Tgl. Kunjungan</th>
        <th>Created</th>
        <th>Detail</th>
      </tr>
    </thead>
    <tbody id="view1">
          @foreach ($surat as $item)
          <tr>
              <td>{{ $item->no_surat }}</td>
              <td>{{ sprintf("%06s",$item->no_rm) }}</td>
              <td>{{ $item->no_rujukan }}</td>
              <td>{{ $item->tanggal }}</td>
              <td>{{ $item->kunjungan }}</td>
              <td>{{ $item->created_at }}</td>
          <td><a class="btn btn-info" target="_blank" href="detail/{{ $item->no_rm }}">Lihat Data</a></td>
          </tr>
        @endforeach
    </tbody>
</table>
<script type="text/javascript">
  function zeroPad(num, places) {
    var zero = places - num.toString().length + 1;
    return Array(+(zero > 0 && zero)).join("0") + num;
  }

  $('#btnCari').keypress(function (e) {
    var key = e.which;
    if(key == 13)  // the enter key code
      {
        var keywords = $('#btnCari').val();
        $.ajax({
        url: "http://localhost/surat-kontrol/surat",
        method: "POST",
        data: { "_token": "{{ csrf_token() }}", item_id: keywords},
        }).done(function(response) {
          $("#view1").html(response);
        }).fail(function( jqXHR, textStatus ) {
          alert('fail');
        }); 
      }
  });   
</script>
@endsection
