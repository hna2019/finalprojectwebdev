// Search JS

const search = document.getElementById("search");
const searchInput = document.getElementById("searchinput");

search.addEventListener("submit", function(event) {

    searchInput.style.backgroundColor = "";

    // makes sure user entered something
    if (!searchInput.value.trim()) {
        event.preventDefault();
        alert("Please enter a search term");
        searchInput.focus();
        searchInput.style.backgroundColor = "red";
        return;
    }

});


// SHOPPING CART JS

const prices = {
    pikachu: 18.00,
    charmander: 15.00,
    bulbasaur: 15.00,
    squirtle: 15.00,
    willcall: 0.00,
    shipping: 10.00
};

const form = document.getElementById("shopping_cart");
const q0 = document.getElementById("q0");
const q1 = document.getElementById("q1");
const q2 = document.getElementById("q2");
const q3 = document.getElementById("q3");
const pricePikachu = document.getElementById("price_pikachu");
const priceCharmander = document.getElementById("price_charmander");
const priceBulbasaur = document.getElementById("price_bulbasaur");
const priceSquirtle = document.getElementById("price_squirtle");
const willcall = document.getElementById("willcall");
const shipping = document.getElementById("shipping");
const grandTotal = document.getElementById("grand_total");

q0.addEventListener("change", total);
q1.addEventListener("change", total);
q2.addEventListener("change", total);
q3.addEventListener("change", total);
shipping.addEventListener("change", total);
willcall.addEventListener("change", total);

function total() {
    let qPikachu = parseInt(q0.value);
    if (isNaN(qPikachu)) qPikachu = 0;

    let qCharmander = parseInt(q1.value);
    if (isNaN(qCharmander)) qCharmander = 0;

    let qBulbasaur = parseInt(q2.value);
    if (isNaN(qBulbasaur)) qBulbasaur = 0;

    let qSquirtle = parseInt(q3.value);
    if (isNaN(qSquirtle)) qSquirtle = 0;

    const subtotalPikachu = qPikachu * prices.pikachu;
    const subtotalCharmander = qCharmander * prices.charmander;
    const subtotalBulbasaur = qBulbasaur * prices.bulbasaur;
    const subtotalSquirtle = qSquirtle * prices.squirtle;

    pricePikachu.innerText = subtotalPikachu;
    priceCharmander.innerText = subtotalCharmander;
    priceBulbasaur.innerText = subtotalBulbasaur;
    priceSquirtle.innerText = subtotalSquirtle;

    let shippingCost = 0;
    if (shipping.checked){
        shippingCost = prices.shipping;
    } else{
        shippingCost = prices.willcall;
    }

    const totalPrice = subtotalPikachu + subtotalCharmander + subtotalBulbasaur + subtotalSquirtle + shippingCost;
    grandTotal.innerText = totalPrice;
}

form.addEventListener("submit", function(event){
    receipt(event);
});

function receipt(event){
    const name = document.getElementById("name");
    const email = document.getElementById("email");
    const address = document.getElementById("address");
    const phone = document.getElementById("phone");
    const zip = document.getElementById("zip");
    const credit = document.getElementById("credit");

    /* --- Ensures Required Fields Are Filled --- */
    if (!name.value){
        event.preventDefault();
        alert("Name is required");
        name.focus();
        name.select();
        name.style.backgroundColor = "red";
        return;
    }
    if (!email.value){
        event.preventDefault();
        alert("Email is required");
        email.focus();
        email.select();
        email.style.backgroundColor = "red";
        return;
    }
    if (!address.value){
        event.preventDefault();
        alert("Address is required");
        address.focus();
        address.select();
        address.style.backgroundColor = "red";
        return;
    }
    if (!phone.value){
        event.preventDefault();
        alert("Phone number is required");
        phone.focus();
        phone.select();
        phone.style.backgroundColor = "red";
        return;
    }
    const zipPattern = /^\d{5}$/;
    if (!zipPattern.test(zip.value)) {
        event.preventDefault();
        alert("Zip code must be exactly 5 digits");
        zip.focus();
        zip.select();
        zip.style.backgroundColor = "red";
        return;
    }
    if (!credit.value){
        event.preventDefault();
        alert("Credit card info is required");
        credit.focus();
        credit.select();
        credit.style.backgroundColor = "red";
        return;
    }
}

form.addEventListener("reset", function(){
    q0.value = "";
    q1.value = "";
    q2.value = "";
    q3.value = "";
    pricePikachu.innerText = "0.00";
    priceCharmander.innerText = "0.00";
    priceBulbasaur.innerText = "0.00";
    priceSquirtle.innerText = "0.00";
    grandTotal.innerText = "0.00";
    shipping.checked = false;
});

