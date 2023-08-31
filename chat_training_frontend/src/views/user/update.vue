<script setup>
import axios from 'axios'
import UpdateUserInformation from '../../components/updateUserInformation.vue';
import HomePageHeader from '../../components/homePageHeader.vue';



</script>

<template>
  
  <main>
    <HomePageHeader />
  
  <suspense>
        
        
    <UpdateUserInformation />
      <template #fallback>
        <div class='d-flex justify-content-center pb-3 mt-5'><div class='spinner-border text-primary' role='status'><span class='sr-only'></span></div></div>

      </template>
    </suspense>
    

  </main>
</template>
<style>

</style>