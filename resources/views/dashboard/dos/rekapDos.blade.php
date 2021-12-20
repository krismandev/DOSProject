@extends("layouts.dashboard.master")
@section("title","Rekap DOS")
@section("page_title","Rekap DOS")
@section("breadcrumb")
<li class="breadcrumb-item"><a href="{{route("home")}}">Home</a></li>
<li class="breadcrumb-item active">Rekap DOS</li>
@endsection
@section("content")
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          {{-- <h3 class="card-title">Responsive Hover </h3> --}}

          <div class="card-tools">
            <h5>Pilih SPV Terlebih dahulu</h5>
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
                @foreach ($spvs as $user)
                <tr>
                    <td>{{$user->name}}</td>
                    <td>{{$user->kode}}</td>
                    <td>{{$user->spv->agency->name}}</td>
                    <td>
                        <a href="{{route("getRekapDosBySpv",$user->id)}}" class="btn btn-primary">
                            Buka
                        <a/>
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
@endsection
@section("linkfooter")

@endsection
