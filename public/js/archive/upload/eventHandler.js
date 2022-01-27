import { utils } from './../../lib/Utils.js'

window.addEventListener('load', () => {
    let addFileButton = document.querySelector('.form-file-button');
    let formFiles = document.querySelector('.form-files');

    addFileButton.addEventListener('click', (e) => {
        e.preventDefault();

        // let fileInput = document.createElement('input');
        // fileInput.type = 'file';
        // fileInput.className = 'hidden';
        // fileInput.name = 'file[]';

        // fileInput.addEventListener('change', () => {
        //     let label = document.createElement('label');
        //     label.htmlFor = 'form-file';
        //     label.className = 'form-file p-sm mr-sm mb-sm';
        //     label.innerHTML = fileInput.files[0].name;

        //     formFiles.insertAdjacentElement("afterbegin", label);
        //     formFiles.append(fileInput);
        // })

        // fileInput.click(); // fire open file picker dialog

    });
});
