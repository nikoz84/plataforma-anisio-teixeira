webpackJsonp([1],{

/***/ 169:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(192)
}
var normalizeComponent = __webpack_require__(0)
/* script */
var __vue_script__ = __webpack_require__(194)
/* template */
var __vue_template__ = __webpack_require__(205)
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

/***/ 192:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(193);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(3)("bee04172", content, false, {});
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

/***/ 193:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(1)(false);
// imports


// module
exports.push([module.i, "\n.page-header[data-v-4931cae4] {\n  margin: 0;\n}\n.page-header .page-title[data-v-4931cae4] {\n  margin-top: 0;\n  position: relative;\n  margin-bottom: 30px;\n}\n.page-header .page-title[data-v-4931cae4]:after {\n  width: 15%;\n  height: 2px;\n  content: '';\n  background: var(--color);\n  display: block;\n  position: absolute;\n  bottom: -10px;\n}\n[data-v-4931cae4]:root {\n  --background: var(--color);\n}\naside > header > h3[data-v-4931cae4] {\n  margin-top: 5px;\n  font-size: 18px;\n}\n", ""]);

// exports


/***/ }),

/***/ 194:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator__ = __webpack_require__(2);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__components_NavCanalComponent_vue__ = __webpack_require__(195);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__components_NavCanalComponent_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_1__components_NavCanalComponent_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__components_SidebarCanalComponent_vue__ = __webpack_require__(200);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_2__components_SidebarCanalComponent_vue___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_2__components_SidebarCanalComponent_vue__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_3__http_js__ = __webpack_require__(4);


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





var http = new __WEBPACK_IMPORTED_MODULE_3__http_js__["a" /* default */]();

/* harmony default export */ __webpack_exports__["default"] = ({
    name: 'canal',
    components: { NavCanal: __WEBPACK_IMPORTED_MODULE_1__components_NavCanalComponent_vue___default.a, SidebarCanal: __WEBPACK_IMPORTED_MODULE_2__components_SidebarCanalComponent_vue___default.a },
    data: function data() {
        return {
            title: '',
            descricao: null,
            canal_id: null,
            options: null,
            color: '#1e78c2',
            hasCategories: false,
            categories: null,
            hasAbout: false,
            sidebar: null
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
                var url, resp;
                return __WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
                    while (1) {
                        switch (_context.prev = _context.next) {
                            case 0:
                                url = '/canais/slug/' + this.$route.params.slug;
                                _context.next = 3;
                                return http.getDataFromUrl(url);

                            case 3:
                                resp = _context.sent;


                                if (resp.data.success) {
                                    this.canal_id = resp.data.canal.id;
                                    this.title = resp.data.canal.name;
                                    this.options = resp.data.canal.options;
                                    this.color = this.options.color;
                                    this.hasAbout = this.options.has_about;
                                    this.hasCategories = this.options.has_categories;
                                    this.sidebar = resp.data.sidebar;
                                    localStorage.setItem('canal_id', this.canal_id);

                                    if (this.hasCategories) {
                                        this.getCategories();
                                    }
                                }

                            case 5:
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
        }(),
        getCategories: function () {
            var _ref2 = _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator___default.a.mark(function _callee2() {
                var params, resp;
                return __WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator___default.a.wrap(function _callee2$(_context2) {
                    while (1) {
                        switch (_context2.prev = _context2.next) {
                            case 0:
                                params = {
                                    canal: this.canal_id
                                };
                                _context2.next = 3;
                                return http.getDataFromUrl('/categories', params);

                            case 3:
                                resp = _context2.sent;

                                if (resp.data.success) {
                                    this.categories = resp.data.categories;
                                }

                            case 5:
                            case 'end':
                                return _context2.stop();
                        }
                    }
                }, _callee2, this);
            }));

            function getCategories() {
                return _ref2.apply(this, arguments);
            }

            return getCategories;
        }()
    }
});

/***/ }),

/***/ 195:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(196)
}
var normalizeComponent = __webpack_require__(0)
/* script */
var __vue_script__ = __webpack_require__(198)
/* template */
var __vue_template__ = __webpack_require__(199)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-69ec2f9e"
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
Component.options.__file = "resources/assets/js/components/NavCanalComponent.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-69ec2f9e", Component.options)
  } else {
    hotAPI.reload("data-v-69ec2f9e", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 196:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(197);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(3)("67e6eaac", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-69ec2f9e\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../node_modules/sass-loader/lib/loader.js!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./NavCanalComponent.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-69ec2f9e\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../node_modules/sass-loader/lib/loader.js!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./NavCanalComponent.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 197:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(1)(false);
// imports


// module
exports.push([module.i, "", ""]);

// exports


/***/ }),

/***/ 198:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__store_index_js__ = __webpack_require__(7);
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
    name: 'NavCanal',
    props: ['hasAbout'],
    data: function data() {
        return {
            isLogged: __WEBPACK_IMPORTED_MODULE_0__store_index_js__["a" /* default */].state.isLogged
        };
    },
    beforeCreate: function beforeCreate() {},

    computed: {
        showAdicionarConteudo: function showAdicionarConteudo() {
            if (this.isLogged && this.$route.params.slug != 'aplicativos-educacionais') {
                return this.isLogged;
            }
            return false;
        },
        showAdicionarAplicativo: function showAdicionarAplicativo() {
            if (this.isLogged && this.$route.params.slug == 'aplicativos-educacionais') {
                return this.isLogged;
            }
            return false;
        }
    },
    methods: {
        getUrl: function getUrl() {
            var url = encodeURI(location.href);
            this.$router.push({ name: 'DenunciaForm', params: { slug: this.$route.params.slug, url: url } });
        }
    }
});

/***/ }),

/***/ 199:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("nav", [
    _c(
      "ul",
      { staticClass: "nav nav-pills" },
      [
        _c(
          "router-link",
          {
            attrs: {
              tag: "li",
              to: { name: "Inicio", params: { slug: _vm.$route.params.slug } },
              exact: ""
            }
          },
          [_c("a", [_vm._v("Home")])]
        ),
        _vm._v(" "),
        _c(
          "router-link",
          {
            attrs: {
              tag: "li",
              to: { name: "Listar", params: { slug: _vm.$route.params.slug } }
            }
          },
          [_c("a", [_vm._v("Listar")])]
        ),
        _vm._v(" "),
        _vm.showAdicionarConteudo
          ? _c(
              "router-link",
              {
                attrs: {
                  tag: "li",
                  to: {
                    name: "AdicionarConteudo",
                    params: { slug: _vm.$route.params.slug }
                  }
                }
              },
              [_c("a", [_vm._v("Adicionar")])]
            )
          : _vm._e(),
        _vm._v(" "),
        _vm.showAdicionarAplicativo
          ? _c(
              "router-link",
              {
                attrs: {
                  tag: "li",
                  to: {
                    name: "AdicionarAplicativo",
                    params: { slug: _vm.$route.params.slug }
                  },
                  exact: ""
                }
              },
              [_c("a", [_vm._v("Adicionar")])]
            )
          : _vm._e(),
        _vm._v(" "),
        _c("li", [
          _c(
            "a",
            {
              on: {
                click: function($event) {
                  $event.preventDefault()
                  return _vm.getUrl($event)
                }
              }
            },
            [_vm._v("Denúnciar")]
          )
        ])
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
    require("vue-hot-reload-api")      .rerender("data-v-69ec2f9e", module.exports)
  }
}

/***/ }),

/***/ 200:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
function injectStyle (ssrContext) {
  if (disposed) return
  __webpack_require__(201)
}
var normalizeComponent = __webpack_require__(0)
/* script */
var __vue_script__ = __webpack_require__(203)
/* template */
var __vue_template__ = __webpack_require__(204)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = injectStyle
/* scopeId */
var __vue_scopeId__ = "data-v-92b465d2"
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
Component.options.__file = "resources/assets/js/components/SidebarCanalComponent.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-92b465d2", Component.options)
  } else {
    hotAPI.reload("data-v-92b465d2", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 201:
/***/ (function(module, exports, __webpack_require__) {

// style-loader: Adds some css to the DOM by adding a <style> tag

// load the styles
var content = __webpack_require__(202);
if(typeof content === 'string') content = [[module.i, content, '']];
if(content.locals) module.exports = content.locals;
// add the styles to the DOM
var update = __webpack_require__(3)("f1d1eaba", content, false, {});
// Hot Module Replacement
if(false) {
 // When the styles change, update the <style> tags
 if(!content.locals) {
   module.hot.accept("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-92b465d2\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../node_modules/sass-loader/lib/loader.js!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./SidebarCanalComponent.vue", function() {
     var newContent = require("!!../../../../node_modules/css-loader/index.js!../../../../node_modules/vue-loader/lib/style-compiler/index.js?{\"vue\":true,\"id\":\"data-v-92b465d2\",\"scoped\":true,\"hasInlineConfig\":true}!../../../../node_modules/sass-loader/lib/loader.js!../../../../node_modules/vue-loader/lib/selector.js?type=styles&index=0!./SidebarCanalComponent.vue");
     if(typeof newContent === 'string') newContent = [[module.id, newContent, '']];
     update(newContent);
   });
 }
 // When the module is disposed, remove the <style> tags
 module.hot.dispose(function() { update(); });
}

/***/ }),

/***/ 202:
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(1)(false);
// imports


// module
exports.push([module.i, "", ""]);

// exports


/***/ }),

/***/ 203:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0__http_js__ = __webpack_require__(4);
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



var http = new __WEBPACK_IMPORTED_MODULE_0__http_js__["a" /* default */]();

/* harmony default export */ __webpack_exports__["default"] = ({
    name: 'SidebarCanal',
    props: ['sidebar'],
    data: function data() {
        return {
            checkedTipos: [],
            checkedLicenses: [],
            checkedComponents: [],
            isVisible: false
        };
    },

    computed: {
        categoriesExists: function categoriesExists() {
            return this.sidebar && this.sidebar.categories ? true : false;
        },
        disciplinasExists: function disciplinasExists() {
            return this.sidebar && this.sidebar.disciplinas[0] ? true : false;
        },
        temasExists: function temasExists() {
            return this.sidebar && this.sidebar.temas[0] ? true : false;
        },
        tiposExists: function tiposExists() {
            return this.sidebar && this.sidebar.tipos ? true : false;
        },
        licensesExists: function licensesExists() {
            return this.sidebar && this.sidebar.licenses ? true : false;
        },
        componentsExists: function componentsExists() {
            return this.sidebar && this.sidebar.components ? true : false;
        },
        NiveisExists: function NiveisExists() {
            return this.sidebar && this.sidebar.niveis ? true : false;
        }
    },
    methods: {
        addToQuery: function addToQuery() {
            this.$router.push({ name: 'Listar',
                params: { slug: this.$route.params.slug },
                query: {
                    tipos: [this.checkedTipos],
                    licencas: [this.checkedLicenses],
                    componentes: [this.checkedComponents] }
            });
        }
    }

});

/***/ }),

/***/ 204:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("div", [
    _vm.categoriesExists
      ? _c("nav", { attrs: { role: "menu categorias" } }, [
          _c(
            "ul",
            { staticClass: "nav nav-pills nav-stacked" },
            [
              _c(
                "router-link",
                {
                  attrs: {
                    tag: "li",
                    to: {
                      name: "Listar",
                      params: { slug: _vm.$route.params.slug }
                    }
                  }
                },
                [_c("a", [_vm._v("Todos")])]
              ),
              _vm._v(" "),
              _vm._l(_vm.sidebar.categories, function(category, c) {
                return _c(
                  "li",
                  { key: c },
                  [
                    _c(
                      "router-link",
                      {
                        attrs: {
                          to: {
                            name: "Listar",
                            params: { slug: _vm.$route.params.slug },
                            query: { categoria: category.id }
                          },
                          exact: ""
                        }
                      },
                      [_c("a", [_vm._v(_vm._s(category.name))])]
                    ),
                    _vm._v(" "),
                    category.sub_categories &&
                    category.sub_categories.length > 0
                      ? _c(
                          "ul",
                          _vm._l(category.sub_categories, function(
                            subcategory,
                            s
                          ) {
                            return _c(
                              "li",
                              { key: s },
                              [
                                _c(
                                  "router-link",
                                  {
                                    attrs: {
                                      to: {
                                        name: "Listar",
                                        params: {
                                          slug: _vm.$route.params.slug
                                        },
                                        query: { categoria: subcategory.id }
                                      },
                                      exact: ""
                                    }
                                  },
                                  [_c("a", [_vm._v(_vm._s(subcategory.name))])]
                                )
                              ],
                              1
                            )
                          }),
                          0
                        )
                      : _vm._e()
                  ],
                  1
                )
              })
            ],
            2
          )
        ])
      : _vm._e(),
    _vm._v(" "),
    _vm.disciplinasExists
      ? _c(
          "nav",
          {
            style: "margin-top:30px;",
            attrs: { role: "menu disciplinas ensino medio" }
          },
          [
            _c("h5", { staticClass: "text-center" }, [_vm._v("Disciplinas")]),
            _vm._v(" "),
            _c(
              "ul",
              { staticClass: "nav nav-pills nav-stacked" },
              _vm._l(_vm.sidebar.disciplinas[0].components, function(
                disciplina,
                d
              ) {
                return _c(
                  "li",
                  { key: d },
                  [
                    _c(
                      "router-link",
                      {
                        attrs: {
                          to: {
                            name: "Listar",
                            params: { slug: _vm.$route.params.slug },
                            query: {
                              categoria: _vm.$route.query.categoria,
                              disciplina: disciplina.id
                            }
                          },
                          exact: ""
                        }
                      },
                      [_c("a", [_vm._v(_vm._s(disciplina.name))])]
                    )
                  ],
                  1
                )
              }),
              0
            )
          ]
        )
      : _vm._e(),
    _vm._v(" "),
    _vm.temasExists
      ? _c(
          "nav",
          {
            style: "margin-top: 30px;",
            attrs: { role: "menu temas transversáis" }
          },
          [
            _c(
              "h5",
              { staticClass: "text-center", style: "margin-bottom: 20px;" },
              [_vm._v("Temas Transversáis")]
            ),
            _vm._v(" "),
            _c(
              "ul",
              { staticClass: "nav nav-pills nav-stacked" },
              _vm._l(_vm.sidebar.temas[0].components, function(tema, t) {
                return _c(
                  "li",
                  { key: t },
                  [
                    _c(
                      "router-link",
                      {
                        attrs: {
                          to: {
                            name: "Listar",
                            params: { slug: _vm.$route.params.slug },
                            query: {
                              categoria: _vm.$route.query.categoria,
                              tema: tema.id
                            }
                          },
                          exact: ""
                        }
                      },
                      [_c("a", [_vm._v(_vm._s(tema.name))])]
                    )
                  ],
                  1
                )
              }),
              0
            )
          ]
        )
      : _vm._e(),
    _vm._v(" "),
    _vm.tiposExists
      ? _c("nav", { attrs: { role: "menu tipos de mídias" } }, [
          _vm._m(0),
          _vm._v(" "),
          _c(
            "ul",
            {
              staticClass: "collapse list-unstyled",
              attrs: { id: "collapse-tipos" }
            },
            _vm._l(_vm.sidebar.tipos, function(tipo, ti) {
              return _c(
                "li",
                { key: ti, staticStyle: { "padding-left": "5px" } },
                [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.checkedTipos,
                        expression: "checkedTipos"
                      }
                    ],
                    attrs: { type: "checkbox", id: "tipo-" + tipo.id },
                    domProps: {
                      value: tipo.id,
                      checked: Array.isArray(_vm.checkedTipos)
                        ? _vm._i(_vm.checkedTipos, tipo.id) > -1
                        : _vm.checkedTipos
                    },
                    on: {
                      change: [
                        function($event) {
                          var $$a = _vm.checkedTipos,
                            $$el = $event.target,
                            $$c = $$el.checked ? true : false
                          if (Array.isArray($$a)) {
                            var $$v = tipo.id,
                              $$i = _vm._i($$a, $$v)
                            if ($$el.checked) {
                              $$i < 0 && (_vm.checkedTipos = $$a.concat([$$v]))
                            } else {
                              $$i > -1 &&
                                (_vm.checkedTipos = $$a
                                  .slice(0, $$i)
                                  .concat($$a.slice($$i + 1)))
                            }
                          } else {
                            _vm.checkedTipos = $$c
                          }
                        },
                        _vm.addToQuery
                      ]
                    }
                  }),
                  _vm._v(" "),
                  _c("label", { attrs: { for: "tipo-" + tipo.id } }, [
                    _vm._v(
                      "\n                    " +
                        _vm._s(tipo.name) +
                        "\n                "
                    )
                  ])
                ]
              )
            }),
            0
          ),
          _vm._v(" "),
          _vm._m(1),
          _vm._v(" "),
          _c(
            "ul",
            {
              staticClass: "collapse list-unstyled",
              attrs: { id: "collapse-licenses" }
            },
            _vm._l(_vm.sidebar.licenses, function(license, li) {
              return _c(
                "li",
                { key: li, staticStyle: { "padding-left": "5px" } },
                [
                  _c("input", {
                    directives: [
                      {
                        name: "model",
                        rawName: "v-model",
                        value: _vm.checkedLicenses,
                        expression: "checkedLicenses"
                      }
                    ],
                    attrs: { type: "checkbox", id: "license-" + license.id },
                    domProps: {
                      value: license.id,
                      checked: Array.isArray(_vm.checkedLicenses)
                        ? _vm._i(_vm.checkedLicenses, license.id) > -1
                        : _vm.checkedLicenses
                    },
                    on: {
                      change: [
                        function($event) {
                          var $$a = _vm.checkedLicenses,
                            $$el = $event.target,
                            $$c = $$el.checked ? true : false
                          if (Array.isArray($$a)) {
                            var $$v = license.id,
                              $$i = _vm._i($$a, $$v)
                            if ($$el.checked) {
                              $$i < 0 &&
                                (_vm.checkedLicenses = $$a.concat([$$v]))
                            } else {
                              $$i > -1 &&
                                (_vm.checkedLicenses = $$a
                                  .slice(0, $$i)
                                  .concat($$a.slice($$i + 1)))
                            }
                          } else {
                            _vm.checkedLicenses = $$c
                          }
                        },
                        _vm.addToQuery
                      ]
                    }
                  }),
                  _vm._v(" "),
                  _c("label", { attrs: { for: "license-" + license.id } }, [
                    _vm._v(
                      "\n                    " +
                        _vm._s(license.name) +
                        "\n                "
                    )
                  ])
                ]
              )
            }),
            0
          ),
          _vm._v(" "),
          _c(
            "ul",
            { staticClass: "list-unstyled" },
            _vm._l(_vm.sidebar.components, function(categoriaComponent, cat) {
              return _c(
                "li",
                {
                  key: cat,
                  attrs: { id: "categoria-" + categoriaComponent.id }
                },
                [
                  _c(
                    "h5",
                    {
                      staticClass: "pointer",
                      attrs: {
                        "data-toggle": "collapse",
                        "data-target":
                          "#collapse-categoria-" + categoriaComponent.id,
                        "aria-expanded": "false",
                        "aria-controls":
                          "#collapse-categoria-" + categoriaComponent.id
                      }
                    },
                    [
                      _vm._v(
                        "\n                    " +
                          _vm._s(categoriaComponent.name) +
                          " \n                    "
                      ),
                      _c("i", {
                        staticClass:
                          "glyphicon glyphicon-chevron-down pull-right"
                      })
                    ]
                  ),
                  _vm._v(" "),
                  _c(
                    "ul",
                    {
                      staticClass: "collapse list-unstyled",
                      attrs: {
                        id: "collapse-categoria-" + categoriaComponent.id
                      }
                    },
                    _vm._l(categoriaComponent.components, function(
                      component,
                      com
                    ) {
                      return _c(
                        "li",
                        { key: com, staticStyle: { "padding-left": "5px" } },
                        [
                          _c("input", {
                            directives: [
                              {
                                name: "model",
                                rawName: "v-model",
                                value: _vm.checkedComponents,
                                expression: "checkedComponents"
                              }
                            ],
                            attrs: {
                              type: "checkbox",
                              id: "component-" + component.id
                            },
                            domProps: {
                              value: component.id,
                              checked: Array.isArray(_vm.checkedComponents)
                                ? _vm._i(_vm.checkedComponents, component.id) >
                                  -1
                                : _vm.checkedComponents
                            },
                            on: {
                              change: [
                                function($event) {
                                  var $$a = _vm.checkedComponents,
                                    $$el = $event.target,
                                    $$c = $$el.checked ? true : false
                                  if (Array.isArray($$a)) {
                                    var $$v = component.id,
                                      $$i = _vm._i($$a, $$v)
                                    if ($$el.checked) {
                                      $$i < 0 &&
                                        (_vm.checkedComponents = $$a.concat([
                                          $$v
                                        ]))
                                    } else {
                                      $$i > -1 &&
                                        (_vm.checkedComponents = $$a
                                          .slice(0, $$i)
                                          .concat($$a.slice($$i + 1)))
                                    }
                                  } else {
                                    _vm.checkedComponents = $$c
                                  }
                                },
                                _vm.addToQuery
                              ]
                            }
                          }),
                          _vm._v(" "),
                          _c("label", {
                            attrs: { for: "component-" + component.id },
                            domProps: { textContent: _vm._s(component.name) }
                          })
                        ]
                      )
                    }),
                    0
                  )
                ]
              )
            }),
            0
          ),
          _vm._v(" "),
          _c(
            "button",
            {
              staticClass: "btn btn-default",
              on: {
                click: function($event) {
                  _vm.isVisible = !_vm.isVisible
                }
              }
            },
            [!_vm.isVisible ? _c("b", [_vm._v("+")]) : _c("b", [_vm._v("-")])]
          ),
          _vm._v(" "),
          _vm.isVisible
            ? _c(
                "h5",
                {
                  staticStyle: {
                    "padding-top": "30px",
                    "padding-bottom": "30px"
                  }
                },
                [
                  _vm._v(
                    "\n            Outras Modalidades / Níveis de Ensino\n        "
                  )
                ]
              )
            : _vm._e(),
          _vm._v(" "),
          _vm.isVisible
            ? _c(
                "ul",
                { staticClass: "list-unstyled" },
                _vm._l(_vm.sidebar.niveis, function(nivel, ni) {
                  return _c(
                    "li",
                    { key: ni, attrs: { id: "nivel-" + nivel.id } },
                    [
                      nivel.id != 12 && nivel.id != 13
                        ? _c(
                            "h5",
                            {
                              staticClass: "pointer",
                              attrs: {
                                "data-toggle": "collapse",
                                "data-target": "#collapse-nivel-" + nivel.id,
                                "aria-expanded": "false",
                                "aria-controls": "#collapse-nivel-" + nivel.id
                              }
                            },
                            [
                              _vm._v(
                                "\n                    " +
                                  _vm._s(nivel.name) +
                                  "\n                    "
                              ),
                              _c("i", {
                                staticClass:
                                  "glyphicon glyphicon-chevron-down pull-right"
                              })
                            ]
                          )
                        : _vm._e(),
                      _vm._v(" "),
                      _c(
                        "ul",
                        {
                          staticClass: "collapse list-unstyled",
                          attrs: { id: "collapse-nivel-" + nivel.id }
                        },
                        _vm._l(nivel.components, function(component, com) {
                          return _c(
                            "li",
                            {
                              key: com,
                              staticStyle: { "padding-left": "5px" }
                            },
                            [
                              _c("input", {
                                directives: [
                                  {
                                    name: "model",
                                    rawName: "v-model",
                                    value: _vm.checkedComponents,
                                    expression: "checkedComponents"
                                  }
                                ],
                                attrs: {
                                  type: "checkbox",
                                  id: "component-" + component.id
                                },
                                domProps: {
                                  value: component.id,
                                  checked: Array.isArray(_vm.checkedComponents)
                                    ? _vm._i(
                                        _vm.checkedComponents,
                                        component.id
                                      ) > -1
                                    : _vm.checkedComponents
                                },
                                on: {
                                  change: [
                                    function($event) {
                                      var $$a = _vm.checkedComponents,
                                        $$el = $event.target,
                                        $$c = $$el.checked ? true : false
                                      if (Array.isArray($$a)) {
                                        var $$v = component.id,
                                          $$i = _vm._i($$a, $$v)
                                        if ($$el.checked) {
                                          $$i < 0 &&
                                            (_vm.checkedComponents = $$a.concat(
                                              [$$v]
                                            ))
                                        } else {
                                          $$i > -1 &&
                                            (_vm.checkedComponents = $$a
                                              .slice(0, $$i)
                                              .concat($$a.slice($$i + 1)))
                                        }
                                      } else {
                                        _vm.checkedComponents = $$c
                                      }
                                    },
                                    _vm.addToQuery
                                  ]
                                }
                              }),
                              _vm._v(" "),
                              _c("label", {
                                attrs: { for: "component-" + component.id },
                                domProps: {
                                  textContent: _vm._s(component.name)
                                }
                              })
                            ]
                          )
                        }),
                        0
                      )
                    ]
                  )
                }),
                0
              )
            : _vm._e()
        ])
      : _vm._e()
  ])
}
var staticRenderFns = [
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "h5",
      {
        staticClass: "pointer",
        attrs: {
          "data-toggle": "collapse",
          "data-target": "#collapse-tipos",
          "aria-expanded": "false",
          "aria-controls": "#collapse-tipos"
        }
      },
      [
        _vm._v("\n                   Tipos de Mídia\n                   "),
        _c("i", { staticClass: "glyphicon glyphicon-chevron-down pull-right" })
      ]
    )
  },
  function() {
    var _vm = this
    var _h = _vm.$createElement
    var _c = _vm._self._c || _h
    return _c(
      "h5",
      {
        staticClass: "pointer",
        attrs: {
          "data-toggle": "collapse",
          "data-target": "#collapse-licenses",
          "aria-expanded": "false",
          "aria-controls": "#collapse-licenses"
        }
      },
      [
        _vm._v("\n                   Licenças\n                   "),
        _c("i", { staticClass: "glyphicon glyphicon-chevron-down pull-right" })
      ]
    )
  }
]
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-92b465d2", module.exports)
  }
}

/***/ }),

/***/ 205:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("section", { staticClass: "container-fluid heigth" }, [
    _c("div", { staticClass: "row" }, [
      _c(
        "aside",
        { staticClass: "col-sm-3" },
        [_c("SidebarCanal", { attrs: { sidebar: _vm.sidebar } })],
        1
      ),
      _vm._v(" "),
      _c("article", { staticClass: "col-sm-9" }, [
        _c(
          "header",
          { staticClass: "page-header" },
          [
            _c(
              "h1",
              { staticClass: "page-title", style: "--color:" + _vm.color },
              [
                _vm._v(
                  "\n                    " +
                    _vm._s(_vm.title) +
                    "\n                "
                )
              ]
            ),
            _vm._v(" "),
            _c("NavCanal")
          ],
          1
        ),
        _vm._v(" "),
        _c(
          "div",
          [
            _c(
              "transition",
              {
                attrs: {
                  name: "custom-classes-transition",
                  "enter-active-class": "animated fadeIn",
                  "leave-active-class": "animated fadeOut",
                  mode: "out-in"
                }
              },
              [_c("router-view", { style: "--color:" + _vm.color })],
              1
            )
          ],
          1
        )
      ])
    ])
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

/***/ })

});