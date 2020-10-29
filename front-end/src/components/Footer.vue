<template lang="pug">
  .footer(:class="{ main: isMain }")
    .footer__content
      p &copy 2020. RUSTAFF. Все права защищены.
      .footer__links
        a(v-for="(link, index) in links", :key="index", :href="link.href")
          img(:src="require(`../assets/images/${link.icon}`)")
</template>

<script>
export default {
  name: 'Footer',
  props: {
    isMain: {
      default: false
    }
  },
  data() {
    return {
      links: [
        {
          href: '',
          icon: 'youtube.svg'
        },
        {
          href: '',
          icon: 'vk.svg'
        },
        {
          href: '',
          icon: 'discord.svg'
        }
      ]
    }
  }
}
</script>

<style scoped lang="stylus">
.footer
  width 100%
  height 86px
  display flex
  justify-content center
  align-items center
  background #12121A

  &.main
    position absolute
    bottom 0
    left 0
    background transparent

  &__content
    width 1170px
    display flex
    justify-content space-between
    align-items center

    p
      color #79859E
      font-size 14px
      font-weight 500
      letter-spacing 0.02em

  &__links
    a
      margin-left 36px

      &:first-child
        margin 0
</style>
