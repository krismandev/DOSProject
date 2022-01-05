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
                    <td>{{$sf->sales_force->ktp}}</td>
                    <td>{{$sf->sales_force->spv->user->name}}</td>
                    <td>{{$sf->sales_force->status}}</td>
                    <td>
                        <button class="btn btn-warning edit-sf" data-toggle="modal" data-target="#editSf"
                        data-user_id="{{$sf->id}}"
                        data-name="{{$sf->name}}"
                        data-kode="{{$sf->kode}}"
                        data-spv_id="{{$sf->sales_force->spv_id}}"
                        data-spv_name="{{$sf->sales_force->spv->user->name}}"
                        data-hp="{{$sf->sales_force->hp}}"
                        data-ktp="{{$sf->sales_force->ktp}}"
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

<div id="editSf" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit data SF</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
            <div class="modal-body">
                <form role="form" method="POST" action="{{route('updateSf')}}">
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
                      <div class="form-group">
                        <label>Supervisor</label>
                        <select class="custom-select" name="spv_id">
                          <option value="" id="spv_id_update">Pilih Supervisor</option>
                          @foreach ($spvs as $spv)
                          <option value="{{$spv->id}}">{{$spv->name}}</option>
                          @endforeach
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="hp">HP</label>
                        <input type="text" name="hp" class="form-control" id="hp_update" placeholder="Masukkan nomor hp">
                      </div>
                      <div class="form-group">
                        <label for="ktp">No. KTP</label>
                        <input type="text" name="ktp" class="form-control" id="ktp_update" placeholder="Masukkan nomor ktp">
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
        $(".edit-sf").click(function (e) {
            e.preventDefault();
            const user_id = $(this).data("user_id")
            const name = $(this).data("name")
            const kode = $(this).data("kode")
            const spv_id = $(this).data("spv_id")
            const spv_name = $(this).data("spv_name")
            const hp = $(this).data("hp")
            const ktp = $(this).data("ktp")

            console.log(spv_id);
            $("#user_id_update").val(user_id)
            $("#name_update").val(name)
            $("#kode_update").val(kode)
            $("#spv_id_update").val(spv_id).html(spv_name)
            $("#hp_update").val(hp)
            $("#ktp_update").val(ktp)


        });
    });
</script>

@endsection
