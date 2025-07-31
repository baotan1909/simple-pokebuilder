import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import AuthAPI from '../services/AuthAPI.js'

const isAuthenticated = ref(false)
const user = ref(null)

export default function useAuth() {
  const router = useRouter()

  const setAuth = (userData) => {
    user.value = userData
    isAuthenticated.value = !!userData
  }

  const checkAuth = async () => {
    try {
      const res = await AuthAPI.getProfile()
      setAuth(res.data.user)
    } catch (err) {
      setAuth(null)
    }
  }

  const handleLogout = async () => {
    try {
      await axios.post(import.meta.env.VITE_AUTH_BASE_URL + '/logout.php', {}, { withCredentials: true } )
      setAuth(null)
      router.push('/')
    } catch (error) {
      console.error('Logout failed:', error)
    }
  }

  onMounted(() => {
    checkAuth()
  })

  return {
    user,
    isAuthenticated,
    checkAuth,
    handleLogout
  }
}