window.addEventListener('load', (e) => {
    let errors = document.querySelectorAll('.error');
    if (typeof errors !== 'undefined') {
        for (let i = 0; i < errors.length; i++) {
            const error = errors[i];
            // get the close button
            let closeButton = error.childNodes[1];

            closeButton.addEventListener('click', () => {
                // remove parent when click
                error.remove();
            })
        }
    }
})
