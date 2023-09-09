

<template>
  
    <main class="mx-auto mt-5" style="max-width: 900px;">
    
      <div class="rounded-3 mx-auto cardsColor">
      <div class="d-flex">
        <p class="textColor text-28 ms-sm-3 ms-1 ms-md-5 bold ">User Name:</p>
        <p class="headerColor text-28 mx-auto ms-2">{{ friendInfoData.friendInfo.name }}</p>
      </div>
      
      <hr class="text-white">
      <div class="d-flex">
        <p class="textColor text-28 ms-sm-3 ms-1 ms-md-5 bold ">E-Mail:</p>
        <p class="headerColor text-28 ms-2">{{ friendInfoData.friendInfo.email }}</p>
      </div>
      
      <hr class="text-white">
      <div class="d-flex">
        <p class="textColor text-28 ms-sm-3 ms-1 ms-md-5 bold ">Description:</p>
        <p class="headerColor text-28 ms-2">{{ friendInfoData.friendInfo.description }}</p>
      </div>
      
      </div>
    </main>
      
      
      
    
  </template>
<script setup>
import axios from 'axios'
  const props = defineProps({
  friendId: Number
  })


  const getFriendInfo = async ()=>{
      try{
        const resultData = await axios.request({
    headers: {
      Authorization: `Bearer ${localStorage.getItem("accessToken")}`
    },
    method: "GET",
    url: `http://localhost:8000/api/friend-info/${props.friendId}`
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
  const friendInfoData = await getFriendInfo();
  
  
  </script>