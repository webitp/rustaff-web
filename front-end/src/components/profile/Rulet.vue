<template lang="pug">
  .rulet
    .modal(v-if="modals.createItem.open")
      .modal-container
        h1 Добавить предмет
        input(placeholder="Название", v-model="modals.createItem.values.name")
        input(placeholder="Изображение", v-model="modals.createItem.values.image")
        select(v-model="modals.createItem.values.type")
          option(value="1", selected) Игровой предмет
          option(value="2") Игровой скин
          option(value="3") Привилегия
          option(value="4") Деньги
        select(v-model="modals.createItem.values.isConstant")
          option(value="0", selected) Динамический предмет
          option(value="1") Статический предмет
        .modal--buttons
          button(@click="createItem()") Создать
          button.close(@click="closeModal('createItem')") Закрыть

    transition(name="fade")
      trade-modal(v-if="modals.trade.open", @close="closeModal('trade')")

    .rulet-content
      .rulet-content__left
        .wheel
          img.wheel-point(src="../../assets/images/wheel-point.svg")
          .wheel-button(v-if="access", @click="roll()") Крутить бесплатно
          .wheel-button(v-else) Вы не отыграли<br>1 час
          transition(name="fade")
            .wheel-result(v-if="result.index > -1")
              transition(name="fade")
                .wheel-result__content(v-if="result.animstate")
                  img(:src="getItemImage(rulletItems[result.index])")
                  p {{ result.text }}
          .wheel-container(:style="{ transform: rotate ? `rotate(-${3618 + this.rotate}deg)` : `rotate(-${startRotateAngel}deg)`, 'transition-duration': anim ? ROLL_TIME + 'ms' : '' }")
            img.item(:src="item.image", v-for="item in itemsConst")
            img.item(:src="getItemImage(item)", v-for="item in items")
      .rulet-content__right
        .rulet-content__info
          .rulet-content__info--title
            img.dice(src="../../assets/images/dice.svg")
            h2 Бесплатная <span>рулетка</span>
          p Данная рулетка доступна всем игрока бестлатно, отыграв на сервере 1 час, вы можете прокрутить рулетку 1 раз. Вы можете выбрать призы из списка ниже, после выбора призов нажмите на кнопку КРУТИТЬ БЕСПЛАТНО.
          h3 Призы, которые нельзя изменить:
          .items
            .items-item
              .items-item__image
                img(src="/images/skins/spacesuit.png")
              span Spacesuit
            .items-item
              .items-item__image
                img(src="/images/items/privilege.png")
              span Привилегия
            .items-item
              .items-item__image
                img(src="/images/items/bonus.png")
              span Баланс
          p Все призы будут отправлены ваш инвентарь,Чтобы получить предмет, введите в чат <span>/store</span>

    .rulet-items
      .rulet-items__data
        h3 Хочу выиграть
        p Нажмите на предмет, чтобы добавить его на барабан.

      .rulet-items__container
        .rulet-items__arrow(@click="slideLeft()", :style="{ opacity: itemsOffset == 0 ? '0.3' : '1' }")
          img(src="../../assets/images/arrow-slide.svg", style="transform: rotate(180deg)")
        .rulet-items__list
          .rulet-items__item(v-if="user && user.adminlvl", style="font-size: 30px; font-weight: bold; color: #e2e2e2; margin-right: 10px; position: relative; z-index: 1", @click="openModal('createItem')") +
          .rulet-items__item(v-for="(item, index) in itemsSelect", :style="getItemOffsetStyle(index)", :class="{ active: isSelectedItem(item) }", @click="selectItem(item)")
            img(v-if="item.type == 1", :src="`/images/items/${item.name.split('_').join('.')}.png`")
            img(v-else, :src="item.image")
        .rulet-items__arrow(@click="slideRight()", :style="{ opacity: !canSlideRight() ? '0.3' : '1' }")
          img(src="../../assets/images/arrow-slide.svg")
</template>

<script>
import store from '@/store';

import rulletService from '../../services/rullet';
import shopService from '../../services/shop';

import TradeModal from '../TradeModal';

export default {
  name: 'ProfilePurchases',
  components: {
    TradeModal
  },
  data() {
    return {
      user: store.state.user,
      rotate: false,
      rolling: false,

      access: false,

      startRotateAngel: 0,
      anim: false,

      result: {
        index: -1,
        animstate: 0,
        text: ''
      },

      ROLL_TIME: 5000,

      modals: {
        createItem: {
          open: false,
          values: {
            name: '',
            image: '',
            type: 1,
            isConstant: 0
          }
        },
        trade: {
          open: false
        }
      },

      items: [],

      itemsOffset: 0,
      itemsConst: [],
      itemsSelect: [],

      PRIVILEGIES: [
        'Bronze',
        'Silver',
        'Gold'
      ]
    }
  },

  async created() {
    this.access = (await rulletService.access(this.user.steamid)).data;

    await this.loadItems();

    this.startRotateAngel = this.calcStartAngel();

    this.$nextTick(() => {
      this.anim = true;
    });
    // const items = this.itemsSelect.sort(function(){
    //   return Math.random() - 0.5;
    // }).slice(0, 10 - this.itemsConst.length);
    // for (const item of items)
    //   this.items.push(item);
  },

  computed: {
    rulletItems() {
      let itemsRullet = this.itemsConst;
      return itemsRullet.concat(this.items);
    },
  },

  methods: {
    async roll() {
      if (this.rolling || this.rulletItems.length != 10) {
        this.$notify({
          group: 'main',
          title: 'Заполните рулетку!',
          text: 'Выберите динамические предметы, которые хотите добавить на рулетку.',
          type: 'error',
          duration: 5000
        });
        return;
      }

      let itemsRullet = this.rulletItems;
      let res = [];
      for (const item of itemsRullet)
        res.push(item.id);
      itemsRullet = res;

      const predict = (await rulletService.predict({ items: itemsRullet})).data;
      const item = this.getItemByID(predict.item);
      
      const index = itemsRullet.indexOf(item.id);
      this.rotate = 36 * index - ((Math.random() * 1000) % 33);
      this.rolling = true;

      setTimeout(async () => {
        const itemModel = this.rulletItems[index];
        if (itemModel.type == 1) {
          const itemInfo = (await shopService.items.info(itemModel.name)).data;
          this.result.text = itemInfo.name;
          if (itemInfo.count > 1)
            this.result.text += ' x' + itemInfo.count;
        }
        if (itemModel.type == 2) {
          this.result.text = 'Игровой скин ' + itemModel.name.toUpperCase();
          this.openModal('trade');
        }
        if (itemModel.type == 3)
          this.result.text = 'Привилегия ' + this.PRIVILEGIES[predict.other];
        if (itemModel.type == 4) {
          this.result.text = 'Баланс +' + predict.other + ' руб.';
          store.state.user.money += predict.other;
        }

        this.result.index = index;
        this.rolling = false;

        setTimeout(async () => {
          this.result.animstate = 1;

          let title = '', text = '';
          if (itemModel.type == 1) {
            title = 'Вы выиграли игровой предмет!';
            text = 'Предмет успешно добавлен вам в инвентарь. Введите /store в чат, чтоб использовать.';
          }
          else if (itemModel.type == 2) {
            title = 'Вы выиграли игровой скин!';
            text = 'Для получения перейдите во вкладку "инвентарь"';
          }
          else if (itemModel.type == 3) {
            title = 'Вы выиграли игровую привилегию!';
            text = 'Привилегия успешно добавлена вам в инвентарь. Введите /store в чат, чтоб использовать.';
          }
          else if (itemModel.type == 4) {
            title = `Вы выиграли ${predict.other} руб. на счет!`;
            text = 'Деньги успешно начислены вам на аккаунт.';
          }

          this.$notify({
            group: 'main',
            title: title,
            text: text,
            type: 'success',
            duration: 5000
          });

          var query = {
            type: itemModel.type,
            name: itemModel.name,
            steamid: this.user.steamid,
            param: predict.other,
          }
          await rulletService.givePrize(query);
          await rulletService.use(this.user.steamid);
          this.access = false;

          setTimeout(() => {
            this.resetRullet();
          }, 5000);
        }, 250);
      }, this.ROLL_TIME);
    },

    calcStartAngel() {
      return (Math.random() * 1000) % 360;
    },

    resetRullet() {
      this.result.index = -1;
      this.result.animstate = 0;
      this.result.text = '';
      this.anim = false;
      this.rotate = 0;
      this.startRotateAngel = this.calcStartAngel();
      this.$nextTick(() => {
        this.anim = true;
      });
    },

    getItemByID(id) {
      let items = this.itemsConst;
      items = items.concat(this.items);
      const item = items.filter(e => e.id == id);
      return item[0];
    },

    getItemImage(item) {
      if (item) {
        if (item.type == 1)
          return `/images/items/${item.name.split('_').join('.')}.png`;
        return item.image;
      }
      return '';
    },

    openModal(name) {
      this.modals[name].open = true;
    },

    closeModal(name) {
      this.modals[name].open = false;
    },

    ucFirst(str) {
      if (!str) return str;
      return str[0].toUpperCase() + str.slice(1);
    },

    async createItem() {
      const name = this.modals.createItem.values.name;
      const image = this.modals.createItem.values.image;
      const type = this.modals.createItem.values.type;
      const isConstant = this.modals.createItem.values.isConstant;

      await rulletService.create({
        name: name,
        image: image,
        type: type,
        constant: isConstant
      });

      this.modals.createItem.values = {
        name: '',
        image: '',
        type: 1,
        isConstant: 0
      };
      this.closeModal('createItem');

      await this.loadItems();
    },

    async loadItems() {
      const items = (await rulletService.items()).data;
      this.itemsConst = items.filter(e => e.is_constant);
      this.itemsSelect = items.filter(e => !e.is_constant);
    },

    isSelectedItem(item) {
      return this.items.filter(e => e.id == item.id).length > 0;
    },

    selectItem(item) {
      if (this.items.indexOf(item) == -1 ) {
        if (this.items.length >= 10 - this.itemsConst.length) return;
        this.items.push(item);
      } else {
        this.items[this.items.indexOf(item)] = null;
        this.items = this.items.filter(e => e != null);
        this.$forceUpdate();
      }
    },

    getItemOffsetStyle(index) {
      if (index == 0)
        return 'margin-left: ' + (-110 * this.itemsOffset + 'px');
      return ''
    },

    canSlideRight() {
      const list = document.querySelector('.rulet-items__list');
      if (list) {
        const width = 110 * this.itemsSelect.length - 10;

        return (width - list.clientWidth) > (110 * this.itemsOffset);
      }
      return true;
    },

    slideRight() {
      if (this.canSlideRight())
        this.itemsOffset++;
    },

    slideLeft() {
      if (this.itemsOffset > 0)
        this.itemsOffset--;
    }
  }
}
</script>

<style scoped lang="stylus">
.rulet
  img
    user-select none

  &-content
    width 100%
    display flex
    justify-content space-between
    align-items center
    margin-top 60px

    &__right
      width 50%

    &__info
      width 100%
      box-sizing border-box
      background #1C2030
      border-radius 5px
      padding 20px

      &--title
        display flex
        justify-content center
        align-items center

        h2
          margin-left 10px
          text-transform uppercase
          color #E2E2E2
          font-family 'Russo One'
          font-weight normal
          font-size 16px
          color #E2E2E2

          span
            color #E93737

      p
        margin-top 20px
        color #808FAC
        font-size 14px
        line-height 170%
        font-weight 500

        span
          color #E93737

      h3
        margin-top 43px
        color #E2E2E2
        font-size 14px
        line-height 170%
        font-weight 500

      .items
        display grid
        grid-template-columns repeat(3, 118px)
        justify-content space-evenly
        margin-top 10px
        padding-bottom 20px

        &-item
          text-align center

          &__image
            width 100%
            height 118px
            background-image url('../../assets/images/items/bg.svg')
            background-size cover
            background-position center
            display flex
            justify-content center
            align-items center
            box-shadow 0px 0px 20px rgba(0, 0, 0, 0.15)
            margin-bottom 4px

          span
            text-align center
            color #808FAC
            font-size 16px
            line-height 150%
            font-family 'Russo One'

  &-items
    display flex
    margin-top 70px
    padding-bottom 40px
    justify-content space-between

    &__data
      width 230px

      h3
        font-size 30px
        line-height 100%
        font-weight bold
        color #E2E2E2
        text-transform uppercase

      p
        color #6C768D
        font-size 14px
        font-weight 500
        line-height 100%
        margin-top 14px

    &__container
      display flex
      align-items center
      max-width calc(100% - 220px)

    &__list
      display flex
      overflow hidden

    &__arrow
      height 100%
      padding 0 10px
      display flex
      align-items center
      cursor pointer

    &__item
      min-width 100px
      min-height 100px
      background-image url('../../assets/images/items/bg.svg')
      background-size cover
      background-position center
      display flex
      justify-content center
      align-items center
      margin-left 10px
      box-shadow 0px 8px 4px rgba(0, 0, 0, 0.15)
      border-radius 5px
      transition-duration .5s
      transition-property margin
      cursor pointer

      &:hover, &.active
        border 2px solid rgba(69, 163, 90, 0.5)
        box-sizing border-box

      &:first-child
        margin 0

      img
        width 75px

  .wheel
    display flex
    justify-content center
    align-items center
    position relative
    user-select none

    &-point
      position absolute
      top 0
      z-index 1

    &-result
      position absolute
      z-index 2
      display flex
      justify-content center
      align-items center
      width 100%
      height 100%

      &__content
        width 100%
        height 100%
        display flex
        justify-content center
        align-content center
        position relative
        z-index 1
        flex-wrap wrap

        img
          width 40%

        p
          display block
          width 100%
          text-align center
          color #E2E2E2
          font-size 40px
          line-height 150%
          font-family 'Russo One'

      &::before
        content ''
        position absolute
        width 280px
        height 280px
        background #5C8DD7
        filter blur(200px)
        border-radius 50%

    &-button
      position absolute
      background #202435
      border 3px solid #1C2030
      box-sizing border-box
      width 205px
      height 205px
      display flex
      justify-content center
      align-items center
      border-radius 50%
      color #6C768D
      font-size 20px
      line-height 120%
      font-weight bold
      text-align center
      text-transform uppercase
      cursor pointer
      z-index 1
      user-select none

    &-container
      width 500px
      height 500px
      background-image url('../../assets/images/wheel.svg')
      background-size cover
      background-position center
      position relative
      display flex
      justify-content center
      align-items center

      .item
        width 70px
        position absolute

        &:nth-child(1)
          top 28px

        &:nth-child(2)
          top 70px
          right 95px
          transform rotate(38.49deg)

        &:nth-child(3)
          right 32px
          top 163px
          transform rotate(73.94deg)

        &:nth-child(4)
          right 36px
          bottom 155px
          transform rotate(109.87deg)

        &:nth-child(5)
          right 105px
          bottom 60px
          transform rotate(144.44deg)

        &:nth-child(6)
          bottom 27px
          transform rotate(180deg)

        &:nth-child(7)
          left 105px
          bottom 60px
          transform rotate(-142.65deg)

        &:nth-child(8)
          left 36px
          bottom 155px
          transform rotate(-109.87deg)

        &:nth-child(9)
          left 32px
          top 163px
          transform rotate(-73.94deg)

        &:nth-child(10)
          left 95px
          top 70px
          transform rotate(-38.49deg)

@media screen and (max-width: 1250px)
  .rulet
    &-content
      flex-wrap wrap
      justify-content center
      flex-direction column-reverse

      .wheel
        &-container
          width 70vw
          height 70vw

        &-button
          width 31vw
          height 31vw
          font-size 3vw

      &__left, &__right
        width 100%

      &__left
        margin-top 70px
</style>
