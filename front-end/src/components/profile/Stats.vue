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
            p Огнестрельное оружие:
            span 55
          .row
            p Холодное оружие:
            span 55
          .row
            p Лук:
            span 55
          .row
            p В голову:
            span 55
          .row
            p Раненых:
            span 55
          .row
            p Спящих:
            span 55

      .stats-card
        .stats-card__title
          img(src="../../assets/images/icons/stats/paw.svg")
          h2 Убийство 
            span животных
        .stats-card__content
          .row
            p Медведи:
            span 55
          .row
            p Волки:
            span 55
          .row
            p Кабаны:
            span 55
          .row
            p Курицы:
            span 55
          .row
            p Лошади:
            span 55
          .row
            p Олени:
            span 55

      .stats-card
        .stats-card__title
          img(src="../../assets/images/icons/stats/death.svg")
          h2 Ваших 
            span смертей
        .stats-card__content
          .row
            p Игроков:
            span 55
          .row
            p Животных:
            span 55
          .row
            p Вертолеты:
            span 55
          .row
            p Ловушки:
            span 55
          .row
            p Радиация:
            span 55
          .row
            p Самоубийства:
            span 55

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
              span 55
            .row
              p Камень:
              span 55
            .row
              p Железная руда:
              span 55
            .row
              p МВК руда:
              span 55
            .row
              p Ткань:
              span 55
            .row
              p Кожа:
              span 55
            .row
              p Кабанье мясо:
              span 55
            .row
              p Куриное мясо:
              span 55

          .stats-card__content
            .row
              p Тыквы:
              span 55
            .row
              p Кукуруза:
              span 55
            .row
              p Семена тыквы:
              span 55
            .row
              p Семена кукурузы:
              span 55
            .row
              p Огнестрельное оружие:
              span 55
            .row
              p Семена конопли:
              span 55
            .row
              p Человеческое мясо:
              span 55
            .row
              p Грибы:
              span 55

          .stats-card__content
            .row
              p Сера:
              span 55
            .row
              p Мякоть кактуса:
              span 55
            .row
              p Животный жир:
              span 55
            .row
              p Обломки костей:
              span 55
            .row
              p Медвежье мясо:
              span 55
            .row
              p Волчье мясо:
              span 55
            .row
              p Человеческие черепа:
              span 55
            .row
              p Волчьи черепа:
              span 55
</template>

<script>
export default {
  name: 'ProfileStats',
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
