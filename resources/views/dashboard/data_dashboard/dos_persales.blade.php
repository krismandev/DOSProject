@extends("layouts.dashboard.master")
@section("page_title","Dashboard DOS / Sales")
@section("breadcrumb")
<li class="breadcrumb-item"><a href="{{route("home")}}">Home</a></li>
<li class="breadcrumb-item">Dashboard DOS</li>
<li class="breadcrumb-item active"> Per Sales</li>
@endsection
@section("title","Dashboard DOS / SPV")
@section("content")
<div class="row">
    <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Supervisor: {{$spv_selected->name}}</h3> <br>
            <h3 class="card-title">Tanggal Mulai: {{$awal}} | Tanggal Akhir: {{$akhir}}</h3>
            <button type="submit" class="btn btn-primary float-right" data-toggle="modal" data-target="#myModal">Ubah Tanggal</button>

          </div>
          {{-- <div class="card-tools">
            <button type="submit" class="btn btn-primary float-right" data-toggle="modal" data-target="#myModal">Ubah Tanggal</button>
          </div> --}}
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <div class="table-responsive">
                <table class="table table-bordered text-nowrap">
                    <thead>
                      <tr>
                        <th style="width: 10px">Nama SF</th>
                        <th>KKontak SF</th>
                        <th>Target</th>
                        <th>Bertemu</th>
                        <th>Tidak Bertemu</th>
                        <th>Total</th>
                        <th>Ach</th>
                      </tr>
                    </thead>
                    <tbody>

                    @php

                    $jumlah_target = 0;
                    $jumlah_bertemu = 0;
                    $jumlah_tidak_bertemu = 0;
                    $jumlah_kunjungan = 0;

                    @endphp
                      @foreach ($sales_forces as $item)
                          <tr>
                                <td>
                                    {{$item->name}}
                                </td>
                                <td>
                                    {{$item->kode}}
                                </td>
                                <td>
                                    {{$item->target($awal,$akhir)}}
                                </td>
                                <td>
                                    {{$item->jumlahBertemu($awal,$akhir)}}
                                </td>
                                <td>
                                    {{$item->jumlahTidakBertemu($awal,$akhir)}}
                                </td>
                                <td>
                                    {{$item->jumlahKunjungan($awal,$akhir)}}
                                 </td>
                                 @if ($item->persentase($awal,$akhir) < 75)
                                 <td style="background-color: red; color:white;">
                                    {{$item->persentase($awal,$akhir)}} %
                                 </td>
                                 @else
                                 <td style="background-color: green; color:white;">
                                    {{$item->persentase($awal,$akhir)}} %
                                 </td>
                                 @endif
                          </tr>
                          @php
                            $jumlah_target += $item->target($awal,$akhir);
                            $jumlah_bertemu += $item->jumlahBertemu($awal,$akhir);
                            $jumlah_tidak_bertemu += $item->jumlahTidakBertemu($awal,$akhir);
                            $jumlah_kunjungan += $item->jumlahKunjungan($awal,$akhir);

                        @endphp
                      @endforeach
                        <tr>
                            <th colspan="2">
                                Total
                            </th>
                            <th>
                                {{$jumlah_target}}
                            </th>
                            <th>
                                {{$jumlah_bertemu}}
                            </th>
                            <th>
                                {{$jumlah_tidak_bertemu}}
                            </th>
                            <th>
                                {{$jumlah_kunjungan}}
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
                        <label for="name">Pilih Supervisor</label>
                        <select class="form-control" name="spv_id">
                            <option value="{{$spv_selected->id}}">{{$spv_selected->name}}</option>
                            @foreach ($spv as $item)
                            <option value="{{$item->id}}">{{$item->name}}</option>
                            @endforeach
                        </select>
                    </div>
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
