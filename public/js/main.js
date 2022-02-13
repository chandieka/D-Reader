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

/**
 * Check if the input string is empty or whitespace or null
 *
 * @param {String} str
 */
function isEmptyOrSpaces(str) {
    return str === null || str.match(/^ *$/) !== null;
}
