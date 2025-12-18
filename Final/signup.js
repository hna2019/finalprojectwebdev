// DOM elements to variables
const signupForm = document.getElementById("registrationForm");
const firstName = document.getElementById("firstName");
const lastName = document.getElementById("lastName");
const email = document.getElementById("email");
const phone = document.getElementById("phone");
const password = document.getElementById("password");

signupForm.addEventListener("submit", function(event) {

    // Reset background colors first
    firstName.style.backgroundColor = "";
    lastName.style.backgroundColor = "";
    email.style.backgroundColor = "";
    phone.style.backgroundColor = "";
    password.style.backgroundColor = "";

    // --- Validation like in assignment 6 and products JS---
    if (!firstName.value.trim()) {
        // Prevent default if something is wrong so the form isn't submitted
        event.preventDefault();
        // Get the user's attention
        alert("First Name is required");
        firstName.focus();
        firstName.style.backgroundColor = "red";
        return;
    }

    if (!lastName.value.trim()) {
        event.preventDefault();
        alert("Last Name is required");
        lastName.focus();
        lastName.style.backgroundColor = "red";
        return;
    }

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
        alert("Input a Password");
        password.focus();
        password.style.backgroundColor = "red";
        return;
    }


    if (!phone.value.trim()) {
        event.preventDefault();
        alert("Phone number is required");
        phone.focus();
        phone.style.backgroundColor = "red";
        return;
    }

    const phonePattern = /^\d{3}-\d{3}-\d{4}$/;
    if (!phonePattern.test(phone.value)) {
        event.preventDefault();
        alert("Phone number must be in the format 123-456-7890");
        phone.focus();
        phone.style.backgroundColor = "red";
        return;
    }

});