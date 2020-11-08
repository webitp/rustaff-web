<template lang="pug">
  .kits
    main-header

    transition(name="fade")
      .modal(v-if="modals.createKit.open")
        .modal-container
          h1 Добавить кит
          input(placeholder="Название", v-model="modals.createKit.values.name")
          input(placeholder="Cooldown (в секундах)", type="number", v-model="modals.createKit.values.cooldown")
          .modal--buttons
            button(@click="createKit()") Создать
            button.close(@click="closeModal('createKit')") Закрыть

    transition(name="fade")
      .modal(v-if="modals.createKitItem.open")
        .modal-container
          h1 Добавить предмет
          input(placeholder="Игровое название", v-model="modals.createKitItem.values.game_name")
          input(placeholder="Количество", type="number", v-model="modals.createKitItem.values.count")
          .modal--buttons
            button(@click="createKitItem()") Создать
            button.close(@click="closeModal('createKitItem')") Закрыть

    .content-container
      .content
        .content__title
          h1 Доступные 
            span киты

        .tabs
          .tabs__item(v-for="(tab, index) in tabs", :class="{ active: index == currentTab }", @click="currentTab = index") {{ tab }}

        .kit(v-for="kit in filtredKits")
          .content__subtitle
            h2 {{ kit.name }} 
              span {{ formatCooldown(kit.cooldown) }}
          .icon-items
            .icon-items__item(v-for="item in kit.items")
              .icon-items__item-value x{{ item.count }}
              img(:src="`/images/items/${item.game_name}.png`")
            .icon-items__item.add(v-if="user && user.adminlvl", @click="modals.createKitItem.values.kit = kit.id; openModal('createKitItem')") +

        .kits-add(v-if="user && user.adminlvl", @click="openModal('createKit')") Добавить кит

    main-footer
</template>

<script>
import store from '@/store';

import kitsService from '../services/kits';

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
      user: store.state.user,

      modals: {
        createKit: {
          open: false,
          values: {
            name: '',
            cooldown: ''
          }
        },
        createKitItem: {
          open: false,
          values: {
            game_name: '',
            count: '',
            kit: 0
          }
        }
      },

      tabs: [
        'STANDART',
        'BRONZE',
        'SILVER',
        'GOLD'
      ],
      currentTab: 0,

      kits: []
    }
  },

  computed: {
    filtredKits() {
      return this.kits.filter((e) => e.category - 1 == this.currentTab);
    }
  },

  async created() {
    await this.loadKits();
  },

  methods: {
    formatCooldown(time) {
      var minutes = Math.floor(time / 60);
      const hours = Math.floor(minutes / 60);

      if (hours > 0)
        minutes = minutes % 60;

      var res = hours > 0 ? `${hours} ч. ` : '';
      res += minutes > 0 ? `${minutes} мин. ` : '';
      return res;
    },

    openModal(name) {
      this.modals[name].open = true;
    },

    closeModal(name) {
      this.modals[name].open = false;
    },
    async loadKits() {
      this.kits = await kitsService.get();
    },

    async createKit() {
      var values = this.modals.createKit.values;
      if (values.name.trim() && values.cooldown) {
        await kitsService.create({
          name: values.name,
          category: this.currentTab + 1,
          cooldown: values.cooldown
        });
        values = {
          name: '',
          cooldown: ''
        };
        this.modals.createKit.values = values;
        this.closeModal('createKit');
        await this.loadKits();
      }
    },

    async createKitItem() {
      var values = this.modals.createKitItem.values;
      if (values.kit && values.game_name.trim() && values.count) {
        await kitsService.items.create({
          kit: values.kit,
          game_name: values.game_name,
          count: values.count
        });
        values = {
          game_name: '',
          kit: 0,
          count: ''
        };
        this.modals.createKitItem.values = values;
        this.closeModal('createKitItem');
        await this.loadKits();
      }
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

  &-add
    background #232937
    color #6c768d
    padding 20px
    border-radius 5px
    font-size 15px
    font-weight bold
    text-align center
    width 200px
    cursor pointer
    transition-duration .25s
    margin-top 20px

    &:hover
      background #5c8dd7
      color #e2e2e2
      transition-duration .25s

.icon-items__item.add
  cursor pointer
  font-weight bolder
  color #6c768d
  font-size 45px
  text-align center

.icon-items__item
  img
    width 50%
</style>