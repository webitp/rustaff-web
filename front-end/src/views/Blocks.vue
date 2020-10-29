<template lang="pug">
  .block
    main-header

    .content-container
      .content
        .content__title
          h1 Временные 
            span блокировки

        .content__subtitle
          h2 Заблокированное оружие
        .icon-items
          .icon-items__item(v-for="item in guns")
            .icon-items__item-value {{ item.value }} М.
            img(:src="require(`../assets/images/items/${item.icon}`)")

        .content__subtitle
          h2 Заблокированная одежда
        .icon-items
          .icon-items__item(v-for="item in clothes")
            .icon-items__item-value {{ item.value }} М.
            img(:src="require(`../assets/images/items/${item.icon}`)")

    main-footer
</template>

<script>
import MainHeader from '../components/Header';
import MainFooter from '../components/Footer';

export default {
  name: 'Shop',
  components: {
    MainHeader,
    MainFooter
  },
  data() {
    return {
      guns: [
        {
          icon: '1.png',
          value: 30,
        },
        {
          icon: '2.png',
          value: 30,
        },
        {
          icon: '3.png',
          value: 30,
        },
        {
          icon: '4.png',
          value: 30,
        },
        {
          icon: '5.png',
          value: 30,
        },
        {
          icon: '6.png',
          value: 30,
        },
        {
          icon: '7.png',
          value: 30,
        },
      ],

      clothes: [
        {
          icon: '1.png',
          value: 30,
        },
        {
          icon: '2.png',
          value: 30,
        },
        {
          icon: '3.png',
          value: 30,
        },
        {
          icon: '4.png',
          value: 30,
        },
        {
          icon: '5.png',
          value: 30,
        },
        {
          icon: '6.png',
          value: 30,
        },
        {
          icon: '7.png',
          value: 30,
        },
      ]
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

.content__subtitle
  text-align left
  margin 50px 0 20px 0

.block
  &-items
    display grid
    grid-template-columns repeat(8, 1fr)
    grid-gap 20px

    &__item
      height 120px
      display flex
      justify-content center
      align-items center
      position relative
      background-image url('../assets/images/items/bg.svg')
      background-cover #1C2030
      background-size cover
      border-radius 5px
      overflow hidden
      user-select none
      box-shadow 0px 5px 5px rgba(0, 0, 0, 0.15)

      img
        filter drop-shadow(0px 8px 4px rgba(0, 0, 0, 0.15))

      &-value
        position absolute
        left 0
        top 0
        background #5C8DD7
        border-radius 5px 0 5px 0
        width 70px
        height 23px
        text-align center
        line-height 23px
        text-transform uppercase
        text-shadow 0px 2px 2px rgba(0, 0, 0, 0.15)
</style>