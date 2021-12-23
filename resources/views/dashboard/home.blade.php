@extends("layouts.dashboard.master")
@section("title","Home")
@section("content")
<div class="row">
    <div class="col-md-3 col-sm-6 col-12">
      <a href="{{route("dashDosPerSpv")}}">
        <div class="info-box">
            <span class="info-box-icon bg-info"><i class="far fa-envelope"></i></span>

            <div class="info-box-content">
              {{-- <span class="info-box-text">Messages</span> --}}
              <span class="info-box-number">DOS Per SPV</span>
            </div>
            <!-- /.info-box-content -->
        </div>
          <!-- /.info-box -->
      </a>
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-12">
      <div class="info-box">
        <span class="info-box-icon bg-success"><i class="far fa-flag"></i></span>

        <div class="info-box-content">
          {{-- <span class="info-box-text">Bookmarks</span> --}}
          <span class="info-box-number">DOS Per Sales</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-12">
      <div class="info-box">
        <span class="info-box-icon bg-warning"><i class="far fa-copy"></i></span>

        <div class="info-box-content">
          {{-- <span class="info-box-text">Uploads</span> --}}
          <span class="info-box-number">Evaluasi DOS SF</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
    {{-- <div class="col-md-3 col-sm-6 col-12">
      <div class="info-box">
        <span class="info-box-icon bg-danger"><i class="far fa-star"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Likes</span>
          <span class="info-box-number">93,139</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
  </div> --}}
@endsection
