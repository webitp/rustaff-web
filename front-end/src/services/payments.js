import request from './request'

export default {
  list(steamid) {
    return request.post(`/payments`, { steamid: steamid });
  }
};