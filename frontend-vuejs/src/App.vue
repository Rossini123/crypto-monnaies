<template>
  <div id="App">
    <Navbar/>
    <router-view/>
  </div>
</template>

<script>
import Navbar from '@/components/Navbar.vue'
export default {
  name : "App",
  components: { Navbar }
}
</script>

<style>
@import url("https://fonts.googleapis.com/css2?family=Signika:wght@300;400;500;600;700&display=swap");

body{
  background: #fafafa;
  font-family: 'Signika', sans-serif;
}
.monnaie{
  color: #f2aa4c;
}
</style>
