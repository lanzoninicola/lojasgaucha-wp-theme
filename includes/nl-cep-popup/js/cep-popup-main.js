// TODO: manage response from server
// TODO: managing errors (send to external services)

const WP_ADMIN_AJAX = jsDataLake["adminAjax"];

const checkCepButton = document.getElementById("btn-check-cep");
if (checkCepButton) {
  checkCepButton.addEventListener("click", (e) => {
    console.log("checkCepButton click event fired");

    setLoadingState({ status: "pending" });

    const body = new URLSearchParams({
      action: "check_cep_request",
      request_id: "cep-popup",
    });

    httpRequest(body);
  });
}

const pickupStoreButton = document.getElementById("btn-pickup-store");
if (pickupStoreButton) {
  pickupStoreButton.addEventListener("click", (e) => {
    console.log("pickupStoreButton click event fired");

    setLoadingState({ status: "pending" });

    const body = new URLSearchParams({
      action: "pickup_store",
      request_id: "cep-popup",
    });

    httpRequest(body);
  });
}

const cepUserState = document.getElementById("cep-form-states");
if (cepUserState) {
  cepUserState.addEventListener("change", (e) => {
    cepUserState.value = e.target.value;
  });
}

const cepUserInput = document.getElementById("cep-form-usercep-input");
if (cepUserInput) {
  cepUserInput.addEventListener("onchange", (e) => {
    cepUserInput.value = e.target.value;
  });
}

const cepFormSubmitButton = document.getElementById("cep-form-submit");
if (cepFormSubmitButton) {
  cepFormSubmitButton.addEventListener("click", (e) => {
    console.log("CEP FORM click event fired");

    if (cepUserInput.value > 0) {
      setLoadingState({ status: "pending" });

      const body = new URLSearchParams({
        action: "shipping_area_validation",
        request_id: "cep-form",
        field: "cep-form-countries",
        country: jsDataLake["countryCode"],
        state: cepUserState.value,
        postcode: cepUserInput.value,
      });

      httpRequest(body);
    }
  });
}

function setLoadingState({ status = "pending" }) {
  if (status === "pending") {
    setNotice({ message: "Loading...." });
  }

  if (status === "success") {
    setNotice({ message: "" });
  }

  if (status === "rejected") {
    setNotice({ message: "Some error occured" });
  }
}

function setNotice({ message = "" }) {
  const cepFormNotice = document.getElementById("cep-form-notice");

  if (cepFormNotice) {
    cepFormNotice.innerText = message;
  }
}

function httpRequest(body) {
  fetch(WP_ADMIN_AJAX, {
    method: "POST",
    credentials: "same-origin",
    headers: {
      "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
      "Cache-Control": "no-cache",
    },
    body: body,
  })
    .then((res) => {
      setLoadingState({ status: "success" });
      return res.json();
    })
    .then((res) => {
      console.log(res);
    })
    .catch((err) => {
      setLoadingState({ status: "error" });
      console.log("son qua", err);
    });
}
