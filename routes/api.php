<?php

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;
use App\Favorite;
use App\Comment;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:api')->post('/recipe/{recipeId}/favorite', function(Request $request, $recipeId){
	$userId = $request->user()->id;
	try{
		$existingFavorite = Favorite::where('user_id', $userId)->where('recipe_id', $recipeId)->firstOrFail();
		$existingFavorite->delete();
		$favoriteCount = Favorite::where('recipe_id', $recipeId)->count();
		return response(json_encode(['favorited' => false, 'count' => $favoriteCount]), 200)->header('Content-type', 'application/json');
	}catch(Illuminate\Database\Eloquent\ModelNotFoundException $e){
		//there was no favorite for this user
		$recipeFavorite = new Favorite;
		$recipeFavorite->recipe_id = $recipeId;
		$recipeFavorite->user_id = $userId;
		$recipeFavorite->confirmed=true;
		$recipeFavorite->save();
		$favoriteCount = Favorite::where('recipe_id', $recipeId)->count();
		return response(json_encode(['favorited' => true, 'count' => $favoriteCount]), 200)->header('Content-type', 'application/json');
	}catch(Exception $err){
		$jsonRes = json_encode(['favorited' => false, 'message' => 'Unable to favorite this comment']);
		return response($jsonRes, 500)->header('Content-type', 'application/json');
	}
});
Route::middleware('auth:api')->get('/recipe/{recipeId}/comment/{commentId}', function(Request $request, $recipeId, $commentId){
	try{
		$comment = Comment::where('recipe_id', $recipeId)->where('id', $commentId)->firstOrFail();
		$jsonRes = json_encode(['comment'=>$comment]);
		return response($jsonRes, 200)->header('Content-type', 'application/json');
	}catch(Illuminate\Database\Eloquent\ModelNotFoundException $e){
		return response(json_encode(['message'=>"Unable to retrieve this comment"]), 200)->header('Content-type', 'application/json');
	}
});
Route::middleware('auth:api')->get('/recipe/{recipeId}/comments', function(Request $request, $recipeId){
	try{
		$comments = Comment::where('recipe_id', $recipeId)->with('user:id,username')->get();
		$jsonRes = json_encode(['comments' => $comments]);
		return response($jsonRes, 200)->header('Content-type', 'application/json');
	}catch(Illuminate\Database\Eloquent\ModelNotFoundException $e){
		return response(json_encode(['message' => $e->message]), 404);
	}catch(Exception $err){
		return response($err, 500);
	}
});
Route::middleware('auth:api')->post('/recipe/{recipeId}/comments', function(Request $request, $recipeId){
	$userId = $request->user()->id;
	$body = $request->input('body');
	$recipeId = $request->input('recipeId');
	$comment = new Comment;
	$comment->user_id = $userId;
	$comment->recipe_id = $recipeId;
	$comment->body = $body;
	$comment->save();
	$comment->user = User::where('id', $comment->user_id)->select('id', 'username')->firstOrFail();
	$jsonRes = json_encode(['comment' => $comment]);
	return response($jsonRes, 200)->header('Content-type', 'application/json');
});
Route::middleware('auth:api')->put('/recipe/{recipeId}/comments/{commentId}', function(Request $request, $recipeId, $commentId){
	$userId = $request->user()->id;
	$body = $request->input('body');
	try{
		$comment = Comment::where('id', $commentId)->where('user_id', $userId)->firstOrFail();
		$comment->body = $body;
		$comment->save();
		$jsonRes = json_encode(['commentBody' => $comment->body]);
		return response($jsonRes, 200)->header('Content-type', 'application/json');
	}catch(Illuminate\Database\Eloquent\ModelNotFoundException $e){
		return response(json_encode(['message' => $e->message]), 500)->header('Content-type', 'application/json');
	}
});
Route::middleware('auth:api')->delete('/recipe/{recipeId}/comments/{commentId}', function(Request $request, $recipeId, $commentId){
	$userId = $request->user()->id;
	try{
		$deletedComment = Comment::where('user_id', $userId)->where('id', $commentId)->delete();
		$jsonRes = json_encode(['deleted'=>true]);
		return response($jsonRes, 200)->header('Content-type', 'application/json');
	}catch(Exception $e){
		$jsonRes = json_encode(['deleted' => false, 'message' => $e->message]);
		return response($jsonRes, 500)->header('Content-type', 'application/json');
	}
});