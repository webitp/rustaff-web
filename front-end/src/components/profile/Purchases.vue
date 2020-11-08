<template lang="pug">
  .purchases
    .search
      .search-input
        img(src="../../assets/images/search.svg")
        input(placeholder="Введите название для поиска", v-model="search")
      //- button.search-button Промо-Код
      a.search-button.go(href="/shop") Перейти в магазин
    
    .table
      .table__row.head
        .table__col.flex-start Товар
        .table__col.flex-start Название
        .table__col Количество
        .table__col Цена
        .table__col Дата

      .table__row(v-for="purchase in filtredPurchases")
        .table__col.flex-start
          img(:src="getItemImage(purchase)")
        .table__col.flex-start {{ purchase.name }}
        .table__col {{ purchase.count }}
        .table__col {{ purchase.price * purchase.count }} ₽
        .table__col {{ formatDate(purchase.created_at) }}
</template>

<script>
import store from '@/store';

import purchasesService from '../../services/purchases';

export default {
  name: 'ProfilePurchases',
  data() {
    return {
      user: store.state.user,

      search: '',

      purchases: []
    }
  },

  async created() {
    this.purchases = (await purchasesService.list(this.user.steamid)).data;
  },

  computed: {
    filtredPurchases() {
      const param = this.search.trim().toLowerCase();
      var res = [];
      for (const purchase of this.purchases)
        if (purchase.name.toLowerCase().indexOf(param) > -1)
          res.push(purchase);
      return res;
    }
  },

  methods: {
    formatDate(dateString) {
      const date = new Date(dateString);
      return date.toLocaleString().replace(',', '');
    },

    getItemImage(data) {
      if (!data.image) {
        const image = data.game_name.split('_').join('.');
        return `/images/items/${image}.png`;
      }
      return data.image;
    }
  }
}
</script>

<style scoped lang="stylus">
.table
  margin-top 30px

  &__row
    grid-template-columns 1fr 2fr repeat(3, 1fr)

    img
      height 100px

.search
  grid-template-columns 1fr 20%

  &-button
    display flex
    justify-content center
    align-items center

.purchases
  &__search
    display grid
    grid-template-columns 1fr repeat(2, 14.5%)
    grid-template-rows 50px
    grid-gap 30px
    margin-top 30px

    &-input
      background #1C2030
      border-radius 5px
      padding 13px 15px
      display flex
      align-items center
      justify-content space-between

      img
        cursor pointer

      input
        width calc(100% - 44px)
        height 100%
        background transparent
        font-size 14px
        font-weight 500
        color #626A8B

        &::placeholder
          color rgba(98, 106, 139, 0.5)

    &-button
      color white
      font-size 14px
      font-weight 500
      border-radius 5px
      background #5C8DD7
      cursor pointer

      &.go
        background #45A35A
</style>
