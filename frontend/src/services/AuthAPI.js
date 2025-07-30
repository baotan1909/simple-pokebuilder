import API from './API.js'

const api = API()

api.defaults.withCredentials = true

export default {
    getProfile() {
      return api.get('/profile.php')
    }
}