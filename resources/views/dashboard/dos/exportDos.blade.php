<table border="1">
    <thead>
        <tr>
            <th><b>TANGGAL</b></th>
            <th><b>KEGIATAN</b></th>
            <th><b>WAKTU</b></th>
            <th><b>PRODUK</b></th>
            <th><b>KKONTAKSF</b></th>
            <th><b>TIKOR</b></th>
            <th><b>ODP</b></th>
            <th><b>STATUS_KUNJUNGAN</b></th>
            <th><b>KETERANGAN_KUNJUNGAN</b></th>
            <th><b>KETERANGAN_TAMBAHAN</b></th>
            <th><b>ID</b></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dos as $item)
            <tr>
                <td>{{date("d/m/Y",strtotime($item->tanggal))}}</td>
                <td>{{$item->kegiatan}}</td>
                <td>{{$item->waktu}}</td>
                <td>{{$item->produk}}</td>
                <td>{{$item->user->kode}}</td>
                <td>{{$item->lat}},{{$item->long}}</td>
                <td>{{$item->odp}}</td>
                <td>{{$item->status_kunjungan}}</td>
                <td>{{$item->keterangan_kunjungan}}</td>
                <td>{{$item->keterangan_tambahan}}</td>
                <td>{{$item->id_dos}}</td>

            </tr>
        @endforeach
    </tbody>
</table>
