<script setup>

import axios from 'axios'
import {onMounted} from 'vue'
import {$toast} from '../main.js'
let email = null;
let password = null;
let oldPassword = null;
let userName = null;
let password_confirmation = null;
let description = null;
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
  console.log(resultData.data.userData.name);
  userName = resultData.data.userData.name;
  email = resultData.data.userData.email;
  description = resultData.data.userData.description;
  return resultData.data;
      }catch(err){
       console.log(err);
      }
}
const userInfoData = await getUserInfo();

function updateUserAccount(){
  document.getElementById("switch").innerHTML = "<div class='d-flex justify-content-center pb-3'><div class='spinner-border text-primary' role='status'><span class='sr-only'></span></div></div>"

  axios.request({
  headers: {
    Authorization: `Bearer ${localStorage.getItem("accessToken")}`
  },
  params:{email:email,
    password:password,
    oldPassword:oldPassword,
    name:userName,
    password_confirmation:password_confirmation,
    description:description
},
  method: "PUT",
  url: `http://localhost:8000/api/update-user`
}).then((response)=>{
  if(response.data.success){
  localStorage.setItem("success", true);
  location.reload();
}
}).catch((err)=>{
  if(err.response.data.error){
                    localStorage.setItem("error", `${err.response.data.error}`);
  }else{
    const errorsObject = err.response.data.errors;
    const keysArray = Object.keys(errorsObject);
    
    for(let i = 0; i < keysArray.length; i++){
      localStorage.setItem(`error${i}`, `${errorsObject[keysArray[i]][0]}`);
    }


                  }
               location.reload();console.log(err);
});
}

onMounted(() => {
  let keys = Object.keys(localStorage);
  if(localStorage.getItem("success")){
    $toast.success(`Successfully Updated`)
    localStorage.removeItem("success")
  }
for(let key of keys) {

  if(key == 'error0' || key == 'error1' || key == 'error2' || key == 'error3' || key == 'error'){
    console.log(localStorage.getItem(key));
    $toast.error(`${localStorage.getItem(key)}`)
    localStorage.removeItem(key)

  }
  
}
})

</script>

<template>
<main>
    <div class="cardsColor rounded-2 mt-5 mx-auto" style="max-width: 750px;">
    <form class="m-3 ">
    <div class="form-group">
        <label for="exampleInputUserName1" class="textColor">User Name:</label>
        <input class="form-control" v-model="userName" id="exampleInputUserName1" type="text" placeholder="Default input">
    </div>
      
    <div class="form-group">
        <label for="exampleInputEmail1" class="textColor">Email address:</label>
        <input type="email" class="form-control" v-model="email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1" class="textColor">Old Password:</label>
        <input type="password" class="form-control" v-model="oldPassword" id="exampleInputPassword1" placeholder="Password">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword3" class="textColor">New Password:</label>
        <input type="password" class="form-control" v-model="password" id="exampleInputPassword3" placeholder="Password">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword2" class="textColor">Repeat New Password:</label>
        <input type="password" class="form-control" v-model="password_confirmation" id="exampleInputPassword2" placeholder="Password">
    </div>
    <div class="form-group">
        <label for="exampleFormControlTextarea1" class="textColor">Description:</label>
        <textarea class="form-control mb-3" v-model="description"  id="exampleFormControlTextarea1" rows="3"></textarea>
    </div>
    <div class="d-flex justify-content-center" id="switch">
        <button type="button" class="btn btn-primary buttonColor bold width-half mx-auto  mb-3 align-content-center" @click="updateUserAccount">Update</button>
    </div>
    </form>
    </div>

</main>

</template>