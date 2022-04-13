@extends('layouts.app')
@section('content')
    <div class="container light-style flex-grow-1 container-p-y">
        <h4 class="font-weight-bold py-3 mb-4">
            Account settings
        </h4>

        <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="account-general">

                            <hr class="border-light m-0">

                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    <input type="text" readonly class="form-control" value="{{$user->name}}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">E-mail</label>
                                    <input type="text" class="form-control mb-1" readonly value="{{$user->email}}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Role</label>
                                    <input readonly type="text" class="form-control"
                                           value="{{$user->is_librarian == 1 ? 'Librarian' : 'Reader'}}">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
