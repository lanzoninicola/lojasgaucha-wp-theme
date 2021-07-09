const WP_ADMIN_AJAX = jsDataLake["wpAjaxEndpoint"];
const CEP_POPUP_TIMEOUT = jsDataLake["popupTimeout"];

const cepPopupDomNodes = {
  containerNode: document.getElementById("cep-popup-container"),
  viewWelcome: document.getElementById("cep-popup-welcome"),
  btnGotoCepCheckForm: document.getElementById("btn-goto-check-cep"),
  viewCepCheckForm: document.getElementById("cep-popup-check-cep-form"),
  btnSubmitCheckCep: document.getElementById(
    "cep-form-submit-cep-check-request"
  ),
  viewCepCheckSuccess: document.getElementById("cep-popup-check-success"),
  viewCepCheckFailed: document.getElementById("cep-popup-check-failed"),
  btnGotoStore: document.getElementsByClassName("cep-popup-btn-go-to-store"),
  noticeArea: document.getElementById("cep-popup-notice"),
  doNotRemindMe: document.getElementById("cep-popup-donotremindme"),
};

setTimeout(showCepPopUp, CEP_POPUP_TIMEOUT);

gotoCepCheck();

gotoStore();

submitCepCheckRequest();

doNotRemindMe();

function showCepPopUp() {
  const containerNode = cepPopupDomNodes["containerNode"];
  const doNotRemindCookie = getCookie("cepDoNotRemindMe");
  const cepCheckedCookie = getCookie("cepChecked");

  if (doNotRemindCookie !== "yes" || cepCheckedCookie !== "yes") {
    if (containerNode) {
      containerNode.classList.remove("cep-popup-hidden");
      containerNode.classList.add("nl-cep-popup-show");
    }
  }
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

function gotoCepCheck() {
  const viewWelcome = cepPopupDomNodes["viewWelcome"];
  const btnGotoCepCheckForm = cepPopupDomNodes["btnGotoCepCheckForm"];
  const viewCepCheckForm = cepPopupDomNodes["viewCepCheckForm"];
  if (viewWelcome) {
    if (btnGotoCepCheckForm) {
      btnGotoCepCheckForm.addEventListener("click", (e) => {
        e.preventDefault();
        hideNode(viewWelcome);
        showNode(viewCepCheckForm);
      });
    }
  }
}

function submitCepCheckRequest() {
  const btnSubmitCheckCep = cepPopupDomNodes["btnSubmitCheckCep"];
  const viewCepCheckForm = cepPopupDomNodes["viewCepCheckForm"];
  const viewCepCheckSuccess = cepPopupDomNodes["viewCepCheckSuccess"];
  const viewCepCheckFailed = cepPopupDomNodes["viewCepCheckFailed"];

  if (btnSubmitCheckCep) {
    btnSubmitCheckCep.addEventListener("click", (e) => {
      e.preventDefault();
      if (cepUserInput.value <= 0) {
        setNotice({ type: "error", message: "CEP necessário" });
      } else {
        setLoadingState({ status: "pending" });

        const body = new URLSearchParams({
          action: "shipping_area_validation",
          request_id: "cep-form",
          field: "cep-form-countries",
          country: jsDataLake["countryCode"],
          state: cepUserState.value,
          postcode: cepUserInput.value,
        });

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
            setCookie("cepChecked", "yes", 90);

            const cepCheckResult = res["data"]["result"];

            if (cepCheckResult) {
              hideNode(viewCepCheckForm);
              showNode(viewCepCheckSuccess);
              gotoStore();
            }

            if (!cepCheckResult) {
              hideNode(viewCepCheckForm);
              showNode(viewCepCheckFailed);
              gotoStore();
            }
          })
          .catch((err) => {
            setLoadingState({ status: "error" });
            console.log("son qua", err);
          });
      }
    });
  }
}

function gotoStore() {
  btnGotoStore = cepPopupDomNodes["btnGotoStore"];
  const containerNode = cepPopupDomNodes["containerNode"];

  if (btnGotoStore.length > 0) {
    Object.keys(btnGotoStore).forEach((i) => {
      btnGotoStore[i].addEventListener("click", () => {
        e.preventDefault();
        hideNode(containerNode);
      });
    });
  }
}

function hideNode(node) {
  node.classList.add("cep-popup-hidden");
}

function showNode(node) {
  node.classList.remove("cep-popup-hidden");
}

function setLoadingState({ status = "pending" }) {
  if (status === "pending") {
    setNotice({ message: "Aguarda...." });
  }

  if (status === "success") {
    setNotice({ message: "" });
  }

  if (status === "rejected") {
    setNotice({ message: "Occoreu um erro" });
  }
}

function setNotice({ type = "info", message = "" }) {
  const noticeArea = cepPopupDomNodes["noticeArea"];

  if (noticeArea) {
    noticeArea.innerText = message;
  }

  if (type === "info") {
    noticeArea.classList.add("cep-notice-info");
  }

  if (type === "warning") {
    noticeArea.classList.add("cep-notice-warning");
  }

  if (type === "error") {
    noticeArea.classList.add("cep-notice-error");
  }
}

function doNotRemindMe() {
  const doNotRemindMe = cepPopupDomNodes["doNotRemindMe"];
  const containerNode = cepPopupDomNodes["containerNode"];

  if (doNotRemindMe) {
    doNotRemindMe.addEventListener("click", (e) => {
      e.preventDefault();
      hideNode(containerNode);
      setCookie("cepDoNotRemindMe", "yes", 30);
    });
  }
}

function setCookie(cname, cvalue, exdays) {
  const d = new Date();
  d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
  let expires = "expires=" + d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
  let name = cname + "=";
  let ca = document.cookie.split(";");
  for (let i = 0; i < ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == " ") {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function checkCookie() {
  let user = getCookie("username");
  if (user != "") {
    alert("Welcome again " + user);
  } else {
    user = prompt("Please enter your name:", "");
    if (user != "" && user != null) {
      setCookie("username", user, 365);
    }
  }
}
