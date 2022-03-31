let searchBtn = document.querySelector('#search-btn');
let searchBar = document.querySelector('.search-bar-container');
let formBtn = document.querySelector('#login-btn');
let loginForm = document.querySelector('.login-form-container');
let formClose = document.querySelector('#form-close');
let menu = document.querySelector('#menu-bar');
let navbar = document.querySelector('.navbar');

//search butonu
searchBtn.addEventListener('click', () =>{
    searchBtn.classList.toggle('fa-times');
    searchBar.classList.toggle('active');
});
//sign in sayfaysı pop up
formBtn.addEventListener('click', () =>{
    loginForm.classList.add('active');
});
//sign in kapatma
formClose.addEventListener('click', () =>{
    loginForm.classList.remove('active');
});