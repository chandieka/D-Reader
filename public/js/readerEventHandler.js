window.addEventListener('load', () => {
    if (typeof pages !== 'undefined' && typeof paginator !== 'undefined' && typeof gallery !== 'undefined'){
        let pageImage = document.querySelector('#reader-page');
        let pagePosition = document.querySelectorAll('.reader-position');
        let pageCounter = document.querySelectorAll('.reader-counter');
        let nextButton = document.querySelectorAll('.reader-next');
        let previousButton = document.querySelectorAll('.reader-previous');
        let lastButton = document.querySelectorAll('.reader-last');
        let firstButton = document.querySelectorAll('.reader-first');

        function changePage(src, element) {
            // change the image
            element.src = src;
            element.alt = "page " + paginator.currentPage;

            // change the URL
            let newURL = window.location.protocol + "//" + window.location.host + paginator.resource + paginator.currentPage;
            let newTitle = "D-Reader - " + gallery.title + " - Page " + paginator.currentPage;
            history.pushState("page " + paginator.currentPage, newTitle, newURL);
        }

        function NextPage() {
            if (paginator.currentPage + 1 <= paginator.totalPages) {
                paginator.currentPage += 1;
                pageCounter.forEach((element) => {
                    element.innerText = paginator.currentPage;
                })
                let src = "/" + pages[paginator.currentPage - 1].filename; // temp solutions
                changePage(src, pageImage);
                console.log("Next page");
            }
        }

        function previousPage() {
            if (paginator.currentPage - 1 > 0) {
                paginator.currentPage -= 1;
                pageCounter.forEach((element) => {
                    element.innerText = paginator.currentPage;
                })
                let src = "/" + pages[paginator.currentPage - 1].filename; // temp solutions
                changePage(src, pageImage);
                console.log("Previous page");
            }
        }

        pageImage.addEventListener('click', (e) => {
            let pageWidth = pageImage.offsetWidth;
            let rect = e.target.getBoundingClientRect();
            let x = e.clientX - rect.left; //x position within the element.
            let y = e.clientY - rect.top;  //y position within the element.

            if (x > pageWidth / 2) {
                // go to next page
                NextPage();
            }
            else {
                // go to previous page
                previousPage();
            }
        });

        nextButton.forEach((element) => {
            element.addEventListener('click', (e) => {
                NextPage();
            });
        });

        previousButton.forEach((element) => {
            element.addEventListener('click', (e) => {
                previousPage();
            });
        });

        lastButton.forEach((element) => {
            element.addEventListener('click', (e) => {
                paginator.currentPage = paginator.totalPages;
                pageCounter.forEach((element) => {
                    element.innerText = paginator.currentPage;
                })
                let src = "/" + pages[paginator.currentPage - 1].filename; // temp solutions
                changePage(src, pageImage);
            });
        })

        firstButton.forEach((element) => {
            element.addEventListener('click', (e) => {
                paginator.currentPage = 1;
                pageCounter.forEach((element) => {
                    element.innerText = paginator.currentPage;
                })
                let src = "/" + pages[paginator.currentPage - 1].filename; // temp solutions
                changePage(src, pageImage);
                console.log("Previous page");
            });
        });
    }
    else {
        console.error('Error: list of page is missing!!');
    }
})

