
<script setup>
import HomePageHeader from '../../components/homePageHeader.vue'
import { defineAsyncComponent } from 'vue';


const AsyncShowFriendRequests = defineAsyncComponent(() =>
  import('../../components/AsyncShowFriendRequests.vue')
);

  </script>
<template>
  
    <main class="mx-auto">
  
      <HomePageHeader active-page="5" />

      <suspense>
      
      
      <AsyncShowFriendRequests class="mt-5"/>
      <template #fallback>
        <div class='d-flex justify-content-center pb-3 mt-5'><div class='spinner-border text-primary' role='status'><span class='sr-only'></span></div></div>
      </template>
    </suspense>
    
 
  
    </main>
      
      
      
    
  </template>
  