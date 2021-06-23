window.addEventListener('load', () => {
    if (typeof pages !== 'undefined' && typeof paginator !== 'undefined' && typeof gallery !== 'undefined'){
        let pageImage = document.querySelector('#reader-page');
        let pageCounter = document.querySelectorAll('.reader-counter')
        let pagePosition = document.querySelectorAll('.reader-position');
        let nextButton = document.querySelectorAll('.reader-next');
        let previousButton = document.querySelectorAll('.reader-previous');
        let lastButton = document.querySelectorAll('.reader-last');
        let firstButton = document.querySelectorAll('.reader-first');


        function updateImage(src, element) {
            // change the image src
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
            updateImage(src, pageImage);

            // update the URL & push a new browser history
            let newURL = window.location.protocol + "//" + window.location.host + paginator.resource + paginator.currentPage;
            let newTitle = "D-Reader - " + gallery.title + " - Page " + paginator.currentPage;
            document.title = newTitle; // change it in DOM
            history.pushState("page " + paginator.currentPage, newTitle, newURL);

            console.log('p: ' + paginator.currentPage);
        }

        function updatePaginatorLinks(pageNumber){
            let previousPageNumber = pageNumber - 1;
            // only when change the links if its not in the 1st index
            if (previousPageNumber != 0){
                previousButton.forEach(element => {
                    element.href = window.location.protocol + "//" + window.location.host + paginator.resource + previousPageNumber;
                });
            }
            else {
                previousButton.forEach(element => {
                    element.href = window.location.protocol + "//" + window.location.host + paginator.resource + 1;
                });
            }

            let nextPageNumber = pageNumber + 1;
            // change when its not more than totalpages
            if (nextPageNumber <= paginator.totalPages){
                nextButton.forEach(element => {
                    element.href = window.location.protocol + "//" + window.location.host + paginator.resource + nextPageNumber;
                });
            }
            else {
                nextButton.forEach(element => {
                    element.href = window.location.protocol + "//" + window.location.host + paginator.resource + paginator.totalPages;
                });
            }
        }

        function NextPage() {
            if (paginator.currentPage + 1 <= paginator.totalPages) {
                let newPage = paginator.currentPage + 1;
                updatePaginatorLinks(newPage);
                changeToPage(newPage);
            }
        }

        function previousPage() {
            if (paginator.currentPage - 1 > 0) {
                let newPage = paginator.currentPage - 1;
                updatePaginatorLinks(newPage);
                changeToPage(newPage);
            }
        }

        pageImage.addEventListener('click', (e) => {
            // determine if the user is on the right or the left area of the image
            e.preventDefault();
            let pageWidth = pageImage.offsetWidth;
            let rect = e.target.getBoundingClientRect();
            let x = e.clientX - rect.left; //x position within the element.
            let y = e.clientY - rect.top;  //y position within the element.

            if (x > pageWidth / 2) {
                NextPage();
            }
            else {
                previousPage();
            }
        });

        nextButton.forEach((element) => {
            element.addEventListener('click', (e) => {
                e.preventDefault();
                NextPage();
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
        })

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
                let pageNumber = prompt("Move to page?");
                if (pageNumber <= paginator.totalPages && pageNumber > 0 && !isNaN(pageNumber)){
                    paginator.currentPage = pageNumber;
                    updatePaginatorLinks(paginator.currentPage);
                    changeToPage(paginator.currentPage);
                }
            })
        })
    }
})

