<template>
 <div class="member_list">
    <ul class="list-unstyled">
        <li v-for="thread in threads" :thread="thread" class="left clearfix" @click="changeCurrentThread(thread.id)">
            <div class="chat-body clearfix">
                <div class="header_sec">
                    <strong class="primary-font">{{thread.title}}</strong>
                    <strong v-if="thread.new" style="color:red;" class="pull-right">New</strong>
                </div>
            </div>
        </li>
    </ul>
</div>
</template>

<script>
    export default {
        props: ['threads', 'messages'],
        methods:{
            changeCurrentThread(id){
                this.$emit('changethread',{
                    id: id,
                });
            }
        }        
    }
</script>
