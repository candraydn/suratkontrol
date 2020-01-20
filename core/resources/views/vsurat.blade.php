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