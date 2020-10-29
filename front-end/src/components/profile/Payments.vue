<template lang="pug">
  .payments
    .search
      .search-input
        img(src="../../assets/images/search.svg")
        input(placeholder="Введите название для поиска", v-model="search")
      button.search-button.go(@click="modals.payment.open = true;") Пополнить баланс

    transition(name="fade")
      payment-modal(v-if="modals.payment.open", @close="modals.payment.open = false;")
    
    .table
      .table__row.head
        .table__col Дата
        .table__col Сумма

      .table__row(v-for="payment in filtredPayments")
        .table__col {{ formatDate(payment.created_at) }}
        .table__col {{ payment.amount }} ₽
</template>

<script>
import store from '@/store';

import paymentsService from '../../services/payments';

import PaymentModal from '../../components/PaymentModal';

export default {
  name: 'ProfilePayments',

  components: {
    PaymentModal
  },

  data() {
    return {
      user: store.state.user,

      search: '',

      modals: {
        payment: {
          open: false
        }
      },

      payments: []
    }
  },

  computed: {
    filtredPayments() {
      const param = this.search.trim();
      if (param) {
        var res = [];
        for (const payment of this.payments)
          if (payment.amount == param)
            res.push(payment);
        return res;
      }
      return this.payments;
    }
  },

  async created() {
    this.payments = (await paymentsService.list(this.user.steamid)).data;
  },

  methods: {
    formatDate(dateString) {
      const date = new Date(dateString);
      return date.toLocaleString().replace(',', '');
    }
  }
}
</script>

<style scoped lang="stylus">
.table
  margin-top 30px

  &__row
    grid-template-columns 1fr 1fr

.payments
  .search
    grid-template-columns 1fr 14.5%
</style>
