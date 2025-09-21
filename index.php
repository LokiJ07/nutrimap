<?php
// Load your landing page
require __DIR__ . '/landing_page/home.php';
?>

<script>
// Auto-fill email if "Remember Me" was previously checked
window.addEventListener("DOMContentLoaded", function () {
    const savedEmail = localStorage.getItem("rememberedEmail");
    if (savedEmail) {
        const emailInput = document.querySelector("input[name='email']");
        const rememberCheckbox = document.querySelector("input[name='remember']");
        if (emailInput) emailInput.value = savedEmail;
        if (rememberCheckbox) rememberCheckbox.checked = true;
    }
});

document.querySelector("form")?.addEventListener("submit", async function(e) {
    e.preventDefault(); // Prevent full page reload

    const formData = new FormData(this);
    const rememberMe = this.querySelector("input[name='remember']")?.checked;

    // Save email in localStorage if "Remember Me" is checked, else clear it
    const emailInput = this.querySelector("input[name='email']");
    if (rememberMe && emailInput) {
        localStorage.setItem("rememberedEmail", emailInput.value);
    } else {
        localStorage.removeItem("rememberedEmail");
    }

    try {
        const response = await fetch("login_api.php", {
            method: "POST",
            body: formData
        });

        const result = await response.json();

        if (result.success) {
            alert(result.message);
            window.location.href = result.redirect; // Redirect to OTP page
        } else {
            alert(result.message);
        }
    } catch (error) {
        console.error("Login API error:", error);
        alert("Something went wrong. Please try again.");
    }
});
</script>
