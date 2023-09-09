<script setup>

import axios from 'axios'
import {ref,onMounted} from 'vue'
import {$toast} from '../main.js'

const props = defineProps({
    groupId: Number
})


let groupName = null;
let description = null;
const users = ref([]);

async function getGroupInfo(){
    console.log(props.groupId);
    try{
        const resultData = await axios.request({
    headers: {
      Authorization: `Bearer ${localStorage.getItem("accessToken")}`
    },
    method: "GET",
    url: `http://localhost:8000/api/group-info-update/${props.groupId}`
  });
  console.log(resultData.data);
  users.value = resultData.data.group.users;
  groupName = resultData.data.group.group_name;
  description = resultData.data.group.description;
  return resultData.data;
      }catch(err){
       console.log(err);
       if (err.response.data.message == "Your email address is not verified.") {
      window.location.replace("/verify");
     }
      }
}
const GroupInfo = await getGroupInfo();

function updateGroup(){
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
  params:{name:groupName,
    users:usersArray,
    description:description
},
  method: "PUT",
  url: `http://localhost:8000/api/update-group-all-info/${props.groupId}`
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

function checkGroupUser(id){
  const cheched = ref(false);
  console.log(id)
  users.value.forEach(element => {
    if(element.id == id){
      cheched.value = true;
    }
  });
  return cheched.value
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
      <p class="textColor text-28 ms-sm-3 ms-1 ms-md-5 bold ">Users:</p>
      <div class="form-check" v-for="user in GroupInfo.friends">
    <input type="checkbox"  name="users[]" :value="user.id" class="form-check-input ms-auto  " :key="user.id" id="exampleCheck1" :checked="checkGroupUser(user.id)" >
    <label class="form-check-label ms-2  headerColor" for="exampleCheck1">{{ user.name }}</label>
  </div>
    </div>
    
    
    <div class="d-flex justify-content-center" id="switch">
        <button type="button" class="btn btn-primary buttonColor bold width-half mx-auto  mb-3 align-content-center" @click="updateGroup">Update</button>
    </div>
    </form>
    </div>

</main>

</template>