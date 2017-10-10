<template>
	<div class="message_write">
    	<input class="form-control" placeholder="Send Message..." v-model="messageText" @keydown.enter="sendMessage"></textarea>
		<div class="clearfix"></div>
		<div class="chat_bottom">
 			<a href="#" class="pull-right btn btn-success" @click="sendMessage">Send</a>
 		</div>
	</div>
</template>

<script>
    export default {
    	data(){
    		return{
    			messageText: ''
    		}
    	},
    	methods:{
    		sendMessage(){
    			this.$emit('messagesent',{
    				message:this.messageText, 
    			});
    			this.messageText = '';
    		}
    	}

    }
</script>
