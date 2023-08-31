<script setup>
import axios from 'axios'
import {onMounted} from 'vue'
import {$toast} from '../../main.js'

let email = null;
let password = null;
let userName = null;
let password_confirmation = null;
let description = null;
function registerFunction(){
  document.getElementById("switch").innerHTML = "<div class='d-flex justify-content-center pb-3'><div class='spinner-border text-primary' role='status'><span class='sr-only'></span></div></div>"
  axios.post('http://localhost:8000/api/register', {
    name:userName,
    email: email,
    password: password,
    password_confirmation:password_confirmation,
    description:description
                })
                .then(function (response) {
                  localStorage.setItem('accessToken',response.data.token);
                  console.log(localStorage.getItem('accessToken'));
                  localStorage.setItem("welcome", `Welcome ${userName}`);
                  window.location.replace("/home");


                })
                .catch(function (error) {
                  if(error.response.data.error){
                    localStorage.setItem("error", `${error.response.data.error}`);
  }else{
    const errorsObject = error.response.data.errors;
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
    <div class="cardsColor rounded-2 mx-auto" style="max-width: 750px;">
    <form class="m-3 " >
      <div class="form-group">
    <label for="exampleInputUserName1" class="textColor">User Name:</label>
    <input class="form-control" v-model="userName" id="exampleInputUserName1" type="text" placeholder="Default input">
  </div>
      
  <div class="form-group">
    <label for="exampleInputEmail1" class="textColor">Email address:</label>
    <input type="email" class="form-control" v-model="email" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1" class="textColor">Password:</label>
    <input type="password" class="form-control" v-model="password" id="exampleInputPassword1" placeholder="Password">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword2" class="textColor">Repeat Password:</label>
    <input type="password" class="form-control" v-model="password_confirmation" id="exampleInputPassword2" placeholder="Password">
  </div>
  <div class="form-group mb-3 pb-3">
    <label for="exampleFormControlTextarea1" class="textColor">Description:</label>
    <textarea class="form-control" v-model="description" id="exampleFormControlTextarea1" rows="3"></textarea>
  </div>
  <div id="switch">
    <button type="button" @click="registerFunction" class="btn btn-primary mb-3  text-28 buttonColor width-half buttonColor">Submit</button>
  <RouterLink class="btn btn-primary mb-3 width-half text-28 buttonColor buttonColor " to="/">Login</RouterLink>
  </div>
  
</form>
</div>
  </main>
</template>
<style>

</style>