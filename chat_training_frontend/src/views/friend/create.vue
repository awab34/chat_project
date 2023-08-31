<script setup>
import axios from 'axios';
import HomePageHeader from '../../components/homePageHeader.vue';
import { ref } from 'vue';

const componentKey = ref(0);

let userName = null;
let newFriends = [];

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
  componentKey.value += 1;
}).catch((err)=>{
  console.log(err);
});

    
  
}

function sendFriendRequest (id){
    axios.request({
  headers: {
    Authorization: `Bearer ${localStorage.getItem("accessToken")}`
  },
  method: "GET",
  url: `http://localhost:8000/api/request-friend/${id}`
}).then((response)=>{
  console.log(response.data);
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
  componentKey.value += 1;
}).catch((err)=>{
  console.log(err);
});
  
}).catch((err)=>{
  console.log(err);
});

    
  
}
</script>

<template>
  <main class="w-100">
<HomePageHeader active-page="2"/>
<form class="d-flex mx-auto mt-5" role="search" >
  
  <input class="form-control me-2 ms-auto " v-model="userName" type="search" style="max-width: 350px;" name="name" placeholder="Find Friends" aria-label="Search">
  <button class="btn btn-success me-auto" type="button" @click="getNewFriend" >Search</button>
</form>
<div :key="componentKey">
  <ul class="list-group mx-auto" v-for="friend in newFriends" :key="friend.id">
  <li class="list-group-item text-center d-flex">
  
  <p class=" text-decoration-none text-center text-28 bold my-auto">{{ friend.name }}</p> 
<a @click="sendFriendRequest(friend.id)" class="text-decoration-none text-black text-center my-auto ms-auto text-28">Request Friendship</a></li>
  
</ul>
</div>
  

  </main>
</template>