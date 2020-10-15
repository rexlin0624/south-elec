var ARR_PDF_IDS = [];
var PAGE = 1;
var PAGE_SIZE = 10;

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

function nextPage() {
    PAGE += 1;
    setSeFilter();
}

function prevPage() {
    PAGE -= 1;
    setSeFilter();
}

function changeSearch() {
    $('#search-form').find('.product-prop-filter').remove();

    var series_id = $('#serial_id').val();
    if (!series_id) {
        return true;
    }

    var series_key = $('#serial_id').find('option[selected]').text();
    var product_props = PROPERTIES[series_key];

    var html = [], prop, opt, option;
    for (var key in product_props) {
        if (!product_props.hasOwnProperty(key)) {
            continue;
        }
        prop = product_props[key];

        html.push('<fieldset class="filter column grid_filter product-prop-filter">');
        html.push('<label>' + prop['title'] + '（' + Object.keys(prop['options']).length + '）</label>');
        html.push('<select onchange="setSeFilter();" name="' + key + '" id="' + key + '" class="prodFinder" style="display: inline-block;">');
        html.push('<option value="-"></option>');
        for (opt in prop['options']) {
            if (!prop['options'].hasOwnProperty(opt)) {
                continue;
            }
            option = prop['options'][opt];
            html.push('<option value="' + opt + '">' + opt + ' ' + option + '</option>');
        }
        html.push('</select>');
        html.push('</fieldset>');
    }

    $('#search-form').append(html.join(''));
}

function setSeFilter(type) {
    var series_id, series_key;
    if (!$('#serial_id').val()) {
        series_id = 8;
        series_key = '6.0';
        $('#serial_id').val(series_id);
    } else {
        series_id = $('#serial_id').val();
        series_key = $('#serial_id').find('option[selected]').text();
    }

    if (type === 1) {
        changeSearch();
    }

    var product_props = PROPERTIES[series_key];
    var filters = {};
    var temp_props = [], prop = {}, props = [];
    for (var key in product_props) {
        if (!product_props.hasOwnProperty(key)) {
            continue;
        }
        prop = product_props[key];
        temp_props.push('<tr><td class="attribute">', prop['title'], '：</td><td class="attribute_value">{', key, '}</td></tr>');
        props.push(key);

        filters[key] = $('#' + key).val();
    }
    if ($.trim($('#product_code').val()) !== '') {
        filters['code'] = $.trim($('#product_code').val());
    }
    filters['series_id'] = series_id;

    var template = [
        '<tr>',
            '<td>',
                '<div class="product_list_row">',
                    '<table>',
                        '<tbody>',
                            '<tr>',
                                '<td class="product_counter"><span>{index}</span></td>',
                                '<td><a href="{url}"><img src="{thumb}" style="height: 100px;" alt="{title}" title="{title}" /></a></td>',
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
    var total = items.length;

    var start = (PAGE - 1) * PAGE_SIZE;
    var end = start + PAGE_SIZE;
    items = items.slice(start, end);

    if (is_show_contact) {
        $('#show-contact-engineer').show();
    } else {
        $('#show-contact-engineer').hide();
    }

    // 规则：系列-{前圈尺寸}{前圈/按键材料}{前圈/按键形状}{前圈/按键颜色}.{开关元件}{照明形式}{LED灯颜色}{LED灯电压}.{军标}{序列号}
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
        filters['military_standard'] ? filters['military_standard'] : 'X'
    ].join('');
    document.getElementById('current-selected-code').innerHTML = selected_code;

    var html = [], item = {}, index = 1, replace = {}, j, propValue;
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
            propValue = product_props[props[j]]['options'][item[props[j]]];
            replace['{' + props[j] + '}'] = propValue ? propValue : '-';
        }
        html.push(template.allReplace(replace));
        ARR_PDF_IDS.push(item['id']);

        index++;
    }

    document.getElementById('total_record').innerHTML = total + '';
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