
<template>
<div class="new_message_head">
	<div class="pull-left">
	 	<button data-toggle="modal" data-target="#addUser" @click="getUsers">
	 		<i class="fa fa-plus-square-o" aria-hidden="true"></i>
		 	New Message
	 	</button>
	</div>
	<div id="addUser" class="modal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
      </div>
      <div class="modal-body">
      	<div  v-for="user in users">
        <input type="radio"  :value="user.id" v-model="selectedUser"> {{user.name}}
    	</div>
      </div>
      <div class="modal-footer">
      	<a type="button" class="btn btn-success" @click="createChat" data-dismiss="modal" data-backdrop="false">Create Chat</a>
        <button type="button" class="btn btn-default" data-dismiss="modal" data-backdrop="false">Close</button>

      </div>
    </div>

  </div>
</div>
</div>

</template>

<script>
export default {
	props: ['threads','actualthread', 'messages'],
	data(){
		return{
			selectedUser: [],
			users:[]
		}
	},
	methods:{
		getUsers(){
			axios.get('/users').then(response => {
	            this.users = response.data;
	        });
		},
		createChat(){
			axios.post('/thread',{user:this.selectedUser}).then(response=>{
				if(response.data.status){
					alert('This chat alreadye exists');
				}
				else{
					this.threads.push(response.data);
					this.$emit('threadposted',{
    					id:response.data.id, 
    				});
				}
			});
			$('#addUser').modal('hide');
		}
	}
}
</script>
