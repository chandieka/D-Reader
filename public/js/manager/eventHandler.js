window.addEventListener("load", (e) => {
    let form = document.querySelector('#form-delete');
    let formButtons = document.querySelectorAll('.form-delete-button');

    formButtons.forEach(element => {
        element.addEventListener('click', (j) => {
            j.preventDefault()

            if (confirm("WARNING!!! This action will permanently delete the item")){
                form.submit();
            }
        })
    });
});
