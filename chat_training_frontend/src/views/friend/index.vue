<script setup>
import HomePageHeader from '../../components/homePageHeader.vue';
import { defineAsyncComponent, onMounted } from 'vue';

const AsyncShowUserFriends = defineAsyncComponent(() =>
  import('../../components/AsyncShowUserFriends.vue')
);
onMounted(()=>{
  const currentUrl = window.location.href;
  console.log(currentUrl);
});


</script>

<template>
  <main>

<HomePageHeader active-page="4" />

<suspense>
      
      
    <AsyncShowUserFriends class="mt-5" />
    <template #fallback>
      <div class='d-flex justify-content-center pb-3 mt-5'><div class='spinner-border text-primary' role='status'><span class='sr-only'></span></div></div>
    </template>
  </suspense>
  </main>
</template>