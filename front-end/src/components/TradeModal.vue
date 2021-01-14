<template lang="pug">
  .modal
    .modal-container
      img.modal-close(src="../assets/images/close.svg", @click="close()")
      h1 Получение скина
      p После отправки ссылки на обмен Вам будет выслан скин в течение 5-10 минут (в зависимости от нагруженности бота)
      p Введите свою ссылку на обмен
      input(placeholder="Ссылка", v-model="path")
      p
        a(:href="tradePath" target="_blank") Где взять ссылку на обмен?
      .modal-submit(@click="send()")
        button Отправить
</template>

<script>
import store from '@/store';

import vkService from '../services/vk';
import rulletService from '../services/rullet';

export default {
  name: 'TradeModal',
  data() {
    return {
      user: store.state.user,
      path: ''
    }
  },

  computed: {
    tradePath() {
      return `https://steamcommunity.com/profiles/${this.user.steamid}/tradeoffers/privacy`;
    }
  },

  created() {
  },

  methods: {
    close() {
      this.$emit('close');
    },

    async send() {
      if (/https:\/\/steamcommunity.com\/(\S+)/.exec(this.path)) {
        await vkService.notify(2, `Игрок ${this.user.name} выбил скин в рулетке. Ссылка на трейд ${this.path}`);
        await rulletService.setSkinState(this.user.steamid, 2);
        this.$emit('close');
        setTimeout(() => {
          window.location.reload();
        }, 1000);
      }
    }
  }
}
</script>

<style scoped lang="stylus">
.modal
  &-container
    position relative

  &-close
    position absolute
    right 30px
    top 30px
    width 20px
    cursor pointer
    transition-duration .25s

    &:hover
      opacity 0.7
      transition-duration .25s

  &-submit
    display flex
    justify-content flex-end
    margin-top 10px

    button
      background #45A35A

  h1
    color #E2E2E2

  input
    margin-top 10px

  a
    text-decoration underline

  p, a
    font-size 15px
    color #808FAC
    margin-top 10px

</style>
