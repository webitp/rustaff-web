<template lang="pug">
  .kits
    main-header

    .content-container
      .content
        .content__title
          h1 Доступные 
            span киты

        .tabs
          .tabs__item(v-for="(tab, index) in tabs", :class="{ active: index == currentTab }", @click="currentTab = index") {{ tab }}

        modded

    main-footer
</template>

<script>
import MainHeader from '../components/Header';
import MainFooter from '../components/Footer';

import Modded from '../components/kits/Modded';

export default {
  name: 'Shop',
  components: {
    MainHeader,
    MainFooter,
    Modded
  },
  data() {
    return {
      tabs: [
        'MODDED',
        'VIP',
        'PREMIUM',
        'ELITE'
      ],
      currentTab: 0
    }
  },

  created() {
  }
}
</script>

<style lang="stylus" scoped>
.content-container
  margin-top 105px
  padding-bottom 60px
  box-sizing border-box
  min-height calc(100vh - 105px - 86px)
</style>

<style lang="stylus">
.kits
  .content__subtitle
    text-align left
    margin 50px 0 20px 0

    span
      color #E93737
      font-size 0.95em
      margin-left 5px
</style>