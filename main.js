document.getElementById('year').textContent = new Date().getFullYear();

const menuBtn = document.querySelector('.menu-button');
const nav = document.querySelector('nav.primary');

menuBtn.addEventListener('click', () => {
    nav.style.display = nav.style.display === 'flex' ? 'none' : 'flex';
});
