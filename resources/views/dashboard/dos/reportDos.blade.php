@extends("layouts.dashboard.master")
@section("title","Report DOS")
@section("content")
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Bordered Table</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" style="overflow-x: scroll;">
                    <thead>
                      <tr>
                        <th>Tanggal</th>
                        <th>Kegiatan</th>
                        <th>Waktu</th>
                        <th>Produk</th>
                        <th>KKontak SF</th>
                        <th>Tikor</th>
                        <th width="30%">ODP</th>
                        <th>Status Kunjungan</th>
                        <th>Keterangan Kunjungan</th>
                        <th>Keterangan Tambahan</th>
                        <th>ID</th>
                        <th>Gambar</th>

                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($dos as $item)
                            <tr>
                                <td>{{$item->tanggal}}</td>
                                <td>{{$item->kegiatan}}</td>
                                <td>{{$item->waktu}}</td>
                                <td>{{$item->produk}}</td>
                                <td>{{$item->user->kode}}</td>
                                <td>{{$item->long}},{{$item->lat}}</td>
                                <td>{{$item->odp}}</td>
                                <td>{{$item->status_kunjungan}}</td>
                                <td>{{$item->keterangan_kunjungan}}</td>
                                <td>{{$item->keterangan_tambahan}}</td>
                                <td>Y</td>
                                <td>
                                    <img src="{{asset("storage/".$item->foto)}}" style="width: 120px; height: 80px;">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer clearfix">
          <ul class="pagination pagination-sm m-0 float-right">
            <li class="page-item"><a class="page-link" href="#">«</a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">»</a></li>
          </ul>
        </div>
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
@endsection
