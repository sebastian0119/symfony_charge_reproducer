/**
 * WORKAROUND:
 * Setting XHR header manually, so that Symfony controller identifies FETCH as xmlHttpRequest
 */
const myXhrHeader = new Headers();
myXhrHeader.append('Content-Type', 'text/plain');
myXhrHeader.append('X-Requested-With', 'XMLHttpRequest');

/**
 * Do a FETCH request (similar to AJAX GET)
 * @param {String} url     - URL where the request is directed to, including GET parameters (e.g. name=xyz&city=abc)
 * @param {String} target  - element where the content of the response is inserted into
 */

async function tableFetch(url, target) {
    const data = await fetch(url, {
        method: 'GET',
        headers: myXhrHeader,
    })
    .then(response => response.text())
    .then(data => {
        document.getElementById(target).innerHTML = data;
    }).catch(err => {
        document.getElementById(target).innerHTML = '<p>Server response error</p>';
    });
}