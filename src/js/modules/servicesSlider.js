import Swiper from 'swiper';
import { Navigation } from 'swiper/modules';
import 'swiper/css/navigation';

/* Services slider */

const slider = document.querySelector('.services-directory__mobile-slider');
const sliderWrapper = slider.querySelector('.services-directory__list');
const slides = sliderWrapper.querySelectorAll('.services-directory__item');

const controls = document.querySelector('.services-directory__mobile-controls');
const buttonPrevServices = controls.querySelector(".services-directory__mobile-control--prev");
const buttonNextServices = controls.querySelector(".services-directory__mobile-control--next");

const swiperServices = new Swiper('.swiperServices', {
    // Optional parameters
    direction: 'horizontal',
    speed: 500,
    // loop: true,

    modules: [Navigation],
});

buttonPrevServices.addEventListener('click', () => {
    swiperServices.slidePrev();
});

buttonNextServices.addEventListener('click', () => {
    swiperServices.slideNext();
});

/* Убираем кнопки управления для слайдера мобильной версии при количестве слайдов меньше 2-х */

if (slides.length < 2) {
    controls.style.display = 'none';
}

/* Функция для удаления классов swiper */

const removeSwiperClasses = (items, className) => {
    let allHaveClass = true;
    items.forEach(item => {
        if (!item.classList.contains('swiper-slide')) {
            allHaveClass = false;
            return; // Если хотя бы один элемент не содержит класс .swiper-slide, завершаем цикл
        }
    });

    if (slider.classList.contains('swiper') && slider.classList.contains(`${className}`)) {
        slider.classList.remove('swiper', `${className}`);
    };
    if (sliderWrapper.classList.contains('swiper-wrapper')) {
        sliderWrapper.classList.remove('swiper-wrapper');
        sliderWrapper.style.transform = '';
    };

    if (allHaveClass) {
        items.forEach(item => {
            item.classList.remove('swiper-slide');
            item.style.width = 'auto';
        })
    }
}

/* Функция для добавления классов swiper */

const addSwiperClasses = (items, className) => {
    let allHaveClass = true;
    items.forEach(item => {
        if (!item.classList.contains('swiper-slide')) {
            allHaveClass = false;
            return; // Если хотя бы один элемент не содержит класс .swiper-slide, завершаем цикл
        }
    });

    if (!slider.classList.contains('swiper') && !slider.classList.contains(`${className}`)) { slider.classList.add('swiper', `${className}`) };
    if (!sliderWrapper.classList.contains('swiper-wrapper')) { sliderWrapper.classList.add('swiper-wrapper') };

    if (!allHaveClass) {
        items.forEach(item => {
            item.classList.add('swiper-slide');
        })
    }
}

if (window.innerWidth >= 1600) {
    removeSwiperClasses(slides, 'swiperServices');
}

const handleViewportChange = (items, className) => {
    // Получаем текущую ширину вьюпорта
    const viewportWidth = window.innerWidth;

    if (viewportWidth < 1600) {
        window.addEventListener('resize', () => {
            const newViewportWidth = window.innerWidth;
            if (newViewportWidth >= 1600) {
                removeSwiperClasses(items, className);
                handleViewportChange(items, className);
            }
        })
    } else {
        window.addEventListener('resize', () => {
            const newViewportWidth = window.innerWidth;
            if (newViewportWidth < 1600) {

                addSwiperClasses(items, className);
                handleViewportChange(items, className);
            }
        })
    }
}

handleViewportChange(slides, 'swiperServices');
