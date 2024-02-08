const inputs = document.getElementById("inputs");
let msg = document.getElementById("error_msg");

inputs.addEventListener("input", function (e) {
  const target = e.target;
  const val = target.value;
  if (isNaN(val)) {
    console.log(1);
    target.value = "";
    return;
  }

  if (val != "") {
    console.log(2);
    const next = target.nextElementSibling;
    if (next) {
      console.log(3);
      next.focus();
    }
  }
});

inputs.addEventListener("keyup", function (e) {
  const target = e.target;
  const key = e.key.toLowerCase();

  if (key == "backspace" || key == "delete") {
    target.value = "";
    const prev = target.previousElementSibling;
    if (prev) {
      prev.focus();
    }
    return;
  }
});