// TODO: Make sure that the appropriate caching headers are sent by the server when requesting these images

export default class ImagePreloader {

    static #forwardCacheSize = 3;
    static #backCacheSize = 1;
    #pages;
    #gallery;
    constructor(pages, gallery) {
        this.#pages = pages;
        this.#gallery = gallery
    }

    setCurrentPage(pageIndex) {
        this._preload(pageIndex - ImagePreloader.#backCacheSize, pageIndex + ImagePreloader.#forwardCacheSize);
    }

    _preload(startIndex, endIndex) {
        const pages = this.#pages.slice(Math.max(0, startIndex), endIndex);
        const path = `/assets/galleries/${this.#gallery.dir_path}`; // kinda bad

        (function loadNextImage() {
            const image = pages.pop();

            if (!image) {
                return;
            }

            const img = new Image();

            img.src = `${path}/${image.filename}`;
            img.onload = () => loadNextImage();
        })();
    }
}