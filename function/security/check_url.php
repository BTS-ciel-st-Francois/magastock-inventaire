require('././config/config.php');

    // check if the URL is valid and belongs to the website
function check_url($url) {
    global $website_url;
    // parse the URL and get the host
    $parsed_url = parse_url($url);
    if ($parsed_url === false) {
        return false;
    }
    $host = $parsed_url['host'] ?? '';
    // check if the host is the same as the website URL
    if ($host === parse_url($website_url, PHP_URL_HOST)) {
        return true;
    }
    return false;
}
