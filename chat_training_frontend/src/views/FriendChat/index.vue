<script setup>
import {  ref,onMounted } from 'vue';
import HomePageHeader from '../../components/homePageHeader.vue';
import axios from 'axios';
import ShowFriendChatMessages from '../../components/showFriendChatMessages.vue';
import {$toast} from '../../main.js'
 
const friendId = ref(null);
const message = ref(null);
const messages = ref([]);
const messagesComponentKey = ref(0);
const userId = ref(0);
const friendInfo = ref([]);
const responseState = ref(false);
var w;

function startWorker(id) {
  if(typeof(Worker) !== "undefined") {
    if(typeof(w) == "undefined") {
      
      w = new Worker(new URL('demo_workers.js', import.meta.url));
      w.postMessage([id, localStorage.getItem("accessToken")]);
    }
    
    w.onmessage = function(event) {
      let result = JSON.parse(event.data);
      if(JSON.stringify(result.messages) === JSON.stringify(messages.value)){
      }else{
        messages.value = result.messages;
        messagesComponentKey.value += 1;
      }
    };
  } else {
    console.log( "Sorry, your browser does not support Web Workers...");
  }
}
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
    responseState.value = true;
  }).catch((err)=>{
    console.log(err)
    if (err.response.data.message == "Your email address is not verified.") {
      window.location.replace("/verify");
     }else{
      $toast.open({
    message: `Something went wrong please refresh the page`,
    type:'error',
    duration: 20000,
})
     }
    
  });
  startWorker(friendId.value);
      
    
  

});

function sendMessage(){
  const buttonToDisable = document.getElementById("buttonToDisable"); 
  buttonToDisable.disabled = true;
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
  buttonToDisable.disabled = false;
  }).catch((err)=>{
    console.log(err)
    buttonToDisable.disabled = false;
    $toast.open({
    message: `Something went wrong please send it again`,
    type:'error',
    duration: 20000,
})
  });
  

}).catch((err)=>{
  console.log(err);
  buttonToDisable.disabled = false;
  $toast.open({
    message: `Something went wrong please send it again`,
    type:'error',
    duration: 20000,
})
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
    $toast.open({
    message: `Something went wrong please delete it again`,
    type:'error',
    duration: 20000,
})
  });
  

}).catch((err)=>{
  $toast.open({
    message: `Something went wrong please delete it again`,
    type:'error',
    duration: 20000,
  })
});
}


</script>

<template>
  <main>
  <HomePageHeader :friend-array="friendInfo"/>
  <div :key="messagesComponentKey">
    <ShowFriendChatMessages class="mt-5" :messages-array="messages"  :user-id="userId" @deleteMessage="(id) =>deleteMessages(id)" v-if="responseState"/>
      <div v-else>
    <div class='d-flex justify-content-center pb-3 mt-5'><div class='spinner-border text-primary' role='status'><span class='sr-only'></span></div></div>
  </div>
  </div>
   
  <form class="d-flex mx-auto mt-5" id="myForm">
  
  <input class="form-control me-2 ms-auto " id="myForm" v-model="message" type="text" style="max-width: 350px;" name="message" placeholder="Send Message">
  <button class="btn btn-success me-auto" id="buttonToDisable" type="button" @click="sendMessage" >Send</button>
</form> 
  </main>
</template>