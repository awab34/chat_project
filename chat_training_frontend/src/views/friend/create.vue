<script setup>
import axios from 'axios';
import HomePageHeader from '../../components/homePageHeader.vue';
import { ref,onMounted } from 'vue';
import {$toast} from '../../main.js'
const componentKey = ref(0);

let userName = null;
let newFriends = [];
let searchStatus = false;
async function getNewFriend (){
  const buttonToDisable = document.getElementById("buttonToDisable"); 
  buttonToDisable.disabled = true;

    await axios.request({
  headers: {
    Authorization: `Bearer ${localStorage.getItem("accessToken")}`
  },
  params:{name:userName},
  method: "POST",
  url: `http://localhost:8000/api/search-friend`
}).then((response)=>{
  console.log(response.data.searchResult);
  newFriends = response.data.searchResult;
  searchStatus = response.data.searchStatus;
  componentKey.value += 1;
}).catch((err)=>{
  console.log(err);
  localStorage.setItem("error", `${err.response.data.error}`);


                  
               location.reload();
});
buttonToDisable.disabled = false;
    
  
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
  localStorage.setItem("success", `Requested Successfully`);
  location.reload();
}).catch((err)=>{
  console.log(err);
  localStorage.setItem("error", `${err.response.data.error}`);
  location.reload();
});
  
}).catch((err)=>{
  console.log(err);
  localStorage.setItem("error", `${err.response.data.error}`);
  location.reload();
});  
  
}

onMounted(() => {
  if(localStorage.getItem("success")){
    $toast.success(`${localStorage.getItem("success")}`)
    localStorage.removeItem("success")
  }else if(localStorage.getItem("error")){
    $toast.open({
    message: `${localStorage.getItem("error")}`,
    type:'error',
    duration: 20000,
})
    localStorage.removeItem("error")
  }
  
  })
</script>

<template>
  <main class="w-100">
<HomePageHeader active-page="2"/>
<form class="d-flex mx-auto mt-5" role="search" >
  
  <input class="form-control me-2 ms-auto " v-model="userName" type="search" style="max-width: 350px;" name="name" placeholder="Find Friends" aria-label="Search">
  <button class="btn btn-success me-auto" id="buttonToDisable" type="button" @click="getNewFriend" >Search</button>
</form>
<div :key="componentKey">

  <ul class="list-group mx-auto mt-5 " v-if="newFriends.length > 0" style="max-width: 900px;">
  <li class="list-group-item cardsColor2 text-center d-flex" v-for="friend in newFriends" :key="friend.id" >
  
  <p class=" text-decoration-none text-center text-28 bold my-auto">{{ friend.name }}</p> 
<a @click="sendFriendRequest(friend.id)" class="text-decoration-none text-black pointer-change-cursor  cardsColor rounded-5 px-2 text-center my-auto ms-auto text-28 ">Add Friend</a></li>
  
</ul>
<div v-else>
  <h1 class="text-28 text-center mt-3" v-if="searchStatus" >No Users Found</h1>
</div>

</div>
  

  </main>
</template>