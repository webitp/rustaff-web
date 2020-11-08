<template lang="pug">
  .servers
    main-header

    .content-container
      .content
        .content__title
          h1 Наши 
            span сервера

        .servers-list
          .servers-list__item(v-for="server in servers", :class="{ aviable: server.state == 'aviable' }")
            .servers-list__item--name
              h2 {{ server.name }}
              a(v-if="server.state == 'aviable'", :href="`steam://connect/${server.ip}:${server.port}`") Выжить!
              a(v-else disabled, style="background: #383F59") В разработке

            .servers-list__item--data
              .servers-list__item--col
                .icon
                  img(src="../assets/images/icons/stats/fist.svg")
                .data
                  p IP Сервера: <br>
                    span {{ server.state == 'aviable' ? `${server.ip}:${server.port}` : 'В разработке' }}

              .servers-list__item--col
                .icon
                  img(src="../assets/images/icons/stats/clock.svg")
                .data
                  p До вайпа: <br>
                    span {{ server.state == 'aviable' ? server.wipe : 'В разработке' }}

              .servers-list__item--col
                .icon
                  img(src="../assets/images/icons/stats/gas.svg")
                .data
                  p Выживших онлайн: <br>
                    span(style="color: #45A35A", v-if="server.state == 'aviable'") {{ server.online }}/{{ server.maxOnline }}
                    span(v-else) В разработке

    main-footer
</template>

<script>
import servers from '@/services/servers';
import serversList from '@/constants/servers';

import MainHeader from '../components/Header';
import MainFooter from '../components/Footer';

export default {
  name: 'Servers',
  components: {
    MainHeader,
    MainFooter
  },
  data() {
    return {
      servers: []
    }
  },

  async created() {
    this.servers = serversList;

    for (let i = 0; i < this.servers.length; ++i) {
      const serverData = this.servers[i];
      if (serverData.state == 'aviable') {
        const server = (await servers.get(serverData.ip, serverData.port)).data.server;
        
        this.servers[i].online = server.Players;
        this.servers[i].maxOnline = server.MaxPlayers;
      }
    }

    this.$forceUpdate();
  }
}
</script>

<style lang="stylus" scoped>
.content-container
  margin-top 105px
  padding-bottom 60px
  box-sizing border-box
  min-height calc(100vh - 105px - 86px)

.servers
  &-list
    &__item
      height 200px
      background-size cover
      background-color #161722
      display flex
      align-items center
      justify-content space-between
      padding 0 50px
      margin-top 30px

      &.aviable
        background-image url('../assets/images/server-bg.png')

        .servers-list__item
          &--name, &--data
            opacity 1

      &:first-child
        margin 0

      &--name
        text-align center
        opacity .25

        h2
          font-family 'Russo One', sans-serif
          font-weight normal
          font-size 24px
          line-height 140%

        a
          display block
          width 140px
          height 35px
          line-height 35px
          border-radius 5px
          background #E93737
          color white
          font-size 14px
          font-weight 500
          margin 0 auto
          margin-top 10px

      &--data
        width 65%
        display grid
        grid-template-columns repeat(3, 1fr)
        grid-gap 60px
        opacity .25

      &--col
        display flex
        align-items center

        .data
          margin-left 10px
          
          p
            font-size 15px
            font-weight 500
            color #6C768D
            line-height 160%

            span
              color #E2E2E2

@media screen and (max-width: 1250px)
  .servers-list
    max-width 100vw
    overflow-x scroll
    box-sizing border-box

    &__item
      width 1000px
    // transform scale(0.5)
</style>