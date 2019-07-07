@extends('layouts.app')

@section('content')
<main>
    <div class="container">
        <div class="row my-4 shadow-lg">
            <div class="col-12 py-3">
                <h1 class="display-1 text-center">Account Information</h1>
                <hr />
                @if( session('success_message') )
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success_message' )}}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <h4 class="display-4">Username: <span class="text-secondary">{{$user->username}}</span></h4><br />
                <p class="lead">Name: <span class="font-weight-bold">{{$user->name}}</span></p><br />
                <p class="lead">Email: <span class="font-weight-bold">{{$user->email}}</span></p><br />
                <p>
                    <a href="/account/edit" class="btn btn-primary">Edit Account</a>
                    <a href="/account/password" class="btn btn-secondary text-white">Edit Password</a>
                </p>
            </div>
        </div>
    </div>
</main>
@endsection
@section('scripts')
@endsection