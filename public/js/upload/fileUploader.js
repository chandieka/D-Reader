import Utils from "../lib/Utils.js";

document.querySelector('.file-upload').addEventListener('click', (e) => {
    e.preventDefault();
    const xhr = new XMLHttpRequest();

    let file = document.querySelector('#file').files[0];
    let token = document.querySelector('.form-upload').elements._token.value;
    let formData = new FormData();
    formData.append('file', file);
    formData.append('_token', token);

    xhr.addEventListener('load', function(e) {
        let response = JSON.parse(xhr.response);
        console.log(xhr.response);
    });

    let previousBytes = 0;
    xhr.upload.onprogress = (event) => {
        previousBytes = event.loaded - previousBytes;
        let speed = Utils.bytesToSize(previousBytes)

        console.log(`Speed: ${speed}/s Uploaded: ${event.loaded} of ${event.total} bytes`);
    }

    xhr.open('POST', "http://dreader.test/test/upload");
    xhr.send(formData);
});

