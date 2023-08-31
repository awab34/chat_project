<script setup>
import axios from 'axios'
import {$toast} from '../../main.js'
import {onMounted} from 'vue'
let email = null;
let password = null;
let rememberMe = false;
function loginFunction(){
  document.getElementById("switch").innerHTML = "<div class='d-flex justify-content-center pb-3'><div class='spinner-border text-primary' role='status'><span class='sr-only'></span></div></div>"
  axios.post('http://localhost:8000/api/login', {
    email: email,
    password: password
                    ,
                    remember: rememberMe
                })
                .then(function (response) {
                  if(response.data.token){
                    localStorage.setItem('accessToken',response.data.token);
                    console.log(localStorage.getItem('accessToken'));
                    localStorage.setItem("welcome", `Welcome ${response.data.user.name}`);
                    window.location.replace("/home");
                  }
                  console.log(response.data);
                  //store.state.user.token = response.data.token;
                  //console.log(store.state.user.token);
                })
                .catch(function (error) {
                  if(error.response.data.error){
                    localStorage.setItem("error", `${error.response.data.error}`);
  }else{
    if(error.response.data.errors.email && error.response.data.errors.password){
      console.log(error.response.data.errors.email);
      console.log(error.response.data.errors.password);
      localStorage.setItem("email", `${error.response.data.errors.email}`);
      localStorage.setItem("password", `${error.response.data.errors.password}`);
                     
                    }else if(error.response.data.errors.password){
                      localStorage.setItem("password", `${error.response.data.errors.password}`);
                    }else if(error.response.data.errors.email){
                      localStorage.setItem("email", `${error.response.data.errors.email}`);
                    }else{
                      localStorage.setItem("error", `Something went wrong please try again`);
                     
                    }
                  
                    
                  }
                  location.reload();
                    
                });
}

onMounted(() => {
  
  if(localStorage.getItem("error")){
    console.log(localStorage.getItem("error"));
    $toast.error(`${localStorage.getItem("error")}`)
    localStorage.removeItem("error")
  }else{
    if(localStorage.getItem("password") && localStorage.getItem("email")){
                      $toast.error(`${localStorage.getItem("email")}`)
                      $toast.error(`${localStorage.getItem("password")}`)
                      localStorage.removeItem("email")
                      localStorage.removeItem("password")
                    }else if(localStorage.getItem("password")){
                      $toast.error(`${localStorage.getItem("password")}`)
                      localStorage.removeItem("password")
                    }else if(localStorage.getItem("email")){
                      $toast.error(`${localStorage.getItem("email")}`)
                      localStorage.removeItem("email")
                    }
                  
                    
                  }
})

</script>

<template>
  
  <main>

  <div class="cardsColor rounded-2 mx-auto" style="max-width: 750px;">
    <form class="m-3 " >
  <div class="form-group">
    <label for="exampleInputEmail1" class="textColor">Email address</label>
    <input type="email" name="email"  v-model="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
  </div>
  <div class="form-group" >
    <label for="exampleInputPassword1" class="textColor">Password</label>
    <input type="password" name="password"  v-model="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
  </div>
  <div class="form-check">
    <input type="checkbox" name="remember"  v-model="rememberMe" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label textColor"  for="exampleCheck1">Remember Me</label>
  </div>
  
  
<div id="switch">
  <button @click="loginFunction" type="button" class="btn btn-primary mb-3 text-28 buttonColor width-half ">Submit</button>
  <RouterLink class="btn btn-primary mb-3 width-half text-28 buttonColor" to="/register">New User</RouterLink>
</div>
  
</form>
  </div>
      
    

  </main>
</template>
<style>

</style>