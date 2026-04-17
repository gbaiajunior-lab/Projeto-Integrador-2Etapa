function showMsg(success, message) {
  const el = document.getElementById("msg");
  if (!el) return;

  el.classList.remove("d-none", "alert-success", "alert-danger");
  el.classList.add(success ? "alert-success" : "alert-danger");
  el.innerText = message;
}

function escapeQuotes(str) {
  if (!str) return "";
  return str.replace(/'/g, "\\'").replace(/"/g, '\\"');
}
