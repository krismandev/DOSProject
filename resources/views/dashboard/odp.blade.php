@extends("layouts.dashboard.master")
@section("title","Data ODP")
@section("page_title","Data ODP")
@section("breadcrumb")
<li class="breadcrumb-item"><a href="{{route("home")}}">Home</a></li>
<li class="breadcrumb-item active">Data ODP</li>
@endsection
@section("content")
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Jumlah</h3>
          <div class="card-tools">
            <button type="submit" class="btn btn-primary float-right" data-toggle="modal" data-target="#myModal">Import</button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <div class="table-responsive">
                <table class="table table-bordered text-nowrap" style="overflow-x: scroll;">
                    <thead>
                      <tr>
                        <th>Nama ODP</th>
                        <th>STO</th>
                        <th>Lat</th>
                        <th>Long</th>
                        <th>Alamat</th>
                        <th>Merk OLT</th>
                        <th>Tanggal Go Live</th>
                        <th>ID SW</th>
                        <th>Project</th>
                        <th>ID Valins</th>
                        <th>Label Barcode ODP</th>
                        <th>Mitra</th>
                        <th>Kendala</th>
                        <th>Permintaan</th>

                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($odps as $item)
                            <tr>
                                <td>{{$item->nama_odp}}</td>
                                <td>{{$item->sto}}</td>
                                <td>{{$item->lat}}</td>
                                <td>{{$item->long}}</td>
                                <td>{{$item->alamat}}</td>
                                <td>{{$item->merk_olt}}</td>
                                <td>{{$item->tanggal_go_live}}</td>
                                <td>{{$item->id_sw}}</td>
                                <td>{{$item->project}}</td>
                                <td>{{$item->id_valins}}</td>
                                <td>{{$item->label_barcode_odp}}</td>
                                <td>{{$item->mitra}}</td>
                                <td>{{$item->kendala}}</td>
                                <td>{{$item->permintaan}}</td>

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
                <form role="form" method="POST" action="{{route('importOdp')}}" enctype="multipart/form-data">
                    @csrf
                      <div class="form-group">
                        <label for="name">File</label>
                        <input type="file" name="file" class="form-control">
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
