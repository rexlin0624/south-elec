function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}

function modifyPdfDownloadUrl() {
    var g = getUrlParameter('g') - 0;
    var pdfa = $('.downloads').find('a');
    var href = pdfa.attr('href');
    var href_new = href.replace('pdf/', 'pdf/' + (g === 1 ? 'g/' : 'ng/'));
    pdfa.attr('href', href_new);
}

window.onload = function() {
    modifyPdfDownloadUrl();
};