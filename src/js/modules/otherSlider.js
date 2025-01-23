import Swiper from 'swiper';
import { Navigation } from 'swiper/modules';
import 'swiper/css/navigation';

/* Other slider */

const swiperOther = new Swiper('.swiperOther', {
    // Optional parameters
    direction: 'horizontal',
    speed: 500,
    loop: true,
    breakpoints: {
        1600: {
            slidesPerView: 3,
        }
    },

    modules: [Navigation],
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
});

const wrapper = document.querySelector('.other__list');
const slides = document.querySelectorAll('.other__item');
const controls = document.querySelector('.other__controls');
const buttonPrevOther = controls.querySelector('.other__control--prev');
const buttonNextOther = controls.querySelector('.other__control--next');

buttonPrevOther.addEventListener('click', () => {
    swiperOther.slidePrev();
});

buttonNextOther.addEventListener('click', () => {
    swiperOther.slideNext();
});

/* Убираем кнопки управления для слайдера мобильной версии при количестве слайдов меньше 2-х и слайдера дестопной версии при количестве слайдов меньше 4-х */

if (window.innerWidth < 1600) {
    if (slides.length < 2) {
        controls.style.display = 'none';
    }
} else {
    if (slides.length < 4) {
        controls.style.display = 'none';
        wrapper.style.justifyContent = 'center';
    }
}

const removeSwiperOtherControls = () => {
    if (window.innerWidth < 1600) {
        if (slides.length < 2 && controls.style.display !== 'none') {
            controls.style.display = 'none';
        }
        if (slides.length >= 2 && controls.style.display !== 'flex') {
            controls.style.display = 'flex';
        }
    } else {
        if (slides.length < 4 && controls.style.display !== 'none') {
            controls.style.display = 'none';
            wrapper.style.justifyContent = 'center';
        }
    }

    window.addEventListener('resize', () => {
        removeSwiperOtherControls();
    })
}

removeSwiperOtherControls();
