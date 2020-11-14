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
            input(placeholder="Введите название для поиска", v-model="search")
          a.search-button(href="https://vk.com/rustaffnet") Хотите разбан?
      
        .table
          .table__row.head
            .table__col.flex-start Игрок
            .table__col Причина
            .table__col Дата
            .table__col Страница

          .table__row(v-for="ban in filtredBans")
            .table__col.flex-start {{ ban.name }}
            .table__col {{ ban.reason }}
            .table__col {{ formatDate(ban.created_at) }}
            .table__col 
              a(:href="`https://steamcommunity.com/profiles/${ban.steamid}/`", target="_blank") Страница

    main-footer
</template>

<script>
import MainHeader from '../components/Header';
import MainFooter from '../components/Footer';

import banServices from '../services/bans';

export default {
  name: 'BanList',
  components: {
    MainHeader,
    MainFooter
  },
  data() {
    return {
      bans: [],
      search: ''
    }
  },

  computed: {
    filtredBans() {
      var res = [];
      for (const ban of this.bans) {
        if (ban.name.toLowerCase().indexOf(this.search) > -1)
          res.push(ban);
      }
      return res;
    }
  },

  async created() {
    this.bans = (await banServices.list()).data;
  },

  methods: {
    formatDate(time) {
      const date = new Date(time);
      return date.toLocaleString('ru-RU');
    }
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

    &-button
      display flex
      justify-content center
      align-items center

  .table__col
    a
      color #808fac

      &:hover
        text-decoration underline

.content-container
  margin-top 105px
  padding-bottom 60px
  box-sizing border-box
  min-height calc(100vh - 105px - 86px)
</style>