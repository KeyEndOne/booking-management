@extends('layouts.app')
@section('content')

<div class="container">
    <div>
        <img class="d-block w-100" style="height: 200px;" src="{{ asset('/images/slidesearch.jpg')}}" alt="Error">
    </div>
    @if (count($tour) > 0)
    <div id="searchresult">
        <h3 style="margin-top: 10px;">
            Xem tất cả {{count($tour)}} chuyến xe
        </h3>
        <p>Chọn giờ lên xe phù hợp</p>
        @foreach($tour as $t)

        <div style="margin-bottom: 15px;" class="d-flex tour">
            <img style="height: 150px; width: 150px;margin-right:16px" src="{{ asset('/images/img-xe.jpeg')}}" alt="Error">
            <div>
                <p> <span style="font-weight:bold">Thời gian: </span> {{ Carbon\Carbon::parse($t->FromHour)->format('H:i:s d-m-Y '); }}<i class="fa-solid fa-arrow-right"></i> {{ Carbon\Carbon::parse($t->ToHour)->format('H:i:s d-m-Y '); }}</p>
                <p> <span style="font-weight:bold">Số ghế: </span> {{$t->Seat}}</p>
                <p> <span style="font-weight:bold">Giá: </span> {{number_format($t->Price,0 )}} VNĐ</p>
                <button style="color:white;" id="{{$t->TourId}}" class="btn btn-primary chose"> Chọn ghế </button>
            </div>
        </div>
        <div>
            <form id="frm{{$t->TourId}}" value="{{$t->Price}}" class="frmChose" style="display: none;">
                {{csrf_field()}}
                <table class="table table-striped">
                    <thead>
                        <tr>
                            @foreach($seat = DB::table('tourseat')->where('TourId', $t->TourId)->get() as $s)

                            @if ($s->Status == "Booked" )
                            <th>
                                <input frmid="{{$s->TourId}}" value="{{$t->Price}}" class="form-check-input" type="checkbox" id="MyCheck{{$s->SeatId}}" name="{{$s->SeatId}}" checked disabled="disabled">
                                <label class="form-check-label">Ghế {{$s->SeatId}}</label>
                            </th>
                            @else
                            <th>
                                <input frmid="{{$s->TourId}}" value="{{$t->Price}}" class="form-check-input" type="checkbox" id="MyCheck{{$s->SeatId}}" name="{{$s->SeatId}}">
                                <label class="form-check-label">Ghế {{$s->SeatId}}</label>
                            </th>
                            @endif

                            @endforeach
                        </tr>
                    </thead>
                </table>

                <div class="d-flex justify-content-end align-items-end">
                    <div id="total{{$t->TourId}}" style="padding-right: 20px;">Tổng tiền vé: 0</div>
                    <a style="color: white;" value="{{$t->Price}}" class="btn btn-primary btnAddTicket" id="{{$t->TourId}}"> Đặt vé</a>
                </div>
            </form>

        </div>
        @endforeach
        @else
        <h5 style="margin-top: 15px;" class="d-flex justify-content-center align-items-center">
            Xin lỗi bạn vì sự bất tiện này. VeXeRe sẽ cập nhật ngay khi có thông tin xe hoạt động trên tuyến đường bạn tìm kiếm
        </h5>
        <p class="d-flex justify-content-center">
            Xin bạn vui lòng thay đổi tuyến đường tìm kiếm
        </p>
        @endif

    </div>

</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(".chose").click(function() {
        var frmId = this.id;
        var isVisible = document.getElementById('frm' + frmId).style.display == "none";
        if (isVisible)
            $("#frm" + frmId).removeAttr('style');
        else
            $("#frm" + frmId).css({
                display: 'none'
            });
    });
    $(".btnAddTicket").click(function() {
        var frmId = this.id;
        var Price = this.getAttribute('value');
        var element = document.getElementById('frm' + frmId);
        var data = new FormData();
        var lstSeat = [];
        //get list seat  user chose
        $(element).each(function() {
            $(this).find(':input:checked:not([disabled])').each(function() {
                var SeatId = this.getAttribute('name');
                lstSeat.push(SeatId);
            })
        });
        // console.log(lstSeat.length);
        data.append('lstSeat', lstSeat);
        data.append('tourId', frmId);
        data.append('Price', parseFloat(Price) * lstSeat.length);
        data.append('_token', '{{ csrf_token() }}');
        // console.log(...data);
        if (lstSeat.length <= 0) {
            alert("Vui lòng chọn ghế");
        } else {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                    "X-Requested-With": "XMLHttpRequest"
                }
            });
            //call ajax create ticket
            $.ajax({
                url: "{{ route('createticket') }}",
                processData: false,
                contentType: false,
                type: 'post',
                data: data,
                statusCode: {
                    401: function() {
                        if (confirm('Bạn cần đăng nhập để đặt vé')) {
                            window.location.href = "http://127.0.0.1:8000/login";
                        }
                    }
                },
                success: function(response) {
                    window.location.href = "http://127.0.0.1:8000/ok";
                },
                error: function(response) {
                    console.log("Lỗi rồi");
                }
            });
        }

    });
    $('.form-check-input').change(function() {
        //change change in frm?
        var frmId = this.getAttribute("frmid");
        var element = document.getElementById('frm' + frmId);
        var Price = parseFloat(this.getAttribute('value'));
        var lstSeat = [];
        //get list seat  user chose
        $(element).each(function() {
            $(this).find(':input:checked:not([disabled])').each(function() {
                lstSeat.push($(this).val());
            })
        });
        var total = lstSeat.length * Price;
        //set value
        var elementtotal = document.getElementById('total' + frmId);
        elementtotal.setHTML("Tổng tiền vé: " + total.toLocaleString(
            undefined, // leave undefined to use the visitor's browser 
            // locale or a string like 'en-US' to override it.
            {
                minimumFractionDigits: 0
            }
        ) + " VNĐ");
    });

    // $('.form-check-input').click(function() {
    //     if (!$(this).is(':checked')) {
    //         return confirm("Are you sure?");
    //     }
    // });
</script>
@stop