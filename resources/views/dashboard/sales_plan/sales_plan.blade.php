@extends("layouts.dashboard.master")
@section("title","Sales Plan")
@section("page_title","Sales Plan")
@section("breadcrumb")
<li class="breadcrumb-item"><a href="{{route("home")}}">Home</a></li>
<li class="breadcrumb-item active">Sales Plan</li>
@endsection
@section("content")
<div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          {{-- <h3 class="card-title">Jumlah</h3> --}}
          <div class="card-tools">
            <a href="{{route('createSalesPlan')}}" class="btn btn-primary float-right">Buat Sales Plan</a>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
            <div class="table-responsive">
                <table class="table table-bordered text-nowrap" style="overflow-x: scroll;" id="dttb_sales_plan">
                    <thead>
                      <tr>
                        <th>Tanggal</th>
                        <th>Deskripsi</th>
                        <th>SPV</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales_plans as $item)
                            <tr>
                                <td>{{date('d-M-Y',strtotime($item->tanggal))}}</td>
                                <td>{{Str::limit($item->deskripsi,50)}}</td>
                                <td>
                                    <div class="col-lg-12">
                                        <div class="row">
                                            @foreach ($item->sales_plan_spv as $sls_pln_spv)
                                            <div class="col-md-6">
                                                {{-- <ul> --}}
                                                    <li>{{$sls_pln_spv->spv->user->name}}</li>
                                                    {{-- </ul> --}}
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <a href="#" class="btn btn-primary">Edit</a>
                                    <a href="#" class="btn btn-info lihat-plan" data-toggle="modal" data-target="#lihatPlanModal"
                                        data-tanggal="{{$item->tanggal}}"
                                        data-deskripsi="{{$item->deskripsi}}"
                                        data-sales_plan_kelurahan="{{$item->sales_plan_kelurahan}}"
                                        data-sales_plan_spv="{{$item->sales_plan_spv}}">Lihat</a>
                                    <a href="#" class="btn btn-danger">Hapus</a>
                                </td>
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


@endsection
@section("linkfooter")

<div class="modal fade" id="lihatPlanModal">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Detail Plan</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-2">
                    Tanggal
                </div>
                <div class="col-sm-10" id="showTanggal" id="showDeskripsi">

                </div>
            </div>
            <div class="row">
                <div class="col-sm-2">
                    Deskripsi
                </div>
                <div class="col-sm-10" id="showDeskripsi">

                </div>
            </div>
            <div class="row mt-3">
                <div class="col-sm-2">
                    SPV
                </div>
                <div class="col-sm-10" id="showSpv">

                </div>
            </div>
            <div class="row mt-3">
                <div class="col-sm-2">
                    Kelurahan
                </div>
                <div class="col-sm-10" id="showKelurahan">

                </div>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

<script>
    $(document).ready(function () {
        $("#dttb_sales_plan").DataTable();

        $(".lihat-plan").click(function (e) {
            e.preventDefault();
            const tanggal = $(this).data('tanggal')
            const deskripsi = $(this).data('deskripsi')
            const sales_plan_kelurahan = $(this).data('sales_plan_kelurahan')
            const sales_plan_spv = $(this).data('sales_plan_spv')


            $("#showTanggal").html(tanggal)
            $("#showDeskripsi").html(deskripsi)

            let elemKelurahan
            elemKelurahan ='<div class="col-lg-12">'
                elemKelurahan += '<div class="row">'
                sales_plan_kelurahan.forEach(sls_pln_kelurahan => {
                    elemKelurahan += ' <div class="col-md-6">'
                        elemKelurahan += '<li> '+sls_pln_kelurahan.kelurahan.gab+' </li>'
                    elemKelurahan += ' </div>'
                });
                elemKelurahan += ' </div>'
            elemKelurahan += ' </div>'

            $("#showKelurahan").append(elemKelurahan)

            let elemSpv
            elemSpv ='<div class="col-lg-12">'
                elemSpv += '<div class="row">'
                sales_plan_spv.forEach(sls_pln_spv => {
                    elemSpv += ' <div class="col-md-6">'
                        elemSpv += '<li> '+sls_pln_spv.spv.user.name+' </li>'
                    elemSpv += ' </div>'
                });
                elemSpv += ' </div>'
            elemSpv += ' </div>'

            $("#showSpv").append(elemSpv)


        });

    });
</script>

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
