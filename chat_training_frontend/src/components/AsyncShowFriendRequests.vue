
<script setup>
import axios from 'axios'



  const getChats = async ()=>{
      try{
        const resultData = await axios.request({
    headers: {
      Authorization: `Bearer ${localStorage.getItem("accessToken")}`
    },
    method: "GET",
    url: `http://localhost:8000/api/show-friend-requests`
  });
  console.log(resultData.data);
  
  return resultData.data;
      }catch(err){
       console.log(err);
      }
      
    
  }
  const requestData = await getChats();


  function acceptNewFirend(status,id,requester){
    
    axios.request({
  headers: {
    Authorization: `Bearer ${localStorage.getItem("accessToken")}`
  },
  params:{first_freind:requester,
    status:status,
    requestId:id
},
  method: "POST",
  url: `http://localhost:8000/api/accept-friend`
}).then((response)=>{
  
    location.reload();
  
  
}).catch((err)=>{
  console.log(err);
});
  }

  
  
  </script>
<template>
  
    <main class="mx-auto">
       
        
        
        
    
            
    <div v-if="requestData.friendRequests.length > 0" class="mt-5">
        <ul class="list-group mx-auto" v-for="friendRequest in requestData.friendRequests" :key="friendRequest.id">
    <li class="list-group-item text-center d-flex">
    <p class=" text-decoration-none text-center text-28 bold my-auto">{{ friendRequest.name }}</p> 
    <form class="my-auto ms-auto">
           
           <input type="hidden"  name="first_freind" value="{{$item['requester']}}">
           <input type="hidden"  name="status" value="1">
           <input type="hidden" name="requestId" value="{{$item['id']}}">
           <button type="button" class="ms-auto btn btn-success me-2 my-auto" @click="acceptNewFirend(1,friendRequest.id,friendRequest.requester)">Accept</button>
       </form>
       <form class="my-auto">
           <input type="hidden" name="first_freind" value="{{$item['requester']}}">
           <input type="hidden" name="status" value="2">
           <input type="hidden" name="requestId" value="{{$item['id']}}">
           <button type="button" class="btn btn-danger my-auto" @click="acceptNewFirend(2,friendRequest.id,friendRequest.requester)">Reject</button>
       </form></li>
    
  </ul>
    </div>
    <div v-else class="mx-auto"><p class="text-28 mx-auto mt-5"><b class="mx-auto">No Requests Found</b></p></div>
  
  
    </main>
      
      
      
    
</template>