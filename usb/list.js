var PRODUCTS = {products};
var PROPERTIES = {properties};

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
};

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
    for (var filter in filters) {
        if (!filters.hasOwnProperty(filter)) {
            continue;
        }
        if (filters[filter] === '-') {
            continue;
        }

        myfilter[filter] = filters[filter];
    }
    items = items.filter(function (item) { return eval(fn_condition(myfilter, item)); });

    var html = [], item = {}, index = 1, replace = {}, j;
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

        index++;
    }

    document.getElementById('total_record').innerHTML = html.length + '';
    document.getElementById('sortTableTbody').innerHTML = html.join('');
}