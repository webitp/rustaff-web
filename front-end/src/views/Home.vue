<template lang="pug">
  .home
    main-header(:isMain="true")
    .home__content
      .home__data
        .home__data--text
          img(src="../assets/images/mask.svg")
          p Выживших онлайн: 
            span {{ online }} 
              span чел.
        img.target(src="../assets/images/target.svg")
        .home__data--button
          a.alive(href="/servers") Выжить!
    main-footer(:isMain="true")
</template>

<script>
import Cookies from 'js-cookie'

import servers from '@/services/servers';
import serversList from '@/constants/servers';

import MainHeader from '../components/Header';
import MainFooter from '../components/Footer';

export default {
  name: 'Home',
  components: {
    MainHeader,
    MainFooter
  },
  data() {
    return {
      online: 0
    }
  },
  async created() {
    await this.auth();

    for (const serverData of serversList) {
      if (serverData.state == 'aviable') {
        const server = (await servers.get(serverData.ip, serverData.port)).data.server;
        if (server)
          this.online += server.Players;
      }
    }

    this.$forceUpdate();
  },
  methods: {
    async auth() {
      const token = this.$route.query.token;
      if (token) {
        Cookies.set('token', token, { expires: 365 });
        location.href = location.pathname;
      }
    },
  }
}
</script>

<style lang="stylus" scoped>
.home
  width 100vw
  height 100vh
  background-image url('../assets/images/main_bg.jpg')
  background-size cover
  background-position center

  &__content
    width 100%
    height 100%
    display flex
    justify-content center
    align-items center

  &__data
    &--text
      display flex
      justify-content center
      align-items center

      p
        text-transform uppercase
        font-size 20px
        letter-spacing 0.02em
        margin-left 10px
        opacity .85
        font-family 'Russo One', sans-serif

        span
          color #E93737
          
          span
            font-weight 500
            font-size 12px

    .target
      margin-top 30px

    &--button
      display flex
      justify-content center
      margin-top 30px

      a.alive
        background #E93737
        border-radius 5px
        display block
        height 64px
        line-height 64px
        padding 0 37px
        color white
        text-transform uppercase
        font-size 48px
        font-family 'Russo One', sans-serif
</style>