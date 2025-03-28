<script setup>
import { RouterLink, RouterView } from "vue-router";
</script>

<template>
  <div id="app">
    <!-- <nav>
      <RouterLink to="/">Home</RouterLink>
      <RouterLink to="/products">Products</RouterLink>
    </nav> -->
    <router-view></router-view>
  </div>
</template>

<script setup>
</script>

<style scoped>
.container {
  font-family: Arial, sans-serif;
}

.navbar {
  background: #333;
  color: white;
  padding: 15px;
  display: flex;
  justify-content: space-between;
}

.nav-links a {
  color: white;
  margin-right: 15px;
  text-decoration: none;
}

.nav-links a.router-link-exact-active {
  font-weight: bold;
  text-decoration: underline;
}

main {
  padding: 20px;
}
</style>
