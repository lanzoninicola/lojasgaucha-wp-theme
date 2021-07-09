// TODO: handler actions when param from woocommerce is not available
// TODO: save quantity in a cookie
// TODO: handle errors. Especialy in if statement
if (typeof wc_add_to_cart_params === "undefined") {
  console.log("wc_add_to_cart_params from Woocommerce is not available");
}

const variables = {
  domNodes: {
    plusQtyButtons: document.getElementsByClassName("add-to-cart-plus-qty"),
    minusQtyButtons: document.getElementsByClassName("add-to-cart-minus-qty"),
    addToCartButtons: document.getElementsByClassName("add-to-cart-button"),
  },
  state: {},
  defaultParams: {
    addQtyFraction: 1,
    decreasQtyFraction: 1,
  },
};

// let stateQty = 0;

function setState(newState = {}) {
  let prevState = { ...variables["state"] };
  Object.keys(newState).forEach((stateItem) => {
    if (prevState[stateItem]) {
      prevState[stateItem] = newState[stateItem];
    } else {
      prevState = {
        ...prevState,
        [stateItem]: newState[stateItem],
      };
    }
  });

  variables["state"] = { ...prevState };
}

if (variables["domNodes"]["plusQtyButtons"]) {
  const plusQtyButtons = variables["domNodes"]["plusQtyButtons"];

  Object.keys(plusQtyButtons).forEach((plusButton) => {
    plusQtyButtons[plusButton].addEventListener("click", addQtyToCart);
  });
}

if (variables["domNodes"]["minusQtyButtons"]) {
  const minusQtyButtons = variables["domNodes"]["minusQtyButtons"];

  Object.keys(minusQtyButtons).forEach((minusButton) => {
    minusQtyButtons[minusButton].addEventListener("click", decreaseQtyToCart);
  });
}

if (variables["domNodes"]["addToCartButtons"]) {
  const addToCartButtons = variables["domNodes"]["addToCartButtons"];

  Object.keys(addToCartButtons).forEach((addToCartButton) => {
    addToCartButtons[addToCartButton].addEventListener("click", addToCart);
  });
}

function addQtyToCart(e) {
  e.preventDefault();
  const product_id = this.getAttribute("data-product-id");
  const initQuantityCartState = 0;

  const qtyProductState = variables["state"]["product_id_" + product_id];
  let prevQuantity = initQuantityCartState;

  if (qtyProductState) {
    prevQuantity =
      variables["state"]["product_id_" + product_id]["quantityCart"] ||
      initQuantityCartState;
  }

  let newQuantity = prevQuantity + variables["defaultParams"]["addQtyFraction"];
  setState({
    ["product_id_" + product_id]: {
      quantityCart: newQuantity,
    },
  });

  const qtyProductInput = document.getElementById(
    "add-to-cart-quantity-input-" + product_id
  );

  if (qtyProductInput) {
    qtyProductInput.value =
      variables["state"]["product_id_" + product_id]["quantityCart"];
  }
}

function decreaseQtyToCart(e) {
  e.preventDefault();
  const product_id = this.getAttribute("data-product-id");
  const initQuantityCartState = 0;

  const prevQuantity =
    variables["state"]["product_id_" + product_id]["quantityCart"] ||
    initQuantityCartState;

  let newQuantity =
    prevQuantity - variables["defaultParams"]["decreasQtyFraction"];

  if (newQuantity <= 0) {
    // TODO: disabling minus button
    newQuantity = 0;
  }

  setState({
    ["product_id_" + product_id]: {
      quantityCart: newQuantity,
    },
  });

  const qtyProductInput = document.getElementById(
    "add-to-cart-quantity-input-" + product_id
  );

  if (qtyProductInput) {
    qtyProductInput.value =
      variables["state"]["product_id_" + product_id]["quantityCart"];
  }
}

function addToCart(e) {
  e.preventDefault();
  const product_id = this.getAttribute("data-product-id");
  const product_qty_node = document.getElementById(
    "add-to-cart-quantity-input-" + product_id
  );

  if (product_qty_node) {
    product_qty = product_qty_node.value;
  }

  var data = new URLSearchParams({
    action: "ql_woocommerce_ajax_add_to_cart",
    product_id: product_id,
    product_sku: "",
    quantity: product_qty,
  });

  fetch(wc_add_to_cart_params.ajax_url, {
    method: "POST",
    credentials: "same-origin",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
      "Cache-Control": "no-cache",
    },
    body: data,
  })
    .then((res) => {
      // setLoadingState({ status: "success" });
      return res.json();
    })
    .then((res) => {
      // setCookie("cepChecked", "yes", 90);
      console.log(res);
    })
    .catch((err) => {
      // setLoadingState({ status: "error" });
      console.log("error", err);
    });
}

/*

jQuery(document).ready(function ($) {
  $(".single_add_to_cart_button").on("click", function (e) {
    e.preventDefault();
    ($thisbutton = $(this)),
      ($form = $thisbutton.closest("form.cart")),
      (id = $thisbutton.val()),
      (product_qty = $form.find("input[name=quantity]").val() || 1),
      (product_id = $form.find("input[name=product_id]").val() || id),
      (variation_id = $form.find("input[name=variation_id]").val() || 0);
    var data = {
      action: "ql_woocommerce_ajax_add_to_cart",
      product_id: product_id,
      product_sku: "",
      quantity: product_qty,
      variation_id: variation_id,
    };
    $.ajax({
      type: "post",
      url: wc_add_to_cart_params.ajax_url,
      data: data,
      beforeSend: function (response) {
        $thisbutton.removeClass("added").addClass("loading");
      },
      complete: function (response) {
        $thisbutton.addClass("added").removeClass("loading");
      },
      success: function (response) {
        if (response.error & response.product_url) {
          window.location = response.product_url;
          return;
        } else {
          $(document.body).trigger("added_to_cart", [
            response.fragments,
            response.cart_hash,
            $thisbutton,
          ]);
        }
      },
    });
  });
});
*/
