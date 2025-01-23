let menuLinkWithSubmenu = document.querySelectorAll('.menu--full a:has(+ .sub-menu)');

/* Реализация выпадающего списка для разделов бокового меню */

menuLinkWithSubmenu.forEach((menuLink) => {
    let arrow = document.createElement('span');
    arrow.classList.add('menu__arrow');
    menuLink.appendChild(arrow);

    arrow.addEventListener('click', (event) => {
        event.preventDefault();
        let menuItem = menuLink.closest('li');
    
        menuItem.querySelector('.sub-menu').classList.toggle('menu__show');
        arrow.classList.toggle('menu__arrow--rotate')
    })
})

