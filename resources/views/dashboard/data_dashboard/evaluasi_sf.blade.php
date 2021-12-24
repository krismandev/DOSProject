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
                    <th style="width: 10px">Range Waktu</th>
                    <th>Bertemu</th>
                    <th>Tidak Bertemu</th>
                    <th>Tot Visit</th>
                    <th>Bertemu</th>
                    <th>Tidak Bertemu</th>
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
                        $jumlah_bertemu = Dos::where("waktu",$waktu->waktu)->where("status","approved")->where("status_kunjungan","BERTEMU")->count();
                        $jumlah_tidak_bertemu = Dos::where("waktu",$waktu->waktu)->where("status","approved")->where("status_kunjungan","TIDAK BERTEMU")->count();
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
                        <th>TOTAL</th>
                        <th>{{$sum_bertemu}}</th>
                        <th>{{$sum_tidak_bertemu}}</th>
                        <th>{{$sum_kunjungan}}</th>
                        <th>{{$persen_sum_bertemu}}</th>
                        <th>{{$persen_sum_tidak_bertemu}}</th>
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
        <div class="card-body p-0">
          <table class="table">
            <thead>
              <tr>
                <th style="width: 10px">#</th>
                <th>Task</th>
                <th>Progress</th>
                <th style="width: 40px">Label</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1.</td>
                <td>Update software</td>
                <td>
                  <div class="progress progress-xs">
                    <div class="progress-bar progress-bar-danger" style="width: 55%"></div>
                  </div>
                </td>
                <td><span class="badge bg-danger">55%</span></td>
              </tr>
              <tr>
                <td>2.</td>
                <td>Clean database</td>
                <td>
                  <div class="progress progress-xs">
                    <div class="progress-bar bg-warning" style="width: 70%"></div>
                  </div>
                </td>
                <td><span class="badge bg-warning">70%</span></td>
              </tr>
              <tr>
                <td>3.</td>
                <td>Cron job running</td>
                <td>
                  <div class="progress progress-xs progress-striped active">
                    <div class="progress-bar bg-primary" style="width: 30%"></div>
                  </div>
                </td>
                <td><span class="badge bg-primary">30%</span></td>
              </tr>
              <tr>
                <td>4.</td>
                <td>Fix and squish bugs</td>
                <td>
                  <div class="progress progress-xs progress-striped active">
                    <div class="progress-bar bg-success" style="width: 90%"></div>
                  </div>
                </td>
                <td><span class="badge bg-success">90%</span></td>
              </tr>
            </tbody>
          </table>
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
