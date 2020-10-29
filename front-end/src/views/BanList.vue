<template lang="pug">
  .bans
    main-header

    .content-container
      .content
        .content__title
          h1 Бан 
            span лист

        .search
          .search-input
            img(src="../assets/images/search.svg")
            input(placeholder="Введите название для поиска")
          button.search-button Хотите разбан?
      
        .table
          .table__row.head
            .table__col.flex-start Игрок
            .table__col Причина
            .table__col Дата
            .table__col Страница

          .table__row
            .table__col.flex-start Игрок
            .table__col Причина
            .table__col Дата
            .table__col Страница
          .table__row
            .table__col.flex-start Игрок
            .table__col Причина
            .table__col Дата
            .table__col Страница

    main-footer
</template>

<script>
import MainHeader from '../components/Header';
import MainFooter from '../components/Footer';

export default {
  name: 'BanList',
  components: {
    MainHeader,
    MainFooter
  },
  data() {
    return {
      
    }
  },

  created() {
  }
}
</script>

<style lang="stylus" scoped>
.table
  margin-top 30px

  &__row
    grid-template-columns repeat(4, 1fr)

.bans
  .search
    grid-template-columns 1fr 14.5%

.content-container
  margin-top 105px
  padding-bottom 60px
  box-sizing border-box
  min-height calc(100vh - 105px - 86px)
</style>