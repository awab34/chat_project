<script setup>
import axios from 'axios'

async function getUserInfo(){
    try{
        const resultData = await axios.request({
    headers: {
      Authorization: `Bearer ${localStorage.getItem("accessToken")}`
    },
    method: "GET",
    url: `http://localhost:8000/api/user-data`
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
const userInfoData = await getUserInfo();

</script>

<template>
    <main>
        <div class="rounded-3 mx-auto cardsColor" style="max-width: 900px;">
      <div class="d-flex">
        <p class="textColor text-28 ms-sm-3 ms-1 ms-md-5 bold ">User Name:</p>
        <p class="headerColor text-28 mx-auto ms-2">{{ userInfoData.userData.name }}</p>
      </div>
      
      <hr class="text-white">
      <div class="d-flex">
        <p class="textColor text-28 ms-sm-3 ms-1 ms-md-5 bold ">E-Mail:</p>
        <p class="headerColor text-28 ms-2">{{ userInfoData.userData.email }}</p>
      </div>
      
      <hr class="text-white">
      <div class="d-flex">
        <p class="textColor text-28 ms-sm-3 ms-1 ms-md-5 bold ">Description:</p>
        <p class="headerColor text-28 ms-2">{{ userInfoData.userData.description }}</p>
      </div>
      <hr class="text-white">
      <div class="d-flex">
        <a href="/updateUser" class="btn btn-success mx-auto mb-3 text-28">Update Account</a>
      </div>
      
      </div>
        
    </main>
  </template>