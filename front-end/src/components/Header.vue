<template lang="pug">
  .header(:class="{ dashboard: isMain }")
    transition(name="fade")
      .header__overlay(v-if="isOpen")
        .header__overlay-content
          ul
            li(v-for="(link, index) in links", :key="index")
              a(:href="link.href") {{ link.name }}

    transition(name="fade")
      payment-modal(v-if="modals.payment.open", @close="modals.payment.open = false;")
            
    .header__content
      .header__content--menu(@click="isOpen = !isOpen")
        img(v-if="!isOpen", src="../assets/images/menu.svg")
        img(v-else, src="../assets/images/close.svg")
      a.header__content--logo(href="/")
        img(src="../assets/images/logo.png")
      a.header__content--connect(v-if="!user", :href="loginUrl")
        img(src="../assets/images/steam.svg")
        .text Вход через Steam
      .header__content--profile(v-if="user", :class="{ active: isOpenProfile }", @click="isOpenProfile = !isOpenProfile")
        .icon
          img(:src="user.avatar")
        .name {{ user.name }}
        img.arrow(src="../assets/images/arrow.svg")
        
        transition(name="fade")
          .header__content--profile__list(v-if="isOpenProfile")
            ul
              li
                a(href="/profile/stats") Стастистика
              li(@click="modals.payment.open = true;")
                a Баланс: 
                  span {{ user.money }} ₽
                img.icon(src="../assets/images/plus.svg")
              li
                a(href="/profile/purchases") Покупки
              li
                a(href="/profile/inventory") Инвентарь
              li
                a(href="/profile/roll") Рулетка
              li.logout(@click="logout()")
                a Выйти
</template>

<script>
import store from '@/store'
import logoutService from '../services/logout'

import PaymentModal from '../components/PaymentModal';

export default {
  name: 'Header',
  props: {
    isMain: {
      default: false
    }
  },
  components: {
    PaymentModal
  },
  data() {
    return {
      isOpen: false,
      isOpenProfile: false,

      user: store.state.user,
      loginUrl: store.state.loginUrl,

      modals: {
        payment: {
          open: false
        }
      },

      links: [
        {
          name: 'Сервера',
          href: '/servers'
        },
        {
          name: 'Магазин',
          href: '/shop'
        },
        {
          name: 'Команды и правила',
          href: '/rules'
        },
        {
          name: 'Временные блокировки',
          href: '/blocks'
        },
        {
          name: 'Баны игроков',
          href: '/bans'
        },
        {
          name: 'Доступные киты',
          href: '/kits'
        },
      ]
    }
  },

  methods: {
    logout() {
      logoutService();
    }
  }
}
</script>

<style scoped lang="stylus">
.header
  width 100vw
  height 105px
  display flex
  justify-content center
  position absolute
  top 0
  background #12121A
  z-index 999

  &.dashboard
    position absolute
    background transparent

  &__content
    width 1170px
    height 100%
    position relative
    display flex
    justify-content center
    align-items center

    &--menu, &--connect, &--profile
      position absolute

    &--menu
      cursor pointer
      left 0
      z-index 10

    &--logo
      display block

    &--connect
      display flex
      align-items center
      height 44px
      padding 0 15px
      cursor pointer
      right 0
      border-radius 5px
      transition-duration .25s

      &:hover
        background #1C212C
        transition-duration .25s

      .text
        margin-left 12px
        color #5B677F
        font-size 14px
        font-weight 500

    &--profile
      right 0
      width 200px
      height 44px
      background rgba(28, 33, 44, 0.25)
      border-radius 5px
      display flex
      align-items center
      cursor pointer
      transition-duration .25s

      &.active
        border-radius 5px 5px 0 0

      &:hover, &.active
        background #1C212C
        transition-duration .25s

      .icon
        width 44px
        height 100%
        background black
        border-radius 5px
        overflow hidden

        img
          width 100%

      .name
        margin-left 10px
        color alpha(#E2E2E2, 0.8)
        font-size 13px
        font-weight bold

      img.arrow
        position absolute
        right 15px

      &__list
        position absolute
        top 44px
        right 0
        width 100%
        background #161A24
        border-radius 0 0 5px 5px
        overflow hidden

        ul
          list-style none

          li
            border-bottom 1px solid rgba(35, 41, 55, 0.5)
            box-sizing border-box
            transition-duration .25s
            display flex
            align-items center

            &.logout a
              color #E93737

            &:hover
              background #1C212C
              transition-duration .25s

            a
              padding 15px
              display block
              width 100%
              height 100%
              color #5B677F
              font-size 13px
              font-weight 500

              span
                color #45A35A

            .icon
              background transparent
              width 16px
              position absolute
              right 15px

  &__overlay
    width 100vw
    height 100vh
    position fixed
    background alpha(#12121A, .95)
    z-index 9
    display flex
    justify-content center
    align-items center

    &-content
      ul
        list-style none

        li
          font-family 'Russo One', sans-serif
          font-size 36px
          line-height 100%
          text-transform uppercase
          letter-spacing 0.02em
          margin-top 55px
          text-align center

          &:first-child
            margin 0
          
          a
            color white
            transition-duration .25s

            &:hover
              color #E93737
              transition-duration .25s
</style>
