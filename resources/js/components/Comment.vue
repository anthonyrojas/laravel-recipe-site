<template>
	<div class="card w-100 rounded-0 my-1">
		<div class="card-body py-1">
			<p class="card-text text-secondary">{{user.username}}</p>
			<p class="card-text" v-if="!editing">{{commentBody}}</p>
			<textarea class="form-control" aria-label="With textarea" v-else v-model="commentBody"></textarea>
			<p class="card-text text-muted"><small>{{new Date(created_at).toDateString()}}</small></p>
		</div>
		<div class="card-footer bg-light py-1" v-if="accountId == user_id">
			<a href='#' class="card-link" @click="editComment" v-if="!editing">Edit</a>
			<a href="#" class="card-link" @click="updateComment" v-else>Update</a>
			<a href='#' class="card-link text-danger" @click="deleteComment">Delete</a>
		</div>
	</div>
</template>
<script>
	export default{
		props: ['body', 'user_id', 'recipe_id', 'created_at', 'user', 'accountId', 'id'],
		created(){
		},
		methods: {
			editComment: function(e){
				e.preventDefault();
				this.editing = true;
			},
			updateComment: function(e){
				e.preventDefault();
				let data = {
					body: this.commentBody
				};
				axios.put('/api/recipe/' + this.recipe_id + '/comments/' + this.id, data)
				.then(res=>{
					this.commentBody = res.data.commentBody;
					this.editing = false;
				})
				.catch(err => {
					console.log(err);
					this.commentBody = this.body;
					this.editing = false;
				})
			},
			deleteComment: function(e){
				e.preventDefault();
				this.$emit('deletingComment');
			}
		},
		data(){
			return{
				editing: false,
				commentBody: this.body
			};
		}
	}
</script>