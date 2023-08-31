<script setup>
 
const props = defineProps({
  messagesArray: Array,
  userId: Number
})

</script>

<template>
  <main class="mt-5">

    <div v-for="message in messagesArray" :key="message.id" >
    <div v-if="userId == message.senderId" class="d-flex my-2 cardsColor rounded-3 mx-auto" style="max-width: 700px;">
     <div class="d-block w-100" >
      <p  class="headerColor text-28 my-auto" ><b class="ms-1 ms-sm-5 ">{{ message.name }}</b> </p>
      <p class="textColor text-28 my-auto ms-1 ms-sm-5">{{ message.message }}</p> 
      <a class="btn btn-danger my-auto ms-auto me-2 float-end button-font-size" @click="$emit('deleteMessage', message.id)" >Delete</a>
     </div> 
             
            
    </div>
        
<div v-else class="d-flex my-2 cardsColor rounded-3 mx-auto" style="max-width: 700px;">
  <div class="d-block">
      <p  class="headerColor text-28 my-auto" ><b class="ms-1 ms-sm-5">{{ message.name }}</b> </p>
      <p class="textColor text-28 my-auto ms-1 ms-sm-5">{{ message.message }}</p> 
     </div>
</div>
        
    </div>
        
        
  </main>
</template>