import request from './request'

export default {
  list() {
    return request.get('/bans');
  }
};