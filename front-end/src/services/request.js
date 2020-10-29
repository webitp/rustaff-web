import axios from 'axios'
import store from '@/store'

var request = axios.create({
  baseURL: 'https://api.rustaff.net/api/',
  timeout: 20000,
  headers: {
    'Content-Type': 'application/json',
    Authorization: {
      toString() {
        const token = store.state.token;
        if (token && token != 'null') return token;
      }
    }
  }
});

export default request;