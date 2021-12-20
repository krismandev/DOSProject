@extends("layouts.dashboard.master")
@section("title","Rekap DOS - SPV ".$user_spv->name)
@section("page_title","Rekap DOS -  SPV ".$user_spv->name)
@section("breadcrumb")
<li class="breadcrumb-item"><a href="{{route("home")}}">Home</a></li>
<li class="breadcrumb-item">Data DOS</li>
<li class="breadcrumb-item">SPV {{$user_spv->name}}</li>
@endsection
@section("content")
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
            <div class="card-tools">
                <button type="button" class="btn btn-primary float-right export">Export Excel</button>

                <label for="">Tanggal awal</label>
                <span class="add-on"><i class="icon-th"></i></span>
                <input class="span2 datepicker" type="date" value="{{$awal}}" autocomplete="off" name="awal" id="awal">

                <label for="">Tanggal akhir</label>
                <span class="add-on"><i class="icon-th"></i></span>
                <input class="span2 datepicker" type="date" value="{{$akhir}}" autocomplete="off" name="akhir" id="akhir">

            </div>
          </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <div class="table-responsive">
                <table class="table table-bordered text-nowrap" style="overflow-x: scroll;" id="dos_table">
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
                        {{-- {{-- <th>Gambar</th> --}}
                        <th>Aksi</th>

                      </tr>
                    </thead>
                    {{-- <tbody>
                        @foreach ($dos as $item)
                            <tr>
                                <td>{{date('d-m-Y',strtotime($item->tanggal))}}</td>
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
                                <td>
                                    <img src="{{asset("storage/".$item->foto)}}" style="width: 120px; height: 80px; object-fit: cover; object-position: center; ">
                                </td>
                                <td>
                                    <button class="btn btn-primary">Show</button>
                                </td>

                            </tr>
                        @endforeach
                    </tbody> --}}
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
{{-- <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> --}}
<div class="modal fade" id="modal-filter" tabindex="-1" role="dialog" aria-labelledby="modal-notification" aria-hidden="true">
    <div class="modal-dialog modal-default modal-dialog-centered modal-" role="document">
      <div class="modal-content bg-gradient-danger">

        <div class="modal-header">
          <h6 class="modal-title" id="modal-title-notification">Your attention is required</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>

        <div class="modal-body">
          <form role="form" method="get" action="">
            @csrf
            <div class="box-body">
              <div class="input-prepend date">
                  <label for="">Tanggal awal</label>
                  <span class="add-on"><i class="icon-th"></i></span>
                  <input class="span2 datepicker" type="date" value="{{$awal}}" autocomplete="off" name="awal" id="awal">
              </div>
              <div class="input-prepend date">
                  <label for="">Tanggal akhir</label>
                  <span class="add-on"><i class="icon-th"></i></span>
                  <input class="span2 datepicker" type="date" value="{{$akhir}}" autocomplete="off" name="akhir" id="akhir">
              </div>
            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>

<script>
    $(document).ready(function () {
        let tanggal_awal = '{{$awal}}';
        let tanggal_akhir = '{{$akhir}}';
        let user_spv_id = '{{$user_spv->id}}'

        // {!! route('dataRekapDosBySpv',["id"=>$user_spv->id,"awal"=>$awal,"akhir"=>$akhir]) !!}
        renderTable();



        $("#awal").datepicker({
            dateFormat: "yy-mm-dd",
            onSelect: function(dateText){
                // console.log("Selected date: " + dateText + "; input's current value: ");
                tanggal_awal = dateText;
                $("#dos_table").DataTable().destroy();
                renderTable();
            }
        })

        $("#akhir").datepicker({
            dateFormat: "yy-mm-dd",
            onSelect: function(dateText){
                tanggal_akhir = dateText;
                $("#dos_table").DataTable().destroy();
                renderTable();
            }
        })


        function renderTable(){
            $("#dos_table").DataTable({
                processing: true,
                serverSide: true,
                ajax: '/rekap-dos/spv/'+user_spv_id+'/data/'+tanggal_awal+'/'+tanggal_akhir, // memanggil route yang menampilkan data json
                columns: [
                    { // mengambil & menampilkan kolom sesuai tabel database
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'kegiatan',
                        name: 'kegiatan'
                    },
                    {
                        data: 'waktu',
                        name: 'waktu'
                    },
                    {
                        data: 'produk',
                        name: 'produk'
                    },
                    {
                        data: 'user.kode',
                        name: 'kkontak'
                    },
                    {
                        "render": function (data,type,full_row,meta) {
                            return full_row.lat+","+full_row.long;
                        }
                    },
                    {
                        data: 'odp',
                        name: 'odp'
                    },
                    {
                        data: 'status_kunjungan',
                        name: 'status_kunjungan'
                    },
                    {
                        data: 'keterangan_kunjungan',
                        name: 'keterangan_kunjungan'
                    },
                    {
                        data: 'keterangan_tambahan',
                        name: 'keterangan_tambahan'
                    },
                    {
                        data: 'id_dos',
                        name: 'id_dos'
                    },
                    {
                        "render": function (data,type,full_row,meta) {
                            // return full_row.foto;
                            // return '<img src="{{asset("storage/'+full_row.foto+'")}}" style="width: 120px; height: 80px; object-fit: cover; object-position: center; ">'
                            return `<img src="{{asset("storage")}}/${full_row.foto}" style="width: 120px; height: 80px; object-fit: cover; object-position: center; ">`
                        }
                    }

                ]
            })
        }

        $(".export").click(function (e) {
            e.preventDefault();
            window.location = '/rekap-dos/spv/'+user_spv_id+'/data/'+tanggal_awal+'/'+tanggal_akhir+'/export';
        });
    });
</script>
@endsection
