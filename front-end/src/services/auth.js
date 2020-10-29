import request from './request'

const data = {
  post() {
    return request.post('/user');
  }
}

export default data;