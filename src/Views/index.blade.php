@extends('layouts.app')
@section('content')
<div class="main_section">
   <div class="container">
      <div class="chat_container">
         <div class="col-sm-3 chat_sidebar">
       <div class="row">
           <laravchat-thread :threads="threads" v-on:changethread="currentThread"></laravchat-thread>
         </div>
         </div>
         <!--chat_sidebar-->


         <div class="col-sm-9 message_section">
       <div class="row">
       <laravchat-add :threads="threads"></laravchat-add>
       <laravchat-log :messages="messages" :currentuser="currentuser"></laravchat-log>
       <laravchat-composer v-on:messagesent="submitMessage"></laravchat-composer>
       </div>
         </div> <!--message_section-->
      </div>
   </div>
</div>
   </div>

@endsection
