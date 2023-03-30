@extends('admin.layout')
@section('content')


<div>
    <button id="btn-add" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
        Tạo mới
    </button>
    @if (count($tour) > 0)
    <div id="searchresult">
        <table class="table table-bordered table-striped table-hover dataTable no-footer">
            <thead class="isd-table-header">
                <tr>
                    <th class="text-center">Id</th>
                    <th class="text-center">Thời gian đi</th>
                    <th class="text-center">Từ -> đến</th>
                    <th class="text-center">Giá vé</th>
                    <th class="text-center">Chức năng</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tour as $t)
                <tr>
                    <th class="text-center">{{$t->TourId}}</th>
                    <td class="text-center">{{ Carbon\Carbon::parse($t->FromHour)->format('H:i:s d-m-Y '); }} -> {{ Carbon\Carbon::parse($t->ToHour)->format('H:i:s d-m-Y '); }}</td>
                    <td class="text-center">{{$t->FromAddress}} -> {{$t->ToAddress}}</td>
                    <td class="text-center">{{number_format($t->Price,0 )}} VNĐ</td>
                    <td class="text-center">
                        <button id="{{$t->TourId}}" type="button" class="btn btn-primary btn-edit" data-toggle="modal" data-target="#exampleModal">
                            Sửa
                        </button>
                        <button id="{{$t->TourId}}" class="btn btn-danger btn-del">Xóa</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot></tfoot>
        </table>
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
                        <input type="hidden" id="TourId" name="TourId">
                        <div class="form-group">
                            <label class="col-sm-12 control-label">Điểm đi</label>
                            <div class="col-sm-12">
                                <select type="text" name="from" id="from" class="form-control">
                                    <!-- <option value="">Tất cả</option> -->
                                    @foreach($address as $d)
                                    <option value="{{$d->AddressId}}">{{ $d->AddressName }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12 control-label">Điểm đến</label>
                            <div class="col-sm-12">
                                <select type="text" name="to" id="to" class="form-control">
                                    <!-- <option value="">Tất cả</option> -->
                                    @foreach($address as $d)
                                    <option value="{{$d->AddressId}}">{{ $d->AddressName }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12 control-label">Giá</label>
                            <div class="col-sm-12">
                                <input type="number" id="price" name="price" required="" class="form-control"></input>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12 control-label">Số ghế</label>
                            <div class="col-sm-12">
                                <input type="number" min=1 id="seat" name="seat" required="" class="form-control"></input>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12 control-label">Thời gian đi</label>
                            <div class="col-sm-12">
                                <input type="datetime-local" id="fromtime" name="fromtime" required="" class="form-control"></input>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12 control-label">Thời gian đến</label>
                            <div class="col-sm-12">
                                <input type="datetime-local" id="totime" name="totime" required="" class="form-control"></input>
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
                data.append('TourId', id);
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
                    url: "{{ route('deltour') }}",
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
            var from = $("#from").val();
            var to = $("#to").val();
            var price = $("#price").val();
            var seat = $("#seat").val();
            var fromtime = $("#fromtime").val();
            var totime = $("#totime").val();
            data.append('FromAddress', from);
            data.append('ToAddress', to);
            data.append('FromHour', fromtime);
            data.append('ToHour', totime);
            data.append('Price', price);
            data.append('Seat', seat);
            data.append('_token', '{{ csrf_token() }}');
            $.ajax({
                url: "{{ route('createtour') }}",
                processData: false,
                contentType: false,
                type: 'post',
                data: data,
                success: function(response) {
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
            $("#TourId").val(this.id);
            $("#AddressName").val(this.value);
        });
        $("#btn-add").click(function() {
            $("#save").css({
                display: 'block'
            });
            $("#saveedit").css({

                display: 'none'
            });
            $("#TourId").val();
            $("#AddressName").val();
        });
    </script>

    @stop