@extends("layouts.dashboard.master")
@section("page_title","Buat Plan")
@section('linkheader')
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

@endsection
@section("breadcrumb")
<li class="breadcrumb-item"><a href="{{route("home")}}">Home</a></li>
<li class="breadcrumb-item"><a href="{{route("getSalesPlan")}}">Sales Plan</a></li>
<li class="breadcrumb-item active">Buat Plan</li>
@endsection
@section("title","Buat Plan")
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
            <form class="form-horizontal" action="{{route('storeSalesPlan')}}" method="post">
                @csrf
                <div class="card-body">
                  <div class="form-group row">
                    <label for="inputTanggal" class="col-sm-2 col-form-label">Tanggal</label>
                    <div class="col-sm-10">
                      <input type="date" value="{{date('Y-m-d')}}" class="form-control" id="inputTanggal" name="tanggal">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputDeskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputDeskripsi" name="deskripsi">
                    </div>
                  </div>
                  <div class="form-group row">
                        <label for="inputDeskripsi" class="col-sm-2 col-form-label">Kelurahan</label>
                        <div class="col-sm-10 list-kelurahan">
                            @include('dashboard.sales_plan.partials.tab-kelurahan')
                            {{-- <select class="form-control custom-kelurahan-id">
                                <option value="" selected>Pilih Kelurahan</option>
                                @foreach ($kelurahans as $item)
                                    <option value="{{$item->id}}">{{$item->gab}}</option>
                                @endforeach
                            </select> --}}
                            {{-- <div class="form-group row baris">
                                <div class="col-md-6 col-sm-6">
                                    <select class="form-control custom-kelurahan-id" name="kelurahan_id[]">
                                        <option value="" selected>Pilih Kelurahan</option>
                                        @foreach ($kelurahans as $item)
                                            <option value="{{$item->id}}">{{$item->gab}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4 float-right">
                                    <button class="btn btn-danger" id="hapus-row"><i class="fa fa-trash"></i></button>
                                </div>
                            </div> --}}
                            {{-- <div class="row">
                                <div class="col-md-">
                                    <a title="Add New Row" href="#" class="btooltip btn btn-block btn-white btn-add-row" style="background:#eee;" data-target="#template_row_kelurahan">
                                        <i data-feather="plus"></i> Add Row
                                    </a>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputDeskripsi" class="col-sm-2 col-form-label">Pilih SPV</label>
                            <div class="col-sm-10">
                                <div class="col-sm-6">
                                    <!-- checkbox -->
                                    <div class="form-group">
                                        @foreach ($spvs as $item)
                                        <div class="custom-control custom-checkbox">
                                            <input class="custom-control-input" type="checkbox" name="spv_id[]" id="chechboxspv-{{$item->id}}" value="{{$item->id}}">
                                            <label for="chechboxspv-{{$item->id}}" class="custom-control-label">{{$item->name}}</label>
                                        </div>
                                        @endforeach
                                    </div>
                                  </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-info">Simpan</button>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
  </div>


@endsection
@section("linkfooter")
<script type="text/javascript">
// $("select").select2();
// $("select[name='kelurahan_id[]']").select2();
$(document).ready(function () {
    // $(function () {
    // });

    $(document).on('click', ".btn-add-row", function(e){
		e.preventDefault();

		// check row limit
		// maxloop = $(this).closest('table').attr('data-maxloop');
		// if(typeof maxloop != "undefined"){
		// 	if(parseInt(maxloop) <= $(this).closest('table').find('tbody tr').length){
		// 		// cannot insert row more than maxloop variable
		// 		toastr.warning("Maximum " + maxloop + " data allowed in this part");
		// 		return;
		// 	}
		// }

		targetClone = $(this).closest('table').find('tbody tr:last-child');
		target = $(this).attr('data-target');
		cln = $(target).html();

		targetClone.after(cln);
		targetClone.next('tr').find('input:first').focus();
		// feather.replace();
		$(".bs-tooltip").tooltip();
        $("select").select2();


	});

    $(document).on('click', '.btn-remove-row', function(e){
		e.preventDefault();
		if($(this).closest('tbody').find('tr').length > 1){
			$(this).tooltip('hide');
			$(this).closest('tr').remove();
		}
		else{
			$(this).closest('tr').find('input').val('');
			$(this).closest('tr').find('input:first').focus();
		}
	});

    // $(".btn-tambah-row").click(function (e) {
    //     e.preventDefault();
    //     const url = "/sales_plan/add-kelurahan";
    //     try {
    //         $.ajax({
    //             type: "get",
    //             url: url,
    //             dataType: "json",
    //             success: function (response) {
    //                 $("select").select2();

    //                 let row = ''
    //                 row += '<div class="form-group row baris">'
    //                     row += '<div class="col-md-6 col-sm-6">'
    //                       row += '<select class="form-control custom-kelurahan-id" name="kelurahan_id[]">'
    //                         row += '<option value="" selected>Pilih Kelurahan</option>'
    //                         response.data.forEach(element => {
    //                           row += '<option value="'+element.id+'" selected>'+element.gab+'</option>'
    //                         });
    //                       row += '</select>'
    //                     row += '</div>'
    //                     row += '<div class="col-md-4 float-right">'
    //                       row += '<button class="btn btn-danger" id="hapus-row"><i class="fa fa-trash"></i></button>'
    //                     row += '</div>'
    //                 row += '</div>'

    //                 $('.list-kelurahan').append(row);
    //                 $("select").select2();
    //             //   $("select[name='kelurahan_id[]']").select2();

    //             }
    //         });
    //     } catch (error) {
    //         alert(error.message)
    //     }
    // });
});
</script>
@endsection
