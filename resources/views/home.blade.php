@extends('layouts.app')

@section('content')
<div class="homepage-banner">
    <h2 class="homepage-tittle"> VeXeRe - Cam kết hoàn 150% nếu nhà xe không giữ vé</h4>
        <form class="frmSearch" action="{{ route('search') }}" method="get" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form-group col-2">
                <label for="fromAddress">Điểm đi</label>
                <select type="text" name="fromAddress" id="fromAddress" class="form-control">
                    <!-- <option value="">Tất cả</option> -->
                    @foreach($address as $d)
                    <option value="{{$d->AddressId}}">{{ $d->AddressName }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-2">
                <label for="toAddress">Điểm đến</label>
                <select type="text" name="toAddress" id="toAddress" class="form-control">
                    <!-- <option value="">Tất cả</option> -->
                    @foreach($address as $d)
                    <option value="{{$d->AddressId}}">{{ $d->AddressName }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-2">
                <label for="date">Ngày</label>
                <input type="date" name="date" id="date" class="form-control">
            </div>
            <div class="form-group col-2">
                <label for=""></label>
                <button class="form-control btn btn-info btnsearch" type="submit">Tìm vé</button>
            </div>
        </form>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    //set date = datetime.now
    $(document).ready(function() {
        let currentDate = new Date().toJSON().slice(0, 10);
        $('#date').val(currentDate);
    });
</script>
@endsection
