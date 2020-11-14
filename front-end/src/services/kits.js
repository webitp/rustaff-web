import request from './request'

export default {
  async get() {
    const kits = (await request.get(`/kits`)).data;
    return kits;
  },

  create(payload) {
    return request.post(`/kits/create`, payload);
  },

  items: {
    create(payload) {
      return request.post(`/kits/items/create`, payload);
    }
  }
};