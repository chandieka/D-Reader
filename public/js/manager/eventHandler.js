window.addEventListener("load", (e) => {
    let form = document.querySelector('#form-delete');
    let formButton = document.querySelector('.form-delete-button');

    formButton.addEventListener('click', (j) => {
        j.preventDefault()

        if (confirm("WARNING!!! This action will permanently delete the item")){
            form.submit();
        }
    })
});
