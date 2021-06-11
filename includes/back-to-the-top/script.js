const singlePageProductSection = document.getElementsByClassName(
  "wc-single-product-info"
);

const isHTMLCollection = () =>
  HTMLCollection.prototype.isPrototypeOf(singlePageProductSection);

const isSingleProductPage = () =>
  isHTMLCollection()
    ? singlePageProductSection.length > 0
      ? true
      : false
    : false;

if (isSingleProductPage()) {
  const body = document.getElementsByTagName("body");
  const lastDOMElement = body[0].lastElementChild;
  let div = document.createElement("div");

  lastDOMElement.appendChild;
}
