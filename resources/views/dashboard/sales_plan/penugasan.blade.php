@extends("layouts.dashboard.master")
@section("title","Sales Plan")
@section("page_title","Sales Plan")
@section("breadcrumb")
<li class="breadcrumb-item"><a href="{{route("home")}}">Home</a></li>
<li class="breadcrumb-item active">Sales Plan</li>
@endsection
@section("content")
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          {{-- <h3 class="card-title">Jumlah</h3> --}}
          <div class="card-tools">
            <button type="submit" class="btn btn-primary float-right" data-toggle="modal" data-target="#myModal">Buat Penugasan</button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <div class="table-responsive">
                <table class="table table-bordered text-nowrap" style="overflow-x: scroll;">
                    <thead>
                      <tr>
                        <th>SPV</th>
                        <th>ODC</th>
                        <th>ODP</th>
                        <th>Keterangan</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($penugasans as $item)
                            <tr>
                                <td>{{$item->spv->user->name}}</td>
                                <td>{{$item->odc->nama_odc}}</td>
                                <td>{{$item->odp}}</td>
                                <td>{{$item->keterangan}}</td>
                                <td>{{$item->tanggal_mulai}}</td>
                                <td>{{$item->tanggal_selesai}}</td>
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

<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Import Data ODP</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
            <div class="modal-body">
                <form role="form" method="POST" action="{{route('storePenugasan')}}">
                    @csrf
                    <div class="form-group">
                        <label>Supervisor</label>
                        <select class="custom-select" name="spv_id">
                          <option value="">Pilih Supervisor</option>
                          @foreach ($spvs as $spv)
                          <option value="{{$spv->id}}">{{$spv->user->name}}</option>
                          @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>ODC</label>
                        <select class="custom-select" name="odc_id">
                          <option value="">Pilih ODC</option>
                          @foreach ($odcs as $odc)
                          <option value="{{$odc->id}}">{{$odc->nama_odc}}</option>
                          @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">ODP</label>
                        <textarea name="odp" rows="7" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="name">Keterangan</label>
                        <textarea name="keterangan" rows="7" class="form-control"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="kode">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="kode">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="form-control">
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

@if ($errors->any())
    @php
        $message = '';
    @endphp
    @foreach ($errors->all() as $error)
        @php
            $message .= $error.", ";
        @endphp
    @endforeach

    <script>
        $(document).Toasts('create', {
            class: 'bg-danger',
            title: 'Error',
            body: '{{$message}}'
        })
    </script>

@endif
@endsection
