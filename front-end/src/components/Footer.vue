<template lang="pug">
  .footer(:class="{ main: isMain }")
    .footer__content
      p &copy 2020. RUSTAFF. Все права защищены. Design by 
        a(href="https://vk.com/cardinal.studio", target="_blank") Cardinal Studio
      .footer__links
        a(v-for="(link, index) in links", :key="index", :href="link.href", target="_blank")
          svg
            use(:xlink:href="require(`../assets/images/profile-icons.svg`) + `#${link.icon}`")
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
          href: 'https://vk.com/rustaffnet',
          icon: 'vk'
        },
        {
          href: 'https://discord.gg/KfujFg5yDm',
          icon: 'discord'
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

      a
        color #79859E
        transition-duration .25s

        &:hover
          color #E93737
          transition-duration .25s

  &__links
    a
      margin-left 36px

      &:hover svg
        fill #E93737
        transition-duration .25s

      svg
        width 24px
        height 24px
        fill #5B6780
        transition-duration .25s

      &:first-child
        margin 0

@media screen and (max-width: 500px)
  .footer
    p
      font-size 12px
      
    &__links
      a
        margin-left 20px

        img
          width 18px
</style>
