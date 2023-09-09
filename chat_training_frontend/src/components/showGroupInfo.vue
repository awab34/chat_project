<script setup>
import axios from 'axios'
import {onMounted , ref} from 'vue'

const props = defineProps({
    groupId: Number
})




async function getUserInfo(){
    try{
        
        const resultData = await axios.request({
    headers: {
      Authorization: `Bearer ${localStorage.getItem("accessToken")}`
    },
    method: "GET",
    url: `http://localhost:8000/api/group-info/${props.groupId}`
  });
  console.log(resultData.data);
  return resultData.data;
      }catch(err){
       console.log(err);
       if (err.response.data.message == "Your email address is not verified.") {
      window.location.replace("/verify");
     }
      }
}

const GroupInfo = await getUserInfo();
</script>

<template>
    <main>
        <div class="rounded-3 mx-auto cardsColor mt-5">
      <div class="d-flex">
        <p class="textColor text-28 ms-sm-3 ms-1 ms-md-5 bold ">Group Name:</p>
        <p class="headerColor text-28 mx-auto ms-2">{{ GroupInfo.group.group_name }}</p>
      </div>
      
      <hr class="text-white">
      <div class="d-flex">
        <p class="textColor text-28 ms-sm-3 ms-1 ms-md-5 bold ">Admin</p>
        <p class="headerColor text-28 ms-2">{{ GroupInfo.admin.name }}</p>
      </div>
      
      <hr class="text-white">
      <div class="d-flex">
        <p class="textColor text-28 ms-sm-3 ms-1 ms-md-5 bold ">Description:</p>
        <p class="headerColor text-28 ms-2">{{ GroupInfo.group.description }}</p>
      </div>
      <hr class="text-white">
      <div>
        <p class="textColor text-28 ms-sm-3 ms-1 ms-md-5 bold ">Users:</p>
        <ul class="list-group mb-3  w-75 mx-auto">
  <li class="list-group-item text-28 text-center mb-1" v-for="user in GroupInfo.group.users" :key="user.id" >{{ user.name }}</li>
</ul>
      </div>
      <div class="d-flex" v-if="GroupInfo.userId == GroupInfo.admin.id">
        <a :href="'/updategroup?'+groupId" class="btn btn-success mx-auto mb-3 text-28">Update Account</a>
      </div>
      
      
      </div>
        
    </main>
  </template>