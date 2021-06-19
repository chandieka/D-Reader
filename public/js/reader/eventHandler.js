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
        }

        function changeToPage(pageNumber) {
            // change the paginator index
            paginator.currentPage = pageNumber;

            // update the page number on the paginator counter
            pageCounter.forEach((element) => {
                element.innerText = paginator.currentPage;
            })

            // prepare the new image
            let src = "/" + pages[paginator.currentPage - 1].filename; // temp solutions

            // update img src
            changePage(src, pageImage);

            // update the URL & push a new browser history
            let newURL = window.location.protocol + "//" + window.location.host + paginator.resource + paginator.currentPage;
            let newTitle = "D-Reader - " + gallery.title + " - Page " + paginator.currentPage;
            document.title = newTitle; // change it in DOM
            history.pushState("page " + paginator.currentPage, newTitle, newURL);
        }

        function NextPage() {
            if (paginator.currentPage + 1 <= paginator.totalPages) {
                changeToPage(paginator.currentPage + 1);
            }
        }

        function previousPage() {
            if (paginator.currentPage - 1 > 0) {
                changeToPage(paginator.currentPage - 1);
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
                changeToPage(paginator.currentPage);
            });
        })

        firstButton.forEach((element) => {
            element.addEventListener('click', (e) => {
                paginator.currentPage = 1;
                changeToPage(paginator.currentPage);
            });
        });

        pagePosition.forEach((element) => {
            element.addEventListener('click', (e) => {
                let pageNumber = prompt("Move to page?");
                if (!isNaN(pageNumber)) {
                    paginator.currentPage = pageNumber;
                    changeToPage(paginator.currentPage);
                }
            })
        })
    }
    else {
        console.error('Error: list of page is missing!!');
    }
})

