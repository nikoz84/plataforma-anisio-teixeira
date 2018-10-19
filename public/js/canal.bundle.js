webpackJsonp([1],{

/***/ 117:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(118);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(3)("3d9066f0", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-4931cae4\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../node_modules/sass-loader/lib/loader.js?indentedSyntax!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Canal.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-4931cae4\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../node_modules/sass-loader/lib/loader.js?indentedSyntax!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Canal.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 118:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(2)(false);
// imports


// module
exports.push([module.i, "", ""]);

// exports


/***/ }),

/***/ 119:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//


/* harmony default export */ __webpack_exports__["default"] = ({
    name: 'canal',
    data: function data() {
        return {
            title: null,
            descricao: null,
            idCanal: null,
            metaData: null
        };
    },
    created: function created() {},
    mounted: function mounted() {
        this.getCanal();
    },

    watch: {
        '$route': function $route(to, from) {
            this.getCanal();
        }
    },
    methods: {
        getCanal: function getCanal() {
            var _this = this;

            axios.get('/api-v1/canais/slug/' + this.$route.params.slug).then(function (resp) {
                _this.idCanal = resp.data.canal.id;
                _this.title = resp.data.canal.name;
                localStorage.setItem('idCanal', _this.idCanal);
                //this.descricao = resp.data.canal.description;
                //this.pagina = this.$route.name;
                //this.metaData = JSON.parse(resp.data.canal.options);
                //console.log(resp.data.canal)
            });
        }
    }
});

/***/ }),

/***/ 120:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", { staticClass: "row" }, [
    _c("aside", { staticClass: "col-sm-3" }, [
      _vm._v("\n        sidebar\n    ")
    ]),
    _vm._v(" "),
    _c(
      "article",
      { staticClass: "col-sm-9" },
      [
        _c("header", { staticClass: "page-header" }, [
          _c("h1", [_c("small", [_vm._v(_vm._s(_vm.title))])]),
          _vm._v(" "),
          _c(
            "nav",
            [
              _c(
                "router-link",
                {
                  attrs: {
                    to: {
                      name: "Inicio",
                      params: { slug: _vm.$route.params.slug }
                    }
                  }
                },
                [_vm._v("Home")]
              ),
              _vm._v(" |\n                "),
              _c(
                "router-link",
                {
                  attrs: {
                    to: {
                      name: "Listar",
                      params: { slug: _vm.$route.params.slug }
                    }
                  }
                },
                [_vm._v("Programas")]
              ),
              _vm._v(" |\n                "),
              _c(
                "router-link",
                {
                  attrs: {
                    to: {
                      name: "Sobre",
                      params: { slug: _vm.$route.params.slug }
                    }
                  }
                },
                [_vm._v("Sobre")]
              )
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c("router-view", { attrs: { id: _vm.idCanal } })
      ],
      1
    )
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-4931cae4", module.exports)
  }
}

/***/ }),

/***/ 95:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(117)
}
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(119)
/* template */
var __vue_template__ = __webpack_require__(120)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-4931cae4"
/* moduleIdentifier (server only) */
var __vue_module_identifier__ = null
var Component = normalizeComponent(
  __vue_script__,
  __vue_template__,
  __vue_template_functional__,
  __vue_styles__,
  __vue_scopeId__,
  __vue_module_identifier__
)
Component.options.__file = "resources/assets/js/pages/Canal.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-4931cae4", Component.options)
  } else {
    hotAPI.reload("data-v-4931cae4", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ })

});