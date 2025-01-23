import Swiper from 'swiper';
import { Navigation } from 'swiper/modules';
import 'swiper/css/navigation';

/* Main slider */

const swiperMain = new Swiper('.swiperMain', {
    // Optional parameters
    direction: 'horizontal',
    speed: 500,
    loop: true,

    modules: [Navigation],
});

const slides = document.querySelectorAll('.slider-main__item');
const controls = document.querySelector('.slider-main__controls');
const buttonPrevMain = controls.querySelector('.slider-main__control--prev');
const buttonNextMain = controls.querySelector('.slider-main__control--next');

buttonPrevMain.addEventListener('click', () => {
    swiperMain.slidePrev();
});

buttonNextMain.addEventListener('click', () => {
    swiperMain.slideNext();
});

/* Убираем кнопки управления для слайдера мобильной версии при количестве слайдов меньше 2-х */

if (slides.length < 2) {
    controls.style.display = 'none';
}
