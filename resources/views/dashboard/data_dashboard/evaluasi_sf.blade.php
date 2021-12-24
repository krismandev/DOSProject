@php
    use App\Dos;
@endphp

@extends("layouts.dashboard.master")
@section("page_title","Dashboard DOS / Sales")
@section("breadcrumb")
<li class="breadcrumb-item"><a href="{{route("home")}}">Home</a></li>
<li class="breadcrumb-item">Dashboard DOS</li>
<li class="breadcrumb-item active"> Evaluasi SF</li>
@endsection
@section("title","Dashboard DOS / SPV")
@section("content")

<style>
    .cell-yellow{
        background-color: #fcfc03;
    }

    .cell-orange{
        background-color: #fc9803;
    }

    .cell-purple,.row-purple{
        background-color: #da8af2;
    }


</style>

<div class="row">
    <div class="col-md-7">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Berdasarkan Jam Kunjungan</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
          <div class="table-responsive">
            <table class="table table-bordered text-nowrap">
                <thead>
                  <tr>
                    <th style="width: 10px" class="cell-yellow">Range Waktu</th>
                    <th class="cell-yellow">Bertemu</th>
                    <th class="cell-yellow">Tidak Bertemu</th>
                    <th class="cell-yellow">Tot Visit</th>
                    <th class="cell-orange">Bertemu</th>
                    <th class="cell-orange">Tidak Bertemu</th>
                  </tr>
                </thead>
                <tbody>

                    @php
                        $sum_bertemu = 0;
                        $sum_tidak_bertemu = 0;
                        $sum_kunjungan = 0;
                    @endphp
                    @foreach ($waktu_kunjungans as $waktu)
                    @php
                        $jumlah_bertemu = Dos::where("waktu",$waktu->waktu)->where("status","approved")->where("status_kunjungan","BERTEMU")->whereDate("created_at",">=",$awal)->whereDate("created_at","<=",$akhir)->count();
                        $jumlah_tidak_bertemu = Dos::where("waktu",$waktu->waktu)->where("status","approved")->where("status_kunjungan","TIDAK BERTEMU")->whereDate("created_at",">=",$awal)->whereDate("created_at","<=",$akhir)->count();
                        $jumlah_kunjungan = Dos::where("waktu",$waktu->waktu)->where("status","approved")->count();

                        $persen_bertemu = $jumlah_bertemu / $jumlah_kunjungan;
                        $persen_bertemu = $persen_bertemu * 100;
                        $persen_bertemu = round($persen_bertemu,2);

                        $persen_tidak_bertemu = $jumlah_tidak_bertemu / $jumlah_kunjungan;
                        $persen_tidak_bertemu = $persen_tidak_bertemu * 100;
                        $persen_tidak_bertemu = round($persen_tidak_bertemu,2);

                        $sum_bertemu += $jumlah_bertemu;
                        $sum_tidak_bertemu += $jumlah_tidak_bertemu;
                        $sum_kunjungan += $jumlah_kunjungan;

                    @endphp
                    <tr>
                        <td>{{$waktu->waktu}}</td>
                        <td>{{$jumlah_bertemu}}</td>
                        <td>{{$jumlah_tidak_bertemu}}</td>
                        <td>{{$jumlah_kunjungan}}</td>
                        <td>{{$persen_bertemu}}%</td>
                        <td>{{$persen_tidak_bertemu}}%</td>
                    </tr>
                    @endforeach
                    @php
                        $persen_sum_bertemu = $sum_bertemu / $sum_kunjungan;
                        $persen_sum_bertemu = $persen_sum_bertemu * 100;
                        $persen_sum_bertemu = round($persen_sum_bertemu,2);

                        $persen_sum_tidak_bertemu = $sum_tidak_bertemu / $sum_kunjungan;
                        $persen_sum_tidak_bertemu = $persen_sum_tidak_bertemu * 100;
                        $persen_sum_tidak_bertemu = round($persen_sum_tidak_bertemu,2);
                    @endphp
                    <tr>
                        <th class="cell-yellow">TOTAL</th>
                        <th class="cell-yellow">{{$sum_bertemu}}</th>
                        <th class="cell-yellow">{{$sum_tidak_bertemu}}</th>
                        <th class="cell-yellow">{{$sum_kunjungan}}</th>
                        <th class="cell-orange">{{$persen_sum_bertemu}}</th>
                        <th class="cell-orange">{{$persen_sum_tidak_bertemu}}</th>
                    </tr>
                </tbody>
              </table>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

      <!-- /.card -->
    </div>
    <!-- /.col -->
    <div class="col-md-5">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Berdasar Hasil Kunjungan</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">

          <div class="table-responsive">
            <table class="table text-nowrap">
                <thead>
                  <tr class="row-purple">
                    <th style="width: 10px">SPV</th>
                    <th>Bertemu</th>
                    <th>Tidak Bertemu</th>
                  </tr>
                </thead>
                <tbody>
                    @php
                        $sum_spv_bertemu = 0;
                        $sum_spv_tidak_bertemu = 0;
                    @endphp
                    @foreach ($spv as $item)
                    <tr>
                        <td>{{$item->name}}</td>
                        <td>{{$item->jumlahBertemu($awal,$akhir)}}</td>
                        <td>{{$item->jumlahTidakBertemu($awal,$akhir)}}</td>

                    </tr>
                    @php
                        $sum_spv_bertemu += $item->jumlahBertemu($awal,$akhir);
                        $sum_spv_tidak_bertemu += $item->jumlahTidakBertemu($awal,$akhir);
                    @endphp
                    @endforeach
                    <tr class="row-purple">
                        <th>
                            Total
                        </th>
                        <th>
                            {{$sum_spv_bertemu}}
                        </th>
                        <th>
                            {{$sum_spv_tidak_bertemu}}
                        </th>
                    </tr>
                </tbody>
            </table>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
      <!-- /.card -->
    </div>
    <!-- /.col -->
  </div>

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Result Prospek (bertemu pelanggan)</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
          <div class="table-responsive">
            <table class="table table-bordered text-nowrap">
                <thead>
                  <tr class="row-purple">
                    <th style="width: 10px">Alasan</th>
                    <th>Jumlah</th>
                  </tr>
                </thead>
                <tbody>

                    @php
                        $total_by_semua_keterangan = 0;
                    @endphp
                    @foreach ($keterangan_kunjungans as $item)
                    <tr>
                        <td>{{$item->keterangan_kunjungan}}</td>
                        <td>{{jumlahByKeteranganKunjungan($item->keterangan_kunjungan,$awal,$akhir)}}</td>
                    </tr>
                    @php
                        $total_by_semua_keterangan += jumlahByKeteranganKunjungan($item->keterangan_kunjungan,$awal,$akhir);
                    @endphp
                    @endforeach
                    <tr class="row-purple">
                        <th>TOTAL</th>
                        <th>{{$total_by_semua_keterangan}}</th>
                    </tr>
                </tbody>
              </table>
          </div>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

      <!-- /.card -->
    </div>
    <!-- /.col -->
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Result Prospek (bertemu pelanggan) Per SPV</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
          <div class="table-responsive">
            <table class="table table-bordered text-nowrap">
                <thead>
                  <tr class="row-purple">
                    <th style="width: 10px">SPV</th>
                    <th>TIDAK BERMINAT</th>
                    <th>SUDAH PAKAI KOMPETITOR</th>
                    <th>PIKIR2 KEMBALI</th>
                    <th>KEBERATAN DENGAN HARGA</th>
                    <th>DEAL</th>
                    <th>SUDAH BERLANGGANAN</th>
                  </tr>
                </thead>
                <tbody>
                    @foreach ($spv as $item)
                        <tr class="text-center">
                            <td>
                                {{$item->name}}
                            </td>
                            <td>
                                {{$item->jumlahByKeteranganKunjungan("TIDAK BERMINAT",$awal,$akhir)}}
                            </td>
                            <td>
                                {{$item->jumlahByKeteranganKunjungan("SUDAH PAKAI KOMPETITOR",$awal,$akhir)}}
                            </td>
                            <td>
                                {{$item->jumlahByKeteranganKunjungan("PIKIR2 KEMBALI",$awal,$akhir)}}
                            </td>
                            <td>
                                {{$item->jumlahByKeteranganKunjungan("KEBERATAN DENGAN HARGA",$awal,$akhir)}}
                            </td>
                            <td>
                                {{$item->jumlahByKeteranganKunjungan("DEAL",$awal,$akhir)}}
                            </td>
                            <td>
                                {{$item->jumlahByKeteranganKunjungan("SUDAH BERLANGGANAN",$awal,$akhir)}}
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
      <!-- /.card -->
    </div>
    <!-- /.col -->
  </div>

<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Atur Filter</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
            <div class="modal-body">
                <form role="form" method="GET" action="{{route('dashDosPerSalesFiltered')}}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Tanggal Mulai</label>
                        <input type="date" name="awal" value="{{$awal}}" class="form-control datepicker" id="awal">
                    </div>
                    <div class="form-group">
                        <label for="name">Tanggal Akhir</label>
                        <input type="date" name="akhir" value="{{$akhir}}" class="form-control datepicker" id="awal">
                    </div>
                    <!-- /.card-body -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-info waves-effect">Simpan</button>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endsection
@section("linkfooter")
@if (session("success"))
    <script>
            $(document).Toasts('create', {
                class: 'bg-success',
                title: 'Berhasil',
                body: '{{session("success")}}'
            })
    </script>
@endif
<script type="text/javascript">
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        function showAlertSuccess(message) {
            $('.swalDefaultSuccess').click(function() {
                Toast.fire({
                    icon: 'success',
                    title: message
                })
            });
        }
</script>
@endsection
