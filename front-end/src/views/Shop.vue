<template lang="pug">
  .shop
    main-header

    transition(name="fade")
      payment-modal(v-if="modals.payment.open", :staticSum="staticPrice", @close="staticPrice = null; closeModal('payment')")

    .modal(v-if="modals.createCategory.open")
      .modal-container
        h1 Добавить категорию
        input(placeholder="Название", v-model="modals.createCategory.values.name")
        .modal--buttons
          button(@click="createCategory()") Создать
          button.close(@click="closeModal('createCategory')") Закрыть

    .modal(v-if="modals.createItem.open")
      .modal-container
        h1 Добавить предмет
        select(v-model="modals.createItem.values.category")
          option(value="0" selected) Выберите категорию
          option(v-for="category in categories", :value="category.id") {{ category.name }}
        input(placeholder="Название", v-model="modals.createItem.values.name")
        input(placeholder="Игровое название предмета", v-model="modals.createItem.values.gameName")
        input(placeholder="Цена", type="number", v-model="modals.createItem.values.price")
        input(placeholder="Количество", type="number", v-model="modals.createItem.values.count")
        input(placeholder="Изображение (оставьте пустым, если игровая иконка)", v-model="modals.createItem.values.image")
        .modal--buttons
          button(@click="createItem()") Создать
          button.close(@click="closeModal('createItem')") Закрыть

    transition(name="fade")
      .modal(v-if="purchase.open")
        .modal-container.purchase
          .purchase-close(@click="purchase.open = false;")
            img(src="../assets/images/close-modal.svg")
          .purchase-item.shop-items__item
            .price {{ purchase.item.price }} ₽
            .shop-items__item-icon
              img(:src="getItemImage(purchase.item)")
            .purchase-item__data
              h2 {{ purchase.item.name }} 
                span(v-if="purchase.item.count > 1") (x{{ purchase.item.count * purchase.count }})
              p.description(v-if="purchase.item.type == 1", v-html="parsePrivilegeData(purchase.item.game_name).description")
              a.kits(v-if="purchase.item.type == 1", :href="`/kits?tab=${parsePrivilegeData(purchase.item.game_name).kits_page}`") Просмотреть доступные киты
              .purchase-item__count
                p Количество
                .input
                  .input-button(@click="subPurchaseCount()")
                    img(src="../assets/images/arrow-purchase.svg")
                  input(:value="`${purchase.count} шт.`", readonly)
                  .input-button(@click="addPurchaseCount()")
                    img(src="../assets/images/arrow-purchase.svg", style="transform: rotate(180deg)")
              .button(@click="buyItem()") Купить за {{ purchase.item.price * purchase.count }} ₽
              .hint Чтобы получить товар, введи в чат /store

    .content-container
      .content
        .content__title
          h1 Магазин 
            span сервера

        .search
          .search-input
            img(src="../assets/images/search.svg")
            input(placeholder="Введите название для поиска", v-model="search")
          .search-button.go(v-if="user", @click="openModal('payment')") Баланс: {{ user.money }} ₽
            img(src="../assets/images/add.svg")
          .search-button.go(v-else) Авторизуйтесь

        .shop__content
          .shop-categories
            h3 Категории
            ul.shop-categories__list
              li(:class="{ active: activeParams.indexOf(0) > -1 }", @click="toggleParam(0)")
                .check
                p Все
                  span ({{ items.length }})
              li(v-for="(category, idx) in categories", :class="{ active: activeParams.indexOf(category.id) > -1 }", @click="toggleParam(category.id)")
                .check
                p {{ category.name }} 
                  span ({{ category.count }})
                  span.delete(v-if="user && user.adminlvl", @click="deleteCategory(category.id)") del
              li(v-if="user && user.adminlvl", @click="openModal('createCategory')")
                p(style="width: 100%; text-align: center")
                  b Добавить

          .shop-items
            .shop-items__item(v-for="item in filtredItems", @click="openPurchase(item)")
              .delete(v-if="user && user.adminlvl", @click="deleteItem(item.id)") del
              .price {{ item.price }} ₽
              .shop-items__item-icon
                img(:src="getItemImage(item)")
              .shop-items__item-name
                p {{ item.name }} 

            .shop-items__item(v-if="user && user.adminlvl", @click="openModal('createItem')")
              .add +

    main-footer
</template>

<script>
import store from '@/store';

import shopService from '../services/shop';
import purchasesService from '../services/purchases';

import MainHeader from '../components/Header';
import MainFooter from '../components/Footer';
import PaymentModal from '../components/PaymentModal';

export default {
  name: 'Shop',
  components: {
    MainHeader,
    MainFooter,
    PaymentModal
  },
  data() {
    return {
      user: store.state.user,

      modals: {
        createCategory: {
          open: false,
          values: {
            name: ''
          }
        },
        createItem: {
          open: false,
          values: {
            category: 0,
            name: '',
            gameName: '',
            price: '',
            count: '',
            image: ''
          }
        },
        payment: {
          open: false
        }
      },

      search: '',

      activeParams: [0],

      categories: [],
      items: [],
      filtredItems: [],

      purchase: {
        open: false,
        count: 1,
        item: {}
      },

      staticPrice: null
    }
  },

  async created() {
    await this.loadCategories();
    await this.loadItems();
  },

  methods: {
    parsePrivilegeData(json) {
      console.log(json);
      return JSON.parse(json);
    },

    getItemImage(data) {
      if (!data.image) {
        const image = data.game_name.split('_').join('.');
        return `/images/items/${image}.png`;
      }
      return data.image;
    },

    async loadCategories() {
      this.categories = (await shopService.categories.get()).data;
    },

    async loadItems() {
      this.items = (await shopService.items.get()).data;
      this.filterItems();
    },

    filterItems() {
      var res = [];
      const categories = this.activeParams;

      for (const item of this.items) {
        if (categories.indexOf(item.category) > -1 || categories.indexOf(0) > -1 || !categories.length) {
          if (this.search.trim()) {
            if (item.name.toLowerCase().indexOf(this.search.toLowerCase().trim()) > -1)
              res.push(item);
          }
          else
            res.push(item);
        }  
      }

      this.filtredItems = res;
    },

    toggleParam(key) {
      if (key != 0 && this.activeParams.indexOf(0) > -1)
        delete this.activeParams[this.activeParams.indexOf(0)];

      if (key == 0) {
        this.activeParams = [0];
      } else {
        const index = this.activeParams.indexOf(key);
        if (index > -1)
          delete this.activeParams[index]
        else
          this.activeParams.push(key);
      }

      if (!this.activeParams.length)
        this.activeParams = [0];

      this.activeParams = this.activeParams.filter((e) => e || e == 0);

      this.filterItems();
      this.$forceUpdate();
    },

    openModal(name) {
      this.modals[name].open = true;
    },

    closeModal(name) {
      this.modals[name].open = false;
      const values = this.modals[name].values;
      for (const value in values)
        this.modals[name].values[value] = '';
    },

    async createCategory() {
      const name = this.modals.createCategory.values.name;
      if (name.trim()) {
        await shopService.categories.create(name);
        await this.loadCategories();
        this.closeModal('createCategory');
      }
    },

    async deleteCategory(id) {
      await shopService.categories.delete(id);
      await this.loadCategories();
    },

    async createItem() {
      const name = this.modals.createItem.values.name;
      const gameName = this.modals.createItem.values.gameName;
      const price = this.modals.createItem.values.price;
      const count = this.modals.createItem.values.count;
      const image = this.modals.createItem.values.image;
      const category = this.modals.createItem.values.category;
      if (name.trim() && gameName.trim() && price && category && count > 0) {
        await shopService.items.create(name, gameName, price, category, image, count);
        await this.loadItems();
        this.closeModal('createItem');
        this.modals.createItem.values.category = 0;
      }
    },

    async deleteItem(id) {
      await shopService.items.delete(id);
      await this.loadItems();
    },

    openPurchase(item) {
      this.purchase.item = item;
      this.purchase.count = 1;
      this.purchase.open = true;
    },

    addPurchaseCount() {
      this.purchase.count++;
    },

    subPurchaseCount() {
      if (this.purchase.count > 1)
        this.purchase.count--;
    },

    async buyItem() {
      if (this.user) {
        const itemPrice = this.purchase.item.price * this.purchase.count;
        if (this.user.money < itemPrice) {
          this.$notify({
            group: 'main',
            title: 'Недостаточно средств!',
            text: 'Пополните баланс в появившемся окне.',
            type: 'error'
          });

          this.staticPrice = itemPrice - this.user.money;
          
          this.purchase.open = false;
          this.openModal('payment');
        } else {
          await purchasesService.create(this.user.steamid, this.purchase.item.id, this.purchase.count);
          this.purchase.open = false;
          store.state.user.money -= this.purchase.item.price * this.purchase.count;

          this.$notify({
            group: 'main',
            title: 'Вы успешно купили предмет',
            text: 'Чтобы получить товар, введи в чат /store.',
            type: 'success',
            duration: 7500
          });
        }
      } else {
        location.href = store.state.loginUrl;
      }
    }
  },

  watch: {
    search() {
      this.filterItems();
    }
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

.search
  grid-template-columns 1fr 24%

  &-button
    line-height 50px
    display flex
    align-items center
    justify-content center
    cursor pointer
    user-select none
    
    img
      margin-left 6px

.shop
  &__content
    display flex
    justify-content space-between
    align-items flex-start
    margin-top 30px

  &-categories
    width 270px
    background #1C2030
    border-radius 5px
    box-shadow 0px 5px 15px rgba(0, 0, 0, 0.15)
    box-sizing border-box
    padding 30px

    h3
      font-size 18px
      font-weight 600
      color white
      line-height 100%

    &__list
      list-style none
      margin-top 20px

      li
        display flex
        align-items center
        cursor pointer
        margin-top 19px
        position relative

        &:first-child
          margin 0

        &:hover, &.active
          .check
            &::after
              opacity 1
              transition-duration .25s

        .check
          width 18px
          height 18px
          border-radius 2px
          border 2px solid #6C768D
          box-sizing border-box
          cursor pointer
          position relative

          &::after
            position absolute
            content ''
            width calc(100% + 4px)
            height calc(100% + 4px)
            background-image url('../assets/images/ok.svg')
            background-size cover
            left -2px
            top -2px
            opacity 0
            transition-duration .25s

        p
          color #6C768D
          font-size 15px
          font-weight 500
          line-height 100%
          margin-left 10px

          span
            color #383F59

          .delete
            position absolute
            right 0
            transition-duration .25s
            
            &:hover
              color #e93737
              cursor pointer
              transition-duration .25s

  &-items
    width calc(100% - 300px)
    display grid
    grid-template-columns repeat(auto-fill, 130px)
    grid-gap 18px

    &__item
      width 130px
      height 182px
      background #1C2030
      box-shadow 0px 5px 5px rgba(0, 0, 0, 0.15)
      border-radius 5px
      position relative
      cursor pointer
      display block
      overflow hidden

      .add
        height 100%
        display flex
        justify-content center
        align-items center
        font-size 40px
        color #6c768d
        font-weight bold

      .delete
        position absolute
        right 0
        top 0
        background #262B3F
        height 33px
        padding 0 10px
        color #6C768D
        line-height 33px
        font-size 13px
        transition-duration .25s
          
        &:hover
          color #e93737
          cursor pointer
          transition-duration .25s

      &-icon
        width 100%
        height 120px
        display flex
        justify-content center
        align-items center
        background-image url('../assets/images/items/bg.svg')
        background-cover #1C2030
        background-size cover
        overflow hidden

        img
          width 60%

      &-name
        height 60px
        display flex
        justify-content center
        align-items center
        padding 0 10px

        p
          font-size 13px
          line-height 150%
          font-weight 500
          color #6C768D
          text-shadow 0px 2px 2px rgba(0, 0, 0, 0.15)
          text-align center

          span
            color #383F59

      .price
        position absolute
        left 0
        top 0
        background #262B3F
        width 55px
        height 33px
        text-align center
        line-height 33px
        text-shadow 0px 2px 2px rgba(0, 0, 0, 0.15)
        color #45A35A
        font-size 13px
        font-weight 600
  
.purchase
  padding 0
  width auto
  border-radius 5px
  overflow hidden
  box-shadow 0px 15px 30px rgba(0, 0, 0, 0.25)
  position relative

  &-close
    position absolute
    right 10px
    top 10px
    cursor pointer
    z-index 1

  &-item
    width 322px
    height auto
    cursor auto

    .shop-items__item-icon
      height 215px !important
      background-size cover
      background-repeat no-repeat
      background-position center
      background-image url('../assets/images/purchase-bg.svg')

    &__data
      padding 26px 30px
      user-select none

      h2
        text-align center
        font-size 16px
        line-height 150%
        color #B6BFD2
        text-shadow 0px 2px 2px rgba(0, 0, 0, 0.15)

        span
          color #383F59

      p.description
        text-align left
        font-size 12px
        margin-top 10px

      a.kits
        width 100%
        display block
        text-align center
        font-size 14px
        color #B6BFD2
        margin-top 10px

        &:hover
          text-decoration underline

      .button
        text-align center
        background #45A35A
        border-radius 5px
        height 45px
        cursor pointer
        line-height 45px
        color white
        font-size 14px
        font-weight bold
        text-transform uppercase
        margin-top 25px

      .hint
        text-align center
        color #E93737
        font-size 14px
        font-weight 500
        line-height 150%
        margin-top 15px

    &__count
      margin-top 20px

      p
        color rgba(108, 118, 141, 0.6)
        font-size 14px
        font-weight 500

      .input
        display flex
        align-items center
        height 40px
        border-radius 5px
        overflow hidden
        margin-top 10px

        input
          margin 0
          border-radius 0
          height 100%
          width calc(100% - 80px)
          background #2B3046
          text-align center
          color #A1A9BC

        &-button
          width 40px
          height 100%
          display flex
          justify-content center
          align-items center
          background #202537
          cursor pointer

@media screen and (max-width: 1040px)
  .shop
    &__content
      flex-wrap wrap

    &-categories, &-items
      width 100%

    &-items
      margin-top 50px
      justify-content center

.fade-enter-active, .fade-leave-active
  transition opacity .5s
.fade-enter, .fade-leave-to
  opacity 0
</style>