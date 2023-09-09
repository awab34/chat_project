<script setup>
import axios from 'axios'

defineProps({
  activePage: String,
  friendArray: Array,
  groupInfo: Array
})
async function logout(){
    try{
        
        const resultData = await axios.request({
    headers: {
      Authorization: `Bearer ${localStorage.getItem("accessToken")}`
    },
    method: "GET",
    url: `http://localhost:8000/api/logout`
  });
  console.log(resultData.data.success)
  if(resultData.data.success){
    localStorage.removeItem('accessToken');
    window.location.replace("/");
  }
  
  return resultData.data;
      }catch(err){
       console.log(err);

      }
}

</script>

<template>
  <main>
    <nav class="navbar navbar-dark cardsColor fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand headerColor" href="#">header</a>
    <button class="navbar-toggler headerColor" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Dark offcanvas</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item">
            <a :class="'nav-link ' +( activePage == '1'? 'active' :'')" aria-current="page" href="/home">Home</a>
          </li>
          <li class="nav-item">
            <a :class="'nav-link ' +( activePage == '0'? 'active' :'')"  href="/userinfo">Account Info</a>
          </li>
          <li class="nav-item">
            <a :class="'nav-link '" v-if="activePage == '0'" href="/resetpassword">Reset Password</a>
          </li>
          <li class="nav-item"> 
            <a :class="'nav-link '" v-if="activePage == '0'" href="/change-email">Change Email</a>
          </li>
          <li class="nav-item">
            <a :class="'nav-link ' + (activePage == '2'? 'active' :'')" href="/createfriends">Add New Friends</a>
          </li>
          <li class="nav-item">
            <a :class="'nav-link ' + (activePage == '3'? 'active' :'')" href="/creategroup">Create A New Group</a>
          </li>
          <li class="nav-item">
            <a :class="'nav-link ' + (activePage == '4'? 'active' :'')" href="/showfriends">Show Friends</a>
          </li>
          <li class="nav-item">
            <a :class="'nav-link ' + (activePage == '5'? 'active' :'')" href="/showfriendrequests">Friends Requests</a>
          </li>
          <li class="nav-item" v-if="groupInfo">
            <a class="nav-link active" :href="'/groupinfo?' + groupInfo.id">{{ groupInfo.group_name }}</a>
          </li>
          <li class="nav-item" v-if="friendArray">
            <a class="nav-link active" :href="'/friendinfo?' + friendArray.id">{{ friendArray.name }}</a>
          </li>
          <li class="nav-item" >
            <a class="nav-link" @click="logout">Logout</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>
  </main>
</template>