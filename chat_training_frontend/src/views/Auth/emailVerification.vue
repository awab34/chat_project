<script setup>
import axios from 'axios'
import {ref,onMounted} from 'vue'
import {$toast} from '../../main.js'

const email = ref(null);
const verificationKey = ref(0);
async function getUserInfo(){
    try{
        const resultData = await axios.request({
    headers: {
      Authorization: `Bearer ${localStorage.getItem("accessToken")}`
    },
    method: "GET",
    url: `http://localhost:8000/api/show-email`
  });
  console.log(resultData.data);
  
  email.value = resultData.data.email;
  verificationKey.value += 1;
  return resultData.data;
      }catch(err){
       console.log(err);
       if (err.response.data.message == "Your email address is not verified.") {
      window.location.replace("/verify");
     }
      }
}
onMounted(()=>{
  if(localStorage.getItem("success")){
    $toast.success(`Successfully Changed`)
    localStorage.removeItem("success")
  }
})
const userInfoData = getUserInfo();
</script>

<template>
  <div :key="verificationKey">
    <div v-if="email" class="cardsColor rounded-2 mx-auto my-auto" style="max-width: 750px;">
    <h1 class="text-28 pt-5 pb-2 px-3 alert-color">Pleace Verify Your Email By Clicking The URL Sent To You In Your Email:</h1>
    <h1 class="text-28 pb-2 px-3 ">{{ email }}</h1>
    <a href="/change-email-before-verification" class="btn btn-info ms-3 buttonColor2 text-28 mb-2">Change Email</a>
    </div>
    <div v-else class='d-flex justify-content-center pb-3 mt-5'><div class='spinner-border text-primary' role='status'>
    <span class='sr-only'></span></div></div>
  </div>

</template>