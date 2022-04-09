@extends('layouts.app')
@section('content')
    <div class="container-fluid px-5 pt-2">
        <div class="row">
            <h1 class="pb-2 ml-2">My borrow requests</h1>
            @if(count($borrowList) === 0)
                <span>No found rejected borrows</span>
            @else
                @foreach($borrowList as $borrow)
                    <div class="card mx-lg-5" style="width: 13rem;">
                        <img src="{{asset($borrow->book_name->cover_image)}}" style="width: auto;height: 240px"
                             class="card-img-top" alt="">
                        <div class="card-body">
                            <h5 class="card-title">{{$borrow->book_name->title}}</h5>
                            <p>Status</p>
                            @if($borrow->status === 'ACCEPTED')
                                <span class="btn btn-outline-success">{{$borrow->status}}</span>
                            @else
                                <span class="{{ $borrow->status == 'REJECTED' ? 'btn btn-danger' : 'btn btn-primary' }}">{{$borrow->status}}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection

