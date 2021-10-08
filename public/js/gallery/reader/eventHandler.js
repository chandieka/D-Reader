const imagePreloaderPromise = import('./ImagePreloader');

window.addEventListener('load', () => {
    if (typeof pages !== 'undefined' && typeof paginator !== 'undefined' && typeof gallery !== 'undefined') {
        const pageImage = document.querySelector('#reader-page');
        const pagePosition = document.querySelectorAll('.reader-position');
        const pageCounter = document.querySelectorAll('.reader-counter');
        const nextButton = document.querySelectorAll('.reader-next');
        const previousButton = document.querySelectorAll('.reader-previous');
        const lastButton = document.querySelectorAll('.reader-last');
        const firstButton = document.querySelectorAll('.reader-first');

        let imagePreloader;

        function scrollToTop(){
            document.querySelector("#reader").scrollIntoView();
        }

        function updateImage(src, element) {
            // change the image src
            element.src = src;
            element.alt = `page ${paginator.currentPage}`;
        }

        function changeToPage(pageNumber) {
            // change the paginator index
            paginator.currentPage = pageNumber;

            // update the page number on the paginator counter
            pageCounter.forEach((element) => {
                element.innerText = paginator.currentPage;
            });

            // prepare the new image
            const storagePath = '/assets/galleries/';
            const src = `${window.location.protocol}//${window.location.host}${storagePath}${gallery.dir_path}/${pages[paginator.currentPage - 1].filename}`; // temp solutions

            // update img src
            updateImage(src, pageImage);

            // update the URL & push a new browser history
            const newURL = `${window.location.protocol}//${window.location.host}${paginator.resource}${paginator.currentPage}`;
            const newTitle = `D-Reader - ${gallery.title} - Page ${paginator.currentPage}`;
            document.title = newTitle; // change it in DOM

            history.pushState(`page ${paginator.currentPage}`, newTitle, newURL);

            imagePreloader?.setCurrentPage(paginator.currentPage - 1);
        }

        function updatePaginatorLinks(pageNumber){
            // only change when the links if its not in the 1st index
            if (pageNumber - 1 != 0){
                previousButton.forEach(element => {
                    element.href = `${window.location.protocol}//${window.location.host}${paginator.resource}${paginator.currentPage - 1}`;
                });
            }
            else {
                previousButton.forEach(element => {
                    element.href = `${window.location.protocol}//${window.location.host}${paginator.resource}1`;
                });
            }

            // change when its not more than totalpages
            if (pageNumber + 1 <= paginator.totalPages){
                nextButton.forEach(element => {
                    element.href = `${window.location.protocol}//${window.location.host}${paginator.resource}${paginator.currentPage + 1}`;
                });
            }
            else {
                nextButton.forEach(element => {
                    element.href = `${window.location.protocol}//${window.location.host}${paginator.resource}${paginator.totalPages}`;
                });
            }
        }


        function nextPage() {
            if (paginator.currentPage + 1 <= paginator.totalPages) {
                const newPage = paginator.currentPage + 1;
                updatePaginatorLinks(newPage);
                scrollToTop();
                changeToPage(newPage);
            }
        }

        function previousPage() {
            const newPage = paginator.currentPage - 1;

            if (newPage > 0) {
                updatePaginatorLinks(newPage);
                scrollToTop();
                changeToPage(newPage);
            }
        }

        pageImage.addEventListener('click', (e) => {
            // determine if the user is on the right or the left area of the image
            e.preventDefault();

            const pageWidth = pageImage.offsetWidth;
            const rect = e.target.getBoundingClientRect();
            const x = e.clientX - rect.left; // x position within the element.
            if (x > pageWidth * 0.4) {
                // go to next page
                nextPage();
            } else {
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
                updatePaginatorLinks(paginator.currentPage);
                changeToPage(paginator.currentPage);
            });
        });

        firstButton.forEach((element) => {
            element.addEventListener('click', (e) => {
                e.preventDefault();
                paginator.currentPage = 1;
                updatePaginatorLinks(paginator.currentPage);
                changeToPage(paginator.currentPage);
            });
        });

        pagePosition.forEach((element) => {
            element.addEventListener('click', (e) => {
                e.preventDefault();
                const pageNumber = prompt('Move to page?');
                if (pageNumber <= paginator.totalPages && pageNumber > 0 && !isNaN(pageNumber)) {
                    paginator.currentPage = pageNumber;
                    updatePaginatorLinks(paginator.currentPage);
                    changeToPage(paginator.currentPage);
                }
            })
        });

        // preload the image for the 1st time
        // and define the imagePreloader object as well
        imagePreloaderPromise.then(({ default: ImagePreloader }) => {
                imagePreloader = new ImagePreloader(pages, gallery);
                imagePreloader.setCurrentPage(paginator.currentPage - 1);
            })
            .catch((err) => console.log('Was unable to load the image preloader module', err)
            );
    }
});
