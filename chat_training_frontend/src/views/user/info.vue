<script setup>
import HomePageHeader from '../../components/homePageHeader.vue';
import { defineAsyncComponent, onMounted, ref } from 'vue';

const showUserInfo = defineAsyncComponent(() =>
  import('../../components/showUserInfo.vue')
);
const userAuth = ref(null);


onMounted(()=>{
  userAuth.value = localStorage.getItem('accessToken');
  console.log(userAuth.value);
});

</script>

<template>
    <main>
  
  <HomePageHeader active-page="0" />
  
  <suspense>
        
        
      <showUserInfo class="mt-5"  />
      <template #fallback>
        <div class='d-flex justify-content-center pb-3 mt-5'><div class='spinner-border text-primary' role='status'><span class='sr-only'></span></div></div>

      </template>
    </suspense>
    </main>
  </template>