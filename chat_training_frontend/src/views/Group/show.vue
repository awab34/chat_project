<script setup>
import {  ref,onMounted } from 'vue';
import HomePageHeader from '../../components/homePageHeader.vue';
import axios from 'axios';
import showGroupChatMessages from '../../components/showGroupChatMessages.vue';
const groupId = ref(null);
const message = ref(null);
const messages = ref([]);
const messagesComponentKey = ref(0);
const userId = ref(0);
const users = ref([]);
const friends = ref([]);
const divKey = ref(0);
const reponseState = ref(false);
const groupInfo = ref([]);
onMounted(()=>{
  const currentUrl = window.location.href;
  
  
  const myArray = currentUrl.split("?");
  groupId.value = myArray[myArray.length - 1];

  axios.request({
    headers: {
      Authorization: `Bearer ${localStorage.getItem("accessToken")}`
    },
    method: "GET",
    url: `http://localhost:8000/api/show-group/${groupId.value}`
  }).then((response)=>{
    console.log(response.data);
    messages.value = response.data.messages;
    userId.value = response.data.userId;
    groupInfo.value = response.data.group;
    users.value = response.data.group.users;
    friends.value = response.data.friends;
    console.log(friends.value);
    messagesComponentKey.value += 1;
    reponseState.value = true;
  }).catch((err)=>{
    console.log(err)
  });
});

function checkGroupUser(id){
  const cheched = ref(false);
  console.log(id)
  users.value.forEach(element => {
    if(element.id == id){
      cheched.value = true;
    }
  });
  return cheched.value
}

function addUsers(){
  let checkbox = document.getElementsByName("users[]");
  let usersArray = [];
  checkbox.forEach(element => {
    if(element.checked){
      usersArray.push(element.value);
    }
  });
  console.log(usersArray);
  axios.request({
    headers: {
      Authorization: `Bearer ${localStorage.getItem("accessToken")}`
    },
    params:{
      users:usersArray
    },
    method: "PUT",
    url: `http://localhost:8000/api/update-group/${groupId.value}`
  }).then((response)=>{
    console.log(response);
    divKey.value += 1;
  }).catch((err)=>{
    console.log(err)
  });
}


function sendMessage(){
  axios.request({
  headers: {
    Authorization: `Bearer ${localStorage.getItem("accessToken")}`
  },
  params:{message:message.value,receiver_id:groupId.value},
  method: "POST",
  url: `http://localhost:8000/api/message-store`
}).then((response)=>{
  axios.request({
    headers: {
      Authorization: `Bearer ${localStorage.getItem("accessToken")}`
    },
    method: "GET",
    url: `http://localhost:8000/api/show-group/${groupId.value}`
  }).then((response)=>{
    document.getElementById("myForm").reset();
    message.value = null;
    console.log(response.data);
    messages.value = response.data.messages;
    userId.value = response.data.userId;
    users.value = response.data.group.users;
    friends.value = response.data.friends;
    console.log(friends.value);
    messagesComponentKey.value += 1;
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
    url: `http://localhost:8000/api/show-group/${groupId.value}`
  }).then((response)=>{
    console.log(response.data);
    messages.value = response.data.messages;
    userId.value = response.data.userId;
    users.value = response.data.group.users;
    friends.value = response.data.friends;
    console.log(friends.value);
    messagesComponentKey.value += 1;
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
    <HomePageHeader :group-info="groupInfo" />
    <showGroupChatMessages class="mt-5" :messages-array="messages" :key="messagesComponentKey" :user-id="userId" @deleteMessage="(id) =>deleteMessages(id)"/> 
     <div :key="divKey" v-if="reponseState">
     <div v-if="friends.length == 0">
        <a href="/createfriends" class="btn btn-success mx-auto text-28">Please Add New Friends</a>
     </div>
     <div v-else>
      <form class="mt-5" id="myForm" v-if="users.length < 2" >
      <div class="cardsColor rounded-3">
        <div class="form-check" v-for="friend in friends" :key="friend.id">
    <input type="checkbox" name="users[]" :value="friend.id" class="form-check-input ms-auto  " id="exampleCheck1" :checked="checkGroupUser(friend.id)" >
    <label class="form-check-label ms-2  headerColor" for="exampleCheck1">{{ friend.name }}</label>
  </div>
  
  <button class="btn btn-success   ms-3" @click="addUsers" type="button"  >Add Users</button>
      </div>
        
</form>
  <form class="d-flex mx-auto   mt-5" id="myForm" v-else>
  
  <input class="form-control me-2 ms-auto " id="myForm" v-model="message" type="text" style="max-width: 350px;" name="message" placeholder="Send Message">
  <button class="btn btn-success me-auto" type="button" @click="sendMessage" >Send</button>
</form>
     </div>
      
     </div> 
    
  </main>
</template>