/**
 * Performs a get request
 *
 * @param url
 * @returns {Promise}
 */
export default function getRequest(url) {

    return new Promise(function(resolve, reject) {
        var request = new XMLHttpRequest();
        request.open('GET', url);

        request.onload = function() {
            if (this.status === 200) {
                resolve(this.response);
                return true;
            }
            reject(Error(this.statusText));
            return false;

        };

        request.onerror = function() {
            reject(Error("Network Error"));
        };

        request.send();

    });
}