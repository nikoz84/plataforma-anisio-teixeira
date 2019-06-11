<template>
  <div class="icon-bar afix" data-spy="affix" data-offset-bottom="50%">    
    <a @click.prevent="openSidebar()" 
      class="">
        <i class="glyphicon glyphicon-search"></i>
    </a>
    <a @click="backToTop" 
      class="">
        <i class="glyphicon glyphicon-home"></i>
    </a>
  </div>
  
</template>
<script>
export default {
  name: "OpenSideBar",
  methods: {
    openSidebar() {
      document.getElementById("sidebar-home").style.width = "100%";
    },
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
};
</script>
<style lang="scss" scoped>
.icon-bar {
  width: 42px;
  background-color: #010e1b;
  background-color: rgba(1, 14, 27, 0.7);
  opacity: 0.8;
  z-index: 200 !important;
}

.icon-bar a {
  display: block;
  text-align: center;
  cursor: pointer;
  padding: 5px;
  transition: all 0.3s ease;
  color: white;
  font-size: 20px;
  .glyphicon {
    color: white;
    font-size: 20px;
  }
}

.icon-bar a:hover {
  background-color: #2196f3;
}

.affix {
  top: 14vh;
  right: 10px;
}
</style>