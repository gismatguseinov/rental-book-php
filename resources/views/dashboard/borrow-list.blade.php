@extends('dashboard.layouts.app')
@section('content')
    <div class="container-fluid">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a aria-current="page"
                                               href="{{route('dashboard.index')}}">Home</a></li>
                <li class="breadcrumb-item"><a
                        href="{{route('dashboard.borrows')}}">Requests</a> / </li>
                <li class="breadcrumb-item active"><a aria-current="page"
                                                      href="{{route('dashboard.return-reject-borrows')}}">Returned
                        Rejected</a>
                </li>
            </ol>
        </nav>
        <div class="row">
            <h1>Rejected Borrow Requests</h1>
            @if(count($rejected) === 0)
                <span>No found rejected borrows</span>
            @else
                @foreach($rejected as $rejectB)
                    <div class="card mx-lg-5" style="width: 13rem;">
                        <img src="{{asset($rejectB->book_name->cover_image)}}" style="width: auto;height: 240px"
                             class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">{{$rejectB->book_name->title}}</h5>
                            <p>User : {{$rejectB->reader_name->name}}</p>
                        </div>
                    </div>
                @endforeach
            @endif

        </div>
        <div class="row mt-5">
            <h1>Returned Borrow Request</h1>
            @if(count($returned) === 0)
                <span>No found returned borrows</span>
            @else
                @foreach($returned as $returnedB)
                    <div id="{{$returnedB->id}}" class="card mx-lg-5" style="width: 13rem;">
                        <img src="{{asset($returnedB->book_name->cover_image)}}" style="width: auto;height: 240px"
                             class="card-img-top" alt="...">
                        <div class="card-body">
                            <h3>{{$returnedB->reader_name->name}}</h3>
                            <h5 class="card-title">{{$returnedB->book_name->title}}</h5>
                            <p class="card-text">{{$returnedB->book_name->descroption}}</p>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection

