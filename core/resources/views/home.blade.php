@extends('layouts.master')

@section('content')
<h1>Data Pasien</h1>
<hr>
<a href="{{route('add')}}" class="btn btn-success">+ Tambah</a><br><br>
<table class="table table-striped" id="laravel_datatable">
    <thead>
      <tr>
        <th>No. RM</th>
        <th>Nama</th>
        <th>Option</th>
      </tr>
    </thead>
</table>
<script type="text/javascript">
$(document).ready( function () {
    $('#laravel_datatable').DataTable({
           processing: true,
           serverSide: true,
           ajax: "{{ route('getPasien') }}",
           columns: [
                    { 
                      "data": "no_rm",
                      "render": function(data, type, row, meta){
                          if(type === 'display'){
                              data = zeroPad(data, 6);
                          }
                          return data;
                      }
                    },
                    { data: 'nama_pasien', name: 'nama_pasien' },
                    { 
                      "data": "no_rm",
                      "render": function(data, type, row, meta){
                          if(type === 'display'){
                              data = '<a class="btn btn-info" target="_blank" href="detail/' + data + '">Lihat Data</a>';
                          }
                          return data;
                      }
                    } 
                 ]
        });
     });
    function zeroPad(num, places) {
      var zero = places - num.toString().length + 1;
      return Array(+(zero > 0 && zero)).join("0") + num;
    }
</script>
@endsection
