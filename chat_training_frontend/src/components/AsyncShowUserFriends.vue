

<template>
  
  <main class="mx-auto">

    <div v-if="chatsData.friends.length > 0">
      <ul class="list-group mx-auto" v-for="friend in chatsData.friends" :key="friend.id">
  <li class="list-group-item text-center d-flex">
  <a :href="'/showfriendchat?'+friend.id" class=" my-auto text-decoration-none text-black text-center">
  <p class=" my-auto text-decoration-none text-center text-28 bold">{{ friend.name }}</p> 
       </a><a @click="unfriend(friend.id)" class="btn btn-danger ms-auto my-auto">Unfriend</a></li>
  
</ul>
    </div>
    <div v-else class="mx-auto"><p class="text-28 mx-auto mt-5"><b class="mx-auto">No Friends Found</b></p></div>

  </main>
    
    
    
  
</template>
<script setup>
import axios from 'axios'

const getChats = async ()=>{
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
const chatsData = await getChats();

function unfriend(id){
  try{
       axios.request({
  headers: {
    Authorization: `Bearer ${localStorage.getItem("accessToken")}`
  },
  method: "GET",
  url: `http://localhost:8000/api/unfriend/${id}`
});

location.reload();

    }catch(err){
     console.log(err);
    }
}



</script>