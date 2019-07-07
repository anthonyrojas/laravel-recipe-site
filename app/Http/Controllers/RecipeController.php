<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Recipe;
use App\Favorite;

class RecipeController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}
	public function get_recipes(Request $request)
	{
		$sorter = $request->query('sort');
		if(empty($sorter) || $sorter == null){
			$sorter = "title";
		}
		$sortBy = $sorter;
		if($sortBy == "date"){
			$sortBy = "created_at";
		}
		$limit = $request->query('limit');
		if(empty($limit) || $limit == null){
			$limit = 5;
		}
		// $recipes = Recipe::paginate(5);
		// return view('recipes')->with('recipes', $recipes);
		// $recipes = Recipe::orderBy('created_at', 'desc')->paginate($limit);
		// return view('recipes')->with('recipes', $recipes)->with('limit', $limit)->with('sortBy', $sortBy)->with('users', $users);
		$recipes = Recipe::with('user')->with(['favorites' => function($q){
			$q->select(['id', 'confirmed', 'user_id', 'recipe_id'])->where('favorites.user_id', '=', Auth::user()->id)->where('confirmed', '=', 1);
		}])->withCount('favorites')->withCount('comments')->orderBy($sortBy, 'desc')->paginate($limit);
		return view('recipes')->with('recipes', $recipes)->with('sorter', $sorter)->with('limit', $limit)->with('account_recipe', false);
	}
	public function get_my_recipes(Request $request){
		$sorter = $request->query('sort');
		if(empty($sorter) || $sorter == null){
			$sorter = "title";
		}
		$sortBy = $sorter;
		if($sortBy == "date"){
			$sortBy = "created_at";
		}
		$limit = $request->query('limit');
		if(empty($limit) || $limit == null){
			$limit = 5;
		}
		$recipes = Recipe::with('user')->with(['favorites' => function($q){
			$q->select(['id', 'confirmed', 'user_id', 'recipe_id'])->where('favorites.user_id', '=', Auth::user()->id)->where('confirmed', '=', 1);
		}])->withCount('favorites')->withCount('comments')->where('user_id', Auth::user()->id)->orderBy($sortBy)->paginate($limit);
		return view('recipes')->with('recipes', $recipes)->with('sorter', $sorter)->with('limit', $limit)->with('account_recipe', true);
	}
	public function get_recipe(Request $req, $id)
	{
		if($req->session()->has('recipe'))
		{
			$recipe = $req->session()->get('recipe');
			$favorited = Favorite::where('user_id', auth::user()->id)->where('recipe_id', $recipe->id)->first();
			if(is_null($favorited)){
				$recipe->favorited = false;
			}else{
				$recipe->favorited = true;
			}
			return view('recipe')->with('recipe', $recipe);
		}
		$recipe = Recipe::withCount('favorites')->findOrFail($id);
		$favorited = Favorite::where('user_id', auth::user()->id)->where('recipe_id', $recipe->id)->first();
		if(is_null($favorited)){
			$recipe->favorited = false;
		}else{
			$recipe->favorited = true;
		}
		return view('recipe')->with('recipe', $recipe);
	}
	public function edit_recipe($id)
	{
		$recipe = Recipe::findOrFail($id);
		if($recipe->user_id == Auth::user()->id)
		{
			return view('recipe-edit')->with('recipe', $recipe);
		}
		else
		{
			return redirect('recipe/' . $id)->withErrors('You are not authorized to access this page.');
		}
	}
	public function update(Request $req, $id)
	{
		$validator = Validator::make($req->all(),[
			'title' => 'required|max:255',
			'img' => 'image',
			'short_description' => 'required|max:255',
			'description' => 'required'
		]);
		if($validator->fails())
		{
			return back()->withErrors($validator)->withInput();
		}
		$recipe = Recipe::find($id);
		if($req->hasFile('img')){
			$file = $req->file('img');
			$path = Storage::putFile('public/recipes/' . Auth::user()->id, $file);
			$pathName = str_replace('public', 'storage', $path);
			//delete the old image
			$recipeImgPath = str_replace('storage','public', $recipe->img);
			Storage::delete($recipeImgPath);
			$recipe->img = '/' . $pathName;
		}
		$recipe->title = $req->input('title');
		$recipe->short_description = $req->input('short_description');
		$recipe->description = $req->input('description');
		$recipe->save();
		return redirect('recipe/' . $recipe->id)->with('recipe', $recipe);
	}
	public function create_recipe()
	{
		return view('recipe-create');
	}
	public function create(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'title' => 'required|max:255',
			'img' => 'required|image',
			'short_description' => 'required|max:255',
			'description' => 'required'
		]);
		if($validator->fails())
		{
			return back()->withErrors($validator)->withInput();
		}
		$file = $request->file('img');
		$path = Storage::putFile('public/recipes/' . Auth::user()->id, $file);
		$pathName = str_replace('public', 'storage', $path);
		$recipe = Recipe::create([
			'title' => $request->input('title'),
			'img' => '/' . $pathName,
			'short_description' => $request->input('short_description'),
			'description' => $request->input('description'),
			'user_id' => Auth::user()->id
		]);
		return redirect('recipe/' . $recipe->id)->with('recipe', $recipe);
	}
	public function delete($id){
		$recipe = Recipe::find($id);
		$recipe->delete();
		return redirect('recipes');
	}
}
