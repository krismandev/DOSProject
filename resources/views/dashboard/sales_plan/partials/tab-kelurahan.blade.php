<table class="table table-dr-subscription">
    <tbody>
        <tr>
            <td>
                {{-- <input autocomplete="off" class="form-control url-validate" value="" type="text" name="kelurahan_id[]"> --}}
                <select class="form-control custom-kelurahan-id" name="kelurahan_id[]">
                    <option value="" selected>Pilih Kelurahan</option>
                    @foreach ($kelurahans as $item)
                        <option value="{{$item->id}}">{{$item->gab}}</option>
                    @endforeach
                </select>
                <span class="url-validate-result text-danger"></span>
            </td>
            <td>
                <button class="btooltip btn btn-text text-danger btn-remove-row" type="button" title="Remove Row"><i data-feather="x"></i>Hapus</button>
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <a title="Add New Row" href="#" class="btooltip btn btn-block btn-white btn-add-row" style="background:#eee;" data-target="#template_row_kelurahan">
                    <i data-feather="plus"></i> Tambah Kelurahan
                </a>
            </td>
        </tr>
    </tfoot>
</table>
<template id="template_row_kelurahan">
    <tr>
        <td>
            {{-- <input autocomplete="off" class="form-control url-validate" value="" type="text" name="kelurahan_id[]"> --}}
            <select class="form-control custom-kelurahan-id" name="kelurahan_id[]">
                <option value="" selected>Pilih Kelurahan</option>
                @foreach ($kelurahans as $item)
                    <option value="{{$item->id}}">{{$item->gab}}</option>
                @endforeach
            </select>
            <span class="url-validate-result text-danger"></span>
        </td>
        <td>
            <button class="btooltip btn btn-text text-danger btn-remove-row" type="button" title="Hapus"><i data-feather="x"></i> Hapus</button>
        </td>
    </tr>
</template>

<script>
    // $(document).ready(function () {
    // // $(function () {
    //     $("select").select2();
    //     $("select[name='kelurahan_id[]']").select2();
    // })
</script>
