// DOM elements to variables
const login = document.getElementById("registrationForm");
const email = document.getElementById("email");
const password = document.getElementById("password");


login.addEventListener("submit", function(event) {

    // Reset background colors first
    email.style.backgroundColor = "";
    password.style.backgroundColor = "";

    // --- Validation like in assignment 6 and products JS---
    if (!email.value.trim()) {
        event.preventDefault();
        alert("Email is required");
        email.focus();
        email.style.backgroundColor = "red";
        return;
    }

    const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/i;
    if (!emailPattern.test(email.value)) {
        event.preventDefault();
        alert("Enter a valid email address");
        email.focus();
        email.style.backgroundColor = "red";
        return;
    }

    if (!password.value.trim()) {
        event.preventDefault();
        alert("Password is required");
        password.focus();
        password.style.backgroundColor = "red";
        return;
    }

});