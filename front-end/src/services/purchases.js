import request from './request'

export default {
  create(steamid, item, count) {
    return request.post('/purchases', {
      steamid: steamid,
      item: item,
      count: count
    });
  },

  list(steamid) {
    return request.get(`/purchases/list?steamid=${steamid}`);
  },

  inventory(steamid) {
    return request.post(`/purchases/inventory`, { steamid: steamid });
  }
};