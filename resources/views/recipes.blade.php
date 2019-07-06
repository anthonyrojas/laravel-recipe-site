@extends('layouts.app')
@section('stylesheets')
@endsection
@section('content')
<main>
	<div class="bg-secondary py-4 text-white">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-sm-12 col-lg-3">
				</div>
				<div class="col-sm-12 col-lg-3">
					<label for="limit-select">Limit:</label>
					<select name="limit" class="custom-select" id="limit-select">
						<option @if($limit == 5) selected @endif value="5">5</option>
						<option @if($limit == 10) selected @endif value="10">10</option>
						<option @if($limit == 15) selected @endif value="15">15</option>
						<option @if($limit == 20) selected @endif value="20">20</option>
					</select>
				</div>
				<div class="col-sm-12 col-lg-3">
					<label for="sort-select">Sort By:</label>
					<select name="sorter" class="custom-select" id="sort-select">
						<option @if($sorter == 'date') selected @endif value="date">Date</option>
						<option @if($sorter == 'title') selected @endif value="title">Title</option>
					</select>
				</div>
				<div class="col-sm-12 col-lg-3 text-center">
					<button class="btn btn-primary rounded-0" onclick="filterRecipes()">Filter</button>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row justify-content-center">
		@if(count($recipes) <= 0)
			<div class="col-sm-12 col-md-10 py-3 mt-3">
				<p class="lead text-center py-3">There were no recipes found.</p>
			</div>
		@endif
		@foreach($recipes as $recipe)
			<div class="col-sm-12 col-md-10">
				<div class="card my-3 shadow-sm">
					<div class="row no-gutters">
						<div class="col-md-3 bg-secondary">
							<img src="{{$recipe->img || '/storage/recipes/temp/default.png'}}" class="card-img" onerror='this.src="/storage/recipes/temp/default.png"' alt="{{$recipe->title}}">
						</div>
						<div class="col-md-9">
							<div class="card-body">
								<h4 class="text-center card-title">{{$recipe->title}}</h4>
								<p class="card-text">{{$recipe->short_description}}</p>
								<p class="card-text">Created: <span class="recipe-created-at text-muted">{{$recipe->created_at}}</span></p>
								<p class="card-text">From: {{$recipe->user->username}}</p>
								<a href="/recipe/{{$recipe->id}}" class="card-link text-center btn btn-primary btn-sm">View Recipe</a>
								@if($account_recipe == true)
									<a href="/recipe/{{$recipe->id}}/update" class="card-link text-center btn btn-secondary btn-sm">Update Recipe</a>
								@endif
							</div>
						</div>
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-sm-12 col-md-6">
								<button class="btn" onclick="favoriteRecipe({{$recipe->id}})"><i id="favorite-icon-{{$recipe->id}}" class="@if(count($recipe->favorites) > 0) fas @else far @endif fa-2x fa-heart"></i></button>&nbsp;Favorites: <span id="favorite-count-{{$recipe->id}}">{{$recipe->favorites_count}}</span>
							</div>
							<div class="col-sm-12 col-md-6">
								<button class="btn" onclick="navToRecipeComments({{$recipe->id}})"><i class="far fa-2x fa-comments"></i></button>&nbsp;Comments: {{$recipe->comments_count}}
							</div>
						</div>
					</div>
				</div>				
			</div>
		@endforeach
		</div>
		<div class="row my-3">
			<div class="col-12 justify-content-center">
				{{ $recipes->appends(['sort' => $sorter, 'limit' => $limit ])->links() }}
			</div>
		</div>
	</div>
</main>
@endsection
@section('scripts')
<script>
	window.onload = function(e){
		var recipeDates = document.querySelectorAll('.recipe-created-at');
		for(var i = 0; i < recipeDates.length; i++){
			var currentRecipeDate = recipeDates[i].innerHTML;
			var dateVal = currentRecipeDate;
			recipeDates[i].innerHTML = new Date(currentRecipeDate).toDateString();
		}
	}
	function navToRecipeComments(recipeId){
		window.location = '/recipe/' + recipeId + '#recipe-comments';
	}
	function filterRecipes(){
		var limitList = document.getElementById('limit-select');
		var sorterList = document.getElementById('sort-select');
		var limit = limitList.options[limitList.selectedIndex].value;
		var sorter = sorterList = sorterList.options[sorterList.selectedIndex].value;
		var urlParams = new URLSearchParams(window.location.search);
		var pageParam = urlParams.get('page');
		if(pageParam === undefined || pageParam === null || pageParam <= 0){
			pageParam = 1;
		}
		var redirectPage = location.pathname + '?sort=' + sorter + '&limit=' + limit + '&page=' + pageParam;
		window.location.href = redirectPage;
	}
	function favoriteRecipe(recipeId){
		var favoriteCount = document.getElementById('favorite-count-' + recipeId);
		var favoriteIcon = document.getElementById('favorite-icon-' + recipeId);
		var data = {};
		axios.post('/api/recipe/' + recipeId + '/favorite', data)
		.then(res => {
			if(res.data.favorited){
				favoriteCount.innerHTML = res.data.count;
				favoriteIcon.className = favoriteIcon.className.replace('far', 'fas');
			}else{
				favoriteCount.innerHTML = res.data.count;
				favoriteIcon.className = favoriteIcon.className.replace('fas', 'far');
			}
		})
		.catch(err => {
			console.log(err);
		});
	}
</script>
@endsection