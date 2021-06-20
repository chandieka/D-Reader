
/**
* Do form Submit from a given id
*
* @param {string} $id
*/
function formSubmit(id) {
    document.getElementById(id).submit();
}

/**
* Add a Class of "open" to an element with an id of "dropDown"
*
*/
function showMenu() {
    let dropElement = document.getElementById('nav-dropDown');
    if (dropElement.className == 'collapse') {
        dropElement.className += ' open';
    }
    else {
        dropElement.className = 'collapse';
    }
}



