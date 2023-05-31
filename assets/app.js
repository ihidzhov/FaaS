var FaaS = FaaS || {};

FaaS.save = (self) => {
  var data = new FormData();
  data.append("editorContent", editor.getValue());
  data.append("functionName", document.getElementById("function-name").value);
  if (functionID) {
    data.append("id", functionID);
  }
  data.append(
    "trigger",
    document.querySelector('input[name="trigger"]:checked').value
  );
  data.append(
    "triggerDetails",
    document.getElementById("trigger-details").value
  );

  fetch("index.php?action=api-save-func", {
    method: "POST",
    body: data,
  })
    .then(function (res) {
      return res.json();
    })
    .then(function (data) {
      if (!functionID) {
        window.location.href = "index.php?action=func&id=" + data?.data?.id;
      } else {
        // display message
      }
    });
};

FaaS.delete = () => {
  fetch("index.php?action=api-delete-func&id=" + functionID, {
    method: "DELETE",
  })
    .then(function (res) {
      return res.json();
    })
    .then(function (data) {
      window.location.href = "index.php?action=funcs";
    });
};

FaaS.getCodeSnippet = (id) => {
  fetch("index.php?action=api-function-code&id=" + id, {
    method: "GET",
  })
    .then(function (res) {
      return res.json();
    })
    .then(function (data) {
      editor.setValue(data.snippet);
    });
};

FaaS.getList = (params) => {
  fetch(
    "index.php?action=api-lambdas-table&" + new URLSearchParams(params.data),
    {
      method: "GET",
    }
  )
    .then(function (res) {
      return res.json();
    })
    .then(function (data) {
      params.success(data);
    });
};

FaaS.triggers = {
  onChange: (x) => {
    const elHttp = document.querySelector("#trigger-http");
    const elTime = document.querySelector("#trigger-time");

    elHttp.classList.remove("show");
    elHttp.classList.remove("hide");

    elTime.classList.remove("show");
    elTime.classList.remove("hide");
    if (x == 1) {
      elHttp.classList.add("show");
    } else {
      elTime.classList.add("show");
    }
  },
};

FaaS.updateConfig = () => {
  var jsp = JSON.parse(editor.getValue());
  fetch("index.php?action=api-update-config", {
    method: "PUT",
    body: JSON.stringify(jsp),
  })
    .then(function (res) {
      return res.json();
    })
    .then(function (data) {
      console.log(data);
    });
};
FaaS.getConfigCodeSnippet = () => {
  fetch("index.php?action=api-config-code", {
    method: "GET",
  })
    .then(function (res) {
      return res.json();
    })
    .then(function (data) {
      if (data.status == "success") {
        var json = JSON.parse(data.data);
        editor.setValue(JSON.stringify(json, null, 4));
      }
    });
};

FaaS.getLogs = (params) => {
  fetch("index.php?action=api-logs-table&" + new URLSearchParams(params.data), {
    method: "GET",
  })
    .then(function (res) {
      return res.json();
    })
    .then(function (data) {
      params.success(data);
    });
};

FaaS.updateUserPreferences = () => {
  let site_theme = JSON.parse(
    document.querySelector('input[name="site-theme"]:checked').value
  );

  fetch("index.php?action=api-update-upreferences", {
    method: "PUT",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ site_theme }),
  })
    .then(function (res) {
      return res.json();
    })
    .then(function (data) {
      console.log(data);
    });
};
