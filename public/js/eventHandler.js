import { TabBar } from "./lib/TabBar.js";
import { TagHandler } from "./lib/TagHandler.js";

/*
this is where generic/global event is handle which mean that on every page it will have the callbacks assigned
to the appropiate event
*/
window.addEventListener('load', (e) => {
    // add your global event callback here
    navAccDropdown();
    accDropDown();
    standardDropDown();
    new TagHandler(document.querySelector('#test-tag'), 'tags');
    new TabBar(
        document.querySelector('.gallery-meta-option-tags'),
        document.querySelector('.gallery-meta-options'),
        document.querySelector('.gallery-meta-selection-tags'),
        document.querySelector('.gallery-meta-selections'),
    );
    new TabBar(
        document.querySelector('.gallery-meta-option-details'),
        document.querySelector('.gallery-meta-options'),
        document.querySelector('.gallery-meta-selection-details'),
        document.querySelector('.gallery-meta-selections'),
    );
    reloadOnPopstate();
    jumpToPage();
});

function navAccDropdown() {
    let dropElement = document.getElementById('nav-dropdown-btn');
    dropElement.addEventListener('click', (j) => {
        let el = document.querySelector('.collapse');
        el.classList.toggle('open');
        j.stopPropagation();
    })
}

function accDropDown() {
    document.querySelectorAll('.acc-dropbtn').forEach(element => {
        element.addEventListener('click', (j) => {
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
    });

    document.querySelectorAll('.acc-dropdown-content').forEach((element) => {
        element.addEventListener('click', (j) => {
            j.stopPropagation();
        })
    })
}

function standardDropDown() {
    document.querySelectorAll('.dropbtn').forEach(element => {
        element.addEventListener('click', (j) => {
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
    });

    document.querySelectorAll('.dropdown-content').forEach((element) => {
        element.addEventListener('click', (j) => {
            j.stopPropagation();
        })
    })
}

function reloadOnPopstate() {
    window.addEventListener('popstate', (e) => {
        window.location.reload();
    });
}

function jumpToPage() {
    let element = document.querySelector('.page-jump');
    if (element != null){
        element.addEventListener('click', (e) => {
            let page = window.prompt("Jump to page?");
            if (page != null && page > 0){
                window.location.href = window.location.origin + "/?page=" + page;
            }
        });
    }
}

function fadeOut() {
    let elements = document.querySelectorAll('.fade-out');
    Array.from(elements).forEach(el => {
        el.addEventListener(e => {
            el.style.opacity = '0';
            setTimeout(() => {
                el.remove();
            }, 500);
        })
    })
}
