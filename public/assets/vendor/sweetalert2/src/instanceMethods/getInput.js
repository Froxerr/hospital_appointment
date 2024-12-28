import privateProps from 'public/assets/vendor/sweetalert2/src/privateProps.js'
import * as dom from 'public/assets/vendor/sweetalert2/src/utils/dom'

/**
 * Gets the input DOM node, this method works with input parameter.
 *
 * @returns {HTMLInputElement | null}
 */
export function getInput() {
  const innerParams = privateProps.innerParams.get(this)
  const domCache = privateProps.domCache.get(this)
  if (!domCache) {
    return null
  }
  return dom.getInput(domCache.popup, innerParams.input)
}
