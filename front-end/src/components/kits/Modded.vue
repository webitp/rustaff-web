<template lang="pug">
  .modded
    .content__subtitle
      h2 СТАРТ 
        span 1 час
    .icon-items
      .icon-items__item(v-for="item in guns")
        .icon-items__item-value {{ item.value }} М.
        img(:src="require(`../../assets/images/items/${item.icon}`)")

    .content__subtitle
      h2 МЕДИК 
        span 30 мин
    .icon-items
      .icon-items__item(v-for="item in clothes")
        .icon-items__item-value {{ item.value }} М.
        img(:src="require(`../../assets/images/items/${item.icon}`)")

    .content__subtitle
      h2 ЕДА 
        span 20 мин
    .icon-items
      .icon-items__item(v-for="item in clothes")
        .icon-items__item-value {{ item.value }} М.
        img(:src="require(`../../assets/images/items/${item.icon}`)")

    .content__subtitle
      h2 ДОМ 
        span 24 часа
    .icon-items
      .icon-items__item(v-for="item in clothes")
        .icon-items__item-value {{ item.value }} М.
        img(:src="require(`../../assets/images/items/${item.icon}`)")
</template>

<script>
export default {
  name: 'KitsModded',
  data() {
    return {
      guns: [
        {
          icon: '1.png',
          value: 30,
        },
        {
          icon: '2.png',
          value: 30,
        },
        {
          icon: '3.png',
          value: 30,
        },
        {
          icon: '4.png',
          value: 30,
        },
        {
          icon: '5.png',
          value: 30,
        },
        {
          icon: '6.png',
          value: 30,
        },
        {
          icon: '7.png',
          value: 30,
        },
      ],

      clothes: [
        {
          icon: '1.png',
          value: 30,
        },
        {
          icon: '2.png',
          value: 30,
        },
        {
          icon: '3.png',
          value: 30,
        },
        {
          icon: '4.png',
          value: 30,
        },
        {
          icon: '5.png',
          value: 30,
        },
        {
          icon: '6.png',
          value: 30,
        },
        {
          icon: '7.png',
          value: 30,
        },
      ]
    }
  }
}
</script>

<style scoped lang="stylus">

</style>
