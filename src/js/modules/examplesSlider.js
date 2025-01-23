import Swiper from 'swiper';
import { Navigation } from 'swiper/modules';
import 'swiper/css/navigation';

/* Examples slider */

const slider = document.querySelector('.examples__mobile-slider');


if (slider) {
    const sliderWrapper = slider.querySelector('.examples__list');
    const slides = sliderWrapper.querySelectorAll('.examples__item');

    const controls = document.querySelector('.examples__mobile-controls');
    const buttonPrevExamples = controls.querySelector('.examples__mobile-control--prev');
    const buttonNextExamples = controls.querySelector('.examples__mobile-control--next');

    const swiperExamples = new Swiper('.swiperExamples', {
        // Optional parameters
        direction: 'horizontal',
        speed: 500,

        modules: [Navigation],
    });

    buttonPrevExamples.addEventListener('click', () => {
        swiperExamples.slidePrev();
    });

    buttonNextExamples.addEventListener('click', () => {
        swiperExamples.slideNext();
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
        removeSwiperClasses(slides, 'swiperExamples');
    }

    /* Функция, добавляющая swiper при изменении ширины вьюпорта с >= 1600 px на < 1600 px, и убирающая его при изменении с < 1600 px на >= 1600 px */

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

    handleViewportChange(slides, 'swiperExamples');
}

