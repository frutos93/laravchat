<template>
    <div>
         <li class="left clearfix">
            <div class="chat-body1 clearfix">
                <p>{{message.message}}</p>
                <div v-if="isSameUser(message.user_id)" class="chat_time pull-right"><strong>You</strong></div>
                <div v-else class="chat_time pull-left"><strong>{{message.user}}</strong></div>
            </div>
        </li>
    </div>
</template>

<script>
    export default {
        props:['message', 'currentuser'],
        methods:{
            isSameUser(id){
                return this.currentuser.id == id;
            }
        } 
    }
</script>
