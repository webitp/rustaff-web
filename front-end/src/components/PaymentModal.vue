<template lang="pug">
  .modal
    .payment
      .payment-close(@click="close()")
        img(src="../assets/images/close-modal.svg")
      h2 Пополнение баланса
      input(placeholder="Введите сумму:", type="number", min="1", v-model="sum", :readonly="staticSum ? true : false")
      button(@click="pay()") Пополнить
</template>

<script>
import store from '@/store';
import shopService from '@/services/shop';

export default {
  name: 'Footer',
  props: ['staticSum'],
  data() {
    return {
      user: store.state.user,
      sum: ''
    }
  },

  created() {
    this.sum = this.staticSum || '';
  },

  methods: {
    close() {
      this.$emit('close');
    },

    async pay() {
      if (this.user && this.sum && this.sum > 0) {
        const data = (await shopService.items.payment({
          sum: this.sum,
          steamid: this.user.steamid
        })).data;
        location.href = data.url;
        this.close();
      }
    }
  }
}
</script>

<style scoped lang="stylus">
.payment
  background #202537
  border-radius 5px
  padding 20px
  width 350px
  position relative

  &-close
    position absolute
    right 20px
    top 20px
    cursor pointer

  h2
    color #EAEAEA
    font-size 16px

  input
    width 100%
    background #2B3046
    height 40px
    padding 0 15px
    box-sizing border-box
    border-radius 5px
    margin-top 20px
    
    &, &::placeholder
      color #A1A9BC

  button
    margin-top 20px
    background #45A35A
    border-radius 5px
    height 35px
    width 100%
    color white
    font-size 14px
    font-weight bold
    text-transform uppercase
    cursor pointer
</style>
