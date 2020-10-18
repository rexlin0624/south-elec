var ARR_PDF_IDS = [];
var PAGE = 1;
var PAGE_SIZE = 10;

var series_4 = '6-1,2,3,4,A,B,D-0,1,2-1,2,3,A,B-1,2,3,4,5,6,7-0,1,2,3,4-1,2,3-0,1,2,3,4-0,1,2,3,4-C-0,1,2,4,6-A,B,C,D,E';
var series_5 = '7-1,2,3,4,A,B,D-1,2-1,2,3,A,B-1,2,3,4,5,6,7-1,2-1,2,3-0,1,2,3,4-0,1,2,3,4-C-1,2-A,B,C,D,E';
var series_6 = '8-0,1,2,3-0,1,2,3-0,1-1,2,3,4,5-0,1,2,3,4,5,6-0,1,2,3-0,1,2,3,4,7,8-0,1,2,3,4-n-0,1,2,3,4,5,6-E,F,G';

var map_series_title = {
    6: '4.0',
    7: '5.0',
    8: '6.0'
};

var _relaction = [];
var searchRestrict = {};

function pageInit() {
    _relaction.push(splitSerial(series_4));
    _relaction.push(splitSerial(series_5));
    _relaction.push(splitSerial(series_6));
}

function splitSerial(series) {
    var series1 = series.split('-');
    var series2 = [];

    var item;
    for (var i = 0;i < series1.length;i++) {
        item = series1[i];
        series2.push(item.split(','));
    }

    return series2;
}

var relationIndex = {
    // 系列
    'series_id': 0,
    // 前圈尺寸
    'front_shape': 1,
    // 前圈/按键材料
    'front_button_material': 2,
    // 前圈/按键形状
    'front_button_shape': 3,
    // 前圈/按键颜色
    'front_button_color': 4,
    // 开关元件
    'switch_element': 5,
    // 照明形式
    'light_style': 6,
    // 灯罩/LED灯颜色
    'led_color': 7,
    // LED灯电压
    'led_voltage': 8,
    // 军标
    'military_standard': 9,
    // 功能
    'functions_id': 10,
    // 安装尺寸
    'install_size': 11
};

function propRestrict(relations, prop, index) {
    var restricts = [];
    var relation;
    for (var i = 0;i < relations.length;i++) {
        relation = relations[i];
        if (relation[index].indexOf(prop) !== -1) {
            restricts.push(relation);
        }
    }

    return restricts;
}

function relactionRestrict(property) {
    var restricts = [];
    var propValue, rIndex;
    for (var prop in relationIndex) {
        if (!relationIndex.hasOwnProperty(prop)) {
            continue;
        }
        rIndex = relationIndex[prop];

        propValue = property[prop] ? property[prop] : -100;
        if (propValue !== -100 && propValue !== -1000) {
            if (restricts.length === 0) {
                restricts = propRestrict(_relaction, propValue, rIndex);
            } else {
                restricts = propRestrict(restricts, propValue, rIndex);
            }
        }
    }

    var unionRestricts = {};
    var i, j, idx, restrict, items, item;
    for (i = 0;i < restricts.length;i++) {
        restrict = restricts[i];
        for (j = 0;j < restrict.length;j++) {
            idx = j;
            if (!unionRestricts[idx]) {
                unionRestricts[idx] = [];
            }
            items = restrict[j];

            for (item in items) {
                if (unionRestricts[idx].indexOf(item) !== -1) {
                    unionRestricts[idx].push(item);
                }
            }
        }
    }

    return unionRestricts;
}

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

function nextPage() {
    PAGE += 1;
    setSeFilter();
}

function prevPage() {
    PAGE -= 1;
    if (PAGE <= 0) {
        alert('已经是第一页');
        return false;
    }
    setSeFilter();
}

function changeSearch(series_id) {
    $('#search-form').find('.product-prop-filter').remove();

    series_id = series_id ? series_id : $('#serial_id').val();
    if (!series_id) {
        return true;
    }

    var series_key = map_series_title[series_id];
    var product_props = PROPERTIES[series_key];

    var html = [], prop, opt, option;
    for (var key in product_props) {
        if (!product_props.hasOwnProperty(key)) {
            continue;
        }
        prop = product_props[key];

        html.push('<fieldset class="filter column grid_filter product-prop-filter">');
        html.push('<label>' + prop['title'] + '（<span id="' + key + '-count">' + Object.keys(prop['options']).length + '</span>）</label>');
        html.push('<select onchange="setSeFilter();" name="' + key + '" id="' + key + '" class="prodFinder sel-product-prop" style="display: inline-block;">');
        html.push('<option value="-"></option>');
        for (opt in prop['options']) {
            if (!prop['options'].hasOwnProperty(opt)) {
                continue;
            }

            // 联动
            if (searchRestrict[key] && searchRestrict[key].indexOf(opt) === -1) {
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

function searchRestrictCondition(products) {
    searchRestrict = [];
    var ii, jj, tmp, val;
    for (ii = 0;ii < products.length;ii++) {
        tmp = products[ii];
        for (jj in tmp) {
            if (!tmp.hasOwnProperty(jj)) {
                continue;
            }
            if (Object.keys(relationIndex).indexOf(jj) === -1) {
                continue;
            }
            val = $.trim(tmp[jj]);
            if (val === '') {
                continue;
            }

            if (!searchRestrict[jj]) {
                searchRestrict[jj] = [];
            }
            if (searchRestrict[jj].indexOf(val) !== -1) {
                continue;
            }

            searchRestrict[jj].push(val);
        }
    }

    for (var prop in searchRestrict) {
        if (!searchRestrict.hasOwnProperty(prop)) {
            continue;
        }

        $('#' + prop).find('option').each(function() {
            if ($(this).val() === '-') {
                return true;
            }

            if (searchRestrict[prop].indexOf($(this).val()) === -1) {
                $(this).remove();
            }
        });
        $('#' + prop + '-count').html(searchRestrict[prop].length);
    }
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
    filters['functions_id'] = $('#functions_id').val();

    var is_military_standard = filters['military_standard'] === 'J';
    delete filters['military_standard'];

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
    var fn_condition = new Function('filters', 'item', 'if (Object.keys(filters).length === 0) { return true; } var condition = [];for (var filter in filters) { if (filter === "code") { condition.push("item[\'code\'].indexOf(\'" + filters[filter] + "\') !== -1"); } else { condition.push("item[\'" + filter + "\'] === \'" + filters[filter] + "\'"); }} return condition.join(" && ");');
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
    var products = items.filter(function (item) { return eval(fn_condition(myfilter, item)); });
    var total = products.length;

    // 查询联动
    searchRestrictCondition(products);

    var start = (PAGE - 1) * PAGE_SIZE;
    var end = start + PAGE_SIZE;
    products = products.slice(start, end);

    // if (is_show_contact) {
    //     $('#show-contact-engineer').show();
    // } else {
    //     $('#show-contact-engineer').hide();
    // }

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
        is_military_standard ? 'J' : '-'
    ].join('');
    document.getElementById('current-selected-code').innerHTML = selected_code;

    var html = [], item = {}, index = 1, replace = {}, j, propValue;
    ARR_PDF_IDS = [];
    for (var i = 0;i < products.length;i++) {
        item = products[i];

        replace = {
            '{index}': index,
            '{url}': 'show-' + item['id'] + '.html?g=' + (is_military_standard ? 1 : 0),
            '{thumb}': item['thumb'].slice(1),
            '{title}': item['title'],
            '{code}': item['code'].replace('J', '-')
        };
        for (j = 0;j < props.length;j++) {
            propValue = product_props[props[j]]['options'][item[props[j]]];
            if (props[j] === 'military_standard') {
                propValue = is_military_standard ? propValue : '-';
            }

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