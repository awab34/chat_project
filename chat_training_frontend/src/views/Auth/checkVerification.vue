<script setup>
import { onMounted } from 'vue';
import axios from 'axios'

async function verificationFunction(){
    const currentUrl = window.location.href;
    const myArray = currentUrl.split("?");
    const variablesArray = myArray[1].split("&");
    const id = variablesArray[0].split("=");
    const hash = variablesArray[1].split("=");
    const verificationUrl = "http://localhost:8000/api/email/verify/"+id[1]+"/"+hash[1]+"?"+variablesArray[2]+"&"+variablesArray[3];
    console.log("hi awab")
    try{
        const resultData = await axios.request({
    headers: {
      Authorization: `Bearer ${localStorage.getItem("accessToken")}`
    },
    method: "GET",
    url: verificationUrl
  });
  console.log(resultData.data.verified);
  if(resultData.data.verified){
    window.location.replace("/home");
  }
  return resultData.data;
      }catch(err){
       
      }
}

    
onMounted(async ()=>{
   await verificationFunction();
});
    



</script>

<template>
        <div class='d-flex justify-content-center pb-3 mt-5'>
        <div class='spinner-border text-primary' role='status'>
        <span class='sr-only'></span>
        </div></div>

</template>