<template>
  <div id="app">
    <notifications group="main" class="main-notify" animation-type="velocity" width="350px" position="bottom right"/>
    <router-view/>
  </div>
</template>

<style lang="stylus">
*
  margin 0
  padding 0
  border 0
  outline none

body
  color white
  font-size 10px
  font-family 'Manrope', sans-serif
  background #171925
  overflow-x hidden

a
  text-decoration none

.main-notify
  z-index 99999 !important
  margin 20px

  .notification-title
    font-size 16px !important

  .notification-content
    font-size 14px !important

.content
  width 1170px

  &-container
    display flex
    justify-content center

  &-data
    p
      font-size 16px
      font-weight 500
      color #5B6780
      margin-top 50px

      span.subtitle
        color #E2E2E2

        b
          font-family 'Russo One', sans-serif
          font-weight normal

      span.bold
        color #E93737
        font-family 'Russo One', sans-serif

  &__title
    text-align center
    font-size 24px
    letter-spacing 0.02em
    text-shadow 0px 2px 2px rgba(0, 0, 0, 0.15)
    color #E2E2E2
    text-transform uppercase
    font-family 'Russo One', sans-serif
    margin 50px 0

    h1
      font-size 24px
      font-weight normal
      line-height 100%

    span
      color #E93737

  &__subtitle
    text-align center
    color #E2E2E2
    font-family 'Russo One', sans-serif
    margin 50px 0

    h2
      font-size 18px
      font-weight normal
      line-height 100%

.table
  background #1C2030
  border-radius 5px

  &__row
    display grid
    padding 25px
    color #808FAC
    font-size 14px
    font-weight 500
    position relative
    justify-content center

    &:last-child::after
      display none
    
    &::after
      content ''
      position absolute
      bottom 0
      left 25px
      width calc(100% - 50px)
      height 1px
      background #222635

    &.head
      background #222635
      grid-template-rows 57px
      color #6C768D
      border-radius 5px
      padding 0 25px

      .table__col:nth-child(2n+1)
        color #6C768D

  &__col
    display flex
    align-items center
    justify-content center

    &:nth-child(2n+1)
      color #E2E2E2

    &.flex-start
      justify-content flex-start

.search
  display grid
  grid-template-columns 1fr repeat(2, 14.5%)
  grid-template-rows 50px
  grid-gap 30px
  margin-top 30px

  &-input
    background #1C2030
    border-radius 5px
    padding 13px 15px
    display flex
    align-items center
    justify-content space-between

    img
      cursor pointer

    input
      width calc(100% - 44px)
      height 100%
      background transparent
      font-size 14px
      font-weight 500
      color #626A8B

      &::placeholder
        color rgba(98, 106, 139, 0.5)

  &-button
    color white
    font-size 14px
    font-weight 500
    border-radius 5px
    background #5C8DD7
    cursor pointer

    &.go
      background #45A35A

.icon
  &-items
    display grid
    grid-template-columns repeat(auto-fill, 120px)
    grid-gap 20px

    &__item
      height 120px
      display flex
      justify-content center
      align-items center
      position relative
      background-image url('./assets/images/items/bg.svg')
      background-cover #1C2030
      background-size cover
      border-radius 5px
      overflow hidden
      user-select none
      box-shadow 0px 5px 5px rgba(0, 0, 0, 0.15)

      img
        filter drop-shadow(0px 8px 4px rgba(0, 0, 0, 0.15))

      &-value
        position absolute
        left 0
        top 0
        background #5C8DD7
        border-radius 5px 0 5px 0
        width 70px
        height 23px
        text-align center
        line-height 23px
        text-transform uppercase
        text-shadow 0px 2px 2px rgba(0, 0, 0, 0.15)

.tabs
  display flex
  justify-content space-evenly
  flex-wrap wrap
  margin-top -10px

  &__item
    background #232937
    border-radius 5px
    height 40px
    width 170px
    text-align center
    line-height 40px
    color #6C768D
    font-size 14px
    font-weight 600
    margin-top 10px
    cursor pointer
    transition-duration .25s

    &:hover, &.active
      background #5C8DD7
      color #E2E2E2
      transition-duration .25s

.modal
  width 100vw
  height 100vh
  position fixed
  left 0
  top 0
  background alpha(black, 0.5)
  z-index 9999
  display flex
  justify-content center
  align-items center

  &--buttons
    display flex
    justify-content flex-end
    margin-top 25px

  &-container
    width 350px
    padding 30px
    border-radius 5px
    background #232937

    select
      cursor pointer
      color #555e75 !important
      padding 0 10px !important

    input, select
      background #1C2030
      border-radius 5px
      height 30px
      width 100%
      padding 0 15px
      box-sizing border-box
      color white
      margin-top 20px

      &::placeholder
        color #555e75

    button
      background #5C8DD7
      color #E2E2E2
      cursor pointer
      height 35px
      border-radius 5px
      padding 0 20px
      font-weight bold
      font-size 13px
      margin-left 10px

      &.close
        background #d75c6d

@media screen and (max-width: 1250px)
  .content, .footer__content
    width 100%
    box-sizing border-box
    padding 0 30px

  .header__content--menu
    left 30px !important

  .header__content--profile
    right 30px !important

  .home
    &__data 
      &--text
        p, p span
          font-size 2.5vw !important

      img.target
        width 90vw

      .alive
        font-size 5vw !important
        padding 0 5vw !important
        height 8vw !important
        line-height 8vw !important
  
      &--button, img.target
        margin-top 5vw !important

@media screen and (max-width: 800px)
  .stats-card
    width 100% !important

    &__cols
      grid-template-columns 1fr !important

@media screen and (max-width: 650px)
  .header__content--logo
    display none !important

  .search
    grid-template-columns 1fr !important

    &-button
      height 50px

  .profile__nav .content
    display flex
    overflow auto

  .profile__header-stats
    p
      display none

@media screen and (max-width: 590px)
  .header__overlay-content li
    font-size 25px !important


.fade-enter-active, .fade-leave-active
  transition opacity .5s
.fade-enter, .fade-leave-to
  opacity 0
</style>
