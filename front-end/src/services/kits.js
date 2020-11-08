import request from './request'

export default {
  async get() {
    var res = [];
    const kits = (await request.get(`/kits`)).data;

    for (const kit of kits) {
      const items = (await request.get(`/kits/items?kit=${kit.id}`)).data;
      res.push({
        id: kit.id,
        name: kit.name,
        cooldown: kit.cooldown,
        category: kit.category,
        items: items
      });
    }
    return res;
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