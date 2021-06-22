const imagePreloaderPromise = import('./ImagePreloader.js');

window.addEventListener('load', () => {
    if (typeof pages !== 'undefined' && typeof paginator !== 'undefined' && typeof gallery !== 'undefined') {
        let pageImage = document.querySelector('#reader-page');
        let pagePosition = document.querySelectorAll('.reader-position');
        let pageCounter = document.querySelectorAll('.reader-counter');
        let nextButton = document.querySelectorAll('.reader-next');
        let previousButton = document.querySelectorAll('.reader-previous');
        let lastButton = document.querySelectorAll('.reader-last');
        let firstButton = document.querySelectorAll('.reader-first');
        let imagePreloader;

        function updateImage(src, element) {
            // change the image
            element.src = src;
            element.alt = "page " + paginator.currentPage;
        }

        function changeToPage(pageNumber) {
            // change the paginator index
            paginator.currentPage = pageNumber;

            // update the page number on the paginator counter
            pageCounter.forEach((element) => {
                element.innerText = paginator.currentPage;
            })

            // prepare the new image
            const src = "/" + pages[paginator.currentPage - 1].filename; // temp solutions

            // update img src
            updateImage(src, pageImage);

            // update the URL & push a new browser history
            const newURL = paginator.resource + paginator.currentPage;
            const newTitle = "D-Reader - " + gallery.title + " - Page " + paginator.currentPage;
            document.title = newTitle; // change it in DOM
            history.pushState("page " + paginator.currentPage, newTitle, newURL);

            imagePreloader?.setCurrentPage(paginator.currentPage - 1);
        }

        function updatePaginatorLinks() {
            if (paginator.currentPage == 1) {
                let previousPage = paginator.currentPage - 1;
                previousButton.forEach(element => {
                    element.href = paginator.resource + previousPage;
                });
            }

            if (paginator.currentPage != paginator.currentPage) {
                let nextPage = paginator.currentPage + 1;
                nextButton.forEach(element => {
                    element.href = paginator.resource + nextPage;
                });
            }
        }

        function nextPage() {
            if (paginator.currentPage + 1 <= paginator.totalPages) {
                let newPage = paginator.currentPage + 1;
                updatePaginatorLinks();
                changeToPage(newPage);
            }
        }

        function previousPage() {
            if (paginator.currentPage - 1 > 0) {
                let newPage = paginator.currentPage - 1;
                updatePaginatorLinks();
                changeToPage(newPage);
            }
        }

        pageImage.addEventListener('click', (e) => {
            e.preventDefault();
            let pageWidth = pageImage.offsetWidth;
            let rect = e.target.getBoundingClientRect();
            let x = e.clientX - rect.left; //x position within the element.
            let y = e.clientY - rect.top;  //y position within the element.

            if (x > pageWidth / 2) {
                // go to next page
                nextPage();
            }
            else {
                // go to previous page
                previousPage();
            }
        });

        nextButton.forEach((element) => {
            element.addEventListener('click', (e) => {
                e.preventDefault();
                nextPage();
            });
        });

        previousButton.forEach((element) => {
            element.addEventListener('click', (e) => {
                e.preventDefault();
                previousPage();
            });
        });

        lastButton.forEach((element) => {
            element.addEventListener('click', (e) => {
                e.preventDefault();
                paginator.currentPage = paginator.totalPages;
                changeToPage(paginator.currentPage);
            });
        })

        firstButton.forEach((element) => {
            element.addEventListener('click', (e) => {
                e.preventDefault();
                paginator.currentPage = 1;
                changeToPage(paginator.currentPage);
            });
        });

        pagePosition.forEach((element) => {
            element.addEventListener('click', (e) => {
                e.preventDefault();
                let pageNumber = prompt("Move to page?");
                if (pageNumber <= paginator.totalPages && pageNumber > 0 && !isNaN(pageNumber)) {
                    paginator.currentPage = pageNumber;
                    changeToPage(paginator.currentPage);
                }
            })
        });

        imagePreloaderPromise
            .then(({ default: ImagePreloader }) => {
                imagePreloader = new ImagePreloader(pages);
                imagePreloader.setCurrentPage(paginator.currentPage - 1);
            })
            .catch((err) => console.log('Was unable to load the image preloader module', err))
    }
});
