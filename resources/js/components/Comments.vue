<template>
	<div class="row mb-3 bg-light shadow-lg py-4 px-1">
		<div class="col-12 mb-2">
			<label for="commentBodyInput">New Comment:</label>
			<textarea class="form-control" id="commentBodyInput" aria-label="With textarea" v-model="bodyInput" @input="handleBodyInput"></textarea>
			<button class="btn btn-sm btn-primary my-2" @click="submitComment">Submit</button>
		</div>
		<div class="col-12">
			<div class="text-center" v-if="this.loadingComments">
				<div class="spinner-border" role="status">
					<span class="sr-only">Loading...</span>
				</div>
			</div>
			<p class="text-center text-danger" v-if="comments.length <= 0 && !this.loadingComments">This recipe has no comments.</p>
			<div v-else class="row">
				<comment v-for="comment in comments" v-bind:key="comment.id" v-bind="comment" :account-id="account.id" @deletingComment="deletingComment(comment.id)"></comment>
			</div>
		</div>
	</div>
</template>
<script>
	export default{
		props: [
			'recipeId'
		],
		created(){
			axios.get('/api/user')
			.then(res => {
				this.account = res.data;
			})
			.catch(err => {
				console.log(err);
			});
			axios.get('/api/recipe/' + this.recipeId + '/comments').then(res => {
				this.comments = res.data.comments;
				this.loadingComments = false;
			}).catch(err=>{
				console.log(err);
				this.loadingComments = false;
			});
		},
		methods:{
			handleBodyInput: function(e){
				this.bodyInput = e.target.value;
			},
			submitComment: function(e){
				let data = {
					body: this.bodyInput,
					recipeId: this.recipeId
				}
				axios.post(`/api/recipe/${this.recipeId}/comments`, data)
				.then(res=>{

					this.comments.push(res.data.comment);
					this.bodyInput = '';
				})
				.catch(err=>{
					console.log(err);
				});
			},
			deletingComment: function(commentId){
				let confirmedDelete = confirm('Are you sure you want to delete this comment?');
				if(confirmedDelete){
					axios.delete('/api/recipe/' + this.recipeId + '/comments/' + commentId)
					.then(res => {
						this.comments = this.comments.filter(c => c.id != commentId);
					})
					.catch(err =>{
						console.log(err);
					});
				}
			}
		},
		data(){
			return{
				account: '',
				loadingComments: true,
				comments: [],
				bodyInput: '',
			}
		}
	}
</script>
<style></style>