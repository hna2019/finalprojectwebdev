/* --- Used for opening and closing the navigation menu on mobile --- */

let svg = document.querySelector(".svg");
let nav = document.querySelector("#navigation");
let isOpen = false;

svg.addEventListener("click", menu);

    
function menu(){
    
    if (isOpen) {
        isOpen = false;
        nav.style.display = "none";
    } else {
        isOpen = true;
        nav.style.display = "flex";
    }
                
}

window.addEventListener('resize', function() {
    if (window.innerWidth > 768) {
        nav.style.display = ''; 
        isOpen = false;
    }
});