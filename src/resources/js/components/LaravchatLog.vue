<template>
    <div class="chat_area">
         <ul class="list-unstyled">
            <laravchat-message v-for="message in messages" :message="message" :currentuser="currentuser" ></laravchat-message>
        </ul>
    </div><!--chat_area-->
</template>

<script>
    export default {
        props:['messages', 'currentuser']
    }
</script>
