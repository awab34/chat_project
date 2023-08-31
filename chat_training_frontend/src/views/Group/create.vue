<script setup>
import HomePageHeader from '../../components/homePageHeader.vue';
import {defineAsyncComponent} from 'vue'
const createGroupForm = defineAsyncComponent(() =>
  import('../../components/createGroupForm.vue')
);


</script>

<template>
    <main>
      <HomePageHeader active-page="3" />
      <suspense>
        
        
        <createGroupForm />
          <template #fallback>
            <div class='d-flex justify-content-center pb-3 mt-5'><div class='spinner-border text-primary' role='status'><span class='sr-only'></span></div></div>
          </template>
        </suspense>
  </main>
</template>