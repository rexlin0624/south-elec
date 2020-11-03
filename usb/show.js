var PRODUCTS = {products};
var PROPERTIES = {properties};
var map_series_title = {
    6: '4.0',
    7: '5.0',
    8: '6.0'
};

function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}

function getData() {
    var id = getUrlParameter('id') - 0;
    var g = getUrlParameter('g') - 0;
    var product = PRODUCTS[id];

    var product_thumb = product.thumb.substr(1);
    $('#title').html(product.title);
    $('#thumb').attr('src', product_thumb);
    $('#thumb_a').attr('href', product_thumb);
    var series_id = map_series_title[product.series_id];
    var properties = PROPERTIES[series_id];
    var product_code = product.code;
    var pdf_download = 'pdf/g/' + product_code + '.pdf';
    if (g === 0) {
        product_code = product_code.substr(0, 12);
        pdf_download = 'pdf/ng/' + product_code + '.pdf';
    } else {
        product_code = product_code.substr(0, 12) + '.J';
    }
    $('#pdf_download').attr('href', pdf_download);

    var property = [
        '<tr style="line-height: 30px;"><td>产品编码</td><td class="right" id="product_code">', product_code ,'</td></tr>',
    ];
    var prop;
    $.each(properties, function(key, value) {
        prop = value.options[product[key]];
        if (key === 'military_standard') {
            prop = g === 0 ? '-' : '国军标';
        }

        property.push(
            '<tr style="line-height: 30px;">',
            '<td>', value.title ,'</td>',
            '<td class="right" id="', key ,'">', prop ,'</td>',
            '</tr>'
        );
    });
    $('#property').html(property.join(''));
}

window.onload = function() {
    getData();
};