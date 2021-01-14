<template lang="pug">
  .inventory
    transition(name="fade")
      trade-modal(v-if="isOpenTrade", @close="isOpenTrade = false")

    .table
      .table__row.head
        .table__col.flex-start Товар
        .table__col.flex-start Название
        .table__col Количество
        .table__col Дата

      .table__row(v-for="item in items")
        .table__col.flex-start 
          img(:src="getItemImage(item)")
        .table__col.flex-start {{ item.purchase_type == 2 ? 'Игровой скин' : item.name }}
        .table__col(v-if="item.purchase_type != 2") {{ item.count * item.item_count }}
        .table__col(v-else)
          button.get(v-if="item.used == 0", @click="isOpenTrade = true") Получить
          button.get(v-if="item.used == 1") Получено
          button.get(v-if="item.used == 2", style="background: #e93737;") Ожидание
        .table__col {{ formatDate(item.created_at) }}

      .inventory-hint Чтобы получить товар, введите в чат /store
</template>

<script>
import store from '@/store';

import purchasesService from '../../services/purchases';

import TradeModal from '../TradeModal';

export default {
  name: 'ProfileInventory',
  components: {
    TradeModal
  },
  data() {
    return {
      user: store.state.user,

      isOpenTrade: false,

      items: []
    }
  },

  async created() {
    this.items = (await purchasesService.inventory(this.user.steamid)).data;
    console.log(this.items);
  },

  methods: {
    formatDate(dateString) {
      const date = new Date(dateString);
      return date.toLocaleString().replace(',', '');
    },

    getItemImage(data) {
      if (data.purchase_type == 2)
        return '/images/skins/spacesuit.png';
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

  .get
    background #45A35A
    border-radius 5px
    padding 10px 20px
    font-size 15px
    font-weight 500
    color #e2e2e2
    cursor pointer
</style>
