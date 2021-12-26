@extends("layouts.dashboard.master")
@section("page_title","Data Supervisor")
@section("breadcrumb")
<li class="breadcrumb-item"><a href="{{route("home")}}">Home</a></li>
<li class="breadcrumb-item active">Supervisor</li>
@endsection
@section("title","Supervisor")
@section("content")
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          {{-- <h3 class="card-title">Responsive Hover </h3> --}}

          <div class="card-tools">
            <button type="submit" class="btn btn-primary float-right" data-toggle="modal" data-target="#myModal">Tambah</button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
          <table class="table table-hover text-nowrap">
            <thead>
              <tr>
                <th>Nama</th>
                <th>Kode</th>
                <th>Agensi</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($spvs as $spv)
                <tr>
                    <td>{{$spv->name}}</td>
                    <td>{{$spv->kode}}</td>
                    <td>{{$spv->spv->agency->name}}</td>
                    <td>
                        <button class="btn btn-primary">
                            Edit
                        </button>
                    </td>
                </tr>
                @endforeach
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
                <h4 class="modal-title">Tambah data SPV</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
            <div class="modal-body">
                <form role="form" method="POST" action="{{route('storeSpv')}}">
                    @csrf
                      <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Masukkan nama">
                      </div>
                      <div class="form-group">
                        <label for="kode">Kode</label>
                        <input type="text" name="kode" class="form-control" id="kode" placeholder="Masukkan kode / username">
                      </div>
                      <div class="form-group">
                        <label>Agensi</label>
                        <select class="custom-select" name="agency_id">
                          <option value="">Pilih Agensi</option>
                          @foreach ($agencies as $agency)
                          <option value="{{$agency->id}}">{{$agency->name}}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label>PIC</label>
                        <select class="custom-select" name="pic_id">
                          <option value="">Pilih PIC</option>
                          @foreach ($pics as $pic)
                          <option value="{{$pic->id}}">{{$pic->name}}</option>
                          @endforeach
                        </select>
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
