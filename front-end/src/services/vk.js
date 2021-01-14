import request from './request'

export default {
  notify(chat, message) {
    return request.post('/vk/notification', {
      chat_id: chat,
      message: message
    });
  }
};