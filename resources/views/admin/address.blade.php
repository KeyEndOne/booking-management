@extends('admin.layout')
@section('content')


<div>
    <button id="btn-add" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Tạo mới
    </button>
    @if (count($address) > 0)
    <table class="table table-bordered table-striped table-hover dataTable no-footer">
        <thead class="isd-table-header">
            <tr>
                <th class="text-center">Mã địa chỉ</th>
                <th class="text-center">Tên địa chỉ</th>
                <th class="text-center">Chức năng</th>
            </tr>
        </thead>
        <tbody>
            @foreach($address as $d)
            <tr>
                <td class="text-center">{{($d->AddressId)}}</td>
                <td class="text-center">{{($d->AddressName)}}</td>
                <td class="text-center">
                    <button id="{{$d->AddressId}}" value="{{$d->AddressName}}" type="button" class="btn btn-primary btn-edit" data-toggle="modal" data-target="#exampleModal">
                        Sửa
                    </button>
                    <button id="{{$d->AddressId}}" class="btn btn-danger btn-del">Xóa</button>
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot></tfoot>
    </table>
    @else
    <p>K có kết quả nào tìm thấy</p>
    @endif
</div>
<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Model</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addressForm" class="form-horizontal">
                    <input type="hidden" id="AddressId" name="AddressId">
                    <div class="form-group">
                        <label class="col-sm-12 control-label">Address Name</label>
                        <div class="col-sm-12">
                            <input id="AddressName" name="AddressName" required="" class="form-control"></input>
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="save" type="button" class="btn btn-primary">Save changes</button>
                <button id="saveedit" type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(".btn-del").click(function() {
        if (confirm('Bạn có chắc muốn xóa')) {
            var id = this.id;
            // console.log(lstSeat.length);
            var data = new FormData();
            data.append('AddressId', id);
            data.append('_token', '{{ csrf_token() }}');
            // console.log(...data);
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "X-Requested-With": "XMLHttpRequest"
                }
            });
            //call ajax create ticket
            $.ajax({
                url: "{{ route('deladdress') }}",
                processData: false,
                contentType: false,
                type: 'post',
                data: data,
                success: function(response) {
                    alert("Xóa thành công");
                    location.reload();
                },
                error: function(response) {
                    console.log("Lỗi rồi");
                }
            });
        }
    });

    $("#save").click(function() {
        var data = new FormData();
        var name = $("#AddressName").val();
        data.append('AddressName', name);
        data.append('_token', '{{ csrf_token() }}');
        $.ajax({
            url: "{{ route('createaddress') }}",
            processData: false,
            contentType: false,
            type: 'post',
            data: data,
            success: function(response) {
                alert("Thêm mới thành công");
                location.reload();
            },
            error: function(response) {
                console.log("Lỗi rồi");
            }
        });
    });
    $("#saveedit").click(function() {

        var data = new FormData();
        var name = $("#AddressName").val();
        var id = $("#AddressId").val();
        data.append('AddressId', id);
        data.append('AddressName', name);
        data.append('_token', '{{ csrf_token() }}');
        $.ajax({
            url: "{{ route('editaddress') }}",
            processData: false,
            contentType: false,
            type: 'post',
            data: data,
            success: function(response) {
                alert("Sửa thành công");
                location.reload();
            },
            error: function(response) {
                console.log("Lỗi rồi");
            }
        });
    });
    $(".btn-edit").click(function() {
        $("#save").css({
            display: 'none'
        });
        $("#saveedit").css({
            display: 'block'
        });
        $("#AddressId").val(this.id);
        $("#AddressName").val(this.value);
    });
    $("#btn-add").click(function() {
        $("#save").css({
            display: 'block'
        });
        $("#saveedit").css({

            display: 'none'
        });
        $("#AddressId").val();
        $("#AddressName").val();
    });
</script>

@stop