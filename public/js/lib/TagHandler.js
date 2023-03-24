import Utils from "./Utils.js";

export class TagHandler {
    /**
    *
    * @param {HTMLInputElement} textInput
    * @param {String} valueName
    */
    constructor(textInput, valueName) {
        this.textInput = textInput;
        this.valueName = valueName;

        this.tagList = [];
        this.tagInputHandler();
    }

    createTag(value) {
        let tagTemplate = `
            <label class="tag-group">
                <span class="tag-description">${ value }</span>
                <input type="text" class="tag-value" name="${this.valueName}[]" value="${ value }">
                <span class="tag-delete">x</span>
            </label>
        `;

        let tagElement = Utils.createElementFromHTML(tagTemplate);
        tagElement.querySelector('.tag-delete').addEventListener('click', (e) => {
            e.target.parentElement.remove();
        })

        return tagElement;
    }

    /**
     * attach the event listener and its callback
     *
     */
    tagInputHandler(){
        // add the tag by pressing enter if input value is not empty
        if (this.textInput != null) {
            this.textInput.addEventListener('keypress', (e) => {
                if (e.key == "Enter") {
                    e.preventDefault();
                    if (!Utils.isEmptyOrSpaces(e.target.value)){
                        let nwTag = this.createTag(e.target.value);
                        if (e.target.insertAdjacentElement('beforebegin', nwTag)) {
                            e.target.value = ''; // reset after tag is added
                            this.tagList.push(nwTag);
                        }
                    }
                    return false;
                }
            })
            // Remove tag on backspace if there's nothing on the input
            this.textInput.addEventListener('keydown', (e) => {
                if (e.key == 'Backspace' && Utils.isEmptyOrSpaces(e.target.value)) {
                    e.preventDefault();
                    let tag = this.tagList.pop();
                    if (tag != null) {
                        tag.remove();
                    }
                    return false;
                }
            })
        }
    }
}
