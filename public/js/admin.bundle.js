webpackJsonp([0],{

/***/ 109:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(116)
}
var normalizeComponent = __webpack_require__(2)
/* script */
var __vue_script__ = __webpack_require__(118)
/* template */
var __vue_template__ = __webpack_require__(129)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-7943083c"
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
Component.options.__file = "resources/assets/js/pages/Admin.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-7943083c", Component.options)
  } else {
    hotAPI.reload("data-v-7943083c", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 116:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(117);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(3)("4c6eebf4", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-7943083c\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../node_modules/sass-loader/lib/loader.js!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Admin.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-7943083c\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../node_modules/sass-loader/lib/loader.js!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./Admin.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 117:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(1)(false);
// imports


// module
exports.push([module.i, "\n.page-header > h1[data-v-7943083c] {\n  margin-top: 0px;\n}\n", ""]);

// exports


/***/ }),

/***/ 118:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__components_SidebarComponent_vue__ = __webpack_require__(119);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__components_SidebarComponent_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__components_SidebarComponent_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__components_SearchComponent_vue__ = __webpack_require__(124);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__components_SearchComponent_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__components_SearchComponent_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__components_ListComponent_vue__ = __webpack_require__(16);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__components_ListComponent_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__components_ListComponent_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__components_PaginatorComponent_vue__ = __webpack_require__(17);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__components_PaginatorComponent_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_3__components_PaginatorComponent_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_4__store_js__ = __webpack_require__(8);
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
    name: 'admin',
    components: {
        Sidebar: __WEBPACK_IMPORTED_MODULE_0__components_SidebarComponent_vue___default.a, Search: __WEBPACK_IMPORTED_MODULE_1__components_SearchComponent_vue___default.a, List: __WEBPACK_IMPORTED_MODULE_2__components_ListComponent_vue___default.a, Paginator: __WEBPACK_IMPORTED_MODULE_3__components_PaginatorComponent_vue___default.a
    },
    data: function data() {
        return {
            title: '',
            paginator: {},
            search: '',
            show: false
        };
    },

    methods: {}
});

/***/ }),

/***/ 119:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(120)
}
var normalizeComponent = __webpack_require__(2)
/* script */
var __vue_script__ = __webpack_require__(122)
/* template */
var __vue_template__ = __webpack_require__(123)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-1d893ab8"
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
Component.options.__file = "resources/assets/js/components/SidebarComponent.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-1d893ab8", Component.options)
  } else {
    hotAPI.reload("data-v-1d893ab8", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 120:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(121);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(3)("1443cc7c", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-1d893ab8\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../node_modules/sass-loader/lib/loader.js?indentedSyntax!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./SidebarComponent.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-1d893ab8\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../node_modules/sass-loader/lib/loader.js?indentedSyntax!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./SidebarComponent.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 121:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(1)(false);
// imports


// module
exports.push([module.i, "\n.w-150[data-v-1d893ab8] {\n  width: 150px;\n}\n", ""]);

// exports


/***/ }),

/***/ 122:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator__ = __webpack_require__(4);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__http_js__ = __webpack_require__(5);


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



/* harmony default export */ __webpack_exports__["default"] = ({
    name: 'Sidebar',
    data: function data() {
        return {
            username: localStorage.getItem('username'),
            userId: localStorage.getItem('idUser')
        };
    },

    methods: {
        get: function () {
            var _ref = _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator___default.a.mark(function _callee(endpoint) {
                var http, params, resp;
                return __WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
                    while (1) {
                        switch (_context.prev = _context.next) {
                            case 0:
                                this.$parent.show = false;
                                http = new __WEBPACK_IMPORTED_MODULE_1__http_js__["a" /* default */]();
                                params = { token: localStorage.token };
                                _context.next = 5;
                                return http.getDataWithTokenUrl('/' + endpoint, params);

                            case 5:
                                resp = _context.sent;


                                if (resp.data.success) {
                                    this.$parent.paginator = resp.data.paginator;
                                    this.$parent.title = resp.data.title;
                                    this.$parent.search = endpoint;
                                    this.$parent.show = true;
                                }

                            case 7:
                            case 'end':
                                return _context.stop();
                        }
                    }
                }, _callee, this);
            }));

            function get(_x) {
                return _ref.apply(this, arguments);
            }

            return get;
        }()
    }
});

/***/ }),

/***/ 123:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("nav", { staticClass: "list-group" }, [
    _c("a", { staticClass: "thumbnail", attrs: { href: "#" } }, [
      _c("img", {
        staticClass: "w-150",
        attrs: {
          src: "https://via.placeholder.com/300x200",
          alt: "Foto Usuário"
        }
      })
    ]),
    _vm._v(" "),
    _c("p", [_vm._v(_vm._s("Benvindo " + _vm.username))]),
    _vm._v(" "),
    _c(
      "a",
      {
        staticClass: "list-group-item pointer",
        on: {
          click: function($event) {
            _vm.get("canais")
          }
        }
      },
      [_vm._v("Canais")]
    ),
    _vm._v(" "),
    _c(
      "a",
      {
        staticClass: "list-group-item pointer",
        on: {
          click: function($event) {
            _vm.get("users")
          }
        }
      },
      [_vm._v("Usuários")]
    ),
    _vm._v(" "),
    _c(
      "a",
      {
        staticClass: "list-group-item pointer",
        on: {
          click: function($event) {
            _vm.get("conteudos")
          }
        }
      },
      [_vm._v("Mídias Educacionais")]
    ),
    _vm._v(" "),
    _c(
      "a",
      {
        staticClass: "list-group-item pointer",
        on: {
          click: function($event) {
            _vm.get("aplicativos")
          }
        }
      },
      [_vm._v("Aplicativos Educacionais")]
    ),
    _vm._v(" "),
    _c(
      "a",
      {
        staticClass: "list-group-item pointer",
        on: {
          click: function($event) {
            _vm.get("tags")
          }
        }
      },
      [_vm._v("Tags")]
    ),
    _vm._v(" "),
    _c(
      "a",
      {
        staticClass: "list-group-item pointer",
        on: {
          click: function($event) {
            _vm.get("licencas")
          }
        }
      },
      [_vm._v("Licenças")]
    )
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-1d893ab8", module.exports)
  }
}

/***/ }),

/***/ 124:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(125)
}
var normalizeComponent = __webpack_require__(2)
/* script */
var __vue_script__ = __webpack_require__(127)
/* template */
var __vue_template__ = __webpack_require__(128)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-6406c664"
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
Component.options.__file = "resources/assets/js/components/SearchComponent.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-6406c664", Component.options)
  } else {
    hotAPI.reload("data-v-6406c664", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 125:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(126);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(3)("3bb5a10d", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-6406c664\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../node_modules/sass-loader/lib/loader.js?indentedSyntax!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./SearchComponent.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-6406c664\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../node_modules/sass-loader/lib/loader.js?indentedSyntax!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./SearchComponent.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 126:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(1)(false);
// imports


// module
exports.push([module.i, "", ""]);

// exports


/***/ }),

/***/ 127:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator__ = __webpack_require__(4);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__http_js__ = __webpack_require__(5);


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



/* harmony default export */ __webpack_exports__["default"] = ({
    name: 'Search',
    data: function data() {
        return {
            placeholder: 'Pesquise de conteúdos',
            termo: ''
        };
    },

    methods: {
        onSearch: function () {
            var _ref = _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator___default.a.mark(function _callee() {
                var url, http, params, resp;
                return __WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
                    while (1) {
                        switch (_context.prev = _context.next) {
                            case 0:
                                url = '/' + this.$parent.search + '/search/' + this.termo;

                                this.$parent.show = false;
                                http = new __WEBPACK_IMPORTED_MODULE_1__http_js__["a" /* default */]();
                                params = { token: localStorage.token };
                                _context.next = 6;
                                return http.getDataFromUrl(url, params);

                            case 6:
                                resp = _context.sent;


                                if (resp.data) {
                                    this.$parent.paginator = resp.data.paginator;
                                    this.$parent.show = true;
                                }

                            case 8:
                            case 'end':
                                return _context.stop();
                        }
                    }
                }, _callee, this);
            }));

            function onSearch() {
                return _ref.apply(this, arguments);
            }

            return onSearch;
        }()
    }
});

/***/ }),

/***/ 128:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "form",
    {
      staticClass: "search",
      on: {
        submit: function($event) {
          $event.preventDefault()
          _vm.onSearch()
        }
      }
    },
    [
      _c("div", { staticClass: "input-group" }, [
        _c("input", {
          directives: [
            {
              name: "model",
              rawName: "v-model",
              value: _vm.termo,
              expression: "termo"
            }
          ],
          staticClass: "form-control",
          attrs: { type: "text", placeholder: _vm.placeholder },
          domProps: { value: _vm.termo },
          on: {
            input: function($event) {
              if ($event.target.composing) {
                return
              }
              _vm.termo = $event.target.value
            }
          }
        }),
        _vm._v(" "),
        _vm._m(0)
      ])
    ]
  )
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c("span", { staticClass: "input-group-btn" }, [
      _c(
        "button",
        { staticClass: "btn btn-default", attrs: { type: "submit" } },
        [_vm._v("Pesquisa")]
      )
    ])
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-6406c664", module.exports)
  }
}

/***/ }),

/***/ 129:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "container-fluid heigth" },
    [
      _c("Sidebar", { staticClass: "col-sm-3" }),
      _vm._v(" "),
      _c(
        "section",
        { staticClass: "col-sm-9" },
        [
          _c("Search", { attrs: { search: _vm.search } }),
          _vm._v(" "),
          _c("header", { staticClass: "page-header" }, [
            _c("h1", [_c("small", [_vm._v(_vm._s(_vm.title))])])
          ]),
          _vm._v(" "),
          _c(
            "transition",
            {
              attrs: {
                name: "custom-classes-transition",
                "enter-active-class": "animated fadeInUp",
                "leave-active-class": "animated bounceOut",
                mode: "out-in"
              }
            },
            [
              _vm.show
                ? _c(
                    "div",
                    [
                      _c("List", { attrs: { items: _vm.paginator.data } }),
                      _vm._v(" "),
                      _c("Paginator", { attrs: { paginator: _vm.paginator } })
                    ],
                    1
                  )
                : _vm._e()
            ]
          )
        ],
        1
      )
    ],
    1
  )
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-7943083c", module.exports)
  }
}

/***/ })

});