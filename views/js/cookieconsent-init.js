/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./src/index.js":
/*!**********************!*\
  !*** ./src/index.js ***!
  \**********************/
/***/ (() => {

eval("// TODO: Da capire se consent update e consent default va fatto per ogni pagina oppure solo al cambio\n\nCookieConsent.run({\n  onModalShow: function (event) {\n    const e = document.querySelector(\"#cc-main .pm\");\n    let {\n      consentId,\n      consentTimestamp,\n      lastConsentTimestamp\n    } = window.CookieConsent.getCookie();\n    if (!window.CookieConsent.validConsent() || !e) return;\n    consentIdField = e.querySelector('#consent-id');\n    consentTimestampField = e.querySelector('#consent-timestamp');\n    lastConsentTimestampField = e.querySelector('#last-consent-timestamp');\n    consentIdField && (consentIdField.textContent = consentId);\n    consentTimestampField && (consentTimestampField.textContent = new Date(consentTimestamp).toLocaleString());\n    lastConsentTimestampField && (lastConsentTimestampField.textContent = new Date(lastConsentTimestamp).toLocaleString());\n  },\n  categories: window.cc_config.categories,\n  disablePageInteraction: window.cc_config.disablePageInteraction,\n  autoClearCookies: window.cc_config.autoClearCookies,\n  guiOptions: window.cc_config.guiOptions,\n  language: {\n    default: 'en',\n    translations: {\n      en: {\n        consentModal: {\n          title: 'We use cookies',\n          description: 'Cookie modal description',\n          acceptAllBtn: 'Accept all',\n          acceptNecessaryBtn: 'Reject all',\n          showPreferencesBtn: 'Manage Individual preferences'\n        },\n        preferencesModal: {\n          title: 'Manage cookie preferences',\n          acceptAllBtn: 'Accept all',\n          acceptNecessaryBtn: 'Reject all',\n          savePreferencesBtn: 'Accept current selection',\n          closeIconLabel: 'Close modal',\n          sections: [{\n            title: 'Somebody said ... cookies?',\n            description: 'I want one!'\n          }, ...window.cc_config.sections, {\n            title: \"Your consent details\",\n            description: '<p>consent id: <span id=\"consent-id\">-</span></p><p>consent date: <span id=\"consent-timestamp\">-</span></p><p>last update: <span id=\"last-consent-timestamp\">-</span></p>'\n          }, {\n            title: 'More information',\n            description: 'For any queries in relation to my policy on cookies and your choices, please <a href=\"#contact-page\">contact us</a>'\n          }]\n        }\n      }\n    }\n  }\n});\n\n//# sourceURL=webpack://cookieconsent/./src/index.js?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./src/index.js"]();
/******/ 	
/******/ })()
;