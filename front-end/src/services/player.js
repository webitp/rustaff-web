import request from './request'

export default {
  statistic(steamid) {
    return request.get(`/player/statistic?steamid=${steamid}`);
  }
};