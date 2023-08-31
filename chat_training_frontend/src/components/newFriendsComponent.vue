<script setup>
import axios from 'axios'
import { getCurrentInstance } from 'vue';
import {onMounted} from 'vue';
import { ref } from 'vue';

const componentKey = ref(0);

let userName = null;
let newFriends = [];
let instance = null;

function getNewFriend (){
    axios.request({
  headers: {
    Authorization: `Bearer ${localStorage.getItem("accessToken")}`
  },
  params:{name:userName},
  method: "POST",
  url: `http://localhost:8000/api/search-friend`
}).then((response)=>{
  console.log(response.data.searchResult);
  newFriends = response.data.searchResult;
  
  
}).catch((err)=>{
  console.log(err);
});  
}
onMounted(() => {
    instance = getCurrentInstance();
});
</script>

<template>
  <main class="w-100">

<form class="d-flex mx-auto   mt-5" role="search" >
  
  <input class="form-control me-2 ms-auto " v-model="userName" type="search" style="max-width: 350px;" name="name" placeholder="Find Friends" aria-label="Search">
  <button class="btn btn-success me-auto" type="button" @click="getNewFriend" >Search</button>
</form>

  <ul class="list-group mx-auto" v-for="friend in newFriends" :key="friend.id">
  <li class="list-group-item text-center">
  <a :href="'/showfriendchat?'+friend.id" class="mx-auto text-decoration-none text-black text-center">
  <p class="mx-auto text-decoration-none text-center text-28 bold">{{ friend.name }}</p> 
       </a><a :href="'/unfriend/'+friend.id">Unfriend</a></li>
  
</ul>

  </main>
</template>