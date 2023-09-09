<script setup>

import axios from 'axios'
import {onMounted} from 'vue'
import {$toast} from '../../main.js'
import HomePageHeader from '../../components/homePageHeader.vue';

let email = null;
let password = null;


function updateEmail(){
  document.getElementById("switch").innerHTML = "<div class='d-flex justify-content-center pb-3'><div class='spinner-border text-primary' role='status'><span class='sr-only'></span></div></div>"

  axios.request({
  headers: {
    Authorization: `Bearer ${localStorage.getItem("accessToken")}`
  },
  params:{
    email:email,
    password:password,
},
  method: "PUT",
  url: `http://localhost:8000/api/change-email-before-verification`
}).then((response)=>{
  if(response.data.success){
  localStorage.setItem("success", true);
  window.location.replace("/verify");
}
}).catch((err)=>{
  if(err.response.data.error){
                    localStorage.setItem("error", `${err.response.data.error}`);
  }else if(err.response.data.message){
    localStorage.setItem("error", "Something went wrong please try again");
  }else{
    console.log(err);
    const errorsObject = err.response.data.errors;

    const keysArray = Object.keys(errorsObject);
    
    for(let i = 0; i < keysArray.length; i++){
      localStorage.setItem(`error${i}`, `${errorsObject[keysArray[i]][0]}`);
    }


                  }
               location.reload();
});
}

onMounted(() => {
  let keys = Object.keys(localStorage);
  if(localStorage.getItem("success")){
    $toast.success(`Successfully Changed`)
    localStorage.removeItem("success")
  }
for(let key of keys) {

  if(key == 'error0' || key == 'error1' || key == 'error2' || key == 'error3' || key == 'error'){
    console.log(localStorage.getItem(key));
    $toast.open({
    message: `${localStorage.getItem(key)}`,
    type:'error',
    duration: 20000,
})
    localStorage.removeItem(key)

  }
  
}
})

</script>

<template>
<main>
    <HomePageHeader activePage="6" />
    <div class=" shadow-lg p-3 mb-5 bg-white rounded  rounded-2 mt-5 mx-auto" style="max-width: 750px;">
    <form class="m-3 ">
    <div class="form-group">
        <label for="exampleInputUserName1" >New Email:</label>
        <input class="form-control" v-model="email" id="exampleInputUserName1" type="text" placeholder="Default input">
    </div>
      
    <div class="form-group">
        <label for="exampleInputUserName1" >Password:</label>
        <input class="form-control mb-3" v-model="password" id="exampleInputUserName1" type="password" placeholder="Default input">
    </div>
    
    
    <div class="d-flex justify-content-center" id="switch">
        <button type="button" class="btn btn-primary cardsColor bold width-half mx-auto  mb-3 align-content-center" @click="updateEmail">Change</button>
    </div>
    </form>
    </div>

</main>

</template>