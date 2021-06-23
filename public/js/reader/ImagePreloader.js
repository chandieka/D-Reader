// TODO: Make sure that the appropriate caching headers are sent by the server when requesting these images

export default class ImagePreloader {

    static #forwardCacheSize = 3;
    static #backCacheSize = 1;

    #pages;

    constructor(pages) {
        this.#pages = pages;
    }

    setCurrentPage(pageIndex) {
        this._preload(pageIndex - ImagePreloader.#backCacheSize, pageIndex + ImagePreloader.#forwardCacheSize);
    }

    _preload(startIndex, endIndex) {
        const pages = this.#pages.slice(Math.max(0, startIndex), endIndex);

        (function loadNextImage() {
            const image = pages.pop();

            if (!image) {
                return;
            }

            const img = new Image();

            img.src = `/${image.filename}`;
            img.onload = () => loadNextImage();
        })();
    }
}