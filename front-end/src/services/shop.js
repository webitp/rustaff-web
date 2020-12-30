import request from './request'

export default {
  categories: {
    get() {
      return request.get('/categories');
    },

    create(name) {
      return request.post('/categories/create', { name: name });
    },

    delete(id) {
      return request.post('/categories/delete', { id: id });
    }
  },

  items: {
    get() {
      return request.get('/items');
    },

    info(id) {
      return request.get(`/items/get?id=${id}`);
    },

    create(name, gameName, price, category, image, count) {
      return request.post('/items/create', { 
        name: name,
        game_name: gameName,
        price: price,
        category: category,
        image: image,
        count: count
      });
    },

    delete(id) {
      return request.post('/items/delete', { id: id });
    },

    payment(payload) {
      return request.post('/items/payment', payload);
    }
  }
}