import axios from 'axios'

const axiosIns = axios.create({
  baseURL: import.meta.env.VITE_API_URL || 'http://localhost:8000/api',
  // timeout: 1000,
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
  },
})

export default axiosIns
