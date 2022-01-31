@extends("layouts.dashboard.master")
@section("page_title","Data Agency")
@section("breadcrumb")
<li class="breadcrumb-item"><a href="{{route("home")}}">Home</a></li>
<li class="breadcrumb-item active">Agency</li>
@endsection
@section("title","Agency")
@section("content")
<div class="row">
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
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
                  <th>#</th>
                  <th>Nama Agency</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                @if ($agencies != null)
                @foreach ($agencies as $agency)
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{$agency->name}}</td>
                  <td>
                      <button class="btn btn-warning edit-agency"
                      data-toggle="modal" data-target="#editModal"
                      data-agency_id="{{$agency->id}}"
                      data-name="{{$agency->name}}">Edit</button>
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
                <h4 class="modal-title">Tambah data agency</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
            <div class="modal-body">
                <form role="form" method="POST" action="{{route('storeAgency')}}">
                    @csrf
                      <div class="form-group">
                        <label for="name">Nama Agensi</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Masukkan nama">
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
<div id="editModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit data Agency</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
            <div class="modal-body">
                <form role="form" method="POST" action="{{route('updateAgency')}}">
                    @csrf @method("PATCH")
                      <div class="form-group">
                        <label for="name">Nama Agensi</label>
                        <input type="hidden" name="agency_id" id="agency_id_update">
                        <input type="text" name="name" class="form-control" id="name_update" placeholder="Masukkan nama">
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
<script type="text/javascript">
    $(".edit-agency").click(function (e) {
        const agency_id = $(this).data("agency_id")
        const agency_name = $(this).data("name")

        $("#name_update").val(agency_name)
        $("#agency_id_update").val(agency_id)

    });
</script>
@endsection
