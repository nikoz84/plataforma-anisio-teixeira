<template>
    <aside class="sidebar" id="sidebar-home">
      <div class="row">
          <span class="label label-primary btn-close" @click.prevent="closeSidebar()"><i class="glyphicon glyphicon-remove"></i> Fechar</span>
           
           <div class="input-group" style="padding-top:30px;">
              
              <span class="input-group-btn">
                  <button class="btn btn-default glyphicon glyphicon-search" type="button" ></button>
              </span>
              <input type="text" class="form-control" placeholder="Busca...">
          </div>
        </div>
    </aside>
</template>
<script>
export default {
    name: "SideBar",
    methods: {
      closeSidebar() {
        document.getElementById("sidebar-home").style.width = "0";
      }
    },
}
</script>
<style lang="scss" scoped>
.sidebar {
  height: 100%; /* 100% Full-height */
  width: 0; /* 0 width - change this with JavaScript */
  position: fixed; /* Stay in place */
  z-index: 900; /* Stay on top */
  top: 0;
  left: 0;
  background-color: rgb(255, 255, 255);
  
  overflow-x: hidden; /* Disable horizontal scroll */
  padding-top: 60px; /* Place content 60px from the top */
  transition: 0.5s; /* 0.5 second transition effect to slide in the sidenav */
}
.sidebar .row{
 margin-left: 15px;
 margin-right: 15px;
}
.sidebar a.link {
  //padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 16px;
  color: #1c7eb7;
  display: block;
  transition: 0.3s;
}

.sidebar a:hover {
  color: #2d5e9e;
}

/* Position and style the close button (top right corner) */
.sidebar .closebtn {
  position: absolute;
  bottom: 150px;
  right: 25px;
  font-size: 36px;
  margin-left: 50px;
  text-decoration: none;
}

.btn-close{
  cursor: pointer;
  float: right;
}
</style>

