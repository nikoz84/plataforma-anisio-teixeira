webpackJsonp([3],{

/***/ 109:
/***/ (function(module, exports, __webpack_require__) {

var disposed = false
var normalizeComponent = __webpack_require__(1)
/* script */
var __vue_script__ = __webpack_require__(129)
/* template */
var __vue_template__ = __webpack_require__(130)
/* template functional */
var __vue_template_functional__ = false
/* styles */
var __vue_styles__ = null
/* scopeId */
var __vue_scopeId__ = null
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
Component.options.__file = "resources/assets/js/pages/Login.vue"

/* hot reload */
if (false) {(function () {
  var hotAPI = require("vue-hot-reload-api")
  hotAPI.install(require("vue"), false)
  if (!hotAPI.compatible) return
  module.hot.accept()
  if (!module.hot.data) {
    hotAPI.createRecord("data-v-5b96cafc", Component.options)
  } else {
    hotAPI.reload("data-v-5b96cafc", Component.options)
  }
  module.hot.dispose(function (data) {
    disposed = true
  })
})()}

module.exports = Component.exports


/***/ }),

/***/ 129:
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
Object.defineProperty(__webpack_exports__, "__esModule", { value: true });
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator__ = __webpack_require__(4);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator___default = __webpack_require__.n(__WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator__);
/* harmony import */ var __WEBPACK_IMPORTED_MODULE_1__http_js__ = __webpack_require__(6);


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



/* harmony default export */ __webpack_exports__["default"] = ({
  name: 'login',
  data: function data() {
    return {
      user: {
        email: null,
        password: null
      },
      token: '',
      message: '',
      loginSuccess: null
    };
  },

  methods: {
    login: function () {
      var _ref = _asyncToGenerator( /*#__PURE__*/__WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator___default.a.mark(function _callee() {
        var _this = this;

        return __WEBPACK_IMPORTED_MODULE_0_babel_runtime_regenerator___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:

                axios.post('/api-v1/auth/login', { email: this.user.email,
                  password: this.user.password }).then(function (resp) {
                  //this.loginSuccess = resp.data.success;
                  console.log(resp);
                  localStorage.setItem('token', resp.data.access_token);
                  //localStorage.setItem('login_success', this.loginSuccess)
                  //localStorage.setItem('username', resp.data.user.name)
                  //localStorage.setItem('user_id', resp.data.user.id)
                  if (localStorage.getItem('token')) {
                    _this.$router.push('admin');
                  }
                }).catch(function (error) {
                  /*
                  if (error.response.status === 401) {
                    this.message = error.response.data.message;
                    this.loginSuccess = error.response.data.success;
                    localStorage.setItem('login_success', this.loginSuccess)
                  }
                  */
                });

                //let http = new Http();
                //let resp = await http.postData();
                //console.log(resp);     

              case 1:
              case 'end':
                return _context.stop();
            }
          }
        }, _callee, this);
      }));

      function login() {
        return _ref.apply(this, arguments);
      }

      return login;
    }()
  }
});

/***/ }),

/***/ 130:
/***/ (function(module, exports, __webpack_require__) {

var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c("section", { staticClass: "container-fluid heigth" }, [
    _c("div", { staticClass: "row" }, [
      _c(
        "div",
        {
          staticClass:
            "col-md-6 col-md-offset-3 col-xs-10 col-xs-offset-1 center-xs"
        },
        [
          _c("h3", { staticClass: "center-xs" }, [
            _vm._v("Faça seu login agora")
          ]),
          _vm._v(" "),
          _c(
            "form",
            {
              on: {
                submit: function($event) {
                  $event.preventDefault()
                  _vm.login()
                }
              }
            },
            [
              _c("div", { staticClass: "form-group" }, [
                _c("label", { attrs: { for: "email" } }, [_vm._v("E-mail")]),
                _vm._v(" "),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.user.email,
                      expression: "user.email"
                    }
                  ],
                  staticClass: "form-control",
                  attrs: { id: "email", type: "text" },
                  domProps: { value: _vm.user.email },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.$set(_vm.user, "email", $event.target.value)
                    }
                  }
                })
              ]),
              _vm._v(" "),
              _c("div", { staticClass: "form-group" }, [
                _c("label", { attrs: { for: "senha" } }, [_vm._v("Senha")]),
                _vm._v(" "),
                _c("input", {
                  directives: [
                    {
                      name: "model",
                      rawName: "v-model",
                      value: _vm.user.password,
                      expression: "user.password"
                    }
                  ],
                  staticClass: "form-control",
                  attrs: { id: "senha", type: "password" },
                  domProps: { value: _vm.user.password },
                  on: {
                    input: function($event) {
                      if ($event.target.composing) {
                        return
                      }
                      _vm.$set(_vm.user, "password", $event.target.value)
                    }
                  }
                })
              ]),
              _vm._v(" "),
              _c(
                "button",
                { staticClass: "btn btn-default", attrs: { type: "submit" } },
                [_vm._v("Login")]
              )
            ]
          ),
          _vm._v(" "),
          _vm.loginSuccess == false
            ? _c(
                "div",
                { staticClass: "alert alert-info", attrs: { role: "alert" } },
                [_vm._v("\n        " + _vm._s(_vm.message) + "\n      ")]
              )
            : _vm._e()
        ]
      )
    ])
  ])
}
var staticRenderFns = []
render._withStripped = true
module.exports = { render: render, staticRenderFns: staticRenderFns }
if (false) {
  module.hot.accept()
  if (module.hot.data) {
    require("vue-hot-reload-api")      .rerender("data-v-5b96cafc", module.exports)
  }
}

/***/ })

});