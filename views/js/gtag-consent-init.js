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

/***/ "./src/gtag-consent-init.js":
/*!**********************************!*\
  !*** ./src/gtag-consent-init.js ***!
  \**********************************/
/***/ (() => {

eval("window.dataLayer = window.dataLayer || [];\nfunction gtag() {\n  window.dataLayer.push(arguments);\n}\ngtag('consent', 'default', {\n  'personalization_storage': 'denied',\n  'security_storage': 'denied',\n  'analytics_storage': 'denied',\n  'ad_storage': 'denied'\n});\n(function ($) {\n  window.addEventListener('cc:onFirstConsent, cc:onConsent', function (event) {\n    let consent = {};\n    let userPreferences = CookieConsent.getUserPreferences();\n    userPreferences.acceptedCategories.forEach(category => {\n      consent[category] = 'granted';\n    });\n    userPreferences.rejectedCategories.forEach(category => {\n      consent[category] = 'denied';\n    });\n    gtag('consent', 'update', consent);\n  });\n  window.addEventListener('cc:onChange', function (event) {\n    let consent = {};\n    let userPreferences = CookieConsent.getUserPreferences();\n    event.detail.changedCategories.forEach(category => {\n      consent[category] = userPreferences.acceptedCategories.includes(category) ? 'granted' : 'denied';\n    });\n    gtag('consent', 'update', consent);\n  });\n})();\n\n//# sourceURL=webpack://cookieconsent/./src/gtag-consent-init.js?");

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./src/gtag-consent-init.js"]();
/******/ 	
/******/ })()
;