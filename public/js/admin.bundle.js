webpackJsonp([0],{

/***/ 157:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(164)
}
var normalizeComponent = __webpack_require__(0)
/* script */
var __vue_script__ = __webpack_require__(166)
/* template */
var __vue_template__ = __webpack_require__(177)
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

/***/ 164:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(165);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(2)("4c6eebf4", content, false, {});
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

/***/ 165:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(1)(false);
// imports


// module
exports.push([module.i, "\n.page-header > h1[data-v-7943083c] {\n  margin-top: 0px;\n}\n", ""]);

// exports


/***/ }),

/***/ 166:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__components_SidebarComponent_vue__ = __webpack_require__(167);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__components_SidebarComponent_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0__components_SidebarComponent_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__forms_SearchForm_vue__ = __webpack_require__(172);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__forms_SearchForm_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__forms_SearchForm_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__components_ListComponent_vue__ = __webpack_require__(20);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__components_ListComponent_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__components_ListComponent_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__store_index_js__ = __webpack_require__(7);
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
        Sidebar: __WEBPACK_IMPORTED_MODULE_0__components_SidebarComponent_vue___default.a, SearchForm: __WEBPACK_IMPORTED_MODULE_1__forms_SearchForm_vue___default.a, List: __WEBPACK_IMPORTED_MODULE_2__components_ListComponent_vue___default.a
    },
    data: function data() {
        return {
            title: '',
            search: '',
            show: false,
            paginator: {}
        };
    },
    beforeCreate: function beforeCreate() {
        if (!__WEBPACK_IMPORTED_MODULE_3__store_index_js__["a" /* default */].state.isLogged) {
            this.$router.go('/usuario/login');
        }
    },

    methods: {}
});

/***/ }),

/***/ 167:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(168)
}
var normalizeComponent = __webpack_require__(0)
/* script */
var __vue_script__ = __webpack_require__(170)
/* template */
var __vue_template__ = __webpack_require__(171)
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

/***/ 168:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(169);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(2)("1443cc7c", content, false, {});
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

/***/ 169:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(1)(false);
// imports


// module
exports.push([module.i, "\n.w-150[data-v-1d893ab8] {\n  width: 150px;\n}\n", ""]);

// exports


/***/ }),

/***/ 170:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__http_js__ = __webpack_require__(4);


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

/***/ 171:
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
            _vm.get("licenses")
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

/***/ 172:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(173)
}
var normalizeComponent = __webpack_require__(0)
/* script */
var __vue_script__ = __webpack_require__(175)
/* template */
var __vue_template__ = __webpack_require__(176)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-64832ebe"
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
Component.options.__file = "resources/assets/js/forms/SearchForm.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-64832ebe", Component.options)
  } else {
    hotAPI.reload("data-v-64832ebe", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 173:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(174);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(2)("1b0f6b80", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-64832ebe\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../node_modules/sass-loader/lib/loader.js?indentedSyntax!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./SearchForm.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-64832ebe\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../node_modules/sass-loader/lib/loader.js?indentedSyntax!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./SearchForm.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 174:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(1)(false);
// imports


// module
exports.push([module.i, "", ""]);

// exports


/***/ }),

/***/ 175:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator__ = __webpack_require__(3);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__http_js__ = __webpack_require__(4);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_lodash_debounce__ = __webpack_require__(21);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2_lodash_debounce___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2_lodash_debounce__);


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



var http = new __WEBPACK_IMPORTED_MODULE_1__http_js__["a" /* default */]();

/* harmony default export */ __webpack_exports__["default"] = ({
    name: 'SearchForm',
    props: ['search'],
    data: function data() {
        return {
            placeholder: 'Pesquise...',
            termo: ''
        };
    },
    created: function created() {
        this.delayFunction = __WEBPACK_IMPORTED_MODULE_2_lodash_debounce___default()(this.onSearch, 500);
    },

    watch: {
        termo: function termo(novo, antigo) {
            this.placeholder = 'Esperando...';
            this.delayFunction();
        }
    },
    methods: {
        onSearch: function () {
            var _ref = _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator___default.a.mark(function _callee() {
                var url, params, resp;
                return __WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
                    while (1) {
                        switch (_context.prev = _context.next) {
                            case 0:
                                if (this.termo) {
                                    _context.next = 2;
                                    break;
                                }

                                return _context.abrupt('return');

                            case 2:
                                url = '/' + this.search + '/search/' + this.termo;

                                this.$parent.show = false;

                                params = { token: localStorage.token };
                                _context.next = 7;
                                return http.getDataFromUrl(url, params);

                            case 7:
                                resp = _context.sent;


                                if (resp.data) {
                                    this.$parent.paginator = resp.data.paginator;
                                    this.$parent.show = true;
                                }

                            case 9:
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

/***/ 176:
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
          attrs: { type: "text", id: "termo", placeholder: _vm.placeholder },
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
    require("vue-hot-reload-api")      .rerender("data-v-64832ebe", module.exports)
  }
}

/***/ }),

/***/ 177:
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
          _c("SearchForm", { attrs: { search: _vm.search } }),
          _vm._v(" "),
          _c("header", { staticClass: "page-header" }, [
            _c("h1", [_c("small", [_vm._v(_vm._s(_vm.title))])])
          ]),
          _vm._v(" "),
          _vm.show
            ? _c("div", [
                _vm._v(
                  "\n                " +
                    _vm._s(_vm.paginator.data) +
                    "\n            "
                )
              ])
            : _vm._e()
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