<script setup>
import HomePageHeader from '../../components/homePageHeader.vue';
import { defineAsyncComponent, onMounted, ref } from 'vue';

const showFriendInfo = defineAsyncComponent(() =>
  import('../../components/showFriendInfo.vue')
);
const frinedId = ref(0);


onMounted(()=>{
  const currentUrl = window.location.href;
  const myArray = currentUrl.split("?");
  frinedId.value = myArray[myArray.length - 1];
  console.log(frinedId.value);


});


</script>

<template>
  <main>

<HomePageHeader  />

<suspense>
      
      
    <showFriendInfo class="mt-5" :friend-id="frinedId" />
    <template #fallback>
      <div class='d-flex justify-content-center pb-3 mt-5'><div class='spinner-border text-primary' role='status'><span class='sr-only'></span></div></div>
    </template>
  </suspense>
  </main>
</template>