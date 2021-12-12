@extends("layouts.dashboard.master")
@section("page_title","Data Sales Force")
@section("breadcrumb")
<li class="breadcrumb-item"><a href="{{route("home")}}">Home</a></li>
<li class="breadcrumb-item active">Sales Force</li>
@endsection
@section("title","Sales Force")
@section("content")
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <div class="card-tools">
            <button type="submit" class="btn btn-primary float-right" data-toggle="modal" data-target="#myModal">Tambah</button>
          </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap">
              <thead>
                <tr>
                    <th>Nama</th>
                    <th>KKontak</th>
                    <th>Agensi</th>
                    <th>HP</th>
                    <th>Supervisor</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @if ($sfs != null)
                @foreach ($sfs as $sf)
                <tr>
                    <td>{{$sf->name}}</td>
                    <td>{{$sf->kode}}</td>
                    <td>{{$sf->sales_force->spv->agency->name}}</td>
                    <td>{{$sf->sales_force->hp}}</td>
                    <td>{{$sf->sales_force->spv->user->name}}</td>
                    <td>{{$sf->sales_force->status}}</td>
                    <td>
                        <button class="btn btn-warning">Edit</button>
                    </td>
                </tr>
                @endforeach
                @endif
              </tbody>
            </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
  </div>


<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah data SF</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
            <div class="modal-body">
                <form role="form" method="POST" action="{{route('storeSf')}}">
                    @csrf
                      <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Masukkan nama">
                      </div>
                      <div class="form-group">
                        <label for="kode">Kode</label>
                        <input type="text" name="kode" class="form-control" id="kode" placeholder="Masukkan kode / kkontak">
                      </div>
                      <div class="form-group">
                        <label>Supervisor</label>
                        <select class="custom-select" name="spv_id">
                          <option value="">Pilih Supervisor</option>
                          @foreach ($spvs as $spv)
                          <option value="{{$spv->id}}">{{$spv->name}}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="hp">HP</label>
                        <input type="text" name="hp" class="form-control" id="hp" placeholder="Masukkan nomor hp">
                      </div>
                      <div class="form-group">
                        <label for="ktp">No. KTP</label>
                        <input type="text" name="ktp" class="form-control" id="ktp" placeholder="Masukkan nomor ktp">
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
            title: 'Berhasil',
            body: '{{$message}}'
        })
    </script>

@endif

@endsection
