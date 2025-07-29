import axios from 'axios'

const baseURL = import.meta.env.VITE_API_BASE_URL

export default (url = baseURL) => {
  return axios.create({
    baseURL: url
  })
}