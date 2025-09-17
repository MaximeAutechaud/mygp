<script setup lang="ts">
import api from "@/lib/axios.ts";
import {ref} from "vue";

const subject = ref<string>('')
const body = ref<string>('')
const file = ref<File | null>(null)

function handleFileSelect(e: Event) {
  const input = e.target as HTMLInputElement;
  if (input.files && input.files[0]) {
    file.value = input.files[0]
  }
}

async function submitContact() {
  const formData = new FormData();
  formData.append('subject', subject.value);
  formData.append('body', body.value);
  if (file.value) {
    formData.append('file', file.value);
  }
  try {
    console.log(formData)
    api.post('/contact', formData)
  } catch (err) {
    console.error(err)
  }
}

function formatSize(bytes: number): string {
  const sizes = ['B', 'KB', 'MB', 'GB']
  const i = Math.floor(Math.log(bytes) / Math.log(1024))
  const size = (bytes / Math.pow(1024, i)).toFixed(1)
  return `${size} ${sizes[i]}`
}

</script>

<template>
  <form @submit.prevent="submitContact" class="max-w-md mx-auto bg-white p-6 rounded-xl shadow" type="multipart/form-data">
    <h2 class="text-2xl font-semibold mb-4">Demande de contact</h2>

    <!-- Sujet -->
    <label class="block mb-2 text-sm font-medium text-gray-700">Sujet</label>
    <input
      v-model="subject"
      type="text"
      class="w-full px-3 py-2 rounded focus:outline-none focus:border focus:border-blue-700"
      required
    />

    <!-- Message -->
    <label class="block mt-4 mb-2 text-sm font-medium text-gray-700">Message</label>
    <div class="relative">
      <textarea
        v-model="body"
        class="w-full px-3 py-2 rounded focus:outline-none pr-10 focus:border focus:border-blue-700"
        required
      />
    </div>

    <label class="block mt-4 mb-2 text-sm font-medium text-gray-700">Pièce-jointe (2Mo max)</label>
    <div class="relative">
      <input
        @change="handleFileSelect"
        type="file"
        class="w-full px-3 py-2 rounded focus:outline-none pr-10 focus:border focus:border-blue-700"
      />
    </div>
    <p v-if="file"> Vous avez joint : {{ file.name }}
      <span v-if="file.size > 2000000" class="text-red-500 bold" >
        ({{ formatSize(file.size) }}) <br>CE FICHIER EST TROP VOLUMINEUX
      </span>
      <span v-else class="text-green-700 underline" >
        ({{ formatSize(file.size) }})
      </span>
    </p>

    <!-- Submit -->
    <div class="mt-6 flex items-center justify-center">
      <button
        type="submit"
        class="bg-blue-600 disabled:opacity-60 text-white px-4 py-2 rounded hover:bg-blue-700"
      >
        <span>Envoyer</span>
      </button>
    </div>
  </form>
</template>

<style scoped>

</style>
