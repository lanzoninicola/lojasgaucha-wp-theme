function getUpsellDOMSection() {
  let productUpsellSection = [];

  productUpsellSection = [
    ...productUpsellSection,
    ...document.getElementsByClassName("product-upsell"),
  ];

  if (productUpsellSection.length > 1) {
    console.error(
      'Multiple assignment of "product-upsell" class in the DOM detected. Please, inspect the HTML'
    );
    return;
  }

  return productUpsellSection[0];
}

function hideUpsellDOMSection() {
  productUpsellSection = getUpsellDOMSection();

  if (
    typeof productUpsellSection === "object" &&
    productUpsellSection !== undefined &&
    productUpsellSection !== null
  ) {
    try {
      productUpsellSection.parentNode.removeChild(productUpsellSection);
    } catch (e) {
      if (typeof e === "string") {
        console.error("hide_upsell_product - " + e);
      }
    }
  }
}

hideUpsellDOMSection();
