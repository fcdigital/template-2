import { getScrollbarWidth } from './utils.js';

const nav = () => {

	/* Открытие и закрытие навигации */

	const body = document.querySelector('body');
	const navToggle = document.querySelector('.header__nav-toggle');
	const nav = document.querySelector('.nav');
	const menuIcon = document.querySelector('.header__nav-icon');

	let scrollbarCurrentWidth;

	navToggle.onclick = () => {

		nav.classList.toggle('nav--open');
		menuIcon.classList.toggle('header__nav-icon--active');

		scrollbarCurrentWidth = getScrollbarWidth();

		if (nav.classList.contains('nav--open')) {
			if (window.getComputedStyle(body).marginRight === '0px') {
				body.style.marginRight = `${scrollbarCurrentWidth}px`;
			} else {
				body.style.marginRight = '0px';
			}

			document.body.classList.toggle('no-scroll');
		} else {
			setTimeout(() => {
				if (window.getComputedStyle(body).marginRight === '0px') {
					body.style.marginRight = `${scrollbarCurrentWidth}px`;
				} else {
					body.style.marginRight = '0px';
				}

				document.body.classList.toggle('no-scroll');
			}, 200);
		}
	};

	/* Реализация выпадающего списка для разделов навигации */

	let navLinkWithSubmenu = document.querySelectorAll('.nav__column-1 a:has(+ .sub-menu)');

	navLinkWithSubmenu.forEach((navLink) => {
		let arrow = document.createElement('span');
		arrow.classList.add('nav__arrow');
		navLink.appendChild(arrow);

		arrow.addEventListener('click', (event) => {
			event.preventDefault();
			let navItem = navLink.closest('li');

			navItem.querySelector('.sub-menu').classList.toggle('nav__show');
			arrow.classList.toggle('nav__arrow--rotate')
		})
	})
}

export default nav;