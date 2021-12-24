@extends("layouts.dashboard.master")
@section("title","Report DOS")
@section("page_title","Incoming DOS")
@section("breadcrumb")
<li class="breadcrumb-item"><a href="{{route("home")}}">Home</a></li>
<li class="breadcrumb-item active">Incoming DOS</li>
@endsection
@section("content")
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Jumlah ({{$jumlah}})</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <div class="table-responsive">
                <table class="table table-bordered text-nowrap" style="overflow-x: scroll;">
                    <thead>
                      <tr>
                        <th>Tanggal</th>
                        <th>Kegiatan</th>
                        <th>Waktu</th>
                        <th>Produk</th>
                        <th>KKontak SF</th>
                        <th>Tikor</th>
                        <th>ODP</th>
                        <th>Status Kunjungan</th>
                        <th>Keterangan Kunjungan</th>
                        <th>Keterangan Tambahan</th>
                        <th>ID</th>
                        <th>Gambar</th>
                        <th>Aksi</th>

                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($dos as $item)
                            <tr class="baris" id="{{$item->id_dos}}">
                                <td>{{date('d-m-Y',strtotime($item->tanggal))}}</td>
                                <td>{{$item->kegiatan}}</td>
                                <td>{{$item->waktu}}</td>
                                <td>{{$item->produk}}</td>
                                <td>{{$item->user->kode}}</td>
                                <td>{{$item->long}},{{$item->lat}}</td>
                                <td>{{$item->odp}}</td>
                                <td>{{$item->status_kunjungan}}</td>
                                <td>{{$item->keterangan_kunjungan}}</td>
                                <td>{{$item->keterangan_tambahan}}</td>
                                <td>{{$item->id_dos}}</td>
                                <td>
                                    <a href="{{asset("storage/".$item->foto)}}" data-fancybox="gallery">
                                        <img src="{{asset("storage/".$item->foto)}}" style="width: 120px; height: 80px; object-fit: cover; object-position: center; ">
                                    </a>
                                </td>
                                <td>
                                    <a href="" class="btn btn-primary approve" data-dos_id="{{$item->id}}" data-id_dos="{{$item->id_dos}}"> Terima </a>
                                    <button class="btn btn-danger decline" data-dos_id="{{$item->id}}" data-id_dos="{{$item->id_dos}}"> Tolak </a>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <!-- /.col -->
</div>
@endsection
@section("linkfooter")
<script>
  $(document).ready(function () {
    $(".approve").click(function (e) {
      e.preventDefault();
      const dos_id = $(this).data("dos_id");
        const url = "/laporan_dos/approve/"+dos_id;
        const id_dos = $(this).data("id_dos");
        $.ajax({
          type: "get",
          url: url,
          dataType: "json",
          success: function (response) {
            if (response.message == "success") {
                $(document).Toasts('create', {
                    class: 'bg-success',
                    title: 'Berhasil',
                    body: 'laporan diterima'
                })

                $("#"+id_dos).remove();
            }
          }
        });
    });

    $(".decline").click(function (e) {
        e.preventDefault();
        const dos_id = $(this).data("dos_id");
        const url = "/laporan_dos/decline/"+dos_id;
        const id_dos = $(this).data("id_dos");
        swal({
            title: "Yakin?",
            text: "akan menolak laporan ini?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    type: "get",
                    url: url,
                    dataType: "json",
                    success: function (response) {
                        if (response.message == "success") {
                            $(document).Toasts('create', {
                                class: 'bg-danger',
                                title: 'Berhasil',
                                body: 'laporan ditolak'
                            });

                            $("#"+id_dos).remove();
                        }
                    }
                });
            }

        });
    });
  });
</script>
@endsection
