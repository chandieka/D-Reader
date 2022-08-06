import Utils from "../lib/Utils.js";

window.addEventListener('load', () => {
    let inputFileElement = document.querySelector('.archive-files');
    let container = document.querySelector('.form-file-collection');
    let totalFilesElement = document.querySelector('#total-files');
    let totalFilesizeElement = document.querySelector('#total-filesize');
    let fileHandler = {
        files: [],
        totalBytes: 0,
        totalFiles: 0
    }

    function updateInfo() {
        totalFilesElement.innerText = fileHandler.totalFiles;
        totalFilesizeElement.innerText = Utils.bytesToSize(fileHandler.totalBytes);
        console.log(fileHandler.totalBytes);
    }

    function error(message) {
        console.log(message);
    }

    document.querySelector('.form-file-add').addEventListener('click', async (e) => {
        e.preventDefault();
        inputFileElement.click();
    });

    document.querySelector('#btn-upload').addEventListener('click', (e) => {
        e.preventDefault();

        if (fileHandler.totalFiles > 500000000) {
            return error('Total filesize exceed the upload limit');
        }

        if (fileHandler.totalFiles == 0 || fileHandler.totalBytes == 0) {
            return error('No file is selected');
        }

        document.querySelector('#form-upload').submit();
    });

    document.querySelector('.archive-files').addEventListener('change', (e) => {
        container.innerHTML = ''; // clean the UI
        fileHandler.files = Array.from(e.target.files);
        fileHandler.files.forEach(file => {
            fileHandler.totalBytes += file.size;
        });
        fileHandler.totalFiles = fileHandler.files.length;

        for (let i = 0; i < fileHandler.files.length; i++) {
            const file = fileHandler.files[i];

            let template = `
                <div class="form-file-item center mr-sm ml-sm" data-file-id="${i}">
                    <div class="form-file-item-icon">
                        <i class="fas fa-file fa-6x"></i>
                    </div>
                    <div class="font-sm mb-sm bold mr-xsm ml-xsm">
                        ${ Utils.stringShortener(file.name, 60) }
                    </div>
                    <div class="p-sm form-file-item-info">
                        <span>
                            <span class="font-sm bold">Filesize: </span><span class="font-sm">${Utils.bytesToSize(file.size)}</span>
                        </span>
                        <span>
                            <span class="font-sm bold">Type: </span><span class="font-sm">${file.name.split('.').pop()}</span>
                        </span>
                    </div>
                    <button class="form-file-item-remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>`;

            let element = Utils.createElementFromHTML(template);

            element.querySelector('.form-file-item-remove').addEventListener('click', () => {
                const index = fileHandler.files.indexOf(fileHandler.files[element.dataset.fileId]);
                if (index > -1) {
                    let deletedFile = fileHandler.files.splice(index, 1);

                    let data = new DataTransfer();

                    fileHandler.files.forEach(file => {
                        data.items.add(file);
                    });

                    inputFileElement.files = data.files;
                    fileHandler.totalBytes -= deletedFile[0].size;
                    fileHandler.totalFiles -= 1;

                    element.remove();
                    updateInfo();
                }
            });

            container.appendChild(element);
        }
        updateInfo();
    });
});
