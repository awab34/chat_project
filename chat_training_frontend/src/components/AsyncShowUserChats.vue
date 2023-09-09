

<template>
  
  <main class="mx-auto">
<div v-if="chatsData.friends.length > 0 || chatsData.groups.length > 0">
  <ul class="list-group mx-auto cardsColor " v-for="group in chatsData.groups" :key="group.id" style="max-width: 750px;">
  <li class="list-group-item text-center cardsColor">
  <a :href="'/showgroup?'+group.id" class="mx-auto text-decoration-none text-black text-center cardsColor">
  <p class="mx-auto text-decoration-none text-center text-28 bold headerColor">{{ group.group_name }}</p> 
       </a></li>
  
</ul>
<ul class="list-group mx-auto cardsColor " v-for="friend in chatsData.friends" :key="friend.id" style="max-width: 750px;">
  <li class="list-group-item text-center cardsColor ">
  <a :href="'/showfriendchat?'+friend.id" class="mx-auto text-decoration-none text-black text-center cardsColor">
  <p class="mx-auto text-decoration-none text-center text-28 bold headerColor">{{ friend.name }}</p> 
       </a></li>
  
</ul>
</div>
<div v-else>
<h1 class="text-28 text-center">No Chats Found Please Add New Friends</h1>
</div>
    

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
  url: `http://localhost:8000/api/home`
});
console.log(resultData.data);
return resultData.data;
    }catch(err){
     console.log(err);
     if (err.response.data.message == "Your email address is not verified.") {
      window.location.replace("/verify");
     }
    }
    
  
}
const chatsData = await getChats();


</script>