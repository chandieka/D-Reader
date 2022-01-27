export default class Utils {
    /**
     * Shorten the text to n amount of character
     * @param {string} text
     * @param {string} lenght
     * @returns string
     */
    stringShortener(text, lenght) {
        let shortenText = "";

        if (text.lenght <= lenght) {
            return text; // do nothing
        } else {
            shortenText = text.substring(0, lenght) + '...';
            return shortenText;
        }
    }

    test() {
        var yourString = "The quick brown fox jumps over the lazy dog"; //replace with your string.
        var maxLength = 20 // maximum number of characters to extract

        //trim the string to the maximum length
        var trimmedString = yourString.substring(0, maxLength);

        //re-trim if we are in the middle of a word
        trimmedString = trimmedString.substring(0, Math.min(trimmedString.length, trimmedString.lastIndexOf(" ")))
        return trimmedString;
    }
}
