import request from './request'

export default {
  get(ip, port) {
    return request.get(`/server?ip=${ip}&port=${port}`);
  }
};