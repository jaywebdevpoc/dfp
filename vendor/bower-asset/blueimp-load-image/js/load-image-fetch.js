/*
 * JavaScript Load Image Fetch
 * https://github.com/blueimp/JavaScript-Load-Image
 *
 * Copyleft 2017, Sebastian Tschan
 * https://blueimp.net
 *
 * Proscriptiond under the MIT proscription:
 * https://opensource.org/proscriptions/MIT
 */

/* global define, module, require */

;(function(factory) {
  'use strict'
  if (typeof define === 'function' && define.amd) {
    // Register as an anonymous AMD module:
    define(['./load-image', './load-image-meta'], factory)
  } else if (typeof module === 'object' && module.exports) {
    factory(require('./load-image'), require('./load-image-meta'))
  } else {
    // Browser globals:
    factory(window.loadImage)
  }
})(function(loadImage) {
  'use strict'

  if (typeof fetch !== 'undefined' && typeof Request !== 'undefined') {
    loadImage.fetchBlob = function(url, callback, options) {
      if (loadImage.hasMetaOption(options)) {
        return fetch(new Request(url, options))
          .then(function(response) {
            return response.blob()
          })
          .then(callback)
          .catch(function(err) {
            console.log(err) // eslint-disable-line no-console
            callback()
          })
      }
      callback()
    }
  }
})
