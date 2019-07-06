@extends('layouts.app')
@section('stylesheets')
@endsection
@section('content')
<main>
	<div class="container">
		<div class="row py-4">
			<div class="col-md-8 py-3 card shadow-md rounded-0">
				<div class="card-body">
					<h4 class="display-4 text-center">{{$recipe->title}}</h4>
					<hr />
					<p>{{$recipe->short_description}}</p>
					@if($recipe->user_id == Auth::user()->id)
					<a href="/recipe/{{$recipe->id}}/edit" class="btn btn-primary rounded-0 shadow-sm text-center">Edit Your Recipe</a>
					@endif
					@if($recipe->user_id == Auth::user()->id)
					<form method="POST" action="/recipe/{{ $recipe->id }}">
						@csrf
						{{ method_field('DELETE') }}
						<button class="btn btn-danger my-3 rounded-0 shadow-sm" type="submit">Delete Recipe</button>
					</form>
					@endif
				</div>
			</div>
			<div class="col-md-4 py-3">
				<img src="{{$recipe->img}}" alt="{{$recipe->title}}" class="img-fluid shadow-lg rounded">
			</div>
		</div>
		<div class="row py-4 bg-secondary text-white shadow-lg my-4">
			<div class="col-12">
				{!! $recipe->description !!}
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row bg-light d-flex">
			<div class="col-12">
				Favorites: <button class="btn" onclick="toggleFavoriteRecipe()"><i id="favorite-icon" class="@if($recipe->favorited) fas @else far @endif fa-2x fa-heart align-middle"></i></button>&nbsp;<span id="favorite-count">{{$recipe->favorites_count}}</span>
			</div>
		</div>
		<div id='recipe-comments'>
			<comments recipe-id="{{$recipe->id}}"></comments>
		</div>
	</div>
</main>
@endsection
@section('scripts')
<script>
	function toggleFavoriteRecipe(){
		axios.post('/api/recipe/{{$recipe->id}}/favorite')
		.then(res => {
			var favoriteIcon = document.getElementById('favorite-icon');
			var favoriteCount = document.getElementById('favorite-count');
			if(res.data.favorited){
				favoriteIcon.className = favoriteIcon.className.replace('far', 'fas');
				favoriteCount.innerHTML = res.data.count;
			}else{
				favoriteIcon.className = favoriteIcon.className.replace('fas', 'far');
				favoriteCount.innerHTML = res.data.count;
			}
		})
		.catch(err => {
			console.log(err);
		});
	}
</script>
@endsection