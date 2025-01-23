import { getScrollbarWidth } from "./utils.js";

const modal = () => {
    const body = document.querySelector('body');
    const consultationButton = document.querySelector('.consultation-button');
    const modal = document.querySelector('.modal');
    const modalClose = document.querySelector('.modal__close');

    let scrollbarCurrentWidth;

    consultationButton.onclick = () => {
        modal.classList.add('modal--open');
        scrollbarCurrentWidth = getScrollbarWidth();
        modal.style.paddingRight = `${scrollbarCurrentWidth}px`;
        body.style.marginRight = `${scrollbarCurrentWidth}px`;
        body.classList.add('no-scroll');
    }

    modalClose.onclick = () => {
        modal.classList.remove('modal--open');
        body.classList.remove('no-scroll');
        body.style.marginRight = '0px';
        modal.style.paddingRight = '0px';
        
        const form = document.getElementById('form-consultation');
        if (form) {
            form.reset();
        }
    }
}

export default modal;