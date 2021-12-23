@extends("layouts.dashboard.master")
@section("page_title","Dashboard DOS / SPV")
@section("breadcrumb")
<li class="breadcrumb-item"><a href="{{route("home")}}">Home</a></li>
<li class="breadcrumb-item active">Dashboard DOS / SPV</li>
@endsection
@section("title","Dashboard DOS / SPV")
@section("content")
<div class="row">
    <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Bordered Table</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th style="width: 10px">SPV</th>
                  <th>Jumlah SF</th>
                  <th>Target</th>
                  <th>Bertemu</th>
                  <th>Tidak Bertemu</th>
                  <th>Total</th>
                  <th>Ach</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($spv as $item)
                <tr>
                 <td>
                    {{$item->name}}
                 </td>
                 <td>
                    {{$item->jumlahSf()}}
                 </td>
                 <td>
                    {{$item->target($awal,$akhir)}}
                 </td>
                 <td>
                    {{$item->jumlahBertemu($awal,$akhir)}}
                 </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
          <div class="card-footer clearfix">
            <ul class="pagination pagination-sm m-0 float-right">
              <li class="page-item"><a class="page-link" href="#">«</a></li>
              <li class="page-item"><a class="page-link" href="#">1</a></li>
              <li class="page-item"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"><a class="page-link" href="#">»</a></li>
            </ul>
          </div>
        </div>
        <!-- /.card -->
        <!-- /.card -->
    </div>
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
<script type="text/javascript">
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        function showAlertSuccess(message) {
            $('.swalDefaultSuccess').click(function() {
                Toast.fire({
                    icon: 'success',
                    title: message
                })
            });
        }
</script>
@endsection
