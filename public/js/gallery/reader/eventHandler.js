const imagePreloaderPromise = import('./ImagePreloader.js'); // this does work
// const imagePreloaderPromise = import('./ImagePreloader'); // this doesn't work


window.addEventListener('load', () => {
    if (typeof pages !== 'undefined' && typeof paginator !== 'undefined' && typeof gallery !== 'undefined') {
        const pageImageContainer = document.querySelector('.reader-img')
        const pageImage = document.querySelector('#reader-page');
        const pagePosition = document.querySelectorAll('.reader-position');
        const pageCounter = document.querySelectorAll('.reader-counter');
        const nextButton = document.querySelectorAll('.reader-next');
        const previousButton = document.querySelectorAll('.reader-previous');
        const lastButton = document.querySelectorAll('.reader-last');
        const firstButton = document.querySelectorAll('.reader-first');
        // Preloader
        let imagePreloader;

        function scrollToTop(element){
            element.scrollIntoView();
        }

        function updateImage(src) {
            // delete the old img element
            pageImageContainer.innerHTML = "";
            // create new img with the new src
            let imgObj = new Image();
            imgObj.src = src;
            imgObj.alt = `page ${paginator.currentPage}`;
            imgObj.id = 'reader-page'
            imgObj.className += "point";
            // add event lisnter
            changePageOnClickListner(imgObj);

            // add to the document
            pageImageContainer.insertAdjacentElement('afterbegin', imgObj)
            scrollToTop(imgObj);
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

            // update img
            updateImage(src, pageImage);

            // update the URL & push a new browser history
            const newURL = `${window.location.protocol}//${window.location.host}${paginator.resource}${paginator.currentPage}`;
            const newTitle = `${gallery.title} - Page ${paginator.currentPage} - D-Reader`;
            document.title = newTitle; // change it in DOM

            history.pushState(`page ${paginator.currentPage}`, newTitle, newURL);

            // fire preload for the next
            imagePreloader?.setCurrentPage(paginator.currentPage - 1);
        }

        function updatePaginatorLinks(pageNumber){
            // Update the links for "previous button"
            if (pageNumber - 1 != 0){ // if the page number is not 1
                previousButton.forEach(element => {
                    element.href = `${window.location.protocol}//${window.location.host}${paginator.resource}${paginator.currentPage - 1}`;
                });
            }
            else {
                previousButton.forEach(element => {
                    element.href = `${window.location.protocol}//${window.location.host}${paginator.resource}1`;
                });
            }

            // Update the links for "Next button"
            if (pageNumber + 1 <= paginator.totalPages){ // if the page number is at less than maximum number of page
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
            const newPage = paginator.currentPage + 1;
            if (paginator.currentPage + 1 <= paginator.totalPages) {
                updatePaginatorLinks(newPage);
                changeToPage(newPage);
            }
        }

        function previousPage() {
            const newPage = paginator.currentPage - 1;
            if (newPage > 0) {
                updatePaginatorLinks(newPage);
                changeToPage(newPage);
            }
        }

        function changePageOnClickListner(element) {
            element.addEventListener('click', (e) => {
                // determine if the user is on the right or the left area of the image
                e.preventDefault();

                const pageWidth = element.offsetWidth;
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
        }

        // attach a click event on the first image
        changePageOnClickListner(pageImage);

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
            // pages and gallery var is a const, define in reader.blade.php
            imagePreloader = new ImagePreloader(pages, gallery);
            imagePreloader.setCurrentPage(paginator.currentPage - 1);
        })
        .catch((err) => console.log('Was unable to load the image preloader module', err)
        );
        // imagePreloader = new ImagePreloader(pages, gallery);
        // imagePreloader.setCurrentPage(paginator.currentPage - 1);
    }
});
