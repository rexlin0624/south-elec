/*!
 * jQuery JavaScript Library v1.4.2
 * http://jquery.com/
 *
 * Copyright 2010, John Resig
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://jquery.org/license
 *
 * Includes Sizzle.js
 * http://sizzlejs.com/
 * Copyright 2010, The Dojo Foundation
 * Released under the MIT, BSD, and GPL Licenses.
 *
 * Date: Sat Feb 13 22:33:48 2010 -0500
 */
(function(A,w){function ma(){if(!c.isReady){try{s.documentElement.doScroll("left")}catch(a){setTimeout(ma,1);return}c.ready()}}function Qa(a,b){b.src?c.ajax({url:b.src,async:false,dataType:"script"}):c.globalEval(b.text||b.textContent||b.innerHTML||"");b.parentNode&&b.parentNode.removeChild(b)}function X(a,b,d,f,e,j){var i=a.length;if(typeof b==="object"){for(var o in b)X(a,o,b[o],f,e,d);return a}if(d!==w){f=!j&&f&&c.isFunction(d);for(o=0;o<i;o++)e(a[o],b,f?d.call(a[o],o,e(a[o],b)):d,j);return a}return i?
    e(a[0],b):w}function J(){return(new Date).getTime()}function Y(){return false}function Z(){return true}function na(a,b,d){d[0].type=a;return c.event.handle.apply(b,d)}function oa(a){var b,d=[],f=[],e=arguments,j,i,o,k,n,r;i=c.data(this,"events");if(!(a.liveFired===this||!i||!i.live||a.button&&a.type==="click")){a.liveFired=this;var u=i.live.slice(0);for(k=0;k<u.length;k++){i=u[k];i.origType.replace(O,"")===a.type?f.push(i.selector):u.splice(k--,1)}j=c(a.target).closest(f,a.currentTarget);n=0;for(r=
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             j.length;n<r;n++)for(k=0;k<u.length;k++){i=u[k];if(j[n].selector===i.selector){o=j[n].elem;f=null;if(i.preType==="mouseenter"||i.preType==="mouseleave")f=c(a.relatedTarget).closest(i.selector)[0];if(!f||f!==o)d.push({elem:o,handleObj:i})}}n=0;for(r=d.length;n<r;n++){j=d[n];a.currentTarget=j.elem;a.data=j.handleObj.data;a.handleObj=j.handleObj;if(j.handleObj.origHandler.apply(j.elem,e)===false){b=false;break}}return b}}function pa(a,b){return"live."+(a&&a!=="*"?a+".":"")+b.replace(/\./g,"`").replace(/ /g,
    "&")}function qa(a){return!a||!a.parentNode||a.parentNode.nodeType===11}function ra(a,b){var d=0;b.each(function(){if(this.nodeName===(a[d]&&a[d].nodeName)){var f=c.data(a[d++]),e=c.data(this,f);if(f=f&&f.events){delete e.handle;e.events={};for(var j in f)for(var i in f[j])c.event.add(this,j,f[j][i],f[j][i].data)}}})}function sa(a,b,d){var f,e,j;b=b&&b[0]?b[0].ownerDocument||b[0]:s;if(a.length===1&&typeof a[0]==="string"&&a[0].length<512&&b===s&&!ta.test(a[0])&&(c.support.checkClone||!ua.test(a[0]))){e=
    true;if(j=c.fragments[a[0]])if(j!==1)f=j}if(!f){f=b.createDocumentFragment();c.clean(a,b,f,d)}if(e)c.fragments[a[0]]=j?f:1;return{fragment:f,cacheable:e}}function K(a,b){var d={};c.each(va.concat.apply([],va.slice(0,b)),function(){d[this]=a});return d}function wa(a){return"scrollTo"in a&&a.document?a:a.nodeType===9?a.defaultView||a.parentWindow:false}var c=function(a,b){return new c.fn.init(a,b)},Ra=A.jQuery,Sa=A.$,s=A.document,T,Ta=/^[^<]*(<[\w\W]+>)[^>]*$|^#([\w-]+)$/,Ua=/^.[^:#\[\.,]*$/,Va=/\S/,
    Wa=/^(\s|\u00A0)+|(\s|\u00A0)+$/g,Xa=/^<(\w+)\s*\/?>(?:<\/\1>)?$/,P=navigator.userAgent,xa=false,Q=[],L,$=Object.prototype.toString,aa=Object.prototype.hasOwnProperty,ba=Array.prototype.push,R=Array.prototype.slice,ya=Array.prototype.indexOf;c.fn=c.prototype={init:function(a,b){var d,f;if(!a)return this;if(a.nodeType){this.context=this[0]=a;this.length=1;return this}if(a==="body"&&!b){this.context=s;this[0]=s.body;this.selector="body";this.length=1;return this}if(typeof a==="string")if((d=Ta.exec(a))&&
        (d[1]||!b))if(d[1]){f=b?b.ownerDocument||b:s;if(a=Xa.exec(a))if(c.isPlainObject(b)){a=[s.createElement(a[1])];c.fn.attr.call(a,b,true)}else a=[f.createElement(a[1])];else{a=sa([d[1]],[f]);a=(a.cacheable?a.fragment.cloneNode(true):a.fragment).childNodes}return c.merge(this,a)}else{if(b=s.getElementById(d[2])){if(b.id!==d[2])return T.find(a);this.length=1;this[0]=b}this.context=s;this.selector=a;return this}else if(!b&&/^\w+$/.test(a)){this.selector=a;this.context=s;a=s.getElementsByTagName(a);return c.merge(this,
        a)}else return!b||b.jquery?(b||T).find(a):c(b).find(a);else if(c.isFunction(a))return T.ready(a);if(a.selector!==w){this.selector=a.selector;this.context=a.context}return c.makeArray(a,this)},selector:"",jquery:"1.4.2",length:0,size:function(){return this.length},toArray:function(){return R.call(this,0)},get:function(a){return a==null?this.toArray():a<0?this.slice(a)[0]:this[a]},pushStack:function(a,b,d){var f=c();c.isArray(a)?ba.apply(f,a):c.merge(f,a);f.prevObject=this;f.context=this.context;if(b===
        "find")f.selector=this.selector+(this.selector?" ":"")+d;else if(b)f.selector=this.selector+"."+b+"("+d+")";return f},each:function(a,b){return c.each(this,a,b)},ready:function(a){c.bindReady();if(c.isReady)a.call(s,c);else Q&&Q.push(a);return this},eq:function(a){return a===-1?this.slice(a):this.slice(a,+a+1)},first:function(){return this.eq(0)},last:function(){return this.eq(-1)},slice:function(){return this.pushStack(R.apply(this,arguments),"slice",R.call(arguments).join(","))},map:function(a){return this.pushStack(c.map(this,
        function(b,d){return a.call(b,d,b)}))},end:function(){return this.prevObject||c(null)},push:ba,sort:[].sort,splice:[].splice};c.fn.init.prototype=c.fn;c.extend=c.fn.extend=function(){var a=arguments[0]||{},b=1,d=arguments.length,f=false,e,j,i,o;if(typeof a==="boolean"){f=a;a=arguments[1]||{};b=2}if(typeof a!=="object"&&!c.isFunction(a))a={};if(d===b){a=this;--b}for(;b<d;b++)if((e=arguments[b])!=null)for(j in e){i=a[j];o=e[j];if(a!==o)if(f&&o&&(c.isPlainObject(o)||c.isArray(o))){i=i&&(c.isPlainObject(i)||
    c.isArray(i))?i:c.isArray(o)?[]:{};a[j]=c.extend(f,i,o)}else if(o!==w)a[j]=o}return a};c.extend({noConflict:function(a){A.$=Sa;if(a)A.jQuery=Ra;return c},isReady:false,ready:function(){if(!c.isReady){if(!s.body)return setTimeout(c.ready,13);c.isReady=true;if(Q){for(var a,b=0;a=Q[b++];)a.call(s,c);Q=null}c.fn.triggerHandler&&c(s).triggerHandler("ready")}},bindReady:function(){if(!xa){xa=true;if(s.readyState==="complete")return c.ready();if(s.addEventListener){s.addEventListener("DOMContentLoaded",
        L,false);A.addEventListener("load",c.ready,false)}else if(s.attachEvent){s.attachEvent("onreadystatechange",L);A.attachEvent("onload",c.ready);var a=false;try{a=A.frameElement==null}catch(b){}s.documentElement.doScroll&&a&&ma()}}},isFunction:function(a){return $.call(a)==="[object Function]"},isArray:function(a){return $.call(a)==="[object Array]"},isPlainObject:function(a){if(!a||$.call(a)!=="[object Object]"||a.nodeType||a.setInterval)return false;if(a.constructor&&!aa.call(a,"constructor")&&!aa.call(a.constructor.prototype,
        "isPrototypeOf"))return false;var b;for(b in a);return b===w||aa.call(a,b)},isEmptyObject:function(a){for(var b in a)return false;return true},error:function(a){throw a;},parseJSON:function(a){if(typeof a!=="string"||!a)return null;a=c.trim(a);if(/^[\],:{}\s]*$/.test(a.replace(/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g,"@").replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,"]").replace(/(?:^|:|,)(?:\s*\[)+/g,"")))return A.JSON&&A.JSON.parse?A.JSON.parse(a):(new Function("return "+
        a))();else c.error("Invalid JSON: "+a)},noop:function(){},globalEval:function(a){if(a&&Va.test(a)){var b=s.getElementsByTagName("head")[0]||s.documentElement,d=s.createElement("script");d.type="text/javascript";if(c.support.scriptEval)d.appendChild(s.createTextNode(a));else d.text=a;b.insertBefore(d,b.firstChild);b.removeChild(d)}},nodeName:function(a,b){return a.nodeName&&a.nodeName.toUpperCase()===b.toUpperCase()},each:function(a,b,d){var f,e=0,j=a.length,i=j===w||c.isFunction(a);if(d)if(i)for(f in a){if(b.apply(a[f],
        d)===false)break}else for(;e<j;){if(b.apply(a[e++],d)===false)break}else if(i)for(f in a){if(b.call(a[f],f,a[f])===false)break}else for(d=a[0];e<j&&b.call(d,e,d)!==false;d=a[++e]);return a},trim:function(a){return(a||"").replace(Wa,"")},makeArray:function(a,b){b=b||[];if(a!=null)a.length==null||typeof a==="string"||c.isFunction(a)||typeof a!=="function"&&a.setInterval?ba.call(b,a):c.merge(b,a);return b},inArray:function(a,b){if(b.indexOf)return b.indexOf(a);for(var d=0,f=b.length;d<f;d++)if(b[d]===
        a)return d;return-1},merge:function(a,b){var d=a.length,f=0;if(typeof b.length==="number")for(var e=b.length;f<e;f++)a[d++]=b[f];else for(;b[f]!==w;)a[d++]=b[f++];a.length=d;return a},grep:function(a,b,d){for(var f=[],e=0,j=a.length;e<j;e++)!d!==!b(a[e],e)&&f.push(a[e]);return f},map:function(a,b,d){for(var f=[],e,j=0,i=a.length;j<i;j++){e=b(a[j],j,d);if(e!=null)f[f.length]=e}return f.concat.apply([],f)},guid:1,proxy:function(a,b,d){if(arguments.length===2)if(typeof b==="string"){d=a;a=d[b];b=w}else if(b&&
        !c.isFunction(b)){d=b;b=w}if(!b&&a)b=function(){return a.apply(d||this,arguments)};if(a)b.guid=a.guid=a.guid||b.guid||c.guid++;return b},uaMatch:function(a){a=a.toLowerCase();a=/(webkit)[ \/]([\w.]+)/.exec(a)||/(opera)(?:.*version)?[ \/]([\w.]+)/.exec(a)||/(msie) ([\w.]+)/.exec(a)||!/compatible/.test(a)&&/(mozilla)(?:.*? rv:([\w.]+))?/.exec(a)||[];return{browser:a[1]||"",version:a[2]||"0"}},browser:{}});P=c.uaMatch(P);if(P.browser){c.browser[P.browser]=true;c.browser.version=P.version}if(c.browser.webkit)c.browser.safari=
    true;if(ya)c.inArray=function(a,b){return ya.call(b,a)};T=c(s);if(s.addEventListener)L=function(){s.removeEventListener("DOMContentLoaded",L,false);c.ready()};else if(s.attachEvent)L=function(){if(s.readyState==="complete"){s.detachEvent("onreadystatechange",L);c.ready()}};(function(){c.support={};var a=s.documentElement,b=s.createElement("script"),d=s.createElement("div"),f="script"+J();d.style.display="none";d.innerHTML="   <link/><table></table><a href='/a' style='color:red;float:left;opacity:.55;'>a</a><input type='checkbox'/>";
    var e=d.getElementsByTagName("*"),j=d.getElementsByTagName("a")[0];if(!(!e||!e.length||!j)){c.support={leadingWhitespace:d.firstChild.nodeType===3,tbody:!d.getElementsByTagName("tbody").length,htmlSerialize:!!d.getElementsByTagName("link").length,style:/red/.test(j.getAttribute("style")),hrefNormalized:j.getAttribute("href")==="/a",opacity:/^0.55$/.test(j.style.opacity),cssFloat:!!j.style.cssFloat,checkOn:d.getElementsByTagName("input")[0].value==="on",optSelected:s.createElement("select").appendChild(s.createElement("option")).selected,
        parentNode:d.removeChild(d.appendChild(s.createElement("div"))).parentNode===null,deleteExpando:true,checkClone:false,scriptEval:false,noCloneEvent:true,boxModel:null};b.type="text/javascript";try{b.appendChild(s.createTextNode("window."+f+"=1;"))}catch(i){}a.insertBefore(b,a.firstChild);if(A[f]){c.support.scriptEval=true;delete A[f]}try{delete b.test}catch(o){c.support.deleteExpando=false}a.removeChild(b);if(d.attachEvent&&d.fireEvent){d.attachEvent("onclick",function k(){c.support.noCloneEvent=
        false;d.detachEvent("onclick",k)});d.cloneNode(true).fireEvent("onclick")}d=s.createElement("div");d.innerHTML="<input type='radio' name='radiotest' checked='checked'/>";a=s.createDocumentFragment();a.appendChild(d.firstChild);c.support.checkClone=a.cloneNode(true).cloneNode(true).lastChild.checked;c(function(){var k=s.createElement("div");k.style.width=k.style.paddingLeft="1px";s.body.appendChild(k);c.boxModel=c.support.boxModel=k.offsetWidth===2;s.body.removeChild(k).style.display="none"});a=function(k){var n=
        s.createElement("div");k="on"+k;var r=k in n;if(!r){n.setAttribute(k,"return;");r=typeof n[k]==="function"}return r};c.support.submitBubbles=a("submit");c.support.changeBubbles=a("change");a=b=d=e=j=null}})();c.props={"for":"htmlFor","class":"className",readonly:"readOnly",maxlength:"maxLength",cellspacing:"cellSpacing",rowspan:"rowSpan",colspan:"colSpan",tabindex:"tabIndex",usemap:"useMap",frameborder:"frameBorder"};var G="jQuery"+J(),Ya=0,za={};c.extend({cache:{},expando:G,noData:{embed:true,object:true,
        applet:true},data:function(a,b,d){if(!(a.nodeName&&c.noData[a.nodeName.toLowerCase()])){a=a==A?za:a;var f=a[G],e=c.cache;if(!f&&typeof b==="string"&&d===w)return null;f||(f=++Ya);if(typeof b==="object"){a[G]=f;e[f]=c.extend(true,{},b)}else if(!e[f]){a[G]=f;e[f]={}}a=e[f];if(d!==w)a[b]=d;return typeof b==="string"?a[b]:a}},removeData:function(a,b){if(!(a.nodeName&&c.noData[a.nodeName.toLowerCase()])){a=a==A?za:a;var d=a[G],f=c.cache,e=f[d];if(b){if(e){delete e[b];c.isEmptyObject(e)&&c.removeData(a)}}else{if(c.support.deleteExpando)delete a[c.expando];
    else a.removeAttribute&&a.removeAttribute(c.expando);delete f[d]}}}});c.fn.extend({data:function(a,b){if(typeof a==="undefined"&&this.length)return c.data(this[0]);else if(typeof a==="object")return this.each(function(){c.data(this,a)});var d=a.split(".");d[1]=d[1]?"."+d[1]:"";if(b===w){var f=this.triggerHandler("getData"+d[1]+"!",[d[0]]);if(f===w&&this.length)f=c.data(this[0],a);return f===w&&d[1]?this.data(d[0]):f}else return this.trigger("setData"+d[1]+"!",[d[0],b]).each(function(){c.data(this,
        a,b)})},removeData:function(a){return this.each(function(){c.removeData(this,a)})}});c.extend({queue:function(a,b,d){if(a){b=(b||"fx")+"queue";var f=c.data(a,b);if(!d)return f||[];if(!f||c.isArray(d))f=c.data(a,b,c.makeArray(d));else f.push(d);return f}},dequeue:function(a,b){b=b||"fx";var d=c.queue(a,b),f=d.shift();if(f==="inprogress")f=d.shift();if(f){b==="fx"&&d.unshift("inprogress");f.call(a,function(){c.dequeue(a,b)})}}});c.fn.extend({queue:function(a,b){if(typeof a!=="string"){b=a;a="fx"}if(b===
        w)return c.queue(this[0],a);return this.each(function(){var d=c.queue(this,a,b);a==="fx"&&d[0]!=="inprogress"&&c.dequeue(this,a)})},dequeue:function(a){return this.each(function(){c.dequeue(this,a)})},delay:function(a,b){a=c.fx?c.fx.speeds[a]||a:a;b=b||"fx";return this.queue(b,function(){var d=this;setTimeout(function(){c.dequeue(d,b)},a)})},clearQueue:function(a){return this.queue(a||"fx",[])}});var Aa=/[\n\t]/g,ca=/\s+/,Za=/\r/g,$a=/href|src|style/,ab=/(button|input)/i,bb=/(button|input|object|select|textarea)/i,
    cb=/^(a|area)$/i,Ba=/radio|checkbox/;c.fn.extend({attr:function(a,b){return X(this,a,b,true,c.attr)},removeAttr:function(a){return this.each(function(){c.attr(this,a,"");this.nodeType===1&&this.removeAttribute(a)})},addClass:function(a){if(c.isFunction(a))return this.each(function(n){var r=c(this);r.addClass(a.call(this,n,r.attr("class")))});if(a&&typeof a==="string")for(var b=(a||"").split(ca),d=0,f=this.length;d<f;d++){var e=this[d];if(e.nodeType===1)if(e.className){for(var j=" "+e.className+" ",
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     i=e.className,o=0,k=b.length;o<k;o++)if(j.indexOf(" "+b[o]+" ")<0)i+=" "+b[o];e.className=c.trim(i)}else e.className=a}return this},removeClass:function(a){if(c.isFunction(a))return this.each(function(k){var n=c(this);n.removeClass(a.call(this,k,n.attr("class")))});if(a&&typeof a==="string"||a===w)for(var b=(a||"").split(ca),d=0,f=this.length;d<f;d++){var e=this[d];if(e.nodeType===1&&e.className)if(a){for(var j=(" "+e.className+" ").replace(Aa," "),i=0,o=b.length;i<o;i++)j=j.replace(" "+b[i]+" ",
        " ");e.className=c.trim(j)}else e.className=""}return this},toggleClass:function(a,b){var d=typeof a,f=typeof b==="boolean";if(c.isFunction(a))return this.each(function(e){var j=c(this);j.toggleClass(a.call(this,e,j.attr("class"),b),b)});return this.each(function(){if(d==="string")for(var e,j=0,i=c(this),o=b,k=a.split(ca);e=k[j++];){o=f?o:!i.hasClass(e);i[o?"addClass":"removeClass"](e)}else if(d==="undefined"||d==="boolean"){this.className&&c.data(this,"__className__",this.className);this.className=
        this.className||a===false?"":c.data(this,"__className__")||""}})},hasClass:function(a){a=" "+a+" ";for(var b=0,d=this.length;b<d;b++)if((" "+this[b].className+" ").replace(Aa," ").indexOf(a)>-1)return true;return false},val:function(a){if(a===w){var b=this[0];if(b){if(c.nodeName(b,"option"))return(b.attributes.value||{}).specified?b.value:b.text;if(c.nodeName(b,"select")){var d=b.selectedIndex,f=[],e=b.options;b=b.type==="select-one";if(d<0)return null;var j=b?d:0;for(d=b?d+1:e.length;j<d;j++){var i=
        e[j];if(i.selected){a=c(i).val();if(b)return a;f.push(a)}}return f}if(Ba.test(b.type)&&!c.support.checkOn)return b.getAttribute("value")===null?"on":b.value;return(b.value||"").replace(Za,"")}return w}var o=c.isFunction(a);return this.each(function(k){var n=c(this),r=a;if(this.nodeType===1){if(o)r=a.call(this,k,n.val());if(typeof r==="number")r+="";if(c.isArray(r)&&Ba.test(this.type))this.checked=c.inArray(n.val(),r)>=0;else if(c.nodeName(this,"select")){var u=c.makeArray(r);c("option",this).each(function(){this.selected=
        c.inArray(c(this).val(),u)>=0});if(!u.length)this.selectedIndex=-1}else this.value=r}})}});c.extend({attrFn:{val:true,css:true,html:true,text:true,data:true,width:true,height:true,offset:true},attr:function(a,b,d,f){if(!a||a.nodeType===3||a.nodeType===8)return w;if(f&&b in c.attrFn)return c(a)[b](d);f=a.nodeType!==1||!c.isXMLDoc(a);var e=d!==w;b=f&&c.props[b]||b;if(a.nodeType===1){var j=$a.test(b);if(b in a&&f&&!j){if(e){b==="type"&&ab.test(a.nodeName)&&a.parentNode&&c.error("type property can't be changed");
        a[b]=d}if(c.nodeName(a,"form")&&a.getAttributeNode(b))return a.getAttributeNode(b).nodeValue;if(b==="tabIndex")return(b=a.getAttributeNode("tabIndex"))&&b.specified?b.value:bb.test(a.nodeName)||cb.test(a.nodeName)&&a.href?0:w;return a[b]}if(!c.support.style&&f&&b==="style"){if(e)a.style.cssText=""+d;return a.style.cssText}e&&a.setAttribute(b,""+d);a=!c.support.hrefNormalized&&f&&j?a.getAttribute(b,2):a.getAttribute(b);return a===null?w:a}return c.style(a,b,d)}});var O=/\.(.*)$/,db=function(a){return a.replace(/[^\w\s\.\|`]/g,
    function(b){return"\\"+b})};c.event={add:function(a,b,d,f){if(!(a.nodeType===3||a.nodeType===8)){if(a.setInterval&&a!==A&&!a.frameElement)a=A;var e,j;if(d.handler){e=d;d=e.handler}if(!d.guid)d.guid=c.guid++;if(j=c.data(a)){var i=j.events=j.events||{},o=j.handle;if(!o)j.handle=o=function(){return typeof c!=="undefined"&&!c.event.triggered?c.event.handle.apply(o.elem,arguments):w};o.elem=a;b=b.split(" ");for(var k,n=0,r;k=b[n++];){j=e?c.extend({},e):{handler:d,data:f};if(k.indexOf(".")>-1){r=k.split(".");
        k=r.shift();j.namespace=r.slice(0).sort().join(".")}else{r=[];j.namespace=""}j.type=k;j.guid=d.guid;var u=i[k],z=c.event.special[k]||{};if(!u){u=i[k]=[];if(!z.setup||z.setup.call(a,f,r,o)===false)if(a.addEventListener)a.addEventListener(k,o,false);else a.attachEvent&&a.attachEvent("on"+k,o)}if(z.add){z.add.call(a,j);if(!j.handler.guid)j.handler.guid=d.guid}u.push(j);c.event.global[k]=true}a=null}}},global:{},remove:function(a,b,d,f){if(!(a.nodeType===3||a.nodeType===8)){var e,j=0,i,o,k,n,r,u,z=c.data(a),
        C=z&&z.events;if(z&&C){if(b&&b.type){d=b.handler;b=b.type}if(!b||typeof b==="string"&&b.charAt(0)==="."){b=b||"";for(e in C)c.event.remove(a,e+b)}else{for(b=b.split(" ");e=b[j++];){n=e;i=e.indexOf(".")<0;o=[];if(!i){o=e.split(".");e=o.shift();k=new RegExp("(^|\\.)"+c.map(o.slice(0).sort(),db).join("\\.(?:.*\\.)?")+"(\\.|$)")}if(r=C[e])if(d){n=c.event.special[e]||{};for(B=f||0;B<r.length;B++){u=r[B];if(d.guid===u.guid){if(i||k.test(u.namespace)){f==null&&r.splice(B--,1);n.remove&&n.remove.call(a,u)}if(f!=
        null)break}}if(r.length===0||f!=null&&r.length===1){if(!n.teardown||n.teardown.call(a,o)===false)Ca(a,e,z.handle);delete C[e]}}else for(var B=0;B<r.length;B++){u=r[B];if(i||k.test(u.namespace)){c.event.remove(a,n,u.handler,B);r.splice(B--,1)}}}if(c.isEmptyObject(C)){if(b=z.handle)b.elem=null;delete z.events;delete z.handle;c.isEmptyObject(z)&&c.removeData(a)}}}}},trigger:function(a,b,d,f){var e=a.type||a;if(!f){a=typeof a==="object"?a[G]?a:c.extend(c.Event(e),a):c.Event(e);if(e.indexOf("!")>=0){a.type=
        e=e.slice(0,-1);a.exclusive=true}if(!d){a.stopPropagation();c.event.global[e]&&c.each(c.cache,function(){this.events&&this.events[e]&&c.event.trigger(a,b,this.handle.elem)})}if(!d||d.nodeType===3||d.nodeType===8)return w;a.result=w;a.target=d;b=c.makeArray(b);b.unshift(a)}a.currentTarget=d;(f=c.data(d,"handle"))&&f.apply(d,b);f=d.parentNode||d.ownerDocument;try{if(!(d&&d.nodeName&&c.noData[d.nodeName.toLowerCase()]))if(d["on"+e]&&d["on"+e].apply(d,b)===false)a.result=false}catch(j){}if(!a.isPropagationStopped()&&
        f)c.event.trigger(a,b,f,true);else if(!a.isDefaultPrevented()){f=a.target;var i,o=c.nodeName(f,"a")&&e==="click",k=c.event.special[e]||{};if((!k._default||k._default.call(d,a)===false)&&!o&&!(f&&f.nodeName&&c.noData[f.nodeName.toLowerCase()])){try{if(f[e]){if(i=f["on"+e])f["on"+e]=null;c.event.triggered=true;f[e]()}}catch(n){}if(i)f["on"+e]=i;c.event.triggered=false}}},handle:function(a){var b,d,f,e;a=arguments[0]=c.event.fix(a||A.event);a.currentTarget=this;b=a.type.indexOf(".")<0&&!a.exclusive;
        if(!b){d=a.type.split(".");a.type=d.shift();f=new RegExp("(^|\\.)"+d.slice(0).sort().join("\\.(?:.*\\.)?")+"(\\.|$)")}e=c.data(this,"events");d=e[a.type];if(e&&d){d=d.slice(0);e=0;for(var j=d.length;e<j;e++){var i=d[e];if(b||f.test(i.namespace)){a.handler=i.handler;a.data=i.data;a.handleObj=i;i=i.handler.apply(this,arguments);if(i!==w){a.result=i;if(i===false){a.preventDefault();a.stopPropagation()}}if(a.isImmediatePropagationStopped())break}}}return a.result},props:"altKey attrChange attrName bubbles button cancelable charCode clientX clientY ctrlKey currentTarget data detail eventPhase fromElement handler keyCode layerX layerY metaKey newValue offsetX offsetY originalTarget pageX pageY prevValue relatedNode relatedTarget screenX screenY shiftKey srcElement target toElement view wheelDelta which".split(" "),
    fix:function(a){if(a[G])return a;var b=a;a=c.Event(b);for(var d=this.props.length,f;d;){f=this.props[--d];a[f]=b[f]}if(!a.target)a.target=a.srcElement||s;if(a.target.nodeType===3)a.target=a.target.parentNode;if(!a.relatedTarget&&a.fromElement)a.relatedTarget=a.fromElement===a.target?a.toElement:a.fromElement;if(a.pageX==null&&a.clientX!=null){b=s.documentElement;d=s.body;a.pageX=a.clientX+(b&&b.scrollLeft||d&&d.scrollLeft||0)-(b&&b.clientLeft||d&&d.clientLeft||0);a.pageY=a.clientY+(b&&b.scrollTop||
        d&&d.scrollTop||0)-(b&&b.clientTop||d&&d.clientTop||0)}if(!a.which&&(a.charCode||a.charCode===0?a.charCode:a.keyCode))a.which=a.charCode||a.keyCode;if(!a.metaKey&&a.ctrlKey)a.metaKey=a.ctrlKey;if(!a.which&&a.button!==w)a.which=a.button&1?1:a.button&2?3:a.button&4?2:0;return a},guid:1E8,proxy:c.proxy,special:{ready:{setup:c.bindReady,teardown:c.noop},live:{add:function(a){c.event.add(this,a.origType,c.extend({},a,{handler:oa}))},remove:function(a){var b=true,d=a.origType.replace(O,"");c.each(c.data(this,
                "events").live||[],function(){if(d===this.origType.replace(O,""))return b=false});b&&c.event.remove(this,a.origType,oa)}},beforeunload:{setup:function(a,b,d){if(this.setInterval)this.onbeforeunload=d;return false},teardown:function(a,b){if(this.onbeforeunload===b)this.onbeforeunload=null}}}};var Ca=s.removeEventListener?function(a,b,d){a.removeEventListener(b,d,false)}:function(a,b,d){a.detachEvent("on"+b,d)};c.Event=function(a){if(!this.preventDefault)return new c.Event(a);if(a&&a.type){this.originalEvent=
    a;this.type=a.type}else this.type=a;this.timeStamp=J();this[G]=true};c.Event.prototype={preventDefault:function(){this.isDefaultPrevented=Z;var a=this.originalEvent;if(a){a.preventDefault&&a.preventDefault();a.returnValue=false}},stopPropagation:function(){this.isPropagationStopped=Z;var a=this.originalEvent;if(a){a.stopPropagation&&a.stopPropagation();a.cancelBubble=true}},stopImmediatePropagation:function(){this.isImmediatePropagationStopped=Z;this.stopPropagation()},isDefaultPrevented:Y,isPropagationStopped:Y,
    isImmediatePropagationStopped:Y};var Da=function(a){var b=a.relatedTarget;try{for(;b&&b!==this;)b=b.parentNode;if(b!==this){a.type=a.data;c.event.handle.apply(this,arguments)}}catch(d){}},Ea=function(a){a.type=a.data;c.event.handle.apply(this,arguments)};c.each({mouseenter:"mouseover",mouseleave:"mouseout"},function(a,b){c.event.special[a]={setup:function(d){c.event.add(this,b,d&&d.selector?Ea:Da,a)},teardown:function(d){c.event.remove(this,b,d&&d.selector?Ea:Da)}}});if(!c.support.submitBubbles)c.event.special.submit=
    {setup:function(){if(this.nodeName.toLowerCase()!=="form"){c.event.add(this,"click.specialSubmit",function(a){var b=a.target,d=b.type;if((d==="submit"||d==="image")&&c(b).closest("form").length)return na("submit",this,arguments)});c.event.add(this,"keypress.specialSubmit",function(a){var b=a.target,d=b.type;if((d==="text"||d==="password")&&c(b).closest("form").length&&a.keyCode===13)return na("submit",this,arguments)})}else return false},teardown:function(){c.event.remove(this,".specialSubmit")}};
    if(!c.support.changeBubbles){var da=/textarea|input|select/i,ea,Fa=function(a){var b=a.type,d=a.value;if(b==="radio"||b==="checkbox")d=a.checked;else if(b==="select-multiple")d=a.selectedIndex>-1?c.map(a.options,function(f){return f.selected}).join("-"):"";else if(a.nodeName.toLowerCase()==="select")d=a.selectedIndex;return d},fa=function(a,b){var d=a.target,f,e;if(!(!da.test(d.nodeName)||d.readOnly)){f=c.data(d,"_change_data");e=Fa(d);if(a.type!=="focusout"||d.type!=="radio")c.data(d,"_change_data",
        e);if(!(f===w||e===f))if(f!=null||e){a.type="change";return c.event.trigger(a,b,d)}}};c.event.special.change={filters:{focusout:fa,click:function(a){var b=a.target,d=b.type;if(d==="radio"||d==="checkbox"||b.nodeName.toLowerCase()==="select")return fa.call(this,a)},keydown:function(a){var b=a.target,d=b.type;if(a.keyCode===13&&b.nodeName.toLowerCase()!=="textarea"||a.keyCode===32&&(d==="checkbox"||d==="radio")||d==="select-multiple")return fa.call(this,a)},beforeactivate:function(a){a=a.target;c.data(a,
                "_change_data",Fa(a))}},setup:function(){if(this.type==="file")return false;for(var a in ea)c.event.add(this,a+".specialChange",ea[a]);return da.test(this.nodeName)},teardown:function(){c.event.remove(this,".specialChange");return da.test(this.nodeName)}};ea=c.event.special.change.filters}s.addEventListener&&c.each({focus:"focusin",blur:"focusout"},function(a,b){function d(f){f=c.event.fix(f);f.type=b;return c.event.handle.call(this,f)}c.event.special[b]={setup:function(){this.addEventListener(a,
            d,true)},teardown:function(){this.removeEventListener(a,d,true)}}});c.each(["bind","one"],function(a,b){c.fn[b]=function(d,f,e){if(typeof d==="object"){for(var j in d)this[b](j,f,d[j],e);return this}if(c.isFunction(f)){e=f;f=w}var i=b==="one"?c.proxy(e,function(k){c(this).unbind(k,i);return e.apply(this,arguments)}):e;if(d==="unload"&&b!=="one")this.one(d,f,e);else{j=0;for(var o=this.length;j<o;j++)c.event.add(this[j],d,i,f)}return this}});c.fn.extend({unbind:function(a,b){if(typeof a==="object"&&
            !a.preventDefault)for(var d in a)this.unbind(d,a[d]);else{d=0;for(var f=this.length;d<f;d++)c.event.remove(this[d],a,b)}return this},delegate:function(a,b,d,f){return this.live(b,d,f,a)},undelegate:function(a,b,d){return arguments.length===0?this.unbind("live"):this.die(b,null,d,a)},trigger:function(a,b){return this.each(function(){c.event.trigger(a,b,this)})},triggerHandler:function(a,b){if(this[0]){a=c.Event(a);a.preventDefault();a.stopPropagation();c.event.trigger(a,b,this[0]);return a.result}},
        toggle:function(a){for(var b=arguments,d=1;d<b.length;)c.proxy(a,b[d++]);return this.click(c.proxy(a,function(f){var e=(c.data(this,"lastToggle"+a.guid)||0)%d;c.data(this,"lastToggle"+a.guid,e+1);f.preventDefault();return b[e].apply(this,arguments)||false}))},hover:function(a,b){return this.mouseenter(a).mouseleave(b||a)}});var Ga={focus:"focusin",blur:"focusout",mouseenter:"mouseover",mouseleave:"mouseout"};c.each(["live","die"],function(a,b){c.fn[b]=function(d,f,e,j){var i,o=0,k,n,r=j||this.selector,
        u=j?this:c(this.context);if(c.isFunction(f)){e=f;f=w}for(d=(d||"").split(" ");(i=d[o++])!=null;){j=O.exec(i);k="";if(j){k=j[0];i=i.replace(O,"")}if(i==="hover")d.push("mouseenter"+k,"mouseleave"+k);else{n=i;if(i==="focus"||i==="blur"){d.push(Ga[i]+k);i+=k}else i=(Ga[i]||i)+k;b==="live"?u.each(function(){c.event.add(this,pa(i,r),{data:f,selector:r,handler:e,origType:i,origHandler:e,preType:n})}):u.unbind(pa(i,r),e)}}return this}});c.each("blur focus focusin focusout load resize scroll unload click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup error".split(" "),
        function(a,b){c.fn[b]=function(d){return d?this.bind(b,d):this.trigger(b)};if(c.attrFn)c.attrFn[b]=true});A.attachEvent&&!A.addEventListener&&A.attachEvent("onunload",function(){for(var a in c.cache)if(c.cache[a].handle)try{c.event.remove(c.cache[a].handle.elem)}catch(b){}});(function(){function a(g){for(var h="",l,m=0;g[m];m++){l=g[m];if(l.nodeType===3||l.nodeType===4)h+=l.nodeValue;else if(l.nodeType!==8)h+=a(l.childNodes)}return h}function b(g,h,l,m,q,p){q=0;for(var v=m.length;q<v;q++){var t=m[q];
        if(t){t=t[g];for(var y=false;t;){if(t.sizcache===l){y=m[t.sizset];break}if(t.nodeType===1&&!p){t.sizcache=l;t.sizset=q}if(t.nodeName.toLowerCase()===h){y=t;break}t=t[g]}m[q]=y}}}function d(g,h,l,m,q,p){q=0;for(var v=m.length;q<v;q++){var t=m[q];if(t){t=t[g];for(var y=false;t;){if(t.sizcache===l){y=m[t.sizset];break}if(t.nodeType===1){if(!p){t.sizcache=l;t.sizset=q}if(typeof h!=="string"){if(t===h){y=true;break}}else if(k.filter(h,[t]).length>0){y=t;break}}t=t[g]}m[q]=y}}}var f=/((?:\((?:\([^()]+\)|[^()]+)+\)|\[(?:\[[^[\]]*\]|['"][^'"]*['"]|[^[\]'"]+)+\]|\\.|[^ >+~,(\[\\]+)+|[>+~])(\s*,\s*)?((?:.|\r|\n)*)/g,
        e=0,j=Object.prototype.toString,i=false,o=true;[0,0].sort(function(){o=false;return 0});var k=function(g,h,l,m){l=l||[];var q=h=h||s;if(h.nodeType!==1&&h.nodeType!==9)return[];if(!g||typeof g!=="string")return l;for(var p=[],v,t,y,S,H=true,M=x(h),I=g;(f.exec(""),v=f.exec(I))!==null;){I=v[3];p.push(v[1]);if(v[2]){S=v[3];break}}if(p.length>1&&r.exec(g))if(p.length===2&&n.relative[p[0]])t=ga(p[0]+p[1],h);else for(t=n.relative[p[0]]?[h]:k(p.shift(),h);p.length;){g=p.shift();if(n.relative[g])g+=p.shift();
        t=ga(g,t)}else{if(!m&&p.length>1&&h.nodeType===9&&!M&&n.match.ID.test(p[0])&&!n.match.ID.test(p[p.length-1])){v=k.find(p.shift(),h,M);h=v.expr?k.filter(v.expr,v.set)[0]:v.set[0]}if(h){v=m?{expr:p.pop(),set:z(m)}:k.find(p.pop(),p.length===1&&(p[0]==="~"||p[0]==="+")&&h.parentNode?h.parentNode:h,M);t=v.expr?k.filter(v.expr,v.set):v.set;if(p.length>0)y=z(t);else H=false;for(;p.length;){var D=p.pop();v=D;if(n.relative[D])v=p.pop();else D="";if(v==null)v=h;n.relative[D](y,v,M)}}else y=[]}y||(y=t);y||k.error(D||
        g);if(j.call(y)==="[object Array]")if(H)if(h&&h.nodeType===1)for(g=0;y[g]!=null;g++){if(y[g]&&(y[g]===true||y[g].nodeType===1&&E(h,y[g])))l.push(t[g])}else for(g=0;y[g]!=null;g++)y[g]&&y[g].nodeType===1&&l.push(t[g]);else l.push.apply(l,y);else z(y,l);if(S){k(S,q,l,m);k.uniqueSort(l)}return l};k.uniqueSort=function(g){if(B){i=o;g.sort(B);if(i)for(var h=1;h<g.length;h++)g[h]===g[h-1]&&g.splice(h--,1)}return g};k.matches=function(g,h){return k(g,null,null,h)};k.find=function(g,h,l){var m,q;if(!g)return[];
        for(var p=0,v=n.order.length;p<v;p++){var t=n.order[p];if(q=n.leftMatch[t].exec(g)){var y=q[1];q.splice(1,1);if(y.substr(y.length-1)!=="\\"){q[1]=(q[1]||"").replace(/\\/g,"");m=n.find[t](q,h,l);if(m!=null){g=g.replace(n.match[t],"");break}}}}m||(m=h.getElementsByTagName("*"));return{set:m,expr:g}};k.filter=function(g,h,l,m){for(var q=g,p=[],v=h,t,y,S=h&&h[0]&&x(h[0]);g&&h.length;){for(var H in n.filter)if((t=n.leftMatch[H].exec(g))!=null&&t[2]){var M=n.filter[H],I,D;D=t[1];y=false;t.splice(1,1);if(D.substr(D.length-
        1)!=="\\"){if(v===p)p=[];if(n.preFilter[H])if(t=n.preFilter[H](t,v,l,p,m,S)){if(t===true)continue}else y=I=true;if(t)for(var U=0;(D=v[U])!=null;U++)if(D){I=M(D,t,U,v);var Ha=m^!!I;if(l&&I!=null)if(Ha)y=true;else v[U]=false;else if(Ha){p.push(D);y=true}}if(I!==w){l||(v=p);g=g.replace(n.match[H],"");if(!y)return[];break}}}if(g===q)if(y==null)k.error(g);else break;q=g}return v};k.error=function(g){throw"Syntax error, unrecognized expression: "+g;};var n=k.selectors={order:["ID","NAME","TAG"],match:{ID:/#((?:[\w\u00c0-\uFFFF-]|\\.)+)/,
            CLASS:/\.((?:[\w\u00c0-\uFFFF-]|\\.)+)/,NAME:/\[name=['"]*((?:[\w\u00c0-\uFFFF-]|\\.)+)['"]*\]/,ATTR:/\[\s*((?:[\w\u00c0-\uFFFF-]|\\.)+)\s*(?:(\S?=)\s*(['"]*)(.*?)\3|)\s*\]/,TAG:/^((?:[\w\u00c0-\uFFFF\*-]|\\.)+)/,CHILD:/:(only|nth|last|first)-child(?:\((even|odd|[\dn+-]*)\))?/,POS:/:(nth|eq|gt|lt|first|last|even|odd)(?:\((\d*)\))?(?=[^-]|$)/,PSEUDO:/:((?:[\w\u00c0-\uFFFF-]|\\.)+)(?:\((['"]?)((?:\([^\)]+\)|[^\(\)]*)+)\2\))?/},leftMatch:{},attrMap:{"class":"className","for":"htmlFor"},attrHandle:{href:function(g){return g.getAttribute("href")}},
        relative:{"+":function(g,h){var l=typeof h==="string",m=l&&!/\W/.test(h);l=l&&!m;if(m)h=h.toLowerCase();m=0;for(var q=g.length,p;m<q;m++)if(p=g[m]){for(;(p=p.previousSibling)&&p.nodeType!==1;);g[m]=l||p&&p.nodeName.toLowerCase()===h?p||false:p===h}l&&k.filter(h,g,true)},">":function(g,h){var l=typeof h==="string";if(l&&!/\W/.test(h)){h=h.toLowerCase();for(var m=0,q=g.length;m<q;m++){var p=g[m];if(p){l=p.parentNode;g[m]=l.nodeName.toLowerCase()===h?l:false}}}else{m=0;for(q=g.length;m<q;m++)if(p=g[m])g[m]=
                l?p.parentNode:p.parentNode===h;l&&k.filter(h,g,true)}},"":function(g,h,l){var m=e++,q=d;if(typeof h==="string"&&!/\W/.test(h)){var p=h=h.toLowerCase();q=b}q("parentNode",h,m,g,p,l)},"~":function(g,h,l){var m=e++,q=d;if(typeof h==="string"&&!/\W/.test(h)){var p=h=h.toLowerCase();q=b}q("previousSibling",h,m,g,p,l)}},find:{ID:function(g,h,l){if(typeof h.getElementById!=="undefined"&&!l)return(g=h.getElementById(g[1]))?[g]:[]},NAME:function(g,h){if(typeof h.getElementsByName!=="undefined"){var l=[];
                h=h.getElementsByName(g[1]);for(var m=0,q=h.length;m<q;m++)h[m].getAttribute("name")===g[1]&&l.push(h[m]);return l.length===0?null:l}},TAG:function(g,h){return h.getElementsByTagName(g[1])}},preFilter:{CLASS:function(g,h,l,m,q,p){g=" "+g[1].replace(/\\/g,"")+" ";if(p)return g;p=0;for(var v;(v=h[p])!=null;p++)if(v)if(q^(v.className&&(" "+v.className+" ").replace(/[\t\n]/g," ").indexOf(g)>=0))l||m.push(v);else if(l)h[p]=false;return false},ID:function(g){return g[1].replace(/\\/g,"")},TAG:function(g){return g[1].toLowerCase()},
            CHILD:function(g){if(g[1]==="nth"){var h=/(-?)(\d*)n((?:\+|-)?\d*)/.exec(g[2]==="even"&&"2n"||g[2]==="odd"&&"2n+1"||!/\D/.test(g[2])&&"0n+"+g[2]||g[2]);g[2]=h[1]+(h[2]||1)-0;g[3]=h[3]-0}g[0]=e++;return g},ATTR:function(g,h,l,m,q,p){h=g[1].replace(/\\/g,"");if(!p&&n.attrMap[h])g[1]=n.attrMap[h];if(g[2]==="~=")g[4]=" "+g[4]+" ";return g},PSEUDO:function(g,h,l,m,q){if(g[1]==="not")if((f.exec(g[3])||"").length>1||/^\w/.test(g[3]))g[3]=k(g[3],null,null,h);else{g=k.filter(g[3],h,l,true^q);l||m.push.apply(m,
                g);return false}else if(n.match.POS.test(g[0])||n.match.CHILD.test(g[0]))return true;return g},POS:function(g){g.unshift(true);return g}},filters:{enabled:function(g){return g.disabled===false&&g.type!=="hidden"},disabled:function(g){return g.disabled===true},checked:function(g){return g.checked===true},selected:function(g){return g.selected===true},parent:function(g){return!!g.firstChild},empty:function(g){return!g.firstChild},has:function(g,h,l){return!!k(l[3],g).length},header:function(g){return/h\d/i.test(g.nodeName)},
            text:function(g){return"text"===g.type},radio:function(g){return"radio"===g.type},checkbox:function(g){return"checkbox"===g.type},file:function(g){return"file"===g.type},password:function(g){return"password"===g.type},submit:function(g){return"submit"===g.type},image:function(g){return"image"===g.type},reset:function(g){return"reset"===g.type},button:function(g){return"button"===g.type||g.nodeName.toLowerCase()==="button"},input:function(g){return/input|select|textarea|button/i.test(g.nodeName)}},
        setFilters:{first:function(g,h){return h===0},last:function(g,h,l,m){return h===m.length-1},even:function(g,h){return h%2===0},odd:function(g,h){return h%2===1},lt:function(g,h,l){return h<l[3]-0},gt:function(g,h,l){return h>l[3]-0},nth:function(g,h,l){return l[3]-0===h},eq:function(g,h,l){return l[3]-0===h}},filter:{PSEUDO:function(g,h,l,m){var q=h[1],p=n.filters[q];if(p)return p(g,l,h,m);else if(q==="contains")return(g.textContent||g.innerText||a([g])||"").indexOf(h[3])>=0;else if(q==="not"){h=
                h[3];l=0;for(m=h.length;l<m;l++)if(h[l]===g)return false;return true}else k.error("Syntax error, unrecognized expression: "+q)},CHILD:function(g,h){var l=h[1],m=g;switch(l){case "only":case "first":for(;m=m.previousSibling;)if(m.nodeType===1)return false;if(l==="first")return true;m=g;case "last":for(;m=m.nextSibling;)if(m.nodeType===1)return false;return true;case "nth":l=h[2];var q=h[3];if(l===1&&q===0)return true;h=h[0];var p=g.parentNode;if(p&&(p.sizcache!==h||!g.nodeIndex)){var v=0;for(m=p.firstChild;m;m=
                m.nextSibling)if(m.nodeType===1)m.nodeIndex=++v;p.sizcache=h}g=g.nodeIndex-q;return l===0?g===0:g%l===0&&g/l>=0}},ID:function(g,h){return g.nodeType===1&&g.getAttribute("id")===h},TAG:function(g,h){return h==="*"&&g.nodeType===1||g.nodeName.toLowerCase()===h},CLASS:function(g,h){return(" "+(g.className||g.getAttribute("class"))+" ").indexOf(h)>-1},ATTR:function(g,h){var l=h[1];g=n.attrHandle[l]?n.attrHandle[l](g):g[l]!=null?g[l]:g.getAttribute(l);l=g+"";var m=h[2];h=h[4];return g==null?m==="!=":m===
            "="?l===h:m==="*="?l.indexOf(h)>=0:m==="~="?(" "+l+" ").indexOf(h)>=0:!h?l&&g!==false:m==="!="?l!==h:m==="^="?l.indexOf(h)===0:m==="$="?l.substr(l.length-h.length)===h:m==="|="?l===h||l.substr(0,h.length+1)===h+"-":false},POS:function(g,h,l,m){var q=n.setFilters[h[2]];if(q)return q(g,l,h,m)}}},r=n.match.POS;for(var u in n.match){n.match[u]=new RegExp(n.match[u].source+/(?![^\[]*\])(?![^\(]*\))/.source);n.leftMatch[u]=new RegExp(/(^(?:.|\r|\n)*?)/.source+n.match[u].source.replace(/\\(\d+)/g,function(g,
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    h){return"\\"+(h-0+1)}))}var z=function(g,h){g=Array.prototype.slice.call(g,0);if(h){h.push.apply(h,g);return h}return g};try{Array.prototype.slice.call(s.documentElement.childNodes,0)}catch(C){z=function(g,h){h=h||[];if(j.call(g)==="[object Array]")Array.prototype.push.apply(h,g);else if(typeof g.length==="number")for(var l=0,m=g.length;l<m;l++)h.push(g[l]);else for(l=0;g[l];l++)h.push(g[l]);return h}}var B;if(s.documentElement.compareDocumentPosition)B=function(g,h){if(!g.compareDocumentPosition||
        !h.compareDocumentPosition){if(g==h)i=true;return g.compareDocumentPosition?-1:1}g=g.compareDocumentPosition(h)&4?-1:g===h?0:1;if(g===0)i=true;return g};else if("sourceIndex"in s.documentElement)B=function(g,h){if(!g.sourceIndex||!h.sourceIndex){if(g==h)i=true;return g.sourceIndex?-1:1}g=g.sourceIndex-h.sourceIndex;if(g===0)i=true;return g};else if(s.createRange)B=function(g,h){if(!g.ownerDocument||!h.ownerDocument){if(g==h)i=true;return g.ownerDocument?-1:1}var l=g.ownerDocument.createRange(),m=
        h.ownerDocument.createRange();l.setStart(g,0);l.setEnd(g,0);m.setStart(h,0);m.setEnd(h,0);g=l.compareBoundaryPoints(Range.START_TO_END,m);if(g===0)i=true;return g};(function(){var g=s.createElement("div"),h="script"+(new Date).getTime();g.innerHTML="<a name='"+h+"'/>";var l=s.documentElement;l.insertBefore(g,l.firstChild);if(s.getElementById(h)){n.find.ID=function(m,q,p){if(typeof q.getElementById!=="undefined"&&!p)return(q=q.getElementById(m[1]))?q.id===m[1]||typeof q.getAttributeNode!=="undefined"&&
    q.getAttributeNode("id").nodeValue===m[1]?[q]:w:[]};n.filter.ID=function(m,q){var p=typeof m.getAttributeNode!=="undefined"&&m.getAttributeNode("id");return m.nodeType===1&&p&&p.nodeValue===q}}l.removeChild(g);l=g=null})();(function(){var g=s.createElement("div");g.appendChild(s.createComment(""));if(g.getElementsByTagName("*").length>0)n.find.TAG=function(h,l){l=l.getElementsByTagName(h[1]);if(h[1]==="*"){h=[];for(var m=0;l[m];m++)l[m].nodeType===1&&h.push(l[m]);l=h}return l};g.innerHTML="<a href='#'></a>";
        if(g.firstChild&&typeof g.firstChild.getAttribute!=="undefined"&&g.firstChild.getAttribute("href")!=="#")n.attrHandle.href=function(h){return h.getAttribute("href",2)};g=null})();s.querySelectorAll&&function(){var g=k,h=s.createElement("div");h.innerHTML="<p class='TEST'></p>";if(!(h.querySelectorAll&&h.querySelectorAll(".TEST").length===0)){k=function(m,q,p,v){q=q||s;if(!v&&q.nodeType===9&&!x(q))try{return z(q.querySelectorAll(m),p)}catch(t){}return g(m,q,p,v)};for(var l in g)k[l]=g[l];h=null}}();
        (function(){var g=s.createElement("div");g.innerHTML="<div class='test e'></div><div class='test'></div>";if(!(!g.getElementsByClassName||g.getElementsByClassName("e").length===0)){g.lastChild.className="e";if(g.getElementsByClassName("e").length!==1){n.order.splice(1,0,"CLASS");n.find.CLASS=function(h,l,m){if(typeof l.getElementsByClassName!=="undefined"&&!m)return l.getElementsByClassName(h[1])};g=null}}})();var E=s.compareDocumentPosition?function(g,h){return!!(g.compareDocumentPosition(h)&16)}:
            function(g,h){return g!==h&&(g.contains?g.contains(h):true)},x=function(g){return(g=(g?g.ownerDocument||g:0).documentElement)?g.nodeName!=="HTML":false},ga=function(g,h){var l=[],m="",q;for(h=h.nodeType?[h]:h;q=n.match.PSEUDO.exec(g);){m+=q[0];g=g.replace(n.match.PSEUDO,"")}g=n.relative[g]?g+"*":g;q=0;for(var p=h.length;q<p;q++)k(g,h[q],l);return k.filter(m,l)};c.find=k;c.expr=k.selectors;c.expr[":"]=c.expr.filters;c.unique=k.uniqueSort;c.text=a;c.isXMLDoc=x;c.contains=E})();var eb=/Until$/,fb=/^(?:parents|prevUntil|prevAll)/,
        gb=/,/;R=Array.prototype.slice;var Ia=function(a,b,d){if(c.isFunction(b))return c.grep(a,function(e,j){return!!b.call(e,j,e)===d});else if(b.nodeType)return c.grep(a,function(e){return e===b===d});else if(typeof b==="string"){var f=c.grep(a,function(e){return e.nodeType===1});if(Ua.test(b))return c.filter(b,f,!d);else b=c.filter(b,f)}return c.grep(a,function(e){return c.inArray(e,b)>=0===d})};c.fn.extend({find:function(a){for(var b=this.pushStack("","find",a),d=0,f=0,e=this.length;f<e;f++){d=b.length;
            c.find(a,this[f],b);if(f>0)for(var j=d;j<b.length;j++)for(var i=0;i<d;i++)if(b[i]===b[j]){b.splice(j--,1);break}}return b},has:function(a){var b=c(a);return this.filter(function(){for(var d=0,f=b.length;d<f;d++)if(c.contains(this,b[d]))return true})},not:function(a){return this.pushStack(Ia(this,a,false),"not",a)},filter:function(a){return this.pushStack(Ia(this,a,true),"filter",a)},is:function(a){return!!a&&c.filter(a,this).length>0},closest:function(a,b){if(c.isArray(a)){var d=[],f=this[0],e,j=
            {},i;if(f&&a.length){e=0;for(var o=a.length;e<o;e++){i=a[e];j[i]||(j[i]=c.expr.match.POS.test(i)?c(i,b||this.context):i)}for(;f&&f.ownerDocument&&f!==b;){for(i in j){e=j[i];if(e.jquery?e.index(f)>-1:c(f).is(e)){d.push({selector:i,elem:f});delete j[i]}}f=f.parentNode}}return d}var k=c.expr.match.POS.test(a)?c(a,b||this.context):null;return this.map(function(n,r){for(;r&&r.ownerDocument&&r!==b;){if(k?k.index(r)>-1:c(r).is(a))return r;r=r.parentNode}return null})},index:function(a){if(!a||typeof a===
            "string")return c.inArray(this[0],a?c(a):this.parent().children());return c.inArray(a.jquery?a[0]:a,this)},add:function(a,b){a=typeof a==="string"?c(a,b||this.context):c.makeArray(a);b=c.merge(this.get(),a);return this.pushStack(qa(a[0])||qa(b[0])?b:c.unique(b))},andSelf:function(){return this.add(this.prevObject)}});c.each({parent:function(a){return(a=a.parentNode)&&a.nodeType!==11?a:null},parents:function(a){return c.dir(a,"parentNode")},parentsUntil:function(a,b,d){return c.dir(a,"parentNode",
            d)},next:function(a){return c.nth(a,2,"nextSibling")},prev:function(a){return c.nth(a,2,"previousSibling")},nextAll:function(a){return c.dir(a,"nextSibling")},prevAll:function(a){return c.dir(a,"previousSibling")},nextUntil:function(a,b,d){return c.dir(a,"nextSibling",d)},prevUntil:function(a,b,d){return c.dir(a,"previousSibling",d)},siblings:function(a){return c.sibling(a.parentNode.firstChild,a)},children:function(a){return c.sibling(a.firstChild)},contents:function(a){return c.nodeName(a,"iframe")?
            a.contentDocument||a.contentWindow.document:c.makeArray(a.childNodes)}},function(a,b){c.fn[a]=function(d,f){var e=c.map(this,b,d);eb.test(a)||(f=d);if(f&&typeof f==="string")e=c.filter(f,e);e=this.length>1?c.unique(e):e;if((this.length>1||gb.test(f))&&fb.test(a))e=e.reverse();return this.pushStack(e,a,R.call(arguments).join(","))}});c.extend({filter:function(a,b,d){if(d)a=":not("+a+")";return c.find.matches(a,b)},dir:function(a,b,d){var f=[];for(a=a[b];a&&a.nodeType!==9&&(d===w||a.nodeType!==1||!c(a).is(d));){a.nodeType===
        1&&f.push(a);a=a[b]}return f},nth:function(a,b,d){b=b||1;for(var f=0;a;a=a[d])if(a.nodeType===1&&++f===b)break;return a},sibling:function(a,b){for(var d=[];a;a=a.nextSibling)a.nodeType===1&&a!==b&&d.push(a);return d}});var Ja=/ jQuery\d+="(?:\d+|null)"/g,V=/^\s+/,Ka=/(<([\w:]+)[^>]*?)\/>/g,hb=/^(?:area|br|col|embed|hr|img|input|link|meta|param)$/i,La=/<([\w:]+)/,ib=/<tbody/i,jb=/<|&#?\w+;/,ta=/<script|<object|<embed|<option|<style/i,ua=/checked\s*(?:[^=]|=\s*.checked.)/i,Ma=function(a,b,d){return hb.test(d)?
        a:b+"></"+d+">"},F={option:[1,"<select multiple='multiple'>","</select>"],legend:[1,"<fieldset>","</fieldset>"],thead:[1,"<table>","</table>"],tr:[2,"<table><tbody>","</tbody></table>"],td:[3,"<table><tbody><tr>","</tr></tbody></table>"],col:[2,"<table><tbody></tbody><colgroup>","</colgroup></table>"],area:[1,"<map>","</map>"],_default:[0,"",""]};F.optgroup=F.option;F.tbody=F.tfoot=F.colgroup=F.caption=F.thead;F.th=F.td;if(!c.support.htmlSerialize)F._default=[1,"div<div>","</div>"];c.fn.extend({text:function(a){if(c.isFunction(a))return this.each(function(b){var d=
            c(this);d.text(a.call(this,b,d.text()))});if(typeof a!=="object"&&a!==w)return this.empty().append((this[0]&&this[0].ownerDocument||s).createTextNode(a));return c.text(this)},wrapAll:function(a){if(c.isFunction(a))return this.each(function(d){c(this).wrapAll(a.call(this,d))});if(this[0]){var b=c(a,this[0].ownerDocument).eq(0).clone(true);this[0].parentNode&&b.insertBefore(this[0]);b.map(function(){for(var d=this;d.firstChild&&d.firstChild.nodeType===1;)d=d.firstChild;return d}).append(this)}return this},
        wrapInner:function(a){if(c.isFunction(a))return this.each(function(b){c(this).wrapInner(a.call(this,b))});return this.each(function(){var b=c(this),d=b.contents();d.length?d.wrapAll(a):b.append(a)})},wrap:function(a){return this.each(function(){c(this).wrapAll(a)})},unwrap:function(){return this.parent().each(function(){c.nodeName(this,"body")||c(this).replaceWith(this.childNodes)}).end()},append:function(){return this.domManip(arguments,true,function(a){this.nodeType===1&&this.appendChild(a)})},
        prepend:function(){return this.domManip(arguments,true,function(a){this.nodeType===1&&this.insertBefore(a,this.firstChild)})},before:function(){if(this[0]&&this[0].parentNode)return this.domManip(arguments,false,function(b){this.parentNode.insertBefore(b,this)});else if(arguments.length){var a=c(arguments[0]);a.push.apply(a,this.toArray());return this.pushStack(a,"before",arguments)}},after:function(){if(this[0]&&this[0].parentNode)return this.domManip(arguments,false,function(b){this.parentNode.insertBefore(b,
            this.nextSibling)});else if(arguments.length){var a=this.pushStack(this,"after",arguments);a.push.apply(a,c(arguments[0]).toArray());return a}},remove:function(a,b){for(var d=0,f;(f=this[d])!=null;d++)if(!a||c.filter(a,[f]).length){if(!b&&f.nodeType===1){c.cleanData(f.getElementsByTagName("*"));c.cleanData([f])}f.parentNode&&f.parentNode.removeChild(f)}return this},empty:function(){for(var a=0,b;(b=this[a])!=null;a++)for(b.nodeType===1&&c.cleanData(b.getElementsByTagName("*"));b.firstChild;)b.removeChild(b.firstChild);
            return this},clone:function(a){var b=this.map(function(){if(!c.support.noCloneEvent&&!c.isXMLDoc(this)){var d=this.outerHTML,f=this.ownerDocument;if(!d){d=f.createElement("div");d.appendChild(this.cloneNode(true));d=d.innerHTML}return c.clean([d.replace(Ja,"").replace(/=([^="'>\s]+\/)>/g,'="$1">').replace(V,"")],f)[0]}else return this.cloneNode(true)});if(a===true){ra(this,b);ra(this.find("*"),b.find("*"))}return b},html:function(a){if(a===w)return this[0]&&this[0].nodeType===1?this[0].innerHTML.replace(Ja,
            ""):null;else if(typeof a==="string"&&!ta.test(a)&&(c.support.leadingWhitespace||!V.test(a))&&!F[(La.exec(a)||["",""])[1].toLowerCase()]){a=a.replace(Ka,Ma);try{for(var b=0,d=this.length;b<d;b++)if(this[b].nodeType===1){c.cleanData(this[b].getElementsByTagName("*"));this[b].innerHTML=a}}catch(f){this.empty().append(a)}}else c.isFunction(a)?this.each(function(e){var j=c(this),i=j.html();j.empty().append(function(){return a.call(this,e,i)})}):this.empty().append(a);return this},replaceWith:function(a){if(this[0]&&
            this[0].parentNode){if(c.isFunction(a))return this.each(function(b){var d=c(this),f=d.html();d.replaceWith(a.call(this,b,f))});if(typeof a!=="string")a=c(a).detach();return this.each(function(){var b=this.nextSibling,d=this.parentNode;c(this).remove();b?c(b).before(a):c(d).append(a)})}else return this.pushStack(c(c.isFunction(a)?a():a),"replaceWith",a)},detach:function(a){return this.remove(a,true)},domManip:function(a,b,d){function f(u){return c.nodeName(u,"table")?u.getElementsByTagName("tbody")[0]||
            u.appendChild(u.ownerDocument.createElement("tbody")):u}var e,j,i=a[0],o=[],k;if(!c.support.checkClone&&arguments.length===3&&typeof i==="string"&&ua.test(i))return this.each(function(){c(this).domManip(a,b,d,true)});if(c.isFunction(i))return this.each(function(u){var z=c(this);a[0]=i.call(this,u,b?z.html():w);z.domManip(a,b,d)});if(this[0]){e=i&&i.parentNode;e=c.support.parentNode&&e&&e.nodeType===11&&e.childNodes.length===this.length?{fragment:e}:sa(a,this,o);k=e.fragment;if(j=k.childNodes.length===
        1?(k=k.firstChild):k.firstChild){b=b&&c.nodeName(j,"tr");for(var n=0,r=this.length;n<r;n++)d.call(b?f(this[n],j):this[n],n>0||e.cacheable||this.length>1?k.cloneNode(true):k)}o.length&&c.each(o,Qa)}return this}});c.fragments={};c.each({appendTo:"append",prependTo:"prepend",insertBefore:"before",insertAfter:"after",replaceAll:"replaceWith"},function(a,b){c.fn[a]=function(d){var f=[];d=c(d);var e=this.length===1&&this[0].parentNode;if(e&&e.nodeType===11&&e.childNodes.length===1&&d.length===1){d[b](this[0]);
        return this}else{e=0;for(var j=d.length;e<j;e++){var i=(e>0?this.clone(true):this).get();c.fn[b].apply(c(d[e]),i);f=f.concat(i)}return this.pushStack(f,a,d.selector)}}});c.extend({clean:function(a,b,d,f){b=b||s;if(typeof b.createElement==="undefined")b=b.ownerDocument||b[0]&&b[0].ownerDocument||s;for(var e=[],j=0,i;(i=a[j])!=null;j++){if(typeof i==="number")i+="";if(i){if(typeof i==="string"&&!jb.test(i))i=b.createTextNode(i);else if(typeof i==="string"){i=i.replace(Ka,Ma);var o=(La.exec(i)||["",
            ""])[1].toLowerCase(),k=F[o]||F._default,n=k[0],r=b.createElement("div");for(r.innerHTML=k[1]+i+k[2];n--;)r=r.lastChild;if(!c.support.tbody){n=ib.test(i);o=o==="table"&&!n?r.firstChild&&r.firstChild.childNodes:k[1]==="<table>"&&!n?r.childNodes:[];for(k=o.length-1;k>=0;--k)c.nodeName(o[k],"tbody")&&!o[k].childNodes.length&&o[k].parentNode.removeChild(o[k])}!c.support.leadingWhitespace&&V.test(i)&&r.insertBefore(b.createTextNode(V.exec(i)[0]),r.firstChild);i=r.childNodes}if(i.nodeType)e.push(i);else e=
            c.merge(e,i)}}if(d)for(j=0;e[j];j++)if(f&&c.nodeName(e[j],"script")&&(!e[j].type||e[j].type.toLowerCase()==="text/javascript"))f.push(e[j].parentNode?e[j].parentNode.removeChild(e[j]):e[j]);else{e[j].nodeType===1&&e.splice.apply(e,[j+1,0].concat(c.makeArray(e[j].getElementsByTagName("script"))));d.appendChild(e[j])}return e},cleanData:function(a){for(var b,d,f=c.cache,e=c.event.special,j=c.support.deleteExpando,i=0,o;(o=a[i])!=null;i++)if(d=o[c.expando]){b=f[d];if(b.events)for(var k in b.events)e[k]?
            c.event.remove(o,k):Ca(o,k,b.handle);if(j)delete o[c.expando];else o.removeAttribute&&o.removeAttribute(c.expando);delete f[d]}}});var kb=/z-?index|font-?weight|opacity|zoom|line-?height/i,Na=/alpha\([^)]*\)/,Oa=/opacity=([^)]*)/,ha=/float/i,ia=/-([a-z])/ig,lb=/([A-Z])/g,mb=/^-?\d+(?:px)?$/i,nb=/^-?\d/,ob={position:"absolute",visibility:"hidden",display:"block"},pb=["Left","Right"],qb=["Top","Bottom"],rb=s.defaultView&&s.defaultView.getComputedStyle,Pa=c.support.cssFloat?"cssFloat":"styleFloat",ja=
        function(a,b){return b.toUpperCase()};c.fn.css=function(a,b){return X(this,a,b,true,function(d,f,e){if(e===w)return c.curCSS(d,f);if(typeof e==="number"&&!kb.test(f))e+="px";c.style(d,f,e)})};c.extend({style:function(a,b,d){if(!a||a.nodeType===3||a.nodeType===8)return w;if((b==="width"||b==="height")&&parseFloat(d)<0)d=w;var f=a.style||a,e=d!==w;if(!c.support.opacity&&b==="opacity"){if(e){f.zoom=1;b=parseInt(d,10)+""==="NaN"?"":"alpha(opacity="+d*100+")";a=f.filter||c.curCSS(a,"filter")||"";f.filter=
            Na.test(a)?a.replace(Na,b):b}return f.filter&&f.filter.indexOf("opacity=")>=0?parseFloat(Oa.exec(f.filter)[1])/100+"":""}if(ha.test(b))b=Pa;b=b.replace(ia,ja);if(e)f[b]=d;return f[b]},css:function(a,b,d,f){if(b==="width"||b==="height"){var e,j=b==="width"?pb:qb;function i(){e=b==="width"?a.offsetWidth:a.offsetHeight;f!=="border"&&c.each(j,function(){f||(e-=parseFloat(c.curCSS(a,"padding"+this,true))||0);if(f==="margin")e+=parseFloat(c.curCSS(a,"margin"+this,true))||0;else e-=parseFloat(c.curCSS(a,
            "border"+this+"Width",true))||0})}a.offsetWidth!==0?i():c.swap(a,ob,i);return Math.max(0,Math.round(e))}return c.curCSS(a,b,d)},curCSS:function(a,b,d){var f,e=a.style;if(!c.support.opacity&&b==="opacity"&&a.currentStyle){f=Oa.test(a.currentStyle.filter||"")?parseFloat(RegExp.$1)/100+"":"";return f===""?"1":f}if(ha.test(b))b=Pa;if(!d&&e&&e[b])f=e[b];else if(rb){if(ha.test(b))b="float";b=b.replace(lb,"-$1").toLowerCase();e=a.ownerDocument.defaultView;if(!e)return null;if(a=e.getComputedStyle(a,null))f=
            a.getPropertyValue(b);if(b==="opacity"&&f==="")f="1"}else if(a.currentStyle){d=b.replace(ia,ja);f=a.currentStyle[b]||a.currentStyle[d];if(!mb.test(f)&&nb.test(f)){b=e.left;var j=a.runtimeStyle.left;a.runtimeStyle.left=a.currentStyle.left;e.left=d==="fontSize"?"1em":f||0;f=e.pixelLeft+"px";e.left=b;a.runtimeStyle.left=j}}return f},swap:function(a,b,d){var f={};for(var e in b){f[e]=a.style[e];a.style[e]=b[e]}d.call(a);for(e in b)a.style[e]=f[e]}});if(c.expr&&c.expr.filters){c.expr.filters.hidden=function(a){var b=
        a.offsetWidth,d=a.offsetHeight,f=a.nodeName.toLowerCase()==="tr";return b===0&&d===0&&!f?true:b>0&&d>0&&!f?false:c.curCSS(a,"display")==="none"};c.expr.filters.visible=function(a){return!c.expr.filters.hidden(a)}}var sb=J(),tb=/<script(.|\s)*?\/script>/gi,ub=/select|textarea/i,vb=/color|date|datetime|email|hidden|month|number|password|range|search|tel|text|time|url|week/i,N=/=\?(&|$)/,ka=/\?/,wb=/(\?|&)_=.*?(&|$)/,xb=/^(\w+:)?\/\/([^\/?#]+)/,yb=/%20/g,zb=c.fn.load;c.fn.extend({load:function(a,b,d){if(typeof a!==
            "string")return zb.call(this,a);else if(!this.length)return this;var f=a.indexOf(" ");if(f>=0){var e=a.slice(f,a.length);a=a.slice(0,f)}f="GET";if(b)if(c.isFunction(b)){d=b;b=null}else if(typeof b==="object"){b=c.param(b,c.ajaxSettings.traditional);f="POST"}var j=this;c.ajax({url:a,type:f,dataType:"html",data:b,complete:function(i,o){if(o==="success"||o==="notmodified")j.html(e?c("<div />").append(i.responseText.replace(tb,"")).find(e):i.responseText);d&&j.each(d,[i.responseText,o,i])}});return this},
        serialize:function(){return c.param(this.serializeArray())},serializeArray:function(){return this.map(function(){return this.elements?c.makeArray(this.elements):this}).filter(function(){return this.name&&!this.disabled&&(this.checked||ub.test(this.nodeName)||vb.test(this.type))}).map(function(a,b){a=c(this).val();return a==null?null:c.isArray(a)?c.map(a,function(d){return{name:b.name,value:d}}):{name:b.name,value:a}}).get()}});c.each("ajaxStart ajaxStop ajaxComplete ajaxError ajaxSuccess ajaxSend".split(" "),
        function(a,b){c.fn[b]=function(d){return this.bind(b,d)}});c.extend({get:function(a,b,d,f){if(c.isFunction(b)){f=f||d;d=b;b=null}return c.ajax({type:"GET",url:a,data:b,success:d,dataType:f})},getScript:function(a,b){return c.get(a,null,b,"script")},getJSON:function(a,b,d){return c.get(a,b,d,"json")},post:function(a,b,d,f){if(c.isFunction(b)){f=f||d;d=b;b={}}return c.ajax({type:"POST",url:a,data:b,success:d,dataType:f})},ajaxSetup:function(a){c.extend(c.ajaxSettings,a)},ajaxSettings:{url:location.href,
            global:true,type:"GET",contentType:"application/x-www-form-urlencoded",processData:true,async:true,xhr:A.XMLHttpRequest&&(A.location.protocol!=="file:"||!A.ActiveXObject)?function(){return new A.XMLHttpRequest}:function(){try{return new A.ActiveXObject("Microsoft.XMLHTTP")}catch(a){}},accepts:{xml:"application/xml, text/xml",html:"text/html",script:"text/javascript, application/javascript",json:"application/json, text/javascript",text:"text/plain",_default:"*/*"}},lastModified:{},etag:{},ajax:function(a){function b(){e.success&&
        e.success.call(k,o,i,x);e.global&&f("ajaxSuccess",[x,e])}function d(){e.complete&&e.complete.call(k,x,i);e.global&&f("ajaxComplete",[x,e]);e.global&&!--c.active&&c.event.trigger("ajaxStop")}function f(q,p){(e.context?c(e.context):c.event).trigger(q,p)}var e=c.extend(true,{},c.ajaxSettings,a),j,i,o,k=a&&a.context||e,n=e.type.toUpperCase();if(e.data&&e.processData&&typeof e.data!=="string")e.data=c.param(e.data,e.traditional);if(e.dataType==="jsonp"){if(n==="GET")N.test(e.url)||(e.url+=(ka.test(e.url)?
            "&":"?")+(e.jsonp||"callback")+"=?");else if(!e.data||!N.test(e.data))e.data=(e.data?e.data+"&":"")+(e.jsonp||"callback")+"=?";e.dataType="json"}if(e.dataType==="json"&&(e.data&&N.test(e.data)||N.test(e.url))){j=e.jsonpCallback||"jsonp"+sb++;if(e.data)e.data=(e.data+"").replace(N,"="+j+"$1");e.url=e.url.replace(N,"="+j+"$1");e.dataType="script";A[j]=A[j]||function(q){o=q;b();d();A[j]=w;try{delete A[j]}catch(p){}z&&z.removeChild(C)}}if(e.dataType==="script"&&e.cache===null)e.cache=false;if(e.cache===
            false&&n==="GET"){var r=J(),u=e.url.replace(wb,"$1_="+r+"$2");e.url=u+(u===e.url?(ka.test(e.url)?"&":"?")+"_="+r:"")}if(e.data&&n==="GET")e.url+=(ka.test(e.url)?"&":"?")+e.data;e.global&&!c.active++&&c.event.trigger("ajaxStart");r=(r=xb.exec(e.url))&&(r[1]&&r[1]!==location.protocol||r[2]!==location.host);if(e.dataType==="script"&&n==="GET"&&r){var z=s.getElementsByTagName("head")[0]||s.documentElement,C=s.createElement("script");C.src=e.url;if(e.scriptCharset)C.charset=e.scriptCharset;if(!j){var B=
            false;C.onload=C.onreadystatechange=function(){if(!B&&(!this.readyState||this.readyState==="loaded"||this.readyState==="complete")){B=true;b();d();C.onload=C.onreadystatechange=null;z&&C.parentNode&&z.removeChild(C)}}}z.insertBefore(C,z.firstChild);return w}var E=false,x=e.xhr();if(x){e.username?x.open(n,e.url,e.async,e.username,e.password):x.open(n,e.url,e.async);try{if(e.data||a&&a.contentType)x.setRequestHeader("Content-Type",e.contentType);if(e.ifModified){c.lastModified[e.url]&&x.setRequestHeader("If-Modified-Since",
            c.lastModified[e.url]);c.etag[e.url]&&x.setRequestHeader("If-None-Match",c.etag[e.url])}r||x.setRequestHeader("X-Requested-With","XMLHttpRequest");x.setRequestHeader("Accept",e.dataType&&e.accepts[e.dataType]?e.accepts[e.dataType]+", */*":e.accepts._default)}catch(ga){}if(e.beforeSend&&e.beforeSend.call(k,x,e)===false){e.global&&!--c.active&&c.event.trigger("ajaxStop");x.abort();return false}e.global&&f("ajaxSend",[x,e]);var g=x.onreadystatechange=function(q){if(!x||x.readyState===0||q==="abort"){E||
        d();E=true;if(x)x.onreadystatechange=c.noop}else if(!E&&x&&(x.readyState===4||q==="timeout")){E=true;x.onreadystatechange=c.noop;i=q==="timeout"?"timeout":!c.httpSuccess(x)?"error":e.ifModified&&c.httpNotModified(x,e.url)?"notmodified":"success";var p;if(i==="success")try{o=c.httpData(x,e.dataType,e)}catch(v){i="parsererror";p=v}if(i==="success"||i==="notmodified")j||b();else c.handleError(e,x,i,p);d();q==="timeout"&&x.abort();if(e.async)x=null}};try{var h=x.abort;x.abort=function(){x&&h.call(x);
            g("abort")}}catch(l){}e.async&&e.timeout>0&&setTimeout(function(){x&&!E&&g("timeout")},e.timeout);try{x.send(n==="POST"||n==="PUT"||n==="DELETE"?e.data:null)}catch(m){c.handleError(e,x,null,m);d()}e.async||g();return x}},handleError:function(a,b,d,f){if(a.error)a.error.call(a.context||a,b,d,f);if(a.global)(a.context?c(a.context):c.event).trigger("ajaxError",[b,a,f])},active:0,httpSuccess:function(a){try{return!a.status&&location.protocol==="file:"||a.status>=200&&a.status<300||a.status===304||a.status===
            1223||a.status===0}catch(b){}return false},httpNotModified:function(a,b){var d=a.getResponseHeader("Last-Modified"),f=a.getResponseHeader("Etag");if(d)c.lastModified[b]=d;if(f)c.etag[b]=f;return a.status===304||a.status===0},httpData:function(a,b,d){var f=a.getResponseHeader("content-type")||"",e=b==="xml"||!b&&f.indexOf("xml")>=0;a=e?a.responseXML:a.responseText;e&&a.documentElement.nodeName==="parsererror"&&c.error("parsererror");if(d&&d.dataFilter)a=d.dataFilter(a,b);if(typeof a==="string")if(b===
            "json"||!b&&f.indexOf("json")>=0)a=c.parseJSON(a);else if(b==="script"||!b&&f.indexOf("javascript")>=0)c.globalEval(a);return a},param:function(a,b){function d(i,o){if(c.isArray(o))c.each(o,function(k,n){b||/\[\]$/.test(i)?f(i,n):d(i+"["+(typeof n==="object"||c.isArray(n)?k:"")+"]",n)});else!b&&o!=null&&typeof o==="object"?c.each(o,function(k,n){d(i+"["+k+"]",n)}):f(i,o)}function f(i,o){o=c.isFunction(o)?o():o;e[e.length]=encodeURIComponent(i)+"="+encodeURIComponent(o)}var e=[];if(b===w)b=c.ajaxSettings.traditional;
            if(c.isArray(a)||a.jquery)c.each(a,function(){f(this.name,this.value)});else for(var j in a)d(j,a[j]);return e.join("&").replace(yb,"+")}});var la={},Ab=/toggle|show|hide/,Bb=/^([+-]=)?([\d+-.]+)(.*)$/,W,va=[["height","marginTop","marginBottom","paddingTop","paddingBottom"],["width","marginLeft","marginRight","paddingLeft","paddingRight"],["opacity"]];c.fn.extend({show:function(a,b){if(a||a===0)return this.animate(K("show",3),a,b);else{a=0;for(b=this.length;a<b;a++){var d=c.data(this[a],"olddisplay");
            this[a].style.display=d||"";if(c.css(this[a],"display")==="none"){d=this[a].nodeName;var f;if(la[d])f=la[d];else{var e=c("<"+d+" />").appendTo("body");f=e.css("display");if(f==="none")f="block";e.remove();la[d]=f}c.data(this[a],"olddisplay",f)}}a=0;for(b=this.length;a<b;a++)this[a].style.display=c.data(this[a],"olddisplay")||"";return this}},hide:function(a,b){if(a||a===0)return this.animate(K("hide",3),a,b);else{a=0;for(b=this.length;a<b;a++){var d=c.data(this[a],"olddisplay");!d&&d!=="none"&&c.data(this[a],
            "olddisplay",c.css(this[a],"display"))}a=0;for(b=this.length;a<b;a++)this[a].style.display="none";return this}},_toggle:c.fn.toggle,toggle:function(a,b){var d=typeof a==="boolean";if(c.isFunction(a)&&c.isFunction(b))this._toggle.apply(this,arguments);else a==null||d?this.each(function(){var f=d?a:c(this).is(":hidden");c(this)[f?"show":"hide"]()}):this.animate(K("toggle",3),a,b);return this},fadeTo:function(a,b,d){return this.filter(":hidden").css("opacity",0).show().end().animate({opacity:b},a,d)},
        animate:function(a,b,d,f){var e=c.speed(b,d,f);if(c.isEmptyObject(a))return this.each(e.complete);return this[e.queue===false?"each":"queue"](function(){var j=c.extend({},e),i,o=this.nodeType===1&&c(this).is(":hidden"),k=this;for(i in a){var n=i.replace(ia,ja);if(i!==n){a[n]=a[i];delete a[i];i=n}if(a[i]==="hide"&&o||a[i]==="show"&&!o)return j.complete.call(this);if((i==="height"||i==="width")&&this.style){j.display=c.css(this,"display");j.overflow=this.style.overflow}if(c.isArray(a[i])){(j.specialEasing=
            j.specialEasing||{})[i]=a[i][1];a[i]=a[i][0]}}if(j.overflow!=null)this.style.overflow="hidden";j.curAnim=c.extend({},a);c.each(a,function(r,u){var z=new c.fx(k,j,r);if(Ab.test(u))z[u==="toggle"?o?"show":"hide":u](a);else{var C=Bb.exec(u),B=z.cur(true)||0;if(C){u=parseFloat(C[2]);var E=C[3]||"px";if(E!=="px"){k.style[r]=(u||1)+E;B=(u||1)/z.cur(true)*B;k.style[r]=B+E}if(C[1])u=(C[1]==="-="?-1:1)*u+B;z.custom(B,u,E)}else z.custom(B,u,"")}});return true})},stop:function(a,b){var d=c.timers;a&&this.queue([]);
            this.each(function(){for(var f=d.length-1;f>=0;f--)if(d[f].elem===this){b&&d[f](true);d.splice(f,1)}});b||this.dequeue();return this}});c.each({slideDown:K("show",1),slideUp:K("hide",1),slideToggle:K("toggle",1),fadeIn:{opacity:"show"},fadeOut:{opacity:"hide"}},function(a,b){c.fn[a]=function(d,f){return this.animate(b,d,f)}});c.extend({speed:function(a,b,d){var f=a&&typeof a==="object"?a:{complete:d||!d&&b||c.isFunction(a)&&a,duration:a,easing:d&&b||b&&!c.isFunction(b)&&b};f.duration=c.fx.off?0:typeof f.duration===
        "number"?f.duration:c.fx.speeds[f.duration]||c.fx.speeds._default;f.old=f.complete;f.complete=function(){f.queue!==false&&c(this).dequeue();c.isFunction(f.old)&&f.old.call(this)};return f},easing:{linear:function(a,b,d,f){return d+f*a},swing:function(a,b,d,f){return(-Math.cos(a*Math.PI)/2+0.5)*f+d}},timers:[],fx:function(a,b,d){this.options=b;this.elem=a;this.prop=d;if(!b.orig)b.orig={}}});c.fx.prototype={update:function(){this.options.step&&this.options.step.call(this.elem,this.now,this);(c.fx.step[this.prop]||
            c.fx.step._default)(this);if((this.prop==="height"||this.prop==="width")&&this.elem.style)this.elem.style.display="block"},cur:function(a){if(this.elem[this.prop]!=null&&(!this.elem.style||this.elem.style[this.prop]==null))return this.elem[this.prop];return(a=parseFloat(c.css(this.elem,this.prop,a)))&&a>-10000?a:parseFloat(c.curCSS(this.elem,this.prop))||0},custom:function(a,b,d){function f(j){return e.step(j)}this.startTime=J();this.start=a;this.end=b;this.unit=d||this.unit||"px";this.now=this.start;
            this.pos=this.state=0;var e=this;f.elem=this.elem;if(f()&&c.timers.push(f)&&!W)W=setInterval(c.fx.tick,13)},show:function(){this.options.orig[this.prop]=c.style(this.elem,this.prop);this.options.show=true;this.custom(this.prop==="width"||this.prop==="height"?1:0,this.cur());c(this.elem).show()},hide:function(){this.options.orig[this.prop]=c.style(this.elem,this.prop);this.options.hide=true;this.custom(this.cur(),0)},step:function(a){var b=J(),d=true;if(a||b>=this.options.duration+this.startTime){this.now=
            this.end;this.pos=this.state=1;this.update();this.options.curAnim[this.prop]=true;for(var f in this.options.curAnim)if(this.options.curAnim[f]!==true)d=false;if(d){if(this.options.display!=null){this.elem.style.overflow=this.options.overflow;a=c.data(this.elem,"olddisplay");this.elem.style.display=a?a:this.options.display;if(c.css(this.elem,"display")==="none")this.elem.style.display="block"}this.options.hide&&c(this.elem).hide();if(this.options.hide||this.options.show)for(var e in this.options.curAnim)c.style(this.elem,
            e,this.options.orig[e]);this.options.complete.call(this.elem)}return false}else{e=b-this.startTime;this.state=e/this.options.duration;a=this.options.easing||(c.easing.swing?"swing":"linear");this.pos=c.easing[this.options.specialEasing&&this.options.specialEasing[this.prop]||a](this.state,e,0,1,this.options.duration);this.now=this.start+(this.end-this.start)*this.pos;this.update()}return true}};c.extend(c.fx,{tick:function(){for(var a=c.timers,b=0;b<a.length;b++)a[b]()||a.splice(b--,1);a.length||
        c.fx.stop()},stop:function(){clearInterval(W);W=null},speeds:{slow:600,fast:200,_default:400},step:{opacity:function(a){c.style(a.elem,"opacity",a.now)},_default:function(a){if(a.elem.style&&a.elem.style[a.prop]!=null)a.elem.style[a.prop]=(a.prop==="width"||a.prop==="height"?Math.max(0,a.now):a.now)+a.unit;else a.elem[a.prop]=a.now}}});if(c.expr&&c.expr.filters)c.expr.filters.animated=function(a){return c.grep(c.timers,function(b){return a===b.elem}).length};c.fn.offset="getBoundingClientRect"in s.documentElement?
        function(a){var b=this[0];if(a)return this.each(function(e){c.offset.setOffset(this,a,e)});if(!b||!b.ownerDocument)return null;if(b===b.ownerDocument.body)return c.offset.bodyOffset(b);var d=b.getBoundingClientRect(),f=b.ownerDocument;b=f.body;f=f.documentElement;return{top:d.top+(self.pageYOffset||c.support.boxModel&&f.scrollTop||b.scrollTop)-(f.clientTop||b.clientTop||0),left:d.left+(self.pageXOffset||c.support.boxModel&&f.scrollLeft||b.scrollLeft)-(f.clientLeft||b.clientLeft||0)}}:function(a){var b=
            this[0];if(a)return this.each(function(r){c.offset.setOffset(this,a,r)});if(!b||!b.ownerDocument)return null;if(b===b.ownerDocument.body)return c.offset.bodyOffset(b);c.offset.initialize();var d=b.offsetParent,f=b,e=b.ownerDocument,j,i=e.documentElement,o=e.body;f=(e=e.defaultView)?e.getComputedStyle(b,null):b.currentStyle;for(var k=b.offsetTop,n=b.offsetLeft;(b=b.parentNode)&&b!==o&&b!==i;){if(c.offset.supportsFixedPosition&&f.position==="fixed")break;j=e?e.getComputedStyle(b,null):b.currentStyle;
            k-=b.scrollTop;n-=b.scrollLeft;if(b===d){k+=b.offsetTop;n+=b.offsetLeft;if(c.offset.doesNotAddBorder&&!(c.offset.doesAddBorderForTableAndCells&&/^t(able|d|h)$/i.test(b.nodeName))){k+=parseFloat(j.borderTopWidth)||0;n+=parseFloat(j.borderLeftWidth)||0}f=d;d=b.offsetParent}if(c.offset.subtractsBorderForOverflowNotVisible&&j.overflow!=="visible"){k+=parseFloat(j.borderTopWidth)||0;n+=parseFloat(j.borderLeftWidth)||0}f=j}if(f.position==="relative"||f.position==="static"){k+=o.offsetTop;n+=o.offsetLeft}if(c.offset.supportsFixedPosition&&
            f.position==="fixed"){k+=Math.max(i.scrollTop,o.scrollTop);n+=Math.max(i.scrollLeft,o.scrollLeft)}return{top:k,left:n}};c.offset={initialize:function(){var a=s.body,b=s.createElement("div"),d,f,e,j=parseFloat(c.curCSS(a,"marginTop",true))||0;c.extend(b.style,{position:"absolute",top:0,left:0,margin:0,border:0,width:"1px",height:"1px",visibility:"hidden"});b.innerHTML="<div style='position:absolute;top:0;left:0;margin:0;border:5px solid #000;padding:0;width:1px;height:1px;'><div></div></div><table style='position:absolute;top:0;left:0;margin:0;border:5px solid #000;padding:0;width:1px;height:1px;' cellpadding='0' cellspacing='0'><tr><td></td></tr></table>";
            a.insertBefore(b,a.firstChild);d=b.firstChild;f=d.firstChild;e=d.nextSibling.firstChild.firstChild;this.doesNotAddBorder=f.offsetTop!==5;this.doesAddBorderForTableAndCells=e.offsetTop===5;f.style.position="fixed";f.style.top="20px";this.supportsFixedPosition=f.offsetTop===20||f.offsetTop===15;f.style.position=f.style.top="";d.style.overflow="hidden";d.style.position="relative";this.subtractsBorderForOverflowNotVisible=f.offsetTop===-5;this.doesNotIncludeMarginInBodyOffset=a.offsetTop!==j;a.removeChild(b);
            c.offset.initialize=c.noop},bodyOffset:function(a){var b=a.offsetTop,d=a.offsetLeft;c.offset.initialize();if(c.offset.doesNotIncludeMarginInBodyOffset){b+=parseFloat(c.curCSS(a,"marginTop",true))||0;d+=parseFloat(c.curCSS(a,"marginLeft",true))||0}return{top:b,left:d}},setOffset:function(a,b,d){if(/static/.test(c.curCSS(a,"position")))a.style.position="relative";var f=c(a),e=f.offset(),j=parseInt(c.curCSS(a,"top",true),10)||0,i=parseInt(c.curCSS(a,"left",true),10)||0;if(c.isFunction(b))b=b.call(a,
            d,e);d={top:b.top-e.top+j,left:b.left-e.left+i};"using"in b?b.using.call(a,d):f.css(d)}};c.fn.extend({position:function(){if(!this[0])return null;var a=this[0],b=this.offsetParent(),d=this.offset(),f=/^body|html$/i.test(b[0].nodeName)?{top:0,left:0}:b.offset();d.top-=parseFloat(c.curCSS(a,"marginTop",true))||0;d.left-=parseFloat(c.curCSS(a,"marginLeft",true))||0;f.top+=parseFloat(c.curCSS(b[0],"borderTopWidth",true))||0;f.left+=parseFloat(c.curCSS(b[0],"borderLeftWidth",true))||0;return{top:d.top-
                f.top,left:d.left-f.left}},offsetParent:function(){return this.map(function(){for(var a=this.offsetParent||s.body;a&&!/^body|html$/i.test(a.nodeName)&&c.css(a,"position")==="static";)a=a.offsetParent;return a})}});c.each(["Left","Top"],function(a,b){var d="scroll"+b;c.fn[d]=function(f){var e=this[0],j;if(!e)return null;if(f!==w)return this.each(function(){if(j=wa(this))j.scrollTo(!a?f:c(j).scrollLeft(),a?f:c(j).scrollTop());else this[d]=f});else return(j=wa(e))?"pageXOffset"in j?j[a?"pageYOffset":
        "pageXOffset"]:c.support.boxModel&&j.document.documentElement[d]||j.document.body[d]:e[d]}});c.each(["Height","Width"],function(a,b){var d=b.toLowerCase();c.fn["inner"+b]=function(){return this[0]?c.css(this[0],d,false,"padding"):null};c.fn["outer"+b]=function(f){return this[0]?c.css(this[0],d,false,f?"margin":"border"):null};c.fn[d]=function(f){var e=this[0];if(!e)return f==null?null:this;if(c.isFunction(f))return this.each(function(j){var i=c(this);i[d](f.call(this,j,i[d]()))});return"scrollTo"in
    e&&e.document?e.document.compatMode==="CSS1Compat"&&e.document.documentElement["client"+b]||e.document.body["client"+b]:e.nodeType===9?Math.max(e.documentElement["client"+b],e.body["scroll"+b],e.documentElement["scroll"+b],e.body["offset"+b],e.documentElement["offset"+b]):f===w?c.css(e,d):this.css(d,typeof f==="string"?f:f+"px")}});A.jQuery=A.$=c})(window);
(function($){var tmp,loading,overlay,wrap,outer,inner,close,nav_left,nav_right,selectedIndex=0,selectedOpts={},selectedArray=[],currentIndex=0,currentOpts={},currentArray=[],ajaxLoader=null,imgPreloader=new Image(),imgRegExp=/\.(jpg|gif|png|bmp|jpeg)(.*)?$/i,swfRegExp=/[^\.]\.(swf)\s*$/i,loadingTimer,loadingFrame=1,start_pos,final_pos,busy=false,shadow=20,fx=$.extend($('<div/>')[0],{prop:0}),titleh=0,isIE6=!$.support.opacity&&!window.XMLHttpRequest,fancybox_abort=function(){loading.hide();imgPreloader.onerror=imgPreloader.onload=null;if(ajaxLoader){ajaxLoader.abort();}
    tmp.empty();},fancybox_error=function(){$.fancybox('<p id="fancybox_error">The requested content cannot be loaded.<br />Please try again later.</p>',{'scrolling':'no','padding':20,'transitionIn':'none','transitionOut':'none'});},fancybox_get_viewport=function(){return[$(window).width(),$(window).height(),$(document).scrollLeft(),$(document).scrollTop()];},fancybox_get_zoom_to=function(){var view=fancybox_get_viewport(),to={},margin=currentOpts.margin,resize=currentOpts.autoScale,horizontal_space=(shadow+margin)*2,vertical_space=(shadow+margin)*2,double_padding=(currentOpts.padding*2),ratio;if(currentOpts.width.toString().indexOf('%')>-1){to.width=((view[0]*parseFloat(currentOpts.width))/100)-(shadow*2);resize=false;}else{to.width=currentOpts.width+double_padding;}
    if(currentOpts.height.toString().indexOf('%')>-1){to.height=((view[1]*parseFloat(currentOpts.height))/100)-(shadow*2);resize=false;}else{to.height=currentOpts.height+double_padding;}
    if(resize&&(to.width>(view[0]-horizontal_space)||to.height>(view[1]-vertical_space))){if(selectedOpts.type=='image'||selectedOpts.type=='swf'){horizontal_space+=double_padding;vertical_space+=double_padding;ratio=Math.min(Math.min(view[0]-horizontal_space,currentOpts.width)/currentOpts.width,Math.min(view[1]-vertical_space,currentOpts.height)/currentOpts.height);to.width=Math.round(ratio*(to.width-double_padding))+double_padding;to.height=Math.round(ratio*(to.height-double_padding))+double_padding;}else{to.width=Math.min(to.width,(view[0]-horizontal_space));to.height=Math.min(to.height,(view[1]-vertical_space));}}
    to.top=view[3]+((view[1]-(to.height+(shadow*2)))*0.5);to.left=view[2]+((view[0]-(to.width+(shadow*2)))*0.5);if(currentOpts.autoScale===false){to.top=Math.max(view[3]+margin,to.top);to.left=Math.max(view[2]+margin,to.left);}
    return to;},fancybox_format_title=function(title){if(title&&title.length){switch(currentOpts.titlePosition){case'inside':return title;case'over':return'<span id="fancybox-title-over">'+title+'</span>';default:return'<span id="fancybox-title-wrap"><span id="fancybox-title-left"></span><span id="fancybox-title-main">'+title+'</span><span id="fancybox-title-right"></span></span>';}}
    return false;},fancybox_process_title=function(){var title=currentOpts.title,width=final_pos.width-(currentOpts.padding*2),titlec='fancybox-title-'+currentOpts.titlePosition;$('#fancybox-title').remove();titleh=0;if(currentOpts.titleShow===false){return;}
    title=$.isFunction(currentOpts.titleFormat)?currentOpts.titleFormat(title,currentArray,currentIndex,currentOpts):fancybox_format_title(title);if(!title||title===''){return;}
    $('<div id="fancybox-title" class="'+titlec+'" />').css({'width':width,'paddingLeft':currentOpts.padding,'paddingRight':currentOpts.padding}).html('').appendTo('body');switch(currentOpts.titlePosition){case'inside':titleh=$("#fancybox-title").outerHeight(true)-currentOpts.padding;final_pos.height+=titleh;break;case'over':$('#fancybox-title').css('bottom',currentOpts.padding);break;default:$('#fancybox-title').css('bottom',$("#fancybox-title").outerHeight(true)*-1);break;}
    $('#fancybox-title').appendTo(outer).hide();},fancybox_set_navigation=function(){$(document).unbind('keydown.fb').bind('keydown.fb',function(e){if(e.keyCode==27&&currentOpts.enableEscapeButton){e.preventDefault();$.fancybox.close();}else if(e.keyCode==37){e.preventDefault();$.fancybox.prev();}else if(e.keyCode==39){e.preventDefault();$.fancybox.next();}});if($.fn.mousewheel){wrap.unbind('mousewheel.fb');if(currentArray.length>1){wrap.bind('mousewheel.fb',function(e,delta){e.preventDefault();if(busy||delta===0){return;}
    if(delta>0){$.fancybox.prev();}else{$.fancybox.next();}});}}
    if(!currentOpts.showNavArrows){return;}
    if((currentOpts.cyclic&&currentArray.length>1)||currentIndex!==0){nav_left.show();}
    if((currentOpts.cyclic&&currentArray.length>1)||currentIndex!=(currentArray.length-1)){nav_right.show();}},fancybox_preload_images=function(){var href,objNext;if((currentArray.length-1)>currentIndex){href=currentArray[currentIndex+1].href;if(typeof href!=='undefined'&&href.match(imgRegExp)){objNext=new Image();objNext.src=href;}}
    if(currentIndex>0){href=currentArray[currentIndex-1].href;if(typeof href!=='undefined'&&href.match(imgRegExp)){objNext=new Image();objNext.src=href;}}},_finish=function(){inner.css('overflow',(currentOpts.scrolling=='auto'?(currentOpts.type=='image'||currentOpts.type=='iframe'||currentOpts.type=='swf'?'hidden':'auto'):(currentOpts.scrolling=='yes'?'auto':'visible')));if(!$.support.opacity){inner.get(0).style.removeAttribute('filter');wrap.get(0).style.removeAttribute('filter');}
    $('#fancybox-title').show();if(currentOpts.hideOnContentClick){inner.one('click',$.fancybox.close);}
    if(currentOpts.hideOnOverlayClick){overlay.one('click',$.fancybox.close);}
    if(currentOpts.showCloseButton){close.show();}
    fancybox_set_navigation();$(window).bind("resize.fb",$.fancybox.center);if(currentOpts.centerOnScroll){$(window).bind("scroll.fb",$.fancybox.center);}else{$(window).unbind("scroll.fb");}
    if($.isFunction(currentOpts.onComplete)){currentOpts.onComplete(currentArray,currentIndex,currentOpts);}
    busy=false;fancybox_preload_images();},fancybox_draw=function(pos){var width=Math.round(start_pos.width+(final_pos.width-start_pos.width)*pos),height=Math.round(start_pos.height+(final_pos.height-start_pos.height)*pos),top=Math.round(start_pos.top+(final_pos.top-start_pos.top)*pos),left=Math.round(start_pos.left+(final_pos.left-start_pos.left)*pos);wrap.css({'width':width+'px','height':height+'px','top':top+'px','left':left+'px'});width=Math.max(width-currentOpts.padding*2,0);height=Math.max(height-(currentOpts.padding*2+(titleh*pos)),0);inner.css({'width':width+'px','height':height+'px'});if(typeof final_pos.opacity!=='undefined'){wrap.css('opacity',(pos<0.5?0.5:pos));}},fancybox_get_obj_pos=function(obj){var pos=obj.offset();pos.top+=parseFloat(obj.css('paddingTop'))||0;pos.left+=parseFloat(obj.css('paddingLeft'))||0;pos.top+=parseFloat(obj.css('border-top-width'))||0;pos.left+=parseFloat(obj.css('border-left-width'))||0;pos.width=obj.width();pos.height=obj.height();return pos;},fancybox_get_zoom_from=function(){var orig=selectedOpts.orig?$(selectedOpts.orig):false,from={},pos,view;if(orig&&orig.length){pos=fancybox_get_obj_pos(orig);from={width:(pos.width+(currentOpts.padding*2)),height:(pos.height+(currentOpts.padding*2)),top:(pos.top-currentOpts.padding-shadow),left:(pos.left-currentOpts.padding-shadow)};}else{view=fancybox_get_viewport();from={width:1,height:1,top:view[3]+view[1]*0.5,left:view[2]+view[0]*0.5};}
    return from;},fancybox_show=function(){loading.hide();if(wrap.is(":visible")&&$.isFunction(currentOpts.onCleanup)){if(currentOpts.onCleanup(currentArray,currentIndex,currentOpts)===false){$.event.trigger('fancybox-cancel');busy=false;return;}}
    currentArray=selectedArray;currentIndex=selectedIndex;currentOpts=selectedOpts;inner.get(0).scrollTop=0;inner.get(0).scrollLeft=0;if(currentOpts.overlayShow){if(isIE6){$('select:not(#fancybox-tmp select)').filter(function(){return this.style.visibility!=='hidden';}).css({'visibility':'hidden'}).one('fancybox-cleanup',function(){this.style.visibility='inherit';});}
        overlay.css({'background-color':currentOpts.overlayColor,'opacity':currentOpts.overlayOpacity}).unbind().show();}
    final_pos=fancybox_get_zoom_to();fancybox_process_title();if(wrap.is(":visible")){$(close.add(nav_left).add(nav_right)).hide();var pos=wrap.position(),equal;start_pos={top:pos.top,left:pos.left,width:wrap.width(),height:wrap.height()};equal=(start_pos.width==final_pos.width&&start_pos.height==final_pos.height);inner.fadeOut(currentOpts.changeFade,function(){var finish_resizing=function(){inner.html(tmp.contents()).fadeIn(currentOpts.changeFade,_finish);};$.event.trigger('fancybox-change');inner.empty().css('overflow','hidden');if(equal){inner.css({top:currentOpts.padding,left:currentOpts.padding,width:Math.max(final_pos.width-(currentOpts.padding*2),1),height:Math.max(final_pos.height-(currentOpts.padding*2)-titleh,1)});finish_resizing();}else{inner.css({top:currentOpts.padding,left:currentOpts.padding,width:Math.max(start_pos.width-(currentOpts.padding*2),1),height:Math.max(start_pos.height-(currentOpts.padding*2),1)});fx.prop=0;$(fx).animate({prop:1},{duration:currentOpts.changeSpeed,easing:currentOpts.easingChange,step:fancybox_draw,complete:finish_resizing});}});return;}
    wrap.css('opacity',1);if(currentOpts.transitionIn=='elastic'){start_pos=fancybox_get_zoom_from();inner.css({top:currentOpts.padding,left:currentOpts.padding,width:Math.max(start_pos.width-(currentOpts.padding*2),1),height:Math.max(start_pos.height-(currentOpts.padding*2),1)}).html(tmp.contents());wrap.css(start_pos).show();if(currentOpts.opacity){final_pos.opacity=0;}
        fx.prop=0;$(fx).animate({prop:1},{duration:currentOpts.speedIn,easing:currentOpts.easingIn,step:fancybox_draw,complete:_finish});}else{inner.css({top:currentOpts.padding,left:currentOpts.padding,width:Math.max(final_pos.width-(currentOpts.padding*2),1),height:Math.max(final_pos.height-(currentOpts.padding*2)-titleh,1)}).html(tmp.contents());wrap.css(final_pos).fadeIn(currentOpts.transitionIn=='none'?0:currentOpts.speedIn,_finish);}},fancybox_process_inline=function(){tmp.width(selectedOpts.width);tmp.height(selectedOpts.height);if(selectedOpts.width=='auto'){selectedOpts.width=tmp.width();}
    if(selectedOpts.height=='auto'){selectedOpts.height=tmp.height();}
    fancybox_show();},fancybox_process_image=function(){busy=true;selectedOpts.width=imgPreloader.width;selectedOpts.height=imgPreloader.height;$("<img />").attr({'id':'fancybox-img','src':imgPreloader.src,'alt':selectedOpts.title}).appendTo(tmp);fancybox_show();},fancybox_start=function(){fancybox_abort();var obj=selectedArray[selectedIndex],href,type,title,str,emb,selector,data;selectedOpts=$.extend({},$.fn.fancybox.defaults,(typeof $(obj).data('fancybox')=='undefined'?selectedOpts:$(obj).data('fancybox')));title=obj.title||$(obj).title||selectedOpts.title||'';if(obj.nodeName&&!selectedOpts.orig){selectedOpts.orig=$(obj).children("img:first").length?$(obj).children("img:first"):$(obj);}
    if(title===''&&selectedOpts.orig){title=selectedOpts.orig.attr('alt');}
    if(obj.nodeName&&(/^(?:javascript|#)/i).test(obj.href)){href=selectedOpts.href||null;}else{href=selectedOpts.href||obj.href||null;}
    if(selectedOpts.type){type=selectedOpts.type;if(!href){href=selectedOpts.content;}}else if(selectedOpts.content){type='html';}else if(href){if(href.match(imgRegExp)){type='image';}else if(href.match(swfRegExp)){type='swf';}else if($(obj).hasClass("iframe")){type='iframe';}else if(href.match(/#/)){obj=href.substr(href.indexOf("#"));type=$(obj).length>0?'inline':'ajax';}else{type='ajax';}}else{type='inline';}
    selectedOpts.type=type;selectedOpts.href=href;selectedOpts.title=title;if(selectedOpts.autoDimensions&&selectedOpts.type!=='iframe'&&selectedOpts.type!=='swf'){selectedOpts.width='auto';selectedOpts.height='auto';}
    if(selectedOpts.modal){selectedOpts.overlayShow=true;selectedOpts.hideOnOverlayClick=false;selectedOpts.hideOnContentClick=false;selectedOpts.enableEscapeButton=false;selectedOpts.showCloseButton=false;}
    if($.isFunction(selectedOpts.onStart)){if(selectedOpts.onStart(selectedArray,selectedIndex,selectedOpts)===false){busy=false;return;}}
    tmp.css('padding',(shadow+selectedOpts.padding+selectedOpts.margin));$('.fancybox-inline-tmp').unbind('fancybox-cancel').bind('fancybox-change',function(){$(this).replaceWith(inner.children());});switch(type){case'html':tmp.html(selectedOpts.content);fancybox_process_inline();break;case'inline':$('<div class="fancybox-inline-tmp" />').hide().insertBefore($(obj)).bind('fancybox-cleanup',function(){$(this).replaceWith(inner.children());}).bind('fancybox-cancel',function(){$(this).replaceWith(tmp.children());});$(obj).appendTo(tmp);fancybox_process_inline();break;case'image':busy=false;$.fancybox.showActivity();imgPreloader=new Image();imgPreloader.onerror=function(){fancybox_error();};imgPreloader.onload=function(){imgPreloader.onerror=null;imgPreloader.onload=null;fancybox_process_image();};imgPreloader.src=href;break;case'swf':str='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="'+selectedOpts.width+'" height="'+selectedOpts.height+'"><param name="movie" value="'+href+'"></param>';emb='';$.each(selectedOpts.swf,function(name,val){str+='<param name="'+name+'" value="'+val+'"></param>';emb+=' '+name+'="'+val+'"';});str+='<embed src="'+href+'" type="application/x-shockwave-flash" width="'+selectedOpts.width+'" height="'+selectedOpts.height+'"'+emb+'></embed></object>';tmp.html(str);fancybox_process_inline();break;case'ajax':selector=href.split('#',2);data=selectedOpts.ajax.data||{};if(selector.length>1){href=selector[0];if(typeof data=="string"){data+='&selector='+selector[1];}else{data.selector=selector[1];}}
        busy=false;$.fancybox.showActivity();ajaxLoader=$.ajax($.extend(selectedOpts.ajax,{url:href,data:data,error:fancybox_error,success:function(data,textStatus,XMLHttpRequest){if(ajaxLoader.status==200){tmp.html(data);fancybox_process_inline();}}}));break;case'iframe':$('<iframe id="fancybox-frame" name="fancybox-frame'+new Date().getTime()+'" frameborder="0" hspace="0" scrolling="'+selectedOpts.scrolling+'" src="'+selectedOpts.href+'"></iframe>').appendTo(tmp);fancybox_show();break;}},fancybox_animate_loading=function(){if(!loading.is(':visible')){clearInterval(loadingTimer);return;}
    $('div',loading).css('top',(loadingFrame*-40)+'px');loadingFrame=(loadingFrame+1)%12;},fancybox_init=function(){if($("#fancybox-wrap").length){return;}
    $('body').append(tmp=$('<div id="fancybox-tmp"></div>'),loading=$('<div id="fancybox-loading"><div></div></div>'),overlay=$('<div id="fancybox-overlay"></div>'),wrap=$('<div id="fancybox-wrap"></div>'));if(!$.support.opacity){wrap.addClass('fancybox-ie');loading.addClass('fancybox-ie');}
    outer=$('<div id="fancybox-outer"></div>').append('<div class="fancy-bg" id="fancy-bg-n"></div><div class="fancy-bg" id="fancy-bg-ne"></div><div class="fancy-bg" id="fancy-bg-e"></div><div class="fancy-bg" id="fancy-bg-se"></div><div class="fancy-bg" id="fancy-bg-s"></div><div class="fancy-bg" id="fancy-bg-sw"></div><div class="fancy-bg" id="fancy-bg-w"></div><div class="fancy-bg" id="fancy-bg-nw"></div>').appendTo(wrap);outer.append(inner=$('<div id="fancybox-inner"></div>'),close=$('<a id="fancybox-close"></a>'),nav_left=$('<a href="javascript:;" id="fancybox-left"><span class="fancy-ico" id="fancybox-left-ico"></span></a>'),nav_right=$('<a href="javascript:;" id="fancybox-right"><span class="fancy-ico" id="fancybox-right-ico"></span></a>'));close.click($.fancybox.close);loading.click($.fancybox.cancel);nav_left.click(function(e){e.preventDefault();$.fancybox.prev();});nav_right.click(function(e){e.preventDefault();$.fancybox.next();});if(isIE6){overlay.get(0).style.setExpression('height',"document.body.scrollHeight > document.body.offsetHeight ? document.body.scrollHeight : document.body.offsetHeight + 'px'");loading.get(0).style.setExpression('top',"(-20 + (document.documentElement.clientHeight ? document.documentElement.clientHeight/2 : document.body.clientHeight/2 ) + ( ignoreMe = document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop )) + 'px'");outer.prepend('<iframe id="fancybox-hide-sel-frame" src="javascript:\'\';" scrolling="no" frameborder="0" ></iframe>');}};$.fn.fancybox=function(options){$(this).data('fancybox',$.extend({},options,($.metadata?$(this).metadata():{}))).unbind('click.fb').bind('click.fb',function(e){e.preventDefault();if(busy){return;}
    busy=true;$(this).blur();selectedArray=[];selectedIndex=0;var rel=$(this).attr('rel')||'';if(!rel||rel==''||rel==='nofollow'){selectedArray.push(this);}else{selectedArray=$("a[rel="+rel+"], area[rel="+rel+"]");selectedIndex=selectedArray.index(this);}
    fancybox_start();return false;});return this;};$.fancybox=function(obj){if(busy){return;}
    busy=true;var opts=typeof arguments[1]!=='undefined'?arguments[1]:{};selectedArray=[];selectedIndex=opts.index||0;if($.isArray(obj)){for(var i=0,j=obj.length;i<j;i++){if(typeof obj[i]=='object'){$(obj[i]).data('fancybox',$.extend({},opts,obj[i]));}else{obj[i]=$({}).data('fancybox',$.extend({content:obj[i]},opts));}}
        selectedArray=jQuery.merge(selectedArray,obj);}else{if(typeof obj=='object'){$(obj).data('fancybox',$.extend({},opts,obj));}else{obj=$({}).data('fancybox',$.extend({content:obj},opts));}
        selectedArray.push(obj);}
    if(selectedIndex>selectedArray.length||selectedIndex<0){selectedIndex=0;}
    fancybox_start();};$.fancybox.showActivity=function(){clearInterval(loadingTimer);loading.show();loadingTimer=setInterval(fancybox_animate_loading,66);};$.fancybox.hideActivity=function(){loading.hide();};$.fancybox.next=function(){return $.fancybox.pos(currentIndex+1);};$.fancybox.prev=function(){return $.fancybox.pos(currentIndex-1);};$.fancybox.pos=function(pos){if(busy){return;}
    pos=parseInt(pos,10);if(pos>-1&&currentArray.length>pos){selectedIndex=pos;fancybox_start();}
    if(currentOpts.cyclic&&currentArray.length>1&&pos<0){selectedIndex=currentArray.length-1;fancybox_start();}
    if(currentOpts.cyclic&&currentArray.length>1&&pos>=currentArray.length){selectedIndex=0;fancybox_start();}
    return;};$.fancybox.cancel=function(){if(busy){return;}
    busy=true;$.event.trigger('fancybox-cancel');fancybox_abort();if(selectedOpts&&$.isFunction(selectedOpts.onCancel)){selectedOpts.onCancel(selectedArray,selectedIndex,selectedOpts);}
    busy=false;};$.fancybox.close=function(){if(busy||wrap.is(':hidden')){return;}
    busy=true;if(currentOpts&&$.isFunction(currentOpts.onCleanup)){if(currentOpts.onCleanup(currentArray,currentIndex,currentOpts)===false){busy=false;return;}}
    fancybox_abort();$(close.add(nav_left).add(nav_right)).hide();$('#fancybox-title').remove();wrap.add(inner).add(overlay).unbind();$(window).unbind("resize.fb scroll.fb");$(document).unbind('keydown.fb');function _cleanup(){overlay.fadeOut('fast');wrap.hide();$.event.trigger('fancybox-cleanup');inner.empty();if($.isFunction(currentOpts.onClosed)){currentOpts.onClosed(currentArray,currentIndex,currentOpts);}
        currentArray=selectedOpts=[];currentIndex=selectedIndex=0;currentOpts=selectedOpts={};busy=false;}
    inner.css('overflow','hidden');if(currentOpts.transitionOut=='elastic'){start_pos=fancybox_get_zoom_from();var pos=wrap.position();final_pos={top:pos.top,left:pos.left,width:wrap.width(),height:wrap.height()};if(currentOpts.opacity){final_pos.opacity=1;}
        fx.prop=1;$(fx).animate({prop:0},{duration:currentOpts.speedOut,easing:currentOpts.easingOut,step:fancybox_draw,complete:_cleanup});}else{wrap.fadeOut(currentOpts.transitionOut=='none'?0:currentOpts.speedOut,_cleanup);}};$.fancybox.resize=function(){var c,h;if(busy||wrap.is(':hidden')){return;}
    busy=true;c=inner.wrapInner("<div style='overflow:auto'></div>").children();h=c.height();wrap.css({height:h+(currentOpts.padding*2)+titleh});inner.css({height:h});c.replaceWith(c.children());$.fancybox.center();};$.fancybox.center=function(){busy=true;var view=fancybox_get_viewport(),margin=currentOpts.margin,to={};to.top=view[3]+((view[1]-((wrap.height()-titleh)+(shadow*2)))*0.5);to.left=view[2]+((view[0]-(wrap.width()+(shadow*2)))*0.5);to.top=Math.max(view[3]+margin,to.top);to.left=Math.max(view[2]+margin,to.left);wrap.css(to);busy=false;};$.fn.fancybox.defaults={padding:10,margin:20,opacity:false,modal:false,cyclic:false,scrolling:'auto',width:560,height:340,autoScale:true,autoDimensions:true,centerOnScroll:false,ajax:{},swf:{wmode:'transparent'},hideOnOverlayClick:true,hideOnContentClick:false,overlayShow:true,overlayOpacity:0.3,overlayColor:'#666',titleShow:true,titlePosition:'outside',titleFormat:null,transitionIn:'fade',transitionOut:'fade',speedIn:300,speedOut:300,changeSpeed:300,changeFade:'fast',easingIn:'swing',easingOut:'swing',showCloseButton:true,showNavArrows:true,enableEscapeButton:true,onStart:null,onCancel:null,onComplete:null,onCleanup:null,onClosed:null};$(document).ready(function(){fancybox_init();});})(jQuery);
/**
 *  Ajax Autocomplete for jQuery, version 1.1.3
 *  (c) 2010 Tomas Kirda
 *
 *  Ajax Autocomplete for jQuery is freely distributable under the terms of an MIT-style license.
 *  For details, see the web site: http://www.devbridge.com/projects/autocomplete/jquery/
 *
 *  Last Review: 04/19/2010
 */

(function(d){function l(b,a,c){a="("+c.replace(m,"\\$1")+")";return b.replace(new RegExp(a,"gi"),"<strong>$1</strong>")}function i(b,a){this.el=d(b);this.el.attr("autocomplete","off");this.suggestions=[];this.data=[];this.badQueries=[];this.selectedIndex=-1;this.currentValue=this.el.val();this.intervalId=0;this.cachedResponse=[];this.onChangeInterval=null;this.ignoreValueChange=false;this.serviceUrl=a.serviceUrl;this.isLocal=false;this.options={autoSubmit:false,minChars:1,maxHeight:300,deferRequestBy:0, width:0,highlight:true,params:{},fnFormatResult:l,delimiter:null,zIndex:9999};this.initialize();this.setOptions(a)}var m=new RegExp("(\\/|\\.|\\*|\\+|\\?|\\||\\(|\\)|\\[|\\]|\\{|\\}|\\\\)","g");d.fn.autocomplete=function(b){return new i(this.get(0)||d("<input />"),b)};i.prototype={killerFn:null,initialize:function(){var b,a,c;b=this;a=Math.floor(Math.random()*1048576).toString(16);c="Autocomplete_"+a;this.killerFn=function(e){if(d(e.target).parents(".autocomplete").size()===0){b.killSuggestions(); b.disableKillerFn()}};if(!this.options.width)this.options.width=this.el.width();this.mainContainerId="AutocompleteContainter_"+a;d('<div id="'+this.mainContainerId+'" style="position:absolute;z-index:9999;"><div class="autocomplete-w1"><div class="autocomplete" id="'+c+'" style="display:none; width:300px;"></div></div></div>').appendTo("body");this.container=d("#"+c);this.fixPosition();window.opera?this.el.keypress(function(e){b.onKeyPress(e)}):this.el.keydown(function(e){b.onKeyPress(e)});this.el.keyup(function(e){b.onKeyUp(e)}); this.el.blur(function(){b.enableKillerFn()});this.el.focus(function(){b.fixPosition()})},setOptions:function(b){var a=this.options;d.extend(a,b);if(a.lookup){this.isLocal=true;if(d.isArray(a.lookup))a.lookup={suggestions:a.lookup,data:[]}}d("#"+this.mainContainerId).css({zIndex:a.zIndex});this.container.css({maxHeight:a.maxHeight+"px",width:a.width})},clearCache:function(){this.cachedResponse=[];this.badQueries=[]},disable:function(){this.disabled=true},enable:function(){this.disabled=false},fixPosition:function(){var b= this.el.offset();d("#"+this.mainContainerId).css({top:b.top+this.el.innerHeight()+"px",left:b.left+"px"})},enableKillerFn:function(){d(document).bind("click",this.killerFn)},disableKillerFn:function(){d(document).unbind("click",this.killerFn)},killSuggestions:function(){var b=this;this.stopKillSuggestions();this.intervalId=window.setInterval(function(){b.hide();b.stopKillSuggestions()},300)},stopKillSuggestions:function(){window.clearInterval(this.intervalId)},onKeyPress:function(b){if(!(this.disabled|| !this.enabled)){switch(b.keyCode){case 27:this.el.val(this.currentValue);this.hide();break;case 9:case 13:if(this.selectedIndex===-1){this.hide();return}this.select(this.selectedIndex);if(b.keyCode===9)return;break;case 38:this.moveUp();break;case 40:this.moveDown();break;default:return}b.stopImmediatePropagation();b.preventDefault()}},onKeyUp:function(b){if(!this.disabled){switch(b.keyCode){case 38:case 40:return}clearInterval(this.onChangeInterval);if(this.currentValue!==this.el.val())if(this.options.deferRequestBy> 0){var a=this;this.onChangeInterval=setInterval(function(){a.onValueChange()},this.options.deferRequestBy)}else this.onValueChange()}},onValueChange:function(){clearInterval(this.onChangeInterval);this.currentValue=this.el.val();var b=this.getQuery(this.currentValue);this.selectedIndex=-1;if(this.ignoreValueChange)this.ignoreValueChange=false;else b===""||b.length<this.options.minChars?this.hide():this.getSuggestions(b)},getQuery:function(b){var a;a=this.options.delimiter;if(!a)return d.trim(b);b= b.split(a);return d.trim(b[b.length-1])},getSuggestionsLocal:function(b){var a,c,e,g,f;c=this.options.lookup;e=c.suggestions.length;a={suggestions:[],data:[]};b=b.toLowerCase();for(f=0;f<e;f++){g=c.suggestions[f];if(g.toLowerCase().indexOf(b)===0){a.suggestions.push(g);a.data.push(c.data[f])}}return a},getSuggestions:function(b){var a,c;if((a=this.isLocal?this.getSuggestionsLocal(b):this.cachedResponse[b])&&d.isArray(a.suggestions)){this.suggestions=a.suggestions;this.data=a.data;this.suggest()}else if(!this.isBadQuery(b)){c= this;c.options.params.query=b;d.get(this.serviceUrl,c.options.params,function(e){c.processResponse(e)},"text")}},isBadQuery:function(b){for(var a=this.badQueries.length;a--;)if(b.indexOf(this.badQueries[a])===0)return true;return false},hide:function(){this.enabled=false;this.selectedIndex=-1;this.container.hide()},suggest:function(){if(this.suggestions.length===0)this.hide();else{var b,a,c,e,g,f,j,k;b=this;a=this.suggestions.length;e=this.options.fnFormatResult;g=this.getQuery(this.currentValue); j=function(h){return function(){b.activate(h)}};k=function(h){return function(){b.select(h)}};this.container.hide().empty();for(f=0;f<a;f++){c=this.suggestions[f];c=d((b.selectedIndex===f?'<div class="selected"':"<div")+' title="'+c+'">'+e(c,this.data[f],g)+"</div>");c.mouseover(j(f));c.click(k(f));this.container.append(c)}this.enabled=true;this.container.show()}},processResponse:function(b){var a;try{a=eval("("+b+")")}catch(c){return}if(!d.isArray(a.data))a.data=[];if(!this.options.noCache){this.cachedResponse[a.query]= a;a.suggestions.length===0&&this.badQueries.push(a.query)}if(a.query===this.getQuery(this.currentValue)){this.suggestions=a.suggestions;this.data=a.data;this.suggest()}},activate:function(b){var a,c;a=this.container.children();this.selectedIndex!==-1&&a.length>this.selectedIndex&&d(a.get(this.selectedIndex)).removeClass();this.selectedIndex=b;if(this.selectedIndex!==-1&&a.length>this.selectedIndex){c=a.get(this.selectedIndex);d(c).addClass("selected")}return c},deactivate:function(b,a){b.className= "";if(this.selectedIndex===a)this.selectedIndex=-1},select:function(b){var a;if(a=this.suggestions[b]){this.el.val(a);if(this.options.autoSubmit){a=this.el.parents("form");a.length>0&&a.get(0).submit()}this.ignoreValueChange=true;this.hide();this.onSelect(b)}},moveUp:function(){if(this.selectedIndex!==-1)if(this.selectedIndex===0){this.container.children().get(0).className="";this.selectedIndex=-1;this.el.val(this.currentValue)}else this.adjustScroll(this.selectedIndex-1)},moveDown:function(){this.selectedIndex!== this.suggestions.length-1&&this.adjustScroll(this.selectedIndex+1)},adjustScroll:function(b){var a,c,e;a=this.activate(b).offsetTop;c=this.container.scrollTop();e=c+this.options.maxHeight-25;if(a<c)this.container.scrollTop(a);else a>e&&this.container.scrollTop(a-this.options.maxHeight+25);this.el.val(this.getValue(this.suggestions[b]))},onSelect:function(b){var a,c;a=this.options.onSelect;c=this.suggestions[b];b=this.data[b];this.el.val(this.getValue(c));d.isFunction(a)&&a(c,b,this.el)},getValue:function(b){var a, c;a=this.options.delimiter;if(!a)return b;c=this.currentValue;a=c.split(a);if(a.length===1)return b;return c.substr(0,c.length-a[a.length-1].length)+b}}})(jQuery);
/**
 * SearchHighlight plugin for jQuery
 *
 * Thanks to Scott Yang <http://scott.yang.id.au/>
 * for the original idea and some code
 *
 * @author Renato Formato <renatoformato@virgilio.it>
 *
 * @version 0.33
 *
 *  Options
 *  - exact (string, default:"exact")
 *    "exact" : find and highlight the exact words.
 *    "whole" : find partial matches but highlight whole words
 *    "partial": find and highlight partial matches
 *
 *  - style_name (string, default:'hilite')
 *    The class given to the span wrapping the matched words.
 *
 *  - style_name_suffix (boolean, default:true)
 *    If true a different number is added to style_name for every different matched word.
 *
 *  - debug_referrer (string, default:null)
 *    Set a referrer for debugging purpose.
 *
 *  - engines (array of regex, default:null)
 *    Add a new search engine regex to highlight searches coming from new search engines.
 *    The first element is the regex to match the domain.
 *    The second element is the regex to match the query string.
 *    Ex: [/^http:\/\/my\.site\.net/i,/search=([^&]+)/i]
 *
 *  - highlight (string, default:null)
 *    A jQuery selector or object to set the elements enabled for highlight.
 *    If null or no elements are found, all the document is enabled for highlight.
 *
 *  - nohighlight (string, default:null)
 *    A jQuery selector or object to set the elements not enabled for highlight.
 *    This option has priority on highlight.
 *
 *  - keys (string, default:null)
 *    Disable the analisys of the referrer and search for the words given as argument
 *
 */

(function($){
    jQuery.fn.SearchHighlight = function(options) {
        var ref = options.debug_referrer || document.referrer;
        if(!ref && options.keys==undefined) return this;

        SearchHighlight.options = $.extend({exact:"exact",style_name:'hilite',style_name_suffix:true},options);

        if(options.engines) SearchHighlight.engines.unshift(options.engines);
        var q = options.keys!=undefined?options.keys.toLowerCase().split(/[\s,\+\.]+/):SearchHighlight.decodeURL(ref,SearchHighlight.engines);
        if(q && q.join("")) {
            SearchHighlight.buildReplaceTools(q);
            return this.each(function(){
                var el = this;
                if(el==document) el = $("body")[0];
                SearchHighlight.hiliteElement(el, q);
            })
        } else return this;
    }

    var SearchHighlight = {
        options: {},
        regex: [],
        engines: [
            [/^http:\/\/(www\.)?google\./i, /q=([^&]+)/i],                            // Google
            [/^http:\/\/(www\.)?search\.yahoo\./i, /p=([^&]+)/i],                     // Yahoo
            [/^http:\/\/(www\.)?search\.msn\./i, /q=([^&]+)/i],                       // MSN
            [/^http:\/\/(www\.)?search\.live\./i, /query=([^&]+)/i],                  // MSN Live
            [/^http:\/\/(www\.)?search\.aol\./i, /userQuery=([^&]+)/i],               // AOL
            [/^http:\/\/(www\.)?ask\.com/i, /q=([^&]+)/i],                            // Ask.com
            [/^http:\/\/(www\.)?altavista\./i, /q=([^&]+)/i],                         // AltaVista
            [/^http:\/\/(www\.)?feedster\./i, /q=([^&]+)/i],                          // Feedster
            [/^http:\/\/(www\.)?search\.lycos\./i, /q=([^&]+)/i],                     // Lycos
            [/^http:\/\/(www\.)?alltheweb\./i, /q=([^&]+)/i],                         // AllTheWeb
            [/^http:\/\/(www\.)?technorati\.com/i, /([^\?\/]+)(?:\?.*)$/i],           // Technorati
        ],
        subs: {},
        decodeURL: function(URL,reg) {
            URL = decodeURIComponent(URL);
            var query = null;
            $.each(reg,function(i,n){
                if(n[0].test(URL)) {
                    var match = URL.match(n[1]);
                    if(match) {
                        query = match[1].toLowerCase();
                        return false;
                    }
                }
            })

            if (query) {
                query = query.replace(/(\'|")/, '\$1');
                query = query.split(/[\s,\+\.]+/);
            }

            return query;
        },
        regexAccent : [
            [/[\xC0-\xC5\u0100-\u0105]/ig,'a'],
            [/[\xC7\u0106-\u010D]/ig,'c'],
            [/[\xC8-\xCB]/ig,'e'],
            [/[\xCC-\xCF]/ig,'i'],
            [/\xD1/ig,'n'],
            [/[\xD2-\xD6\xD8]/ig,'o'],
            [/[\u015A-\u0161]/ig,'s'],
            [/[\u0162-\u0167]/ig,'t'],
            [/[\xD9-\xDC]/ig,'u'],
            [/\xFF/ig,'y'],
            [/[\x91\x92\u2018\u2019]/ig,'\'']
        ],
        matchAccent : /[\x91\x92\xC0-\xC5\xC7-\xCF\xD1-\xD6\xD8-\xDC\xFF\u0100-\u010D\u015A-\u0167\u2018\u2019]/ig,
        replaceAccent: function(q) {
            SearchHighlight.matchAccent.lastIndex = 0;
            if(SearchHighlight.matchAccent.test(q)) {
                for(var i=0,l=SearchHighlight.regexAccent.length;i<l;i++)
                    q = q.replace(SearchHighlight.regexAccent[i][0],SearchHighlight.regexAccent[i][1]);
            }
            return q;
        },
        escapeRegEx : /((?:\\{2})*)([[\]{}*?|])/g, //the special chars . and + are already gone at this point because they are considered split chars
        buildReplaceTools : function(query) {
            var re = [], regex;
            $.each(query,function(i,n){
                if(n = SearchHighlight.replaceAccent(n).replace(SearchHighlight.escapeRegEx,"$1\\$2"))
                    re.push(n);
            });

            regex = re.join("|");
            switch(SearchHighlight.options.exact) {
                case "exact":
                    regex = '\\b(?:'+regex+')\\b';
                    break;
                case "whole":
                    regex = '\\b\\w*('+regex+')\\w*\\b';
                    break;
            }
            SearchHighlight.regex = new RegExp(regex, "gi");

            $.each(re,function(i,n){
                SearchHighlight.subs[n] = SearchHighlight.options.style_name+
                    (SearchHighlight.options.style_name_suffix?i+1:'');
            });
        },
        nosearch: /s(?:cript|tyle)|textarea/i,
        hiliteElement: function(el, query) {
            var opt = SearchHighlight.options, elHighlight, noHighlight;
            elHighlight = opt.highlight?$(opt.highlight):$("body");
            if(!elHighlight.length) elHighlight = $("body");
            noHighlight = opt.nohighlight?$(opt.nohighlight):$([]);

            elHighlight.each(function(){
                SearchHighlight.hiliteTree(this,query,noHighlight);
            });
        },
        hiliteTree : function(el,query,noHighlight) {
            if(noHighlight.index(el)!=-1) return;
            var matchIndex = SearchHighlight.options.exact=="whole"?1:0;
            for(var startIndex=0,endIndex=el.childNodes.length;startIndex<endIndex;startIndex++) {
                var item = el.childNodes[startIndex];
                if ( item.nodeType != 8 ) {//comment node
                    //text node
                    if(item.nodeType==3) {
                        var text = item.data, textNoAcc = SearchHighlight.replaceAccent(text);
                        var newtext="",match,index=0;
                        SearchHighlight.regex.lastIndex = 0;
                        while(match = SearchHighlight.regex.exec(textNoAcc)) {
                            newtext += text.substr(index,match.index-index)+'<span class="'+
                                SearchHighlight.subs[match[matchIndex].toLowerCase()]+'">'+text.substr(match.index,match[0].length)+"</span>";
                            index = match.index+match[0].length;
                        }
                        if(newtext) {
                            //add the last part of the text
                            newtext += text.substring(index);
                            var repl = $.merge([],$("<span>"+newtext+"</span>")[0].childNodes);
                            endIndex += repl.length-1;
                            startIndex += repl.length-1;
                            $(item).before(repl).remove();
                        }
                    } else {
                        if(item.nodeType==1 && item.nodeName.search(SearchHighlight.nosearch)==-1)
                            SearchHighlight.hiliteTree(item,query,noHighlight);
                    }
                }
            }
        }
    };
})(jQuery)
//--------------------------------------------------
// builder
//--------------------------------------------------
function init_builder() {
// make builderBox elements clickable
    $( '.active' ).click( function () {

        var url= 'index.php?tpl=b_builderDialog';
        url += '&box=' + $( this ).attr( 'box' );
        url += '&ref=' + $( this ).attr( 'ref' );
        url += '&IdProduct=' + $( this ).attr( 'pid' );

// call modal dialog
        $.fancybox({
            'href':url,
            overlayOpacity:0.5,
            overlayColor:'#000',
            width:640,
            height:500,
            padding:10,
            margin:0,
            autoDimensions:false,
            autoScale:false,
            centerOnScroll:true,
            hideOnOverlayClick:false,
            type:'iframe',
            title: $( this ).attr( 'title' ),
            titleShow:true,
            titlePosition:'inside'
            //'onClosed'            : function() { alert('closed'); }
        });
    });
}


function set_builder_element( builderBox, basePID, baseTID, PID ) {
    $.fancybox.showActivity();

// add product to config list with baseid
    $.ajax({
        type:"POST",
        async:false,
        url:"index.php?pltpl=basket_ajaxConfigHandler&action=add",
        data:{
            bb: builderBox,
            bpid: basePID,
            btid: baseTID,
            pid: PID,
            join: parent.$( '#bbox_' + builderBox ).attr( 'ref' )
        },
        success: function( data )
        {
// update builderBox image
            if( data != '' )
            {
                var currentImage= $( '#bbox_' + builderBox + ' span' ).css( 'background-image' );
                parent.$( '#bbox_' + builderBox + ' img' ).attr('src',data);
                //parent.$( '#bbox_' + builderBox + ' span' ).css( 'filter', "progid:DXImageTransform.Microsoft.AlphaImageLoader(src=' + data + ',sizingMethod='scale'" );
            }

// update config list
            parent.updateConfigList();

// disable box with id builderBox
            parent.$( '#bbox_' + builderBox ).removeClass( 'active' );
            parent.$( '#bbox_' + builderBox ).unbind( 'click' );

// close modal window
            parent.$.fancybox.hideActivity();
            parent.$.fancybox.close();
        }
    });
}


function addMultipleBuilderElements(builderBox, ref, IdProduct)
{
    $.fancybox.showActivity();

// get all checked products
    var elements= '';
    $( 'input:checkbox:checked' ).each( function(){
        var selected = parseInt($('#select_'+$(this).val()).find(":selected").val());
        for(var i=0;i<selected;i++){
            elements += $( this ).val() + ',';
        }
    });

// add products to config list with baseid
    $.ajax({
        type:"POST",
        url:"index.php?pltpl=basket_ajaxConfigHandler&action=addMultiple",
        data:{
            pids: elements,
            bbox: builderBox,
            join: ref,
            IdProduct: IdProduct
        },
        success: function( data )
        {
// update config list
            parent.updateConfigList()

            if(builderBox){
                // update builderBox image
                if( data != '' )
                {
                    parent.$( '#bbox_' + builderBox + ' img' ).attr('src', data);
                }

                // disable box with id builderBox
                //parent.$( '#bbox_' + builderBox ).removeClass( 'active' );
                //parent.$( '#bbox_' + builderBox ).unbind( 'click' );
            }

// close modal window
            parent.$.fancybox.hideActivity();
            parent.$.fancybox.close();
        }
    });
}


function remove_builder_element( PID )
{
    $.fancybox.showActivity();

// add product to config list with baseid
    $.ajax({
        type:"POST",
        url:"index.php?pltpl=basket_ajaxConfigHandler&action=remove",
        data:{
            pid: PID
        },
        success: function( data )
        {
// update config list
            updateConfigList();

            var defaultImage = $( '#bbox_' + data + ' img' ).attr('defaultImage');
            $( '#bbox_' + data + ' img' ).attr('src',defaultImage);
// restore default image
//var defaultImage= $( '#bbox_' + data + ' span' ).attr( 'defaultImage' );
//$( '#bbox_' + data + ' span' ).css( 'background-image', defaultImage );

            //var explo1 = defaultImage.substr(4);
            //var explo = explo1.replace(")","");
            //$( '#bbox_' + data + ' span' ).css( 'filter', "progid:DXImageTransform.Microsoft.AlphaImageLoader(src='" + explo + "',sizingMethod='scale'" );


// enable box with id builderBox
            $( '#bbox_' + data ).addClass( 'active' );
            init_builder();

            $.fancybox.hideActivity();
        }
    });
}

function remove_multi_one( PID )
{
    $.fancybox.showActivity();

// add product to config list with baseid
    $.ajax({
        type:"POST",
        url:"index.php?pltpl=basket_ajaxConfigHandler&action=remove_multi_one",
        data:{
            pid: PID
        },
        success: function( data )
        {
            $( '#box_item_' + PID ).remove();
            $.fancybox.hideActivity();
            updateConfigList();
        }
    });
}



//--------------------------------------------------
// config and basket
//--------------------------------------------------

// store configuration
function saveConfig()
{
    parent.$.fancybox.showActivity();

    $.ajax({
        type:"POST",
        url:"index.php?pltpl=basket_ajaxBasketHandler&action=add",
        data:{
            name:$( "input[name='mwebForm_data[configName]']" ).val(),
            complete:$( "input[name='mwebForm_data[configComplete]']" ).val(),
            comment:$( "textarea[name='mwebForm_data[configComment]']" ).val()
        },
        success: function( data )
        {
            var tmp= eval('(' + data + ')');
            if( tmp.error )
            {
// show error
                var errTag= $( 'table.dialog p.mandatory' ).attr( 'rel' );
                $( '#' + errTag ).html( tmp.errorMessage );
                $( 'p.mandatory' ).parent().children( 'input:visible' ).addClass( 'error' );
            } else
            {
// update basket list
                updateBasketList();
                parent.$.fancybox.close();
            }
            parent.$.fancybox.hideActivity();
        }
    });
}

// save single product
function addToBasket( pid )
{
    parent.$.fancybox.showActivity();

    $.ajax({
        type:"POST",
        url:"index.php?pltpl=basket_ajaxBasketHandler&action=addSingle",
        data:{
            pid: pid
        },
        cache: false,
        success: function( data )
        {
// update basket list
            updateBasketList();
            parent.$.fancybox.hideActivity();
        }
    });
}

// remove config (in basket overview)
function removeConfig( cid )
{
    $.fancybox.showActivity();

    $.ajax({
        type:"POST",
        url:"index.php?pltpl=basket_ajaxBasketHandler&action=remove",
        data:{
            cid: cid
        },
        success: function( data )
        {
// update basket list
            updateBasketList();

            $.fancybox.hideActivity();
        }
    });
}

// remove config (in basket order dialog)
function removeBasket( cid )
{
    $.fancybox.showActivity();

    $.ajax({
        type:"POST",
        url:"index.php?pltpl=basket_ajaxBasketHandler&action=remove",
        data:{
            cid: cid
        },
        success: function( data )
        {
// update basket list
            updateBasketList();
            updateBasketOrder();

            $.fancybox.hideActivity();
        }
    });
}



//remove config element from config in basket
function removeBasketConfigElement( cid, pid )
{
    $.fancybox.showActivity();

    $.ajax({
        type:"POST",
        url:"index.php?pltpl=basket_ajaxBasketHandler&action=removeConfig",
        data:{
            cid: cid,
            pid: pid,
            comment: $( "textarea[name='mwebForm_data[configComment]']" ).val()
        },
        success: function( data )
        {
            $( '#dialog' ).load( 'index.php?pltpl=basket_showConfigDetailContent&cid=' + cid, function(){
                $.fancybox.hideActivity();
            });
        }
    });
}



function updateConfig( cid )
{
    parent.$.fancybox.showActivity();

    $.ajax({
        type:"POST",
        url:"index.php?pltpl=basket_ajaxBasketHandler&action=updateConfig",
        data:{
            cid: cid,
            comment: $( "textarea[name='mwebForm_data[configComment]']" ).val()
        },
        success: function( data )
        {
            updateBasketList();
            parent.$.fancybox.hideActivity();
            parent.$.fancybox.close();
        }
    });
}


function orderBasket()
{
    parent.$.fancybox.showActivity();

// find all basket entries
    var basket= new Array();
    $( "input[class='number']" ).each( function() {
        var cid= $( this ).attr( 'rel' ).substring( 4 );
        var tmp= {
            cid:    cid,
            cnt:    $( this ).val(),
            nr:     $( "input[rel='number_" + cid + "']" ).val()
        };
        basket.push( tmp );
    });

    // update basket entries
    $.ajax({
        type:"POST",
        url:"index.php?pltpl=basket_ajaxBasketHandler&action=orderBasket",
        data:{
            data: basket
        },
        success: function( data )
        {
            updateBasketList();
            document.location.href= "index.php?pltpl=basket_orderBasketForm";
            parent.$.fancybox.hideActivity();
        }
    });
}


//--------------------------------------------------
// product finder
//--------------------------------------------------
function setFilter()
{
    $( 'select.prodFinder' ).hide();
    $.fancybox.showActivity();
    $( '#mWebProfiSearch' ).submit();
    return false;

// build data string
    var dataParams= '';
    $( '#mWebProfiSearch input' ).each( function() {
//dataParams += $( this ).attr( 'name' ) + ' --- ';
//dataParams += '&' + $( this ).attr( 'name' ) + '=' + $( this ).val();
    });
    alert( $( 'form select' ).length );
    $( '#mWebProfiSearch select' ).each( function() {
        dataParams += $( this ).attr( 'id' ) + ' --- ';
//dataParams += '&' + $( this ).attr( 'name' ) + '=' + $( this ).val();
    });

    alert( dataParams );

    /*
    $( '.content' ).load(
    "feeds.php",
    {
    limit: 25
    },
    function() {
    $.fancybox.hideActivity();
    }
    );
    */
}



//--------------------------------------------------
// helpers
//--------------------------------------------------

// close modal window (from inside modal dialog)
function closeModal()
{
    parent.$.fancybox.close();
}

// update the config list
function updateConfigList()
{
    $( '#orderList div.boxcontentdynamic' ).load( 'index.php?pltpl=basket_listConfigContent', function() {
        setModal();
    });
}


// update the basket list
function updateBasketList()
{
    parent.$( '#basketContentDynamic' ).load( 'index.php?pltpl=basket_listBasketContent', function() {
        parent.setModal();
    });
}


// update the basket list in order dialog
function updateBasketOrder()
{
    $( '#basketOrder' ).load( 'index.php?pltpl=basket_showBasketContent' );
}


// make .modal classes open a modal window
function setModal()
{
    $( '.modal' ).click( function () {
        url= $( this ).attr( 'href' );
        $.fancybox({
            href:url,
            overlayOpacity:0.5,
            overlayColor:'#000',
            width:660,
            height:500,
            padding:10,
            margin:0,
            autoDimensions:false,
            autoScale:false,
            centerOnScroll:true,
            hideOnOverlayClick:false,
            type:'iframe',
            title: $( this ).attr( 'title' ),
            titleShow:true,
            titlePosition:'inside'
        });
        return false;
    });
}


// --------------------------------------------------
// init
// --------------------------------------------------
$( document ).ready( function()
{
    $("#fancybox-wrap").contents().find("#fancybox-close").unbind();
    $("#fancybox-wrap").contents().find("#fancybox-close").click(function(event) {
        try {
            event.preventDefault();
            event.stopPropagation();
            if ($("#fancybox-frame").contents().find('.multiBuilderElements_warning').length > 0) {
                if (confirm($("#fancybox-frame").contents().find('.multiBuilderElements_warning').text())) {
                    parent.$.fancybox.close();
                }
            }
            else{
                parent.$.fancybox.close();
            }
            return false;
        }
        catch(error){
            parent.$.fancybox.close();
        }
    });


// init builder
    if( $( '#builderBox div.builder.active' ).length != 0 )
    {
        init_builder();
    }


// handle 3d iframe content
    if( $( '#3dframe' ).length != 0 )
    {
// init iframe with first 3d link
        $.fancybox.showActivity();
        $( '#3dframe' ).load( function()
        {
            $.fancybox.hideActivity();
        });
        $( '#3dframe' ).attr( 'src', $( 'a.3dswitch:first' ).attr( 'rel' ) );

// handle 3d links
        $( 'a.3dswitch' ).click( function()
        {
// load iframe
            var url= $( this ).attr( 'rel' );
            $.fancybox.showActivity();
            $( '#3dframe' ).load( function(){
                $.fancybox.hideActivity();
            });
            $( '#3dframe' ).attr( 'src', url );

// change fullscreen button
            $( '#3dfullscreen' ).attr( 'href', url );

            return false;
        });
    }


// make "modal" links open fancybox
    if( $( '.modal' ).length != 0 )
    {
        setModal();
    }


// make td clickable
    if( $( 'td.clickable' ).length != 0 )
    {
        $( 'td.clickable' ).click( function () {
            var url= $( this ).attr( 'rel' );
            var target= $( this ).attr( 'target' );
            if( target == 'parent' )
            {
                parent.window.location= url;
            } else
            {
                window.location= url;
            }
            return true;
        });
    }


    var orderListButtonClicks = 0;
    $('.orderListButton').bind('click', function() {
        orderListButtonClicks++;  //count clicks
        if(orderListButtonClicks === 1) {
            var box = $(this).attr('box');
            var idProduct = $(this).attr('idproduct');
            var idTreeGroup = $(this).attr('treegroup');
            var tablerow = $(this).attr('tablerow');
            set_builder_element( box, idProduct, idTreeGroup, tablerow );
            return false;
        }else{
            orderListButtonClicks = 0;
        }
    });

    $('.orderListButton').bind('dblclick', function() {
        return false;
    });

    /*
    // make td selectable
    if( $( 'td.selectable' ).length != 0 )
    {
    $( 'td.selectable' ).click( function () {
    var data= $( this ).attr( 'rel' ).split( '#' );
    set_builder_element( data[0], data[1], data[2], data[3] );
    return true;
    });
    }
    */


// toggle for moreFilters
    if( $( '.toggle' ).length != 0 )
    {
// toggle visibility on click
        $( '.toggle' ).click( function () {
            var toggleElementID= $( this ).attr( 'rel' );
            $( '#' + toggleElementID ).slideToggle( 'slow' );

            if( $( this ).attr( 'status' ) == 1 )
            {
                $( this ).html( $( this ).attr( 'txton' ) );
            } else
            {
                $( this ).html( $( this ).attr( 'txtoff' ) );
            }

// toggle status
            $( this ).attr( 'status', $( this ).attr( 'status' ) * -1 );

// store status
            $( "#filterVisibilityFlag" ).val( $( this ).attr( 'status' ) );
        });

// hide all on init if flag is set
        $( '.toggle' ).each( function () {
            toggleElementID= $( this ).attr( 'rel' );

// get status
            if( $( "#filterVisibilityFlag" ).val() == 1 )
            {
                $( this ).attr( 'status', 1 );
                $( this ).html( $( this ).attr( 'txtoff' ) );
            } else
            {
                $( '#' + toggleElementID ).hide();
                $( this ).attr( 'status', -1 );
                $( this ).html( $( this ).attr( 'txton' ) );
            }

            $( "#filterVisibilityFlag" ).val( $( this ).attr( 'status' ) );
        });
    }


// add "last" class to last tr in tables
    if( $( 'table' ).length != 0 )
    {
        $( 'table' ).each( function() {
            $( this ).find( 'tr:last' ).addClass( 'last' );
        });
    }


// focus first input fields with .focus class
    if( $( 'input.focus:visible' ).length != 0 )
    {
        $( 'input.focus:visible' ).first().focus();
    }


// make img zoom use fancybox
    $( '.modalImg' ).fancybox({
        overlayOpacity:0.5,
        overlayColor:'#000',
        padding:10,
        margin:0,
        centerOnScroll:true,
        titlePosition:'inside'
    });


// highlight search terms
    if( $( '#highlightSearch' ).length != 0 )
    {
        var term= $( '#highlightSearch' ).attr( 'rel' );
        $( document ).SearchHighlight({
            style_name:"searchHighlight",
            exact:"partial",
            keys:term,
            highlight:".content, .SearchHighlight",
            nohighlight:".noSearchHighlight, .nav"
        });
    }


// autocomplete
    if( $( '#quicksearch' ).length != 0 )
    {
        $( '#quicksearch' ).autocomplete({
            serviceUrl:"/index.php?pltpl=fulltextsearch_quickresults",
            minChars:3,
            delimiter:/(,|;)\s*/,// regex or character
            maxHeight:400,
            width:400,
            zIndex:9999,
            deferRequestBy:0,// miliseconds
            noCache: false,// default is false, set to true to disable caching
            onSelect: function( value, data ) {
// remove next line to start the search directlyjump directly to the selected product
                window.location.href= "/index.php?plugin=fulltextsearch_results&search=" + value;
// remove next line to jump directly to the selected product
//window.location.href= "index.php?IdProduct=" + data;
            }
        });
    }

// show product finder drop down boxes (disabled in css)
    if( $( 'select.prodFinder' ).length != 0 )
    {
        $( 'select.prodFinder' ).show();
    }

// handle selection of a reseller country
    if( $( 'select.reseller' ).length != 0 )
    {
        $( 'select.reseller' ).change(function(){
            if( $('select.reseller').val() != "none") {
                $.fancybox.showActivity();
                $( '#distributors' ).load(
                    "index.php?pltpl=dummy_showDistributors",
                    {
                        pid: $('input.pid').val(),
                        iso: $('select.reseller').val()
                    },
                    function() {
                        $.fancybox.hideActivity();
                    }
                );
            } else {
                $( '#distributors' ).html('');
            }
        });
    }

    if ($('.k_3d').length != 0) {
        var id = $('.k_3d').attr('id');
        var temp = id.split("__");
        var partId;
        var partNumber;

        $.ajax({
            type: "GET",
            url: "http://ws.tracepartsonline.net/tpowebservices/PartNumberAvailability",
            cache: false,
            data: {
                PartNumber: temp[1],
                Catalog: "EAO",
                Format: 'json',
                ApiKey: 'xdv8qSjD8whdiA'
            },
            success: function(data)
            {
                partId = data.partId;
                partNumber = data.partNumber;

                if ($('#show3D').val() == '1') {
                    show3D(partId, partNumber);
                }
            },
            error: function(){
                $('.k_3d').prop('disabled', true);
            }
        });
    }

    $('.k_3d').click(function(e) {
        e.preventDefault();

        show3D(partId, partNumber);
    });

});

function show3D(partId, partNumber) {
    if (partId && partNumber) {
        var show3D_p = $('#show3D_p').val();
        var url = "http://www.tracepartsonline.net//ws/EAO/product.aspx?PartFamilyId=" + encodeURIComponent(partId) + "&CanonicalPartNumber=" + encodeURIComponent(partNumber) + "&CatalogId=EAO&p="+ show3D_p;
        $.fancybox({
            'href': url,
            overlayOpacity: 0.5,
            overlayColor: '#000',
            width: 700,
            height: 450,
            padding: 10,
            margin: 0,
            autoDimensions: true,
            autoScale: false,
            centerOnScroll: true,
            hideOnOverlayClick: false,
            type: 'iframe'
        });
    }
}

var $nav = $('.nav');
$nav.find('a:eq(0)').attr('href', 'functions-1.html');
$nav.find('a:eq(1)').attr('href', 'functions.html');
$nav.find('a:eq(2)').attr('href', 'functions-2.html');
