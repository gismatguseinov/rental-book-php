@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-7">
                <div class="card p-3 py-4">
                    <div  class="text-center">
                        <img src="{{asset('about_us.jpg')}}" width="100"
                             class="rounded-circle">
                    </div>
                    <div class="text-center mt-3"><span class="bg-secondary p-1 px-4 rounded text-white">Admin</span>
                        <h5 class="mt-2 mb-0">Samir Aliyev</h5> <span>NEPTUN ID: s2w2zg</span>
                        <div class="px-4 mt-1">
                            <p class="fonts">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet eaque eius
                                eligendi hic ipsam veritatis vitae. Animi aspernatur doloribus earum fugiat minima,
                                nobis suscipit. Beatae iusto pariatur porro quo reiciendis!</p>
                        </div>
                        <div class="buttons">
                            <a class="btn btn-outline-primary" href="mailto:aliyev.s.1999@gmail.com">Contact with
                                email</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
