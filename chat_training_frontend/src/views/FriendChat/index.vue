<script setup>
import {  ref,onMounted } from 'vue';
import HomePageHeader from '../../components/homePageHeader.vue';
import axios from 'axios';
import ShowFriendChatMessages from '../../components/showFriendChatMessages.vue';

const friendId = ref(null);
const message = ref(null);
const messages = ref([]);
const messagesComponentKey = ref(0);
const userId = ref(0);
const friendInfo = ref([]);
onMounted(()=>{
  const currentUrl = window.location.href;
  
  
  const myArray = currentUrl.split("?");
  friendId.value = myArray[myArray.length - 1];

  axios.request({
    headers: {
      Authorization: `Bearer ${localStorage.getItem("accessToken")}`
    },
    method: "GET",
    url: `http://localhost:8000/api/message-friend/${friendId.value}`
  }).then((response)=>{
    console.log(response.data);
    userId.value = response.data.userId;
    messages.value = response.data.messages;
    messagesComponentKey.value += 1;
    friendInfo.value = response.data.friendInfo;
  }).catch((err)=>{
    console.log(err)
  });
  
      
    
  

});

function sendMessage(){
  axios.request({
  headers: {
    Authorization: `Bearer ${localStorage.getItem("accessToken")}`
  },
  params:{message:message.value,reciever:friendId.value},
  method: "GET",
  url: `http://localhost:8000/api/message-store-friend-chat`
}).then((response)=>{
  axios.request({
    headers: {
      Authorization: `Bearer ${localStorage.getItem("accessToken")}`
    },
    method: "GET",
    url: `http://localhost:8000/api/message-friend/${friendId.value}`
  }).then((response)=>{
    document.getElementById("myForm").reset();
    message.value = null;
    console.log(response.data.messages);
    userId.value = response.data.userId;
    messages.value = response.data.messages;
    messagesComponentKey.value += 1;
    location.href = "#myForm";
  }).catch((err)=>{
    console.log(err)
  });
  

}).catch((err)=>{
  console.log(err);
});
}

function deleteMessages(id){
  axios.request({
  headers: {
    Authorization: `Bearer ${localStorage.getItem("accessToken")}`
  },
  method: "GET",
  url: `http://localhost:8000/api/delete-message/${id}`
}).then((response)=>{
  axios.request({
    headers: {
      Authorization: `Bearer ${localStorage.getItem("accessToken")}`
    },
    method: "GET",
    url: `http://localhost:8000/api/message-friend/${friendId.value}`
  }).then((response)=>{
    console.log(response.data.messages);
    userId.value = response.data.userId;
    messages.value = response.data.messages;
    messagesComponentKey.value += 1;
    location.href = "#myForm";
  }).catch((err)=>{
    console.log(err)
  });
  

}).catch((err)=>{
  console.log(err);
});
}

</script>

<template>
  <main>
  <HomePageHeader :friend-array="friendInfo"/>
   <ShowFriendChatMessages class="mt-5" :messages-array="messages" :key="messagesComponentKey" :user-id="userId" @deleteMessage="(id) =>deleteMessages(id)"/> 
  <form class="d-flex mx-auto mt-5" id="myForm">
  
  <input class="form-control me-2 ms-auto " id="myForm" v-model="message" type="text" style="max-width: 350px;" name="message" placeholder="Send Message">
  <button class="btn btn-success me-auto" type="button" @click="sendMessage" >Send</button>
</form> 
  </main>
</template>