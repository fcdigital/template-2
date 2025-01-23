import Swiper from 'swiper';
import { Navigation } from 'swiper/modules';
import 'swiper/css/navigation';

/* About slider */

const swiperAbout = new Swiper('.swiperAbout', {
    // Optional parameters
    direction: 'horizontal',
    speed: 500,
    loop: true,

    modules: [Navigation],
});

const slides = document.querySelectorAll('.slider-about__item');
const controls = document.querySelector('.slider-about__controls');
const buttonPrevAbout = controls.querySelector(".slider-about__control--prev");
const buttonNextAbout = controls.querySelector(".slider-about__control--next");

buttonPrevAbout.addEventListener('click', () => {
    swiperAbout.slidePrev();
});

buttonNextAbout.addEventListener('click', () => {
    swiperAbout.slideNext();
});

/* Убираем кнопки управления для слайдера мобильной версии при количестве слайдов меньше 2-х */

if (slides.length < 2) {
    controls.style.display = 'none';
}