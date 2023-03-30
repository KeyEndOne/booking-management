@extends('layouts.app')
@section('content')

<div class="container">

    @if (count($ticket) > 0)
    <div id="searchresult">
        <p style="margin-top: 10px;">
            Xem tất cả vé bạn đã đặt
        </p>

        <table class="table table-bordered table-striped table-hover dataTable no-footer">
            <thead class="isd-table-header">
                <tr>
                    <th class="text-center">Ngày đi</th>
                    <th class="text-center">Từ -> đến</th>
                    <th class="text-center">Ghế số</th>
                    <th class="text-center">Giá vé</th>
                    <th class="text-center">Chức năng</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ticket as $t)
                <tr>
                    <td class="text-center">{{ Carbon\Carbon::parse($t->FromHour)->format('H:i:s d-m-Y '); }} -> {{ Carbon\Carbon::parse($t->ToHour)->format('H:i:s d-m-Y '); }}</td>
                    <td class="text-center">{{$t->FromAddress}} -> {{$t->ToAddress}}</td>
                    <td class="text-center">{{($t->SeatId)}}</td>
                    <td class="text-center">{{number_format($t->Price,0 )}} VNĐ</td>
                    <td class="text-center">
                        <button id="{{$t->TicketId}}" class="btn btn-danger btn-del">Hủy vé</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot></tfoot>
        </table>
        @endif

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            $(".btn-del").click(function() {
                if (confirm('Bạn có chắc muốn hủy vé')) {
                    var id = this.id;
                    // console.log(lstSeat.length);
                    var data = new FormData();
                    data.append('ticketId', id);
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
                        url: "{{ route('delticket') }}",
                        processData: false,
                        contentType: false,
                        type: 'post',
                        data: data,
                        success: function(response) {
                            alert("Hủy vé thành công");
                            location.reload();
                        },
                        error: function(response) {
                            console.log("Lỗi rồi");
                        }
                    });
                }
            });
        </script>

        @stop