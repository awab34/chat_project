<script setup>
import HomePageHeader from '../../components/homePageHeader.vue';
import {onMounted , ref, defineAsyncComponent} from 'vue'

const groupId = ref(0);
const updateGroupInformation = defineAsyncComponent(() =>
  import('../../components/updateGroupInformation.vue')
);


onMounted(()=>{
  const currentUrl = window.location.href;
  const myArray = currentUrl.split("?");
  groupId.value = myArray[myArray.length - 1];
  console.log(groupId.value);
});


</script>

<template>
  
  <main>
    <HomePageHeader />
  
  <suspense>
        
        
    <updateGroupInformation :group-id="groupId"/>
      <template #fallback>
        <div class='d-flex justify-content-center pb-3 mt-5'>
              <div class='spinner-border text-primary' role='status'>
              <span class='sr-only'></span>
              </div></div>
      </template>
    </suspense>
    

  </main>
</template>
<style>

</style>