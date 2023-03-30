@extends('admin.layout')
@section('content')

<div>
    
    @if (count($user) > 0)
    <div id="searchresult">
        <table class="table table-bordered table-striped table-hover dataTable no-footer">
            <thead class="isd-table-header">
                <tr>
                    <th class="text-center">Id</th>
                    <th class="text-center">Name</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Thời gian tạo</th>
                    <th class="text-center">Chức năng</th>
                </tr>
            </thead>
            <tbody>
                @foreach($user as $t)
                <tr>
                    <td class="text-center">{{$t->id}}</td>
                    <td class="text-center">{{$t->name}}</td>
                    <td class="text-center">{{$t->email}}</td>
                    <td class="text-center">{{ Carbon\Carbon::parse($t->created_at)->format('H:i:s d-m-Y '); }} </td>
                    <td class="text-center">
                       
                        <button id="{{$t->id}}" class="btn btn-danger btn-del">Xóa</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot></tfoot>
        </table>
        @endif
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(".btn-del").click(function() {
            if (confirm('Bạn có chắc muốn xóa')) {
                var id = this.id;
                // console.log(lstSeat.length);
                var data = new FormData();
                data.append('id', id);
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
                    url: "{{ route('deluser') }}",
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
    </script>
    @stop