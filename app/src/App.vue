<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router'

</script>

<template>
  <header class="mb-20">
    <nav class="bg-white border-b border-gray-200 shadow-sm">
      <div class="w-full mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">

          <!-- Logo -->
          <div class="flex-shrink-0">
            <RouterLink to="/" class="text-xl font-bold text-blue-600">MYGP</RouterLink>
          </div>

          <!-- Desktop menu -->
          <div class="hidden md:flex space-x-6">
            <RouterLink class="mx-12" to="/login">Login</RouterLink>
            <RouterLink to="/register">Register</RouterLink>
          </div>
        </div>
      </div>
    </nav>
  </header>
  <RouterView />
</template>

<style scoped>
header {
  line-height: 1.5;
  max-height: 100vh;
}
</style>
