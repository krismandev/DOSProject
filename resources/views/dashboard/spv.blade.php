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
                        <button class="btn btn-warning edit-spv" data-toggle="modal" data-target="#editSpv"
                            data-user_id="{{$spv->id}}"
                            data-name="{{$spv->name}}"
                            data-kode="{{$spv->kode}}"
                            data-agency_name="{{$spv->spv->agency->name}}"
                            data-agency_id="{{$spv->spv->agency->id}}"
                            data-pic_id="{{$spv->spv->pic_id}}"
                            data-pic_name="{{$spv->spv->user_pic->name}}"
                            data-hp="{{$spv->spv->hp}}">
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
                        <label for="kode">Nomor HP</label>
                        <input type="text" name="hp" class="form-control" placeholder="Masukkan nomor HP" value="">
                        <small>Nomor HP akan menjadi password awal akun SPV</small>
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



<div id="editSpv" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit data SPV</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
            <div class="modal-body">
                <form role="form" method="POST" action="{{route('updateSpv')}}">
                    @csrf
                    @method("PATCH")
                      <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="hidden" name="user_id" id="user_id_update">
                        <input type="text" name="name" class="form-control" id="name_update" placeholder="Masukkan nama" value="">
                      </div>
                      <div class="form-group">
                        <label for="kode">Kode</label>
                        <input type="text" name="kode" class="form-control" id="kode_update" placeholder="Masukkan kode / username" value="">
                      </div>
                      <div class="form-group">
                        <label for="kode">Nomor HP</label>
                        <input type="text" name="hp" class="form-control" id="hp_update" placeholder="Masukkan nomor HP" value="">
                      </div>
                      <div class="form-group">
                        <label>Agensi</label>
                        <select class="custom-select" name="agency_id">
                          <option value="" selected id="agency_id_update">Pilih Agensi</option>
                          @foreach ($agencies as $agency)
                          <option value="{{$agency->id}}">{{$agency->name}}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label>PIC</label>
                        <select class="custom-select" name="pic_id">
                          <option value="" id="pic_id_update">Pilih PIC</option>
                          @foreach ($pics as $pic)
                          <option value="{{$pic->id}}">{{$pic->name}}</option>
                          @endforeach
                        </select>
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

@endsection
@section("linkfooter")

<script>
    $(document).ready(function () {
        $(".edit-spv").click(function (e) {
            e.preventDefault();
            let user_id = $(this).data("user_id")
            let name = $(this).data("name")
            let kode = $(this).data("kode")
            let agency_name = $(this).data("agency_name")
            let agency_id = $(this).data("agency_id")
            let pic_id = $(this).data("pic_id")
            let pic_name = $(this).data("pic_name")
            let hp = $(this).data("hp")

            $("#user_id_update").val(user_id)
            $("#name_update").val(name)
            $("#kode_update").val(kode)
            $("#agency_id_update").val(agency_id).html(agency_name)
            $("#pic_id_update").val(pic_id).html(pic_name)
            $("#hp_update").val(hp)
        });


    });
</script>
@endsection
