<template>
  <RegisterForm @registered="onRegistered" @cancel="onCancel" />
</template>

<script setup lang="ts">
import RegisterForm from '@/components/RegisterForm.vue'
import { useRouter } from 'vue-router'
const router = useRouter()

function onRegistered(payload: any) {
  if (payload.token) {
    localStorage.setItem('token', payload.token)
  }
  router.push('/')
}

function onCancel() {
  router.back()
}
</script>
