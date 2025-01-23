const descrSwitches = document.querySelectorAll('.service-description__item');
const descrTypes = document.querySelectorAll('.banners__item');
const descrTypesList = document.querySelector('.banners__list');

const onDescrSwitchClick = () => {
    for (let i = 0; i < descrSwitches.length; i++) {
        descrSwitches[0].classList.add('service-description__item--current');
        descrTypes[0].classList.add('banners__item--current');

        descrSwitches[i].addEventListener('click', () => {

            descrSwitches.forEach((descrSwitch) => {
                if (descrSwitch.classList.contains('service-description__item--current')) {
                    descrSwitch.classList.remove('service-description__item--current');
                }
            });
            descrSwitches[i].classList.add('service-description__item--current');

            let heightDescrTypesList = window.getComputedStyle(descrTypesList).height; // сохраняем в переменную высоту списка элементов до переключения

            descrTypes.forEach((descrType) => {
                if (descrType.classList.contains('banners__item--current')) {
                    descrType.classList.remove('banners__item--current');

                    descrTypesList.style.height = heightDescrTypesList; // задаем высоту списку элементов такой, какая она была до переключения
                }
            });
            descrTypes[i].classList.add('banners__item--current');

            let heightCurrentDescrTypes = window.getComputedStyle(descrTypes[i].children[0]).height; // определяем высоту того элемента списка, который на данный момент является видимым. А так как высота этого элемента увеличивается не сразу (аннимировано), то бурем его дочерний элемент.

            setTimeout(() => {
                descrTypesList.style.height = heightCurrentDescrTypes;
            }, 200) // списку задаем высоту как высота выбранного текущего элемента списка

            window.addEventListener('resize', () => {
                let newheightCurrentDescrTypes = document.querySelector('.banners__item--current').style.height;
                if (newheightCurrentDescrTypes !== heightCurrentDescrTypes) {
                    descrTypesList.style.height = newheightCurrentDescrTypes;
                }
            }) // при изменении ширины экрана меняется высота блоков с контентом
        })


    }
}

onDescrSwitchClick();


