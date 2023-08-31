<script setup>
import { defineAsyncComponent,onMounted } from 'vue';
import HomePageHeader from '../../components/homePageHeader.vue';
import {$toast} from '../../main.js'

const AsyncShowUserChats = defineAsyncComponent(() =>
  import('../../components/AsyncShowUserChats.vue')
);
onMounted(()=>{
  if(localStorage.getItem("welcome")){
    console.log(localStorage.getItem("welcome"));
    $toast.success(`${localStorage.getItem("welcome")}`)
    localStorage.removeItem("welcome")
  }
  
})
</script>

<template>
  
  <main>
  <HomePageHeader activePage="1" />
    <suspense>
      
        <AsyncShowUserChats class="mt-5"/>
      
      <template #fallback>
        <div class='d-flex justify-content-center pb-3 mt-5'><div class='spinner-border text-primary' role='status'><span class='sr-only'></span></div></div>
      </template>
    </suspense>
 
    
  </main>
</template>
<style>

</style>