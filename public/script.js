function togglePasswordVisibility(inputId) {
  const input = document.getElementById(inputId);
  const icon = event.target;

  if (input.type === "password") {
    input.type = "text";
    icon.textContent = "🙈";
  } else {
    input.type = "password";
    icon.textContent = "👁️";
  }
}
