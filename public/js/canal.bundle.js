(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["canal"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/components/NavCanalComponent.vue?vue&type=script&lang=js&":
/*!***********************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/components/NavCanalComponent.vue?vue&type=script&lang=js& ***!
  \***********************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

var _index = _interopRequireDefault(__webpack_require__(/*! ../store/index.js */ "./resources/assets/js/store/index.js"));

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

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
var _default = {
  name: 'NavCanal',
  props: ['hasAbout'],
  data: function data() {
    return {
      isLogged: _index["default"].state.isLogged
    };
  },
  beforeCreate: function beforeCreate() {},
  computed: {
    showAdicionarConteudo: function showAdicionarConteudo() {
      if (this.isLogged && this.$route.params.slug != 'aplicativos-educacionais') {
        return true;
      }

      return false;
    },
    showAdicionarAplicativo: function showAdicionarAplicativo() {
      if (this.isLogged && this.$route.params.slug == 'aplicativos-educacionais') {
        return true;
      }

      return false;
    }
  },
  methods: {
    getUrl: function getUrl() {
      var url = encodeURI(location.href);
      this.$router.push({
        name: 'DenunciaForm',
        params: {
          slug: this.$route.params.slug,
          url: url
        }
      });
    },
    getUrlFaleConosco: function getUrlFaleConosco() {
      var url = encodeURI(location.href);
      this.$router.push({
        name: 'FaleConoscoForm',
        params: {
          slug: this.$route.params.slug,
          url: url
        }
      });
    }
  }
};
exports["default"] = _default;

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/components/SidebarCanalComponent.vue?vue&type=script&lang=js&":
/*!***************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/components/SidebarCanalComponent.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

var _client = _interopRequireDefault(__webpack_require__(/*! ../client.js */ "./resources/assets/js/client.js"));

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

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
var _default = {
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
      this.$router.push({
        name: 'Listar',
        params: {
          slug: this.$route.params.slug
        },
        query: {
          tipos: [this.checkedTipos],
          licencas: [this.checkedLicenses],
          componentes: [this.checkedComponents]
        }
      });
    }
  }
};
exports["default"] = _default;

/***/ }),

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/pages/Canal.vue?vue&type=script&lang=js&":
/*!******************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/pages/Canal.vue?vue&type=script&lang=js& ***!
  \******************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


Object.defineProperty(exports, "__esModule", {
  value: true
});
exports["default"] = void 0;

var _regenerator = _interopRequireDefault(__webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js"));

var _NavCanalComponent = _interopRequireDefault(__webpack_require__(/*! ../components/NavCanalComponent.vue */ "./resources/assets/js/components/NavCanalComponent.vue"));

var _SidebarCanalComponent = _interopRequireDefault(__webpack_require__(/*! ../components/SidebarCanalComponent.vue */ "./resources/assets/js/components/SidebarCanalComponent.vue"));

var _client = _interopRequireDefault(__webpack_require__(/*! ../client.js */ "./resources/assets/js/client.js"));

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

var _default = {
  name: 'canal',
  components: {
    NavCanal: _NavCanalComponent["default"],
    SidebarCanal: _SidebarCanalComponent["default"]
  },
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
      var _getCanal = _asyncToGenerator(
      /*#__PURE__*/
      _regenerator["default"].mark(function _callee() {
        var url, resp;
        return _regenerator["default"].wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                url = "/canais/slug/".concat(this.$route.params.slug);
                _context.next = 3;
                return _client["default"].get(url);

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
              case "end":
                return _context.stop();
            }
          }
        }, _callee, this);
      }));

      function getCanal() {
        return _getCanal.apply(this, arguments);
      }

      return getCanal;
    }(),
    getCategories: function () {
      var _getCategories = _asyncToGenerator(
      /*#__PURE__*/
      _regenerator["default"].mark(function _callee2() {
        var params, resp;
        return _regenerator["default"].wrap(function _callee2$(_context2) {
          while (1) {
            switch (_context2.prev = _context2.next) {
              case 0:
                params = {
                  canal: this.canal_id
                };
                _context2.next = 3;
                return _client["default"].get('/categories', params);

              case 3:
                resp = _context2.sent;

                if (resp.data.success) {
                  this.categories = resp.data.categories;
                }

              case 5:
              case "end":
                return _context2.stop();
            }
          }
        }, _callee2, this);
      }));

      function getCategories() {
        return _getCategories.apply(this, arguments);
      }

      return getCategories;
    }()
  }
};
exports["default"] = _default;

/***/ }),

/***/ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/lib/loader.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/pages/Canal.vue?vue&type=style&index=0&id=4931cae4&lang=scss&scoped=true&":
/*!*******************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/css-loader!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-2!./node_modules/sass-loader/lib/loader.js??ref--7-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/pages/Canal.vue?vue&type=style&index=0&id=4931cae4&lang=scss&scoped=true& ***!
  \*******************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

exports = module.exports = __webpack_require__(/*! ../../../../node_modules/css-loader/lib/css-base.js */ "./node_modules/css-loader/lib/css-base.js")(false);
// imports


// module
exports.push([module.i, ".page-header[data-v-4931cae4] {\n  margin: 0;\n}\n.page-header .page-title[data-v-4931cae4] {\n  margin-top: 0;\n  position: relative;\n  margin-bottom: 30px;\n}\n.page-header .page-title[data-v-4931cae4]:after {\n  width: 15%;\n  height: 2px;\n  content: '';\n  background: var(--color);\n  display: block;\n  position: absolute;\n  bottom: -10px;\n}\n[data-v-4931cae4]:root {\n  --background: var(--color);\n}\naside > header > h3[data-v-4931cae4] {\n  margin-top: 5px;\n  font-size: 18px;\n}\n", ""]);

// exports


/***/ }),

/***/ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/lib/loader.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/pages/Canal.vue?vue&type=style&index=0&id=4931cae4&lang=scss&scoped=true&":
/*!***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/style-loader!./node_modules/css-loader!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src??ref--7-2!./node_modules/sass-loader/lib/loader.js??ref--7-3!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/pages/Canal.vue?vue&type=style&index=0&id=4931cae4&lang=scss&scoped=true& ***!
  \***********************************************************************************************************************************************************************************************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {


var content = __webpack_require__(/*! !../../../../node_modules/css-loader!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--7-2!../../../../node_modules/sass-loader/lib/loader.js??ref--7-3!../../../../node_modules/vue-loader/lib??vue-loader-options!./Canal.vue?vue&type=style&index=0&id=4931cae4&lang=scss&scoped=true& */ "./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/lib/loader.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/pages/Canal.vue?vue&type=style&index=0&id=4931cae4&lang=scss&scoped=true&");

if(typeof content === 'string') content = [[module.i, content, '']];

var transform;
var insertInto;



var options = {"hmr":true}

options.transform = transform
options.insertInto = undefined;

var update = __webpack_require__(/*! ../../../../node_modules/style-loader/lib/addStyles.js */ "./node_modules/style-loader/lib/addStyles.js")(content, options);

if(content.locals) module.exports = content.locals;

if(false) {}

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/components/NavCanalComponent.vue?vue&type=template&id=69ec2f9e&scoped=true&":
/*!***************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/components/NavCanalComponent.vue?vue&type=template&id=69ec2f9e&scoped=true& ***!
  \***************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
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
        ]),
        _vm._v(" "),
        _c("li", [
          _c(
            "a",
            {
              on: {
                click: function($event) {
                  $event.preventDefault()
                  return _vm.getUrlFaleConosco($event)
                }
              }
            },
            [_vm._v("Fale Conosco")]
          )
        ])
      ],
      1
    )
  ])
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/components/SidebarCanalComponent.vue?vue&type=template&id=92b465d2&scoped=true&":
/*!*******************************************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/components/SidebarCanalComponent.vue?vue&type=template&id=92b465d2&scoped=true& ***!
  \*******************************************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
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
                      "\r\n                    " +
                        _vm._s(tipo.name) +
                        "\r\n                "
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
                      "\r\n                    " +
                        _vm._s(license.name) +
                        "\r\n                "
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
                        "\r\n                    " +
                          _vm._s(categoriaComponent.name) +
                          " \r\n                    "
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
                    "\r\n            Outras Modalidades / Níveis de Ensino\r\n        "
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
                                "\r\n                    " +
                                  _vm._s(nivel.name) +
                                  "\r\n                    "
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
        _vm._v("\r\n                   Tipos de Mídia\r\n                   "),
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
        _vm._v("\r\n                   Licenças\r\n                   "),
        _c("i", { staticClass: "glyphicon glyphicon-chevron-down pull-right" })
      ]
    )
  }
]
render._withStripped = true



/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/pages/Canal.vue?vue&type=template&id=4931cae4&scoped=true&":
/*!**********************************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/assets/js/pages/Canal.vue?vue&type=template&id=4931cae4&scoped=true& ***!
  \**********************************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
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



/***/ }),

/***/ "./resources/assets/js/components/NavCanalComponent.vue":
/*!**************************************************************!*\
  !*** ./resources/assets/js/components/NavCanalComponent.vue ***!
  \**************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _NavCanalComponent_vue_vue_type_template_id_69ec2f9e_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./NavCanalComponent.vue?vue&type=template&id=69ec2f9e&scoped=true& */ "./resources/assets/js/components/NavCanalComponent.vue?vue&type=template&id=69ec2f9e&scoped=true&");
/* harmony import */ var _NavCanalComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./NavCanalComponent.vue?vue&type=script&lang=js& */ "./resources/assets/js/components/NavCanalComponent.vue?vue&type=script&lang=js&");
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _NavCanalComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _NavCanalComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__[key]; }) }(__WEBPACK_IMPORT_KEY__));
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _NavCanalComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _NavCanalComponent_vue_vue_type_template_id_69ec2f9e_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _NavCanalComponent_vue_vue_type_template_id_69ec2f9e_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "69ec2f9e",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/assets/js/components/NavCanalComponent.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/assets/js/components/NavCanalComponent.vue?vue&type=script&lang=js&":
/*!***************************************************************************************!*\
  !*** ./resources/assets/js/components/NavCanalComponent.vue?vue&type=script&lang=js& ***!
  \***************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_NavCanalComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./NavCanalComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/components/NavCanalComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_NavCanalComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_NavCanalComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_NavCanalComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_NavCanalComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_NavCanalComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/assets/js/components/NavCanalComponent.vue?vue&type=template&id=69ec2f9e&scoped=true&":
/*!*********************************************************************************************************!*\
  !*** ./resources/assets/js/components/NavCanalComponent.vue?vue&type=template&id=69ec2f9e&scoped=true& ***!
  \*********************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_NavCanalComponent_vue_vue_type_template_id_69ec2f9e_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./NavCanalComponent.vue?vue&type=template&id=69ec2f9e&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/components/NavCanalComponent.vue?vue&type=template&id=69ec2f9e&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_NavCanalComponent_vue_vue_type_template_id_69ec2f9e_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_NavCanalComponent_vue_vue_type_template_id_69ec2f9e_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/assets/js/components/SidebarCanalComponent.vue":
/*!******************************************************************!*\
  !*** ./resources/assets/js/components/SidebarCanalComponent.vue ***!
  \******************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _SidebarCanalComponent_vue_vue_type_template_id_92b465d2_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./SidebarCanalComponent.vue?vue&type=template&id=92b465d2&scoped=true& */ "./resources/assets/js/components/SidebarCanalComponent.vue?vue&type=template&id=92b465d2&scoped=true&");
/* harmony import */ var _SidebarCanalComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./SidebarCanalComponent.vue?vue&type=script&lang=js& */ "./resources/assets/js/components/SidebarCanalComponent.vue?vue&type=script&lang=js&");
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _SidebarCanalComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _SidebarCanalComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__[key]; }) }(__WEBPACK_IMPORT_KEY__));
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _SidebarCanalComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _SidebarCanalComponent_vue_vue_type_template_id_92b465d2_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _SidebarCanalComponent_vue_vue_type_template_id_92b465d2_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "92b465d2",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/assets/js/components/SidebarCanalComponent.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/assets/js/components/SidebarCanalComponent.vue?vue&type=script&lang=js&":
/*!*******************************************************************************************!*\
  !*** ./resources/assets/js/components/SidebarCanalComponent.vue?vue&type=script&lang=js& ***!
  \*******************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SidebarCanalComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./SidebarCanalComponent.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/components/SidebarCanalComponent.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SidebarCanalComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SidebarCanalComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SidebarCanalComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SidebarCanalComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_SidebarCanalComponent_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/assets/js/components/SidebarCanalComponent.vue?vue&type=template&id=92b465d2&scoped=true&":
/*!*************************************************************************************************************!*\
  !*** ./resources/assets/js/components/SidebarCanalComponent.vue?vue&type=template&id=92b465d2&scoped=true& ***!
  \*************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SidebarCanalComponent_vue_vue_type_template_id_92b465d2_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./SidebarCanalComponent.vue?vue&type=template&id=92b465d2&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/components/SidebarCanalComponent.vue?vue&type=template&id=92b465d2&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SidebarCanalComponent_vue_vue_type_template_id_92b465d2_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_SidebarCanalComponent_vue_vue_type_template_id_92b465d2_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ }),

/***/ "./resources/assets/js/pages/Canal.vue":
/*!*********************************************!*\
  !*** ./resources/assets/js/pages/Canal.vue ***!
  \*********************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Canal_vue_vue_type_template_id_4931cae4_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Canal.vue?vue&type=template&id=4931cae4&scoped=true& */ "./resources/assets/js/pages/Canal.vue?vue&type=template&id=4931cae4&scoped=true&");
/* harmony import */ var _Canal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Canal.vue?vue&type=script&lang=js& */ "./resources/assets/js/pages/Canal.vue?vue&type=script&lang=js&");
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _Canal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _Canal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__[key]; }) }(__WEBPACK_IMPORT_KEY__));
/* harmony import */ var _Canal_vue_vue_type_style_index_0_id_4931cae4_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ./Canal.vue?vue&type=style&index=0&id=4931cae4&lang=scss&scoped=true& */ "./resources/assets/js/pages/Canal.vue?vue&type=style&index=0&id=4931cae4&lang=scss&scoped=true&");
/* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");






/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_3__["default"])(
  _Canal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Canal_vue_vue_type_template_id_4931cae4_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Canal_vue_vue_type_template_id_4931cae4_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  "4931cae4",
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/assets/js/pages/Canal.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/assets/js/pages/Canal.vue?vue&type=script&lang=js&":
/*!**********************************************************************!*\
  !*** ./resources/assets/js/pages/Canal.vue?vue&type=script&lang=js& ***!
  \**********************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Canal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/babel-loader/lib??ref--4-0!../../../../node_modules/vue-loader/lib??vue-loader-options!./Canal.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/pages/Canal.vue?vue&type=script&lang=js&");
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Canal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Canal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Canal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Canal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Canal_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/assets/js/pages/Canal.vue?vue&type=style&index=0&id=4931cae4&lang=scss&scoped=true&":
/*!*******************************************************************************************************!*\
  !*** ./resources/assets/js/pages/Canal.vue?vue&type=style&index=0&id=4931cae4&lang=scss&scoped=true& ***!
  \*******************************************************************************************************/
/*! no static exports found */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_lib_loader_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Canal_vue_vue_type_style_index_0_id_4931cae4_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/style-loader!../../../../node_modules/css-loader!../../../../node_modules/vue-loader/lib/loaders/stylePostLoader.js!../../../../node_modules/postcss-loader/src??ref--7-2!../../../../node_modules/sass-loader/lib/loader.js??ref--7-3!../../../../node_modules/vue-loader/lib??vue-loader-options!./Canal.vue?vue&type=style&index=0&id=4931cae4&lang=scss&scoped=true& */ "./node_modules/style-loader/index.js!./node_modules/css-loader/index.js!./node_modules/vue-loader/lib/loaders/stylePostLoader.js!./node_modules/postcss-loader/src/index.js?!./node_modules/sass-loader/lib/loader.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/pages/Canal.vue?vue&type=style&index=0&id=4931cae4&lang=scss&scoped=true&");
/* harmony import */ var _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_lib_loader_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Canal_vue_vue_type_style_index_0_id_4931cae4_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_lib_loader_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Canal_vue_vue_type_style_index_0_id_4931cae4_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0__);
/* harmony reexport (unknown) */ for(var __WEBPACK_IMPORT_KEY__ in _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_lib_loader_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Canal_vue_vue_type_style_index_0_id_4931cae4_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0__) if(__WEBPACK_IMPORT_KEY__ !== 'default') (function(key) { __webpack_require__.d(__webpack_exports__, key, function() { return _node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_lib_loader_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Canal_vue_vue_type_style_index_0_id_4931cae4_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0__[key]; }) }(__WEBPACK_IMPORT_KEY__));
 /* harmony default export */ __webpack_exports__["default"] = (_node_modules_style_loader_index_js_node_modules_css_loader_index_js_node_modules_vue_loader_lib_loaders_stylePostLoader_js_node_modules_postcss_loader_src_index_js_ref_7_2_node_modules_sass_loader_lib_loader_js_ref_7_3_node_modules_vue_loader_lib_index_js_vue_loader_options_Canal_vue_vue_type_style_index_0_id_4931cae4_lang_scss_scoped_true___WEBPACK_IMPORTED_MODULE_0___default.a); 

/***/ }),

/***/ "./resources/assets/js/pages/Canal.vue?vue&type=template&id=4931cae4&scoped=true&":
/*!****************************************************************************************!*\
  !*** ./resources/assets/js/pages/Canal.vue?vue&type=template&id=4931cae4&scoped=true& ***!
  \****************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Canal_vue_vue_type_template_id_4931cae4_scoped_true___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../../node_modules/vue-loader/lib??vue-loader-options!./Canal.vue?vue&type=template&id=4931cae4&scoped=true& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/assets/js/pages/Canal.vue?vue&type=template&id=4931cae4&scoped=true&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Canal_vue_vue_type_template_id_4931cae4_scoped_true___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Canal_vue_vue_type_template_id_4931cae4_scoped_true___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);