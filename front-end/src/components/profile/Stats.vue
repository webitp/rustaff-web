<template lang="pug">
  .stats
    .stats-row
      .stats-card
        .stats-card__title
          img(src="../../assets/images/icons/stats/kill.svg")
          h2 Убийство 
            span игроков
        .stats-card__content
          .row
            p Количество:
            span {{ player.kills }}

      .stats-card
        .stats-card__title
          img(src="../../assets/images/icons/stats/paw.svg")
          h2 Убийство 
            span животных
        .stats-card__content
          .row
            p Количество:
            span {{ player.animal_kills }}

      .stats-card
        .stats-card__title
          img(src="../../assets/images/icons/stats/death.svg")
          h2 Ваших 
            span смертей
        .stats-card__content
          .row
            p Количество:
            span {{ player.death }}

    .stats-row.long
      .stats-card
        .stats-card__title
          img(src="../../assets/images/icons/stats/resources.svg")
          h2 Сбор 
            span ресурсов
        .stats-card__cols
          .stats-card__content
            .row
              p Древесина:
              span {{ player.wood }} 
            .row
              p Металл:
              span {{ player.metall_ore }}

          .stats-card__content
            .row
              p Камень:
              span {{ player.stones }}
            .row
              p Сера:
              span {{ player.sulfur }}
</template>

<script>
export default {
  name: 'ProfileStats',
  props: ['player'],
  data() {
    return {
    }
  }
}
</script>

<style scoped lang="stylus">
.stats
  padding 30px 0
  padding-top 0

  &-row
    display flex
    flex-wrap wrap
    justify-content space-between

    &.long
      justify-content center

      .stats-card__cols
        grid-template-columns repeat(2, 1fr)

      .stats-card
        width 100%

  &-card
    background alpha(#1C2030, .5)
    border-radius 5px
    padding 25px
    width 370px
    box-sizing border-box
    margin-top 30px

    &__title
      display flex
      align-items center

      h2
        font-size 16px
        line-height 150%
        margin-left 10px
        color #E2E2E2
        text-transform uppercase
        font-family 'Russo One', sans-serif
        font-weight normal

        span
          color #E93737

    &__cols
      display grid
      grid-template-columns repeat(3, 1fr)
      grid-gap 80px

    &__content
      margin-top 10px

      .row
        display flex
        justify-content space-between
        border-bottom 1px solid #282B40
        height 43px
        line-height 43px
        box-sizing border-box

        p
          font-size 14px
          font-weight 500
          color #6C768D

        span
          font-size 14px
          font-weight 600
          color #A7A9AC
</style>
