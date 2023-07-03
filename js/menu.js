'use strict';
function hamburgermenu(m) {
  m.classList.toggle("change");
}
let navbar = document.querySelector(".navbar")
 let ham = document.querySelector(".ham")
 function toggleHamburger(){
   navbar.classList.toggle("showNav")
   ham.classList.toggle("showClose")
 }
 ham.addEventListener("click", toggleHamburger)
 let mobilemenu = document.querySelector('.mobile')