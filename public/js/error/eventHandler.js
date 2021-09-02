window.addEventListener('load', (e) => {
    let errors = document.querySelectorAll('.error');
    if (typeof errors !== 'undefined') {
        for (let i = 0; i < errors.length; i++) {
            let error = errors[i];
            // get the close button
            let closeButton = error.lastElementChild;
            closeButton.addEventListener('click', () => {
                // remove parent when click
                error.remove();
            })
        }
    }
})
