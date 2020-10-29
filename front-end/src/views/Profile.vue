<template lang="pug">
  .profile
    main-header
    
    .profile__header.content-container
      .content(v-if="user")
        .profile__header-profile
          .data
            .data-avatar--container
              .data-avatar
                img(:src="user.avatar")
            .data-content
              h2 {{ user.name }}
              .data-text Баланс: 
                span {{ user.money }} ₽
                img(src="../assets/images/add-green.svg")
          
        .profile__header-stats
          .stats-col
            .stats-col__icon
              img(src="../assets/images/icons/stats/fist.svg")
            .stats-col__data
              p Очки:
              span 0
          .stats-col
            .stats-col__icon
              img(src="../assets/images/icons/stats/crosshair.svg")
            .stats-col__data
              p K/D:
              span 0
          .stats-col
            .stats-col__icon
              img(src="../assets/images/icons/stats/clock.svg")
            .stats-col__data
              p Время в игре:
              span 0
          .stats-col
            .stats-col__icon
              img(src="../assets/images/icons/stats/gas.svg")
            .stats-col__data
              p Активность:
              span 0
    nav.profile__nav.content-container
      .content
        a.profile__nav-link(v-for="(link, idx) in navLinks", :key="idx", :class="{ active: link.link == `/profile/${page}` }", :href="link.link") {{ link.name }}

    .content-container
      .content.main(style="padding-bottom: 30px")
        profile-stats(v-if="page == 'stats'")
        profile-purchases(v-if="page == 'purchases'")
        profile-inventory(v-if="page == 'inventory'")
        profile-payments(v-if="page == 'payments'")

    main-footer
</template>

<script>
import 'vue-router';

import store from '@/store'

import logoutService from '../services/logout'

import MainHeader from '../components/Header';
import MainFooter from '../components/Footer';

import ProfileStats from '../components/profile/Stats';
import ProfilePurchases from '../components/profile/Purchases';
import ProfileInventory from '../components/profile/Inventory';
import ProfilePayments from '../components/profile/Payments';

export default {
  name: 'Profile',
  components: {
    MainHeader,
    MainFooter,
    ProfileStats,
    ProfilePurchases,
    ProfileInventory,
    ProfilePayments
  },
  data() {
    return {
      user: store.state.user,
      page: 'stats',
      navLinks: [
        {
          name: 'Статистика',
          link: '/profile/stats'
        },
        {
          name: 'Покупки',
          link: '/profile/purchases'
        },
        {
          name: 'Инвентарь',
          link: '/profile/inventory'
        },
        {
          name: 'Платежи',
          link: '/profile/payments'
        }
      ]
    }
  },

  async created() {
    this.page = this.$route.params.page;
  },

  methods: {
    logout() {
      logoutService();
    }
  }
}
</script>

<style lang="stylus" scoped>
.content.main
  min-height calc(100vh - 391px - 105px - 100px - 86px)

.profile
  &__header
    width 100%
    height 391px
    background-image url('../assets/images/header.jpg')
    background-size cover
    background-position center
    margin-top 104px

    &-profile
      height calc(100% - 72px)
      display flex
      justify-content center
      align-items center

      .data
        display grid
        grid-template-rows 125px 54px
        grid-gap 20px
        justify-content center

        &-avatar
          width 125px
          height 125px
          box-sizing border-box
          border 2px solid rgba(36, 41, 58, 0.5)
          background #12121A
          border-radius 5px
          overflow hidden

          img
            width 100%

          &--container
            display flex
            justify-content center

        &-content
          text-align center

        h2
          font-size 24px
          font-weight 600

        &-text
          display flex
          justify-content center
          align-items center
          color #5B677F
          font-size 15px
          font-weight 500
          margin-top 13px

          span
            color #45A35A

          img
            margin-left 5px

    &-stats
      width 100%
      display flex
      justify-content space-around

      .stats
        &-col
          display flex
          align-items center

          &__data
            margin-left 25px

            p, span
              font-size 15px
              font-weight 500
              color #6C768D

            span
              color #E2E2E2
            
  &__nav
    box-sizing border-box
    height 70px
    position relative
    
    &::after
      content ''
      position absolute
      width 100%
      height 2px
      background #252C39
      bottom 0
      left 0

    &-link
      display inline-flex
      height 100%
      line-height 70px
      text-align center
      padding 0 30px
      cursor pointer
      font-size 15px
      font-weight 500
      color #6C768D
      box-sizing border-box
      position relative
      justify-content center
      z-index 1
      transition-duration .25s

      &::before
        content ''
        position absolute
        bottom 0
        border 6px solid transparent
        border-bottom 8px solid #E93737
        opacity 0

      &::after
        content ''
        position absolute
        left 0
        bottom 0
        width 100%
        height 2px
        background #E93737
        opacity 0

      &:hover, &.active
        color #E93737
        transition-duration .25s

      &.active
        &::after, &::before
          opacity 1
          transition-duration .25s
</style>