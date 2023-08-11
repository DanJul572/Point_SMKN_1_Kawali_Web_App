
//sticky navbar
window.addEventListener('scroll', () => {
    let nav = document.querySelector('nav');
    nav.classList.toggle('sticky', window.scrollY > 0);
});

//burger
const menuBtn = document.querySelector('.menu-btn');
const menu = document.querySelector('.menu');
let menuOpen = false;
menuBtn.addEventListener('click', () => {
    if (!menuOpen) {
        menuBtn.classList.add('open');
        menu.classList.add('slide');
        menuOpen = true;
    } else {
        menuBtn.classList.remove('open');
        menu.classList.remove('slide');
        menuOpen = false;
    }
});

