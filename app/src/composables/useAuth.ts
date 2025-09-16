import { ref } from 'vue'
import axios from '@/lib/axios'
import router from "@/router";

const token = ref<string | null>(localStorage.getItem('token'))

export function useAuth() {
  const isAuthenticated = () => !!token.value

  const login = async (email: string, password: string) => {
    const response = await axios.post('/login', { email, password })
    const newToken = response.data.token

    token.value = newToken
    localStorage.setItem('token', newToken)
    axios.defaults.headers.common['Authorization'] = `Bearer ${newToken}`
  }

  const logout = () => {
    token.value = null
    localStorage.removeItem('token')
    delete axios.defaults.headers.common['Authorization']
    router.push('/login')
  }

  return {
    token,
    isAuthenticated,
    login,
    logout
  }
}
