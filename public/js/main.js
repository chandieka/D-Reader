/**
* Do form Submit from a given id
*
* @param {string} $id
*/
function formSubmit(id) {
    document.getElementById(id).submit();
}


window.addEventListener('load', (e) => {
    let dropElement = document.getElementById('nav-dropdown-btn');
    dropElement.addEventListener('click', (e) => {
        let el = document.querySelector('.collapse');
        if (el.className == 'collapse') {
            el.className += ' open';
        }
        else {
            el.className = 'collapse';
        }
    })

    let subDropdown = document.querySelector('.acc-dropdown');
    subDropdown.addEventListener('click', (e) => {
        console.log(subDropdown.className);
        if (subDropdown.className == 'acc-dropdown') {
            subDropdown.className += ' open';
        }
        else {
            subDropdown.className = 'acc-dropdown';
        }
    });
})



