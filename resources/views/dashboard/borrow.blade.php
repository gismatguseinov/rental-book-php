@extends('dashboard.layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <h1>All Borrow Requests</h1>
            @foreach($borrows as $borrow)
                <div class="card mx-lg-5" style="width: 13rem;">
                    <img src="{{asset($borrow->book_name->cover_image)}}" style="width: auto;height: 240px"
                         class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title">{{$borrow->book_name->title}}</h5>
                        <p class="card-text">{{$borrow->book_name->descroption}}</p>
                        <button id="{{$borrow->id}}" data-bs-toggle="modal" data-bs-target="#myModal"
                                class="btn accept btn-primary">Accept
                        </button>
                        <button id="{{$borrow->id}}" class="btn reject btn-danger">Reject</button>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="row mt-5">
            <h1>Managed Borrow Request</h1>
            @foreach($managedBorrows as $borrow)
                <div id="{{$borrow->id}}" class="card mx-lg-5" style="width: 13rem;">
                    <img src="{{asset($borrow->book_name->cover_image)}}" style="width: auto;height: 240px"
                         class="card-img-top" alt="...">
                    <div class="card-body">
                        <h3>{{$borrow->reader_name->name}}</h3>
                        <h5 class="card-title">{{$borrow->book_name->title}}</h5>
                        <p class="card-text">{{$borrow->book_name->descroption}}</p>
                        <button id="{{$borrow->id}}" class="btn btn-success">Return</button>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="modal" id="myModal">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">Enter deadline</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <!-- Modal body -->
                    <div class="modal-body">
                        <input type="date" min="1" max="60" name="deadline" class="form-control">
                    </div>

                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger acc" data-bs-dismiss="modal">Accept</button>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <script>
        $('.accept').click(function () {
            let myModal = document.getElementById('myModal')
            let myInput = document.getElementById('myInput')

            let id = this.id;
            let url = '{{route('dashboard.accept-borrow',':id')}}'
            url = url.replace(':id', id);
            $('.acc').click(function () {
                let deadline = $('input[name=deadline]').val()

                $.ajax({
                    url: url,
                    data: {
                        "_token": "{{ csrf_token() }}",
                        deadline: deadline
                    },
                    method: 'POST',
                    success: function (response) {
                        console.log(response)
                    },
                    error: function (err) {
                        console.log(err)
                    }
                });
                $('input[name=deadline]').val('')
            })

        })
    </script>
@endsection

