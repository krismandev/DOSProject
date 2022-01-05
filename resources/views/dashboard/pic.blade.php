@extends("layouts.dashboard.master")
@section("page_title","Data PIC")
@section("breadcrumb")
<li class="breadcrumb-item"><a href="{{route("home")}}">Home</a></li>
<li class="breadcrumb-item active">PIC</li>
@endsection
@section("title","PIC")
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
                    <th>Username</th>
                    <th>Supervisor</th>
                    <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @if ($pics != null)
                @foreach ($pics as $pic)
                <tr>
                    <td>{{$pic->name}}</td>
                    <td>{{$pic->kode}}</td>
                    <td>
                        <ul>
                        @foreach ($pic->spv_pic as $item)

                            <li>
                                {{$item->user->name}}
                            </li>

                        @endforeach
                        </ul>
                    </td>
                    <td>
                        <button class="btn btn-warning edit-pic" data-toggle="modal" data-target="#editPic"
                        data-user_id="{{$pic->id}}"
                        data-name="{{$pic->name}}"
                        data-kode="{{$pic->kode}}"
                        >Edit</button>
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
                <h4 class="modal-title">Tambah data PIC</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
            <div class="modal-body">
                <form role="form" method="POST" action="{{route('storePic')}}">
                    @csrf
                      <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Masukkan nama">
                      </div>
                      <div class="form-group">
                        <label for="kode">Kode</label>
                        <input type="text" name="kode" class="form-control" id="kode" placeholder="Masukkan kode / kkontak">
                      </div>
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

<div id="editPic" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit data PIC</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
            <div class="modal-body">
                <form role="form" method="POST" action="{{route('updatePic')}}">
                    @csrf
                    @method("PATCH")
                      <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="hidden" name="user_id" id="user_id_update">
                        <input type="text" name="name" class="form-control" id="name_update" placeholder="Masukkan nama">
                      </div>
                      <div class="form-group">
                        <label for="kode">Kode</label>
                        <input type="text" name="kode" class="form-control" id="kode_update" placeholder="Masukkan kode / kkontak">
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


<script>
    $(document).ready(function () {
        $(".edit-pic").click(function (e) {
            e.preventDefault();
            const user_id = $(this).data("user_id")
            const name = $(this).data("name")
            const kode = $(this).data("kode")

            $("#user_id_update").val(user_id)
            $("#name_update").val(name)
            $("#kode_update").val(kode)

        });
    });
</script>

@endsection
