@extends('layouts.app')

@section('content')
<main>
    <div class="container">
        <div class="row my-4 shadow-lg">
            <div class="col-12 py-4">
                <h4 class="display-4 text-center">Edit Account Information</h4>
                <hr />
                <form method="POST" action="/account/update">
                    @csrf
                    {{ method_field('PUT') }}
                    <div class="form-group">
                        <label for="name-input">Name:</label>
                        <input type="text" name="name" id="name-input" value="{{ old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror">
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email-input">Email:</label>
                        <input type="email" name="email" id="email-input" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="username-input">Username:</label>
                        <input type="text" name="username" id="username-input" value="{{ old('username', $user->username) }}" class="form-control @error('username') is-invalid @enderror">
                        @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-row py-3 px-1">
                        <div class="col-12">
                            <button class="btn btn-primary" type="submit">Update</button>
                            <a class="btn btn-danger" href="/account">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
@section('scripts')
@endsection