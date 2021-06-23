window.addEventListener('load', () => {
    if (typeof pages !== 'undefined' && typeof paginator !== 'undefined' && typeof gallery !== 'undefined') {
        const pageImage = document.querySelector('#reader-page');
        const pagePosition = document.querySelectorAll('.reader-position');
        const pageCounter = document.querySelectorAll('.reader-counter');
        const nextButton = document.querySelectorAll('.reader-next');
        const previousButton = document.querySelectorAll('.reader-previous');
        const lastButton = document.querySelectorAll('.reader-last');
        const firstButton = document.querySelectorAll('.reader-first');

        function updateImage(src, element) {
            // change the image
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
            const src = `/${pages[paginator.currentPage - 1].filename}`; // temp solutions

            // update img src
            updateImage(src, pageImage);

            // update the URL & push a new browser history
            const newURL = `${window.location.protocol}//${window.location.host}${paginator.resource}${paginator.currentPage}`;
            const newTitle = `D-Reader - ${gallery.title} - Page ${paginator.currentPage}`;
            document.title = newTitle; // change it in DOM
            history.pushState(`page ${paginator.currentPage}`, newTitle, newURL);
        }

        function updatePaginatorLinks() {
            if (paginator.currentPage === 1) {
                previousButton.forEach((element) => {
                    element.href = `${window.location.protocol}//${window.location.host}${paginator.resource}${paginator.currentPage - 1}`;
                });
            }

            nextButton.forEach((element) => {
                element.href = `${window.location.protocol}//${window.location.host}${paginator.resource}${paginator.currentPage + 1}`;
            });
        }

        function nextPage() {
            if (paginator.currentPage + 1 <= paginator.totalPages) {
                const newPage = paginator.currentPage + 1;
                updatePaginatorLinks();
                changeToPage(newPage);
            }
        }

        function previousPage() {
            const newPage = paginator.currentPage - 1;

            if (newPage > 0) {
                updatePaginatorLinks();
                changeToPage(newPage);
            }
        }

        pageImage.addEventListener('click', (e) => {
            e.preventDefault();

            const pageWidth = pageImage.offsetWidth;
            const rect = e.target.getBoundingClientRect();
            const x = e.clientX - rect.left; // x position within the element.

            if (x > pageWidth / 2) {
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
                changeToPage(paginator.currentPage);
            });
        });

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
                const pageNumber = prompt('Move to page?');
                if (pageNumber <= paginator.totalPages && pageNumber > 0 && !isNaN(pageNumber)) {
                    paginator.currentPage = pageNumber;
                    changeToPage(paginator.currentPage);
                }
            });
        });
    }
});
