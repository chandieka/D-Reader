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
        let label, description, input, deleteBtn;

        label = document.createElement('label');
        description = document.createElement('span');
        input = document.createElement('input');
        deleteBtn = document.createElement('span');

        label.setAttribute('class', 'tag-group');

        description.setAttribute('class', 'tag-description');
        description.innerText = value;

        input.setAttribute('type', 'text')
        input.setAttribute('class', 'tag-value');
        input.setAttribute( 'name', `${this.valueName}[]`);
        input.setAttribute('value', value);

        deleteBtn.className = 'tag-delete';
        deleteBtn.innerText = 'x';

        label.insertAdjacentElement('afterbegin', deleteBtn);
        label.insertAdjacentElement('afterbegin', input);
        label.insertAdjacentElement('afterbegin', description);

        deleteBtn.addEventListener('click', (e) => {
            e.target.parentElement.remove();
        })

        return label;
    }

    /**
     * this function attach the event listner and its callback
     *
     */
    tagInputHandler(){
        // add the tag by pressing enter if input value is not empty
        if (this.textInput != null) {
            this.textInput.addEventListener('keypress', (e) => {
                if (e.key == "Enter") {
                    e.preventDefault();
                    if (!isEmptyOrSpaces(e.target.value)){
                        // console.log(this.createTag(e.target.value));
                        let nwTag = this.createTag(e.target.value);
                        if (e.target.insertAdjacentElement('beforebegin', nwTag)) {
                            e.target.value = ''; // reset after tag is added
                            this.tagList.push(nwTag);
                            console.log(this.tagList);
                        }
                    }
                    return false;
                }
            })
            // Remove tag on backspace if there's nothing on the input
            this.textInput.addEventListener('keydown', (e) => {
                if (e.key == 'Backspace' && isEmptyOrSpaces(e.target.value)) {
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
