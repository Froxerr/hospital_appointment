import * as dom from 'public/assets/vendor/sweetalert2/src/utils/dom/index'

/**
 * @param {SweetAlert} instance
 * @param {SweetAlertOptions} params
 */
export const renderTitle = (instance, params) => {
  const title = dom.getTitle()
  if (!title) {
    return
  }

  dom.showWhenInnerHtmlPresent(title)

  dom.toggle(title, params.title || params.titleText, 'block')

  if (params.title) {
    dom.parseHtmlToContainer(params.title, title)
  }

  if (params.titleText) {
    title.innerText = params.titleText
  }

  // Custom class
  dom.applyCustomClass(title, params, 'title')
}
