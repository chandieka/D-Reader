export class TabBar {

    /**
     *
     * @param {HTMLElement} tabBtn
     * @param {HTMLElement} tabBtnContainer
     * @param {HTMLElement} tabContent
     * @param {HTMLElement} tabContentContainer
     */
    constructor(tabBtn, tabBtnContainer, tabContent, tabContentContainer) {
        this.tabBtn = tabBtn;
        this.tabBtnContainer = tabBtnContainer;

        this.tabContent = tabContent;
        this.tabContentContainer = tabContentContainer;
        this.tabBarHandler();
    }

    show() {
        Array.from(this.tabBtnContainer.children).forEach(element => {
            element.classList.remove('selected');
        });
        this.tabBtn.classList.add('selected');

        Array.from(this.tabContentContainer.children).forEach(element => {
            element.classList.remove('show');
        })
        this.tabContent.classList.add('show');
    }

    tabBarHandler() {
        this.tabBtn.addEventListener('click', e => {
            this.show();
        })
    }
}
