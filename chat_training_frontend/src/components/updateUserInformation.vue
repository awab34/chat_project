<script setup>

import axios from 'axios'
import {onMounted} from 'vue'
import {$toast} from '../main.js'

let userName = null;
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
  description = resultData.data.userData.description;
  return resultData.data;
      }catch(err){
       console.log(err);
       if (err.response.data.message == "Your email address is not verified.") {
      window.location.replace("/verify");
     }
      }
}
const userInfoData = await getUserInfo();

function updateUserAccount(){
  document.getElementById("switch").innerHTML = "<div class='d-flex justify-content-center pb-3'><div class='spinner-border text-primary' role='status'><span class='sr-only'></span></div></div>"

  axios.request({
  headers: {
    Authorization: `Bearer ${localStorage.getItem("accessToken")}`
  },
  params:{
    name:userName,
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
  }else if(err.response.data.message){
                    localStorage.setItem("error", `${err.response.data.message}`);
  }else{
    console.log(err);
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
    <div class=" shadow-lg p-3 mb-5 bg-white rounded  rounded-2 mt-5 mx-auto" style="max-width: 750px;">
    <form class="m-3 ">
    <div class="form-group">
        <label for="exampleInputUserName1" >User Name:</label>
        <input class="form-control" v-model="userName" id="exampleInputUserName1" type="text" placeholder="Default input">
    </div>
    <div class="form-group">
        <label for="exampleFormControlTextarea1" >Description:</label>
        <textarea class="form-control mb-3" v-model="description"  id="exampleFormControlTextarea1" rows="3"></textarea>
    </div>
    <div class="d-flex justify-content-center" id="switch">
        <button type="button" class="btn btn-primary cardsColor bold width-half mx-auto  mb-3 align-content-center" @click="updateUserAccount">Update</button>
    </div>
    </form>
    </div>

</main>

</template>