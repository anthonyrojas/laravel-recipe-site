@extends('layouts.app')

@section('content')
<main>
    <div class="container">
        <div class="row my-4 shadow-lg">
            <div class="col-12 py-4">
            	<h1 class="display-4 text-center">Update Your Password</h1>
            	<hr />
            	<form method="POST" action="/account/password">
	            	@csrf
	            	{{ method_field('PUT') }}
	            	<div class="form-group">
	            		<label for="password-input">New Password: </label>
	            		<input type="password" name="password" id="password-input" value="{{ old('password', '') }}" class="form-control @error('password') is-invalid @enderror">
	            		@error('password')
	            		<span class="invalid-feedback" role="alert">
	            			<strong>{{ $message }}</strong>
	            		</span>
	            		@enderror
	            	</div>
	            	<div class="form-row">
	            		<div class="col-12">
	            			<button class="btn btn-primary" type="submit">Update Password</button>
	            			<a href="/account" class="btn btn-danger">Cancel</a>
	            		</div>
	            	</div>
            </div>
        </div>
    </div>
</main>
@endsection
@section('scripts')
@endsection