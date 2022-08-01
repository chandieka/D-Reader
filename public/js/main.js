/**
 * Global accessible variable, class, function and etc should be implement here
 *
 *
 *
 */

/**
 * submit form by id
 *
 * @param {string} id
 */
function formSubmit(id) {
    document.getElementById(id).submit();
}


function reset(elementId) {
    document.querySelector(elementId).value = "";
}
