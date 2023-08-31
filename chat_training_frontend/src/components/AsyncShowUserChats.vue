

<template>
  
  <main class="mx-auto">

    <ul class="list-group mx-auto cardsColor" v-for="group in chatsData.groups" :key="group.id">
  <li class="list-group-item text-center cardsColor">
  <a :href="'/showgroup?'+group.id" class="mx-auto text-decoration-none text-black text-center cardsColor">
  <p class="mx-auto text-decoration-none text-center text-28 bold headerColor">{{ group.group_name }}</p> 
       </a></li>
  
</ul>
<ul class="list-group mx-auto cardsColor" v-for="friend in chatsData.friends" :key="friend.id">
  <li class="list-group-item text-center cardsColor">
  <a :href="'/showfriendchat?'+friend.id" class="mx-auto text-decoration-none text-black text-center cardsColor">
  <p class="mx-auto text-decoration-none text-center text-28 bold headerColor">{{ friend.name }}</p> 
       </a></li>
  
</ul>

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
    }
    
  
}
const chatsData = await getChats();


</script>