<template>
    <button class="goTop" v-if="isVisible" @click="backToTop">
        <i class="glyphicon glyphicon-menu-up" aria-hidden="true"></i>
    </button>
</template>
<script>
export default {
    name: "BackToTop",
    data(){
        return {
            isVisible: false
        }
    },
    methods: {
        initToTopButton: function() {
            $(document).bind('scroll', function() {
                var backToTopButton = $('.goTop');
                if ($(document).scrollTop() > 250) {
                    backToTopButton.addClass('isVisible');
                    this.isVisible = true;
                } else {
                    backToTopButton.removeClass('isVisible');
                    this.isVisible = false;
                }
            }.bind(this));
        },
        backToTop: function() {
            $('html,body').stop().animate({
                scrollTop: 0
            }, 'slow', 'swing');
        }
  },
  mounted: function() {
    this.$nextTick(function() {
      this.initToTopButton();
    });
  }
}
</script>
<style lang="scss" scoped>
.goTop {
  border-radius: 2px;
  background-color: rgb(1,14,27);
  background-color: rgba(1, 14, 27, .7);
  position: fixed;
  width: 45px;
  height: 45px;
  display: block;
  right: 10px;
  bottom: 10px;
  border: none;
  opacity: 0;
  z-index: -1;
  .glyphicon {
    color: white;
    font-size: 20px;
  }
  &:hover {
    opacity: 1;
    background-color: rgb(1,14,27);
    background-color: rgba(1, 14, 27, .9);
  }
}

.isVisible {
  opacity: .8;
  z-index: 4;
  transition: all .4s ease-in;
}
</style>