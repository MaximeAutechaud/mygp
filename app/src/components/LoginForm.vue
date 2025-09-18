<script setup lang="ts">
import {reactive, ref} from "vue";
import {useAuth} from '@/composables/useAuth'
import {useRouter} from 'vue-router'

const form = reactive({
  email: '',
  password: ''
})
const showPassword = ref(false)
const errors = reactive<{ email?: string; password?: string }>({})
const serverError = ref<string | null>(null)
const emit = defineEmits<{
  (e: 'login', payload: any): void
}>()
const {login} = useAuth()
const router = useRouter()

function validate(): boolean {
  errors.email = undefined
  errors.password = undefined

  // email simple check
  if (!form.email) {
    errors.email = 'L\'email est requis.'
  } else if (!/^\S+@\S+\.\S+$/.test(form.email)) {
    errors.email = 'Email invalide.'
  }

  // password min length
  if (!form.password) {
    errors.password = 'Le mot de passe est requis.'
  }

  return !errors.email && !errors.password
}

function inputClass(error?: string) {
  return [
    error ? 'border-red-300 focus:border-red-500' : 'border-gray-200 focus:border-blue-400',
    'border'
  ].join(' ')
}

/** Submit */
const onSubmit = async (): Promise<void> => {
  if (!validate()) return
  try {
    await login(form.email, form.password)
    router.push('/contact')
  } catch (err: any) {
    if (err.response?.data) {
      const data = err.response.data
      if (data.errors) {
        if (data.errors.email) errors.email = data.errors.email[0]
        if (data.errors.password) errors.password = data.errors.password[0]
      } else if (data.message) {
        serverError.value = data.message
      } else {
        serverError.value = 'Erreur lors de l\'inscription.'
      }
    } else {
      serverError.value = 'Erreur réseau.'
    }
  }
}
</script>

<template>
  <form @submit.prevent="onSubmit" class="max-w-md mx-auto bg-white p-6 rounded-xl shadow">
    <h2 class="text-2xl font-semibold mb-4">Connexion</h2>

    <!-- Email -->
    <label class="block mb-2 text-sm font-medium text-gray-700">Email</label>
    <input
      v-model="form.email"
      type="email"
      placeholder="you@exemple.com"
      class="w-full px-3 py-2 rounded focus:outline-none"
      :class="inputClass(errors.email)"
      autocomplete="email"
      required
    />

    <!-- Password -->
    <label class="block mt-4 mb-2 text-sm font-medium text-gray-700">Mot de passe</label>
    <div class="relative">
      <input
        v-model="form.password"
        placeholder="8 caractères minimum"
        class="w-full px-3 py-2 rounded focus:outline-none pr-10"
        :class="inputClass(errors.password)"
        autocomplete="new-password"
        required
      />
      <button
        type="button"
        class="absolute right-2 top-1/2 -translate-y-1/2 text-sm text-gray-600"
        @click="showPassword = !showPassword"
        :aria-label="showPassword ? 'Masquer le mot de passe' : 'Afficher le mot de passe'"
      >
        <span v-if="showPassword">🙈</span>
        <span v-else>👁️</span>
      </button>
    </div>
    <p v-if="errors.password" class="text-red-500 text-sm mt-1">{{ errors.password }}</p>


    <!-- Buttons -->
    <div class="mt-6 flex items-center justify-between">
      <button
        type="submit"
        class="bg-blue-600 disabled:opacity-60 text-white px-4 py-2 rounded hover:bg-blue-700"
      >
        <span>Se connecter</span>
      </button>

      <button type="button" class="text-sm text-gray-500">Annuler</button>
    </div>
  </form>
</template>

<style scoped>

</style>
