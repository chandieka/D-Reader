/*
    this is where generic/global event is handle which mean that on every page it will have the callbacks assigned
    to the appropiate event for each respective Elements
*/
window.addEventListener('load', (e) => {
    // add your event callback here
    navAccDropdown();
    accDropDown();
    standardDropDown();
})

function navAccDropdown() {
    let dropElement = document.getElementById('nav-dropdown-btn');
    dropElement.addEventListener('click', (j) => {
        let el = document.querySelector('.collapse');
        el.classList.toggle('open');
        j.stopPropagation();
    })
}

function accDropDown() {
    let subDropdownBtn = document.querySelector('.acc-dropbtn');
    subDropdownBtn.addEventListener('click', (j) => {
        let dropContent = document.querySelector('.acc-dropdown-content');
        dropContent.classList.toggle('open');
        if (dropContent.classList.contains('open')){
            window.addEventListener('click', (k) => {
                let dropContent = document.querySelector('.acc-dropdown-content');
                if (!k.target.matches('.acc-dropbtn')) {
                    if (dropContent.classList.contains('open')) {
                        dropContent.classList.remove('open');
                    }
                }
            }, { once: true });
        }
        j.stopPropagation();
    });

    document.querySelector('.acc-dropdown-content').addEventListener('click', (j) => {
        j.stopPropagation();
    })
}

function standardDropDown() {
    let subDropdownBtn = document.querySelector('.dropbtn');
    subDropdownBtn.addEventListener('click', (j) => {
        let dropContent = document.querySelector('.dropdown-content');
        dropContent.classList.toggle('open');
        if (dropContent.classList.contains('open')) {
            window.addEventListener('click', (k) => {
                let dropContent = document.querySelector('.dropdown-content');
                if (!k.target.matches('.dropbtn')) {
                    if (dropContent.classList.contains('open')) {
                        dropContent.classList.remove('open');
                    }
                }
            }, { once: true });
        }
        j.stopPropagation();
    });

    document.querySelector('.dropdown-content').addEventListener('click', (j) => {
        j.stopPropagation();
    })
}
