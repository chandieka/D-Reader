export default class Utils {
    /**
    * Shorten the text to n amount of character
    * @param {string} text
    * @param {string} lenght
    * @returns string
    */
    static stringShortener(text, lenght) {
        let shortenText = "";

        if (text.lenght <= lenght) {
            return text; // do nothing
        } else {
            shortenText = text.substring(0, lenght).trim() + '...';
            return shortenText;
        }
    }

    static bytesToSize(bytes) {
        var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        if (bytes == 0) return '0 Byte'
        var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        return Math.round(bytes / Math.pow(1024, i)) + ' ' + sizes[i];
    }

    /**
    * Check if the input string is empty or whitespace or null
    *
    * @param {String} str
    */
    static isEmptyOrSpaces(str) {
        return str === null || str.match(/^ *$/) !== null;
    }

    static createElementFromHTML(htmlString) {
        var div = document.createElement('div');
        div.innerHTML = htmlString.trim();

        // Change this to div.childNodes to support multiple top-level nodes.
        return div.firstChild;

    }
}
