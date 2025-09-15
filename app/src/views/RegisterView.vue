<template>
  <RegisterForm @registered="onRegistered" @cancel="onCancel" apiEndpoint="http://localhost:8000/register" />
</template>

<script setup lang="ts">
import RegisterForm from '@/components/RegisterForm.vue'
import { useRouter } from 'vue-router'
const router = useRouter()

function onRegistered(payload: any) {
  // payload peut contenir un token, user, ou message selon ton API
  // Exemple: si API renvoie { token: '...' } :
  if (payload.token) {
    localStorage.setItem('token', payload.token)
    // config axios default header if using custom instance
  }
  // rediriger ou afficher message
  router.push('/')
}

function onCancel() {
  router.back()
}
</script>
