@extends('layouts.app')
@section('stylesheets')
@endsection
@section('content')
<main>
	<div class="bg-light">
		<div class="container">
			<div class="row py-4">
				<div class="col-md-4 my-2">
					<div class="card shadow-sm rounded-0">
						<div class="card-body">
							<p class="text-center"><i class="fab fa-creative-commons-share fa-3x"></i></p>
							<h5 class="text-center card-title">Share</h5>
							<p class="card-text">Upload your recipes that you know. Share them with the community online for everyone to view and learn your recipes.</p>
						</div>
					</div>
				</div>
				<div class="col-md-4 my-2">
					<div class="card shadow-sm rounded-0">
						<div class="card-body">
							<p class="text-center"><i class="fas fa-brain fa-3x"></i></p>
							<h5 class="text-center card-title">Learn</h5>
							<p class="card-text">Learn recipes from other people. You may learn different recipes to enhance your meals for the week and like them.</p>
						</div>
					</div>
				</div>
				<div class="col-md-4 my-2">
					<div class="card shadow-sm rounded-0">
						<div class="card-body">
							<p class="text-center"><i class="fas fa-users fa-3x"></i></p>
							<h5 class="text-center card-title">Interact</h5>
							<p class="card-text">Interact with recipes that other people post. You can favorite and comment on recipes to connect the community here.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="bg-white">
		<div class="container">
			<div class="row py-4">
				<div class="col-md-5 col-sm-12 my-2">
					<img class="img-fluid shadow-lg rounded" src="{{ asset('images/home-1.jpg') }}">
				</div>
				<div class="col-md-2 col-sm-12 my-2"></div>
				<div class="col-md-5 col-sm-12 my-2">
					<h4 class="text-center">Learn. Cook. Eat.</h4>
					<p class="lead">
						Start by learning recipes posted by others here. It is a big world and, therefore, many people have different styles when it comes to preparing food. It is always good to step out of one's shell or comfort zone, and with food it should be no different (unless of course, allergies are involved). Search through many different recipes and pick your favorites to savor forever.
					</p>
				</div>
			</div>
		</div>
	</div>
</main>
@endsection
@section('scripts')
@endsection