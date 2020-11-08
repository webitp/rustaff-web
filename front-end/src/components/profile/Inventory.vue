<template lang="pug">
  .inventory    
    .table
      .table__row.head
        .table__col.flex-start Товар
        .table__col.flex-start Название
        .table__col Количество
        .table__col Дата

      .table__row(v-for="item in items")
        .table__col.flex-start 
          img(:src="getItemImage(item)")
        .table__col.flex-start {{ item.name }}
        .table__col {{ item.count }}
        .table__col {{ formatDate(item.created_at) }}

      .inventory-hint Чтобы получить товар, введите в чат /store
</template>

<script>
import store from '@/store';

import purchasesService from '../../services/purchases';

export default {
  name: 'ProfileInventory',
  data() {
    return {
      user: store.state.user,

      items: []
    }
  },

  async created() {
    this.items = (await purchasesService.inventory(this.user.steamid)).data;
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
  overflow hidden

  &__row
    grid-template-columns repeat(4, 1fr)

    img
      height 100px

.inventory
  &-hint
    background #5C8DD7
    height 55px
    text-align center
    line-height 55px
    font-size 16px
    font-weight 500
</style>
