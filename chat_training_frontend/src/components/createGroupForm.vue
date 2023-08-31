<script setup>

import axios from 'axios'
import {ref,onMounted} from 'vue'
import {$toast} from '../main.js'


let groupName = null;
let description = null;
const users = ref([]);

async function getUserFriends(){
    try{
        const resultData = await axios.request({
    headers: {
      Authorization: `Bearer ${localStorage.getItem("accessToken")}`
    },
    method: "GET",
    url: `http://localhost:8000/api/friends`
  });
  console.log(resultData.data);
  
  return resultData.data;
      }catch(err){
       console.log(err);
      }
}
const userFriends = await getUserFriends();

function createGroup(){
  document.getElementById("switch").innerHTML = "<div class='d-flex justify-content-center pb-3'><div class='spinner-border text-primary' role='status'><span class='sr-only'></span></div></div>"
    let checkbox = document.getElementsByName("users[]");
  let usersArray = [];
  checkbox.forEach(element => {
    if(element.checked){
      usersArray.push(element.value);
    }
  });
  console.log(usersArray);
  axios.request({
  headers: {
    Authorization: `Bearer ${localStorage.getItem("accessToken")}`
  },
  params:{group_name:groupName,
    users:usersArray,
    description:description
},
  method: "POST",
  url: `http://localhost:8000/api/group-store`
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
    $toast.success(`Successfully Created`)
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
        <label for="exampleInputUserName1" class="textColor">Group Name:</label>
        <input class="form-control" v-model="groupName" id="exampleInputUserName1" type="text" placeholder="Default input">
    </div>
    <div class="form-group">
        <label for="exampleFormControlTextarea1" class="textColor">Description:</label>
        <textarea class="form-control mb-3" v-model="description"  id="exampleFormControlTextarea1" rows="3"></textarea>
    </div>
    <div class="form-group">
      <p class="textColor text-28 ms-sm-3 ms-1 ms-md-5 bold ">Add Users:</p>
      <div class="form-check" v-for="friend in userFriends.friends">
    <input type="checkbox"  name="users[]" :value="friend.id" class="form-check-input ms-auto  " :key="friend.id" id="exampleCheck1" >
    <label class="form-check-label ms-2  headerColor" for="exampleCheck1">{{ friend.name }}</label>
  </div>
    </div>
    
    
    <div class="d-flex justify-content-center" id="switch">
        <button type="button" class="btn btn-primary buttonColor bold width-half mx-auto  mb-3 align-content-center" @click="createGroup">Update</button>
    </div>
    </form>
    </div>

</main>

</template>