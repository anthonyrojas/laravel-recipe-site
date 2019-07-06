@extends('layouts.app')
@section('stylesheets')
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endsection
@section('content')
<main>
	<div class="container">
		<div class="row py-4">
			<div class="col-12">
				<div class="card rounded-0 shadow-lg">
					<div class="card-header bg-secondary text-white rounded-0">
						<h5 class="text-center">{{ __('Create Recipe') }}</h5>
					</div>
					<div class="card-body rounded-0">
						<form method="POST" action="/recipe/create" enctype="multipart/form-data" id="recipe-form">
							@csrf
							<div class="form-group row">
								<label for="title" class="col-12 text-left">Title</label>
								<div class="col-12">
									<input name="title" id="title" type="text" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}" required autocomplete="title" value="{{ old('title') }}" autofocus>
									@error('title')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>
							<div class="form-group row">
								<label for="short_description" class="col-12 text-left">Short Description</label>
								<div class="col-12">
									<input name="short_description" id="short_description" type="text" class="form-control @error('short_description') is-invalid @enderror" required value="{{ old('short_description') }}" autocomplete="short_description">
									@error('short_description')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
									@enderror
								</div>
							</div>
							<div class="form-group row">
								<div class="col-12">
									<div class="input-group my-3">
										<div class="input-group-prepend bg-secondary">
											<span class="input-group-text bg-secondary text-white" id="recipe-img-prepend">Upload</span>
										</div>
										<div class="custom-file">
											<input type="file" name="img" class="custom-file-input @error('img') is-invalid @enderror" id="imgUpload" aria-describedby="recipe-img-prepend">
											@error('img')
											<span class="invalid-feedback" role="alert">
												<strong>{{ $message }}</strong>
											</span>
											@enderror
											<label class="custom-file-label" for="imgUpload">Choose Image</label>
										</div>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label for="description" class="col-12 text-left">Recipe Description</label>
								<div class="col-12">
									<div id="description-toolbar">
										<span class="ql-formats">
									      <select class="ql-font"></select>
									      <select class="ql-header"></select>
									    </span>
									    <span class="ql-formats">
									      <button class="ql-bold"></button>
									      <button class="ql-italic"></button>
									      <button class="ql-underline"></button>
									      <button class="ql-strike"></button>
									    </span>
									    <span class="ql-formats">
									      <select class="ql-color"></select>
									      <select class="ql-background"></select>
									    </span>
									    <span class="ql-formats">
									      <button class="ql-script" value="sub"></button>
									      <button class="ql-script" value="super"></button>
									    </span>
									    <span class="ql-formats">
									      <button class="ql-blockquote"></button>
									      <button class="ql-code-block"></button>
									    </span>
									    <span class="ql-formats">
									      <button class="ql-list" value="ordered"></button>
									      <button class="ql-list" value="bullet"></button>
									      <button class="ql-indent" value="-1"></button>
									      <button class="ql-indent" value="+1"></button>
									    </span>
									    <span class="ql-formats">
									      <button class="ql-direction" value="rtl"></button>
									      <select class="ql-align"></select>
									    </span>
									    <span class="ql-formats">
									      <button class="ql-link"></button>
									      <button class="ql-image"></button>
									      <button class="ql-video"></button>
									      <button class="ql-formula"></button>
									    </span>
									    <span class="ql-formats">
									      <button class="ql-clean"></button>
									    </span>
									</div>
									<div id="description-editor">{!! old('description') !!}</div>
									<textarea name="description" id="description" hidden>{{ old('description') }}</textarea>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-12">
									<button type="submit" class="btn btn-primary">Submit</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
@endsection
@section('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script src="{{ asset('js/image-resize.min.js') }}"></script>
<script>
  var quill = new Quill('#description-editor', {
  	modules: {
  		imageResize:{},
  		toolbar: '#description-toolbar'
  	},
    theme: 'snow'
  });
  var recipeForm = document.querySelector('#recipe-form');
  recipeForm.onsubmit = function(e){
  	e.preventDefault();
  	var descriptionEl = document.querySelector('#description');
  	descriptionEl.value = quill.root.innerHTML;
  	if(descriptionEl.value !== undefined && descriptionEl.value !== null && descriptionEl.value !== ''){
  		recipeForm.submit();
  	}
  }
</script>
@endsection