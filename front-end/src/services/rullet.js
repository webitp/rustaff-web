import request from './request'

export default {
  items() {
    return request.get(`/rullet/items`);
  },

  create(payload) {
    return request.post(`/rullet/add`, payload);
  },

  delete(id) {
    return request.post(`/rullet/delete`, {
      id: id
    });
  },

  predict(payload) {
    return request.post(`/rullet/predict`, payload);
  },

  givePrize(payload) {
    return request.post(`/rullet/give`, payload);
  },

  access(steamid) {
    return request.post(`/rullet/access`, { steamid: steamid });
  },

  use(steamid) {
    return request.post(`/rullet/use`, { steamid: steamid });
  }
};