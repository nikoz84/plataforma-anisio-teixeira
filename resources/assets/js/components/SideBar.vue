<template>
    <aside class="sidebar" id="sidebar-home">
      <div class="row">
          <div class="col-sm-12">
            <a class="btn btn-circle btn-close" 
            @click.prevent="closeSidebar()">
            <i class="glyphicon glyphicon-remove"></i> 
            Fechar
            </a>
          </div>
          <div class="col-sm-12">
            <form class="search">
              <input type="text" placeholder="Pesquise.." name="search">
              <button type="submit">
                <i class="glyphicon glyphicon-search"></i>
              </button>
            </form>
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
  }
};
</script>
<style lang="scss" scoped>
.sidebar {
  height: 100%; /* 100% Full-height */
  width: 0; /* 0 width - change this with JavaScript */
  position: fixed; /* Stay in place */
  z-index: 1500; /* Stay on top */
  top: 0;
  left: 0;
  background-color: rgb(255, 255, 255);

  overflow-x: hidden; /* Disable horizontal scroll */
  padding-top: 60px; /* Place content 60px from the top */
  transition: 0.5s; /* 0.5 second transition effect to slide in the sidenav */
}
.sidebar .row {
  margin-left: 15px;
  margin-right: 15px;
}
.sidebar a.link {
  //padding: 8px 8px 8px 32px;
  text-decoration: none;
  font-size: 16px;
  color: #fcfcfc;
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
  width: 45px;
  height: 45px;
}

.btn-close {
  float: right;
  background-color: rgba(236, 241, 243, 0.7);
  margin-bottom: 20px;
}

/* Style the search field */
form.search input[type="text"] {
  padding: 10px;
  font-size: 17px;
  border: 1px solid grey;
  float: left;
  width: 80%;
  background: #f1f1f1;
}

/* Style the submit button */
form.search button {
  float: left;
  width: 20%;
  padding: 10px;
  background: #2196f3;
  color: white;
  font-size: 17px;
  border: 1px solid grey;
  border-left: none; /* Prevent double borders */
  cursor: pointer;
}

form.search button:hover {
  background: #0b7dda;
}

/* Clear floats */
form.search::after {
  content: "";
  clear: both;
  display: table;
}
</style>

