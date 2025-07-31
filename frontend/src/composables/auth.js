import { ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import AuthAPI from '../services/AuthAPI.js'
import { useNotify } from './useNotify.js'

const isAuthenticated = ref(false)
const user = ref(null)

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
  const { confirm } = useNotify()
  if (!confirm('Are you sure you want to log out?')) { return }
  try {
    await axios.post(import.meta.env.VITE_AUTH_BASE_URL + '/logout.php', {}, { withCredentials: true })
    setAuth(null)
    router.push('/')
  } catch (error) {
    console.error('Logout failed:', error)
  }
}

checkAuth()

export default {
  user,
  isAuthenticated,
  checkAuth,
  handleLogout
}
