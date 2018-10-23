webpackJsonp([2],{

/***/ 103:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(124)
}
var normalizeComponent = __webpack_require__(2)
/* script */
var __vue_script__ = __webpack_require__(126)
/* template */
var __vue_template__ = __webpack_require__(127)
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


/***/ }),

/***/ 124:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(125);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(3)("768bec6d", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-4931cae4\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../node_modules/sass-loader/lib/loader.js!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Canal.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-4931cae4\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../node_modules/sass-loader/lib/loader.js!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Canal.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 125:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(1)(false);
// imports


// module
exports.push([module.i, "\n.page-header[data-v-4931cae4] {\n  margin-top: 0px;\n}\n.page-header > h1[data-v-4931cae4] {\n  margin-top: 0px;\n}\n.fade-enter[data-v-4931cae4] {\n  opacity: 0;\n}\n.fade-enter-active[data-v-4931cae4] {\n  -webkit-transition: opacity 1s ease;\n  transition: opacity 1s ease;\n}\n.fade-leave-active[data-v-4931cae4] {\n  -webkit-transition: opacity 1s ease;\n  transition: opacity 1s ease;\n  opacity: 0;\n}\n", ""]);

// exports


/***/ }),

/***/ 126:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator__ = __webpack_require__(136);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__http_js__ = __webpack_require__(135);


function _asyncToGenerator(fn) { return function () { var gen = fn.apply(this, arguments); return new Promise(function (resolve, reject) { function step(key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { return Promise.resolve(value).then(function (value) { step("next", value); }, function (err) { step("throw", err); }); } } return step("next"); }); }; }

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
        getCanal: function () {
            var _ref = _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator___default.a.mark(function _callee() {
                var url, canal, resp;
                return __WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
                    while (1) {
                        switch (_context.prev = _context.next) {
                            case 0:
                                url = '/canais/slug/' + this.$route.params.slug;
                                canal = new __WEBPACK_IMPORTED_MODULE_1__http_js__["a" /* default */]();
                                _context.next = 4;
                                return canal.getDataFromUrl(url);

                            case 4:
                                resp = _context.sent;


                                this.idCanal = resp.data.canal.id;
                                this.title = resp.data.canal.name;
                                localStorage.setItem('idCanal', this.idCanal);

                            case 8:
                            case 'end':
                                return _context.stop();
                        }
                    }
                }, _callee, this);
            }));

            function getCanal() {
                return _ref.apply(this, arguments);
            }

            return getCanal;
        }()
    }
});

/***/ }),

/***/ 127:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("section", { staticClass: "container-fluid heigth" }, [
    _c("div", { staticClass: "row" }, [
      _vm._m(0),
      _vm._v(" "),
      _c("article", { staticClass: "col-sm-9" }, [
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
                [_c("a", [_vm._v("Home")])]
              ),
              _vm._v(" |\n                    "),
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
                [_c("a", [_vm._v("Listar")])]
              ),
              _vm._v(" |\n                    "),
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
                [_c("a", [_vm._v("Sobre")])]
              )
            ],
            1
          )
        ]),
        _vm._v(" "),
        _c(
          "section",
          [
            _c(
              "transition",
              { attrs: { name: "fade", mode: "out-in" } },
              [_c("router-view")],
              1
            )
          ],
          1
        )
      ])
    ])
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("aside", { staticClass: "col-sm-3" }, [
      _c("header", [_vm._v("Categorias")]),
      _vm._v(" "),
      _c("ul", [
        _c("li", [_vm._v("categoria 1")]),
        _vm._v(" "),
        _c("li", [_vm._v("categoria 2")]),
        _vm._v(" "),
        _c("li", [_vm._v("categoria 3")]),
        _vm._v(" "),
        _c("li", [_vm._v("categoria 4")])
      ])
    ])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-4931cae4", module.exports)
  }
}

/***/ })

});