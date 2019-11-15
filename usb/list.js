var PRODUCTS = {products};
var PROPERTIES = {properties};
var ARR_PDF_IDS = [];

String.prototype.allReplace = function(obj) {
    var retStr = this;
    for (var x in obj) {
        if (!obj.hasOwnProperty(x)) {
            continue;
        }

        retStr = retStr.replace(new RegExp(x, 'g'), obj[x]);
    }
    return retStr;
};

function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}

window.onload = function () {
    console.log(getUrlParameter('fid'));
};

function setSeFilter() {
    var filters = {};
    var temp_props = [], prop = {}, props = [];
    for (var key in PROPERTIES) {
        if (!PROPERTIES.hasOwnProperty(key)) {
            continue;
        }
        prop = PROPERTIES[key];
        temp_props.push('<tr><td class="attribute">' , prop['title'] , '：</td><td class="attribute_value">{' , key , '}</td></tr>');
        props.push(key);

        filters[key] = $('#' + key).val();
    }

    var template = [
        '<tr>',
            '<td>',
                '<div class="product_list_row">',
                    '<table>',
                        '<tbody>',
                            '<tr>',
                                '<td class="product_counter"><span>{index}</span></td>',
                                '<td><a href="{url}"><img src="{thumb}" width="48" height="36" alt="{title}" title="{title}" /></a></td>',
                                '<td class="clickable" rel="{url}" target="self">',
                                    '<a href="{url}"><em>{title}</em></a>',
                                    '<table class="attrList">',
                                        '<tbody>',
                                            '<tr>',
                                                '<td class="attribute" width="120">产品编码：</td>',
                                                '<td class="attribute_value">{code}</td>',
                                            '</tr>',
                                            temp_props.join(''),
                                        '</tbody>',
                                    '</table>',
                                '</td>',
                            '</tr>',
                        '</tbody>',
                    '</table>',
                '</div>',
            '</td>',
        '</tr>'
    ].join('');

    var items = PRODUCTS;

    // filter item
    var fn_condition = new Function('filters', 'item', 'if (Object.keys(filters).length === 0) { return true; } var condition = [];for (var filter in filters) { condition.push("item[\'" + filter + "\'] === \'" + filters[filter] + "\'"); } return condition.join(" && ");');
    var myfilter = {};
    var is_show_contact = false;
    for (var filter in filters) {
        if (!filters.hasOwnProperty(filter)) {
            continue;
        }
        if (filters[filter] === '-') {
            continue;
        }
        if (filters[filter] === 'Z') {
            is_show_contact = true;
            continue;
        }

        myfilter[filter] = filters[filter];
    }
    items = items.filter(function (item) { return eval(fn_condition(myfilter, item)); });

    if (is_show_contact) {
        $('#show-contact-engineer').show();
    } else {
        $('#show-contact-engineer').hide();
    }

    // 规则：系列-{前圈尺寸}{前圈/按键材料}{前圈/按键形状}{前圈/按键颜色}.{开关元件}{照明形式}{LED灯颜色}{LED灯电压}.{前圈/磁}{序列号}
    var selected_code = [
        filters['front_shape'] ? filters['front_shape'] : 'X',
        filters['front_button_material'] ? filters['front_button_material'] : 'X',
        filters['front_button_shape'] ? filters['front_button_shape'] : 'X',
        filters['front_button_color'] ? filters['front_button_color'] : 'X',
        '.',
        filters['switch_element'] ? filters['switch_element'] : 'X',
        filters['light_style'] ? filters['light_style'] : 'X',
        filters['led_color'] ? filters['led_color'] : 'X',
        filters['led_voltage'] ? filters['led_voltage'] : 'X',
        '.',
        filters['front_magnetic'] ? filters['front_magnetic'] : 'X'
    ].join('');
    document.getElementById('current-selected-code').innerHTML = selected_code;

    var html = [], item = {}, index = 1, replace = {}, j;
    ARR_PDF_IDS = [];
    for (var i = 0;i < items.length;i++) {
        item = items[i];

        replace = {
            '{index}': index,
            '{url}': 'show-' + item['id'] + '.html',
            '{thumb}': item['thumb'].slice(1),
            '{title}': item['title'],
            '{code}': item['code']
        };
        for (j = 0;j < props.length;j++) {
            replace['{' + props[j] + '}'] = PROPERTIES[props[j]]['options'][item[props[j]]];
        }
        html.push(template.allReplace(replace));
        ARR_PDF_IDS.push(item['id']);

        index++;
    }

    document.getElementById('total_record').innerHTML = html.length + '';
    document.getElementById('sortTableTbody').innerHTML = html.join('');
}

function download_pdfs() {
    var pdfs = ARR_PDF_IDS;
    var path = '';
    for (var i = 0;i < pdfs.length;i++) {
        path = 'pdf/' + pdfs[i] + '.pdf';
        window.open(path);
    }
}