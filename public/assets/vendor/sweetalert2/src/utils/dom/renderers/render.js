import globalState from 'public/assets/vendor/sweetalert2/src/globalState.js'
import { getPopup } from 'public/assets/vendor/sweetalert2/src/utils/dom/getters.js'
import { renderActions } from 'public/assets/vendor/sweetalert2/src/utils/dom/renderers/renderActions.js'
import { renderCloseButton } from 'public/assets/vendor/sweetalert2/src/utils/dom/renderers/renderCloseButton.js'
import { renderContainer } from 'public/assets/vendor/sweetalert2/src/utils/dom/renderers/renderContainer.js'
import { renderContent } from 'public/assets/vendor/sweetalert2/src/utils/dom/renderers/renderContent.js'
import { renderFooter } from 'public/assets/vendor/sweetalert2/src/utils/dom/renderers/renderFooter.js'
import { renderIcon } from 'public/assets/vendor/sweetalert2/src/utils/dom/renderers/renderIcon.js'
import { renderImage } from 'public/assets/vendor/sweetalert2/src/utils/dom/renderers/renderImage.js'
import { renderPopup } from 'public/assets/vendor/sweetalert2/src/utils/dom/renderers/renderPopup.js'
import { renderProgressSteps } from 'public/assets/vendor/sweetalert2/src/utils/dom/renderers/renderProgressSteps.js'
import { renderTitle } from 'public/assets/vendor/sweetalert2/src/utils/dom/renderers/renderTitle.js'

/**
 * @param {SweetAlert} instance
 * @param {SweetAlertOptions} params
 */
export const render = (instance, params) => {
  renderPopup(instance, params)
  renderContainer(instance, params)

  renderProgressSteps(instance, params)
  renderIcon(instance, params)
  renderImage(instance, params)
  renderTitle(instance, params)
  renderCloseButton(instance, params)

  renderContent(instance, params)
  renderActions(instance, params)
  renderFooter(instance, params)

  const popup = getPopup()
  if (typeof params.didRender === 'function' && popup) {
    params.didRender(popup)
  }
  globalState.eventEmitter.emit('didRender', popup)
}
