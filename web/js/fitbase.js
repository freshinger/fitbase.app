/**
 *
 * Color picker
 * Author: Stefan Petre www.eyecon.ro
 *
 * Dual licensed under the MIT and GPL licenses
 *
 */
(function ($) {
    var ColorPicker = function () {
        var
            ids = {},
            inAction,
            charMin = 65,
            visible,
            tpl = '<div class="colorpicker"><div class="colorpicker_color"><div><div></div></div></div><div class="colorpicker_hue"><div></div></div><div class="colorpicker_new_color"></div><div class="colorpicker_current_color"></div><div class="colorpicker_hex"><input type="text" maxlength="6" size="6" /></div><div class="colorpicker_rgb_r colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_rgb_g colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_rgb_b colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_hsb_h colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_hsb_s colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_hsb_b colorpicker_field"><input type="text" maxlength="3" size="3" /><span></span></div><div class="colorpicker_submit"></div></div>',
            defaults = {
                eventName: 'click',
                onShow: function () {
                },
                onBeforeShow: function () {
                },
                onHide: function () {
                },
                onChange: function () {
                },
                onSubmit: function () {
                },
                color: 'ff0000',
                livePreview: true,
                flat: false
            },
            fillRGBFields = function (hsb, cal) {
                var rgb = HSBToRGB(hsb);
                $(cal).data('colorpicker').fields
                    .eq(1).val(rgb.r).end()
                    .eq(2).val(rgb.g).end()
                    .eq(3).val(rgb.b).end();
            },
            fillHSBFields = function (hsb, cal) {
                $(cal).data('colorpicker').fields
                    .eq(4).val(hsb.h).end()
                    .eq(5).val(hsb.s).end()
                    .eq(6).val(hsb.b).end();
            },
            fillHexFields = function (hsb, cal) {
                $(cal).data('colorpicker').fields
                    .eq(0).val(HSBToHex(hsb)).end();
            },
            setSelector = function (hsb, cal) {
                $(cal).data('colorpicker').selector.css('backgroundColor', '#' + HSBToHex({h: hsb.h, s: 100, b: 100}));
                $(cal).data('colorpicker').selectorIndic.css({
                    left: parseInt(150 * hsb.s / 100, 10),
                    top: parseInt(150 * (100 - hsb.b) / 100, 10)
                });
            },
            setHue = function (hsb, cal) {
                $(cal).data('colorpicker').hue.css('top', parseInt(150 - 150 * hsb.h / 360, 10));
            },
            setCurrentColor = function (hsb, cal) {
                $(cal).data('colorpicker').currentColor.css('backgroundColor', '#' + HSBToHex(hsb));
            },
            setNewColor = function (hsb, cal) {
                $(cal).data('colorpicker').newColor.css('backgroundColor', '#' + HSBToHex(hsb));
            },
            keyDown = function (ev) {
                var pressedKey = ev.charCode || ev.keyCode || -1;
                if ((pressedKey > charMin && pressedKey <= 90) || pressedKey == 32) {
                    return false;
                }
                var cal = $(this).parent().parent();
                if (cal.data('colorpicker').livePreview === true) {
                    change.apply(this);
                }
            },
            change = function (ev) {
                var cal = $(this).parent().parent(), col;
                if (this.parentNode.className.indexOf('_hex') > 0) {
                    cal.data('colorpicker').color = col = HexToHSB(fixHex(this.value));
                } else if (this.parentNode.className.indexOf('_hsb') > 0) {
                    cal.data('colorpicker').color = col = fixHSB({
                        h: parseInt(cal.data('colorpicker').fields.eq(4).val(), 10),
                        s: parseInt(cal.data('colorpicker').fields.eq(5).val(), 10),
                        b: parseInt(cal.data('colorpicker').fields.eq(6).val(), 10)
                    });
                } else {
                    cal.data('colorpicker').color = col = RGBToHSB(fixRGB({
                        r: parseInt(cal.data('colorpicker').fields.eq(1).val(), 10),
                        g: parseInt(cal.data('colorpicker').fields.eq(2).val(), 10),
                        b: parseInt(cal.data('colorpicker').fields.eq(3).val(), 10)
                    }));
                }
                if (ev) {
                    fillRGBFields(col, cal.get(0));
                    fillHexFields(col, cal.get(0));
                    fillHSBFields(col, cal.get(0));
                }
                setSelector(col, cal.get(0));
                setHue(col, cal.get(0));
                setNewColor(col, cal.get(0));
                cal.data('colorpicker').onChange.apply(cal, [col, HSBToHex(col), HSBToRGB(col)]);
            },
            blur = function (ev) {
                var cal = $(this).parent().parent();
                cal.data('colorpicker').fields.parent().removeClass('colorpicker_focus');
            },
            focus = function () {
                charMin = this.parentNode.className.indexOf('_hex') > 0 ? 70 : 65;
                $(this).parent().parent().data('colorpicker').fields.parent().removeClass('colorpicker_focus');
                $(this).parent().addClass('colorpicker_focus');
            },
            downIncrement = function (ev) {
                var field = $(this).parent().find('input').focus();
                var current = {
                    el: $(this).parent().addClass('colorpicker_slider'),
                    max: this.parentNode.className.indexOf('_hsb_h') > 0 ? 360 : (this.parentNode.className.indexOf('_hsb') > 0 ? 100 : 255),
                    y: ev.pageY,
                    field: field,
                    val: parseInt(field.val(), 10),
                    preview: $(this).parent().parent().data('colorpicker').livePreview
                };
                $(document).bind('mouseup', current, upIncrement);
                $(document).bind('mousemove', current, moveIncrement);
            },
            moveIncrement = function (ev) {
                ev.data.field.val(Math.max(0, Math.min(ev.data.max, parseInt(ev.data.val + ev.pageY - ev.data.y, 10))));
                if (ev.data.preview) {
                    change.apply(ev.data.field.get(0), [true]);
                }
                return false;
            },
            upIncrement = function (ev) {
                change.apply(ev.data.field.get(0), [true]);
                ev.data.el.removeClass('colorpicker_slider').find('input').focus();
                $(document).unbind('mouseup', upIncrement);
                $(document).unbind('mousemove', moveIncrement);
                return false;
            },
            downHue = function (ev) {
                var current = {
                    cal: $(this).parent(),
                    y: $(this).offset().top
                };
                current.preview = current.cal.data('colorpicker').livePreview;
                $(document).bind('mouseup', current, upHue);
                $(document).bind('mousemove', current, moveHue);
            },
            moveHue = function (ev) {
                change.apply(
                    ev.data.cal.data('colorpicker')
                        .fields
                        .eq(4)
                        .val(parseInt(360 * (150 - Math.max(0, Math.min(150, (ev.pageY - ev.data.y)))) / 150, 10))
                        .get(0),
                    [ev.data.preview]
                );
                return false;
            },
            upHue = function (ev) {
                fillRGBFields(ev.data.cal.data('colorpicker').color, ev.data.cal.get(0));
                fillHexFields(ev.data.cal.data('colorpicker').color, ev.data.cal.get(0));
                $(document).unbind('mouseup', upHue);
                $(document).unbind('mousemove', moveHue);
                return false;
            },
            downSelector = function (ev) {
                var current = {
                    cal: $(this).parent(),
                    pos: $(this).offset()
                };
                current.preview = current.cal.data('colorpicker').livePreview;
                $(document).bind('mouseup', current, upSelector);
                $(document).bind('mousemove', current, moveSelector);
            },
            moveSelector = function (ev) {
                change.apply(
                    ev.data.cal.data('colorpicker')
                        .fields
                        .eq(6)
                        .val(parseInt(100 * (150 - Math.max(0, Math.min(150, (ev.pageY - ev.data.pos.top)))) / 150, 10))
                        .end()
                        .eq(5)
                        .val(parseInt(100 * (Math.max(0, Math.min(150, (ev.pageX - ev.data.pos.left)))) / 150, 10))
                        .get(0),
                    [ev.data.preview]
                );
                return false;
            },
            upSelector = function (ev) {
                fillRGBFields(ev.data.cal.data('colorpicker').color, ev.data.cal.get(0));
                fillHexFields(ev.data.cal.data('colorpicker').color, ev.data.cal.get(0));
                $(document).unbind('mouseup', upSelector);
                $(document).unbind('mousemove', moveSelector);
                return false;
            },
            enterSubmit = function (ev) {
                $(this).addClass('colorpicker_focus');
            },
            leaveSubmit = function (ev) {
                $(this).removeClass('colorpicker_focus');
            },
            clickSubmit = function (ev) {
                var cal = $(this).parent();
                var col = cal.data('colorpicker').color;
                cal.data('colorpicker').origColor = col;
                setCurrentColor(col, cal.get(0));
                cal.data('colorpicker').onSubmit(col, HSBToHex(col), HSBToRGB(col), cal.data('colorpicker').el);
            },
            show = function (ev) {
                var cal = $('#' + $(this).data('colorpickerId'));
                cal.data('colorpicker').onBeforeShow.apply(this, [cal.get(0)]);
                var pos = $(this).offset();
                var viewPort = getViewport();
                var top = pos.top + this.offsetHeight;
                var left = pos.left;
                if (top + 176 > viewPort.t + viewPort.h) {
                    top -= this.offsetHeight + 176;
                }
                if (left + 356 > viewPort.l + viewPort.w) {
                    left -= 356;
                }
                cal.css({left: left + 'px', top: top + 'px'});
                if (cal.data('colorpicker').onShow.apply(this, [cal.get(0)]) != false) {
                    cal.show();
                }
                $(document).bind('mousedown', {cal: cal}, hide);
                return false;
            },
            hide = function (ev) {
                if (!isChildOf(ev.data.cal.get(0), ev.target, ev.data.cal.get(0))) {
                    if (ev.data.cal.data('colorpicker').onHide.apply(this, [ev.data.cal.get(0)]) != false) {
                        ev.data.cal.hide();
                    }
                    $(document).unbind('mousedown', hide);
                }
            },
            isChildOf = function (parentEl, el, container) {
                if (parentEl == el) {
                    return true;
                }
                if (parentEl.contains) {
                    return parentEl.contains(el);
                }
                if (parentEl.compareDocumentPosition) {
                    return !!(parentEl.compareDocumentPosition(el) & 16);
                }
                var prEl = el.parentNode;
                while (prEl && prEl != container) {
                    if (prEl == parentEl)
                        return true;
                    prEl = prEl.parentNode;
                }
                return false;
            },
            getViewport = function () {
                var m = document.compatMode == 'CSS1Compat';
                return {
                    l: window.pageXOffset || (m ? document.documentElement.scrollLeft : document.body.scrollLeft),
                    t: window.pageYOffset || (m ? document.documentElement.scrollTop : document.body.scrollTop),
                    w: window.innerWidth || (m ? document.documentElement.clientWidth : document.body.clientWidth),
                    h: window.innerHeight || (m ? document.documentElement.clientHeight : document.body.clientHeight)
                };
            },
            fixHSB = function (hsb) {
                return {
                    h: Math.min(360, Math.max(0, hsb.h)),
                    s: Math.min(100, Math.max(0, hsb.s)),
                    b: Math.min(100, Math.max(0, hsb.b))
                };
            },
            fixRGB = function (rgb) {
                return {
                    r: Math.min(255, Math.max(0, rgb.r)),
                    g: Math.min(255, Math.max(0, rgb.g)),
                    b: Math.min(255, Math.max(0, rgb.b))
                };
            },
            fixHex = function (hex) {
                var len = 6 - hex.length;
                if (len > 0) {
                    var o = [];
                    for (var i = 0; i < len; i++) {
                        o.push('0');
                    }
                    o.push(hex);
                    hex = o.join('');
                }
                return hex;
            },
            HexToRGB = function (hex) {
                var hex = parseInt(((hex.indexOf('#') > -1) ? hex.substring(1) : hex), 16);
                return {r: hex >> 16, g: (hex & 0x00FF00) >> 8, b: (hex & 0x0000FF)};
            },
            HexToHSB = function (hex) {
                return RGBToHSB(HexToRGB(hex));
            },
            RGBToHSB = function (rgb) {
                var hsb = {
                    h: 0,
                    s: 0,
                    b: 0
                };
                var min = Math.min(rgb.r, rgb.g, rgb.b);
                var max = Math.max(rgb.r, rgb.g, rgb.b);
                var delta = max - min;
                hsb.b = max;
                if (max != 0) {

                }
                hsb.s = max != 0 ? 255 * delta / max : 0;
                if (hsb.s != 0) {
                    if (rgb.r == max) {
                        hsb.h = (rgb.g - rgb.b) / delta;
                    } else if (rgb.g == max) {
                        hsb.h = 2 + (rgb.b - rgb.r) / delta;
                    } else {
                        hsb.h = 4 + (rgb.r - rgb.g) / delta;
                    }
                } else {
                    hsb.h = -1;
                }
                hsb.h *= 60;
                if (hsb.h < 0) {
                    hsb.h += 360;
                }
                hsb.s *= 100 / 255;
                hsb.b *= 100 / 255;
                return hsb;
            },
            HSBToRGB = function (hsb) {
                var rgb = {};
                var h = Math.round(hsb.h);
                var s = Math.round(hsb.s * 255 / 100);
                var v = Math.round(hsb.b * 255 / 100);
                if (s == 0) {
                    rgb.r = rgb.g = rgb.b = v;
                } else {
                    var t1 = v;
                    var t2 = (255 - s) * v / 255;
                    var t3 = (t1 - t2) * (h % 60) / 60;
                    if (h == 360) h = 0;
                    if (h < 60) {
                        rgb.r = t1;
                        rgb.b = t2;
                        rgb.g = t2 + t3
                    }
                    else if (h < 120) {
                        rgb.g = t1;
                        rgb.b = t2;
                        rgb.r = t1 - t3
                    }
                    else if (h < 180) {
                        rgb.g = t1;
                        rgb.r = t2;
                        rgb.b = t2 + t3
                    }
                    else if (h < 240) {
                        rgb.b = t1;
                        rgb.r = t2;
                        rgb.g = t1 - t3
                    }
                    else if (h < 300) {
                        rgb.b = t1;
                        rgb.g = t2;
                        rgb.r = t2 + t3
                    }
                    else if (h < 360) {
                        rgb.r = t1;
                        rgb.g = t2;
                        rgb.b = t1 - t3
                    }
                    else {
                        rgb.r = 0;
                        rgb.g = 0;
                        rgb.b = 0
                    }
                }
                return {r: Math.round(rgb.r), g: Math.round(rgb.g), b: Math.round(rgb.b)};
            },
            RGBToHex = function (rgb) {
                var hex = [
                    rgb.r.toString(16),
                    rgb.g.toString(16),
                    rgb.b.toString(16)
                ];
                $.each(hex, function (nr, val) {
                    if (val.length == 1) {
                        hex[nr] = '0' + val;
                    }
                });
                return hex.join('');
            },
            HSBToHex = function (hsb) {
                return RGBToHex(HSBToRGB(hsb));
            },
            restoreOriginal = function () {
                var cal = $(this).parent();
                var col = cal.data('colorpicker').origColor;
                cal.data('colorpicker').color = col;
                fillRGBFields(col, cal.get(0));
                fillHexFields(col, cal.get(0));
                fillHSBFields(col, cal.get(0));
                setSelector(col, cal.get(0));
                setHue(col, cal.get(0));
                setNewColor(col, cal.get(0));
            };
        return {
            init: function (opt) {
                opt = $.extend({}, defaults, opt || {});
                if (typeof opt.color == 'string') {
                    opt.color = HexToHSB(opt.color);
                } else if (opt.color.r != undefined && opt.color.g != undefined && opt.color.b != undefined) {
                    opt.color = RGBToHSB(opt.color);
                } else if (opt.color.h != undefined && opt.color.s != undefined && opt.color.b != undefined) {
                    opt.color = fixHSB(opt.color);
                } else {
                    return this;
                }
                return this.each(function () {
                    if (!$(this).data('colorpickerId')) {
                        var options = $.extend({}, opt);
                        options.origColor = opt.color;
                        var id = 'collorpicker_' + parseInt(Math.random() * 1000);
                        $(this).data('colorpickerId', id);
                        var cal = $(tpl).attr('id', id);
                        if (options.flat) {
                            cal.appendTo(this).show();
                        } else {
                            cal.appendTo(document.body);
                        }
                        options.fields = cal
                            .find('input')
                            .bind('keyup', keyDown)
                            .bind('change', change)
                            .bind('blur', blur)
                            .bind('focus', focus);
                        cal
                            .find('span').bind('mousedown', downIncrement).end()
                            .find('>div.colorpicker_current_color').bind('click', restoreOriginal);
                        options.selector = cal.find('div.colorpicker_color').bind('mousedown', downSelector);
                        options.selectorIndic = options.selector.find('div div');
                        options.el = this;
                        options.hue = cal.find('div.colorpicker_hue div');
                        cal.find('div.colorpicker_hue').bind('mousedown', downHue);
                        options.newColor = cal.find('div.colorpicker_new_color');
                        options.currentColor = cal.find('div.colorpicker_current_color');
                        cal.data('colorpicker', options);
                        cal.find('div.colorpicker_submit')
                            .bind('mouseenter', enterSubmit)
                            .bind('mouseleave', leaveSubmit)
                            .bind('click', clickSubmit);
                        fillRGBFields(options.color, cal.get(0));
                        fillHSBFields(options.color, cal.get(0));
                        fillHexFields(options.color, cal.get(0));
                        setHue(options.color, cal.get(0));
                        setSelector(options.color, cal.get(0));
                        setCurrentColor(options.color, cal.get(0));
                        setNewColor(options.color, cal.get(0));
                        if (options.flat) {
                            cal.css({
                                position: 'relative',
                                display: 'block'
                            });
                        } else {
                            $(this).bind(options.eventName, show);
                        }
                    }
                });
            },
            showPicker: function () {
                return this.each(function () {
                    if ($(this).data('colorpickerId')) {
                        show.apply(this);
                    }
                });
            },
            hidePicker: function () {
                return this.each(function () {
                    if ($(this).data('colorpickerId')) {
                        $('#' + $(this).data('colorpickerId')).hide();
                    }
                });
            },
            setColor: function (col) {
                if (typeof col == 'string') {
                    col = HexToHSB(col);
                } else if (col.r != undefined && col.g != undefined && col.b != undefined) {
                    col = RGBToHSB(col);
                } else if (col.h != undefined && col.s != undefined && col.b != undefined) {
                    col = fixHSB(col);
                } else {
                    return this;
                }
                return this.each(function () {
                    if ($(this).data('colorpickerId')) {
                        var cal = $('#' + $(this).data('colorpickerId'));
                        cal.data('colorpicker').color = col;
                        cal.data('colorpicker').origColor = col;
                        fillRGBFields(col, cal.get(0));
                        fillHSBFields(col, cal.get(0));
                        fillHexFields(col, cal.get(0));
                        setHue(col, cal.get(0));
                        setSelector(col, cal.get(0));
                        setCurrentColor(col, cal.get(0));
                        setNewColor(col, cal.get(0));
                    }
                });
            }
        };
    }();
    $.fn.extend({
        ColorPicker: ColorPicker.init,
        ColorPickerHide: ColorPicker.hidePicker,
        ColorPickerShow: ColorPicker.showPicker,
        ColorPickerSetColor: ColorPicker.setColor
    });
})(jQuery)
!function(){function n(n){return n&&(n.ownerDocument||n.document||n).documentElement}function t(n){return n&&(n.ownerDocument&&n.ownerDocument.defaultView||n.document&&n||n.defaultView)}function e(n,t){return t>n?-1:n>t?1:n>=t?0:0/0}function r(n){return null===n?0/0:+n}function u(n){return!isNaN(n)}function i(n){return{left:function(t,e,r,u){for(arguments.length<3&&(r=0),arguments.length<4&&(u=t.length);u>r;){var i=r+u>>>1;n(t[i],e)<0?r=i+1:u=i}return r},right:function(t,e,r,u){for(arguments.length<3&&(r=0),arguments.length<4&&(u=t.length);u>r;){var i=r+u>>>1;n(t[i],e)>0?u=i:r=i+1}return r}}}function o(n){return n.length}function a(n){for(var t=1;n*t%1;)t*=10;return t}function c(n,t){for(var e in t)Object.defineProperty(n.prototype,e,{value:t[e],enumerable:!1})}function l(){this._=Object.create(null)}function s(n){return(n+="")===pa||n[0]===va?va+n:n}function f(n){return(n+="")[0]===va?n.slice(1):n}function h(n){return s(n)in this._}function g(n){return(n=s(n))in this._&&delete this._[n]}function p(){var n=[];for(var t in this._)n.push(f(t));return n}function v(){var n=0;for(var t in this._)++n;return n}function d(){for(var n in this._)return!1;return!0}function m(){this._=Object.create(null)}function y(n){return n}function M(n,t,e){return function(){var r=e.apply(t,arguments);return r===t?n:r}}function x(n,t){if(t in n)return t;t=t.charAt(0).toUpperCase()+t.slice(1);for(var e=0,r=da.length;r>e;++e){var u=da[e]+t;if(u in n)return u}}function b(){}function _(){}function w(n){function t(){for(var t,r=e,u=-1,i=r.length;++u<i;)(t=r[u].on)&&t.apply(this,arguments);return n}var e=[],r=new l;return t.on=function(t,u){var i,o=r.get(t);return arguments.length<2?o&&o.on:(o&&(o.on=null,e=e.slice(0,i=e.indexOf(o)).concat(e.slice(i+1)),r.remove(t)),u&&e.push(r.set(t,{on:u})),n)},t}function S(){ta.event.preventDefault()}function k(){for(var n,t=ta.event;n=t.sourceEvent;)t=n;return t}function E(n){for(var t=new _,e=0,r=arguments.length;++e<r;)t[arguments[e]]=w(t);return t.of=function(e,r){return function(u){try{var i=u.sourceEvent=ta.event;u.target=n,ta.event=u,t[u.type].apply(e,r)}finally{ta.event=i}}},t}function A(n){return ya(n,_a),n}function N(n){return"function"==typeof n?n:function(){return Ma(n,this)}}function C(n){return"function"==typeof n?n:function(){return xa(n,this)}}function z(n,t){function e(){this.removeAttribute(n)}function r(){this.removeAttributeNS(n.space,n.local)}function u(){this.setAttribute(n,t)}function i(){this.setAttributeNS(n.space,n.local,t)}function o(){var e=t.apply(this,arguments);null==e?this.removeAttribute(n):this.setAttribute(n,e)}function a(){var e=t.apply(this,arguments);null==e?this.removeAttributeNS(n.space,n.local):this.setAttributeNS(n.space,n.local,e)}return n=ta.ns.qualify(n),null==t?n.local?r:e:"function"==typeof t?n.local?a:o:n.local?i:u}function q(n){return n.trim().replace(/\s+/g," ")}function L(n){return new RegExp("(?:^|\\s+)"+ta.requote(n)+"(?:\\s+|$)","g")}function T(n){return(n+"").trim().split(/^|\s+/)}function R(n,t){function e(){for(var e=-1;++e<u;)n[e](this,t)}function r(){for(var e=-1,r=t.apply(this,arguments);++e<u;)n[e](this,r)}n=T(n).map(D);var u=n.length;return"function"==typeof t?r:e}function D(n){var t=L(n);return function(e,r){if(u=e.classList)return r?u.add(n):u.remove(n);var u=e.getAttribute("class")||"";r?(t.lastIndex=0,t.test(u)||e.setAttribute("class",q(u+" "+n))):e.setAttribute("class",q(u.replace(t," ")))}}function P(n,t,e){function r(){this.style.removeProperty(n)}function u(){this.style.setProperty(n,t,e)}function i(){var r=t.apply(this,arguments);null==r?this.style.removeProperty(n):this.style.setProperty(n,r,e)}return null==t?r:"function"==typeof t?i:u}function U(n,t){function e(){delete this[n]}function r(){this[n]=t}function u(){var e=t.apply(this,arguments);null==e?delete this[n]:this[n]=e}return null==t?e:"function"==typeof t?u:r}function j(n){function t(){var t=this.ownerDocument,e=this.namespaceURI;return e?t.createElementNS(e,n):t.createElement(n)}function e(){return this.ownerDocument.createElementNS(n.space,n.local)}return"function"==typeof n?n:(n=ta.ns.qualify(n)).local?e:t}function F(){var n=this.parentNode;n&&n.removeChild(this)}function H(n){return{__data__:n}}function O(n){return function(){return ba(this,n)}}function I(n){return arguments.length||(n=e),function(t,e){return t&&e?n(t.__data__,e.__data__):!t-!e}}function Y(n,t){for(var e=0,r=n.length;r>e;e++)for(var u,i=n[e],o=0,a=i.length;a>o;o++)(u=i[o])&&t(u,o,e);return n}function Z(n){return ya(n,Sa),n}function V(n){var t,e;return function(r,u,i){var o,a=n[i].update,c=a.length;for(i!=e&&(e=i,t=0),u>=t&&(t=u+1);!(o=a[t])&&++t<c;);return o}}function X(n,t,e){function r(){var t=this[o];t&&(this.removeEventListener(n,t,t.$),delete this[o])}function u(){var u=c(t,ra(arguments));r.call(this),this.addEventListener(n,this[o]=u,u.$=e),u._=t}function i(){var t,e=new RegExp("^__on([^.]+)"+ta.requote(n)+"$");for(var r in this)if(t=r.match(e)){var u=this[r];this.removeEventListener(t[1],u,u.$),delete this[r]}}var o="__on"+n,a=n.indexOf("."),c=$;a>0&&(n=n.slice(0,a));var l=ka.get(n);return l&&(n=l,c=B),a?t?u:r:t?b:i}function $(n,t){return function(e){var r=ta.event;ta.event=e,t[0]=this.__data__;try{n.apply(this,t)}finally{ta.event=r}}}function B(n,t){var e=$(n,t);return function(n){var t=this,r=n.relatedTarget;r&&(r===t||8&r.compareDocumentPosition(t))||e.call(t,n)}}function W(e){var r=".dragsuppress-"+ ++Aa,u="click"+r,i=ta.select(t(e)).on("touchmove"+r,S).on("dragstart"+r,S).on("selectstart"+r,S);if(null==Ea&&(Ea="onselectstart"in e?!1:x(e.style,"userSelect")),Ea){var o=n(e).style,a=o[Ea];o[Ea]="none"}return function(n){if(i.on(r,null),Ea&&(o[Ea]=a),n){var t=function(){i.on(u,null)};i.on(u,function(){S(),t()},!0),setTimeout(t,0)}}}function J(n,e){e.changedTouches&&(e=e.changedTouches[0]);var r=n.ownerSVGElement||n;if(r.createSVGPoint){var u=r.createSVGPoint();if(0>Na){var i=t(n);if(i.scrollX||i.scrollY){r=ta.select("body").append("svg").style({position:"absolute",top:0,left:0,margin:0,padding:0,border:"none"},"important");var o=r[0][0].getScreenCTM();Na=!(o.f||o.e),r.remove()}}return Na?(u.x=e.pageX,u.y=e.pageY):(u.x=e.clientX,u.y=e.clientY),u=u.matrixTransform(n.getScreenCTM().inverse()),[u.x,u.y]}var a=n.getBoundingClientRect();return[e.clientX-a.left-n.clientLeft,e.clientY-a.top-n.clientTop]}function G(){return ta.event.changedTouches[0].identifier}function K(n){return n>0?1:0>n?-1:0}function Q(n,t,e){return(t[0]-n[0])*(e[1]-n[1])-(t[1]-n[1])*(e[0]-n[0])}function nt(n){return n>1?0:-1>n?qa:Math.acos(n)}function tt(n){return n>1?Ra:-1>n?-Ra:Math.asin(n)}function et(n){return((n=Math.exp(n))-1/n)/2}function rt(n){return((n=Math.exp(n))+1/n)/2}function ut(n){return((n=Math.exp(2*n))-1)/(n+1)}function it(n){return(n=Math.sin(n/2))*n}function ot(){}function at(n,t,e){return this instanceof at?(this.h=+n,this.s=+t,void(this.l=+e)):arguments.length<2?n instanceof at?new at(n.h,n.s,n.l):bt(""+n,_t,at):new at(n,t,e)}function ct(n,t,e){function r(n){return n>360?n-=360:0>n&&(n+=360),60>n?i+(o-i)*n/60:180>n?o:240>n?i+(o-i)*(240-n)/60:i}function u(n){return Math.round(255*r(n))}var i,o;return n=isNaN(n)?0:(n%=360)<0?n+360:n,t=isNaN(t)?0:0>t?0:t>1?1:t,e=0>e?0:e>1?1:e,o=.5>=e?e*(1+t):e+t-e*t,i=2*e-o,new mt(u(n+120),u(n),u(n-120))}function lt(n,t,e){return this instanceof lt?(this.h=+n,this.c=+t,void(this.l=+e)):arguments.length<2?n instanceof lt?new lt(n.h,n.c,n.l):n instanceof ft?gt(n.l,n.a,n.b):gt((n=wt((n=ta.rgb(n)).r,n.g,n.b)).l,n.a,n.b):new lt(n,t,e)}function st(n,t,e){return isNaN(n)&&(n=0),isNaN(t)&&(t=0),new ft(e,Math.cos(n*=Da)*t,Math.sin(n)*t)}function ft(n,t,e){return this instanceof ft?(this.l=+n,this.a=+t,void(this.b=+e)):arguments.length<2?n instanceof ft?new ft(n.l,n.a,n.b):n instanceof lt?st(n.h,n.c,n.l):wt((n=mt(n)).r,n.g,n.b):new ft(n,t,e)}function ht(n,t,e){var r=(n+16)/116,u=r+t/500,i=r-e/200;return u=pt(u)*Xa,r=pt(r)*$a,i=pt(i)*Ba,new mt(dt(3.2404542*u-1.5371385*r-.4985314*i),dt(-.969266*u+1.8760108*r+.041556*i),dt(.0556434*u-.2040259*r+1.0572252*i))}function gt(n,t,e){return n>0?new lt(Math.atan2(e,t)*Pa,Math.sqrt(t*t+e*e),n):new lt(0/0,0/0,n)}function pt(n){return n>.206893034?n*n*n:(n-4/29)/7.787037}function vt(n){return n>.008856?Math.pow(n,1/3):7.787037*n+4/29}function dt(n){return Math.round(255*(.00304>=n?12.92*n:1.055*Math.pow(n,1/2.4)-.055))}function mt(n,t,e){return this instanceof mt?(this.r=~~n,this.g=~~t,void(this.b=~~e)):arguments.length<2?n instanceof mt?new mt(n.r,n.g,n.b):bt(""+n,mt,ct):new mt(n,t,e)}function yt(n){return new mt(n>>16,n>>8&255,255&n)}function Mt(n){return yt(n)+""}function xt(n){return 16>n?"0"+Math.max(0,n).toString(16):Math.min(255,n).toString(16)}function bt(n,t,e){var r,u,i,o=0,a=0,c=0;if(r=/([a-z]+)\((.*)\)/i.exec(n))switch(u=r[2].split(","),r[1]){case"hsl":return e(parseFloat(u[0]),parseFloat(u[1])/100,parseFloat(u[2])/100);case"rgb":return t(kt(u[0]),kt(u[1]),kt(u[2]))}return(i=Ga.get(n.toLowerCase()))?t(i.r,i.g,i.b):(null==n||"#"!==n.charAt(0)||isNaN(i=parseInt(n.slice(1),16))||(4===n.length?(o=(3840&i)>>4,o=o>>4|o,a=240&i,a=a>>4|a,c=15&i,c=c<<4|c):7===n.length&&(o=(16711680&i)>>16,a=(65280&i)>>8,c=255&i)),t(o,a,c))}function _t(n,t,e){var r,u,i=Math.min(n/=255,t/=255,e/=255),o=Math.max(n,t,e),a=o-i,c=(o+i)/2;return a?(u=.5>c?a/(o+i):a/(2-o-i),r=n==o?(t-e)/a+(e>t?6:0):t==o?(e-n)/a+2:(n-t)/a+4,r*=60):(r=0/0,u=c>0&&1>c?0:r),new at(r,u,c)}function wt(n,t,e){n=St(n),t=St(t),e=St(e);var r=vt((.4124564*n+.3575761*t+.1804375*e)/Xa),u=vt((.2126729*n+.7151522*t+.072175*e)/$a),i=vt((.0193339*n+.119192*t+.9503041*e)/Ba);return ft(116*u-16,500*(r-u),200*(u-i))}function St(n){return(n/=255)<=.04045?n/12.92:Math.pow((n+.055)/1.055,2.4)}function kt(n){var t=parseFloat(n);return"%"===n.charAt(n.length-1)?Math.round(2.55*t):t}function Et(n){return"function"==typeof n?n:function(){return n}}function At(n){return function(t,e,r){return 2===arguments.length&&"function"==typeof e&&(r=e,e=null),Nt(t,e,n,r)}}function Nt(n,t,e,r){function u(){var n,t=c.status;if(!t&&zt(c)||t>=200&&300>t||304===t){try{n=e.call(i,c)}catch(r){return void o.error.call(i,r)}o.load.call(i,n)}else o.error.call(i,c)}var i={},o=ta.dispatch("beforesend","progress","load","error"),a={},c=new XMLHttpRequest,l=null;return!this.XDomainRequest||"withCredentials"in c||!/^(http(s)?:)?\/\//.test(n)||(c=new XDomainRequest),"onload"in c?c.onload=c.onerror=u:c.onreadystatechange=function(){c.readyState>3&&u()},c.onprogress=function(n){var t=ta.event;ta.event=n;try{o.progress.call(i,c)}finally{ta.event=t}},i.header=function(n,t){return n=(n+"").toLowerCase(),arguments.length<2?a[n]:(null==t?delete a[n]:a[n]=t+"",i)},i.mimeType=function(n){return arguments.length?(t=null==n?null:n+"",i):t},i.responseType=function(n){return arguments.length?(l=n,i):l},i.response=function(n){return e=n,i},["get","post"].forEach(function(n){i[n]=function(){return i.send.apply(i,[n].concat(ra(arguments)))}}),i.send=function(e,r,u){if(2===arguments.length&&"function"==typeof r&&(u=r,r=null),c.open(e,n,!0),null==t||"accept"in a||(a.accept=t+",*/*"),c.setRequestHeader)for(var s in a)c.setRequestHeader(s,a[s]);return null!=t&&c.overrideMimeType&&c.overrideMimeType(t),null!=l&&(c.responseType=l),null!=u&&i.on("error",u).on("load",function(n){u(null,n)}),o.beforesend.call(i,c),c.send(null==r?null:r),i},i.abort=function(){return c.abort(),i},ta.rebind(i,o,"on"),null==r?i:i.get(Ct(r))}function Ct(n){return 1===n.length?function(t,e){n(null==t?e:null)}:n}function zt(n){var t=n.responseType;return t&&"text"!==t?n.response:n.responseText}function qt(){var n=Lt(),t=Tt()-n;t>24?(isFinite(t)&&(clearTimeout(tc),tc=setTimeout(qt,t)),nc=0):(nc=1,rc(qt))}function Lt(){var n=Date.now();for(ec=Ka;ec;)n>=ec.t&&(ec.f=ec.c(n-ec.t)),ec=ec.n;return n}function Tt(){for(var n,t=Ka,e=1/0;t;)t.f?t=n?n.n=t.n:Ka=t.n:(t.t<e&&(e=t.t),t=(n=t).n);return Qa=n,e}function Rt(n,t){return t-(n?Math.ceil(Math.log(n)/Math.LN10):1)}function Dt(n,t){var e=Math.pow(10,3*ga(8-t));return{scale:t>8?function(n){return n/e}:function(n){return n*e},symbol:n}}function Pt(n){var t=n.decimal,e=n.thousands,r=n.grouping,u=n.currency,i=r&&e?function(n,t){for(var u=n.length,i=[],o=0,a=r[0],c=0;u>0&&a>0&&(c+a+1>t&&(a=Math.max(1,t-c)),i.push(n.substring(u-=a,u+a)),!((c+=a+1)>t));)a=r[o=(o+1)%r.length];return i.reverse().join(e)}:y;return function(n){var e=ic.exec(n),r=e[1]||" ",o=e[2]||">",a=e[3]||"-",c=e[4]||"",l=e[5],s=+e[6],f=e[7],h=e[8],g=e[9],p=1,v="",d="",m=!1,y=!0;switch(h&&(h=+h.substring(1)),(l||"0"===r&&"="===o)&&(l=r="0",o="="),g){case"n":f=!0,g="g";break;case"%":p=100,d="%",g="f";break;case"p":p=100,d="%",g="r";break;case"b":case"o":case"x":case"X":"#"===c&&(v="0"+g.toLowerCase());case"c":y=!1;case"d":m=!0,h=0;break;case"s":p=-1,g="r"}"$"===c&&(v=u[0],d=u[1]),"r"!=g||h||(g="g"),null!=h&&("g"==g?h=Math.max(1,Math.min(21,h)):("e"==g||"f"==g)&&(h=Math.max(0,Math.min(20,h)))),g=oc.get(g)||Ut;var M=l&&f;return function(n){var e=d;if(m&&n%1)return"";var u=0>n||0===n&&0>1/n?(n=-n,"-"):"-"===a?"":a;if(0>p){var c=ta.formatPrefix(n,h);n=c.scale(n),e=c.symbol+d}else n*=p;n=g(n,h);var x,b,_=n.lastIndexOf(".");if(0>_){var w=y?n.lastIndexOf("e"):-1;0>w?(x=n,b=""):(x=n.substring(0,w),b=n.substring(w))}else x=n.substring(0,_),b=t+n.substring(_+1);!l&&f&&(x=i(x,1/0));var S=v.length+x.length+b.length+(M?0:u.length),k=s>S?new Array(S=s-S+1).join(r):"";return M&&(x=i(k+x,k.length?s-b.length:1/0)),u+=v,n=x+b,("<"===o?u+n+k:">"===o?k+u+n:"^"===o?k.substring(0,S>>=1)+u+n+k.substring(S):u+(M?n:k+n))+e}}}function Ut(n){return n+""}function jt(){this._=new Date(arguments.length>1?Date.UTC.apply(this,arguments):arguments[0])}function Ft(n,t,e){function r(t){var e=n(t),r=i(e,1);return r-t>t-e?e:r}function u(e){return t(e=n(new cc(e-1)),1),e}function i(n,e){return t(n=new cc(+n),e),n}function o(n,r,i){var o=u(n),a=[];if(i>1)for(;r>o;)e(o)%i||a.push(new Date(+o)),t(o,1);else for(;r>o;)a.push(new Date(+o)),t(o,1);return a}function a(n,t,e){try{cc=jt;var r=new jt;return r._=n,o(r,t,e)}finally{cc=Date}}n.floor=n,n.round=r,n.ceil=u,n.offset=i,n.range=o;var c=n.utc=Ht(n);return c.floor=c,c.round=Ht(r),c.ceil=Ht(u),c.offset=Ht(i),c.range=a,n}function Ht(n){return function(t,e){try{cc=jt;var r=new jt;return r._=t,n(r,e)._}finally{cc=Date}}}function Ot(n){function t(n){function t(t){for(var e,u,i,o=[],a=-1,c=0;++a<r;)37===n.charCodeAt(a)&&(o.push(n.slice(c,a)),null!=(u=sc[e=n.charAt(++a)])&&(e=n.charAt(++a)),(i=N[e])&&(e=i(t,null==u?"e"===e?" ":"0":u)),o.push(e),c=a+1);return o.push(n.slice(c,a)),o.join("")}var r=n.length;return t.parse=function(t){var r={y:1900,m:0,d:1,H:0,M:0,S:0,L:0,Z:null},u=e(r,n,t,0);if(u!=t.length)return null;"p"in r&&(r.H=r.H%12+12*r.p);var i=null!=r.Z&&cc!==jt,o=new(i?jt:cc);return"j"in r?o.setFullYear(r.y,0,r.j):"w"in r&&("W"in r||"U"in r)?(o.setFullYear(r.y,0,1),o.setFullYear(r.y,0,"W"in r?(r.w+6)%7+7*r.W-(o.getDay()+5)%7:r.w+7*r.U-(o.getDay()+6)%7)):o.setFullYear(r.y,r.m,r.d),o.setHours(r.H+(r.Z/100|0),r.M+r.Z%100,r.S,r.L),i?o._:o},t.toString=function(){return n},t}function e(n,t,e,r){for(var u,i,o,a=0,c=t.length,l=e.length;c>a;){if(r>=l)return-1;if(u=t.charCodeAt(a++),37===u){if(o=t.charAt(a++),i=C[o in sc?t.charAt(a++):o],!i||(r=i(n,e,r))<0)return-1}else if(u!=e.charCodeAt(r++))return-1}return r}function r(n,t,e){_.lastIndex=0;var r=_.exec(t.slice(e));return r?(n.w=w.get(r[0].toLowerCase()),e+r[0].length):-1}function u(n,t,e){x.lastIndex=0;var r=x.exec(t.slice(e));return r?(n.w=b.get(r[0].toLowerCase()),e+r[0].length):-1}function i(n,t,e){E.lastIndex=0;var r=E.exec(t.slice(e));return r?(n.m=A.get(r[0].toLowerCase()),e+r[0].length):-1}function o(n,t,e){S.lastIndex=0;var r=S.exec(t.slice(e));return r?(n.m=k.get(r[0].toLowerCase()),e+r[0].length):-1}function a(n,t,r){return e(n,N.c.toString(),t,r)}function c(n,t,r){return e(n,N.x.toString(),t,r)}function l(n,t,r){return e(n,N.X.toString(),t,r)}function s(n,t,e){var r=M.get(t.slice(e,e+=2).toLowerCase());return null==r?-1:(n.p=r,e)}var f=n.dateTime,h=n.date,g=n.time,p=n.periods,v=n.days,d=n.shortDays,m=n.months,y=n.shortMonths;t.utc=function(n){function e(n){try{cc=jt;var t=new cc;return t._=n,r(t)}finally{cc=Date}}var r=t(n);return e.parse=function(n){try{cc=jt;var t=r.parse(n);return t&&t._}finally{cc=Date}},e.toString=r.toString,e},t.multi=t.utc.multi=ae;var M=ta.map(),x=Yt(v),b=Zt(v),_=Yt(d),w=Zt(d),S=Yt(m),k=Zt(m),E=Yt(y),A=Zt(y);p.forEach(function(n,t){M.set(n.toLowerCase(),t)});var N={a:function(n){return d[n.getDay()]},A:function(n){return v[n.getDay()]},b:function(n){return y[n.getMonth()]},B:function(n){return m[n.getMonth()]},c:t(f),d:function(n,t){return It(n.getDate(),t,2)},e:function(n,t){return It(n.getDate(),t,2)},H:function(n,t){return It(n.getHours(),t,2)},I:function(n,t){return It(n.getHours()%12||12,t,2)},j:function(n,t){return It(1+ac.dayOfYear(n),t,3)},L:function(n,t){return It(n.getMilliseconds(),t,3)},m:function(n,t){return It(n.getMonth()+1,t,2)},M:function(n,t){return It(n.getMinutes(),t,2)},p:function(n){return p[+(n.getHours()>=12)]},S:function(n,t){return It(n.getSeconds(),t,2)},U:function(n,t){return It(ac.sundayOfYear(n),t,2)},w:function(n){return n.getDay()},W:function(n,t){return It(ac.mondayOfYear(n),t,2)},x:t(h),X:t(g),y:function(n,t){return It(n.getFullYear()%100,t,2)},Y:function(n,t){return It(n.getFullYear()%1e4,t,4)},Z:ie,"%":function(){return"%"}},C={a:r,A:u,b:i,B:o,c:a,d:Qt,e:Qt,H:te,I:te,j:ne,L:ue,m:Kt,M:ee,p:s,S:re,U:Xt,w:Vt,W:$t,x:c,X:l,y:Wt,Y:Bt,Z:Jt,"%":oe};return t}function It(n,t,e){var r=0>n?"-":"",u=(r?-n:n)+"",i=u.length;return r+(e>i?new Array(e-i+1).join(t)+u:u)}function Yt(n){return new RegExp("^(?:"+n.map(ta.requote).join("|")+")","i")}function Zt(n){for(var t=new l,e=-1,r=n.length;++e<r;)t.set(n[e].toLowerCase(),e);return t}function Vt(n,t,e){fc.lastIndex=0;var r=fc.exec(t.slice(e,e+1));return r?(n.w=+r[0],e+r[0].length):-1}function Xt(n,t,e){fc.lastIndex=0;var r=fc.exec(t.slice(e));return r?(n.U=+r[0],e+r[0].length):-1}function $t(n,t,e){fc.lastIndex=0;var r=fc.exec(t.slice(e));return r?(n.W=+r[0],e+r[0].length):-1}function Bt(n,t,e){fc.lastIndex=0;var r=fc.exec(t.slice(e,e+4));return r?(n.y=+r[0],e+r[0].length):-1}function Wt(n,t,e){fc.lastIndex=0;var r=fc.exec(t.slice(e,e+2));return r?(n.y=Gt(+r[0]),e+r[0].length):-1}function Jt(n,t,e){return/^[+-]\d{4}$/.test(t=t.slice(e,e+5))?(n.Z=-t,e+5):-1}function Gt(n){return n+(n>68?1900:2e3)}function Kt(n,t,e){fc.lastIndex=0;var r=fc.exec(t.slice(e,e+2));return r?(n.m=r[0]-1,e+r[0].length):-1}function Qt(n,t,e){fc.lastIndex=0;var r=fc.exec(t.slice(e,e+2));return r?(n.d=+r[0],e+r[0].length):-1}function ne(n,t,e){fc.lastIndex=0;var r=fc.exec(t.slice(e,e+3));return r?(n.j=+r[0],e+r[0].length):-1}function te(n,t,e){fc.lastIndex=0;var r=fc.exec(t.slice(e,e+2));return r?(n.H=+r[0],e+r[0].length):-1}function ee(n,t,e){fc.lastIndex=0;var r=fc.exec(t.slice(e,e+2));return r?(n.M=+r[0],e+r[0].length):-1}function re(n,t,e){fc.lastIndex=0;var r=fc.exec(t.slice(e,e+2));return r?(n.S=+r[0],e+r[0].length):-1}function ue(n,t,e){fc.lastIndex=0;var r=fc.exec(t.slice(e,e+3));return r?(n.L=+r[0],e+r[0].length):-1}function ie(n){var t=n.getTimezoneOffset(),e=t>0?"-":"+",r=ga(t)/60|0,u=ga(t)%60;return e+It(r,"0",2)+It(u,"0",2)}function oe(n,t,e){hc.lastIndex=0;var r=hc.exec(t.slice(e,e+1));return r?e+r[0].length:-1}function ae(n){for(var t=n.length,e=-1;++e<t;)n[e][0]=this(n[e][0]);return function(t){for(var e=0,r=n[e];!r[1](t);)r=n[++e];return r[0](t)}}function ce(){}function le(n,t,e){var r=e.s=n+t,u=r-n,i=r-u;e.t=n-i+(t-u)}function se(n,t){n&&dc.hasOwnProperty(n.type)&&dc[n.type](n,t)}function fe(n,t,e){var r,u=-1,i=n.length-e;for(t.lineStart();++u<i;)r=n[u],t.point(r[0],r[1],r[2]);t.lineEnd()}function he(n,t){var e=-1,r=n.length;for(t.polygonStart();++e<r;)fe(n[e],t,1);t.polygonEnd()}function ge(){function n(n,t){n*=Da,t=t*Da/2+qa/4;var e=n-r,o=e>=0?1:-1,a=o*e,c=Math.cos(t),l=Math.sin(t),s=i*l,f=u*c+s*Math.cos(a),h=s*o*Math.sin(a);yc.add(Math.atan2(h,f)),r=n,u=c,i=l}var t,e,r,u,i;Mc.point=function(o,a){Mc.point=n,r=(t=o)*Da,u=Math.cos(a=(e=a)*Da/2+qa/4),i=Math.sin(a)},Mc.lineEnd=function(){n(t,e)}}function pe(n){var t=n[0],e=n[1],r=Math.cos(e);return[r*Math.cos(t),r*Math.sin(t),Math.sin(e)]}function ve(n,t){return n[0]*t[0]+n[1]*t[1]+n[2]*t[2]}function de(n,t){return[n[1]*t[2]-n[2]*t[1],n[2]*t[0]-n[0]*t[2],n[0]*t[1]-n[1]*t[0]]}function me(n,t){n[0]+=t[0],n[1]+=t[1],n[2]+=t[2]}function ye(n,t){return[n[0]*t,n[1]*t,n[2]*t]}function Me(n){var t=Math.sqrt(n[0]*n[0]+n[1]*n[1]+n[2]*n[2]);n[0]/=t,n[1]/=t,n[2]/=t}function xe(n){return[Math.atan2(n[1],n[0]),tt(n[2])]}function be(n,t){return ga(n[0]-t[0])<Ca&&ga(n[1]-t[1])<Ca}function _e(n,t){n*=Da;var e=Math.cos(t*=Da);we(e*Math.cos(n),e*Math.sin(n),Math.sin(t))}function we(n,t,e){++xc,_c+=(n-_c)/xc,wc+=(t-wc)/xc,Sc+=(e-Sc)/xc}function Se(){function n(n,u){n*=Da;var i=Math.cos(u*=Da),o=i*Math.cos(n),a=i*Math.sin(n),c=Math.sin(u),l=Math.atan2(Math.sqrt((l=e*c-r*a)*l+(l=r*o-t*c)*l+(l=t*a-e*o)*l),t*o+e*a+r*c);bc+=l,kc+=l*(t+(t=o)),Ec+=l*(e+(e=a)),Ac+=l*(r+(r=c)),we(t,e,r)}var t,e,r;qc.point=function(u,i){u*=Da;var o=Math.cos(i*=Da);t=o*Math.cos(u),e=o*Math.sin(u),r=Math.sin(i),qc.point=n,we(t,e,r)}}function ke(){qc.point=_e}function Ee(){function n(n,t){n*=Da;var e=Math.cos(t*=Da),o=e*Math.cos(n),a=e*Math.sin(n),c=Math.sin(t),l=u*c-i*a,s=i*o-r*c,f=r*a-u*o,h=Math.sqrt(l*l+s*s+f*f),g=r*o+u*a+i*c,p=h&&-nt(g)/h,v=Math.atan2(h,g);Nc+=p*l,Cc+=p*s,zc+=p*f,bc+=v,kc+=v*(r+(r=o)),Ec+=v*(u+(u=a)),Ac+=v*(i+(i=c)),we(r,u,i)}var t,e,r,u,i;qc.point=function(o,a){t=o,e=a,qc.point=n,o*=Da;var c=Math.cos(a*=Da);r=c*Math.cos(o),u=c*Math.sin(o),i=Math.sin(a),we(r,u,i)},qc.lineEnd=function(){n(t,e),qc.lineEnd=ke,qc.point=_e}}function Ae(n,t){function e(e,r){return e=n(e,r),t(e[0],e[1])}return n.invert&&t.invert&&(e.invert=function(e,r){return e=t.invert(e,r),e&&n.invert(e[0],e[1])}),e}function Ne(){return!0}function Ce(n,t,e,r,u){var i=[],o=[];if(n.forEach(function(n){if(!((t=n.length-1)<=0)){var t,e=n[0],r=n[t];if(be(e,r)){u.lineStart();for(var a=0;t>a;++a)u.point((e=n[a])[0],e[1]);return void u.lineEnd()}var c=new qe(e,n,null,!0),l=new qe(e,null,c,!1);c.o=l,i.push(c),o.push(l),c=new qe(r,n,null,!1),l=new qe(r,null,c,!0),c.o=l,i.push(c),o.push(l)}}),o.sort(t),ze(i),ze(o),i.length){for(var a=0,c=e,l=o.length;l>a;++a)o[a].e=c=!c;for(var s,f,h=i[0];;){for(var g=h,p=!0;g.v;)if((g=g.n)===h)return;s=g.z,u.lineStart();do{if(g.v=g.o.v=!0,g.e){if(p)for(var a=0,l=s.length;l>a;++a)u.point((f=s[a])[0],f[1]);else r(g.x,g.n.x,1,u);g=g.n}else{if(p){s=g.p.z;for(var a=s.length-1;a>=0;--a)u.point((f=s[a])[0],f[1])}else r(g.x,g.p.x,-1,u);g=g.p}g=g.o,s=g.z,p=!p}while(!g.v);u.lineEnd()}}}function ze(n){if(t=n.length){for(var t,e,r=0,u=n[0];++r<t;)u.n=e=n[r],e.p=u,u=e;u.n=e=n[0],e.p=u}}function qe(n,t,e,r){this.x=n,this.z=t,this.o=e,this.e=r,this.v=!1,this.n=this.p=null}function Le(n,t,e,r){return function(u,i){function o(t,e){var r=u(t,e);n(t=r[0],e=r[1])&&i.point(t,e)}function a(n,t){var e=u(n,t);d.point(e[0],e[1])}function c(){y.point=a,d.lineStart()}function l(){y.point=o,d.lineEnd()}function s(n,t){v.push([n,t]);var e=u(n,t);x.point(e[0],e[1])}function f(){x.lineStart(),v=[]}function h(){s(v[0][0],v[0][1]),x.lineEnd();var n,t=x.clean(),e=M.buffer(),r=e.length;if(v.pop(),p.push(v),v=null,r)if(1&t){n=e[0];var u,r=n.length-1,o=-1;if(r>0){for(b||(i.polygonStart(),b=!0),i.lineStart();++o<r;)i.point((u=n[o])[0],u[1]);i.lineEnd()}}else r>1&&2&t&&e.push(e.pop().concat(e.shift())),g.push(e.filter(Te))}var g,p,v,d=t(i),m=u.invert(r[0],r[1]),y={point:o,lineStart:c,lineEnd:l,polygonStart:function(){y.point=s,y.lineStart=f,y.lineEnd=h,g=[],p=[]},polygonEnd:function(){y.point=o,y.lineStart=c,y.lineEnd=l,g=ta.merge(g);var n=Fe(m,p);g.length?(b||(i.polygonStart(),b=!0),Ce(g,De,n,e,i)):n&&(b||(i.polygonStart(),b=!0),i.lineStart(),e(null,null,1,i),i.lineEnd()),b&&(i.polygonEnd(),b=!1),g=p=null},sphere:function(){i.polygonStart(),i.lineStart(),e(null,null,1,i),i.lineEnd(),i.polygonEnd()}},M=Re(),x=t(M),b=!1;return y}}function Te(n){return n.length>1}function Re(){var n,t=[];return{lineStart:function(){t.push(n=[])},point:function(t,e){n.push([t,e])},lineEnd:b,buffer:function(){var e=t;return t=[],n=null,e},rejoin:function(){t.length>1&&t.push(t.pop().concat(t.shift()))}}}function De(n,t){return((n=n.x)[0]<0?n[1]-Ra-Ca:Ra-n[1])-((t=t.x)[0]<0?t[1]-Ra-Ca:Ra-t[1])}function Pe(n){var t,e=0/0,r=0/0,u=0/0;return{lineStart:function(){n.lineStart(),t=1},point:function(i,o){var a=i>0?qa:-qa,c=ga(i-e);ga(c-qa)<Ca?(n.point(e,r=(r+o)/2>0?Ra:-Ra),n.point(u,r),n.lineEnd(),n.lineStart(),n.point(a,r),n.point(i,r),t=0):u!==a&&c>=qa&&(ga(e-u)<Ca&&(e-=u*Ca),ga(i-a)<Ca&&(i-=a*Ca),r=Ue(e,r,i,o),n.point(u,r),n.lineEnd(),n.lineStart(),n.point(a,r),t=0),n.point(e=i,r=o),u=a},lineEnd:function(){n.lineEnd(),e=r=0/0},clean:function(){return 2-t}}}function Ue(n,t,e,r){var u,i,o=Math.sin(n-e);return ga(o)>Ca?Math.atan((Math.sin(t)*(i=Math.cos(r))*Math.sin(e)-Math.sin(r)*(u=Math.cos(t))*Math.sin(n))/(u*i*o)):(t+r)/2}function je(n,t,e,r){var u;if(null==n)u=e*Ra,r.point(-qa,u),r.point(0,u),r.point(qa,u),r.point(qa,0),r.point(qa,-u),r.point(0,-u),r.point(-qa,-u),r.point(-qa,0),r.point(-qa,u);else if(ga(n[0]-t[0])>Ca){var i=n[0]<t[0]?qa:-qa;u=e*i/2,r.point(-i,u),r.point(0,u),r.point(i,u)}else r.point(t[0],t[1])}function Fe(n,t){var e=n[0],r=n[1],u=[Math.sin(e),-Math.cos(e),0],i=0,o=0;yc.reset();for(var a=0,c=t.length;c>a;++a){var l=t[a],s=l.length;if(s)for(var f=l[0],h=f[0],g=f[1]/2+qa/4,p=Math.sin(g),v=Math.cos(g),d=1;;){d===s&&(d=0),n=l[d];var m=n[0],y=n[1]/2+qa/4,M=Math.sin(y),x=Math.cos(y),b=m-h,_=b>=0?1:-1,w=_*b,S=w>qa,k=p*M;if(yc.add(Math.atan2(k*_*Math.sin(w),v*x+k*Math.cos(w))),i+=S?b+_*La:b,S^h>=e^m>=e){var E=de(pe(f),pe(n));Me(E);var A=de(u,E);Me(A);var N=(S^b>=0?-1:1)*tt(A[2]);(r>N||r===N&&(E[0]||E[1]))&&(o+=S^b>=0?1:-1)}if(!d++)break;h=m,p=M,v=x,f=n}}return(-Ca>i||Ca>i&&0>yc)^1&o}function He(n){function t(n,t){return Math.cos(n)*Math.cos(t)>i}function e(n){var e,i,c,l,s;return{lineStart:function(){l=c=!1,s=1},point:function(f,h){var g,p=[f,h],v=t(f,h),d=o?v?0:u(f,h):v?u(f+(0>f?qa:-qa),h):0;if(!e&&(l=c=v)&&n.lineStart(),v!==c&&(g=r(e,p),(be(e,g)||be(p,g))&&(p[0]+=Ca,p[1]+=Ca,v=t(p[0],p[1]))),v!==c)s=0,v?(n.lineStart(),g=r(p,e),n.point(g[0],g[1])):(g=r(e,p),n.point(g[0],g[1]),n.lineEnd()),e=g;else if(a&&e&&o^v){var m;d&i||!(m=r(p,e,!0))||(s=0,o?(n.lineStart(),n.point(m[0][0],m[0][1]),n.point(m[1][0],m[1][1]),n.lineEnd()):(n.point(m[1][0],m[1][1]),n.lineEnd(),n.lineStart(),n.point(m[0][0],m[0][1])))}!v||e&&be(e,p)||n.point(p[0],p[1]),e=p,c=v,i=d},lineEnd:function(){c&&n.lineEnd(),e=null},clean:function(){return s|(l&&c)<<1}}}function r(n,t,e){var r=pe(n),u=pe(t),o=[1,0,0],a=de(r,u),c=ve(a,a),l=a[0],s=c-l*l;if(!s)return!e&&n;var f=i*c/s,h=-i*l/s,g=de(o,a),p=ye(o,f),v=ye(a,h);me(p,v);var d=g,m=ve(p,d),y=ve(d,d),M=m*m-y*(ve(p,p)-1);if(!(0>M)){var x=Math.sqrt(M),b=ye(d,(-m-x)/y);if(me(b,p),b=xe(b),!e)return b;var _,w=n[0],S=t[0],k=n[1],E=t[1];w>S&&(_=w,w=S,S=_);var A=S-w,N=ga(A-qa)<Ca,C=N||Ca>A;if(!N&&k>E&&(_=k,k=E,E=_),C?N?k+E>0^b[1]<(ga(b[0]-w)<Ca?k:E):k<=b[1]&&b[1]<=E:A>qa^(w<=b[0]&&b[0]<=S)){var z=ye(d,(-m+x)/y);return me(z,p),[b,xe(z)]}}}function u(t,e){var r=o?n:qa-n,u=0;return-r>t?u|=1:t>r&&(u|=2),-r>e?u|=4:e>r&&(u|=8),u}var i=Math.cos(n),o=i>0,a=ga(i)>Ca,c=gr(n,6*Da);return Le(t,e,c,o?[0,-n]:[-qa,n-qa])}function Oe(n,t,e,r){return function(u){var i,o=u.a,a=u.b,c=o.x,l=o.y,s=a.x,f=a.y,h=0,g=1,p=s-c,v=f-l;if(i=n-c,p||!(i>0)){if(i/=p,0>p){if(h>i)return;g>i&&(g=i)}else if(p>0){if(i>g)return;i>h&&(h=i)}if(i=e-c,p||!(0>i)){if(i/=p,0>p){if(i>g)return;i>h&&(h=i)}else if(p>0){if(h>i)return;g>i&&(g=i)}if(i=t-l,v||!(i>0)){if(i/=v,0>v){if(h>i)return;g>i&&(g=i)}else if(v>0){if(i>g)return;i>h&&(h=i)}if(i=r-l,v||!(0>i)){if(i/=v,0>v){if(i>g)return;i>h&&(h=i)}else if(v>0){if(h>i)return;g>i&&(g=i)}return h>0&&(u.a={x:c+h*p,y:l+h*v}),1>g&&(u.b={x:c+g*p,y:l+g*v}),u}}}}}}function Ie(n,t,e,r){function u(r,u){return ga(r[0]-n)<Ca?u>0?0:3:ga(r[0]-e)<Ca?u>0?2:1:ga(r[1]-t)<Ca?u>0?1:0:u>0?3:2}function i(n,t){return o(n.x,t.x)}function o(n,t){var e=u(n,1),r=u(t,1);return e!==r?e-r:0===e?t[1]-n[1]:1===e?n[0]-t[0]:2===e?n[1]-t[1]:t[0]-n[0]}return function(a){function c(n){for(var t=0,e=d.length,r=n[1],u=0;e>u;++u)for(var i,o=1,a=d[u],c=a.length,l=a[0];c>o;++o)i=a[o],l[1]<=r?i[1]>r&&Q(l,i,n)>0&&++t:i[1]<=r&&Q(l,i,n)<0&&--t,l=i;return 0!==t}function l(i,a,c,l){var s=0,f=0;if(null==i||(s=u(i,c))!==(f=u(a,c))||o(i,a)<0^c>0){do l.point(0===s||3===s?n:e,s>1?r:t);while((s=(s+c+4)%4)!==f)}else l.point(a[0],a[1])}function s(u,i){return u>=n&&e>=u&&i>=t&&r>=i}function f(n,t){s(n,t)&&a.point(n,t)}function h(){C.point=p,d&&d.push(m=[]),S=!0,w=!1,b=_=0/0}function g(){v&&(p(y,M),x&&w&&A.rejoin(),v.push(A.buffer())),C.point=f,w&&a.lineEnd()}function p(n,t){n=Math.max(-Tc,Math.min(Tc,n)),t=Math.max(-Tc,Math.min(Tc,t));var e=s(n,t);if(d&&m.push([n,t]),S)y=n,M=t,x=e,S=!1,e&&(a.lineStart(),a.point(n,t));else if(e&&w)a.point(n,t);else{var r={a:{x:b,y:_},b:{x:n,y:t}};N(r)?(w||(a.lineStart(),a.point(r.a.x,r.a.y)),a.point(r.b.x,r.b.y),e||a.lineEnd(),k=!1):e&&(a.lineStart(),a.point(n,t),k=!1)}b=n,_=t,w=e}var v,d,m,y,M,x,b,_,w,S,k,E=a,A=Re(),N=Oe(n,t,e,r),C={point:f,lineStart:h,lineEnd:g,polygonStart:function(){a=A,v=[],d=[],k=!0},polygonEnd:function(){a=E,v=ta.merge(v);var t=c([n,r]),e=k&&t,u=v.length;(e||u)&&(a.polygonStart(),e&&(a.lineStart(),l(null,null,1,a),a.lineEnd()),u&&Ce(v,i,t,l,a),a.polygonEnd()),v=d=m=null}};return C}}function Ye(n){var t=0,e=qa/3,r=ir(n),u=r(t,e);return u.parallels=function(n){return arguments.length?r(t=n[0]*qa/180,e=n[1]*qa/180):[t/qa*180,e/qa*180]},u}function Ze(n,t){function e(n,t){var e=Math.sqrt(i-2*u*Math.sin(t))/u;return[e*Math.sin(n*=u),o-e*Math.cos(n)]}var r=Math.sin(n),u=(r+Math.sin(t))/2,i=1+r*(2*u-r),o=Math.sqrt(i)/u;return e.invert=function(n,t){var e=o-t;return[Math.atan2(n,e)/u,tt((i-(n*n+e*e)*u*u)/(2*u))]},e}function Ve(){function n(n,t){Dc+=u*n-r*t,r=n,u=t}var t,e,r,u;Hc.point=function(i,o){Hc.point=n,t=r=i,e=u=o},Hc.lineEnd=function(){n(t,e)}}function Xe(n,t){Pc>n&&(Pc=n),n>jc&&(jc=n),Uc>t&&(Uc=t),t>Fc&&(Fc=t)}function $e(){function n(n,t){o.push("M",n,",",t,i)}function t(n,t){o.push("M",n,",",t),a.point=e}function e(n,t){o.push("L",n,",",t)}function r(){a.point=n}function u(){o.push("Z")}var i=Be(4.5),o=[],a={point:n,lineStart:function(){a.point=t},lineEnd:r,polygonStart:function(){a.lineEnd=u},polygonEnd:function(){a.lineEnd=r,a.point=n},pointRadius:function(n){return i=Be(n),a},result:function(){if(o.length){var n=o.join("");return o=[],n}}};return a}function Be(n){return"m0,"+n+"a"+n+","+n+" 0 1,1 0,"+-2*n+"a"+n+","+n+" 0 1,1 0,"+2*n+"z"}function We(n,t){_c+=n,wc+=t,++Sc}function Je(){function n(n,r){var u=n-t,i=r-e,o=Math.sqrt(u*u+i*i);kc+=o*(t+n)/2,Ec+=o*(e+r)/2,Ac+=o,We(t=n,e=r)}var t,e;Ic.point=function(r,u){Ic.point=n,We(t=r,e=u)}}function Ge(){Ic.point=We}function Ke(){function n(n,t){var e=n-r,i=t-u,o=Math.sqrt(e*e+i*i);kc+=o*(r+n)/2,Ec+=o*(u+t)/2,Ac+=o,o=u*n-r*t,Nc+=o*(r+n),Cc+=o*(u+t),zc+=3*o,We(r=n,u=t)}var t,e,r,u;Ic.point=function(i,o){Ic.point=n,We(t=r=i,e=u=o)},Ic.lineEnd=function(){n(t,e)}}function Qe(n){function t(t,e){n.moveTo(t+o,e),n.arc(t,e,o,0,La)}function e(t,e){n.moveTo(t,e),a.point=r}function r(t,e){n.lineTo(t,e)}function u(){a.point=t}function i(){n.closePath()}var o=4.5,a={point:t,lineStart:function(){a.point=e},lineEnd:u,polygonStart:function(){a.lineEnd=i},polygonEnd:function(){a.lineEnd=u,a.point=t},pointRadius:function(n){return o=n,a},result:b};return a}function nr(n){function t(n){return(a?r:e)(n)}function e(t){return rr(t,function(e,r){e=n(e,r),t.point(e[0],e[1])})}function r(t){function e(e,r){e=n(e,r),t.point(e[0],e[1])}function r(){M=0/0,S.point=i,t.lineStart()}function i(e,r){var i=pe([e,r]),o=n(e,r);u(M,x,y,b,_,w,M=o[0],x=o[1],y=e,b=i[0],_=i[1],w=i[2],a,t),t.point(M,x)}function o(){S.point=e,t.lineEnd()}function c(){r(),S.point=l,S.lineEnd=s}function l(n,t){i(f=n,h=t),g=M,p=x,v=b,d=_,m=w,S.point=i}function s(){u(M,x,y,b,_,w,g,p,f,v,d,m,a,t),S.lineEnd=o,o()}var f,h,g,p,v,d,m,y,M,x,b,_,w,S={point:e,lineStart:r,lineEnd:o,polygonStart:function(){t.polygonStart(),S.lineStart=c
},polygonEnd:function(){t.polygonEnd(),S.lineStart=r}};return S}function u(t,e,r,a,c,l,s,f,h,g,p,v,d,m){var y=s-t,M=f-e,x=y*y+M*M;if(x>4*i&&d--){var b=a+g,_=c+p,w=l+v,S=Math.sqrt(b*b+_*_+w*w),k=Math.asin(w/=S),E=ga(ga(w)-1)<Ca||ga(r-h)<Ca?(r+h)/2:Math.atan2(_,b),A=n(E,k),N=A[0],C=A[1],z=N-t,q=C-e,L=M*z-y*q;(L*L/x>i||ga((y*z+M*q)/x-.5)>.3||o>a*g+c*p+l*v)&&(u(t,e,r,a,c,l,N,C,E,b/=S,_/=S,w,d,m),m.point(N,C),u(N,C,E,b,_,w,s,f,h,g,p,v,d,m))}}var i=.5,o=Math.cos(30*Da),a=16;return t.precision=function(n){return arguments.length?(a=(i=n*n)>0&&16,t):Math.sqrt(i)},t}function tr(n){var t=nr(function(t,e){return n([t*Pa,e*Pa])});return function(n){return or(t(n))}}function er(n){this.stream=n}function rr(n,t){return{point:t,sphere:function(){n.sphere()},lineStart:function(){n.lineStart()},lineEnd:function(){n.lineEnd()},polygonStart:function(){n.polygonStart()},polygonEnd:function(){n.polygonEnd()}}}function ur(n){return ir(function(){return n})()}function ir(n){function t(n){return n=a(n[0]*Da,n[1]*Da),[n[0]*h+c,l-n[1]*h]}function e(n){return n=a.invert((n[0]-c)/h,(l-n[1])/h),n&&[n[0]*Pa,n[1]*Pa]}function r(){a=Ae(o=lr(m,M,x),i);var n=i(v,d);return c=g-n[0]*h,l=p+n[1]*h,u()}function u(){return s&&(s.valid=!1,s=null),t}var i,o,a,c,l,s,f=nr(function(n,t){return n=i(n,t),[n[0]*h+c,l-n[1]*h]}),h=150,g=480,p=250,v=0,d=0,m=0,M=0,x=0,b=Lc,_=y,w=null,S=null;return t.stream=function(n){return s&&(s.valid=!1),s=or(b(o,f(_(n)))),s.valid=!0,s},t.clipAngle=function(n){return arguments.length?(b=null==n?(w=n,Lc):He((w=+n)*Da),u()):w},t.clipExtent=function(n){return arguments.length?(S=n,_=n?Ie(n[0][0],n[0][1],n[1][0],n[1][1]):y,u()):S},t.scale=function(n){return arguments.length?(h=+n,r()):h},t.translate=function(n){return arguments.length?(g=+n[0],p=+n[1],r()):[g,p]},t.center=function(n){return arguments.length?(v=n[0]%360*Da,d=n[1]%360*Da,r()):[v*Pa,d*Pa]},t.rotate=function(n){return arguments.length?(m=n[0]%360*Da,M=n[1]%360*Da,x=n.length>2?n[2]%360*Da:0,r()):[m*Pa,M*Pa,x*Pa]},ta.rebind(t,f,"precision"),function(){return i=n.apply(this,arguments),t.invert=i.invert&&e,r()}}function or(n){return rr(n,function(t,e){n.point(t*Da,e*Da)})}function ar(n,t){return[n,t]}function cr(n,t){return[n>qa?n-La:-qa>n?n+La:n,t]}function lr(n,t,e){return n?t||e?Ae(fr(n),hr(t,e)):fr(n):t||e?hr(t,e):cr}function sr(n){return function(t,e){return t+=n,[t>qa?t-La:-qa>t?t+La:t,e]}}function fr(n){var t=sr(n);return t.invert=sr(-n),t}function hr(n,t){function e(n,t){var e=Math.cos(t),a=Math.cos(n)*e,c=Math.sin(n)*e,l=Math.sin(t),s=l*r+a*u;return[Math.atan2(c*i-s*o,a*r-l*u),tt(s*i+c*o)]}var r=Math.cos(n),u=Math.sin(n),i=Math.cos(t),o=Math.sin(t);return e.invert=function(n,t){var e=Math.cos(t),a=Math.cos(n)*e,c=Math.sin(n)*e,l=Math.sin(t),s=l*i-c*o;return[Math.atan2(c*i+l*o,a*r+s*u),tt(s*r-a*u)]},e}function gr(n,t){var e=Math.cos(n),r=Math.sin(n);return function(u,i,o,a){var c=o*t;null!=u?(u=pr(e,u),i=pr(e,i),(o>0?i>u:u>i)&&(u+=o*La)):(u=n+o*La,i=n-.5*c);for(var l,s=u;o>0?s>i:i>s;s-=c)a.point((l=xe([e,-r*Math.cos(s),-r*Math.sin(s)]))[0],l[1])}}function pr(n,t){var e=pe(t);e[0]-=n,Me(e);var r=nt(-e[1]);return((-e[2]<0?-r:r)+2*Math.PI-Ca)%(2*Math.PI)}function vr(n,t,e){var r=ta.range(n,t-Ca,e).concat(t);return function(n){return r.map(function(t){return[n,t]})}}function dr(n,t,e){var r=ta.range(n,t-Ca,e).concat(t);return function(n){return r.map(function(t){return[t,n]})}}function mr(n){return n.source}function yr(n){return n.target}function Mr(n,t,e,r){var u=Math.cos(t),i=Math.sin(t),o=Math.cos(r),a=Math.sin(r),c=u*Math.cos(n),l=u*Math.sin(n),s=o*Math.cos(e),f=o*Math.sin(e),h=2*Math.asin(Math.sqrt(it(r-t)+u*o*it(e-n))),g=1/Math.sin(h),p=h?function(n){var t=Math.sin(n*=h)*g,e=Math.sin(h-n)*g,r=e*c+t*s,u=e*l+t*f,o=e*i+t*a;return[Math.atan2(u,r)*Pa,Math.atan2(o,Math.sqrt(r*r+u*u))*Pa]}:function(){return[n*Pa,t*Pa]};return p.distance=h,p}function xr(){function n(n,u){var i=Math.sin(u*=Da),o=Math.cos(u),a=ga((n*=Da)-t),c=Math.cos(a);Yc+=Math.atan2(Math.sqrt((a=o*Math.sin(a))*a+(a=r*i-e*o*c)*a),e*i+r*o*c),t=n,e=i,r=o}var t,e,r;Zc.point=function(u,i){t=u*Da,e=Math.sin(i*=Da),r=Math.cos(i),Zc.point=n},Zc.lineEnd=function(){Zc.point=Zc.lineEnd=b}}function br(n,t){function e(t,e){var r=Math.cos(t),u=Math.cos(e),i=n(r*u);return[i*u*Math.sin(t),i*Math.sin(e)]}return e.invert=function(n,e){var r=Math.sqrt(n*n+e*e),u=t(r),i=Math.sin(u),o=Math.cos(u);return[Math.atan2(n*i,r*o),Math.asin(r&&e*i/r)]},e}function _r(n,t){function e(n,t){o>0?-Ra+Ca>t&&(t=-Ra+Ca):t>Ra-Ca&&(t=Ra-Ca);var e=o/Math.pow(u(t),i);return[e*Math.sin(i*n),o-e*Math.cos(i*n)]}var r=Math.cos(n),u=function(n){return Math.tan(qa/4+n/2)},i=n===t?Math.sin(n):Math.log(r/Math.cos(t))/Math.log(u(t)/u(n)),o=r*Math.pow(u(n),i)/i;return i?(e.invert=function(n,t){var e=o-t,r=K(i)*Math.sqrt(n*n+e*e);return[Math.atan2(n,e)/i,2*Math.atan(Math.pow(o/r,1/i))-Ra]},e):Sr}function wr(n,t){function e(n,t){var e=i-t;return[e*Math.sin(u*n),i-e*Math.cos(u*n)]}var r=Math.cos(n),u=n===t?Math.sin(n):(r-Math.cos(t))/(t-n),i=r/u+n;return ga(u)<Ca?ar:(e.invert=function(n,t){var e=i-t;return[Math.atan2(n,e)/u,i-K(u)*Math.sqrt(n*n+e*e)]},e)}function Sr(n,t){return[n,Math.log(Math.tan(qa/4+t/2))]}function kr(n){var t,e=ur(n),r=e.scale,u=e.translate,i=e.clipExtent;return e.scale=function(){var n=r.apply(e,arguments);return n===e?t?e.clipExtent(null):e:n},e.translate=function(){var n=u.apply(e,arguments);return n===e?t?e.clipExtent(null):e:n},e.clipExtent=function(n){var o=i.apply(e,arguments);if(o===e){if(t=null==n){var a=qa*r(),c=u();i([[c[0]-a,c[1]-a],[c[0]+a,c[1]+a]])}}else t&&(o=null);return o},e.clipExtent(null)}function Er(n,t){return[Math.log(Math.tan(qa/4+t/2)),-n]}function Ar(n){return n[0]}function Nr(n){return n[1]}function Cr(n){for(var t=n.length,e=[0,1],r=2,u=2;t>u;u++){for(;r>1&&Q(n[e[r-2]],n[e[r-1]],n[u])<=0;)--r;e[r++]=u}return e.slice(0,r)}function zr(n,t){return n[0]-t[0]||n[1]-t[1]}function qr(n,t,e){return(e[0]-t[0])*(n[1]-t[1])<(e[1]-t[1])*(n[0]-t[0])}function Lr(n,t,e,r){var u=n[0],i=e[0],o=t[0]-u,a=r[0]-i,c=n[1],l=e[1],s=t[1]-c,f=r[1]-l,h=(a*(c-l)-f*(u-i))/(f*o-a*s);return[u+h*o,c+h*s]}function Tr(n){var t=n[0],e=n[n.length-1];return!(t[0]-e[0]||t[1]-e[1])}function Rr(){tu(this),this.edge=this.site=this.circle=null}function Dr(n){var t=el.pop()||new Rr;return t.site=n,t}function Pr(n){Xr(n),Qc.remove(n),el.push(n),tu(n)}function Ur(n){var t=n.circle,e=t.x,r=t.cy,u={x:e,y:r},i=n.P,o=n.N,a=[n];Pr(n);for(var c=i;c.circle&&ga(e-c.circle.x)<Ca&&ga(r-c.circle.cy)<Ca;)i=c.P,a.unshift(c),Pr(c),c=i;a.unshift(c),Xr(c);for(var l=o;l.circle&&ga(e-l.circle.x)<Ca&&ga(r-l.circle.cy)<Ca;)o=l.N,a.push(l),Pr(l),l=o;a.push(l),Xr(l);var s,f=a.length;for(s=1;f>s;++s)l=a[s],c=a[s-1],Kr(l.edge,c.site,l.site,u);c=a[0],l=a[f-1],l.edge=Jr(c.site,l.site,null,u),Vr(c),Vr(l)}function jr(n){for(var t,e,r,u,i=n.x,o=n.y,a=Qc._;a;)if(r=Fr(a,o)-i,r>Ca)a=a.L;else{if(u=i-Hr(a,o),!(u>Ca)){r>-Ca?(t=a.P,e=a):u>-Ca?(t=a,e=a.N):t=e=a;break}if(!a.R){t=a;break}a=a.R}var c=Dr(n);if(Qc.insert(t,c),t||e){if(t===e)return Xr(t),e=Dr(t.site),Qc.insert(c,e),c.edge=e.edge=Jr(t.site,c.site),Vr(t),void Vr(e);if(!e)return void(c.edge=Jr(t.site,c.site));Xr(t),Xr(e);var l=t.site,s=l.x,f=l.y,h=n.x-s,g=n.y-f,p=e.site,v=p.x-s,d=p.y-f,m=2*(h*d-g*v),y=h*h+g*g,M=v*v+d*d,x={x:(d*y-g*M)/m+s,y:(h*M-v*y)/m+f};Kr(e.edge,l,p,x),c.edge=Jr(l,n,null,x),e.edge=Jr(n,p,null,x),Vr(t),Vr(e)}}function Fr(n,t){var e=n.site,r=e.x,u=e.y,i=u-t;if(!i)return r;var o=n.P;if(!o)return-1/0;e=o.site;var a=e.x,c=e.y,l=c-t;if(!l)return a;var s=a-r,f=1/i-1/l,h=s/l;return f?(-h+Math.sqrt(h*h-2*f*(s*s/(-2*l)-c+l/2+u-i/2)))/f+r:(r+a)/2}function Hr(n,t){var e=n.N;if(e)return Fr(e,t);var r=n.site;return r.y===t?r.x:1/0}function Or(n){this.site=n,this.edges=[]}function Ir(n){for(var t,e,r,u,i,o,a,c,l,s,f=n[0][0],h=n[1][0],g=n[0][1],p=n[1][1],v=Kc,d=v.length;d--;)if(i=v[d],i&&i.prepare())for(a=i.edges,c=a.length,o=0;c>o;)s=a[o].end(),r=s.x,u=s.y,l=a[++o%c].start(),t=l.x,e=l.y,(ga(r-t)>Ca||ga(u-e)>Ca)&&(a.splice(o,0,new Qr(Gr(i.site,s,ga(r-f)<Ca&&p-u>Ca?{x:f,y:ga(t-f)<Ca?e:p}:ga(u-p)<Ca&&h-r>Ca?{x:ga(e-p)<Ca?t:h,y:p}:ga(r-h)<Ca&&u-g>Ca?{x:h,y:ga(t-h)<Ca?e:g}:ga(u-g)<Ca&&r-f>Ca?{x:ga(e-g)<Ca?t:f,y:g}:null),i.site,null)),++c)}function Yr(n,t){return t.angle-n.angle}function Zr(){tu(this),this.x=this.y=this.arc=this.site=this.cy=null}function Vr(n){var t=n.P,e=n.N;if(t&&e){var r=t.site,u=n.site,i=e.site;if(r!==i){var o=u.x,a=u.y,c=r.x-o,l=r.y-a,s=i.x-o,f=i.y-a,h=2*(c*f-l*s);if(!(h>=-za)){var g=c*c+l*l,p=s*s+f*f,v=(f*g-l*p)/h,d=(c*p-s*g)/h,f=d+a,m=rl.pop()||new Zr;m.arc=n,m.site=u,m.x=v+o,m.y=f+Math.sqrt(v*v+d*d),m.cy=f,n.circle=m;for(var y=null,M=tl._;M;)if(m.y<M.y||m.y===M.y&&m.x<=M.x){if(!M.L){y=M.P;break}M=M.L}else{if(!M.R){y=M;break}M=M.R}tl.insert(y,m),y||(nl=m)}}}}function Xr(n){var t=n.circle;t&&(t.P||(nl=t.N),tl.remove(t),rl.push(t),tu(t),n.circle=null)}function $r(n){for(var t,e=Gc,r=Oe(n[0][0],n[0][1],n[1][0],n[1][1]),u=e.length;u--;)t=e[u],(!Br(t,n)||!r(t)||ga(t.a.x-t.b.x)<Ca&&ga(t.a.y-t.b.y)<Ca)&&(t.a=t.b=null,e.splice(u,1))}function Br(n,t){var e=n.b;if(e)return!0;var r,u,i=n.a,o=t[0][0],a=t[1][0],c=t[0][1],l=t[1][1],s=n.l,f=n.r,h=s.x,g=s.y,p=f.x,v=f.y,d=(h+p)/2,m=(g+v)/2;if(v===g){if(o>d||d>=a)return;if(h>p){if(i){if(i.y>=l)return}else i={x:d,y:c};e={x:d,y:l}}else{if(i){if(i.y<c)return}else i={x:d,y:l};e={x:d,y:c}}}else if(r=(h-p)/(v-g),u=m-r*d,-1>r||r>1)if(h>p){if(i){if(i.y>=l)return}else i={x:(c-u)/r,y:c};e={x:(l-u)/r,y:l}}else{if(i){if(i.y<c)return}else i={x:(l-u)/r,y:l};e={x:(c-u)/r,y:c}}else if(v>g){if(i){if(i.x>=a)return}else i={x:o,y:r*o+u};e={x:a,y:r*a+u}}else{if(i){if(i.x<o)return}else i={x:a,y:r*a+u};e={x:o,y:r*o+u}}return n.a=i,n.b=e,!0}function Wr(n,t){this.l=n,this.r=t,this.a=this.b=null}function Jr(n,t,e,r){var u=new Wr(n,t);return Gc.push(u),e&&Kr(u,n,t,e),r&&Kr(u,t,n,r),Kc[n.i].edges.push(new Qr(u,n,t)),Kc[t.i].edges.push(new Qr(u,t,n)),u}function Gr(n,t,e){var r=new Wr(n,null);return r.a=t,r.b=e,Gc.push(r),r}function Kr(n,t,e,r){n.a||n.b?n.l===e?n.b=r:n.a=r:(n.a=r,n.l=t,n.r=e)}function Qr(n,t,e){var r=n.a,u=n.b;this.edge=n,this.site=t,this.angle=e?Math.atan2(e.y-t.y,e.x-t.x):n.l===t?Math.atan2(u.x-r.x,r.y-u.y):Math.atan2(r.x-u.x,u.y-r.y)}function nu(){this._=null}function tu(n){n.U=n.C=n.L=n.R=n.P=n.N=null}function eu(n,t){var e=t,r=t.R,u=e.U;u?u.L===e?u.L=r:u.R=r:n._=r,r.U=u,e.U=r,e.R=r.L,e.R&&(e.R.U=e),r.L=e}function ru(n,t){var e=t,r=t.L,u=e.U;u?u.L===e?u.L=r:u.R=r:n._=r,r.U=u,e.U=r,e.L=r.R,e.L&&(e.L.U=e),r.R=e}function uu(n){for(;n.L;)n=n.L;return n}function iu(n,t){var e,r,u,i=n.sort(ou).pop();for(Gc=[],Kc=new Array(n.length),Qc=new nu,tl=new nu;;)if(u=nl,i&&(!u||i.y<u.y||i.y===u.y&&i.x<u.x))(i.x!==e||i.y!==r)&&(Kc[i.i]=new Or(i),jr(i),e=i.x,r=i.y),i=n.pop();else{if(!u)break;Ur(u.arc)}t&&($r(t),Ir(t));var o={cells:Kc,edges:Gc};return Qc=tl=Gc=Kc=null,o}function ou(n,t){return t.y-n.y||t.x-n.x}function au(n,t,e){return(n.x-e.x)*(t.y-n.y)-(n.x-t.x)*(e.y-n.y)}function cu(n){return n.x}function lu(n){return n.y}function su(){return{leaf:!0,nodes:[],point:null,x:null,y:null}}function fu(n,t,e,r,u,i){if(!n(t,e,r,u,i)){var o=.5*(e+u),a=.5*(r+i),c=t.nodes;c[0]&&fu(n,c[0],e,r,o,a),c[1]&&fu(n,c[1],o,r,u,a),c[2]&&fu(n,c[2],e,a,o,i),c[3]&&fu(n,c[3],o,a,u,i)}}function hu(n,t,e,r,u,i,o){var a,c=1/0;return function l(n,s,f,h,g){if(!(s>i||f>o||r>h||u>g)){if(p=n.point){var p,v=t-n.x,d=e-n.y,m=v*v+d*d;if(c>m){var y=Math.sqrt(c=m);r=t-y,u=e-y,i=t+y,o=e+y,a=p}}for(var M=n.nodes,x=.5*(s+h),b=.5*(f+g),_=t>=x,w=e>=b,S=w<<1|_,k=S+4;k>S;++S)if(n=M[3&S])switch(3&S){case 0:l(n,s,f,x,b);break;case 1:l(n,x,f,h,b);break;case 2:l(n,s,b,x,g);break;case 3:l(n,x,b,h,g)}}}(n,r,u,i,o),a}function gu(n,t){n=ta.rgb(n),t=ta.rgb(t);var e=n.r,r=n.g,u=n.b,i=t.r-e,o=t.g-r,a=t.b-u;return function(n){return"#"+xt(Math.round(e+i*n))+xt(Math.round(r+o*n))+xt(Math.round(u+a*n))}}function pu(n,t){var e,r={},u={};for(e in n)e in t?r[e]=mu(n[e],t[e]):u[e]=n[e];for(e in t)e in n||(u[e]=t[e]);return function(n){for(e in r)u[e]=r[e](n);return u}}function vu(n,t){return n=+n,t=+t,function(e){return n*(1-e)+t*e}}function du(n,t){var e,r,u,i=il.lastIndex=ol.lastIndex=0,o=-1,a=[],c=[];for(n+="",t+="";(e=il.exec(n))&&(r=ol.exec(t));)(u=r.index)>i&&(u=t.slice(i,u),a[o]?a[o]+=u:a[++o]=u),(e=e[0])===(r=r[0])?a[o]?a[o]+=r:a[++o]=r:(a[++o]=null,c.push({i:o,x:vu(e,r)})),i=ol.lastIndex;return i<t.length&&(u=t.slice(i),a[o]?a[o]+=u:a[++o]=u),a.length<2?c[0]?(t=c[0].x,function(n){return t(n)+""}):function(){return t}:(t=c.length,function(n){for(var e,r=0;t>r;++r)a[(e=c[r]).i]=e.x(n);return a.join("")})}function mu(n,t){for(var e,r=ta.interpolators.length;--r>=0&&!(e=ta.interpolators[r](n,t)););return e}function yu(n,t){var e,r=[],u=[],i=n.length,o=t.length,a=Math.min(n.length,t.length);for(e=0;a>e;++e)r.push(mu(n[e],t[e]));for(;i>e;++e)u[e]=n[e];for(;o>e;++e)u[e]=t[e];return function(n){for(e=0;a>e;++e)u[e]=r[e](n);return u}}function Mu(n){return function(t){return 0>=t?0:t>=1?1:n(t)}}function xu(n){return function(t){return 1-n(1-t)}}function bu(n){return function(t){return.5*(.5>t?n(2*t):2-n(2-2*t))}}function _u(n){return n*n}function wu(n){return n*n*n}function Su(n){if(0>=n)return 0;if(n>=1)return 1;var t=n*n,e=t*n;return 4*(.5>n?e:3*(n-t)+e-.75)}function ku(n){return function(t){return Math.pow(t,n)}}function Eu(n){return 1-Math.cos(n*Ra)}function Au(n){return Math.pow(2,10*(n-1))}function Nu(n){return 1-Math.sqrt(1-n*n)}function Cu(n,t){var e;return arguments.length<2&&(t=.45),arguments.length?e=t/La*Math.asin(1/n):(n=1,e=t/4),function(r){return 1+n*Math.pow(2,-10*r)*Math.sin((r-e)*La/t)}}function zu(n){return n||(n=1.70158),function(t){return t*t*((n+1)*t-n)}}function qu(n){return 1/2.75>n?7.5625*n*n:2/2.75>n?7.5625*(n-=1.5/2.75)*n+.75:2.5/2.75>n?7.5625*(n-=2.25/2.75)*n+.9375:7.5625*(n-=2.625/2.75)*n+.984375}function Lu(n,t){n=ta.hcl(n),t=ta.hcl(t);var e=n.h,r=n.c,u=n.l,i=t.h-e,o=t.c-r,a=t.l-u;return isNaN(o)&&(o=0,r=isNaN(r)?t.c:r),isNaN(i)?(i=0,e=isNaN(e)?t.h:e):i>180?i-=360:-180>i&&(i+=360),function(n){return st(e+i*n,r+o*n,u+a*n)+""}}function Tu(n,t){n=ta.hsl(n),t=ta.hsl(t);var e=n.h,r=n.s,u=n.l,i=t.h-e,o=t.s-r,a=t.l-u;return isNaN(o)&&(o=0,r=isNaN(r)?t.s:r),isNaN(i)?(i=0,e=isNaN(e)?t.h:e):i>180?i-=360:-180>i&&(i+=360),function(n){return ct(e+i*n,r+o*n,u+a*n)+""}}function Ru(n,t){n=ta.lab(n),t=ta.lab(t);var e=n.l,r=n.a,u=n.b,i=t.l-e,o=t.a-r,a=t.b-u;return function(n){return ht(e+i*n,r+o*n,u+a*n)+""}}function Du(n,t){return t-=n,function(e){return Math.round(n+t*e)}}function Pu(n){var t=[n.a,n.b],e=[n.c,n.d],r=ju(t),u=Uu(t,e),i=ju(Fu(e,t,-u))||0;t[0]*e[1]<e[0]*t[1]&&(t[0]*=-1,t[1]*=-1,r*=-1,u*=-1),this.rotate=(r?Math.atan2(t[1],t[0]):Math.atan2(-e[0],e[1]))*Pa,this.translate=[n.e,n.f],this.scale=[r,i],this.skew=i?Math.atan2(u,i)*Pa:0}function Uu(n,t){return n[0]*t[0]+n[1]*t[1]}function ju(n){var t=Math.sqrt(Uu(n,n));return t&&(n[0]/=t,n[1]/=t),t}function Fu(n,t,e){return n[0]+=e*t[0],n[1]+=e*t[1],n}function Hu(n,t){var e,r=[],u=[],i=ta.transform(n),o=ta.transform(t),a=i.translate,c=o.translate,l=i.rotate,s=o.rotate,f=i.skew,h=o.skew,g=i.scale,p=o.scale;return a[0]!=c[0]||a[1]!=c[1]?(r.push("translate(",null,",",null,")"),u.push({i:1,x:vu(a[0],c[0])},{i:3,x:vu(a[1],c[1])})):r.push(c[0]||c[1]?"translate("+c+")":""),l!=s?(l-s>180?s+=360:s-l>180&&(l+=360),u.push({i:r.push(r.pop()+"rotate(",null,")")-2,x:vu(l,s)})):s&&r.push(r.pop()+"rotate("+s+")"),f!=h?u.push({i:r.push(r.pop()+"skewX(",null,")")-2,x:vu(f,h)}):h&&r.push(r.pop()+"skewX("+h+")"),g[0]!=p[0]||g[1]!=p[1]?(e=r.push(r.pop()+"scale(",null,",",null,")"),u.push({i:e-4,x:vu(g[0],p[0])},{i:e-2,x:vu(g[1],p[1])})):(1!=p[0]||1!=p[1])&&r.push(r.pop()+"scale("+p+")"),e=u.length,function(n){for(var t,i=-1;++i<e;)r[(t=u[i]).i]=t.x(n);return r.join("")}}function Ou(n,t){return t=(t-=n=+n)||1/t,function(e){return(e-n)/t}}function Iu(n,t){return t=(t-=n=+n)||1/t,function(e){return Math.max(0,Math.min(1,(e-n)/t))}}function Yu(n){for(var t=n.source,e=n.target,r=Vu(t,e),u=[t];t!==r;)t=t.parent,u.push(t);for(var i=u.length;e!==r;)u.splice(i,0,e),e=e.parent;return u}function Zu(n){for(var t=[],e=n.parent;null!=e;)t.push(n),n=e,e=e.parent;return t.push(n),t}function Vu(n,t){if(n===t)return n;for(var e=Zu(n),r=Zu(t),u=e.pop(),i=r.pop(),o=null;u===i;)o=u,u=e.pop(),i=r.pop();return o}function Xu(n){n.fixed|=2}function $u(n){n.fixed&=-7}function Bu(n){n.fixed|=4,n.px=n.x,n.py=n.y}function Wu(n){n.fixed&=-5}function Ju(n,t,e){var r=0,u=0;if(n.charge=0,!n.leaf)for(var i,o=n.nodes,a=o.length,c=-1;++c<a;)i=o[c],null!=i&&(Ju(i,t,e),n.charge+=i.charge,r+=i.charge*i.cx,u+=i.charge*i.cy);if(n.point){n.leaf||(n.point.x+=Math.random()-.5,n.point.y+=Math.random()-.5);var l=t*e[n.point.index];n.charge+=n.pointCharge=l,r+=l*n.point.x,u+=l*n.point.y}n.cx=r/n.charge,n.cy=u/n.charge}function Gu(n,t){return ta.rebind(n,t,"sort","children","value"),n.nodes=n,n.links=ri,n}function Ku(n,t){for(var e=[n];null!=(n=e.pop());)if(t(n),(u=n.children)&&(r=u.length))for(var r,u;--r>=0;)e.push(u[r])}function Qu(n,t){for(var e=[n],r=[];null!=(n=e.pop());)if(r.push(n),(i=n.children)&&(u=i.length))for(var u,i,o=-1;++o<u;)e.push(i[o]);for(;null!=(n=r.pop());)t(n)}function ni(n){return n.children}function ti(n){return n.value}function ei(n,t){return t.value-n.value}function ri(n){return ta.merge(n.map(function(n){return(n.children||[]).map(function(t){return{source:n,target:t}})}))}function ui(n){return n.x}function ii(n){return n.y}function oi(n,t,e){n.y0=t,n.y=e}function ai(n){return ta.range(n.length)}function ci(n){for(var t=-1,e=n[0].length,r=[];++t<e;)r[t]=0;return r}function li(n){for(var t,e=1,r=0,u=n[0][1],i=n.length;i>e;++e)(t=n[e][1])>u&&(r=e,u=t);return r}function si(n){return n.reduce(fi,0)}function fi(n,t){return n+t[1]}function hi(n,t){return gi(n,Math.ceil(Math.log(t.length)/Math.LN2+1))}function gi(n,t){for(var e=-1,r=+n[0],u=(n[1]-r)/t,i=[];++e<=t;)i[e]=u*e+r;return i}function pi(n){return[ta.min(n),ta.max(n)]}function vi(n,t){return n.value-t.value}function di(n,t){var e=n._pack_next;n._pack_next=t,t._pack_prev=n,t._pack_next=e,e._pack_prev=t}function mi(n,t){n._pack_next=t,t._pack_prev=n}function yi(n,t){var e=t.x-n.x,r=t.y-n.y,u=n.r+t.r;return.999*u*u>e*e+r*r}function Mi(n){function t(n){s=Math.min(n.x-n.r,s),f=Math.max(n.x+n.r,f),h=Math.min(n.y-n.r,h),g=Math.max(n.y+n.r,g)}if((e=n.children)&&(l=e.length)){var e,r,u,i,o,a,c,l,s=1/0,f=-1/0,h=1/0,g=-1/0;if(e.forEach(xi),r=e[0],r.x=-r.r,r.y=0,t(r),l>1&&(u=e[1],u.x=u.r,u.y=0,t(u),l>2))for(i=e[2],wi(r,u,i),t(i),di(r,i),r._pack_prev=i,di(i,u),u=r._pack_next,o=3;l>o;o++){wi(r,u,i=e[o]);var p=0,v=1,d=1;for(a=u._pack_next;a!==u;a=a._pack_next,v++)if(yi(a,i)){p=1;break}if(1==p)for(c=r._pack_prev;c!==a._pack_prev&&!yi(c,i);c=c._pack_prev,d++);p?(d>v||v==d&&u.r<r.r?mi(r,u=a):mi(r=c,u),o--):(di(r,i),u=i,t(i))}var m=(s+f)/2,y=(h+g)/2,M=0;for(o=0;l>o;o++)i=e[o],i.x-=m,i.y-=y,M=Math.max(M,i.r+Math.sqrt(i.x*i.x+i.y*i.y));n.r=M,e.forEach(bi)}}function xi(n){n._pack_next=n._pack_prev=n}function bi(n){delete n._pack_next,delete n._pack_prev}function _i(n,t,e,r){var u=n.children;if(n.x=t+=r*n.x,n.y=e+=r*n.y,n.r*=r,u)for(var i=-1,o=u.length;++i<o;)_i(u[i],t,e,r)}function wi(n,t,e){var r=n.r+e.r,u=t.x-n.x,i=t.y-n.y;if(r&&(u||i)){var o=t.r+e.r,a=u*u+i*i;o*=o,r*=r;var c=.5+(r-o)/(2*a),l=Math.sqrt(Math.max(0,2*o*(r+a)-(r-=a)*r-o*o))/(2*a);e.x=n.x+c*u+l*i,e.y=n.y+c*i-l*u}else e.x=n.x+r,e.y=n.y}function Si(n,t){return n.parent==t.parent?1:2}function ki(n){var t=n.children;return t.length?t[0]:n.t}function Ei(n){var t,e=n.children;return(t=e.length)?e[t-1]:n.t}function Ai(n,t,e){var r=e/(t.i-n.i);t.c-=r,t.s+=e,n.c+=r,t.z+=e,t.m+=e}function Ni(n){for(var t,e=0,r=0,u=n.children,i=u.length;--i>=0;)t=u[i],t.z+=e,t.m+=e,e+=t.s+(r+=t.c)}function Ci(n,t,e){return n.a.parent===t.parent?n.a:e}function zi(n){return 1+ta.max(n,function(n){return n.y})}function qi(n){return n.reduce(function(n,t){return n+t.x},0)/n.length}function Li(n){var t=n.children;return t&&t.length?Li(t[0]):n}function Ti(n){var t,e=n.children;return e&&(t=e.length)?Ti(e[t-1]):n}function Ri(n){return{x:n.x,y:n.y,dx:n.dx,dy:n.dy}}function Di(n,t){var e=n.x+t[3],r=n.y+t[0],u=n.dx-t[1]-t[3],i=n.dy-t[0]-t[2];return 0>u&&(e+=u/2,u=0),0>i&&(r+=i/2,i=0),{x:e,y:r,dx:u,dy:i}}function Pi(n){var t=n[0],e=n[n.length-1];return e>t?[t,e]:[e,t]}function Ui(n){return n.rangeExtent?n.rangeExtent():Pi(n.range())}function ji(n,t,e,r){var u=e(n[0],n[1]),i=r(t[0],t[1]);return function(n){return i(u(n))}}function Fi(n,t){var e,r=0,u=n.length-1,i=n[r],o=n[u];return i>o&&(e=r,r=u,u=e,e=i,i=o,o=e),n[r]=t.floor(i),n[u]=t.ceil(o),n}function Hi(n){return n?{floor:function(t){return Math.floor(t/n)*n},ceil:function(t){return Math.ceil(t/n)*n}}:ml}function Oi(n,t,e,r){var u=[],i=[],o=0,a=Math.min(n.length,t.length)-1;for(n[a]<n[0]&&(n=n.slice().reverse(),t=t.slice().reverse());++o<=a;)u.push(e(n[o-1],n[o])),i.push(r(t[o-1],t[o]));return function(t){var e=ta.bisect(n,t,1,a)-1;return i[e](u[e](t))}}function Ii(n,t,e,r){function u(){var u=Math.min(n.length,t.length)>2?Oi:ji,c=r?Iu:Ou;return o=u(n,t,c,e),a=u(t,n,c,mu),i}function i(n){return o(n)}var o,a;return i.invert=function(n){return a(n)},i.domain=function(t){return arguments.length?(n=t.map(Number),u()):n},i.range=function(n){return arguments.length?(t=n,u()):t},i.rangeRound=function(n){return i.range(n).interpolate(Du)},i.clamp=function(n){return arguments.length?(r=n,u()):r},i.interpolate=function(n){return arguments.length?(e=n,u()):e},i.ticks=function(t){return Xi(n,t)},i.tickFormat=function(t,e){return $i(n,t,e)},i.nice=function(t){return Zi(n,t),u()},i.copy=function(){return Ii(n,t,e,r)},u()}function Yi(n,t){return ta.rebind(n,t,"range","rangeRound","interpolate","clamp")}function Zi(n,t){return Fi(n,Hi(Vi(n,t)[2]))}function Vi(n,t){null==t&&(t=10);var e=Pi(n),r=e[1]-e[0],u=Math.pow(10,Math.floor(Math.log(r/t)/Math.LN10)),i=t/r*u;return.15>=i?u*=10:.35>=i?u*=5:.75>=i&&(u*=2),e[0]=Math.ceil(e[0]/u)*u,e[1]=Math.floor(e[1]/u)*u+.5*u,e[2]=u,e}function Xi(n,t){return ta.range.apply(ta,Vi(n,t))}function $i(n,t,e){var r=Vi(n,t);if(e){var u=ic.exec(e);if(u.shift(),"s"===u[8]){var i=ta.formatPrefix(Math.max(ga(r[0]),ga(r[1])));return u[7]||(u[7]="."+Bi(i.scale(r[2]))),u[8]="f",e=ta.format(u.join("")),function(n){return e(i.scale(n))+i.symbol}}u[7]||(u[7]="."+Wi(u[8],r)),e=u.join("")}else e=",."+Bi(r[2])+"f";return ta.format(e)}function Bi(n){return-Math.floor(Math.log(n)/Math.LN10+.01)}function Wi(n,t){var e=Bi(t[2]);return n in yl?Math.abs(e-Bi(Math.max(ga(t[0]),ga(t[1]))))+ +("e"!==n):e-2*("%"===n)}function Ji(n,t,e,r){function u(n){return(e?Math.log(0>n?0:n):-Math.log(n>0?0:-n))/Math.log(t)}function i(n){return e?Math.pow(t,n):-Math.pow(t,-n)}function o(t){return n(u(t))}return o.invert=function(t){return i(n.invert(t))},o.domain=function(t){return arguments.length?(e=t[0]>=0,n.domain((r=t.map(Number)).map(u)),o):r},o.base=function(e){return arguments.length?(t=+e,n.domain(r.map(u)),o):t},o.nice=function(){var t=Fi(r.map(u),e?Math:xl);return n.domain(t),r=t.map(i),o},o.ticks=function(){var n=Pi(r),o=[],a=n[0],c=n[1],l=Math.floor(u(a)),s=Math.ceil(u(c)),f=t%1?2:t;if(isFinite(s-l)){if(e){for(;s>l;l++)for(var h=1;f>h;h++)o.push(i(l)*h);o.push(i(l))}else for(o.push(i(l));l++<s;)for(var h=f-1;h>0;h--)o.push(i(l)*h);for(l=0;o[l]<a;l++);for(s=o.length;o[s-1]>c;s--);o=o.slice(l,s)}return o},o.tickFormat=function(n,t){if(!arguments.length)return Ml;arguments.length<2?t=Ml:"function"!=typeof t&&(t=ta.format(t));var r,a=Math.max(.1,n/o.ticks().length),c=e?(r=1e-12,Math.ceil):(r=-1e-12,Math.floor);return function(n){return n/i(c(u(n)+r))<=a?t(n):""}},o.copy=function(){return Ji(n.copy(),t,e,r)},Yi(o,n)}function Gi(n,t,e){function r(t){return n(u(t))}var u=Ki(t),i=Ki(1/t);return r.invert=function(t){return i(n.invert(t))},r.domain=function(t){return arguments.length?(n.domain((e=t.map(Number)).map(u)),r):e},r.ticks=function(n){return Xi(e,n)},r.tickFormat=function(n,t){return $i(e,n,t)},r.nice=function(n){return r.domain(Zi(e,n))},r.exponent=function(o){return arguments.length?(u=Ki(t=o),i=Ki(1/t),n.domain(e.map(u)),r):t},r.copy=function(){return Gi(n.copy(),t,e)},Yi(r,n)}function Ki(n){return function(t){return 0>t?-Math.pow(-t,n):Math.pow(t,n)}}function Qi(n,t){function e(e){return i[((u.get(e)||("range"===t.t?u.set(e,n.push(e)):0/0))-1)%i.length]}function r(t,e){return ta.range(n.length).map(function(n){return t+e*n})}var u,i,o;return e.domain=function(r){if(!arguments.length)return n;n=[],u=new l;for(var i,o=-1,a=r.length;++o<a;)u.has(i=r[o])||u.set(i,n.push(i));return e[t.t].apply(e,t.a)},e.range=function(n){return arguments.length?(i=n,o=0,t={t:"range",a:arguments},e):i},e.rangePoints=function(u,a){arguments.length<2&&(a=0);var c=u[0],l=u[1],s=n.length<2?(c=(c+l)/2,0):(l-c)/(n.length-1+a);return i=r(c+s*a/2,s),o=0,t={t:"rangePoints",a:arguments},e},e.rangeRoundPoints=function(u,a){arguments.length<2&&(a=0);var c=u[0],l=u[1],s=n.length<2?(c=l=Math.round((c+l)/2),0):(l-c)/(n.length-1+a)|0;return i=r(c+Math.round(s*a/2+(l-c-(n.length-1+a)*s)/2),s),o=0,t={t:"rangeRoundPoints",a:arguments},e},e.rangeBands=function(u,a,c){arguments.length<2&&(a=0),arguments.length<3&&(c=a);var l=u[1]<u[0],s=u[l-0],f=u[1-l],h=(f-s)/(n.length-a+2*c);return i=r(s+h*c,h),l&&i.reverse(),o=h*(1-a),t={t:"rangeBands",a:arguments},e},e.rangeRoundBands=function(u,a,c){arguments.length<2&&(a=0),arguments.length<3&&(c=a);var l=u[1]<u[0],s=u[l-0],f=u[1-l],h=Math.floor((f-s)/(n.length-a+2*c));return i=r(s+Math.round((f-s-(n.length-a)*h)/2),h),l&&i.reverse(),o=Math.round(h*(1-a)),t={t:"rangeRoundBands",a:arguments},e},e.rangeBand=function(){return o},e.rangeExtent=function(){return Pi(t.a[0])},e.copy=function(){return Qi(n,t)},e.domain(n)}function no(n,t){function i(){var e=0,r=t.length;for(a=[];++e<r;)a[e-1]=ta.quantile(n,e/r);return o}function o(n){return isNaN(n=+n)?void 0:t[ta.bisect(a,n)]}var a;return o.domain=function(t){return arguments.length?(n=t.map(r).filter(u).sort(e),i()):n},o.range=function(n){return arguments.length?(t=n,i()):t},o.quantiles=function(){return a},o.invertExtent=function(e){return e=t.indexOf(e),0>e?[0/0,0/0]:[e>0?a[e-1]:n[0],e<a.length?a[e]:n[n.length-1]]},o.copy=function(){return no(n,t)},i()}function to(n,t,e){function r(t){return e[Math.max(0,Math.min(o,Math.floor(i*(t-n))))]}function u(){return i=e.length/(t-n),o=e.length-1,r}var i,o;return r.domain=function(e){return arguments.length?(n=+e[0],t=+e[e.length-1],u()):[n,t]},r.range=function(n){return arguments.length?(e=n,u()):e},r.invertExtent=function(t){return t=e.indexOf(t),t=0>t?0/0:t/i+n,[t,t+1/i]},r.copy=function(){return to(n,t,e)},u()}function eo(n,t){function e(e){return e>=e?t[ta.bisect(n,e)]:void 0}return e.domain=function(t){return arguments.length?(n=t,e):n},e.range=function(n){return arguments.length?(t=n,e):t},e.invertExtent=function(e){return e=t.indexOf(e),[n[e-1],n[e]]},e.copy=function(){return eo(n,t)},e}function ro(n){function t(n){return+n}return t.invert=t,t.domain=t.range=function(e){return arguments.length?(n=e.map(t),t):n},t.ticks=function(t){return Xi(n,t)},t.tickFormat=function(t,e){return $i(n,t,e)},t.copy=function(){return ro(n)},t}function uo(){return 0}function io(n){return n.innerRadius}function oo(n){return n.outerRadius}function ao(n){return n.startAngle}function co(n){return n.endAngle}function lo(n){return n&&n.padAngle}function so(n,t,e,r){return(n-e)*t-(t-r)*n>0?0:1}function fo(n,t,e,r,u){var i=n[0]-t[0],o=n[1]-t[1],a=(u?r:-r)/Math.sqrt(i*i+o*o),c=a*o,l=-a*i,s=n[0]+c,f=n[1]+l,h=t[0]+c,g=t[1]+l,p=(s+h)/2,v=(f+g)/2,d=h-s,m=g-f,y=d*d+m*m,M=e-r,x=s*g-h*f,b=(0>m?-1:1)*Math.sqrt(M*M*y-x*x),_=(x*m-d*b)/y,w=(-x*d-m*b)/y,S=(x*m+d*b)/y,k=(-x*d+m*b)/y,E=_-p,A=w-v,N=S-p,C=k-v;return E*E+A*A>N*N+C*C&&(_=S,w=k),[[_-c,w-l],[_*e/M,w*e/M]]}function ho(n){function t(t){function o(){l.push("M",i(n(s),a))}for(var c,l=[],s=[],f=-1,h=t.length,g=Et(e),p=Et(r);++f<h;)u.call(this,c=t[f],f)?s.push([+g.call(this,c,f),+p.call(this,c,f)]):s.length&&(o(),s=[]);return s.length&&o(),l.length?l.join(""):null}var e=Ar,r=Nr,u=Ne,i=go,o=i.key,a=.7;return t.x=function(n){return arguments.length?(e=n,t):e},t.y=function(n){return arguments.length?(r=n,t):r},t.defined=function(n){return arguments.length?(u=n,t):u},t.interpolate=function(n){return arguments.length?(o="function"==typeof n?i=n:(i=El.get(n)||go).key,t):o},t.tension=function(n){return arguments.length?(a=n,t):a},t}function go(n){return n.join("L")}function po(n){return go(n)+"Z"}function vo(n){for(var t=0,e=n.length,r=n[0],u=[r[0],",",r[1]];++t<e;)u.push("H",(r[0]+(r=n[t])[0])/2,"V",r[1]);return e>1&&u.push("H",r[0]),u.join("")}function mo(n){for(var t=0,e=n.length,r=n[0],u=[r[0],",",r[1]];++t<e;)u.push("V",(r=n[t])[1],"H",r[0]);return u.join("")}function yo(n){for(var t=0,e=n.length,r=n[0],u=[r[0],",",r[1]];++t<e;)u.push("H",(r=n[t])[0],"V",r[1]);return u.join("")}function Mo(n,t){return n.length<4?go(n):n[1]+_o(n.slice(1,-1),wo(n,t))}function xo(n,t){return n.length<3?go(n):n[0]+_o((n.push(n[0]),n),wo([n[n.length-2]].concat(n,[n[1]]),t))}function bo(n,t){return n.length<3?go(n):n[0]+_o(n,wo(n,t))}function _o(n,t){if(t.length<1||n.length!=t.length&&n.length!=t.length+2)return go(n);var e=n.length!=t.length,r="",u=n[0],i=n[1],o=t[0],a=o,c=1;if(e&&(r+="Q"+(i[0]-2*o[0]/3)+","+(i[1]-2*o[1]/3)+","+i[0]+","+i[1],u=n[1],c=2),t.length>1){a=t[1],i=n[c],c++,r+="C"+(u[0]+o[0])+","+(u[1]+o[1])+","+(i[0]-a[0])+","+(i[1]-a[1])+","+i[0]+","+i[1];for(var l=2;l<t.length;l++,c++)i=n[c],a=t[l],r+="S"+(i[0]-a[0])+","+(i[1]-a[1])+","+i[0]+","+i[1]}if(e){var s=n[c];r+="Q"+(i[0]+2*a[0]/3)+","+(i[1]+2*a[1]/3)+","+s[0]+","+s[1]}return r}function wo(n,t){for(var e,r=[],u=(1-t)/2,i=n[0],o=n[1],a=1,c=n.length;++a<c;)e=i,i=o,o=n[a],r.push([u*(o[0]-e[0]),u*(o[1]-e[1])]);return r}function So(n){if(n.length<3)return go(n);var t=1,e=n.length,r=n[0],u=r[0],i=r[1],o=[u,u,u,(r=n[1])[0]],a=[i,i,i,r[1]],c=[u,",",i,"L",No(Cl,o),",",No(Cl,a)];for(n.push(n[e-1]);++t<=e;)r=n[t],o.shift(),o.push(r[0]),a.shift(),a.push(r[1]),Co(c,o,a);return n.pop(),c.push("L",r),c.join("")}function ko(n){if(n.length<4)return go(n);for(var t,e=[],r=-1,u=n.length,i=[0],o=[0];++r<3;)t=n[r],i.push(t[0]),o.push(t[1]);for(e.push(No(Cl,i)+","+No(Cl,o)),--r;++r<u;)t=n[r],i.shift(),i.push(t[0]),o.shift(),o.push(t[1]),Co(e,i,o);return e.join("")}function Eo(n){for(var t,e,r=-1,u=n.length,i=u+4,o=[],a=[];++r<4;)e=n[r%u],o.push(e[0]),a.push(e[1]);for(t=[No(Cl,o),",",No(Cl,a)],--r;++r<i;)e=n[r%u],o.shift(),o.push(e[0]),a.shift(),a.push(e[1]),Co(t,o,a);return t.join("")}function Ao(n,t){var e=n.length-1;if(e)for(var r,u,i=n[0][0],o=n[0][1],a=n[e][0]-i,c=n[e][1]-o,l=-1;++l<=e;)r=n[l],u=l/e,r[0]=t*r[0]+(1-t)*(i+u*a),r[1]=t*r[1]+(1-t)*(o+u*c);return So(n)}function No(n,t){return n[0]*t[0]+n[1]*t[1]+n[2]*t[2]+n[3]*t[3]}function Co(n,t,e){n.push("C",No(Al,t),",",No(Al,e),",",No(Nl,t),",",No(Nl,e),",",No(Cl,t),",",No(Cl,e))}function zo(n,t){return(t[1]-n[1])/(t[0]-n[0])}function qo(n){for(var t=0,e=n.length-1,r=[],u=n[0],i=n[1],o=r[0]=zo(u,i);++t<e;)r[t]=(o+(o=zo(u=i,i=n[t+1])))/2;return r[t]=o,r}function Lo(n){for(var t,e,r,u,i=[],o=qo(n),a=-1,c=n.length-1;++a<c;)t=zo(n[a],n[a+1]),ga(t)<Ca?o[a]=o[a+1]=0:(e=o[a]/t,r=o[a+1]/t,u=e*e+r*r,u>9&&(u=3*t/Math.sqrt(u),o[a]=u*e,o[a+1]=u*r));for(a=-1;++a<=c;)u=(n[Math.min(c,a+1)][0]-n[Math.max(0,a-1)][0])/(6*(1+o[a]*o[a])),i.push([u||0,o[a]*u||0]);return i}function To(n){return n.length<3?go(n):n[0]+_o(n,Lo(n))}function Ro(n){for(var t,e,r,u=-1,i=n.length;++u<i;)t=n[u],e=t[0],r=t[1]-Ra,t[0]=e*Math.cos(r),t[1]=e*Math.sin(r);return n}function Do(n){function t(t){function c(){v.push("M",a(n(m),f),s,l(n(d.reverse()),f),"Z")}for(var h,g,p,v=[],d=[],m=[],y=-1,M=t.length,x=Et(e),b=Et(u),_=e===r?function(){return g}:Et(r),w=u===i?function(){return p}:Et(i);++y<M;)o.call(this,h=t[y],y)?(d.push([g=+x.call(this,h,y),p=+b.call(this,h,y)]),m.push([+_.call(this,h,y),+w.call(this,h,y)])):d.length&&(c(),d=[],m=[]);return d.length&&c(),v.length?v.join(""):null}var e=Ar,r=Ar,u=0,i=Nr,o=Ne,a=go,c=a.key,l=a,s="L",f=.7;return t.x=function(n){return arguments.length?(e=r=n,t):r},t.x0=function(n){return arguments.length?(e=n,t):e},t.x1=function(n){return arguments.length?(r=n,t):r
},t.y=function(n){return arguments.length?(u=i=n,t):i},t.y0=function(n){return arguments.length?(u=n,t):u},t.y1=function(n){return arguments.length?(i=n,t):i},t.defined=function(n){return arguments.length?(o=n,t):o},t.interpolate=function(n){return arguments.length?(c="function"==typeof n?a=n:(a=El.get(n)||go).key,l=a.reverse||a,s=a.closed?"M":"L",t):c},t.tension=function(n){return arguments.length?(f=n,t):f},t}function Po(n){return n.radius}function Uo(n){return[n.x,n.y]}function jo(n){return function(){var t=n.apply(this,arguments),e=t[0],r=t[1]-Ra;return[e*Math.cos(r),e*Math.sin(r)]}}function Fo(){return 64}function Ho(){return"circle"}function Oo(n){var t=Math.sqrt(n/qa);return"M0,"+t+"A"+t+","+t+" 0 1,1 0,"+-t+"A"+t+","+t+" 0 1,1 0,"+t+"Z"}function Io(n){return function(){var t,e;(t=this[n])&&(e=t[t.active])&&(--t.count?delete t[t.active]:delete this[n],t.active+=.5,e.event&&e.event.interrupt.call(this,this.__data__,e.index))}}function Yo(n,t,e){return ya(n,Pl),n.namespace=t,n.id=e,n}function Zo(n,t,e,r){var u=n.id,i=n.namespace;return Y(n,"function"==typeof e?function(n,o,a){n[i][u].tween.set(t,r(e.call(n,n.__data__,o,a)))}:(e=r(e),function(n){n[i][u].tween.set(t,e)}))}function Vo(n){return null==n&&(n=""),function(){this.textContent=n}}function Xo(n){return null==n?"__transition__":"__transition_"+n+"__"}function $o(n,t,e,r,u){var i=n[e]||(n[e]={active:0,count:0}),o=i[r];if(!o){var a=u.time;o=i[r]={tween:new l,time:a,delay:u.delay,duration:u.duration,ease:u.ease,index:t},u=null,++i.count,ta.timer(function(u){function c(e){if(i.active>r)return s();var u=i[i.active];u&&(--i.count,delete i[i.active],u.event&&u.event.interrupt.call(n,n.__data__,u.index)),i.active=r,o.event&&o.event.start.call(n,n.__data__,t),o.tween.forEach(function(e,r){(r=r.call(n,n.__data__,t))&&v.push(r)}),h=o.ease,f=o.duration,ta.timer(function(){return p.c=l(e||1)?Ne:l,1},0,a)}function l(e){if(i.active!==r)return 1;for(var u=e/f,a=h(u),c=v.length;c>0;)v[--c].call(n,a);return u>=1?(o.event&&o.event.end.call(n,n.__data__,t),s()):void 0}function s(){return--i.count?delete i[r]:delete n[e],1}var f,h,g=o.delay,p=ec,v=[];return p.t=g+a,u>=g?c(u-g):void(p.c=c)},0,a)}}function Bo(n,t,e){n.attr("transform",function(n){var r=t(n);return"translate("+(isFinite(r)?r:e(n))+",0)"})}function Wo(n,t,e){n.attr("transform",function(n){var r=t(n);return"translate(0,"+(isFinite(r)?r:e(n))+")"})}function Jo(n){return n.toISOString()}function Go(n,t,e){function r(t){return n(t)}function u(n,e){var r=n[1]-n[0],u=r/e,i=ta.bisect(Vl,u);return i==Vl.length?[t.year,Vi(n.map(function(n){return n/31536e6}),e)[2]]:i?t[u/Vl[i-1]<Vl[i]/u?i-1:i]:[Bl,Vi(n,e)[2]]}return r.invert=function(t){return Ko(n.invert(t))},r.domain=function(t){return arguments.length?(n.domain(t),r):n.domain().map(Ko)},r.nice=function(n,t){function e(e){return!isNaN(e)&&!n.range(e,Ko(+e+1),t).length}var i=r.domain(),o=Pi(i),a=null==n?u(o,10):"number"==typeof n&&u(o,n);return a&&(n=a[0],t=a[1]),r.domain(Fi(i,t>1?{floor:function(t){for(;e(t=n.floor(t));)t=Ko(t-1);return t},ceil:function(t){for(;e(t=n.ceil(t));)t=Ko(+t+1);return t}}:n))},r.ticks=function(n,t){var e=Pi(r.domain()),i=null==n?u(e,10):"number"==typeof n?u(e,n):!n.range&&[{range:n},t];return i&&(n=i[0],t=i[1]),n.range(e[0],Ko(+e[1]+1),1>t?1:t)},r.tickFormat=function(){return e},r.copy=function(){return Go(n.copy(),t,e)},Yi(r,n)}function Ko(n){return new Date(n)}function Qo(n){return JSON.parse(n.responseText)}function na(n){var t=ua.createRange();return t.selectNode(ua.body),t.createContextualFragment(n.responseText)}var ta={version:"3.5.5"},ea=[].slice,ra=function(n){return ea.call(n)},ua=this.document;if(ua)try{ra(ua.documentElement.childNodes)[0].nodeType}catch(ia){ra=function(n){for(var t=n.length,e=new Array(t);t--;)e[t]=n[t];return e}}if(Date.now||(Date.now=function(){return+new Date}),ua)try{ua.createElement("DIV").style.setProperty("opacity",0,"")}catch(oa){var aa=this.Element.prototype,ca=aa.setAttribute,la=aa.setAttributeNS,sa=this.CSSStyleDeclaration.prototype,fa=sa.setProperty;aa.setAttribute=function(n,t){ca.call(this,n,t+"")},aa.setAttributeNS=function(n,t,e){la.call(this,n,t,e+"")},sa.setProperty=function(n,t,e){fa.call(this,n,t+"",e)}}ta.ascending=e,ta.descending=function(n,t){return n>t?-1:t>n?1:t>=n?0:0/0},ta.min=function(n,t){var e,r,u=-1,i=n.length;if(1===arguments.length){for(;++u<i;)if(null!=(r=n[u])&&r>=r){e=r;break}for(;++u<i;)null!=(r=n[u])&&e>r&&(e=r)}else{for(;++u<i;)if(null!=(r=t.call(n,n[u],u))&&r>=r){e=r;break}for(;++u<i;)null!=(r=t.call(n,n[u],u))&&e>r&&(e=r)}return e},ta.max=function(n,t){var e,r,u=-1,i=n.length;if(1===arguments.length){for(;++u<i;)if(null!=(r=n[u])&&r>=r){e=r;break}for(;++u<i;)null!=(r=n[u])&&r>e&&(e=r)}else{for(;++u<i;)if(null!=(r=t.call(n,n[u],u))&&r>=r){e=r;break}for(;++u<i;)null!=(r=t.call(n,n[u],u))&&r>e&&(e=r)}return e},ta.extent=function(n,t){var e,r,u,i=-1,o=n.length;if(1===arguments.length){for(;++i<o;)if(null!=(r=n[i])&&r>=r){e=u=r;break}for(;++i<o;)null!=(r=n[i])&&(e>r&&(e=r),r>u&&(u=r))}else{for(;++i<o;)if(null!=(r=t.call(n,n[i],i))&&r>=r){e=u=r;break}for(;++i<o;)null!=(r=t.call(n,n[i],i))&&(e>r&&(e=r),r>u&&(u=r))}return[e,u]},ta.sum=function(n,t){var e,r=0,i=n.length,o=-1;if(1===arguments.length)for(;++o<i;)u(e=+n[o])&&(r+=e);else for(;++o<i;)u(e=+t.call(n,n[o],o))&&(r+=e);return r},ta.mean=function(n,t){var e,i=0,o=n.length,a=-1,c=o;if(1===arguments.length)for(;++a<o;)u(e=r(n[a]))?i+=e:--c;else for(;++a<o;)u(e=r(t.call(n,n[a],a)))?i+=e:--c;return c?i/c:void 0},ta.quantile=function(n,t){var e=(n.length-1)*t+1,r=Math.floor(e),u=+n[r-1],i=e-r;return i?u+i*(n[r]-u):u},ta.median=function(n,t){var i,o=[],a=n.length,c=-1;if(1===arguments.length)for(;++c<a;)u(i=r(n[c]))&&o.push(i);else for(;++c<a;)u(i=r(t.call(n,n[c],c)))&&o.push(i);return o.length?ta.quantile(o.sort(e),.5):void 0},ta.variance=function(n,t){var e,i,o=n.length,a=0,c=0,l=-1,s=0;if(1===arguments.length)for(;++l<o;)u(e=r(n[l]))&&(i=e-a,a+=i/++s,c+=i*(e-a));else for(;++l<o;)u(e=r(t.call(n,n[l],l)))&&(i=e-a,a+=i/++s,c+=i*(e-a));return s>1?c/(s-1):void 0},ta.deviation=function(){var n=ta.variance.apply(this,arguments);return n?Math.sqrt(n):n};var ha=i(e);ta.bisectLeft=ha.left,ta.bisect=ta.bisectRight=ha.right,ta.bisector=function(n){return i(1===n.length?function(t,r){return e(n(t),r)}:n)},ta.shuffle=function(n,t,e){(i=arguments.length)<3&&(e=n.length,2>i&&(t=0));for(var r,u,i=e-t;i;)u=Math.random()*i--|0,r=n[i+t],n[i+t]=n[u+t],n[u+t]=r;return n},ta.permute=function(n,t){for(var e=t.length,r=new Array(e);e--;)r[e]=n[t[e]];return r},ta.pairs=function(n){for(var t,e=0,r=n.length-1,u=n[0],i=new Array(0>r?0:r);r>e;)i[e]=[t=u,u=n[++e]];return i},ta.zip=function(){if(!(r=arguments.length))return[];for(var n=-1,t=ta.min(arguments,o),e=new Array(t);++n<t;)for(var r,u=-1,i=e[n]=new Array(r);++u<r;)i[u]=arguments[u][n];return e},ta.transpose=function(n){return ta.zip.apply(ta,n)},ta.keys=function(n){var t=[];for(var e in n)t.push(e);return t},ta.values=function(n){var t=[];for(var e in n)t.push(n[e]);return t},ta.entries=function(n){var t=[];for(var e in n)t.push({key:e,value:n[e]});return t},ta.merge=function(n){for(var t,e,r,u=n.length,i=-1,o=0;++i<u;)o+=n[i].length;for(e=new Array(o);--u>=0;)for(r=n[u],t=r.length;--t>=0;)e[--o]=r[t];return e};var ga=Math.abs;ta.range=function(n,t,e){if(arguments.length<3&&(e=1,arguments.length<2&&(t=n,n=0)),(t-n)/e===1/0)throw new Error("infinite range");var r,u=[],i=a(ga(e)),o=-1;if(n*=i,t*=i,e*=i,0>e)for(;(r=n+e*++o)>t;)u.push(r/i);else for(;(r=n+e*++o)<t;)u.push(r/i);return u},ta.map=function(n,t){var e=new l;if(n instanceof l)n.forEach(function(n,t){e.set(n,t)});else if(Array.isArray(n)){var r,u=-1,i=n.length;if(1===arguments.length)for(;++u<i;)e.set(u,n[u]);else for(;++u<i;)e.set(t.call(n,r=n[u],u),r)}else for(var o in n)e.set(o,n[o]);return e};var pa="__proto__",va="\x00";c(l,{has:h,get:function(n){return this._[s(n)]},set:function(n,t){return this._[s(n)]=t},remove:g,keys:p,values:function(){var n=[];for(var t in this._)n.push(this._[t]);return n},entries:function(){var n=[];for(var t in this._)n.push({key:f(t),value:this._[t]});return n},size:v,empty:d,forEach:function(n){for(var t in this._)n.call(this,f(t),this._[t])}}),ta.nest=function(){function n(t,o,a){if(a>=i.length)return r?r.call(u,o):e?o.sort(e):o;for(var c,s,f,h,g=-1,p=o.length,v=i[a++],d=new l;++g<p;)(h=d.get(c=v(s=o[g])))?h.push(s):d.set(c,[s]);return t?(s=t(),f=function(e,r){s.set(e,n(t,r,a))}):(s={},f=function(e,r){s[e]=n(t,r,a)}),d.forEach(f),s}function t(n,e){if(e>=i.length)return n;var r=[],u=o[e++];return n.forEach(function(n,u){r.push({key:n,values:t(u,e)})}),u?r.sort(function(n,t){return u(n.key,t.key)}):r}var e,r,u={},i=[],o=[];return u.map=function(t,e){return n(e,t,0)},u.entries=function(e){return t(n(ta.map,e,0),0)},u.key=function(n){return i.push(n),u},u.sortKeys=function(n){return o[i.length-1]=n,u},u.sortValues=function(n){return e=n,u},u.rollup=function(n){return r=n,u},u},ta.set=function(n){var t=new m;if(n)for(var e=0,r=n.length;r>e;++e)t.add(n[e]);return t},c(m,{has:h,add:function(n){return this._[s(n+="")]=!0,n},remove:g,values:p,size:v,empty:d,forEach:function(n){for(var t in this._)n.call(this,f(t))}}),ta.behavior={},ta.rebind=function(n,t){for(var e,r=1,u=arguments.length;++r<u;)n[e=arguments[r]]=M(n,t,t[e]);return n};var da=["webkit","ms","moz","Moz","o","O"];ta.dispatch=function(){for(var n=new _,t=-1,e=arguments.length;++t<e;)n[arguments[t]]=w(n);return n},_.prototype.on=function(n,t){var e=n.indexOf("."),r="";if(e>=0&&(r=n.slice(e+1),n=n.slice(0,e)),n)return arguments.length<2?this[n].on(r):this[n].on(r,t);if(2===arguments.length){if(null==t)for(n in this)this.hasOwnProperty(n)&&this[n].on(r,null);return this}},ta.event=null,ta.requote=function(n){return n.replace(ma,"\\$&")};var ma=/[\\\^\$\*\+\?\|\[\]\(\)\.\{\}]/g,ya={}.__proto__?function(n,t){n.__proto__=t}:function(n,t){for(var e in t)n[e]=t[e]},Ma=function(n,t){return t.querySelector(n)},xa=function(n,t){return t.querySelectorAll(n)},ba=function(n,t){var e=n.matches||n[x(n,"matchesSelector")];return(ba=function(n,t){return e.call(n,t)})(n,t)};"function"==typeof Sizzle&&(Ma=function(n,t){return Sizzle(n,t)[0]||null},xa=Sizzle,ba=Sizzle.matchesSelector),ta.selection=function(){return ta.select(ua.documentElement)};var _a=ta.selection.prototype=[];_a.select=function(n){var t,e,r,u,i=[];n=N(n);for(var o=-1,a=this.length;++o<a;){i.push(t=[]),t.parentNode=(r=this[o]).parentNode;for(var c=-1,l=r.length;++c<l;)(u=r[c])?(t.push(e=n.call(u,u.__data__,c,o)),e&&"__data__"in u&&(e.__data__=u.__data__)):t.push(null)}return A(i)},_a.selectAll=function(n){var t,e,r=[];n=C(n);for(var u=-1,i=this.length;++u<i;)for(var o=this[u],a=-1,c=o.length;++a<c;)(e=o[a])&&(r.push(t=ra(n.call(e,e.__data__,a,u))),t.parentNode=e);return A(r)};var wa={svg:"http://www.w3.org/2000/svg",xhtml:"http://www.w3.org/1999/xhtml",xlink:"http://www.w3.org/1999/xlink",xml:"http://www.w3.org/XML/1998/namespace",xmlns:"http://www.w3.org/2000/xmlns/"};ta.ns={prefix:wa,qualify:function(n){var t=n.indexOf(":"),e=n;return t>=0&&(e=n.slice(0,t),n=n.slice(t+1)),wa.hasOwnProperty(e)?{space:wa[e],local:n}:n}},_a.attr=function(n,t){if(arguments.length<2){if("string"==typeof n){var e=this.node();return n=ta.ns.qualify(n),n.local?e.getAttributeNS(n.space,n.local):e.getAttribute(n)}for(t in n)this.each(z(t,n[t]));return this}return this.each(z(n,t))},_a.classed=function(n,t){if(arguments.length<2){if("string"==typeof n){var e=this.node(),r=(n=T(n)).length,u=-1;if(t=e.classList){for(;++u<r;)if(!t.contains(n[u]))return!1}else for(t=e.getAttribute("class");++u<r;)if(!L(n[u]).test(t))return!1;return!0}for(t in n)this.each(R(t,n[t]));return this}return this.each(R(n,t))},_a.style=function(n,e,r){var u=arguments.length;if(3>u){if("string"!=typeof n){2>u&&(e="");for(r in n)this.each(P(r,n[r],e));return this}if(2>u){var i=this.node();return t(i).getComputedStyle(i,null).getPropertyValue(n)}r=""}return this.each(P(n,e,r))},_a.property=function(n,t){if(arguments.length<2){if("string"==typeof n)return this.node()[n];for(t in n)this.each(U(t,n[t]));return this}return this.each(U(n,t))},_a.text=function(n){return arguments.length?this.each("function"==typeof n?function(){var t=n.apply(this,arguments);this.textContent=null==t?"":t}:null==n?function(){this.textContent=""}:function(){this.textContent=n}):this.node().textContent},_a.html=function(n){return arguments.length?this.each("function"==typeof n?function(){var t=n.apply(this,arguments);this.innerHTML=null==t?"":t}:null==n?function(){this.innerHTML=""}:function(){this.innerHTML=n}):this.node().innerHTML},_a.append=function(n){return n=j(n),this.select(function(){return this.appendChild(n.apply(this,arguments))})},_a.insert=function(n,t){return n=j(n),t=N(t),this.select(function(){return this.insertBefore(n.apply(this,arguments),t.apply(this,arguments)||null)})},_a.remove=function(){return this.each(F)},_a.data=function(n,t){function e(n,e){var r,u,i,o=n.length,f=e.length,h=Math.min(o,f),g=new Array(f),p=new Array(f),v=new Array(o);if(t){var d,m=new l,y=new Array(o);for(r=-1;++r<o;)m.has(d=t.call(u=n[r],u.__data__,r))?v[r]=u:m.set(d,u),y[r]=d;for(r=-1;++r<f;)(u=m.get(d=t.call(e,i=e[r],r)))?u!==!0&&(g[r]=u,u.__data__=i):p[r]=H(i),m.set(d,!0);for(r=-1;++r<o;)m.get(y[r])!==!0&&(v[r]=n[r])}else{for(r=-1;++r<h;)u=n[r],i=e[r],u?(u.__data__=i,g[r]=u):p[r]=H(i);for(;f>r;++r)p[r]=H(e[r]);for(;o>r;++r)v[r]=n[r]}p.update=g,p.parentNode=g.parentNode=v.parentNode=n.parentNode,a.push(p),c.push(g),s.push(v)}var r,u,i=-1,o=this.length;if(!arguments.length){for(n=new Array(o=(r=this[0]).length);++i<o;)(u=r[i])&&(n[i]=u.__data__);return n}var a=Z([]),c=A([]),s=A([]);if("function"==typeof n)for(;++i<o;)e(r=this[i],n.call(r,r.parentNode.__data__,i));else for(;++i<o;)e(r=this[i],n);return c.enter=function(){return a},c.exit=function(){return s},c},_a.datum=function(n){return arguments.length?this.property("__data__",n):this.property("__data__")},_a.filter=function(n){var t,e,r,u=[];"function"!=typeof n&&(n=O(n));for(var i=0,o=this.length;o>i;i++){u.push(t=[]),t.parentNode=(e=this[i]).parentNode;for(var a=0,c=e.length;c>a;a++)(r=e[a])&&n.call(r,r.__data__,a,i)&&t.push(r)}return A(u)},_a.order=function(){for(var n=-1,t=this.length;++n<t;)for(var e,r=this[n],u=r.length-1,i=r[u];--u>=0;)(e=r[u])&&(i&&i!==e.nextSibling&&i.parentNode.insertBefore(e,i),i=e);return this},_a.sort=function(n){n=I.apply(this,arguments);for(var t=-1,e=this.length;++t<e;)this[t].sort(n);return this.order()},_a.each=function(n){return Y(this,function(t,e,r){n.call(t,t.__data__,e,r)})},_a.call=function(n){var t=ra(arguments);return n.apply(t[0]=this,t),this},_a.empty=function(){return!this.node()},_a.node=function(){for(var n=0,t=this.length;t>n;n++)for(var e=this[n],r=0,u=e.length;u>r;r++){var i=e[r];if(i)return i}return null},_a.size=function(){var n=0;return Y(this,function(){++n}),n};var Sa=[];ta.selection.enter=Z,ta.selection.enter.prototype=Sa,Sa.append=_a.append,Sa.empty=_a.empty,Sa.node=_a.node,Sa.call=_a.call,Sa.size=_a.size,Sa.select=function(n){for(var t,e,r,u,i,o=[],a=-1,c=this.length;++a<c;){r=(u=this[a]).update,o.push(t=[]),t.parentNode=u.parentNode;for(var l=-1,s=u.length;++l<s;)(i=u[l])?(t.push(r[l]=e=n.call(u.parentNode,i.__data__,l,a)),e.__data__=i.__data__):t.push(null)}return A(o)},Sa.insert=function(n,t){return arguments.length<2&&(t=V(this)),_a.insert.call(this,n,t)},ta.select=function(t){var e;return"string"==typeof t?(e=[Ma(t,ua)],e.parentNode=ua.documentElement):(e=[t],e.parentNode=n(t)),A([e])},ta.selectAll=function(n){var t;return"string"==typeof n?(t=ra(xa(n,ua)),t.parentNode=ua.documentElement):(t=n,t.parentNode=null),A([t])},_a.on=function(n,t,e){var r=arguments.length;if(3>r){if("string"!=typeof n){2>r&&(t=!1);for(e in n)this.each(X(e,n[e],t));return this}if(2>r)return(r=this.node()["__on"+n])&&r._;e=!1}return this.each(X(n,t,e))};var ka=ta.map({mouseenter:"mouseover",mouseleave:"mouseout"});ua&&ka.forEach(function(n){"on"+n in ua&&ka.remove(n)});var Ea,Aa=0;ta.mouse=function(n){return J(n,k())};var Na=this.navigator&&/WebKit/.test(this.navigator.userAgent)?-1:0;ta.touch=function(n,t,e){if(arguments.length<3&&(e=t,t=k().changedTouches),t)for(var r,u=0,i=t.length;i>u;++u)if((r=t[u]).identifier===e)return J(n,r)},ta.behavior.drag=function(){function n(){this.on("mousedown.drag",i).on("touchstart.drag",o)}function e(n,t,e,i,o){return function(){function a(){var n,e,r=t(h,v);r&&(n=r[0]-M[0],e=r[1]-M[1],p|=n|e,M=r,g({type:"drag",x:r[0]+l[0],y:r[1]+l[1],dx:n,dy:e}))}function c(){t(h,v)&&(m.on(i+d,null).on(o+d,null),y(p&&ta.event.target===f),g({type:"dragend"}))}var l,s=this,f=ta.event.target,h=s.parentNode,g=r.of(s,arguments),p=0,v=n(),d=".drag"+(null==v?"":"-"+v),m=ta.select(e(f)).on(i+d,a).on(o+d,c),y=W(f),M=t(h,v);u?(l=u.apply(s,arguments),l=[l.x-M[0],l.y-M[1]]):l=[0,0],g({type:"dragstart"})}}var r=E(n,"drag","dragstart","dragend"),u=null,i=e(b,ta.mouse,t,"mousemove","mouseup"),o=e(G,ta.touch,y,"touchmove","touchend");return n.origin=function(t){return arguments.length?(u=t,n):u},ta.rebind(n,r,"on")},ta.touches=function(n,t){return arguments.length<2&&(t=k().touches),t?ra(t).map(function(t){var e=J(n,t);return e.identifier=t.identifier,e}):[]};var Ca=1e-6,za=Ca*Ca,qa=Math.PI,La=2*qa,Ta=La-Ca,Ra=qa/2,Da=qa/180,Pa=180/qa,Ua=Math.SQRT2,ja=2,Fa=4;ta.interpolateZoom=function(n,t){function e(n){var t=n*y;if(m){var e=rt(v),o=i/(ja*h)*(e*ut(Ua*t+v)-et(v));return[r+o*l,u+o*s,i*e/rt(Ua*t+v)]}return[r+n*l,u+n*s,i*Math.exp(Ua*t)]}var r=n[0],u=n[1],i=n[2],o=t[0],a=t[1],c=t[2],l=o-r,s=a-u,f=l*l+s*s,h=Math.sqrt(f),g=(c*c-i*i+Fa*f)/(2*i*ja*h),p=(c*c-i*i-Fa*f)/(2*c*ja*h),v=Math.log(Math.sqrt(g*g+1)-g),d=Math.log(Math.sqrt(p*p+1)-p),m=d-v,y=(m||Math.log(c/i))/Ua;return e.duration=1e3*y,e},ta.behavior.zoom=function(){function n(n){n.on(q,f).on(Oa+".zoom",g).on("dblclick.zoom",p).on(R,h)}function e(n){return[(n[0]-k.x)/k.k,(n[1]-k.y)/k.k]}function r(n){return[n[0]*k.k+k.x,n[1]*k.k+k.y]}function u(n){k.k=Math.max(N[0],Math.min(N[1],n))}function i(n,t){t=r(t),k.x+=n[0]-t[0],k.y+=n[1]-t[1]}function o(t,e,r,o){t.__chart__={x:k.x,y:k.y,k:k.k},u(Math.pow(2,o)),i(d=e,r),t=ta.select(t),C>0&&(t=t.transition().duration(C)),t.call(n.event)}function a(){b&&b.domain(x.range().map(function(n){return(n-k.x)/k.k}).map(x.invert)),w&&w.domain(_.range().map(function(n){return(n-k.y)/k.k}).map(_.invert))}function c(n){z++||n({type:"zoomstart"})}function l(n){a(),n({type:"zoom",scale:k.k,translate:[k.x,k.y]})}function s(n){--z||n({type:"zoomend"}),d=null}function f(){function n(){f=1,i(ta.mouse(u),g),l(a)}function r(){h.on(L,null).on(T,null),p(f&&ta.event.target===o),s(a)}var u=this,o=ta.event.target,a=D.of(u,arguments),f=0,h=ta.select(t(u)).on(L,n).on(T,r),g=e(ta.mouse(u)),p=W(u);Dl.call(u),c(a)}function h(){function n(){var n=ta.touches(p);return g=k.k,n.forEach(function(n){n.identifier in d&&(d[n.identifier]=e(n))}),n}function t(){var t=ta.event.target;ta.select(t).on(x,r).on(b,a),_.push(t);for(var e=ta.event.changedTouches,u=0,i=e.length;i>u;++u)d[e[u].identifier]=null;var c=n(),l=Date.now();if(1===c.length){if(500>l-M){var s=c[0];o(p,s,d[s.identifier],Math.floor(Math.log(k.k)/Math.LN2)+1),S()}M=l}else if(c.length>1){var s=c[0],f=c[1],h=s[0]-f[0],g=s[1]-f[1];m=h*h+g*g}}function r(){var n,t,e,r,o=ta.touches(p);Dl.call(p);for(var a=0,c=o.length;c>a;++a,r=null)if(e=o[a],r=d[e.identifier]){if(t)break;n=e,t=r}if(r){var s=(s=e[0]-n[0])*s+(s=e[1]-n[1])*s,f=m&&Math.sqrt(s/m);n=[(n[0]+e[0])/2,(n[1]+e[1])/2],t=[(t[0]+r[0])/2,(t[1]+r[1])/2],u(f*g)}M=null,i(n,t),l(v)}function a(){if(ta.event.touches.length){for(var t=ta.event.changedTouches,e=0,r=t.length;r>e;++e)delete d[t[e].identifier];for(var u in d)return void n()}ta.selectAll(_).on(y,null),w.on(q,f).on(R,h),E(),s(v)}var g,p=this,v=D.of(p,arguments),d={},m=0,y=".zoom-"+ta.event.changedTouches[0].identifier,x="touchmove"+y,b="touchend"+y,_=[],w=ta.select(p),E=W(p);t(),c(v),w.on(q,null).on(R,t)}function g(){var n=D.of(this,arguments);y?clearTimeout(y):(v=e(d=m||ta.mouse(this)),Dl.call(this),c(n)),y=setTimeout(function(){y=null,s(n)},50),S(),u(Math.pow(2,.002*Ha())*k.k),i(d,v),l(n)}function p(){var n=ta.mouse(this),t=Math.log(k.k)/Math.LN2;o(this,n,e(n),ta.event.shiftKey?Math.ceil(t)-1:Math.floor(t)+1)}var v,d,m,y,M,x,b,_,w,k={x:0,y:0,k:1},A=[960,500],N=Ia,C=250,z=0,q="mousedown.zoom",L="mousemove.zoom",T="mouseup.zoom",R="touchstart.zoom",D=E(n,"zoomstart","zoom","zoomend");return Oa||(Oa="onwheel"in ua?(Ha=function(){return-ta.event.deltaY*(ta.event.deltaMode?120:1)},"wheel"):"onmousewheel"in ua?(Ha=function(){return ta.event.wheelDelta},"mousewheel"):(Ha=function(){return-ta.event.detail},"MozMousePixelScroll")),n.event=function(n){n.each(function(){var n=D.of(this,arguments),t=k;Tl?ta.select(this).transition().each("start.zoom",function(){k=this.__chart__||{x:0,y:0,k:1},c(n)}).tween("zoom:zoom",function(){var e=A[0],r=A[1],u=d?d[0]:e/2,i=d?d[1]:r/2,o=ta.interpolateZoom([(u-k.x)/k.k,(i-k.y)/k.k,e/k.k],[(u-t.x)/t.k,(i-t.y)/t.k,e/t.k]);return function(t){var r=o(t),a=e/r[2];this.__chart__=k={x:u-r[0]*a,y:i-r[1]*a,k:a},l(n)}}).each("interrupt.zoom",function(){s(n)}).each("end.zoom",function(){s(n)}):(this.__chart__=k,c(n),l(n),s(n))})},n.translate=function(t){return arguments.length?(k={x:+t[0],y:+t[1],k:k.k},a(),n):[k.x,k.y]},n.scale=function(t){return arguments.length?(k={x:k.x,y:k.y,k:+t},a(),n):k.k},n.scaleExtent=function(t){return arguments.length?(N=null==t?Ia:[+t[0],+t[1]],n):N},n.center=function(t){return arguments.length?(m=t&&[+t[0],+t[1]],n):m},n.size=function(t){return arguments.length?(A=t&&[+t[0],+t[1]],n):A},n.duration=function(t){return arguments.length?(C=+t,n):C},n.x=function(t){return arguments.length?(b=t,x=t.copy(),k={x:0,y:0,k:1},n):b},n.y=function(t){return arguments.length?(w=t,_=t.copy(),k={x:0,y:0,k:1},n):w},ta.rebind(n,D,"on")};var Ha,Oa,Ia=[0,1/0];ta.color=ot,ot.prototype.toString=function(){return this.rgb()+""},ta.hsl=at;var Ya=at.prototype=new ot;Ya.brighter=function(n){return n=Math.pow(.7,arguments.length?n:1),new at(this.h,this.s,this.l/n)},Ya.darker=function(n){return n=Math.pow(.7,arguments.length?n:1),new at(this.h,this.s,n*this.l)},Ya.rgb=function(){return ct(this.h,this.s,this.l)},ta.hcl=lt;var Za=lt.prototype=new ot;Za.brighter=function(n){return new lt(this.h,this.c,Math.min(100,this.l+Va*(arguments.length?n:1)))},Za.darker=function(n){return new lt(this.h,this.c,Math.max(0,this.l-Va*(arguments.length?n:1)))},Za.rgb=function(){return st(this.h,this.c,this.l).rgb()},ta.lab=ft;var Va=18,Xa=.95047,$a=1,Ba=1.08883,Wa=ft.prototype=new ot;Wa.brighter=function(n){return new ft(Math.min(100,this.l+Va*(arguments.length?n:1)),this.a,this.b)},Wa.darker=function(n){return new ft(Math.max(0,this.l-Va*(arguments.length?n:1)),this.a,this.b)},Wa.rgb=function(){return ht(this.l,this.a,this.b)},ta.rgb=mt;var Ja=mt.prototype=new ot;Ja.brighter=function(n){n=Math.pow(.7,arguments.length?n:1);var t=this.r,e=this.g,r=this.b,u=30;return t||e||r?(t&&u>t&&(t=u),e&&u>e&&(e=u),r&&u>r&&(r=u),new mt(Math.min(255,t/n),Math.min(255,e/n),Math.min(255,r/n))):new mt(u,u,u)},Ja.darker=function(n){return n=Math.pow(.7,arguments.length?n:1),new mt(n*this.r,n*this.g,n*this.b)},Ja.hsl=function(){return _t(this.r,this.g,this.b)},Ja.toString=function(){return"#"+xt(this.r)+xt(this.g)+xt(this.b)};var Ga=ta.map({aliceblue:15792383,antiquewhite:16444375,aqua:65535,aquamarine:8388564,azure:15794175,beige:16119260,bisque:16770244,black:0,blanchedalmond:16772045,blue:255,blueviolet:9055202,brown:10824234,burlywood:14596231,cadetblue:6266528,chartreuse:8388352,chocolate:13789470,coral:16744272,cornflowerblue:6591981,cornsilk:16775388,crimson:14423100,cyan:65535,darkblue:139,darkcyan:35723,darkgoldenrod:12092939,darkgray:11119017,darkgreen:25600,darkgrey:11119017,darkkhaki:12433259,darkmagenta:9109643,darkolivegreen:5597999,darkorange:16747520,darkorchid:10040012,darkred:9109504,darksalmon:15308410,darkseagreen:9419919,darkslateblue:4734347,darkslategray:3100495,darkslategrey:3100495,darkturquoise:52945,darkviolet:9699539,deeppink:16716947,deepskyblue:49151,dimgray:6908265,dimgrey:6908265,dodgerblue:2003199,firebrick:11674146,floralwhite:16775920,forestgreen:2263842,fuchsia:16711935,gainsboro:14474460,ghostwhite:16316671,gold:16766720,goldenrod:14329120,gray:8421504,green:32768,greenyellow:11403055,grey:8421504,honeydew:15794160,hotpink:16738740,indianred:13458524,indigo:4915330,ivory:16777200,khaki:15787660,lavender:15132410,lavenderblush:16773365,lawngreen:8190976,lemonchiffon:16775885,lightblue:11393254,lightcoral:15761536,lightcyan:14745599,lightgoldenrodyellow:16448210,lightgray:13882323,lightgreen:9498256,lightgrey:13882323,lightpink:16758465,lightsalmon:16752762,lightseagreen:2142890,lightskyblue:8900346,lightslategray:7833753,lightslategrey:7833753,lightsteelblue:11584734,lightyellow:16777184,lime:65280,limegreen:3329330,linen:16445670,magenta:16711935,maroon:8388608,mediumaquamarine:6737322,mediumblue:205,mediumorchid:12211667,mediumpurple:9662683,mediumseagreen:3978097,mediumslateblue:8087790,mediumspringgreen:64154,mediumturquoise:4772300,mediumvioletred:13047173,midnightblue:1644912,mintcream:16121850,mistyrose:16770273,moccasin:16770229,navajowhite:16768685,navy:128,oldlace:16643558,olive:8421376,olivedrab:7048739,orange:16753920,orangered:16729344,orchid:14315734,palegoldenrod:15657130,palegreen:10025880,paleturquoise:11529966,palevioletred:14381203,papayawhip:16773077,peachpuff:16767673,peru:13468991,pink:16761035,plum:14524637,powderblue:11591910,purple:8388736,rebeccapurple:6697881,red:16711680,rosybrown:12357519,royalblue:4286945,saddlebrown:9127187,salmon:16416882,sandybrown:16032864,seagreen:3050327,seashell:16774638,sienna:10506797,silver:12632256,skyblue:8900331,slateblue:6970061,slategray:7372944,slategrey:7372944,snow:16775930,springgreen:65407,steelblue:4620980,tan:13808780,teal:32896,thistle:14204888,tomato:16737095,turquoise:4251856,violet:15631086,wheat:16113331,white:16777215,whitesmoke:16119285,yellow:16776960,yellowgreen:10145074});Ga.forEach(function(n,t){Ga.set(n,yt(t))}),ta.functor=Et,ta.xhr=At(y),ta.dsv=function(n,t){function e(n,e,i){arguments.length<3&&(i=e,e=null);var o=Nt(n,t,null==e?r:u(e),i);return o.row=function(n){return arguments.length?o.response(null==(e=n)?r:u(n)):e},o}function r(n){return e.parse(n.responseText)}function u(n){return function(t){return e.parse(t.responseText,n)}}function i(t){return t.map(o).join(n)}function o(n){return a.test(n)?'"'+n.replace(/\"/g,'""')+'"':n}var a=new RegExp('["'+n+"\n]"),c=n.charCodeAt(0);return e.parse=function(n,t){var r;return e.parseRows(n,function(n,e){if(r)return r(n,e-1);var u=new Function("d","return {"+n.map(function(n,t){return JSON.stringify(n)+": d["+t+"]"}).join(",")+"}");r=t?function(n,e){return t(u(n),e)}:u})},e.parseRows=function(n,t){function e(){if(s>=l)return o;if(u)return u=!1,i;var t=s;if(34===n.charCodeAt(t)){for(var e=t;e++<l;)if(34===n.charCodeAt(e)){if(34!==n.charCodeAt(e+1))break;++e}s=e+2;var r=n.charCodeAt(e+1);return 13===r?(u=!0,10===n.charCodeAt(e+2)&&++s):10===r&&(u=!0),n.slice(t+1,e).replace(/""/g,'"')}for(;l>s;){var r=n.charCodeAt(s++),a=1;if(10===r)u=!0;else if(13===r)u=!0,10===n.charCodeAt(s)&&(++s,++a);else if(r!==c)continue;return n.slice(t,s-a)}return n.slice(t)}for(var r,u,i={},o={},a=[],l=n.length,s=0,f=0;(r=e())!==o;){for(var h=[];r!==i&&r!==o;)h.push(r),r=e();t&&null==(h=t(h,f++))||a.push(h)}return a},e.format=function(t){if(Array.isArray(t[0]))return e.formatRows(t);var r=new m,u=[];return t.forEach(function(n){for(var t in n)r.has(t)||u.push(r.add(t))}),[u.map(o).join(n)].concat(t.map(function(t){return u.map(function(n){return o(t[n])}).join(n)})).join("\n")},e.formatRows=function(n){return n.map(i).join("\n")},e},ta.csv=ta.dsv(",","text/csv"),ta.tsv=ta.dsv("	","text/tab-separated-values");var Ka,Qa,nc,tc,ec,rc=this[x(this,"requestAnimationFrame")]||function(n){setTimeout(n,17)};ta.timer=function(n,t,e){var r=arguments.length;2>r&&(t=0),3>r&&(e=Date.now());var u=e+t,i={c:n,t:u,f:!1,n:null};Qa?Qa.n=i:Ka=i,Qa=i,nc||(tc=clearTimeout(tc),nc=1,rc(qt))},ta.timer.flush=function(){Lt(),Tt()},ta.round=function(n,t){return t?Math.round(n*(t=Math.pow(10,t)))/t:Math.round(n)};var uc=["y","z","a","f","p","n","\xb5","m","","k","M","G","T","P","E","Z","Y"].map(Dt);ta.formatPrefix=function(n,t){var e=0;return n&&(0>n&&(n*=-1),t&&(n=ta.round(n,Rt(n,t))),e=1+Math.floor(1e-12+Math.log(n)/Math.LN10),e=Math.max(-24,Math.min(24,3*Math.floor((e-1)/3)))),uc[8+e/3]};var ic=/(?:([^{])?([<>=^]))?([+\- ])?([$#])?(0)?(\d+)?(,)?(\.-?\d+)?([a-z%])?/i,oc=ta.map({b:function(n){return n.toString(2)},c:function(n){return String.fromCharCode(n)},o:function(n){return n.toString(8)},x:function(n){return n.toString(16)},X:function(n){return n.toString(16).toUpperCase()},g:function(n,t){return n.toPrecision(t)},e:function(n,t){return n.toExponential(t)},f:function(n,t){return n.toFixed(t)},r:function(n,t){return(n=ta.round(n,Rt(n,t))).toFixed(Math.max(0,Math.min(20,Rt(n*(1+1e-15),t))))}}),ac=ta.time={},cc=Date;jt.prototype={getDate:function(){return this._.getUTCDate()},getDay:function(){return this._.getUTCDay()},getFullYear:function(){return this._.getUTCFullYear()},getHours:function(){return this._.getUTCHours()},getMilliseconds:function(){return this._.getUTCMilliseconds()},getMinutes:function(){return this._.getUTCMinutes()},getMonth:function(){return this._.getUTCMonth()},getSeconds:function(){return this._.getUTCSeconds()},getTime:function(){return this._.getTime()},getTimezoneOffset:function(){return 0},valueOf:function(){return this._.valueOf()},setDate:function(){lc.setUTCDate.apply(this._,arguments)},setDay:function(){lc.setUTCDay.apply(this._,arguments)},setFullYear:function(){lc.setUTCFullYear.apply(this._,arguments)},setHours:function(){lc.setUTCHours.apply(this._,arguments)},setMilliseconds:function(){lc.setUTCMilliseconds.apply(this._,arguments)},setMinutes:function(){lc.setUTCMinutes.apply(this._,arguments)},setMonth:function(){lc.setUTCMonth.apply(this._,arguments)},setSeconds:function(){lc.setUTCSeconds.apply(this._,arguments)},setTime:function(){lc.setTime.apply(this._,arguments)}};var lc=Date.prototype;ac.year=Ft(function(n){return n=ac.day(n),n.setMonth(0,1),n},function(n,t){n.setFullYear(n.getFullYear()+t)},function(n){return n.getFullYear()}),ac.years=ac.year.range,ac.years.utc=ac.year.utc.range,ac.day=Ft(function(n){var t=new cc(2e3,0);return t.setFullYear(n.getFullYear(),n.getMonth(),n.getDate()),t},function(n,t){n.setDate(n.getDate()+t)},function(n){return n.getDate()-1}),ac.days=ac.day.range,ac.days.utc=ac.day.utc.range,ac.dayOfYear=function(n){var t=ac.year(n);return Math.floor((n-t-6e4*(n.getTimezoneOffset()-t.getTimezoneOffset()))/864e5)},["sunday","monday","tuesday","wednesday","thursday","friday","saturday"].forEach(function(n,t){t=7-t;var e=ac[n]=Ft(function(n){return(n=ac.day(n)).setDate(n.getDate()-(n.getDay()+t)%7),n},function(n,t){n.setDate(n.getDate()+7*Math.floor(t))},function(n){var e=ac.year(n).getDay();return Math.floor((ac.dayOfYear(n)+(e+t)%7)/7)-(e!==t)});ac[n+"s"]=e.range,ac[n+"s"].utc=e.utc.range,ac[n+"OfYear"]=function(n){var e=ac.year(n).getDay();return Math.floor((ac.dayOfYear(n)+(e+t)%7)/7)}}),ac.week=ac.sunday,ac.weeks=ac.sunday.range,ac.weeks.utc=ac.sunday.utc.range,ac.weekOfYear=ac.sundayOfYear;var sc={"-":"",_:" ",0:"0"},fc=/^\s*\d+/,hc=/^%/;ta.locale=function(n){return{numberFormat:Pt(n),timeFormat:Ot(n)}};var gc=ta.locale({decimal:".",thousands:",",grouping:[3],currency:["$",""],dateTime:"%a %b %e %X %Y",date:"%m/%d/%Y",time:"%H:%M:%S",periods:["AM","PM"],days:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],shortDays:["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],months:["January","February","March","April","May","June","July","August","September","October","November","December"],shortMonths:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"]});ta.format=gc.numberFormat,ta.geo={},ce.prototype={s:0,t:0,add:function(n){le(n,this.t,pc),le(pc.s,this.s,this),this.s?this.t+=pc.t:this.s=pc.t
},reset:function(){this.s=this.t=0},valueOf:function(){return this.s}};var pc=new ce;ta.geo.stream=function(n,t){n&&vc.hasOwnProperty(n.type)?vc[n.type](n,t):se(n,t)};var vc={Feature:function(n,t){se(n.geometry,t)},FeatureCollection:function(n,t){for(var e=n.features,r=-1,u=e.length;++r<u;)se(e[r].geometry,t)}},dc={Sphere:function(n,t){t.sphere()},Point:function(n,t){n=n.coordinates,t.point(n[0],n[1],n[2])},MultiPoint:function(n,t){for(var e=n.coordinates,r=-1,u=e.length;++r<u;)n=e[r],t.point(n[0],n[1],n[2])},LineString:function(n,t){fe(n.coordinates,t,0)},MultiLineString:function(n,t){for(var e=n.coordinates,r=-1,u=e.length;++r<u;)fe(e[r],t,0)},Polygon:function(n,t){he(n.coordinates,t)},MultiPolygon:function(n,t){for(var e=n.coordinates,r=-1,u=e.length;++r<u;)he(e[r],t)},GeometryCollection:function(n,t){for(var e=n.geometries,r=-1,u=e.length;++r<u;)se(e[r],t)}};ta.geo.area=function(n){return mc=0,ta.geo.stream(n,Mc),mc};var mc,yc=new ce,Mc={sphere:function(){mc+=4*qa},point:b,lineStart:b,lineEnd:b,polygonStart:function(){yc.reset(),Mc.lineStart=ge},polygonEnd:function(){var n=2*yc;mc+=0>n?4*qa+n:n,Mc.lineStart=Mc.lineEnd=Mc.point=b}};ta.geo.bounds=function(){function n(n,t){M.push(x=[s=n,h=n]),f>t&&(f=t),t>g&&(g=t)}function t(t,e){var r=pe([t*Da,e*Da]);if(m){var u=de(m,r),i=[u[1],-u[0],0],o=de(i,u);Me(o),o=xe(o);var c=t-p,l=c>0?1:-1,v=o[0]*Pa*l,d=ga(c)>180;if(d^(v>l*p&&l*t>v)){var y=o[1]*Pa;y>g&&(g=y)}else if(v=(v+360)%360-180,d^(v>l*p&&l*t>v)){var y=-o[1]*Pa;f>y&&(f=y)}else f>e&&(f=e),e>g&&(g=e);d?p>t?a(s,t)>a(s,h)&&(h=t):a(t,h)>a(s,h)&&(s=t):h>=s?(s>t&&(s=t),t>h&&(h=t)):t>p?a(s,t)>a(s,h)&&(h=t):a(t,h)>a(s,h)&&(s=t)}else n(t,e);m=r,p=t}function e(){b.point=t}function r(){x[0]=s,x[1]=h,b.point=n,m=null}function u(n,e){if(m){var r=n-p;y+=ga(r)>180?r+(r>0?360:-360):r}else v=n,d=e;Mc.point(n,e),t(n,e)}function i(){Mc.lineStart()}function o(){u(v,d),Mc.lineEnd(),ga(y)>Ca&&(s=-(h=180)),x[0]=s,x[1]=h,m=null}function a(n,t){return(t-=n)<0?t+360:t}function c(n,t){return n[0]-t[0]}function l(n,t){return t[0]<=t[1]?t[0]<=n&&n<=t[1]:n<t[0]||t[1]<n}var s,f,h,g,p,v,d,m,y,M,x,b={point:n,lineStart:e,lineEnd:r,polygonStart:function(){b.point=u,b.lineStart=i,b.lineEnd=o,y=0,Mc.polygonStart()},polygonEnd:function(){Mc.polygonEnd(),b.point=n,b.lineStart=e,b.lineEnd=r,0>yc?(s=-(h=180),f=-(g=90)):y>Ca?g=90:-Ca>y&&(f=-90),x[0]=s,x[1]=h}};return function(n){g=h=-(s=f=1/0),M=[],ta.geo.stream(n,b);var t=M.length;if(t){M.sort(c);for(var e,r=1,u=M[0],i=[u];t>r;++r)e=M[r],l(e[0],u)||l(e[1],u)?(a(u[0],e[1])>a(u[0],u[1])&&(u[1]=e[1]),a(e[0],u[1])>a(u[0],u[1])&&(u[0]=e[0])):i.push(u=e);for(var o,e,p=-1/0,t=i.length-1,r=0,u=i[t];t>=r;u=e,++r)e=i[r],(o=a(u[1],e[0]))>p&&(p=o,s=e[0],h=u[1])}return M=x=null,1/0===s||1/0===f?[[0/0,0/0],[0/0,0/0]]:[[s,f],[h,g]]}}(),ta.geo.centroid=function(n){xc=bc=_c=wc=Sc=kc=Ec=Ac=Nc=Cc=zc=0,ta.geo.stream(n,qc);var t=Nc,e=Cc,r=zc,u=t*t+e*e+r*r;return za>u&&(t=kc,e=Ec,r=Ac,Ca>bc&&(t=_c,e=wc,r=Sc),u=t*t+e*e+r*r,za>u)?[0/0,0/0]:[Math.atan2(e,t)*Pa,tt(r/Math.sqrt(u))*Pa]};var xc,bc,_c,wc,Sc,kc,Ec,Ac,Nc,Cc,zc,qc={sphere:b,point:_e,lineStart:Se,lineEnd:ke,polygonStart:function(){qc.lineStart=Ee},polygonEnd:function(){qc.lineStart=Se}},Lc=Le(Ne,Pe,je,[-qa,-qa/2]),Tc=1e9;ta.geo.clipExtent=function(){var n,t,e,r,u,i,o={stream:function(n){return u&&(u.valid=!1),u=i(n),u.valid=!0,u},extent:function(a){return arguments.length?(i=Ie(n=+a[0][0],t=+a[0][1],e=+a[1][0],r=+a[1][1]),u&&(u.valid=!1,u=null),o):[[n,t],[e,r]]}};return o.extent([[0,0],[960,500]])},(ta.geo.conicEqualArea=function(){return Ye(Ze)}).raw=Ze,ta.geo.albers=function(){return ta.geo.conicEqualArea().rotate([96,0]).center([-.6,38.7]).parallels([29.5,45.5]).scale(1070)},ta.geo.albersUsa=function(){function n(n){var i=n[0],o=n[1];return t=null,e(i,o),t||(r(i,o),t)||u(i,o),t}var t,e,r,u,i=ta.geo.albers(),o=ta.geo.conicEqualArea().rotate([154,0]).center([-2,58.5]).parallels([55,65]),a=ta.geo.conicEqualArea().rotate([157,0]).center([-3,19.9]).parallels([8,18]),c={point:function(n,e){t=[n,e]}};return n.invert=function(n){var t=i.scale(),e=i.translate(),r=(n[0]-e[0])/t,u=(n[1]-e[1])/t;return(u>=.12&&.234>u&&r>=-.425&&-.214>r?o:u>=.166&&.234>u&&r>=-.214&&-.115>r?a:i).invert(n)},n.stream=function(n){var t=i.stream(n),e=o.stream(n),r=a.stream(n);return{point:function(n,u){t.point(n,u),e.point(n,u),r.point(n,u)},sphere:function(){t.sphere(),e.sphere(),r.sphere()},lineStart:function(){t.lineStart(),e.lineStart(),r.lineStart()},lineEnd:function(){t.lineEnd(),e.lineEnd(),r.lineEnd()},polygonStart:function(){t.polygonStart(),e.polygonStart(),r.polygonStart()},polygonEnd:function(){t.polygonEnd(),e.polygonEnd(),r.polygonEnd()}}},n.precision=function(t){return arguments.length?(i.precision(t),o.precision(t),a.precision(t),n):i.precision()},n.scale=function(t){return arguments.length?(i.scale(t),o.scale(.35*t),a.scale(t),n.translate(i.translate())):i.scale()},n.translate=function(t){if(!arguments.length)return i.translate();var l=i.scale(),s=+t[0],f=+t[1];return e=i.translate(t).clipExtent([[s-.455*l,f-.238*l],[s+.455*l,f+.238*l]]).stream(c).point,r=o.translate([s-.307*l,f+.201*l]).clipExtent([[s-.425*l+Ca,f+.12*l+Ca],[s-.214*l-Ca,f+.234*l-Ca]]).stream(c).point,u=a.translate([s-.205*l,f+.212*l]).clipExtent([[s-.214*l+Ca,f+.166*l+Ca],[s-.115*l-Ca,f+.234*l-Ca]]).stream(c).point,n},n.scale(1070)};var Rc,Dc,Pc,Uc,jc,Fc,Hc={point:b,lineStart:b,lineEnd:b,polygonStart:function(){Dc=0,Hc.lineStart=Ve},polygonEnd:function(){Hc.lineStart=Hc.lineEnd=Hc.point=b,Rc+=ga(Dc/2)}},Oc={point:Xe,lineStart:b,lineEnd:b,polygonStart:b,polygonEnd:b},Ic={point:We,lineStart:Je,lineEnd:Ge,polygonStart:function(){Ic.lineStart=Ke},polygonEnd:function(){Ic.point=We,Ic.lineStart=Je,Ic.lineEnd=Ge}};ta.geo.path=function(){function n(n){return n&&("function"==typeof a&&i.pointRadius(+a.apply(this,arguments)),o&&o.valid||(o=u(i)),ta.geo.stream(n,o)),i.result()}function t(){return o=null,n}var e,r,u,i,o,a=4.5;return n.area=function(n){return Rc=0,ta.geo.stream(n,u(Hc)),Rc},n.centroid=function(n){return _c=wc=Sc=kc=Ec=Ac=Nc=Cc=zc=0,ta.geo.stream(n,u(Ic)),zc?[Nc/zc,Cc/zc]:Ac?[kc/Ac,Ec/Ac]:Sc?[_c/Sc,wc/Sc]:[0/0,0/0]},n.bounds=function(n){return jc=Fc=-(Pc=Uc=1/0),ta.geo.stream(n,u(Oc)),[[Pc,Uc],[jc,Fc]]},n.projection=function(n){return arguments.length?(u=(e=n)?n.stream||tr(n):y,t()):e},n.context=function(n){return arguments.length?(i=null==(r=n)?new $e:new Qe(n),"function"!=typeof a&&i.pointRadius(a),t()):r},n.pointRadius=function(t){return arguments.length?(a="function"==typeof t?t:(i.pointRadius(+t),+t),n):a},n.projection(ta.geo.albersUsa()).context(null)},ta.geo.transform=function(n){return{stream:function(t){var e=new er(t);for(var r in n)e[r]=n[r];return e}}},er.prototype={point:function(n,t){this.stream.point(n,t)},sphere:function(){this.stream.sphere()},lineStart:function(){this.stream.lineStart()},lineEnd:function(){this.stream.lineEnd()},polygonStart:function(){this.stream.polygonStart()},polygonEnd:function(){this.stream.polygonEnd()}},ta.geo.projection=ur,ta.geo.projectionMutator=ir,(ta.geo.equirectangular=function(){return ur(ar)}).raw=ar.invert=ar,ta.geo.rotation=function(n){function t(t){return t=n(t[0]*Da,t[1]*Da),t[0]*=Pa,t[1]*=Pa,t}return n=lr(n[0]%360*Da,n[1]*Da,n.length>2?n[2]*Da:0),t.invert=function(t){return t=n.invert(t[0]*Da,t[1]*Da),t[0]*=Pa,t[1]*=Pa,t},t},cr.invert=ar,ta.geo.circle=function(){function n(){var n="function"==typeof r?r.apply(this,arguments):r,t=lr(-n[0]*Da,-n[1]*Da,0).invert,u=[];return e(null,null,1,{point:function(n,e){u.push(n=t(n,e)),n[0]*=Pa,n[1]*=Pa}}),{type:"Polygon",coordinates:[u]}}var t,e,r=[0,0],u=6;return n.origin=function(t){return arguments.length?(r=t,n):r},n.angle=function(r){return arguments.length?(e=gr((t=+r)*Da,u*Da),n):t},n.precision=function(r){return arguments.length?(e=gr(t*Da,(u=+r)*Da),n):u},n.angle(90)},ta.geo.distance=function(n,t){var e,r=(t[0]-n[0])*Da,u=n[1]*Da,i=t[1]*Da,o=Math.sin(r),a=Math.cos(r),c=Math.sin(u),l=Math.cos(u),s=Math.sin(i),f=Math.cos(i);return Math.atan2(Math.sqrt((e=f*o)*e+(e=l*s-c*f*a)*e),c*s+l*f*a)},ta.geo.graticule=function(){function n(){return{type:"MultiLineString",coordinates:t()}}function t(){return ta.range(Math.ceil(i/d)*d,u,d).map(h).concat(ta.range(Math.ceil(l/m)*m,c,m).map(g)).concat(ta.range(Math.ceil(r/p)*p,e,p).filter(function(n){return ga(n%d)>Ca}).map(s)).concat(ta.range(Math.ceil(a/v)*v,o,v).filter(function(n){return ga(n%m)>Ca}).map(f))}var e,r,u,i,o,a,c,l,s,f,h,g,p=10,v=p,d=90,m=360,y=2.5;return n.lines=function(){return t().map(function(n){return{type:"LineString",coordinates:n}})},n.outline=function(){return{type:"Polygon",coordinates:[h(i).concat(g(c).slice(1),h(u).reverse().slice(1),g(l).reverse().slice(1))]}},n.extent=function(t){return arguments.length?n.majorExtent(t).minorExtent(t):n.minorExtent()},n.majorExtent=function(t){return arguments.length?(i=+t[0][0],u=+t[1][0],l=+t[0][1],c=+t[1][1],i>u&&(t=i,i=u,u=t),l>c&&(t=l,l=c,c=t),n.precision(y)):[[i,l],[u,c]]},n.minorExtent=function(t){return arguments.length?(r=+t[0][0],e=+t[1][0],a=+t[0][1],o=+t[1][1],r>e&&(t=r,r=e,e=t),a>o&&(t=a,a=o,o=t),n.precision(y)):[[r,a],[e,o]]},n.step=function(t){return arguments.length?n.majorStep(t).minorStep(t):n.minorStep()},n.majorStep=function(t){return arguments.length?(d=+t[0],m=+t[1],n):[d,m]},n.minorStep=function(t){return arguments.length?(p=+t[0],v=+t[1],n):[p,v]},n.precision=function(t){return arguments.length?(y=+t,s=vr(a,o,90),f=dr(r,e,y),h=vr(l,c,90),g=dr(i,u,y),n):y},n.majorExtent([[-180,-90+Ca],[180,90-Ca]]).minorExtent([[-180,-80-Ca],[180,80+Ca]])},ta.geo.greatArc=function(){function n(){return{type:"LineString",coordinates:[t||r.apply(this,arguments),e||u.apply(this,arguments)]}}var t,e,r=mr,u=yr;return n.distance=function(){return ta.geo.distance(t||r.apply(this,arguments),e||u.apply(this,arguments))},n.source=function(e){return arguments.length?(r=e,t="function"==typeof e?null:e,n):r},n.target=function(t){return arguments.length?(u=t,e="function"==typeof t?null:t,n):u},n.precision=function(){return arguments.length?n:0},n},ta.geo.interpolate=function(n,t){return Mr(n[0]*Da,n[1]*Da,t[0]*Da,t[1]*Da)},ta.geo.length=function(n){return Yc=0,ta.geo.stream(n,Zc),Yc};var Yc,Zc={sphere:b,point:b,lineStart:xr,lineEnd:b,polygonStart:b,polygonEnd:b},Vc=br(function(n){return Math.sqrt(2/(1+n))},function(n){return 2*Math.asin(n/2)});(ta.geo.azimuthalEqualArea=function(){return ur(Vc)}).raw=Vc;var Xc=br(function(n){var t=Math.acos(n);return t&&t/Math.sin(t)},y);(ta.geo.azimuthalEquidistant=function(){return ur(Xc)}).raw=Xc,(ta.geo.conicConformal=function(){return Ye(_r)}).raw=_r,(ta.geo.conicEquidistant=function(){return Ye(wr)}).raw=wr;var $c=br(function(n){return 1/n},Math.atan);(ta.geo.gnomonic=function(){return ur($c)}).raw=$c,Sr.invert=function(n,t){return[n,2*Math.atan(Math.exp(t))-Ra]},(ta.geo.mercator=function(){return kr(Sr)}).raw=Sr;var Bc=br(function(){return 1},Math.asin);(ta.geo.orthographic=function(){return ur(Bc)}).raw=Bc;var Wc=br(function(n){return 1/(1+n)},function(n){return 2*Math.atan(n)});(ta.geo.stereographic=function(){return ur(Wc)}).raw=Wc,Er.invert=function(n,t){return[-t,2*Math.atan(Math.exp(n))-Ra]},(ta.geo.transverseMercator=function(){var n=kr(Er),t=n.center,e=n.rotate;return n.center=function(n){return n?t([-n[1],n[0]]):(n=t(),[n[1],-n[0]])},n.rotate=function(n){return n?e([n[0],n[1],n.length>2?n[2]+90:90]):(n=e(),[n[0],n[1],n[2]-90])},e([0,0,90])}).raw=Er,ta.geom={},ta.geom.hull=function(n){function t(n){if(n.length<3)return[];var t,u=Et(e),i=Et(r),o=n.length,a=[],c=[];for(t=0;o>t;t++)a.push([+u.call(this,n[t],t),+i.call(this,n[t],t),t]);for(a.sort(zr),t=0;o>t;t++)c.push([a[t][0],-a[t][1]]);var l=Cr(a),s=Cr(c),f=s[0]===l[0],h=s[s.length-1]===l[l.length-1],g=[];for(t=l.length-1;t>=0;--t)g.push(n[a[l[t]][2]]);for(t=+f;t<s.length-h;++t)g.push(n[a[s[t]][2]]);return g}var e=Ar,r=Nr;return arguments.length?t(n):(t.x=function(n){return arguments.length?(e=n,t):e},t.y=function(n){return arguments.length?(r=n,t):r},t)},ta.geom.polygon=function(n){return ya(n,Jc),n};var Jc=ta.geom.polygon.prototype=[];Jc.area=function(){for(var n,t=-1,e=this.length,r=this[e-1],u=0;++t<e;)n=r,r=this[t],u+=n[1]*r[0]-n[0]*r[1];return.5*u},Jc.centroid=function(n){var t,e,r=-1,u=this.length,i=0,o=0,a=this[u-1];for(arguments.length||(n=-1/(6*this.area()));++r<u;)t=a,a=this[r],e=t[0]*a[1]-a[0]*t[1],i+=(t[0]+a[0])*e,o+=(t[1]+a[1])*e;return[i*n,o*n]},Jc.clip=function(n){for(var t,e,r,u,i,o,a=Tr(n),c=-1,l=this.length-Tr(this),s=this[l-1];++c<l;){for(t=n.slice(),n.length=0,u=this[c],i=t[(r=t.length-a)-1],e=-1;++e<r;)o=t[e],qr(o,s,u)?(qr(i,s,u)||n.push(Lr(i,o,s,u)),n.push(o)):qr(i,s,u)&&n.push(Lr(i,o,s,u)),i=o;a&&n.push(n[0]),s=u}return n};var Gc,Kc,Qc,nl,tl,el=[],rl=[];Or.prototype.prepare=function(){for(var n,t=this.edges,e=t.length;e--;)n=t[e].edge,n.b&&n.a||t.splice(e,1);return t.sort(Yr),t.length},Qr.prototype={start:function(){return this.edge.l===this.site?this.edge.a:this.edge.b},end:function(){return this.edge.l===this.site?this.edge.b:this.edge.a}},nu.prototype={insert:function(n,t){var e,r,u;if(n){if(t.P=n,t.N=n.N,n.N&&(n.N.P=t),n.N=t,n.R){for(n=n.R;n.L;)n=n.L;n.L=t}else n.R=t;e=n}else this._?(n=uu(this._),t.P=null,t.N=n,n.P=n.L=t,e=n):(t.P=t.N=null,this._=t,e=null);for(t.L=t.R=null,t.U=e,t.C=!0,n=t;e&&e.C;)r=e.U,e===r.L?(u=r.R,u&&u.C?(e.C=u.C=!1,r.C=!0,n=r):(n===e.R&&(eu(this,e),n=e,e=n.U),e.C=!1,r.C=!0,ru(this,r))):(u=r.L,u&&u.C?(e.C=u.C=!1,r.C=!0,n=r):(n===e.L&&(ru(this,e),n=e,e=n.U),e.C=!1,r.C=!0,eu(this,r))),e=n.U;this._.C=!1},remove:function(n){n.N&&(n.N.P=n.P),n.P&&(n.P.N=n.N),n.N=n.P=null;var t,e,r,u=n.U,i=n.L,o=n.R;if(e=i?o?uu(o):i:o,u?u.L===n?u.L=e:u.R=e:this._=e,i&&o?(r=e.C,e.C=n.C,e.L=i,i.U=e,e!==o?(u=e.U,e.U=n.U,n=e.R,u.L=n,e.R=o,o.U=e):(e.U=u,u=e,n=e.R)):(r=n.C,n=e),n&&(n.U=u),!r){if(n&&n.C)return void(n.C=!1);do{if(n===this._)break;if(n===u.L){if(t=u.R,t.C&&(t.C=!1,u.C=!0,eu(this,u),t=u.R),t.L&&t.L.C||t.R&&t.R.C){t.R&&t.R.C||(t.L.C=!1,t.C=!0,ru(this,t),t=u.R),t.C=u.C,u.C=t.R.C=!1,eu(this,u),n=this._;break}}else if(t=u.L,t.C&&(t.C=!1,u.C=!0,ru(this,u),t=u.L),t.L&&t.L.C||t.R&&t.R.C){t.L&&t.L.C||(t.R.C=!1,t.C=!0,eu(this,t),t=u.L),t.C=u.C,u.C=t.L.C=!1,ru(this,u),n=this._;break}t.C=!0,n=u,u=u.U}while(!n.C);n&&(n.C=!1)}}},ta.geom.voronoi=function(n){function t(n){var t=new Array(n.length),r=a[0][0],u=a[0][1],i=a[1][0],o=a[1][1];return iu(e(n),a).cells.forEach(function(e,a){var c=e.edges,l=e.site,s=t[a]=c.length?c.map(function(n){var t=n.start();return[t.x,t.y]}):l.x>=r&&l.x<=i&&l.y>=u&&l.y<=o?[[r,o],[i,o],[i,u],[r,u]]:[];s.point=n[a]}),t}function e(n){return n.map(function(n,t){return{x:Math.round(i(n,t)/Ca)*Ca,y:Math.round(o(n,t)/Ca)*Ca,i:t}})}var r=Ar,u=Nr,i=r,o=u,a=ul;return n?t(n):(t.links=function(n){return iu(e(n)).edges.filter(function(n){return n.l&&n.r}).map(function(t){return{source:n[t.l.i],target:n[t.r.i]}})},t.triangles=function(n){var t=[];return iu(e(n)).cells.forEach(function(e,r){for(var u,i,o=e.site,a=e.edges.sort(Yr),c=-1,l=a.length,s=a[l-1].edge,f=s.l===o?s.r:s.l;++c<l;)u=s,i=f,s=a[c].edge,f=s.l===o?s.r:s.l,r<i.i&&r<f.i&&au(o,i,f)<0&&t.push([n[r],n[i.i],n[f.i]])}),t},t.x=function(n){return arguments.length?(i=Et(r=n),t):r},t.y=function(n){return arguments.length?(o=Et(u=n),t):u},t.clipExtent=function(n){return arguments.length?(a=null==n?ul:n,t):a===ul?null:a},t.size=function(n){return arguments.length?t.clipExtent(n&&[[0,0],n]):a===ul?null:a&&a[1]},t)};var ul=[[-1e6,-1e6],[1e6,1e6]];ta.geom.delaunay=function(n){return ta.geom.voronoi().triangles(n)},ta.geom.quadtree=function(n,t,e,r,u){function i(n){function i(n,t,e,r,u,i,o,a){if(!isNaN(e)&&!isNaN(r))if(n.leaf){var c=n.x,s=n.y;if(null!=c)if(ga(c-e)+ga(s-r)<.01)l(n,t,e,r,u,i,o,a);else{var f=n.point;n.x=n.y=n.point=null,l(n,f,c,s,u,i,o,a),l(n,t,e,r,u,i,o,a)}else n.x=e,n.y=r,n.point=t}else l(n,t,e,r,u,i,o,a)}function l(n,t,e,r,u,o,a,c){var l=.5*(u+a),s=.5*(o+c),f=e>=l,h=r>=s,g=h<<1|f;n.leaf=!1,n=n.nodes[g]||(n.nodes[g]=su()),f?u=l:a=l,h?o=s:c=s,i(n,t,e,r,u,o,a,c)}var s,f,h,g,p,v,d,m,y,M=Et(a),x=Et(c);if(null!=t)v=t,d=e,m=r,y=u;else if(m=y=-(v=d=1/0),f=[],h=[],p=n.length,o)for(g=0;p>g;++g)s=n[g],s.x<v&&(v=s.x),s.y<d&&(d=s.y),s.x>m&&(m=s.x),s.y>y&&(y=s.y),f.push(s.x),h.push(s.y);else for(g=0;p>g;++g){var b=+M(s=n[g],g),_=+x(s,g);v>b&&(v=b),d>_&&(d=_),b>m&&(m=b),_>y&&(y=_),f.push(b),h.push(_)}var w=m-v,S=y-d;w>S?y=d+w:m=v+S;var k=su();if(k.add=function(n){i(k,n,+M(n,++g),+x(n,g),v,d,m,y)},k.visit=function(n){fu(n,k,v,d,m,y)},k.find=function(n){return hu(k,n[0],n[1],v,d,m,y)},g=-1,null==t){for(;++g<p;)i(k,n[g],f[g],h[g],v,d,m,y);--g}else n.forEach(k.add);return f=h=n=s=null,k}var o,a=Ar,c=Nr;return(o=arguments.length)?(a=cu,c=lu,3===o&&(u=e,r=t,e=t=0),i(n)):(i.x=function(n){return arguments.length?(a=n,i):a},i.y=function(n){return arguments.length?(c=n,i):c},i.extent=function(n){return arguments.length?(null==n?t=e=r=u=null:(t=+n[0][0],e=+n[0][1],r=+n[1][0],u=+n[1][1]),i):null==t?null:[[t,e],[r,u]]},i.size=function(n){return arguments.length?(null==n?t=e=r=u=null:(t=e=0,r=+n[0],u=+n[1]),i):null==t?null:[r-t,u-e]},i)},ta.interpolateRgb=gu,ta.interpolateObject=pu,ta.interpolateNumber=vu,ta.interpolateString=du;var il=/[-+]?(?:\d+\.?\d*|\.?\d+)(?:[eE][-+]?\d+)?/g,ol=new RegExp(il.source,"g");ta.interpolate=mu,ta.interpolators=[function(n,t){var e=typeof t;return("string"===e?Ga.has(t)||/^(#|rgb\(|hsl\()/.test(t)?gu:du:t instanceof ot?gu:Array.isArray(t)?yu:"object"===e&&isNaN(t)?pu:vu)(n,t)}],ta.interpolateArray=yu;var al=function(){return y},cl=ta.map({linear:al,poly:ku,quad:function(){return _u},cubic:function(){return wu},sin:function(){return Eu},exp:function(){return Au},circle:function(){return Nu},elastic:Cu,back:zu,bounce:function(){return qu}}),ll=ta.map({"in":y,out:xu,"in-out":bu,"out-in":function(n){return bu(xu(n))}});ta.ease=function(n){var t=n.indexOf("-"),e=t>=0?n.slice(0,t):n,r=t>=0?n.slice(t+1):"in";return e=cl.get(e)||al,r=ll.get(r)||y,Mu(r(e.apply(null,ea.call(arguments,1))))},ta.interpolateHcl=Lu,ta.interpolateHsl=Tu,ta.interpolateLab=Ru,ta.interpolateRound=Du,ta.transform=function(n){var t=ua.createElementNS(ta.ns.prefix.svg,"g");return(ta.transform=function(n){if(null!=n){t.setAttribute("transform",n);var e=t.transform.baseVal.consolidate()}return new Pu(e?e.matrix:sl)})(n)},Pu.prototype.toString=function(){return"translate("+this.translate+")rotate("+this.rotate+")skewX("+this.skew+")scale("+this.scale+")"};var sl={a:1,b:0,c:0,d:1,e:0,f:0};ta.interpolateTransform=Hu,ta.layout={},ta.layout.bundle=function(){return function(n){for(var t=[],e=-1,r=n.length;++e<r;)t.push(Yu(n[e]));return t}},ta.layout.chord=function(){function n(){var n,l,f,h,g,p={},v=[],d=ta.range(i),m=[];for(e=[],r=[],n=0,h=-1;++h<i;){for(l=0,g=-1;++g<i;)l+=u[h][g];v.push(l),m.push(ta.range(i)),n+=l}for(o&&d.sort(function(n,t){return o(v[n],v[t])}),a&&m.forEach(function(n,t){n.sort(function(n,e){return a(u[t][n],u[t][e])})}),n=(La-s*i)/n,l=0,h=-1;++h<i;){for(f=l,g=-1;++g<i;){var y=d[h],M=m[y][g],x=u[y][M],b=l,_=l+=x*n;p[y+"-"+M]={index:y,subindex:M,startAngle:b,endAngle:_,value:x}}r[y]={index:y,startAngle:f,endAngle:l,value:(l-f)/n},l+=s}for(h=-1;++h<i;)for(g=h-1;++g<i;){var w=p[h+"-"+g],S=p[g+"-"+h];(w.value||S.value)&&e.push(w.value<S.value?{source:S,target:w}:{source:w,target:S})}c&&t()}function t(){e.sort(function(n,t){return c((n.source.value+n.target.value)/2,(t.source.value+t.target.value)/2)})}var e,r,u,i,o,a,c,l={},s=0;return l.matrix=function(n){return arguments.length?(i=(u=n)&&u.length,e=r=null,l):u},l.padding=function(n){return arguments.length?(s=n,e=r=null,l):s},l.sortGroups=function(n){return arguments.length?(o=n,e=r=null,l):o},l.sortSubgroups=function(n){return arguments.length?(a=n,e=null,l):a},l.sortChords=function(n){return arguments.length?(c=n,e&&t(),l):c},l.chords=function(){return e||n(),e},l.groups=function(){return r||n(),r},l},ta.layout.force=function(){function n(n){return function(t,e,r,u){if(t.point!==n){var i=t.cx-n.x,o=t.cy-n.y,a=u-e,c=i*i+o*o;if(c>a*a/d){if(p>c){var l=t.charge/c;n.px-=i*l,n.py-=o*l}return!0}if(t.point&&c&&p>c){var l=t.pointCharge/c;n.px-=i*l,n.py-=o*l}}return!t.charge}}function t(n){n.px=ta.event.x,n.py=ta.event.y,a.resume()}var e,r,u,i,o,a={},c=ta.dispatch("start","tick","end"),l=[1,1],s=.9,f=fl,h=hl,g=-30,p=gl,v=.1,d=.64,m=[],M=[];return a.tick=function(){if((r*=.99)<.005)return c.end({type:"end",alpha:r=0}),!0;var t,e,a,f,h,p,d,y,x,b=m.length,_=M.length;for(e=0;_>e;++e)a=M[e],f=a.source,h=a.target,y=h.x-f.x,x=h.y-f.y,(p=y*y+x*x)&&(p=r*i[e]*((p=Math.sqrt(p))-u[e])/p,y*=p,x*=p,h.x-=y*(d=f.weight/(h.weight+f.weight)),h.y-=x*d,f.x+=y*(d=1-d),f.y+=x*d);if((d=r*v)&&(y=l[0]/2,x=l[1]/2,e=-1,d))for(;++e<b;)a=m[e],a.x+=(y-a.x)*d,a.y+=(x-a.y)*d;if(g)for(Ju(t=ta.geom.quadtree(m),r,o),e=-1;++e<b;)(a=m[e]).fixed||t.visit(n(a));for(e=-1;++e<b;)a=m[e],a.fixed?(a.x=a.px,a.y=a.py):(a.x-=(a.px-(a.px=a.x))*s,a.y-=(a.py-(a.py=a.y))*s);c.tick({type:"tick",alpha:r})},a.nodes=function(n){return arguments.length?(m=n,a):m},a.links=function(n){return arguments.length?(M=n,a):M},a.size=function(n){return arguments.length?(l=n,a):l},a.linkDistance=function(n){return arguments.length?(f="function"==typeof n?n:+n,a):f},a.distance=a.linkDistance,a.linkStrength=function(n){return arguments.length?(h="function"==typeof n?n:+n,a):h},a.friction=function(n){return arguments.length?(s=+n,a):s},a.charge=function(n){return arguments.length?(g="function"==typeof n?n:+n,a):g},a.chargeDistance=function(n){return arguments.length?(p=n*n,a):Math.sqrt(p)},a.gravity=function(n){return arguments.length?(v=+n,a):v},a.theta=function(n){return arguments.length?(d=n*n,a):Math.sqrt(d)},a.alpha=function(n){return arguments.length?(n=+n,r?r=n>0?n:0:n>0&&(c.start({type:"start",alpha:r=n}),ta.timer(a.tick)),a):r},a.start=function(){function n(n,r){if(!e){for(e=new Array(c),a=0;c>a;++a)e[a]=[];for(a=0;s>a;++a){var u=M[a];e[u.source.index].push(u.target),e[u.target.index].push(u.source)}}for(var i,o=e[t],a=-1,l=o.length;++a<l;)if(!isNaN(i=o[a][n]))return i;return Math.random()*r}var t,e,r,c=m.length,s=M.length,p=l[0],v=l[1];for(t=0;c>t;++t)(r=m[t]).index=t,r.weight=0;for(t=0;s>t;++t)r=M[t],"number"==typeof r.source&&(r.source=m[r.source]),"number"==typeof r.target&&(r.target=m[r.target]),++r.source.weight,++r.target.weight;for(t=0;c>t;++t)r=m[t],isNaN(r.x)&&(r.x=n("x",p)),isNaN(r.y)&&(r.y=n("y",v)),isNaN(r.px)&&(r.px=r.x),isNaN(r.py)&&(r.py=r.y);if(u=[],"function"==typeof f)for(t=0;s>t;++t)u[t]=+f.call(this,M[t],t);else for(t=0;s>t;++t)u[t]=f;if(i=[],"function"==typeof h)for(t=0;s>t;++t)i[t]=+h.call(this,M[t],t);else for(t=0;s>t;++t)i[t]=h;if(o=[],"function"==typeof g)for(t=0;c>t;++t)o[t]=+g.call(this,m[t],t);else for(t=0;c>t;++t)o[t]=g;return a.resume()},a.resume=function(){return a.alpha(.1)},a.stop=function(){return a.alpha(0)},a.drag=function(){return e||(e=ta.behavior.drag().origin(y).on("dragstart.force",Xu).on("drag.force",t).on("dragend.force",$u)),arguments.length?void this.on("mouseover.force",Bu).on("mouseout.force",Wu).call(e):e},ta.rebind(a,c,"on")};var fl=20,hl=1,gl=1/0;ta.layout.hierarchy=function(){function n(u){var i,o=[u],a=[];for(u.depth=0;null!=(i=o.pop());)if(a.push(i),(l=e.call(n,i,i.depth))&&(c=l.length)){for(var c,l,s;--c>=0;)o.push(s=l[c]),s.parent=i,s.depth=i.depth+1;r&&(i.value=0),i.children=l}else r&&(i.value=+r.call(n,i,i.depth)||0),delete i.children;return Qu(u,function(n){var e,u;t&&(e=n.children)&&e.sort(t),r&&(u=n.parent)&&(u.value+=n.value)}),a}var t=ei,e=ni,r=ti;return n.sort=function(e){return arguments.length?(t=e,n):t},n.children=function(t){return arguments.length?(e=t,n):e},n.value=function(t){return arguments.length?(r=t,n):r},n.revalue=function(t){return r&&(Ku(t,function(n){n.children&&(n.value=0)}),Qu(t,function(t){var e;t.children||(t.value=+r.call(n,t,t.depth)||0),(e=t.parent)&&(e.value+=t.value)})),t},n},ta.layout.partition=function(){function n(t,e,r,u){var i=t.children;if(t.x=e,t.y=t.depth*u,t.dx=r,t.dy=u,i&&(o=i.length)){var o,a,c,l=-1;for(r=t.value?r/t.value:0;++l<o;)n(a=i[l],e,c=a.value*r,u),e+=c}}function t(n){var e=n.children,r=0;if(e&&(u=e.length))for(var u,i=-1;++i<u;)r=Math.max(r,t(e[i]));return 1+r}function e(e,i){var o=r.call(this,e,i);return n(o[0],0,u[0],u[1]/t(o[0])),o}var r=ta.layout.hierarchy(),u=[1,1];return e.size=function(n){return arguments.length?(u=n,e):u},Gu(e,r)},ta.layout.pie=function(){function n(o){var a,c=o.length,l=o.map(function(e,r){return+t.call(n,e,r)}),s=+("function"==typeof r?r.apply(this,arguments):r),f=("function"==typeof u?u.apply(this,arguments):u)-s,h=Math.min(Math.abs(f)/c,+("function"==typeof i?i.apply(this,arguments):i)),g=h*(0>f?-1:1),p=(f-c*g)/ta.sum(l),v=ta.range(c),d=[];return null!=e&&v.sort(e===pl?function(n,t){return l[t]-l[n]}:function(n,t){return e(o[n],o[t])}),v.forEach(function(n){d[n]={data:o[n],value:a=l[n],startAngle:s,endAngle:s+=a*p+g,padAngle:h}}),d}var t=Number,e=pl,r=0,u=La,i=0;return n.value=function(e){return arguments.length?(t=e,n):t},n.sort=function(t){return arguments.length?(e=t,n):e},n.startAngle=function(t){return arguments.length?(r=t,n):r},n.endAngle=function(t){return arguments.length?(u=t,n):u},n.padAngle=function(t){return arguments.length?(i=t,n):i},n};var pl={};ta.layout.stack=function(){function n(a,c){if(!(h=a.length))return a;var l=a.map(function(e,r){return t.call(n,e,r)}),s=l.map(function(t){return t.map(function(t,e){return[i.call(n,t,e),o.call(n,t,e)]})}),f=e.call(n,s,c);l=ta.permute(l,f),s=ta.permute(s,f);var h,g,p,v,d=r.call(n,s,c),m=l[0].length;for(p=0;m>p;++p)for(u.call(n,l[0][p],v=d[p],s[0][p][1]),g=1;h>g;++g)u.call(n,l[g][p],v+=s[g-1][p][1],s[g][p][1]);return a}var t=y,e=ai,r=ci,u=oi,i=ui,o=ii;return n.values=function(e){return arguments.length?(t=e,n):t},n.order=function(t){return arguments.length?(e="function"==typeof t?t:vl.get(t)||ai,n):e},n.offset=function(t){return arguments.length?(r="function"==typeof t?t:dl.get(t)||ci,n):r},n.x=function(t){return arguments.length?(i=t,n):i},n.y=function(t){return arguments.length?(o=t,n):o},n.out=function(t){return arguments.length?(u=t,n):u},n};var vl=ta.map({"inside-out":function(n){var t,e,r=n.length,u=n.map(li),i=n.map(si),o=ta.range(r).sort(function(n,t){return u[n]-u[t]}),a=0,c=0,l=[],s=[];for(t=0;r>t;++t)e=o[t],c>a?(a+=i[e],l.push(e)):(c+=i[e],s.push(e));return s.reverse().concat(l)},reverse:function(n){return ta.range(n.length).reverse()},"default":ai}),dl=ta.map({silhouette:function(n){var t,e,r,u=n.length,i=n[0].length,o=[],a=0,c=[];for(e=0;i>e;++e){for(t=0,r=0;u>t;t++)r+=n[t][e][1];r>a&&(a=r),o.push(r)}for(e=0;i>e;++e)c[e]=(a-o[e])/2;return c},wiggle:function(n){var t,e,r,u,i,o,a,c,l,s=n.length,f=n[0],h=f.length,g=[];for(g[0]=c=l=0,e=1;h>e;++e){for(t=0,u=0;s>t;++t)u+=n[t][e][1];for(t=0,i=0,a=f[e][0]-f[e-1][0];s>t;++t){for(r=0,o=(n[t][e][1]-n[t][e-1][1])/(2*a);t>r;++r)o+=(n[r][e][1]-n[r][e-1][1])/a;i+=o*n[t][e][1]}g[e]=c-=u?i/u*a:0,l>c&&(l=c)}for(e=0;h>e;++e)g[e]-=l;return g},expand:function(n){var t,e,r,u=n.length,i=n[0].length,o=1/u,a=[];for(e=0;i>e;++e){for(t=0,r=0;u>t;t++)r+=n[t][e][1];if(r)for(t=0;u>t;t++)n[t][e][1]/=r;else for(t=0;u>t;t++)n[t][e][1]=o}for(e=0;i>e;++e)a[e]=0;return a},zero:ci});ta.layout.histogram=function(){function n(n,i){for(var o,a,c=[],l=n.map(e,this),s=r.call(this,l,i),f=u.call(this,s,l,i),i=-1,h=l.length,g=f.length-1,p=t?1:1/h;++i<g;)o=c[i]=[],o.dx=f[i+1]-(o.x=f[i]),o.y=0;if(g>0)for(i=-1;++i<h;)a=l[i],a>=s[0]&&a<=s[1]&&(o=c[ta.bisect(f,a,1,g)-1],o.y+=p,o.push(n[i]));return c}var t=!0,e=Number,r=pi,u=hi;return n.value=function(t){return arguments.length?(e=t,n):e},n.range=function(t){return arguments.length?(r=Et(t),n):r},n.bins=function(t){return arguments.length?(u="number"==typeof t?function(n){return gi(n,t)}:Et(t),n):u},n.frequency=function(e){return arguments.length?(t=!!e,n):t},n},ta.layout.pack=function(){function n(n,i){var o=e.call(this,n,i),a=o[0],c=u[0],l=u[1],s=null==t?Math.sqrt:"function"==typeof t?t:function(){return t};if(a.x=a.y=0,Qu(a,function(n){n.r=+s(n.value)}),Qu(a,Mi),r){var f=r*(t?1:Math.max(2*a.r/c,2*a.r/l))/2;Qu(a,function(n){n.r+=f}),Qu(a,Mi),Qu(a,function(n){n.r-=f})}return _i(a,c/2,l/2,t?1:1/Math.max(2*a.r/c,2*a.r/l)),o}var t,e=ta.layout.hierarchy().sort(vi),r=0,u=[1,1];return n.size=function(t){return arguments.length?(u=t,n):u},n.radius=function(e){return arguments.length?(t=null==e||"function"==typeof e?e:+e,n):t},n.padding=function(t){return arguments.length?(r=+t,n):r},Gu(n,e)},ta.layout.tree=function(){function n(n,u){var s=o.call(this,n,u),f=s[0],h=t(f);if(Qu(h,e),h.parent.m=-h.z,Ku(h,r),l)Ku(f,i);else{var g=f,p=f,v=f;Ku(f,function(n){n.x<g.x&&(g=n),n.x>p.x&&(p=n),n.depth>v.depth&&(v=n)});var d=a(g,p)/2-g.x,m=c[0]/(p.x+a(p,g)/2+d),y=c[1]/(v.depth||1);Ku(f,function(n){n.x=(n.x+d)*m,n.y=n.depth*y})}return s}function t(n){for(var t,e={A:null,children:[n]},r=[e];null!=(t=r.pop());)for(var u,i=t.children,o=0,a=i.length;a>o;++o)r.push((i[o]=u={_:i[o],parent:t,children:(u=i[o].children)&&u.slice()||[],A:null,a:null,z:0,m:0,c:0,s:0,t:null,i:o}).a=u);return e.children[0]}function e(n){var t=n.children,e=n.parent.children,r=n.i?e[n.i-1]:null;if(t.length){Ni(n);var i=(t[0].z+t[t.length-1].z)/2;r?(n.z=r.z+a(n._,r._),n.m=n.z-i):n.z=i}else r&&(n.z=r.z+a(n._,r._));n.parent.A=u(n,r,n.parent.A||e[0])}function r(n){n._.x=n.z+n.parent.m,n.m+=n.parent.m}function u(n,t,e){if(t){for(var r,u=n,i=n,o=t,c=u.parent.children[0],l=u.m,s=i.m,f=o.m,h=c.m;o=Ei(o),u=ki(u),o&&u;)c=ki(c),i=Ei(i),i.a=n,r=o.z+f-u.z-l+a(o._,u._),r>0&&(Ai(Ci(o,n,e),n,r),l+=r,s+=r),f+=o.m,l+=u.m,h+=c.m,s+=i.m;o&&!Ei(i)&&(i.t=o,i.m+=f-s),u&&!ki(c)&&(c.t=u,c.m+=l-h,e=n)}return e}function i(n){n.x*=c[0],n.y=n.depth*c[1]}var o=ta.layout.hierarchy().sort(null).value(null),a=Si,c=[1,1],l=null;return n.separation=function(t){return arguments.length?(a=t,n):a},n.size=function(t){return arguments.length?(l=null==(c=t)?i:null,n):l?null:c},n.nodeSize=function(t){return arguments.length?(l=null==(c=t)?null:i,n):l?c:null},Gu(n,o)},ta.layout.cluster=function(){function n(n,i){var o,a=t.call(this,n,i),c=a[0],l=0;Qu(c,function(n){var t=n.children;t&&t.length?(n.x=qi(t),n.y=zi(t)):(n.x=o?l+=e(n,o):0,n.y=0,o=n)});var s=Li(c),f=Ti(c),h=s.x-e(s,f)/2,g=f.x+e(f,s)/2;return Qu(c,u?function(n){n.x=(n.x-c.x)*r[0],n.y=(c.y-n.y)*r[1]}:function(n){n.x=(n.x-h)/(g-h)*r[0],n.y=(1-(c.y?n.y/c.y:1))*r[1]}),a}var t=ta.layout.hierarchy().sort(null).value(null),e=Si,r=[1,1],u=!1;return n.separation=function(t){return arguments.length?(e=t,n):e},n.size=function(t){return arguments.length?(u=null==(r=t),n):u?null:r},n.nodeSize=function(t){return arguments.length?(u=null!=(r=t),n):u?r:null},Gu(n,t)},ta.layout.treemap=function(){function n(n,t){for(var e,r,u=-1,i=n.length;++u<i;)r=(e=n[u]).value*(0>t?0:t),e.area=isNaN(r)||0>=r?0:r}function t(e){var i=e.children;if(i&&i.length){var o,a,c,l=f(e),s=[],h=i.slice(),p=1/0,v="slice"===g?l.dx:"dice"===g?l.dy:"slice-dice"===g?1&e.depth?l.dy:l.dx:Math.min(l.dx,l.dy);for(n(h,l.dx*l.dy/e.value),s.area=0;(c=h.length)>0;)s.push(o=h[c-1]),s.area+=o.area,"squarify"!==g||(a=r(s,v))<=p?(h.pop(),p=a):(s.area-=s.pop().area,u(s,v,l,!1),v=Math.min(l.dx,l.dy),s.length=s.area=0,p=1/0);s.length&&(u(s,v,l,!0),s.length=s.area=0),i.forEach(t)}}function e(t){var r=t.children;if(r&&r.length){var i,o=f(t),a=r.slice(),c=[];for(n(a,o.dx*o.dy/t.value),c.area=0;i=a.pop();)c.push(i),c.area+=i.area,null!=i.z&&(u(c,i.z?o.dx:o.dy,o,!a.length),c.length=c.area=0);r.forEach(e)}}function r(n,t){for(var e,r=n.area,u=0,i=1/0,o=-1,a=n.length;++o<a;)(e=n[o].area)&&(i>e&&(i=e),e>u&&(u=e));return r*=r,t*=t,r?Math.max(t*u*p/r,r/(t*i*p)):1/0}function u(n,t,e,r){var u,i=-1,o=n.length,a=e.x,l=e.y,s=t?c(n.area/t):0;if(t==e.dx){for((r||s>e.dy)&&(s=e.dy);++i<o;)u=n[i],u.x=a,u.y=l,u.dy=s,a+=u.dx=Math.min(e.x+e.dx-a,s?c(u.area/s):0);u.z=!0,u.dx+=e.x+e.dx-a,e.y+=s,e.dy-=s}else{for((r||s>e.dx)&&(s=e.dx);++i<o;)u=n[i],u.x=a,u.y=l,u.dx=s,l+=u.dy=Math.min(e.y+e.dy-l,s?c(u.area/s):0);u.z=!1,u.dy+=e.y+e.dy-l,e.x+=s,e.dx-=s}}function i(r){var u=o||a(r),i=u[0];return i.x=0,i.y=0,i.dx=l[0],i.dy=l[1],o&&a.revalue(i),n([i],i.dx*i.dy/i.value),(o?e:t)(i),h&&(o=u),u}var o,a=ta.layout.hierarchy(),c=Math.round,l=[1,1],s=null,f=Ri,h=!1,g="squarify",p=.5*(1+Math.sqrt(5));
return i.size=function(n){return arguments.length?(l=n,i):l},i.padding=function(n){function t(t){var e=n.call(i,t,t.depth);return null==e?Ri(t):Di(t,"number"==typeof e?[e,e,e,e]:e)}function e(t){return Di(t,n)}if(!arguments.length)return s;var r;return f=null==(s=n)?Ri:"function"==(r=typeof n)?t:"number"===r?(n=[n,n,n,n],e):e,i},i.round=function(n){return arguments.length?(c=n?Math.round:Number,i):c!=Number},i.sticky=function(n){return arguments.length?(h=n,o=null,i):h},i.ratio=function(n){return arguments.length?(p=n,i):p},i.mode=function(n){return arguments.length?(g=n+"",i):g},Gu(i,a)},ta.random={normal:function(n,t){var e=arguments.length;return 2>e&&(t=1),1>e&&(n=0),function(){var e,r,u;do e=2*Math.random()-1,r=2*Math.random()-1,u=e*e+r*r;while(!u||u>1);return n+t*e*Math.sqrt(-2*Math.log(u)/u)}},logNormal:function(){var n=ta.random.normal.apply(ta,arguments);return function(){return Math.exp(n())}},bates:function(n){var t=ta.random.irwinHall(n);return function(){return t()/n}},irwinHall:function(n){return function(){for(var t=0,e=0;n>e;e++)t+=Math.random();return t}}},ta.scale={};var ml={floor:y,ceil:y};ta.scale.linear=function(){return Ii([0,1],[0,1],mu,!1)};var yl={s:1,g:1,p:1,r:1,e:1};ta.scale.log=function(){return Ji(ta.scale.linear().domain([0,1]),10,!0,[1,10])};var Ml=ta.format(".0e"),xl={floor:function(n){return-Math.ceil(-n)},ceil:function(n){return-Math.floor(-n)}};ta.scale.pow=function(){return Gi(ta.scale.linear(),1,[0,1])},ta.scale.sqrt=function(){return ta.scale.pow().exponent(.5)},ta.scale.ordinal=function(){return Qi([],{t:"range",a:[[]]})},ta.scale.category10=function(){return ta.scale.ordinal().range(bl)},ta.scale.category20=function(){return ta.scale.ordinal().range(_l)},ta.scale.category20b=function(){return ta.scale.ordinal().range(wl)},ta.scale.category20c=function(){return ta.scale.ordinal().range(Sl)};var bl=[2062260,16744206,2924588,14034728,9725885,9197131,14907330,8355711,12369186,1556175].map(Mt),_l=[2062260,11454440,16744206,16759672,2924588,10018698,14034728,16750742,9725885,12955861,9197131,12885140,14907330,16234194,8355711,13092807,12369186,14408589,1556175,10410725].map(Mt),wl=[3750777,5395619,7040719,10264286,6519097,9216594,11915115,13556636,9202993,12426809,15186514,15190932,8666169,11356490,14049643,15177372,8077683,10834324,13528509,14589654].map(Mt),Sl=[3244733,7057110,10406625,13032431,15095053,16616764,16625259,16634018,3253076,7652470,10607003,13101504,7695281,10394312,12369372,14342891,6513507,9868950,12434877,14277081].map(Mt);ta.scale.quantile=function(){return no([],[])},ta.scale.quantize=function(){return to(0,1,[0,1])},ta.scale.threshold=function(){return eo([.5],[0,1])},ta.scale.identity=function(){return ro([0,1])},ta.svg={},ta.svg.arc=function(){function n(){var n=Math.max(0,+e.apply(this,arguments)),l=Math.max(0,+r.apply(this,arguments)),s=o.apply(this,arguments)-Ra,f=a.apply(this,arguments)-Ra,h=Math.abs(f-s),g=s>f?0:1;if(n>l&&(p=l,l=n,n=p),h>=Ta)return t(l,g)+(n?t(n,1-g):"")+"Z";var p,v,d,m,y,M,x,b,_,w,S,k,E=0,A=0,N=[];if((m=(+c.apply(this,arguments)||0)/2)&&(d=i===kl?Math.sqrt(n*n+l*l):+i.apply(this,arguments),g||(A*=-1),l&&(A=tt(d/l*Math.sin(m))),n&&(E=tt(d/n*Math.sin(m)))),l){y=l*Math.cos(s+A),M=l*Math.sin(s+A),x=l*Math.cos(f-A),b=l*Math.sin(f-A);var C=Math.abs(f-s-2*A)<=qa?0:1;if(A&&so(y,M,x,b)===g^C){var z=(s+f)/2;y=l*Math.cos(z),M=l*Math.sin(z),x=b=null}}else y=M=0;if(n){_=n*Math.cos(f-E),w=n*Math.sin(f-E),S=n*Math.cos(s+E),k=n*Math.sin(s+E);var q=Math.abs(s-f+2*E)<=qa?0:1;if(E&&so(_,w,S,k)===1-g^q){var L=(s+f)/2;_=n*Math.cos(L),w=n*Math.sin(L),S=k=null}}else _=w=0;if((p=Math.min(Math.abs(l-n)/2,+u.apply(this,arguments)))>.001){v=l>n^g?0:1;var T=null==S?[_,w]:null==x?[y,M]:Lr([y,M],[S,k],[x,b],[_,w]),R=y-T[0],D=M-T[1],P=x-T[0],U=b-T[1],j=1/Math.sin(Math.acos((R*P+D*U)/(Math.sqrt(R*R+D*D)*Math.sqrt(P*P+U*U)))/2),F=Math.sqrt(T[0]*T[0]+T[1]*T[1]);if(null!=x){var H=Math.min(p,(l-F)/(j+1)),O=fo(null==S?[_,w]:[S,k],[y,M],l,H,g),I=fo([x,b],[_,w],l,H,g);p===H?N.push("M",O[0],"A",H,",",H," 0 0,",v," ",O[1],"A",l,",",l," 0 ",1-g^so(O[1][0],O[1][1],I[1][0],I[1][1]),",",g," ",I[1],"A",H,",",H," 0 0,",v," ",I[0]):N.push("M",O[0],"A",H,",",H," 0 1,",v," ",I[0])}else N.push("M",y,",",M);if(null!=S){var Y=Math.min(p,(n-F)/(j-1)),Z=fo([y,M],[S,k],n,-Y,g),V=fo([_,w],null==x?[y,M]:[x,b],n,-Y,g);p===Y?N.push("L",V[0],"A",Y,",",Y," 0 0,",v," ",V[1],"A",n,",",n," 0 ",g^so(V[1][0],V[1][1],Z[1][0],Z[1][1]),",",1-g," ",Z[1],"A",Y,",",Y," 0 0,",v," ",Z[0]):N.push("L",V[0],"A",Y,",",Y," 0 0,",v," ",Z[0])}else N.push("L",_,",",w)}else N.push("M",y,",",M),null!=x&&N.push("A",l,",",l," 0 ",C,",",g," ",x,",",b),N.push("L",_,",",w),null!=S&&N.push("A",n,",",n," 0 ",q,",",1-g," ",S,",",k);return N.push("Z"),N.join("")}function t(n,t){return"M0,"+n+"A"+n+","+n+" 0 1,"+t+" 0,"+-n+"A"+n+","+n+" 0 1,"+t+" 0,"+n}var e=io,r=oo,u=uo,i=kl,o=ao,a=co,c=lo;return n.innerRadius=function(t){return arguments.length?(e=Et(t),n):e},n.outerRadius=function(t){return arguments.length?(r=Et(t),n):r},n.cornerRadius=function(t){return arguments.length?(u=Et(t),n):u},n.padRadius=function(t){return arguments.length?(i=t==kl?kl:Et(t),n):i},n.startAngle=function(t){return arguments.length?(o=Et(t),n):o},n.endAngle=function(t){return arguments.length?(a=Et(t),n):a},n.padAngle=function(t){return arguments.length?(c=Et(t),n):c},n.centroid=function(){var n=(+e.apply(this,arguments)+ +r.apply(this,arguments))/2,t=(+o.apply(this,arguments)+ +a.apply(this,arguments))/2-Ra;return[Math.cos(t)*n,Math.sin(t)*n]},n};var kl="auto";ta.svg.line=function(){return ho(y)};var El=ta.map({linear:go,"linear-closed":po,step:vo,"step-before":mo,"step-after":yo,basis:So,"basis-open":ko,"basis-closed":Eo,bundle:Ao,cardinal:bo,"cardinal-open":Mo,"cardinal-closed":xo,monotone:To});El.forEach(function(n,t){t.key=n,t.closed=/-closed$/.test(n)});var Al=[0,2/3,1/3,0],Nl=[0,1/3,2/3,0],Cl=[0,1/6,2/3,1/6];ta.svg.line.radial=function(){var n=ho(Ro);return n.radius=n.x,delete n.x,n.angle=n.y,delete n.y,n},mo.reverse=yo,yo.reverse=mo,ta.svg.area=function(){return Do(y)},ta.svg.area.radial=function(){var n=Do(Ro);return n.radius=n.x,delete n.x,n.innerRadius=n.x0,delete n.x0,n.outerRadius=n.x1,delete n.x1,n.angle=n.y,delete n.y,n.startAngle=n.y0,delete n.y0,n.endAngle=n.y1,delete n.y1,n},ta.svg.chord=function(){function n(n,a){var c=t(this,i,n,a),l=t(this,o,n,a);return"M"+c.p0+r(c.r,c.p1,c.a1-c.a0)+(e(c,l)?u(c.r,c.p1,c.r,c.p0):u(c.r,c.p1,l.r,l.p0)+r(l.r,l.p1,l.a1-l.a0)+u(l.r,l.p1,c.r,c.p0))+"Z"}function t(n,t,e,r){var u=t.call(n,e,r),i=a.call(n,u,r),o=c.call(n,u,r)-Ra,s=l.call(n,u,r)-Ra;return{r:i,a0:o,a1:s,p0:[i*Math.cos(o),i*Math.sin(o)],p1:[i*Math.cos(s),i*Math.sin(s)]}}function e(n,t){return n.a0==t.a0&&n.a1==t.a1}function r(n,t,e){return"A"+n+","+n+" 0 "+ +(e>qa)+",1 "+t}function u(n,t,e,r){return"Q 0,0 "+r}var i=mr,o=yr,a=Po,c=ao,l=co;return n.radius=function(t){return arguments.length?(a=Et(t),n):a},n.source=function(t){return arguments.length?(i=Et(t),n):i},n.target=function(t){return arguments.length?(o=Et(t),n):o},n.startAngle=function(t){return arguments.length?(c=Et(t),n):c},n.endAngle=function(t){return arguments.length?(l=Et(t),n):l},n},ta.svg.diagonal=function(){function n(n,u){var i=t.call(this,n,u),o=e.call(this,n,u),a=(i.y+o.y)/2,c=[i,{x:i.x,y:a},{x:o.x,y:a},o];return c=c.map(r),"M"+c[0]+"C"+c[1]+" "+c[2]+" "+c[3]}var t=mr,e=yr,r=Uo;return n.source=function(e){return arguments.length?(t=Et(e),n):t},n.target=function(t){return arguments.length?(e=Et(t),n):e},n.projection=function(t){return arguments.length?(r=t,n):r},n},ta.svg.diagonal.radial=function(){var n=ta.svg.diagonal(),t=Uo,e=n.projection;return n.projection=function(n){return arguments.length?e(jo(t=n)):t},n},ta.svg.symbol=function(){function n(n,r){return(zl.get(t.call(this,n,r))||Oo)(e.call(this,n,r))}var t=Ho,e=Fo;return n.type=function(e){return arguments.length?(t=Et(e),n):t},n.size=function(t){return arguments.length?(e=Et(t),n):e},n};var zl=ta.map({circle:Oo,cross:function(n){var t=Math.sqrt(n/5)/2;return"M"+-3*t+","+-t+"H"+-t+"V"+-3*t+"H"+t+"V"+-t+"H"+3*t+"V"+t+"H"+t+"V"+3*t+"H"+-t+"V"+t+"H"+-3*t+"Z"},diamond:function(n){var t=Math.sqrt(n/(2*Ll)),e=t*Ll;return"M0,"+-t+"L"+e+",0 0,"+t+" "+-e+",0Z"},square:function(n){var t=Math.sqrt(n)/2;return"M"+-t+","+-t+"L"+t+","+-t+" "+t+","+t+" "+-t+","+t+"Z"},"triangle-down":function(n){var t=Math.sqrt(n/ql),e=t*ql/2;return"M0,"+e+"L"+t+","+-e+" "+-t+","+-e+"Z"},"triangle-up":function(n){var t=Math.sqrt(n/ql),e=t*ql/2;return"M0,"+-e+"L"+t+","+e+" "+-t+","+e+"Z"}});ta.svg.symbolTypes=zl.keys();var ql=Math.sqrt(3),Ll=Math.tan(30*Da);_a.transition=function(n){for(var t,e,r=Tl||++Ul,u=Xo(n),i=[],o=Rl||{time:Date.now(),ease:Su,delay:0,duration:250},a=-1,c=this.length;++a<c;){i.push(t=[]);for(var l=this[a],s=-1,f=l.length;++s<f;)(e=l[s])&&$o(e,s,u,r,o),t.push(e)}return Yo(i,u,r)},_a.interrupt=function(n){return this.each(null==n?Dl:Io(Xo(n)))};var Tl,Rl,Dl=Io(Xo()),Pl=[],Ul=0;Pl.call=_a.call,Pl.empty=_a.empty,Pl.node=_a.node,Pl.size=_a.size,ta.transition=function(n,t){return n&&n.transition?Tl?n.transition(t):n:ta.selection().transition(n)},ta.transition.prototype=Pl,Pl.select=function(n){var t,e,r,u=this.id,i=this.namespace,o=[];n=N(n);for(var a=-1,c=this.length;++a<c;){o.push(t=[]);for(var l=this[a],s=-1,f=l.length;++s<f;)(r=l[s])&&(e=n.call(r,r.__data__,s,a))?("__data__"in r&&(e.__data__=r.__data__),$o(e,s,i,u,r[i][u]),t.push(e)):t.push(null)}return Yo(o,i,u)},Pl.selectAll=function(n){var t,e,r,u,i,o=this.id,a=this.namespace,c=[];n=C(n);for(var l=-1,s=this.length;++l<s;)for(var f=this[l],h=-1,g=f.length;++h<g;)if(r=f[h]){i=r[a][o],e=n.call(r,r.__data__,h,l),c.push(t=[]);for(var p=-1,v=e.length;++p<v;)(u=e[p])&&$o(u,p,a,o,i),t.push(u)}return Yo(c,a,o)},Pl.filter=function(n){var t,e,r,u=[];"function"!=typeof n&&(n=O(n));for(var i=0,o=this.length;o>i;i++){u.push(t=[]);for(var e=this[i],a=0,c=e.length;c>a;a++)(r=e[a])&&n.call(r,r.__data__,a,i)&&t.push(r)}return Yo(u,this.namespace,this.id)},Pl.tween=function(n,t){var e=this.id,r=this.namespace;return arguments.length<2?this.node()[r][e].tween.get(n):Y(this,null==t?function(t){t[r][e].tween.remove(n)}:function(u){u[r][e].tween.set(n,t)})},Pl.attr=function(n,t){function e(){this.removeAttribute(a)}function r(){this.removeAttributeNS(a.space,a.local)}function u(n){return null==n?e:(n+="",function(){var t,e=this.getAttribute(a);return e!==n&&(t=o(e,n),function(n){this.setAttribute(a,t(n))})})}function i(n){return null==n?r:(n+="",function(){var t,e=this.getAttributeNS(a.space,a.local);return e!==n&&(t=o(e,n),function(n){this.setAttributeNS(a.space,a.local,t(n))})})}if(arguments.length<2){for(t in n)this.attr(t,n[t]);return this}var o="transform"==n?Hu:mu,a=ta.ns.qualify(n);return Zo(this,"attr."+n,t,a.local?i:u)},Pl.attrTween=function(n,t){function e(n,e){var r=t.call(this,n,e,this.getAttribute(u));return r&&function(n){this.setAttribute(u,r(n))}}function r(n,e){var r=t.call(this,n,e,this.getAttributeNS(u.space,u.local));return r&&function(n){this.setAttributeNS(u.space,u.local,r(n))}}var u=ta.ns.qualify(n);return this.tween("attr."+n,u.local?r:e)},Pl.style=function(n,e,r){function u(){this.style.removeProperty(n)}function i(e){return null==e?u:(e+="",function(){var u,i=t(this).getComputedStyle(this,null).getPropertyValue(n);return i!==e&&(u=mu(i,e),function(t){this.style.setProperty(n,u(t),r)})})}var o=arguments.length;if(3>o){if("string"!=typeof n){2>o&&(e="");for(r in n)this.style(r,n[r],e);return this}r=""}return Zo(this,"style."+n,e,i)},Pl.styleTween=function(n,e,r){function u(u,i){var o=e.call(this,u,i,t(this).getComputedStyle(this,null).getPropertyValue(n));return o&&function(t){this.style.setProperty(n,o(t),r)}}return arguments.length<3&&(r=""),this.tween("style."+n,u)},Pl.text=function(n){return Zo(this,"text",n,Vo)},Pl.remove=function(){var n=this.namespace;return this.each("end.transition",function(){var t;this[n].count<2&&(t=this.parentNode)&&t.removeChild(this)})},Pl.ease=function(n){var t=this.id,e=this.namespace;return arguments.length<1?this.node()[e][t].ease:("function"!=typeof n&&(n=ta.ease.apply(ta,arguments)),Y(this,function(r){r[e][t].ease=n}))},Pl.delay=function(n){var t=this.id,e=this.namespace;return arguments.length<1?this.node()[e][t].delay:Y(this,"function"==typeof n?function(r,u,i){r[e][t].delay=+n.call(r,r.__data__,u,i)}:(n=+n,function(r){r[e][t].delay=n}))},Pl.duration=function(n){var t=this.id,e=this.namespace;return arguments.length<1?this.node()[e][t].duration:Y(this,"function"==typeof n?function(r,u,i){r[e][t].duration=Math.max(1,n.call(r,r.__data__,u,i))}:(n=Math.max(1,n),function(r){r[e][t].duration=n}))},Pl.each=function(n,t){var e=this.id,r=this.namespace;if(arguments.length<2){var u=Rl,i=Tl;try{Tl=e,Y(this,function(t,u,i){Rl=t[r][e],n.call(t,t.__data__,u,i)})}finally{Rl=u,Tl=i}}else Y(this,function(u){var i=u[r][e];(i.event||(i.event=ta.dispatch("start","end","interrupt"))).on(n,t)});return this},Pl.transition=function(){for(var n,t,e,r,u=this.id,i=++Ul,o=this.namespace,a=[],c=0,l=this.length;l>c;c++){a.push(n=[]);for(var t=this[c],s=0,f=t.length;f>s;s++)(e=t[s])&&(r=e[o][u],$o(e,s,o,i,{time:r.time,ease:r.ease,delay:r.delay+r.duration,duration:r.duration})),n.push(e)}return Yo(a,o,i)},ta.svg.axis=function(){function n(n){n.each(function(){var n,l=ta.select(this),s=this.__chart__||e,f=this.__chart__=e.copy(),h=null==c?f.ticks?f.ticks.apply(f,a):f.domain():c,g=null==t?f.tickFormat?f.tickFormat.apply(f,a):y:t,p=l.selectAll(".tick").data(h,f),v=p.enter().insert("g",".domain").attr("class","tick").style("opacity",Ca),d=ta.transition(p.exit()).style("opacity",Ca).remove(),m=ta.transition(p.order()).style("opacity",1),M=Math.max(u,0)+o,x=Ui(f),b=l.selectAll(".domain").data([0]),_=(b.enter().append("path").attr("class","domain"),ta.transition(b));v.append("line"),v.append("text");var w,S,k,E,A=v.select("line"),N=m.select("line"),C=p.select("text").text(g),z=v.select("text"),q=m.select("text"),L="top"===r||"left"===r?-1:1;if("bottom"===r||"top"===r?(n=Bo,w="x",k="y",S="x2",E="y2",C.attr("dy",0>L?"0em":".71em").style("text-anchor","middle"),_.attr("d","M"+x[0]+","+L*i+"V0H"+x[1]+"V"+L*i)):(n=Wo,w="y",k="x",S="y2",E="x2",C.attr("dy",".32em").style("text-anchor",0>L?"end":"start"),_.attr("d","M"+L*i+","+x[0]+"H0V"+x[1]+"H"+L*i)),A.attr(E,L*u),z.attr(k,L*M),N.attr(S,0).attr(E,L*u),q.attr(w,0).attr(k,L*M),f.rangeBand){var T=f,R=T.rangeBand()/2;s=f=function(n){return T(n)+R}}else s.rangeBand?s=f:d.call(n,f,s);v.call(n,s,f),m.call(n,f,f)})}var t,e=ta.scale.linear(),r=jl,u=6,i=6,o=3,a=[10],c=null;return n.scale=function(t){return arguments.length?(e=t,n):e},n.orient=function(t){return arguments.length?(r=t in Fl?t+"":jl,n):r},n.ticks=function(){return arguments.length?(a=arguments,n):a},n.tickValues=function(t){return arguments.length?(c=t,n):c},n.tickFormat=function(e){return arguments.length?(t=e,n):t},n.tickSize=function(t){var e=arguments.length;return e?(u=+t,i=+arguments[e-1],n):u},n.innerTickSize=function(t){return arguments.length?(u=+t,n):u},n.outerTickSize=function(t){return arguments.length?(i=+t,n):i},n.tickPadding=function(t){return arguments.length?(o=+t,n):o},n.tickSubdivide=function(){return arguments.length&&n},n};var jl="bottom",Fl={top:1,right:1,bottom:1,left:1};ta.svg.brush=function(){function n(t){t.each(function(){var t=ta.select(this).style("pointer-events","all").style("-webkit-tap-highlight-color","rgba(0,0,0,0)").on("mousedown.brush",i).on("touchstart.brush",i),o=t.selectAll(".background").data([0]);o.enter().append("rect").attr("class","background").style("visibility","hidden").style("cursor","crosshair"),t.selectAll(".extent").data([0]).enter().append("rect").attr("class","extent").style("cursor","move");var a=t.selectAll(".resize").data(v,y);a.exit().remove(),a.enter().append("g").attr("class",function(n){return"resize "+n}).style("cursor",function(n){return Hl[n]}).append("rect").attr("x",function(n){return/[ew]$/.test(n)?-3:null}).attr("y",function(n){return/^[ns]/.test(n)?-3:null}).attr("width",6).attr("height",6).style("visibility","hidden"),a.style("display",n.empty()?"none":null);var c,f=ta.transition(t),h=ta.transition(o);l&&(c=Ui(l),h.attr("x",c[0]).attr("width",c[1]-c[0]),r(f)),s&&(c=Ui(s),h.attr("y",c[0]).attr("height",c[1]-c[0]),u(f)),e(f)})}function e(n){n.selectAll(".resize").attr("transform",function(n){return"translate("+f[+/e$/.test(n)]+","+h[+/^s/.test(n)]+")"})}function r(n){n.select(".extent").attr("x",f[0]),n.selectAll(".extent,.n>rect,.s>rect").attr("width",f[1]-f[0])}function u(n){n.select(".extent").attr("y",h[0]),n.selectAll(".extent,.e>rect,.w>rect").attr("height",h[1]-h[0])}function i(){function i(){32==ta.event.keyCode&&(C||(M=null,q[0]-=f[1],q[1]-=h[1],C=2),S())}function v(){32==ta.event.keyCode&&2==C&&(q[0]+=f[1],q[1]+=h[1],C=0,S())}function d(){var n=ta.mouse(b),t=!1;x&&(n[0]+=x[0],n[1]+=x[1]),C||(ta.event.altKey?(M||(M=[(f[0]+f[1])/2,(h[0]+h[1])/2]),q[0]=f[+(n[0]<M[0])],q[1]=h[+(n[1]<M[1])]):M=null),A&&m(n,l,0)&&(r(k),t=!0),N&&m(n,s,1)&&(u(k),t=!0),t&&(e(k),w({type:"brush",mode:C?"move":"resize"}))}function m(n,t,e){var r,u,i=Ui(t),c=i[0],l=i[1],s=q[e],v=e?h:f,d=v[1]-v[0];return C&&(c-=s,l-=d+s),r=(e?p:g)?Math.max(c,Math.min(l,n[e])):n[e],C?u=(r+=s)+d:(M&&(s=Math.max(c,Math.min(l,2*M[e]-r))),r>s?(u=r,r=s):u=s),v[0]!=r||v[1]!=u?(e?a=null:o=null,v[0]=r,v[1]=u,!0):void 0}function y(){d(),k.style("pointer-events","all").selectAll(".resize").style("display",n.empty()?"none":null),ta.select("body").style("cursor",null),L.on("mousemove.brush",null).on("mouseup.brush",null).on("touchmove.brush",null).on("touchend.brush",null).on("keydown.brush",null).on("keyup.brush",null),z(),w({type:"brushend"})}var M,x,b=this,_=ta.select(ta.event.target),w=c.of(b,arguments),k=ta.select(b),E=_.datum(),A=!/^(n|s)$/.test(E)&&l,N=!/^(e|w)$/.test(E)&&s,C=_.classed("extent"),z=W(b),q=ta.mouse(b),L=ta.select(t(b)).on("keydown.brush",i).on("keyup.brush",v);if(ta.event.changedTouches?L.on("touchmove.brush",d).on("touchend.brush",y):L.on("mousemove.brush",d).on("mouseup.brush",y),k.interrupt().selectAll("*").interrupt(),C)q[0]=f[0]-q[0],q[1]=h[0]-q[1];else if(E){var T=+/w$/.test(E),R=+/^n/.test(E);x=[f[1-T]-q[0],h[1-R]-q[1]],q[0]=f[T],q[1]=h[R]}else ta.event.altKey&&(M=q.slice());k.style("pointer-events","none").selectAll(".resize").style("display",null),ta.select("body").style("cursor",_.style("cursor")),w({type:"brushstart"}),d()}var o,a,c=E(n,"brushstart","brush","brushend"),l=null,s=null,f=[0,0],h=[0,0],g=!0,p=!0,v=Ol[0];return n.event=function(n){n.each(function(){var n=c.of(this,arguments),t={x:f,y:h,i:o,j:a},e=this.__chart__||t;this.__chart__=t,Tl?ta.select(this).transition().each("start.brush",function(){o=e.i,a=e.j,f=e.x,h=e.y,n({type:"brushstart"})}).tween("brush:brush",function(){var e=yu(f,t.x),r=yu(h,t.y);return o=a=null,function(u){f=t.x=e(u),h=t.y=r(u),n({type:"brush",mode:"resize"})}}).each("end.brush",function(){o=t.i,a=t.j,n({type:"brush",mode:"resize"}),n({type:"brushend"})}):(n({type:"brushstart"}),n({type:"brush",mode:"resize"}),n({type:"brushend"}))})},n.x=function(t){return arguments.length?(l=t,v=Ol[!l<<1|!s],n):l},n.y=function(t){return arguments.length?(s=t,v=Ol[!l<<1|!s],n):s},n.clamp=function(t){return arguments.length?(l&&s?(g=!!t[0],p=!!t[1]):l?g=!!t:s&&(p=!!t),n):l&&s?[g,p]:l?g:s?p:null},n.extent=function(t){var e,r,u,i,c;return arguments.length?(l&&(e=t[0],r=t[1],s&&(e=e[0],r=r[0]),o=[e,r],l.invert&&(e=l(e),r=l(r)),e>r&&(c=e,e=r,r=c),(e!=f[0]||r!=f[1])&&(f=[e,r])),s&&(u=t[0],i=t[1],l&&(u=u[1],i=i[1]),a=[u,i],s.invert&&(u=s(u),i=s(i)),u>i&&(c=u,u=i,i=c),(u!=h[0]||i!=h[1])&&(h=[u,i])),n):(l&&(o?(e=o[0],r=o[1]):(e=f[0],r=f[1],l.invert&&(e=l.invert(e),r=l.invert(r)),e>r&&(c=e,e=r,r=c))),s&&(a?(u=a[0],i=a[1]):(u=h[0],i=h[1],s.invert&&(u=s.invert(u),i=s.invert(i)),u>i&&(c=u,u=i,i=c))),l&&s?[[e,u],[r,i]]:l?[e,r]:s&&[u,i])},n.clear=function(){return n.empty()||(f=[0,0],h=[0,0],o=a=null),n},n.empty=function(){return!!l&&f[0]==f[1]||!!s&&h[0]==h[1]},ta.rebind(n,c,"on")};var Hl={n:"ns-resize",e:"ew-resize",s:"ns-resize",w:"ew-resize",nw:"nwse-resize",ne:"nesw-resize",se:"nwse-resize",sw:"nesw-resize"},Ol=[["n","e","s","w","nw","ne","se","sw"],["e","w"],["n","s"],[]],Il=ac.format=gc.timeFormat,Yl=Il.utc,Zl=Yl("%Y-%m-%dT%H:%M:%S.%LZ");Il.iso=Date.prototype.toISOString&&+new Date("2000-01-01T00:00:00.000Z")?Jo:Zl,Jo.parse=function(n){var t=new Date(n);return isNaN(t)?null:t},Jo.toString=Zl.toString,ac.second=Ft(function(n){return new cc(1e3*Math.floor(n/1e3))},function(n,t){n.setTime(n.getTime()+1e3*Math.floor(t))},function(n){return n.getSeconds()}),ac.seconds=ac.second.range,ac.seconds.utc=ac.second.utc.range,ac.minute=Ft(function(n){return new cc(6e4*Math.floor(n/6e4))},function(n,t){n.setTime(n.getTime()+6e4*Math.floor(t))},function(n){return n.getMinutes()}),ac.minutes=ac.minute.range,ac.minutes.utc=ac.minute.utc.range,ac.hour=Ft(function(n){var t=n.getTimezoneOffset()/60;return new cc(36e5*(Math.floor(n/36e5-t)+t))},function(n,t){n.setTime(n.getTime()+36e5*Math.floor(t))},function(n){return n.getHours()}),ac.hours=ac.hour.range,ac.hours.utc=ac.hour.utc.range,ac.month=Ft(function(n){return n=ac.day(n),n.setDate(1),n},function(n,t){n.setMonth(n.getMonth()+t)},function(n){return n.getMonth()}),ac.months=ac.month.range,ac.months.utc=ac.month.utc.range;var Vl=[1e3,5e3,15e3,3e4,6e4,3e5,9e5,18e5,36e5,108e5,216e5,432e5,864e5,1728e5,6048e5,2592e6,7776e6,31536e6],Xl=[[ac.second,1],[ac.second,5],[ac.second,15],[ac.second,30],[ac.minute,1],[ac.minute,5],[ac.minute,15],[ac.minute,30],[ac.hour,1],[ac.hour,3],[ac.hour,6],[ac.hour,12],[ac.day,1],[ac.day,2],[ac.week,1],[ac.month,1],[ac.month,3],[ac.year,1]],$l=Il.multi([[".%L",function(n){return n.getMilliseconds()}],[":%S",function(n){return n.getSeconds()}],["%I:%M",function(n){return n.getMinutes()}],["%I %p",function(n){return n.getHours()}],["%a %d",function(n){return n.getDay()&&1!=n.getDate()}],["%b %d",function(n){return 1!=n.getDate()}],["%B",function(n){return n.getMonth()}],["%Y",Ne]]),Bl={range:function(n,t,e){return ta.range(Math.ceil(n/e)*e,+t,e).map(Ko)},floor:y,ceil:y};Xl.year=ac.year,ac.scale=function(){return Go(ta.scale.linear(),Xl,$l)};var Wl=Xl.map(function(n){return[n[0].utc,n[1]]}),Jl=Yl.multi([[".%L",function(n){return n.getUTCMilliseconds()}],[":%S",function(n){return n.getUTCSeconds()}],["%I:%M",function(n){return n.getUTCMinutes()}],["%I %p",function(n){return n.getUTCHours()}],["%a %d",function(n){return n.getUTCDay()&&1!=n.getUTCDate()}],["%b %d",function(n){return 1!=n.getUTCDate()}],["%B",function(n){return n.getUTCMonth()}],["%Y",Ne]]);Wl.year=ac.year.utc,ac.scale.utc=function(){return Go(ta.scale.linear(),Wl,Jl)},ta.text=At(function(n){return n.responseText}),ta.json=function(n,t){return Nt(n,"application/json",Qo,t)},ta.html=function(n,t){return Nt(n,"text/html",na,t)},ta.xml=At(function(n){return n.responseXML}),"function"==typeof define&&define.amd?define(ta):"object"==typeof module&&module.exports&&(module.exports=ta),this.d3=ta}();
(function ($) {

    function Barometer(container, data, config) {
        this.init(container, data, config);
    }

    $.extend(Barometer.prototype, {
        width: undefined,
        height: undefined,
        init: function (container, data, options) {

            var config = $.extend({
                width: container.get(0).clientWidth,
                height: container.get(0).clientWidth * 0.8,
                center: container.get(0).clientWidth / 8
            }, options);


            var svg = d3.select(container.selector)
                .select('svg')
                .attr('width', config.width)
                .attr('height', config.height);

            var barometer = svg.append('g').attr('class', 'barometer');

            this.__drawBarometerScala(barometer, data, config);
            this.__drawBarometerLines(barometer, data, config);
            this.__drawBarometerText(barometer, data, config);
            this.__drawBarometerPosition(barometer, data, config);

        },
        /**
         * Draw a barometer scala with red, green and yellow
         *
         * @param container
         * @param data
         * @param config
         * @private
         */
        __drawBarometerScala: function (container, data, config) {
            var barometerScala = container.append('g')
                .attr('class', 'barometer-scala');

            barometerScala.selectAll('.barometer-scala')
                .data(config.scala)
                .enter()
                .append("rect")
                .attr('x', config.center - (config.scala_weight / 2))
                .attr('y', config.height)
                .attr('rx', function (d) {
                    if (d.round) {
                        return "10px";
                    }
                    return '0px';
                })
                .attr('ry', function (d) {
                    if (d.round) {
                        return "20px";
                    }
                    return '0px';
                })
                .attr('width', config.scala_weight)
                .attr('height', 0)
                .attr('fill', function (d) {
                    return d.color;
                })
                .transition()
                .duration(config.duration)
                .attr('y', function (d) {
                    return (d.start * config.height / 100);
                })
                .attr('height', function (d) {
                    return (d.height * config.height / 100);
                })
            ;
        },
        /**
         * Draw a barometer lines
         *
         * @param container
         * @param data
         * @param config
         * @private
         */
        __drawBarometerLines: function (container, data, config) {
            var barometerLine = container.append('g')
                .attr('class', 'barometer-lines');

            barometerLine.append('line')
                .attr('x1', config.center)
                .attr('x2', config.center)
                .style('stroke', '#000000')
                .attr('y1', config.height)
                .attr('y2', config.height)
                .transition()
                .duration(config.duration)
                .attr('y1', 0)
                .attr('y2', (config.height * 0.97))
            ;

            barometerLine.selectAll('.barometer-lines')
                .data(Array.apply(null, Array(parseInt(config.lines))).map(function (_, i) {
                    return i;
                }))
                .enter()
                .append('line')
                .attr('x1', config.center - 5)
                .attr('x2', config.center + 5)
                .attr('y1', config.height)
                .attr('y2', config.height)
                .style('stroke', '#000000')
                .transition()
                .duration(config.duration)
                .attr('y1', function (d) {
                    return ((d * 100 / parseInt(config.lines)) * (config.height * 0.95)) / 100;
                })
                .attr('y2', function (d) {
                    return ((d * 100 / parseInt(config.lines)) * (config.height * 0.95)) / 100;
                })
            ;
        },
        /**
         * Draw a current barometer position
         *
         * @param container
         * @param data
         * @param config
         * @private
         */
        __drawBarometerPosition: function (container, data, config) {
            var barometerPosition = container.append('g')
                .attr('class', 'barometer-position');

            barometerPosition.append('polygon')
                .attr('points', function () {
                    var position = (config.height * 0.97);

                    var top = [config.center - 20, position + 5];
                    var bottom = [config.center - 20, position - 5];
                    var right = [config.center, (config.height * 0.97)];
                    return top + ' ' + bottom + ' ' + right;
                })
                .style('fill', '#000000')
                .transition()
                .delay(config.delay)
                .duration(config.duration)
                .attr('points', function () {

                    var position = ((config.height * 0.97) - (data.value * (config.height * 0.97)) / 100);

                    var top = [config.center - 20, position + 5];
                    var bottom = [config.center - 20, position - 5];
                    var right = [config.center, ((config.height * 0.97) - (data.value * (config.height * 0.97)) / 100)];
                    return top + ' ' + bottom + ' ' + right;
                });

        },
        /**
         * Draw a barometer text (description)
         *
         * @param container
         * @param data
         * @param config
         * @private
         */
        __drawBarometerText: function (container, data, config) {
            var barometerText = container.append('g')
                .attr('class', 'barometer-text');

            barometerText.data(data.value)
                .append('foreignObject')
                .attr('x', config.width / 4)
                .attr('y', 0)
                .attr('width', config.width / 1.4)
                .attr('height', config.height)
                .append('xhtml:body')
                .style('font-size', '0.9em')
                .html(data.description);
        }
    });

    $.fn.barometer = function (data, config) {

        return new Barometer($(this), data, $.extend({
            delay: 500,
            duration: 1500,
            lines: 30,
            scala: [
                {
                    start: 60,
                    height: 40,
                    color: '#e65a3b',
                    round: true
                },
                {
                    start: 60,
                    height: 20,
                    color: '#e65a3b'
                },
                {
                    start: 30,
                    height: 30,
                    color: '#fce14b'
                },
                {
                    start: 0,
                    height: 30,
                    color: '#a2d049'
                }
            ],
            scala_weight: 20
        }, config));
    };

})(jQuery);
(function ($) {

    function Waterfall(container, data, config) {
        this.init(container, data, config);
    }

    $.extend(Waterfall.prototype, {

        /**
         * Initial function,
         * improve config, define sizes and other
         *
         * @param container
         * @param data
         * @param options
         */
        init: function (container, data, options) {

            var config = $.extend({
                width: container.get(0).clientWidth,
                height: container.get(0).clientWidth * 0.8,
                center: container.get(0).clientWidth / 2
            }, options);


            var svg = d3.select(container.selector)
                .select('svg')
                .attr('width', config.width)
                .attr('height', config.height);

            var waterfall = svg.append('g').attr('class', 'waterfall');

            this.__drawWaterfallBackground(this, waterfall, data, config);
            this.__drawWaterfallBackgroundLabels(this, waterfall, data, config);

        },

        /**
         * Draw background columns
         *
         * @param container
         * @param data
         * @param config
         * @private
         */
        __drawWaterfallBackground: function (self, container, data, config) {
            var waterfallBackground = container.append('g')
                .attr('class', 'waterfall-column');

            var indexX = 0;
            var indexY = 0;
            var waterfallBackgroundElements = waterfallBackground.selectAll('.waterfall-column')
                .data(data).enter()
                .append('g').attr('class', 'waterfall-column-element');

            waterfallBackgroundElements.append('rect')
                .attr('x', function (data) {
                    return self.__getColumnPositionX(indexX++, data, config);
                })
                .attr('y', function (data) {
                    return self.__getColumnPositionY(indexY++, data, config);
                })
                .attr('height', 0)
                .attr('width', function (data) {
                    return self.__getColumnWidth(data, config)
                })
                .attr('fill', function (d) {
                    return d.color;
                })
                .transition()
                .duration(config.duration)
                .attr('y', function (data) {
                    return config.height - self.__getColumnHeight(data, config);
                })
                .attr('height', function (data) {
                    return self.__getColumnHeight(data, config);
                });


            var indexX = 0;
            var indexY = 0;
            waterfallBackgroundElements
                .append('g')
                .attr('class', 'waterfall-column-text')
                .append('text')
                .attr('x', function (data) {
                    return self.__getColumnPositionX(indexX++, data, config)
                    + (self.__getColumnWidth(data, config) / 4);
                })
                .attr('y', function (data) {
                    return self.__getColumnPositionY(indexY++, data, config);
                })
                .text(function (d) {
                    return '0%';
                })
                .transition()
                .duration(config.duration)
                .attr('y', function (data) {
                    return config.height - self.__getColumnHeight(data, config) - 5;
                })
                .tween('text', function (d) {
                    var interpolator = d3.interpolateRound(0, d.value);
                    return function (t) {
                        this.textContent = interpolator(t) + '%';
                    };
                });
        },

        /**
         * Calculate a x position for column
         *
         * @param index
         * @param data
         * @param config
         * @returns {*}
         * @private
         */
        __getColumnPositionX: function (index, data, config) {
            var distance = (((config.width * config.width_background / 100 ) ) * index);
            return config.center + distance;
        },

        /**
         * Calculate a y-position for column
         *
         * @param index
         * @param data
         * @param config
         * @returns {*|config.height}
         * @private
         */
        __getColumnPositionY: function (index, data, config) {
            return config.height;
        },

        /**
         * Calculate a column-width
         *
         * @param data
         * @param config
         * @returns {number}
         * @private
         */
        __getColumnWidth: function (data, config) {
            return config.width * config.width_background / 100
        },

        /**
         * Calculate a column-height
         *
         * @param data
         * @param config
         * @returns {number}
         * @private
         */
        __getColumnHeight: function (data, config) {
            return data.value * (config.height * 0.9) / 100;
        },

        /**
         * Draw labels for columns
         *
         * @param container
         * @param data
         * @param config
         * @private
         */
        __drawWaterfallBackgroundLabels: function (self, container, data, config) {
            var waterfallColumnLabel = container.append('g')
                .attr('class', 'waterfall-column-label');

            var index = 0;
            var counter = 0;
            var waterfallColumnLabelElements = waterfallColumnLabel
                .selectAll('.waterfall-column-label').data(data)
                .enter()
                .append('g').attr('class', 'waterfall-column-label-element')
                .each(function (d) {
                    counter++;
                })
                .attr('transform', function (d) {
                    index = index + 1;
                    return 'translate(' + 20 + ',' + (config.height - (index * 25)) + ')';
                });

            waterfallColumnLabelElements.append("rect")
                .attr('fill', function (d) {
                    return d.color;
                })
                .attr('x', '0').attr('y', '0')
                .attr('width', '0').attr('height', '0')
                .transition()
                .duration(config.duration)
                .attr('x', '-10').attr('y', '-15')
                .attr('width', '18').attr('height', '18');

            waterfallColumnLabelElements.append("text")
                .attr('x', '0')
                .text(function (d) {
                    return d.label;
                })
                .style('font-size', '0em')

                .transition()
                .duration(config.duration)
                .style('font-size', '1em')
                .attr('x', '20')
                .each('end', function (d) {
                    counter--;
                    if (counter == 0) {
                        self.__drawWaterfallBackgroundTitle(
                            self, waterfallColumnLabel, data, config);
                    }
                });
        },

        /**
         * Draw a title for all labels after all events
         * and animations
         *
         * @param container
         * @param data
         * @param config
         * @private
         */
        __drawWaterfallBackgroundTitle: function (self, container, data, config) {

            var waterfallColumnLabelText = container.append('g')
                .attr('class', 'waterfall-column-label-text')
                .attr('transform', function (d) {
                    var index = (data.length + 3);
                    return 'translate(' + 5 + ',' + (config.height - (index * 25)) + ')';
                });

            waterfallColumnLabelText
                .append('foreignObject')
                .attr('x', 5)
                .attr('y', 5)
                .attr('width', config.width / 3)
                .attr('height', config.height / 5)
                .append('xhtml:body')
                .style('font-size', '0.9em')
                .html(config.title);
        }

    });


    $.fn.waterfall = function (data, config) {

        return new Waterfall($(this), data, $.extend({
            delay: 500,
            duration: 1500,
            width_background: 20
        }, config));
    }


})(jQuery);

$(function () {
    var dropdown_toggles = $('.dropdown-toggle');
    if (dropdown_toggles.length) {
        dropdown_toggles.dropdown();
    }
});
(function ($) {

    function Pie(element, data, config) {
        this.init(element, data, config);
    }

    $.extend(Pie.prototype, {
        width: undefined,
        height: undefined,
        radius: undefined,
        container: undefined,

        init: function (container, data, options) {

            var config = $.extend({
                width: container.get(0).clientWidth,
                height: container.get(0).clientWidth * 0.65
            }, options);

            $.extend(config, {
                radius: Math.min(config.width, config.height) / 3.2
            });

            var svg = d3.select(container.selector)
                .select('svg')
                .attr('width', config.width)
                .attr('height', config.height);

            this.__renderPie(svg, data, config);
            this.__renderLabels(svg, data, config);
        },

        /**
         * Render pie chart
         *
         * @param container
         * @param data
         * @param config
         * @private
         */
        __renderPie: function (container, data, config) {

            var pie = container.append('g')
                .attr('class', 'pieChart--diagramm')
                .attr('filter', 'url(#pieChartInsetShadow)')
                .attr('transform', 'translate(' + config.width / 1.4 + ',' + config.height / 2 + ')');

            var pieData = d3.layout.pie()
                .value(function (d) {
                    return d.value;
                });

            var arc = d3.svg.arc()
                .outerRadius(config.radius * 0.9)
                .innerRadius(0);

            var pieChartPieces = pie.datum(data)
                .selectAll('path').data(pieData)
                .enter()
                .append('path')
                .style("fill", function (d) {
                    return d.data.color;
                })
                .attr('d', arc)
                .each(function () {
                    this._current = {
                        startAngle: 0,
                        endAngle: 0
                    };
                })
                .transition()
                .duration(config.duration)
                .attrTween('d', function (d) {
                    var interpolate = d3.interpolate(this._current, d);
                    this._current = interpolate(0);

                    return function (t) {
                        return arc(interpolate(t));
                    };
                });

            var centerContainer = pie.append('g')
                .attr('class', 'pieChart--center');

            centerContainer.append('circle')
                .attr('class', 'pieChart--center--outerCircle')
                .attr('r', 0)
                .attr('filter', 'url(#pieChartDropShadow)')
                .transition()
                .duration(config.duration)
                .delay(config.delay)
                .attr('r', config.radius - (config.radius_inner * 100 / config.radius));


            centerContainer.append('circle')
                .attr('id', 'pieChart-clippy')
                .attr('class', 'pieChart--center--innerCircle')
                .attr('r', 0)
                .transition()
                .duration(config.duration)
                .delay(config.delay)
                .attr('r', config.radius - ((config.radius_inner + 5) * 100 / config.radius))
                .attr('fill', '#fff');
        },

        /**
         * Render labels
         *
         * @param container
         * @param data
         * @param config
         * @private
         */
        __renderLabels: function (container, data, config) {

            var pieLabels = container.append('g').attr('class', 'pieChart--labels')
                .attr('transform', 'translate(0,' + ((config.height / 2) - config.radius) + ')');

            var elements = pieLabels
                .selectAll(".pieChart--labels")
                .data(data)
                .enter()
                .append("g")
                .attr('transform', function (d) {
                    return 'translate(' + 10 + ',' + (d.index * 25) + ')';
                });

            elements.append("rect")
                .attr('fill', function (d) {
                    return d.color;
                })
                .attr('x', '0').attr('y', '0')
                .attr('width', '0').attr('height', '0')
                .transition()
                .duration(config.duration)
                .attr('x', '-10').attr('y', '-15')
                .attr('width', '18').attr('height', '18');

            elements.append("text")
                .attr('x', '0')
                .text(function (d) {
                    return d.label;
                })
                .transition()
                .duration(config.duration)
                .attr('x', '20');
        }
    });


    $.fn.pie = function (data, config) {

        return new Pie($(this), data, $.extend({
            duration: 1500,
            delay: 500,
            radius_inner: 50
        }, config));
    };

})(jQuery);

/* jQuery POST/GET redirect method
 v.0.1
 modified by Miguel Galante,https://github.com/mgalante
 v.0.1
 made by Nemanja Avramovic, www.avramovic.info
 */
(function ($) {

    $.redirect = function (target, values, method) {

        method = (method && method.toUpperCase() == 'GET') ? 'GET' : 'POST';

        if (!values) {
            var obj = $.parse_url(target);
            target = obj.url;
            values = obj.params;
        }

        var form = $('<form>', {
            attr: {
                method: method,
                action: target
            }
        });

        for (var i in values) {
            $('<input>', {
                attr: {
                    type: 'hidden',
                    name: i,
                    value: values[i]
                }
            }).appendTo(form);

        }

        $('body').append(form);
        console.log(form);
        form.submit();
    };

    $.parse_url = function (url) {
        if (url.indexOf('?') == -1)
            return {url: url, params: {}}

        var parts = url.split('?');
        var url = parts[0];
        var query_string = parts[1];

        var return_obj = {};
        var elems = query_string.split('&');

        var obj = {};

        for (var i in elems) {
            var elem = elems[i];
            var pair = elem.split('=');
            obj[pair[0]] = pair[1];
        }

        return_obj.url = url;
        return_obj.params = obj;

        return return_obj;
    }
})(jQuery);
$(function () {
    var container = $('.tooltip-popup');
    if (typeof(container.tooltip) == "function") {
        container.tooltip();
    }
});
/*! jQuery UI - v1.10.4 - 2014-06-20
 * http://jqueryui.com
 * Includes: jquery.ui.core.js, jquery.ui.widget.js, jquery.ui.mouse.js, jquery.ui.position.js, jquery.ui.draggable.js, jquery.ui.resizable.js, jquery.ui.sortable.js, jquery.ui.accordion.js, jquery.ui.autocomplete.js, jquery.ui.button.js, jquery.ui.datepicker.js, jquery.ui.dialog.js, jquery.ui.menu.js, jquery.ui.progressbar.js, jquery.ui.slider.js, jquery.ui.spinner.js, jquery.ui.tabs.js, jquery.ui.tooltip.js, jquery.ui.effect.js, jquery.ui.effect-blind.js, jquery.ui.effect-bounce.js, jquery.ui.effect-clip.js, jquery.ui.effect-drop.js, jquery.ui.effect-explode.js, jquery.ui.effect-fade.js, jquery.ui.effect-fold.js, jquery.ui.effect-highlight.js, jquery.ui.effect-pulsate.js, jquery.ui.effect-scale.js, jquery.ui.effect-shake.js, jquery.ui.effect-slide.js, jquery.ui.effect-transfer.js
 * Copyright 2014 jQuery Foundation and other contributors; Licensed MIT */

(function (e, t) {
    function i(t, i) {
        var s, a, o, r = t.nodeName.toLowerCase();
        return "area" === r ? (s = t.parentNode, a = s.name, t.href && a && "map" === s.nodeName.toLowerCase() ? (o = e("img[usemap=#" + a + "]")[0], !!o && n(o)) : !1) : (/input|select|textarea|button|object/.test(r) ? !t.disabled : "a" === r ? t.href || i : i) && n(t)
    }

    function n(t) {
        return e.expr.filters.visible(t) && !e(t).parents().addBack().filter(function () {
            return "hidden" === e.css(this, "visibility")
        }).length
    }

    var s = 0, a = /^ui-id-\d+$/;
    e.ui = e.ui || {}, e.extend(e.ui, {
        version: "1.10.4",
        keyCode: {
            BACKSPACE: 8,
            COMMA: 188,
            DELETE: 46,
            DOWN: 40,
            END: 35,
            ENTER: 13,
            ESCAPE: 27,
            HOME: 36,
            LEFT: 37,
            NUMPAD_ADD: 107,
            NUMPAD_DECIMAL: 110,
            NUMPAD_DIVIDE: 111,
            NUMPAD_ENTER: 108,
            NUMPAD_MULTIPLY: 106,
            NUMPAD_SUBTRACT: 109,
            PAGE_DOWN: 34,
            PAGE_UP: 33,
            PERIOD: 190,
            RIGHT: 39,
            SPACE: 32,
            TAB: 9,
            UP: 38
        }
    }), e.fn.extend({
        focus: function (t) {
            return function (i, n) {
                return "number" == typeof i ? this.each(function () {
                    var t = this;
                    setTimeout(function () {
                        e(t).focus(), n && n.call(t)
                    }, i)
                }) : t.apply(this, arguments)
            }
        }(e.fn.focus), scrollParent: function () {
            var t;
            return t = e.ui.ie && /(static|relative)/.test(this.css("position")) || /absolute/.test(this.css("position")) ? this.parents().filter(function () {
                return /(relative|absolute|fixed)/.test(e.css(this, "position")) && /(auto|scroll)/.test(e.css(this, "overflow") + e.css(this, "overflow-y") + e.css(this, "overflow-x"))
            }).eq(0) : this.parents().filter(function () {
                return /(auto|scroll)/.test(e.css(this, "overflow") + e.css(this, "overflow-y") + e.css(this, "overflow-x"))
            }).eq(0), /fixed/.test(this.css("position")) || !t.length ? e(document) : t
        }, zIndex: function (i) {
            if (i !== t)return this.css("zIndex", i);
            if (this.length)for (var n, s, a = e(this[0]); a.length && a[0] !== document;) {
                if (n = a.css("position"), ("absolute" === n || "relative" === n || "fixed" === n) && (s = parseInt(a.css("zIndex"), 10), !isNaN(s) && 0 !== s))return s;
                a = a.parent()
            }
            return 0
        }, uniqueId: function () {
            return this.each(function () {
                this.id || (this.id = "ui-id-" + ++s)
            })
        }, removeUniqueId: function () {
            return this.each(function () {
                a.test(this.id) && e(this).removeAttr("id")
            })
        }
    }), e.extend(e.expr[":"], {
        data: e.expr.createPseudo ? e.expr.createPseudo(function (t) {
            return function (i) {
                return !!e.data(i, t)
            }
        }) : function (t, i, n) {
            return !!e.data(t, n[3])
        }, focusable: function (t) {
            return i(t, !isNaN(e.attr(t, "tabindex")))
        }, tabbable: function (t) {
            var n = e.attr(t, "tabindex"), s = isNaN(n);
            return (s || n >= 0) && i(t, !s)
        }
    }), e("<a>").outerWidth(1).jquery || e.each(["Width", "Height"], function (i, n) {
        function s(t, i, n, s) {
            return e.each(a, function () {
                i -= parseFloat(e.css(t, "padding" + this)) || 0, n && (i -= parseFloat(e.css(t, "border" + this + "Width")) || 0), s && (i -= parseFloat(e.css(t, "margin" + this)) || 0)
            }), i
        }

        var a = "Width" === n ? ["Left", "Right"] : ["Top", "Bottom"], o = n.toLowerCase(), r = {
            innerWidth: e.fn.innerWidth,
            innerHeight: e.fn.innerHeight,
            outerWidth: e.fn.outerWidth,
            outerHeight: e.fn.outerHeight
        };
        e.fn["inner" + n] = function (i) {
            return i === t ? r["inner" + n].call(this) : this.each(function () {
                e(this).css(o, s(this, i) + "px")
            })
        }, e.fn["outer" + n] = function (t, i) {
            return "number" != typeof t ? r["outer" + n].call(this, t) : this.each(function () {
                e(this).css(o, s(this, t, !0, i) + "px")
            })
        }
    }), e.fn.addBack || (e.fn.addBack = function (e) {
        return this.add(null == e ? this.prevObject : this.prevObject.filter(e))
    }), e("<a>").data("a-b", "a").removeData("a-b").data("a-b") && (e.fn.removeData = function (t) {
        return function (i) {
            return arguments.length ? t.call(this, e.camelCase(i)) : t.call(this)
        }
    }(e.fn.removeData)), e.ui.ie = !!/msie [\w.]+/.exec(navigator.userAgent.toLowerCase()), e.support.selectstart = "onselectstart"in document.createElement("div"), e.fn.extend({
        disableSelection: function () {
            return this.bind((e.support.selectstart ? "selectstart" : "mousedown") + ".ui-disableSelection", function (e) {
                e.preventDefault()
            })
        }, enableSelection: function () {
            return this.unbind(".ui-disableSelection")
        }
    }), e.extend(e.ui, {
        plugin: {
            add: function (t, i, n) {
                var s, a = e.ui[t].prototype;
                for (s in n)a.plugins[s] = a.plugins[s] || [], a.plugins[s].push([i, n[s]])
            }, call: function (e, t, i) {
                var n, s = e.plugins[t];
                if (s && e.element[0].parentNode && 11 !== e.element[0].parentNode.nodeType)for (n = 0; s.length > n; n++)e.options[s[n][0]] && s[n][1].apply(e.element, i)
            }
        }, hasScroll: function (t, i) {
            if ("hidden" === e(t).css("overflow"))return !1;
            var n = i && "left" === i ? "scrollLeft" : "scrollTop", s = !1;
            return t[n] > 0 ? !0 : (t[n] = 1, s = t[n] > 0, t[n] = 0, s)
        }
    })
})(jQuery);
(function (t, e) {
    var i = 0, s = Array.prototype.slice, n = t.cleanData;
    t.cleanData = function (e) {
        for (var i, s = 0; null != (i = e[s]); s++)try {
            t(i).triggerHandler("remove")
        } catch (o) {
        }
        n(e)
    }, t.widget = function (i, s, n) {
        var o, a, r, h, l = {}, c = i.split(".")[0];
        i = i.split(".")[1], o = c + "-" + i, n || (n = s, s = t.Widget), t.expr[":"][o.toLowerCase()] = function (e) {
            return !!t.data(e, o)
        }, t[c] = t[c] || {}, a = t[c][i], r = t[c][i] = function (t, i) {
            return this._createWidget ? (arguments.length && this._createWidget(t, i), e) : new r(t, i)
        }, t.extend(r, a, {
            version: n.version,
            _proto: t.extend({}, n),
            _childConstructors: []
        }), h = new s, h.options = t.widget.extend({}, h.options), t.each(n, function (i, n) {
            return t.isFunction(n) ? (l[i] = function () {
                var t = function () {
                    return s.prototype[i].apply(this, arguments)
                }, e = function (t) {
                    return s.prototype[i].apply(this, t)
                };
                return function () {
                    var i, s = this._super, o = this._superApply;
                    return this._super = t, this._superApply = e, i = n.apply(this, arguments), this._super = s, this._superApply = o, i
                }
            }(), e) : (l[i] = n, e)
        }), r.prototype = t.widget.extend(h, {widgetEventPrefix: a ? h.widgetEventPrefix || i : i}, l, {
            constructor: r,
            namespace: c,
            widgetName: i,
            widgetFullName: o
        }), a ? (t.each(a._childConstructors, function (e, i) {
            var s = i.prototype;
            t.widget(s.namespace + "." + s.widgetName, r, i._proto)
        }), delete a._childConstructors) : s._childConstructors.push(r), t.widget.bridge(i, r)
    }, t.widget.extend = function (i) {
        for (var n, o, a = s.call(arguments, 1), r = 0, h = a.length; h > r; r++)for (n in a[r])o = a[r][n], a[r].hasOwnProperty(n) && o !== e && (i[n] = t.isPlainObject(o) ? t.isPlainObject(i[n]) ? t.widget.extend({}, i[n], o) : t.widget.extend({}, o) : o);
        return i
    }, t.widget.bridge = function (i, n) {
        var o = n.prototype.widgetFullName || i;
        t.fn[i] = function (a) {
            var r = "string" == typeof a, h = s.call(arguments, 1), l = this;
            return a = !r && h.length ? t.widget.extend.apply(null, [a].concat(h)) : a, r ? this.each(function () {
                var s, n = t.data(this, o);
                return n ? t.isFunction(n[a]) && "_" !== a.charAt(0) ? (s = n[a].apply(n, h), s !== n && s !== e ? (l = s && s.jquery ? l.pushStack(s.get()) : s, !1) : e) : t.error("no such method '" + a + "' for " + i + " widget instance") : t.error("cannot call methods on " + i + " prior to initialization; " + "attempted to call method '" + a + "'")
            }) : this.each(function () {
                var e = t.data(this, o);
                e ? e.option(a || {})._init() : t.data(this, o, new n(a, this))
            }), l
        }
    }, t.Widget = function () {
    }, t.Widget._childConstructors = [], t.Widget.prototype = {
        widgetName: "widget",
        widgetEventPrefix: "",
        defaultElement: "<div>",
        options: {disabled: !1, create: null},
        _createWidget: function (e, s) {
            s = t(s || this.defaultElement || this)[0], this.element = t(s), this.uuid = i++, this.eventNamespace = "." + this.widgetName + this.uuid, this.options = t.widget.extend({}, this.options, this._getCreateOptions(), e), this.bindings = t(), this.hoverable = t(), this.focusable = t(), s !== this && (t.data(s, this.widgetFullName, this), this._on(!0, this.element, {
                remove: function (t) {
                    t.target === s && this.destroy()
                }
            }), this.document = t(s.style ? s.ownerDocument : s.document || s), this.window = t(this.document[0].defaultView || this.document[0].parentWindow)), this._create(), this._trigger("create", null, this._getCreateEventData()), this._init()
        },
        _getCreateOptions: t.noop,
        _getCreateEventData: t.noop,
        _create: t.noop,
        _init: t.noop,
        destroy: function () {
            this._destroy(), this.element.unbind(this.eventNamespace).removeData(this.widgetName).removeData(this.widgetFullName).removeData(t.camelCase(this.widgetFullName)), this.widget().unbind(this.eventNamespace).removeAttr("aria-disabled").removeClass(this.widgetFullName + "-disabled " + "ui-state-disabled"), this.bindings.unbind(this.eventNamespace), this.hoverable.removeClass("ui-state-hover"), this.focusable.removeClass("ui-state-focus")
        },
        _destroy: t.noop,
        widget: function () {
            return this.element
        },
        option: function (i, s) {
            var n, o, a, r = i;
            if (0 === arguments.length)return t.widget.extend({}, this.options);
            if ("string" == typeof i)if (r = {}, n = i.split("."), i = n.shift(), n.length) {
                for (o = r[i] = t.widget.extend({}, this.options[i]), a = 0; n.length - 1 > a; a++)o[n[a]] = o[n[a]] || {}, o = o[n[a]];
                if (i = n.pop(), 1 === arguments.length)return o[i] === e ? null : o[i];
                o[i] = s
            } else {
                if (1 === arguments.length)return this.options[i] === e ? null : this.options[i];
                r[i] = s
            }
            return this._setOptions(r), this
        },
        _setOptions: function (t) {
            var e;
            for (e in t)this._setOption(e, t[e]);
            return this
        },
        _setOption: function (t, e) {
            return this.options[t] = e, "disabled" === t && (this.widget().toggleClass(this.widgetFullName + "-disabled ui-state-disabled", !!e).attr("aria-disabled", e), this.hoverable.removeClass("ui-state-hover"), this.focusable.removeClass("ui-state-focus")), this
        },
        enable: function () {
            return this._setOption("disabled", !1)
        },
        disable: function () {
            return this._setOption("disabled", !0)
        },
        _on: function (i, s, n) {
            var o, a = this;
            "boolean" != typeof i && (n = s, s = i, i = !1), n ? (s = o = t(s), this.bindings = this.bindings.add(s)) : (n = s, s = this.element, o = this.widget()), t.each(n, function (n, r) {
                function h() {
                    return i || a.options.disabled !== !0 && !t(this).hasClass("ui-state-disabled") ? ("string" == typeof r ? a[r] : r).apply(a, arguments) : e
                }

                "string" != typeof r && (h.guid = r.guid = r.guid || h.guid || t.guid++);
                var l = n.match(/^(\w+)\s*(.*)$/), c = l[1] + a.eventNamespace, u = l[2];
                u ? o.delegate(u, c, h) : s.bind(c, h)
            })
        },
        _off: function (t, e) {
            e = (e || "").split(" ").join(this.eventNamespace + " ") + this.eventNamespace, t.unbind(e).undelegate(e)
        },
        _delay: function (t, e) {
            function i() {
                return ("string" == typeof t ? s[t] : t).apply(s, arguments)
            }

            var s = this;
            return setTimeout(i, e || 0)
        },
        _hoverable: function (e) {
            this.hoverable = this.hoverable.add(e), this._on(e, {
                mouseenter: function (e) {
                    t(e.currentTarget).addClass("ui-state-hover")
                }, mouseleave: function (e) {
                    t(e.currentTarget).removeClass("ui-state-hover")
                }
            })
        },
        _focusable: function (e) {
            this.focusable = this.focusable.add(e), this._on(e, {
                focusin: function (e) {
                    t(e.currentTarget).addClass("ui-state-focus")
                }, focusout: function (e) {
                    t(e.currentTarget).removeClass("ui-state-focus")
                }
            })
        },
        _trigger: function (e, i, s) {
            var n, o, a = this.options[e];
            if (s = s || {}, i = t.Event(i), i.type = (e === this.widgetEventPrefix ? e : this.widgetEventPrefix + e).toLowerCase(), i.target = this.element[0], o = i.originalEvent)for (n in o)n in i || (i[n] = o[n]);
            return this.element.trigger(i, s), !(t.isFunction(a) && a.apply(this.element[0], [i].concat(s)) === !1 || i.isDefaultPrevented())
        }
    }, t.each({show: "fadeIn", hide: "fadeOut"}, function (e, i) {
        t.Widget.prototype["_" + e] = function (s, n, o) {
            "string" == typeof n && (n = {effect: n});
            var a, r = n ? n === !0 || "number" == typeof n ? i : n.effect || i : e;
            n = n || {}, "number" == typeof n && (n = {duration: n}), a = !t.isEmptyObject(n), n.complete = o, n.delay && s.delay(n.delay), a && t.effects && t.effects.effect[r] ? s[e](n) : r !== e && s[r] ? s[r](n.duration, n.easing, o) : s.queue(function (i) {
                t(this)[e](), o && o.call(s[0]), i()
            })
        }
    })
})(jQuery);
(function (t) {
    var e = !1;
    t(document).mouseup(function () {
        e = !1
    }), t.widget("ui.mouse", {
        version: "1.10.4",
        options: {cancel: "input,textarea,button,select,option", distance: 1, delay: 0},
        _mouseInit: function () {
            var e = this;
            this.element.bind("mousedown." + this.widgetName, function (t) {
                return e._mouseDown(t)
            }).bind("click." + this.widgetName, function (i) {
                return !0 === t.data(i.target, e.widgetName + ".preventClickEvent") ? (t.removeData(i.target, e.widgetName + ".preventClickEvent"), i.stopImmediatePropagation(), !1) : undefined
            }), this.started = !1
        },
        _mouseDestroy: function () {
            this.element.unbind("." + this.widgetName), this._mouseMoveDelegate && t(document).unbind("mousemove." + this.widgetName, this._mouseMoveDelegate).unbind("mouseup." + this.widgetName, this._mouseUpDelegate)
        },
        _mouseDown: function (i) {
            if (!e) {
                this._mouseStarted && this._mouseUp(i), this._mouseDownEvent = i;
                var s = this, n = 1 === i.which, a = "string" == typeof this.options.cancel && i.target.nodeName ? t(i.target).closest(this.options.cancel).length : !1;
                return n && !a && this._mouseCapture(i) ? (this.mouseDelayMet = !this.options.delay, this.mouseDelayMet || (this._mouseDelayTimer = setTimeout(function () {
                    s.mouseDelayMet = !0
                }, this.options.delay)), this._mouseDistanceMet(i) && this._mouseDelayMet(i) && (this._mouseStarted = this._mouseStart(i) !== !1, !this._mouseStarted) ? (i.preventDefault(), !0) : (!0 === t.data(i.target, this.widgetName + ".preventClickEvent") && t.removeData(i.target, this.widgetName + ".preventClickEvent"), this._mouseMoveDelegate = function (t) {
                    return s._mouseMove(t)
                }, this._mouseUpDelegate = function (t) {
                    return s._mouseUp(t)
                }, t(document).bind("mousemove." + this.widgetName, this._mouseMoveDelegate).bind("mouseup." + this.widgetName, this._mouseUpDelegate), i.preventDefault(), e = !0, !0)) : !0
            }
        },
        _mouseMove: function (e) {
            return t.ui.ie && (!document.documentMode || 9 > document.documentMode) && !e.button ? this._mouseUp(e) : this._mouseStarted ? (this._mouseDrag(e), e.preventDefault()) : (this._mouseDistanceMet(e) && this._mouseDelayMet(e) && (this._mouseStarted = this._mouseStart(this._mouseDownEvent, e) !== !1, this._mouseStarted ? this._mouseDrag(e) : this._mouseUp(e)), !this._mouseStarted)
        },
        _mouseUp: function (e) {
            return t(document).unbind("mousemove." + this.widgetName, this._mouseMoveDelegate).unbind("mouseup." + this.widgetName, this._mouseUpDelegate), this._mouseStarted && (this._mouseStarted = !1, e.target === this._mouseDownEvent.target && t.data(e.target, this.widgetName + ".preventClickEvent", !0), this._mouseStop(e)), !1
        },
        _mouseDistanceMet: function (t) {
            return Math.max(Math.abs(this._mouseDownEvent.pageX - t.pageX), Math.abs(this._mouseDownEvent.pageY - t.pageY)) >= this.options.distance
        },
        _mouseDelayMet: function () {
            return this.mouseDelayMet
        },
        _mouseStart: function () {
        },
        _mouseDrag: function () {
        },
        _mouseStop: function () {
        },
        _mouseCapture: function () {
            return !0
        }
    })
})(jQuery);
(function (t, e) {
    function i(t, e, i) {
        return [parseFloat(t[0]) * (p.test(t[0]) ? e / 100 : 1), parseFloat(t[1]) * (p.test(t[1]) ? i / 100 : 1)]
    }

    function s(e, i) {
        return parseInt(t.css(e, i), 10) || 0
    }

    function n(e) {
        var i = e[0];
        return 9 === i.nodeType ? {
            width: e.width(),
            height: e.height(),
            offset: {top: 0, left: 0}
        } : t.isWindow(i) ? {
            width: e.width(),
            height: e.height(),
            offset: {top: e.scrollTop(), left: e.scrollLeft()}
        } : i.preventDefault ? {width: 0, height: 0, offset: {top: i.pageY, left: i.pageX}} : {
            width: e.outerWidth(),
            height: e.outerHeight(),
            offset: e.offset()
        }
    }

    t.ui = t.ui || {};
    var a, o = Math.max, r = Math.abs, l = Math.round, h = /left|center|right/, c = /top|center|bottom/, u = /[\+\-]\d+(\.[\d]+)?%?/, d = /^\w+/, p = /%$/, f = t.fn.position;
    t.position = {
        scrollbarWidth: function () {
            if (a !== e)return a;
            var i, s, n = t("<div style='display:block;position:absolute;width:50px;height:50px;overflow:hidden;'><div style='height:100px;width:auto;'></div></div>"), o = n.children()[0];
            return t("body").append(n), i = o.offsetWidth, n.css("overflow", "scroll"), s = o.offsetWidth, i === s && (s = n[0].clientWidth), n.remove(), a = i - s
        }, getScrollInfo: function (e) {
            var i = e.isWindow || e.isDocument ? "" : e.element.css("overflow-x"), s = e.isWindow || e.isDocument ? "" : e.element.css("overflow-y"), n = "scroll" === i || "auto" === i && e.width < e.element[0].scrollWidth, a = "scroll" === s || "auto" === s && e.height < e.element[0].scrollHeight;
            return {width: a ? t.position.scrollbarWidth() : 0, height: n ? t.position.scrollbarWidth() : 0}
        }, getWithinInfo: function (e) {
            var i = t(e || window), s = t.isWindow(i[0]), n = !!i[0] && 9 === i[0].nodeType;
            return {
                element: i,
                isWindow: s,
                isDocument: n,
                offset: i.offset() || {left: 0, top: 0},
                scrollLeft: i.scrollLeft(),
                scrollTop: i.scrollTop(),
                width: s ? i.width() : i.outerWidth(),
                height: s ? i.height() : i.outerHeight()
            }
        }
    }, t.fn.position = function (e) {
        if (!e || !e.of)return f.apply(this, arguments);
        e = t.extend({}, e);
        var a, p, g, m, v, _, b = t(e.of), y = t.position.getWithinInfo(e.within), k = t.position.getScrollInfo(y), w = (e.collision || "flip").split(" "), D = {};
        return _ = n(b), b[0].preventDefault && (e.at = "left top"), p = _.width, g = _.height, m = _.offset, v = t.extend({}, m), t.each(["my", "at"], function () {
            var t, i, s = (e[this] || "").split(" ");
            1 === s.length && (s = h.test(s[0]) ? s.concat(["center"]) : c.test(s[0]) ? ["center"].concat(s) : ["center", "center"]), s[0] = h.test(s[0]) ? s[0] : "center", s[1] = c.test(s[1]) ? s[1] : "center", t = u.exec(s[0]), i = u.exec(s[1]), D[this] = [t ? t[0] : 0, i ? i[0] : 0], e[this] = [d.exec(s[0])[0], d.exec(s[1])[0]]
        }), 1 === w.length && (w[1] = w[0]), "right" === e.at[0] ? v.left += p : "center" === e.at[0] && (v.left += p / 2), "bottom" === e.at[1] ? v.top += g : "center" === e.at[1] && (v.top += g / 2), a = i(D.at, p, g), v.left += a[0], v.top += a[1], this.each(function () {
            var n, h, c = t(this), u = c.outerWidth(), d = c.outerHeight(), f = s(this, "marginLeft"), _ = s(this, "marginTop"), x = u + f + s(this, "marginRight") + k.width, C = d + _ + s(this, "marginBottom") + k.height, M = t.extend({}, v), T = i(D.my, c.outerWidth(), c.outerHeight());
            "right" === e.my[0] ? M.left -= u : "center" === e.my[0] && (M.left -= u / 2), "bottom" === e.my[1] ? M.top -= d : "center" === e.my[1] && (M.top -= d / 2), M.left += T[0], M.top += T[1], t.support.offsetFractions || (M.left = l(M.left), M.top = l(M.top)), n = {
                marginLeft: f,
                marginTop: _
            }, t.each(["left", "top"], function (i, s) {
                t.ui.position[w[i]] && t.ui.position[w[i]][s](M, {
                    targetWidth: p,
                    targetHeight: g,
                    elemWidth: u,
                    elemHeight: d,
                    collisionPosition: n,
                    collisionWidth: x,
                    collisionHeight: C,
                    offset: [a[0] + T[0], a[1] + T[1]],
                    my: e.my,
                    at: e.at,
                    within: y,
                    elem: c
                })
            }), e.using && (h = function (t) {
                var i = m.left - M.left, s = i + p - u, n = m.top - M.top, a = n + g - d, l = {
                    target: {
                        element: b,
                        left: m.left,
                        top: m.top,
                        width: p,
                        height: g
                    },
                    element: {element: c, left: M.left, top: M.top, width: u, height: d},
                    horizontal: 0 > s ? "left" : i > 0 ? "right" : "center",
                    vertical: 0 > a ? "top" : n > 0 ? "bottom" : "middle"
                };
                u > p && p > r(i + s) && (l.horizontal = "center"), d > g && g > r(n + a) && (l.vertical = "middle"), l.important = o(r(i), r(s)) > o(r(n), r(a)) ? "horizontal" : "vertical", e.using.call(this, t, l)
            }), c.offset(t.extend(M, {using: h}))
        })
    }, t.ui.position = {
        fit: {
            left: function (t, e) {
                var i, s = e.within, n = s.isWindow ? s.scrollLeft : s.offset.left, a = s.width, r = t.left - e.collisionPosition.marginLeft, l = n - r, h = r + e.collisionWidth - a - n;
                e.collisionWidth > a ? l > 0 && 0 >= h ? (i = t.left + l + e.collisionWidth - a - n, t.left += l - i) : t.left = h > 0 && 0 >= l ? n : l > h ? n + a - e.collisionWidth : n : l > 0 ? t.left += l : h > 0 ? t.left -= h : t.left = o(t.left - r, t.left)
            }, top: function (t, e) {
                var i, s = e.within, n = s.isWindow ? s.scrollTop : s.offset.top, a = e.within.height, r = t.top - e.collisionPosition.marginTop, l = n - r, h = r + e.collisionHeight - a - n;
                e.collisionHeight > a ? l > 0 && 0 >= h ? (i = t.top + l + e.collisionHeight - a - n, t.top += l - i) : t.top = h > 0 && 0 >= l ? n : l > h ? n + a - e.collisionHeight : n : l > 0 ? t.top += l : h > 0 ? t.top -= h : t.top = o(t.top - r, t.top)
            }
        }, flip: {
            left: function (t, e) {
                var i, s, n = e.within, a = n.offset.left + n.scrollLeft, o = n.width, l = n.isWindow ? n.scrollLeft : n.offset.left, h = t.left - e.collisionPosition.marginLeft, c = h - l, u = h + e.collisionWidth - o - l, d = "left" === e.my[0] ? -e.elemWidth : "right" === e.my[0] ? e.elemWidth : 0, p = "left" === e.at[0] ? e.targetWidth : "right" === e.at[0] ? -e.targetWidth : 0, f = -2 * e.offset[0];
                0 > c ? (i = t.left + d + p + f + e.collisionWidth - o - a, (0 > i || r(c) > i) && (t.left += d + p + f)) : u > 0 && (s = t.left - e.collisionPosition.marginLeft + d + p + f - l, (s > 0 || u > r(s)) && (t.left += d + p + f))
            }, top: function (t, e) {
                var i, s, n = e.within, a = n.offset.top + n.scrollTop, o = n.height, l = n.isWindow ? n.scrollTop : n.offset.top, h = t.top - e.collisionPosition.marginTop, c = h - l, u = h + e.collisionHeight - o - l, d = "top" === e.my[1], p = d ? -e.elemHeight : "bottom" === e.my[1] ? e.elemHeight : 0, f = "top" === e.at[1] ? e.targetHeight : "bottom" === e.at[1] ? -e.targetHeight : 0, g = -2 * e.offset[1];
                0 > c ? (s = t.top + p + f + g + e.collisionHeight - o - a, t.top + p + f + g > c && (0 > s || r(c) > s) && (t.top += p + f + g)) : u > 0 && (i = t.top - e.collisionPosition.marginTop + p + f + g - l, t.top + p + f + g > u && (i > 0 || u > r(i)) && (t.top += p + f + g))
            }
        }, flipfit: {
            left: function () {
                t.ui.position.flip.left.apply(this, arguments), t.ui.position.fit.left.apply(this, arguments)
            }, top: function () {
                t.ui.position.flip.top.apply(this, arguments), t.ui.position.fit.top.apply(this, arguments)
            }
        }
    }, function () {
        var e, i, s, n, a, o = document.getElementsByTagName("body")[0], r = document.createElement("div");
        e = document.createElement(o ? "div" : "body"), s = {
            visibility: "hidden",
            width: 0,
            height: 0,
            border: 0,
            margin: 0,
            background: "none"
        }, o && t.extend(s, {position: "absolute", left: "-1000px", top: "-1000px"});
        for (a in s)e.style[a] = s[a];
        e.appendChild(r), i = o || document.documentElement, i.insertBefore(e, i.firstChild), r.style.cssText = "position: absolute; left: 10.7432222px;", n = t(r).offset().left, t.support.offsetFractions = n > 10 && 11 > n, e.innerHTML = "", i.removeChild(e)
    }()
})(jQuery);
(function (t) {
    t.widget("ui.draggable", t.ui.mouse, {
        version: "1.10.4",
        widgetEventPrefix: "drag",
        options: {
            addClasses: !0,
            appendTo: "parent",
            axis: !1,
            connectToSortable: !1,
            containment: !1,
            cursor: "auto",
            cursorAt: !1,
            grid: !1,
            handle: !1,
            helper: "original",
            iframeFix: !1,
            opacity: !1,
            refreshPositions: !1,
            revert: !1,
            revertDuration: 500,
            scope: "default",
            scroll: !0,
            scrollSensitivity: 20,
            scrollSpeed: 20,
            snap: !1,
            snapMode: "both",
            snapTolerance: 20,
            stack: !1,
            zIndex: !1,
            drag: null,
            start: null,
            stop: null
        },
        _create: function () {
            "original" !== this.options.helper || /^(?:r|a|f)/.test(this.element.css("position")) || (this.element[0].style.position = "relative"), this.options.addClasses && this.element.addClass("ui-draggable"), this.options.disabled && this.element.addClass("ui-draggable-disabled"), this._mouseInit()
        },
        _destroy: function () {
            this.element.removeClass("ui-draggable ui-draggable-dragging ui-draggable-disabled"), this._mouseDestroy()
        },
        _mouseCapture: function (e) {
            var i = this.options;
            return this.helper || i.disabled || t(e.target).closest(".ui-resizable-handle").length > 0 ? !1 : (this.handle = this._getHandle(e), this.handle ? (t(i.iframeFix === !0 ? "iframe" : i.iframeFix).each(function () {
                t("<div class='ui-draggable-iframeFix' style='background: #fff;'></div>").css({
                    width: this.offsetWidth + "px",
                    height: this.offsetHeight + "px",
                    position: "absolute",
                    opacity: "0.001",
                    zIndex: 1e3
                }).css(t(this).offset()).appendTo("body")
            }), !0) : !1)
        },
        _mouseStart: function (e) {
            var i = this.options;
            return this.helper = this._createHelper(e), this.helper.addClass("ui-draggable-dragging"), this._cacheHelperProportions(), t.ui.ddmanager && (t.ui.ddmanager.current = this), this._cacheMargins(), this.cssPosition = this.helper.css("position"), this.scrollParent = this.helper.scrollParent(), this.offsetParent = this.helper.offsetParent(), this.offsetParentCssPosition = this.offsetParent.css("position"), this.offset = this.positionAbs = this.element.offset(), this.offset = {
                top: this.offset.top - this.margins.top,
                left: this.offset.left - this.margins.left
            }, this.offset.scroll = !1, t.extend(this.offset, {
                click: {
                    left: e.pageX - this.offset.left,
                    top: e.pageY - this.offset.top
                }, parent: this._getParentOffset(), relative: this._getRelativeOffset()
            }), this.originalPosition = this.position = this._generatePosition(e), this.originalPageX = e.pageX, this.originalPageY = e.pageY, i.cursorAt && this._adjustOffsetFromHelper(i.cursorAt), this._setContainment(), this._trigger("start", e) === !1 ? (this._clear(), !1) : (this._cacheHelperProportions(), t.ui.ddmanager && !i.dropBehaviour && t.ui.ddmanager.prepareOffsets(this, e), this._mouseDrag(e, !0), t.ui.ddmanager && t.ui.ddmanager.dragStart(this, e), !0)
        },
        _mouseDrag: function (e, i) {
            if ("fixed" === this.offsetParentCssPosition && (this.offset.parent = this._getParentOffset()), this.position = this._generatePosition(e), this.positionAbs = this._convertPositionTo("absolute"), !i) {
                var s = this._uiHash();
                if (this._trigger("drag", e, s) === !1)return this._mouseUp({}), !1;
                this.position = s.position
            }
            return this.options.axis && "y" === this.options.axis || (this.helper[0].style.left = this.position.left + "px"), this.options.axis && "x" === this.options.axis || (this.helper[0].style.top = this.position.top + "px"), t.ui.ddmanager && t.ui.ddmanager.drag(this, e), !1
        },
        _mouseStop: function (e) {
            var i = this, s = !1;
            return t.ui.ddmanager && !this.options.dropBehaviour && (s = t.ui.ddmanager.drop(this, e)), this.dropped && (s = this.dropped, this.dropped = !1), "original" !== this.options.helper || t.contains(this.element[0].ownerDocument, this.element[0]) ? ("invalid" === this.options.revert && !s || "valid" === this.options.revert && s || this.options.revert === !0 || t.isFunction(this.options.revert) && this.options.revert.call(this.element, s) ? t(this.helper).animate(this.originalPosition, parseInt(this.options.revertDuration, 10), function () {
                i._trigger("stop", e) !== !1 && i._clear()
            }) : this._trigger("stop", e) !== !1 && this._clear(), !1) : !1
        },
        _mouseUp: function (e) {
            return t("div.ui-draggable-iframeFix").each(function () {
                this.parentNode.removeChild(this)
            }), t.ui.ddmanager && t.ui.ddmanager.dragStop(this, e), t.ui.mouse.prototype._mouseUp.call(this, e)
        },
        cancel: function () {
            return this.helper.is(".ui-draggable-dragging") ? this._mouseUp({}) : this._clear(), this
        },
        _getHandle: function (e) {
            return this.options.handle ? !!t(e.target).closest(this.element.find(this.options.handle)).length : !0
        },
        _createHelper: function (e) {
            var i = this.options, s = t.isFunction(i.helper) ? t(i.helper.apply(this.element[0], [e])) : "clone" === i.helper ? this.element.clone().removeAttr("id") : this.element;
            return s.parents("body").length || s.appendTo("parent" === i.appendTo ? this.element[0].parentNode : i.appendTo), s[0] === this.element[0] || /(fixed|absolute)/.test(s.css("position")) || s.css("position", "absolute"), s
        },
        _adjustOffsetFromHelper: function (e) {
            "string" == typeof e && (e = e.split(" ")), t.isArray(e) && (e = {
                left: +e[0],
                top: +e[1] || 0
            }), "left"in e && (this.offset.click.left = e.left + this.margins.left), "right"in e && (this.offset.click.left = this.helperProportions.width - e.right + this.margins.left), "top"in e && (this.offset.click.top = e.top + this.margins.top), "bottom"in e && (this.offset.click.top = this.helperProportions.height - e.bottom + this.margins.top)
        },
        _getParentOffset: function () {
            var e = this.offsetParent.offset();
            return "absolute" === this.cssPosition && this.scrollParent[0] !== document && t.contains(this.scrollParent[0], this.offsetParent[0]) && (e.left += this.scrollParent.scrollLeft(), e.top += this.scrollParent.scrollTop()), (this.offsetParent[0] === document.body || this.offsetParent[0].tagName && "html" === this.offsetParent[0].tagName.toLowerCase() && t.ui.ie) && (e = {
                top: 0,
                left: 0
            }), {
                top: e.top + (parseInt(this.offsetParent.css("borderTopWidth"), 10) || 0),
                left: e.left + (parseInt(this.offsetParent.css("borderLeftWidth"), 10) || 0)
            }
        },
        _getRelativeOffset: function () {
            if ("relative" === this.cssPosition) {
                var t = this.element.position();
                return {
                    top: t.top - (parseInt(this.helper.css("top"), 10) || 0) + this.scrollParent.scrollTop(),
                    left: t.left - (parseInt(this.helper.css("left"), 10) || 0) + this.scrollParent.scrollLeft()
                }
            }
            return {top: 0, left: 0}
        },
        _cacheMargins: function () {
            this.margins = {
                left: parseInt(this.element.css("marginLeft"), 10) || 0,
                top: parseInt(this.element.css("marginTop"), 10) || 0,
                right: parseInt(this.element.css("marginRight"), 10) || 0,
                bottom: parseInt(this.element.css("marginBottom"), 10) || 0
            }
        },
        _cacheHelperProportions: function () {
            this.helperProportions = {width: this.helper.outerWidth(), height: this.helper.outerHeight()}
        },
        _setContainment: function () {
            var e, i, s, n = this.options;
            return n.containment ? "window" === n.containment ? (this.containment = [t(window).scrollLeft() - this.offset.relative.left - this.offset.parent.left, t(window).scrollTop() - this.offset.relative.top - this.offset.parent.top, t(window).scrollLeft() + t(window).width() - this.helperProportions.width - this.margins.left, t(window).scrollTop() + (t(window).height() || document.body.parentNode.scrollHeight) - this.helperProportions.height - this.margins.top], undefined) : "document" === n.containment ? (this.containment = [0, 0, t(document).width() - this.helperProportions.width - this.margins.left, (t(document).height() || document.body.parentNode.scrollHeight) - this.helperProportions.height - this.margins.top], undefined) : n.containment.constructor === Array ? (this.containment = n.containment, undefined) : ("parent" === n.containment && (n.containment = this.helper[0].parentNode), i = t(n.containment), s = i[0], s && (e = "hidden" !== i.css("overflow"), this.containment = [(parseInt(i.css("borderLeftWidth"), 10) || 0) + (parseInt(i.css("paddingLeft"), 10) || 0), (parseInt(i.css("borderTopWidth"), 10) || 0) + (parseInt(i.css("paddingTop"), 10) || 0), (e ? Math.max(s.scrollWidth, s.offsetWidth) : s.offsetWidth) - (parseInt(i.css("borderRightWidth"), 10) || 0) - (parseInt(i.css("paddingRight"), 10) || 0) - this.helperProportions.width - this.margins.left - this.margins.right, (e ? Math.max(s.scrollHeight, s.offsetHeight) : s.offsetHeight) - (parseInt(i.css("borderBottomWidth"), 10) || 0) - (parseInt(i.css("paddingBottom"), 10) || 0) - this.helperProportions.height - this.margins.top - this.margins.bottom], this.relative_container = i), undefined) : (this.containment = null, undefined)
        },
        _convertPositionTo: function (e, i) {
            i || (i = this.position);
            var s = "absolute" === e ? 1 : -1, n = "absolute" !== this.cssPosition || this.scrollParent[0] !== document && t.contains(this.scrollParent[0], this.offsetParent[0]) ? this.scrollParent : this.offsetParent;
            return this.offset.scroll || (this.offset.scroll = {
                top: n.scrollTop(),
                left: n.scrollLeft()
            }), {
                top: i.top + this.offset.relative.top * s + this.offset.parent.top * s - ("fixed" === this.cssPosition ? -this.scrollParent.scrollTop() : this.offset.scroll.top) * s,
                left: i.left + this.offset.relative.left * s + this.offset.parent.left * s - ("fixed" === this.cssPosition ? -this.scrollParent.scrollLeft() : this.offset.scroll.left) * s
            }
        },
        _generatePosition: function (e) {
            var i, s, n, a, o = this.options, r = "absolute" !== this.cssPosition || this.scrollParent[0] !== document && t.contains(this.scrollParent[0], this.offsetParent[0]) ? this.scrollParent : this.offsetParent, l = e.pageX, h = e.pageY;
            return this.offset.scroll || (this.offset.scroll = {
                top: r.scrollTop(),
                left: r.scrollLeft()
            }), this.originalPosition && (this.containment && (this.relative_container ? (s = this.relative_container.offset(), i = [this.containment[0] + s.left, this.containment[1] + s.top, this.containment[2] + s.left, this.containment[3] + s.top]) : i = this.containment, e.pageX - this.offset.click.left < i[0] && (l = i[0] + this.offset.click.left), e.pageY - this.offset.click.top < i[1] && (h = i[1] + this.offset.click.top), e.pageX - this.offset.click.left > i[2] && (l = i[2] + this.offset.click.left), e.pageY - this.offset.click.top > i[3] && (h = i[3] + this.offset.click.top)), o.grid && (n = o.grid[1] ? this.originalPageY + Math.round((h - this.originalPageY) / o.grid[1]) * o.grid[1] : this.originalPageY, h = i ? n - this.offset.click.top >= i[1] || n - this.offset.click.top > i[3] ? n : n - this.offset.click.top >= i[1] ? n - o.grid[1] : n + o.grid[1] : n, a = o.grid[0] ? this.originalPageX + Math.round((l - this.originalPageX) / o.grid[0]) * o.grid[0] : this.originalPageX, l = i ? a - this.offset.click.left >= i[0] || a - this.offset.click.left > i[2] ? a : a - this.offset.click.left >= i[0] ? a - o.grid[0] : a + o.grid[0] : a)), {
                top: h - this.offset.click.top - this.offset.relative.top - this.offset.parent.top + ("fixed" === this.cssPosition ? -this.scrollParent.scrollTop() : this.offset.scroll.top),
                left: l - this.offset.click.left - this.offset.relative.left - this.offset.parent.left + ("fixed" === this.cssPosition ? -this.scrollParent.scrollLeft() : this.offset.scroll.left)
            }
        },
        _clear: function () {
            this.helper.removeClass("ui-draggable-dragging"), this.helper[0] === this.element[0] || this.cancelHelperRemoval || this.helper.remove(), this.helper = null, this.cancelHelperRemoval = !1
        },
        _trigger: function (e, i, s) {
            return s = s || this._uiHash(), t.ui.plugin.call(this, e, [i, s]), "drag" === e && (this.positionAbs = this._convertPositionTo("absolute")), t.Widget.prototype._trigger.call(this, e, i, s)
        },
        plugins: {},
        _uiHash: function () {
            return {
                helper: this.helper,
                position: this.position,
                originalPosition: this.originalPosition,
                offset: this.positionAbs
            }
        }
    }), t.ui.plugin.add("draggable", "connectToSortable", {
        start: function (e, i) {
            var s = t(this).data("ui-draggable"), n = s.options, a = t.extend({}, i, {item: s.element});
            s.sortables = [], t(n.connectToSortable).each(function () {
                var i = t.data(this, "ui-sortable");
                i && !i.options.disabled && (s.sortables.push({
                    instance: i,
                    shouldRevert: i.options.revert
                }), i.refreshPositions(), i._trigger("activate", e, a))
            })
        }, stop: function (e, i) {
            var s = t(this).data("ui-draggable"), n = t.extend({}, i, {item: s.element});
            t.each(s.sortables, function () {
                this.instance.isOver ? (this.instance.isOver = 0, s.cancelHelperRemoval = !0, this.instance.cancelHelperRemoval = !1, this.shouldRevert && (this.instance.options.revert = this.shouldRevert), this.instance._mouseStop(e), this.instance.options.helper = this.instance.options._helper, "original" === s.options.helper && this.instance.currentItem.css({
                    top: "auto",
                    left: "auto"
                })) : (this.instance.cancelHelperRemoval = !1, this.instance._trigger("deactivate", e, n))
            })
        }, drag: function (e, i) {
            var s = t(this).data("ui-draggable"), n = this;
            t.each(s.sortables, function () {
                var a = !1, o = this;
                this.instance.positionAbs = s.positionAbs, this.instance.helperProportions = s.helperProportions, this.instance.offset.click = s.offset.click, this.instance._intersectsWith(this.instance.containerCache) && (a = !0, t.each(s.sortables, function () {
                    return this.instance.positionAbs = s.positionAbs, this.instance.helperProportions = s.helperProportions, this.instance.offset.click = s.offset.click, this !== o && this.instance._intersectsWith(this.instance.containerCache) && t.contains(o.instance.element[0], this.instance.element[0]) && (a = !1), a
                })), a ? (this.instance.isOver || (this.instance.isOver = 1, this.instance.currentItem = t(n).clone().removeAttr("id").appendTo(this.instance.element).data("ui-sortable-item", !0), this.instance.options._helper = this.instance.options.helper, this.instance.options.helper = function () {
                    return i.helper[0]
                }, e.target = this.instance.currentItem[0], this.instance._mouseCapture(e, !0), this.instance._mouseStart(e, !0, !0), this.instance.offset.click.top = s.offset.click.top, this.instance.offset.click.left = s.offset.click.left, this.instance.offset.parent.left -= s.offset.parent.left - this.instance.offset.parent.left, this.instance.offset.parent.top -= s.offset.parent.top - this.instance.offset.parent.top, s._trigger("toSortable", e), s.dropped = this.instance.element, s.currentItem = s.element, this.instance.fromOutside = s), this.instance.currentItem && this.instance._mouseDrag(e)) : this.instance.isOver && (this.instance.isOver = 0, this.instance.cancelHelperRemoval = !0, this.instance.options.revert = !1, this.instance._trigger("out", e, this.instance._uiHash(this.instance)), this.instance._mouseStop(e, !0), this.instance.options.helper = this.instance.options._helper, this.instance.currentItem.remove(), this.instance.placeholder && this.instance.placeholder.remove(), s._trigger("fromSortable", e), s.dropped = !1)
            })
        }
    }), t.ui.plugin.add("draggable", "cursor", {
        start: function () {
            var e = t("body"), i = t(this).data("ui-draggable").options;
            e.css("cursor") && (i._cursor = e.css("cursor")), e.css("cursor", i.cursor)
        }, stop: function () {
            var e = t(this).data("ui-draggable").options;
            e._cursor && t("body").css("cursor", e._cursor)
        }
    }), t.ui.plugin.add("draggable", "opacity", {
        start: function (e, i) {
            var s = t(i.helper), n = t(this).data("ui-draggable").options;
            s.css("opacity") && (n._opacity = s.css("opacity")), s.css("opacity", n.opacity)
        }, stop: function (e, i) {
            var s = t(this).data("ui-draggable").options;
            s._opacity && t(i.helper).css("opacity", s._opacity)
        }
    }), t.ui.plugin.add("draggable", "scroll", {
        start: function () {
            var e = t(this).data("ui-draggable");
            e.scrollParent[0] !== document && "HTML" !== e.scrollParent[0].tagName && (e.overflowOffset = e.scrollParent.offset())
        }, drag: function (e) {
            var i = t(this).data("ui-draggable"), s = i.options, n = !1;
            i.scrollParent[0] !== document && "HTML" !== i.scrollParent[0].tagName ? (s.axis && "x" === s.axis || (i.overflowOffset.top + i.scrollParent[0].offsetHeight - e.pageY < s.scrollSensitivity ? i.scrollParent[0].scrollTop = n = i.scrollParent[0].scrollTop + s.scrollSpeed : e.pageY - i.overflowOffset.top < s.scrollSensitivity && (i.scrollParent[0].scrollTop = n = i.scrollParent[0].scrollTop - s.scrollSpeed)), s.axis && "y" === s.axis || (i.overflowOffset.left + i.scrollParent[0].offsetWidth - e.pageX < s.scrollSensitivity ? i.scrollParent[0].scrollLeft = n = i.scrollParent[0].scrollLeft + s.scrollSpeed : e.pageX - i.overflowOffset.left < s.scrollSensitivity && (i.scrollParent[0].scrollLeft = n = i.scrollParent[0].scrollLeft - s.scrollSpeed))) : (s.axis && "x" === s.axis || (e.pageY - t(document).scrollTop() < s.scrollSensitivity ? n = t(document).scrollTop(t(document).scrollTop() - s.scrollSpeed) : t(window).height() - (e.pageY - t(document).scrollTop()) < s.scrollSensitivity && (n = t(document).scrollTop(t(document).scrollTop() + s.scrollSpeed))), s.axis && "y" === s.axis || (e.pageX - t(document).scrollLeft() < s.scrollSensitivity ? n = t(document).scrollLeft(t(document).scrollLeft() - s.scrollSpeed) : t(window).width() - (e.pageX - t(document).scrollLeft()) < s.scrollSensitivity && (n = t(document).scrollLeft(t(document).scrollLeft() + s.scrollSpeed)))), n !== !1 && t.ui.ddmanager && !s.dropBehaviour && t.ui.ddmanager.prepareOffsets(i, e)
        }
    }), t.ui.plugin.add("draggable", "snap", {
        start: function () {
            var e = t(this).data("ui-draggable"), i = e.options;
            e.snapElements = [], t(i.snap.constructor !== String ? i.snap.items || ":data(ui-draggable)" : i.snap).each(function () {
                var i = t(this), s = i.offset();
                this !== e.element[0] && e.snapElements.push({
                    item: this,
                    width: i.outerWidth(),
                    height: i.outerHeight(),
                    top: s.top,
                    left: s.left
                })
            })
        }, drag: function (e, i) {
            var s, n, a, o, r, l, h, c, u, d, p = t(this).data("ui-draggable"), g = p.options, f = g.snapTolerance, m = i.offset.left, _ = m + p.helperProportions.width, v = i.offset.top, b = v + p.helperProportions.height;
            for (u = p.snapElements.length - 1; u >= 0; u--)r = p.snapElements[u].left, l = r + p.snapElements[u].width, h = p.snapElements[u].top, c = h + p.snapElements[u].height, r - f > _ || m > l + f || h - f > b || v > c + f || !t.contains(p.snapElements[u].item.ownerDocument, p.snapElements[u].item) ? (p.snapElements[u].snapping && p.options.snap.release && p.options.snap.release.call(p.element, e, t.extend(p._uiHash(), {snapItem: p.snapElements[u].item})), p.snapElements[u].snapping = !1) : ("inner" !== g.snapMode && (s = f >= Math.abs(h - b), n = f >= Math.abs(c - v), a = f >= Math.abs(r - _), o = f >= Math.abs(l - m), s && (i.position.top = p._convertPositionTo("relative", {
                top: h - p.helperProportions.height,
                left: 0
            }).top - p.margins.top), n && (i.position.top = p._convertPositionTo("relative", {
                top: c,
                left: 0
            }).top - p.margins.top), a && (i.position.left = p._convertPositionTo("relative", {
                top: 0,
                left: r - p.helperProportions.width
            }).left - p.margins.left), o && (i.position.left = p._convertPositionTo("relative", {
                top: 0,
                left: l
            }).left - p.margins.left)), d = s || n || a || o, "outer" !== g.snapMode && (s = f >= Math.abs(h - v), n = f >= Math.abs(c - b), a = f >= Math.abs(r - m), o = f >= Math.abs(l - _), s && (i.position.top = p._convertPositionTo("relative", {
                top: h,
                left: 0
            }).top - p.margins.top), n && (i.position.top = p._convertPositionTo("relative", {
                top: c - p.helperProportions.height,
                left: 0
            }).top - p.margins.top), a && (i.position.left = p._convertPositionTo("relative", {
                top: 0,
                left: r
            }).left - p.margins.left), o && (i.position.left = p._convertPositionTo("relative", {
                top: 0,
                left: l - p.helperProportions.width
            }).left - p.margins.left)), !p.snapElements[u].snapping && (s || n || a || o || d) && p.options.snap.snap && p.options.snap.snap.call(p.element, e, t.extend(p._uiHash(), {snapItem: p.snapElements[u].item})), p.snapElements[u].snapping = s || n || a || o || d)
        }
    }), t.ui.plugin.add("draggable", "stack", {
        start: function () {
            var e, i = this.data("ui-draggable").options, s = t.makeArray(t(i.stack)).sort(function (e, i) {
                return (parseInt(t(e).css("zIndex"), 10) || 0) - (parseInt(t(i).css("zIndex"), 10) || 0)
            });
            s.length && (e = parseInt(t(s[0]).css("zIndex"), 10) || 0, t(s).each(function (i) {
                t(this).css("zIndex", e + i)
            }), this.css("zIndex", e + s.length))
        }
    }), t.ui.plugin.add("draggable", "zIndex", {
        start: function (e, i) {
            var s = t(i.helper), n = t(this).data("ui-draggable").options;
            s.css("zIndex") && (n._zIndex = s.css("zIndex")), s.css("zIndex", n.zIndex)
        }, stop: function (e, i) {
            var s = t(this).data("ui-draggable").options;
            s._zIndex && t(i.helper).css("zIndex", s._zIndex)
        }
    })
})(jQuery);
(function (t) {
    function e(t) {
        return parseInt(t, 10) || 0
    }

    function i(t) {
        return !isNaN(parseInt(t, 10))
    }

    t.widget("ui.resizable", t.ui.mouse, {
        version: "1.10.4",
        widgetEventPrefix: "resize",
        options: {
            alsoResize: !1,
            animate: !1,
            animateDuration: "slow",
            animateEasing: "swing",
            aspectRatio: !1,
            autoHide: !1,
            containment: !1,
            ghost: !1,
            grid: !1,
            handles: "e,s,se",
            helper: !1,
            maxHeight: null,
            maxWidth: null,
            minHeight: 10,
            minWidth: 10,
            zIndex: 90,
            resize: null,
            start: null,
            stop: null
        },
        _create: function () {
            var e, i, s, n, a, o = this, r = this.options;
            if (this.element.addClass("ui-resizable"), t.extend(this, {
                    _aspectRatio: !!r.aspectRatio,
                    aspectRatio: r.aspectRatio,
                    originalElement: this.element,
                    _proportionallyResizeElements: [],
                    _helper: r.helper || r.ghost || r.animate ? r.helper || "ui-resizable-helper" : null
                }), this.element[0].nodeName.match(/canvas|textarea|input|select|button|img/i) && (this.element.wrap(t("<div class='ui-wrapper' style='overflow: hidden;'></div>").css({
                    position: this.element.css("position"),
                    width: this.element.outerWidth(),
                    height: this.element.outerHeight(),
                    top: this.element.css("top"),
                    left: this.element.css("left")
                })), this.element = this.element.parent().data("ui-resizable", this.element.data("ui-resizable")), this.elementIsWrapper = !0, this.element.css({
                    marginLeft: this.originalElement.css("marginLeft"),
                    marginTop: this.originalElement.css("marginTop"),
                    marginRight: this.originalElement.css("marginRight"),
                    marginBottom: this.originalElement.css("marginBottom")
                }), this.originalElement.css({
                    marginLeft: 0,
                    marginTop: 0,
                    marginRight: 0,
                    marginBottom: 0
                }), this.originalResizeStyle = this.originalElement.css("resize"), this.originalElement.css("resize", "none"), this._proportionallyResizeElements.push(this.originalElement.css({
                    position: "static",
                    zoom: 1,
                    display: "block"
                })), this.originalElement.css({margin: this.originalElement.css("margin")}), this._proportionallyResize()), this.handles = r.handles || (t(".ui-resizable-handle", this.element).length ? {
                    n: ".ui-resizable-n",
                    e: ".ui-resizable-e",
                    s: ".ui-resizable-s",
                    w: ".ui-resizable-w",
                    se: ".ui-resizable-se",
                    sw: ".ui-resizable-sw",
                    ne: ".ui-resizable-ne",
                    nw: ".ui-resizable-nw"
                } : "e,s,se"), this.handles.constructor === String)for ("all" === this.handles && (this.handles = "n,e,s,w,se,sw,ne,nw"), e = this.handles.split(","), this.handles = {}, i = 0; e.length > i; i++)s = t.trim(e[i]), a = "ui-resizable-" + s, n = t("<div class='ui-resizable-handle " + a + "'></div>"), n.css({zIndex: r.zIndex}), "se" === s && n.addClass("ui-icon ui-icon-gripsmall-diagonal-se"), this.handles[s] = ".ui-resizable-" + s, this.element.append(n);
            this._renderAxis = function (e) {
                var i, s, n, a;
                e = e || this.element;
                for (i in this.handles)this.handles[i].constructor === String && (this.handles[i] = t(this.handles[i], this.element).show()), this.elementIsWrapper && this.originalElement[0].nodeName.match(/textarea|input|select|button/i) && (s = t(this.handles[i], this.element), a = /sw|ne|nw|se|n|s/.test(i) ? s.outerHeight() : s.outerWidth(), n = ["padding", /ne|nw|n/.test(i) ? "Top" : /se|sw|s/.test(i) ? "Bottom" : /^e$/.test(i) ? "Right" : "Left"].join(""), e.css(n, a), this._proportionallyResize()), t(this.handles[i]).length
            }, this._renderAxis(this.element), this._handles = t(".ui-resizable-handle", this.element).disableSelection(), this._handles.mouseover(function () {
                o.resizing || (this.className && (n = this.className.match(/ui-resizable-(se|sw|ne|nw|n|e|s|w)/i)), o.axis = n && n[1] ? n[1] : "se")
            }), r.autoHide && (this._handles.hide(), t(this.element).addClass("ui-resizable-autohide").mouseenter(function () {
                r.disabled || (t(this).removeClass("ui-resizable-autohide"), o._handles.show())
            }).mouseleave(function () {
                r.disabled || o.resizing || (t(this).addClass("ui-resizable-autohide"), o._handles.hide())
            })), this._mouseInit()
        },
        _destroy: function () {
            this._mouseDestroy();
            var e, i = function (e) {
                t(e).removeClass("ui-resizable ui-resizable-disabled ui-resizable-resizing").removeData("resizable").removeData("ui-resizable").unbind(".resizable").find(".ui-resizable-handle").remove()
            };
            return this.elementIsWrapper && (i(this.element), e = this.element, this.originalElement.css({
                position: e.css("position"),
                width: e.outerWidth(),
                height: e.outerHeight(),
                top: e.css("top"),
                left: e.css("left")
            }).insertAfter(e), e.remove()), this.originalElement.css("resize", this.originalResizeStyle), i(this.originalElement), this
        },
        _mouseCapture: function (e) {
            var i, s, n = !1;
            for (i in this.handles)s = t(this.handles[i])[0], (s === e.target || t.contains(s, e.target)) && (n = !0);
            return !this.options.disabled && n
        },
        _mouseStart: function (i) {
            var s, n, a, o = this.options, r = this.element.position(), h = this.element;
            return this.resizing = !0, /absolute/.test(h.css("position")) ? h.css({
                position: "absolute",
                top: h.css("top"),
                left: h.css("left")
            }) : h.is(".ui-draggable") && h.css({
                position: "absolute",
                top: r.top,
                left: r.left
            }), this._renderProxy(), s = e(this.helper.css("left")), n = e(this.helper.css("top")), o.containment && (s += t(o.containment).scrollLeft() || 0, n += t(o.containment).scrollTop() || 0), this.offset = this.helper.offset(), this.position = {
                left: s,
                top: n
            }, this.size = this._helper ? {
                width: this.helper.width(),
                height: this.helper.height()
            } : {width: h.width(), height: h.height()}, this.originalSize = this._helper ? {
                width: h.outerWidth(),
                height: h.outerHeight()
            } : {width: h.width(), height: h.height()}, this.originalPosition = {
                left: s,
                top: n
            }, this.sizeDiff = {
                width: h.outerWidth() - h.width(),
                height: h.outerHeight() - h.height()
            }, this.originalMousePosition = {
                left: i.pageX,
                top: i.pageY
            }, this.aspectRatio = "number" == typeof o.aspectRatio ? o.aspectRatio : this.originalSize.width / this.originalSize.height || 1, a = t(".ui-resizable-" + this.axis).css("cursor"), t("body").css("cursor", "auto" === a ? this.axis + "-resize" : a), h.addClass("ui-resizable-resizing"), this._propagate("start", i), !0
        },
        _mouseDrag: function (e) {
            var i, s = this.helper, n = {}, a = this.originalMousePosition, o = this.axis, r = this.position.top, h = this.position.left, l = this.size.width, c = this.size.height, u = e.pageX - a.left || 0, d = e.pageY - a.top || 0, p = this._change[o];
            return p ? (i = p.apply(this, [e, u, d]), this._updateVirtualBoundaries(e.shiftKey), (this._aspectRatio || e.shiftKey) && (i = this._updateRatio(i, e)), i = this._respectSize(i, e), this._updateCache(i), this._propagate("resize", e), this.position.top !== r && (n.top = this.position.top + "px"), this.position.left !== h && (n.left = this.position.left + "px"), this.size.width !== l && (n.width = this.size.width + "px"), this.size.height !== c && (n.height = this.size.height + "px"), s.css(n), !this._helper && this._proportionallyResizeElements.length && this._proportionallyResize(), t.isEmptyObject(n) || this._trigger("resize", e, this.ui()), !1) : !1
        },
        _mouseStop: function (e) {
            this.resizing = !1;
            var i, s, n, a, o, r, h, l = this.options, c = this;
            return this._helper && (i = this._proportionallyResizeElements, s = i.length && /textarea/i.test(i[0].nodeName), n = s && t.ui.hasScroll(i[0], "left") ? 0 : c.sizeDiff.height, a = s ? 0 : c.sizeDiff.width, o = {
                width: c.helper.width() - a,
                height: c.helper.height() - n
            }, r = parseInt(c.element.css("left"), 10) + (c.position.left - c.originalPosition.left) || null, h = parseInt(c.element.css("top"), 10) + (c.position.top - c.originalPosition.top) || null, l.animate || this.element.css(t.extend(o, {
                top: h,
                left: r
            })), c.helper.height(c.size.height), c.helper.width(c.size.width), this._helper && !l.animate && this._proportionallyResize()), t("body").css("cursor", "auto"), this.element.removeClass("ui-resizable-resizing"), this._propagate("stop", e), this._helper && this.helper.remove(), !1
        },
        _updateVirtualBoundaries: function (t) {
            var e, s, n, a, o, r = this.options;
            o = {
                minWidth: i(r.minWidth) ? r.minWidth : 0,
                maxWidth: i(r.maxWidth) ? r.maxWidth : 1 / 0,
                minHeight: i(r.minHeight) ? r.minHeight : 0,
                maxHeight: i(r.maxHeight) ? r.maxHeight : 1 / 0
            }, (this._aspectRatio || t) && (e = o.minHeight * this.aspectRatio, n = o.minWidth / this.aspectRatio, s = o.maxHeight * this.aspectRatio, a = o.maxWidth / this.aspectRatio, e > o.minWidth && (o.minWidth = e), n > o.minHeight && (o.minHeight = n), o.maxWidth > s && (o.maxWidth = s), o.maxHeight > a && (o.maxHeight = a)), this._vBoundaries = o
        },
        _updateCache: function (t) {
            this.offset = this.helper.offset(), i(t.left) && (this.position.left = t.left), i(t.top) && (this.position.top = t.top), i(t.height) && (this.size.height = t.height), i(t.width) && (this.size.width = t.width)
        },
        _updateRatio: function (t) {
            var e = this.position, s = this.size, n = this.axis;
            return i(t.height) ? t.width = t.height * this.aspectRatio : i(t.width) && (t.height = t.width / this.aspectRatio), "sw" === n && (t.left = e.left + (s.width - t.width), t.top = null), "nw" === n && (t.top = e.top + (s.height - t.height), t.left = e.left + (s.width - t.width)), t
        },
        _respectSize: function (t) {
            var e = this._vBoundaries, s = this.axis, n = i(t.width) && e.maxWidth && e.maxWidth < t.width, a = i(t.height) && e.maxHeight && e.maxHeight < t.height, o = i(t.width) && e.minWidth && e.minWidth > t.width, r = i(t.height) && e.minHeight && e.minHeight > t.height, h = this.originalPosition.left + this.originalSize.width, l = this.position.top + this.size.height, c = /sw|nw|w/.test(s), u = /nw|ne|n/.test(s);
            return o && (t.width = e.minWidth), r && (t.height = e.minHeight), n && (t.width = e.maxWidth), a && (t.height = e.maxHeight), o && c && (t.left = h - e.minWidth), n && c && (t.left = h - e.maxWidth), r && u && (t.top = l - e.minHeight), a && u && (t.top = l - e.maxHeight), t.width || t.height || t.left || !t.top ? t.width || t.height || t.top || !t.left || (t.left = null) : t.top = null, t
        },
        _proportionallyResize: function () {
            if (this._proportionallyResizeElements.length) {
                var t, e, i, s, n, a = this.helper || this.element;
                for (t = 0; this._proportionallyResizeElements.length > t; t++) {
                    if (n = this._proportionallyResizeElements[t], !this.borderDif)for (this.borderDif = [], i = [n.css("borderTopWidth"), n.css("borderRightWidth"), n.css("borderBottomWidth"), n.css("borderLeftWidth")], s = [n.css("paddingTop"), n.css("paddingRight"), n.css("paddingBottom"), n.css("paddingLeft")], e = 0; i.length > e; e++)this.borderDif[e] = (parseInt(i[e], 10) || 0) + (parseInt(s[e], 10) || 0);
                    n.css({
                        height: a.height() - this.borderDif[0] - this.borderDif[2] || 0,
                        width: a.width() - this.borderDif[1] - this.borderDif[3] || 0
                    })
                }
            }
        },
        _renderProxy: function () {
            var e = this.element, i = this.options;
            this.elementOffset = e.offset(), this._helper ? (this.helper = this.helper || t("<div style='overflow:hidden;'></div>"), this.helper.addClass(this._helper).css({
                width: this.element.outerWidth() - 1,
                height: this.element.outerHeight() - 1,
                position: "absolute",
                left: this.elementOffset.left + "px",
                top: this.elementOffset.top + "px",
                zIndex: ++i.zIndex
            }), this.helper.appendTo("body").disableSelection()) : this.helper = this.element
        },
        _change: {
            e: function (t, e) {
                return {width: this.originalSize.width + e}
            }, w: function (t, e) {
                var i = this.originalSize, s = this.originalPosition;
                return {left: s.left + e, width: i.width - e}
            }, n: function (t, e, i) {
                var s = this.originalSize, n = this.originalPosition;
                return {top: n.top + i, height: s.height - i}
            }, s: function (t, e, i) {
                return {height: this.originalSize.height + i}
            }, se: function (e, i, s) {
                return t.extend(this._change.s.apply(this, arguments), this._change.e.apply(this, [e, i, s]))
            }, sw: function (e, i, s) {
                return t.extend(this._change.s.apply(this, arguments), this._change.w.apply(this, [e, i, s]))
            }, ne: function (e, i, s) {
                return t.extend(this._change.n.apply(this, arguments), this._change.e.apply(this, [e, i, s]))
            }, nw: function (e, i, s) {
                return t.extend(this._change.n.apply(this, arguments), this._change.w.apply(this, [e, i, s]))
            }
        },
        _propagate: function (e, i) {
            t.ui.plugin.call(this, e, [i, this.ui()]), "resize" !== e && this._trigger(e, i, this.ui())
        },
        plugins: {},
        ui: function () {
            return {
                originalElement: this.originalElement,
                element: this.element,
                helper: this.helper,
                position: this.position,
                size: this.size,
                originalSize: this.originalSize,
                originalPosition: this.originalPosition
            }
        }
    }), t.ui.plugin.add("resizable", "animate", {
        stop: function (e) {
            var i = t(this).data("ui-resizable"), s = i.options, n = i._proportionallyResizeElements, a = n.length && /textarea/i.test(n[0].nodeName), o = a && t.ui.hasScroll(n[0], "left") ? 0 : i.sizeDiff.height, r = a ? 0 : i.sizeDiff.width, h = {
                width: i.size.width - r,
                height: i.size.height - o
            }, l = parseInt(i.element.css("left"), 10) + (i.position.left - i.originalPosition.left) || null, c = parseInt(i.element.css("top"), 10) + (i.position.top - i.originalPosition.top) || null;
            i.element.animate(t.extend(h, c && l ? {top: c, left: l} : {}), {
                duration: s.animateDuration,
                easing: s.animateEasing,
                step: function () {
                    var s = {
                        width: parseInt(i.element.css("width"), 10),
                        height: parseInt(i.element.css("height"), 10),
                        top: parseInt(i.element.css("top"), 10),
                        left: parseInt(i.element.css("left"), 10)
                    };
                    n && n.length && t(n[0]).css({
                        width: s.width,
                        height: s.height
                    }), i._updateCache(s), i._propagate("resize", e)
                }
            })
        }
    }), t.ui.plugin.add("resizable", "containment", {
        start: function () {
            var i, s, n, a, o, r, h, l = t(this).data("ui-resizable"), c = l.options, u = l.element, d = c.containment, p = d instanceof t ? d.get(0) : /parent/.test(d) ? u.parent().get(0) : d;
            p && (l.containerElement = t(p), /document/.test(d) || d === document ? (l.containerOffset = {
                left: 0,
                top: 0
            }, l.containerPosition = {left: 0, top: 0}, l.parentData = {
                element: t(document),
                left: 0,
                top: 0,
                width: t(document).width(),
                height: t(document).height() || document.body.parentNode.scrollHeight
            }) : (i = t(p), s = [], t(["Top", "Right", "Left", "Bottom"]).each(function (t, n) {
                s[t] = e(i.css("padding" + n))
            }), l.containerOffset = i.offset(), l.containerPosition = i.position(), l.containerSize = {
                height: i.innerHeight() - s[3],
                width: i.innerWidth() - s[1]
            }, n = l.containerOffset, a = l.containerSize.height, o = l.containerSize.width, r = t.ui.hasScroll(p, "left") ? p.scrollWidth : o, h = t.ui.hasScroll(p) ? p.scrollHeight : a, l.parentData = {
                element: p,
                left: n.left,
                top: n.top,
                width: r,
                height: h
            }))
        }, resize: function (e) {
            var i, s, n, a, o = t(this).data("ui-resizable"), r = o.options, h = o.containerOffset, l = o.position, c = o._aspectRatio || e.shiftKey, u = {
                top: 0,
                left: 0
            }, d = o.containerElement;
            d[0] !== document && /static/.test(d.css("position")) && (u = h), l.left < (o._helper ? h.left : 0) && (o.size.width = o.size.width + (o._helper ? o.position.left - h.left : o.position.left - u.left), c && (o.size.height = o.size.width / o.aspectRatio), o.position.left = r.helper ? h.left : 0), l.top < (o._helper ? h.top : 0) && (o.size.height = o.size.height + (o._helper ? o.position.top - h.top : o.position.top), c && (o.size.width = o.size.height * o.aspectRatio), o.position.top = o._helper ? h.top : 0), o.offset.left = o.parentData.left + o.position.left, o.offset.top = o.parentData.top + o.position.top, i = Math.abs((o._helper ? o.offset.left - u.left : o.offset.left - u.left) + o.sizeDiff.width), s = Math.abs((o._helper ? o.offset.top - u.top : o.offset.top - h.top) + o.sizeDiff.height), n = o.containerElement.get(0) === o.element.parent().get(0), a = /relative|absolute/.test(o.containerElement.css("position")), n && a && (i -= Math.abs(o.parentData.left)), i + o.size.width >= o.parentData.width && (o.size.width = o.parentData.width - i, c && (o.size.height = o.size.width / o.aspectRatio)), s + o.size.height >= o.parentData.height && (o.size.height = o.parentData.height - s, c && (o.size.width = o.size.height * o.aspectRatio))
        }, stop: function () {
            var e = t(this).data("ui-resizable"), i = e.options, s = e.containerOffset, n = e.containerPosition, a = e.containerElement, o = t(e.helper), r = o.offset(), h = o.outerWidth() - e.sizeDiff.width, l = o.outerHeight() - e.sizeDiff.height;
            e._helper && !i.animate && /relative/.test(a.css("position")) && t(this).css({
                left: r.left - n.left - s.left,
                width: h,
                height: l
            }), e._helper && !i.animate && /static/.test(a.css("position")) && t(this).css({
                left: r.left - n.left - s.left,
                width: h,
                height: l
            })
        }
    }), t.ui.plugin.add("resizable", "alsoResize", {
        start: function () {
            var e = t(this).data("ui-resizable"), i = e.options, s = function (e) {
                t(e).each(function () {
                    var e = t(this);
                    e.data("ui-resizable-alsoresize", {
                        width: parseInt(e.width(), 10),
                        height: parseInt(e.height(), 10),
                        left: parseInt(e.css("left"), 10),
                        top: parseInt(e.css("top"), 10)
                    })
                })
            };
            "object" != typeof i.alsoResize || i.alsoResize.parentNode ? s(i.alsoResize) : i.alsoResize.length ? (i.alsoResize = i.alsoResize[0], s(i.alsoResize)) : t.each(i.alsoResize, function (t) {
                s(t)
            })
        }, resize: function (e, i) {
            var s = t(this).data("ui-resizable"), n = s.options, a = s.originalSize, o = s.originalPosition, r = {
                height: s.size.height - a.height || 0,
                width: s.size.width - a.width || 0,
                top: s.position.top - o.top || 0,
                left: s.position.left - o.left || 0
            }, h = function (e, s) {
                t(e).each(function () {
                    var e = t(this), n = t(this).data("ui-resizable-alsoresize"), a = {}, o = s && s.length ? s : e.parents(i.originalElement[0]).length ? ["width", "height"] : ["width", "height", "top", "left"];
                    t.each(o, function (t, e) {
                        var i = (n[e] || 0) + (r[e] || 0);
                        i && i >= 0 && (a[e] = i || null)
                    }), e.css(a)
                })
            };
            "object" != typeof n.alsoResize || n.alsoResize.nodeType ? h(n.alsoResize) : t.each(n.alsoResize, function (t, e) {
                h(t, e)
            })
        }, stop: function () {
            t(this).removeData("resizable-alsoresize")
        }
    }), t.ui.plugin.add("resizable", "ghost", {
        start: function () {
            var e = t(this).data("ui-resizable"), i = e.options, s = e.size;
            e.ghost = e.originalElement.clone(), e.ghost.css({
                opacity: .25,
                display: "block",
                position: "relative",
                height: s.height,
                width: s.width,
                margin: 0,
                left: 0,
                top: 0
            }).addClass("ui-resizable-ghost").addClass("string" == typeof i.ghost ? i.ghost : ""), e.ghost.appendTo(e.helper)
        }, resize: function () {
            var e = t(this).data("ui-resizable");
            e.ghost && e.ghost.css({position: "relative", height: e.size.height, width: e.size.width})
        }, stop: function () {
            var e = t(this).data("ui-resizable");
            e.ghost && e.helper && e.helper.get(0).removeChild(e.ghost.get(0))
        }
    }), t.ui.plugin.add("resizable", "grid", {
        resize: function () {
            var e = t(this).data("ui-resizable"), i = e.options, s = e.size, n = e.originalSize, a = e.originalPosition, o = e.axis, r = "number" == typeof i.grid ? [i.grid, i.grid] : i.grid, h = r[0] || 1, l = r[1] || 1, c = Math.round((s.width - n.width) / h) * h, u = Math.round((s.height - n.height) / l) * l, d = n.width + c, p = n.height + u, f = i.maxWidth && d > i.maxWidth, g = i.maxHeight && p > i.maxHeight, m = i.minWidth && i.minWidth > d, v = i.minHeight && i.minHeight > p;
            i.grid = r, m && (d += h), v && (p += l), f && (d -= h), g && (p -= l), /^(se|s|e)$/.test(o) ? (e.size.width = d, e.size.height = p) : /^(ne)$/.test(o) ? (e.size.width = d, e.size.height = p, e.position.top = a.top - u) : /^(sw)$/.test(o) ? (e.size.width = d, e.size.height = p, e.position.left = a.left - c) : (p - l > 0 ? (e.size.height = p, e.position.top = a.top - u) : (e.size.height = l, e.position.top = a.top + n.height - l), d - h > 0 ? (e.size.width = d, e.position.left = a.left - c) : (e.size.width = h, e.position.left = a.left + n.width - h))
        }
    })
})(jQuery);
(function (t) {
    function e(t, e, i) {
        return t > e && e + i > t
    }

    function i(t) {
        return /left|right/.test(t.css("float")) || /inline|table-cell/.test(t.css("display"))
    }

    t.widget("ui.sortable", t.ui.mouse, {
        version: "1.10.4",
        widgetEventPrefix: "sort",
        ready: !1,
        options: {
            appendTo: "parent",
            axis: !1,
            connectWith: !1,
            containment: !1,
            cursor: "auto",
            cursorAt: !1,
            dropOnEmpty: !0,
            forcePlaceholderSize: !1,
            forceHelperSize: !1,
            grid: !1,
            handle: !1,
            helper: "original",
            items: "> *",
            opacity: !1,
            placeholder: !1,
            revert: !1,
            scroll: !0,
            scrollSensitivity: 20,
            scrollSpeed: 20,
            scope: "default",
            tolerance: "intersect",
            zIndex: 1e3,
            activate: null,
            beforeStop: null,
            change: null,
            deactivate: null,
            out: null,
            over: null,
            receive: null,
            remove: null,
            sort: null,
            start: null,
            stop: null,
            update: null
        },
        _create: function () {
            var t = this.options;
            this.containerCache = {}, this.element.addClass("ui-sortable"), this.refresh(), this.floating = this.items.length ? "x" === t.axis || i(this.items[0].item) : !1, this.offset = this.element.offset(), this._mouseInit(), this.ready = !0
        },
        _destroy: function () {
            this.element.removeClass("ui-sortable ui-sortable-disabled"), this._mouseDestroy();
            for (var t = this.items.length - 1; t >= 0; t--)this.items[t].item.removeData(this.widgetName + "-item");
            return this
        },
        _setOption: function (e, i) {
            "disabled" === e ? (this.options[e] = i, this.widget().toggleClass("ui-sortable-disabled", !!i)) : t.Widget.prototype._setOption.apply(this, arguments)
        },
        _mouseCapture: function (e, i) {
            var s = null, n = !1, o = this;
            return this.reverting ? !1 : this.options.disabled || "static" === this.options.type ? !1 : (this._refreshItems(e), t(e.target).parents().each(function () {
                return t.data(this, o.widgetName + "-item") === o ? (s = t(this), !1) : undefined
            }), t.data(e.target, o.widgetName + "-item") === o && (s = t(e.target)), s ? !this.options.handle || i || (t(this.options.handle, s).find("*").addBack().each(function () {
                this === e.target && (n = !0)
            }), n) ? (this.currentItem = s, this._removeCurrentsFromItems(), !0) : !1 : !1)
        },
        _mouseStart: function (e, i, s) {
            var n, o, a = this.options;
            if (this.currentContainer = this, this.refreshPositions(), this.helper = this._createHelper(e), this._cacheHelperProportions(), this._cacheMargins(), this.scrollParent = this.helper.scrollParent(), this.offset = this.currentItem.offset(), this.offset = {
                    top: this.offset.top - this.margins.top,
                    left: this.offset.left - this.margins.left
                }, t.extend(this.offset, {
                    click: {left: e.pageX - this.offset.left, top: e.pageY - this.offset.top},
                    parent: this._getParentOffset(),
                    relative: this._getRelativeOffset()
                }), this.helper.css("position", "absolute"), this.cssPosition = this.helper.css("position"), this.originalPosition = this._generatePosition(e), this.originalPageX = e.pageX, this.originalPageY = e.pageY, a.cursorAt && this._adjustOffsetFromHelper(a.cursorAt), this.domPosition = {
                    prev: this.currentItem.prev()[0],
                    parent: this.currentItem.parent()[0]
                }, this.helper[0] !== this.currentItem[0] && this.currentItem.hide(), this._createPlaceholder(), a.containment && this._setContainment(), a.cursor && "auto" !== a.cursor && (o = this.document.find("body"), this.storedCursor = o.css("cursor"), o.css("cursor", a.cursor), this.storedStylesheet = t("<style>*{ cursor: " + a.cursor + " !important; }</style>").appendTo(o)), a.opacity && (this.helper.css("opacity") && (this._storedOpacity = this.helper.css("opacity")), this.helper.css("opacity", a.opacity)), a.zIndex && (this.helper.css("zIndex") && (this._storedZIndex = this.helper.css("zIndex")), this.helper.css("zIndex", a.zIndex)), this.scrollParent[0] !== document && "HTML" !== this.scrollParent[0].tagName && (this.overflowOffset = this.scrollParent.offset()), this._trigger("start", e, this._uiHash()), this._preserveHelperProportions || this._cacheHelperProportions(), !s)for (n = this.containers.length - 1; n >= 0; n--)this.containers[n]._trigger("activate", e, this._uiHash(this));
            return t.ui.ddmanager && (t.ui.ddmanager.current = this), t.ui.ddmanager && !a.dropBehaviour && t.ui.ddmanager.prepareOffsets(this, e), this.dragging = !0, this.helper.addClass("ui-sortable-helper"), this._mouseDrag(e), !0
        },
        _mouseDrag: function (e) {
            var i, s, n, o, a = this.options, r = !1;
            for (this.position = this._generatePosition(e), this.positionAbs = this._convertPositionTo("absolute"), this.lastPositionAbs || (this.lastPositionAbs = this.positionAbs), this.options.scroll && (this.scrollParent[0] !== document && "HTML" !== this.scrollParent[0].tagName ? (this.overflowOffset.top + this.scrollParent[0].offsetHeight - e.pageY < a.scrollSensitivity ? this.scrollParent[0].scrollTop = r = this.scrollParent[0].scrollTop + a.scrollSpeed : e.pageY - this.overflowOffset.top < a.scrollSensitivity && (this.scrollParent[0].scrollTop = r = this.scrollParent[0].scrollTop - a.scrollSpeed), this.overflowOffset.left + this.scrollParent[0].offsetWidth - e.pageX < a.scrollSensitivity ? this.scrollParent[0].scrollLeft = r = this.scrollParent[0].scrollLeft + a.scrollSpeed : e.pageX - this.overflowOffset.left < a.scrollSensitivity && (this.scrollParent[0].scrollLeft = r = this.scrollParent[0].scrollLeft - a.scrollSpeed)) : (e.pageY - t(document).scrollTop() < a.scrollSensitivity ? r = t(document).scrollTop(t(document).scrollTop() - a.scrollSpeed) : t(window).height() - (e.pageY - t(document).scrollTop()) < a.scrollSensitivity && (r = t(document).scrollTop(t(document).scrollTop() + a.scrollSpeed)), e.pageX - t(document).scrollLeft() < a.scrollSensitivity ? r = t(document).scrollLeft(t(document).scrollLeft() - a.scrollSpeed) : t(window).width() - (e.pageX - t(document).scrollLeft()) < a.scrollSensitivity && (r = t(document).scrollLeft(t(document).scrollLeft() + a.scrollSpeed))), r !== !1 && t.ui.ddmanager && !a.dropBehaviour && t.ui.ddmanager.prepareOffsets(this, e)), this.positionAbs = this._convertPositionTo("absolute"), this.options.axis && "y" === this.options.axis || (this.helper[0].style.left = this.position.left + "px"), this.options.axis && "x" === this.options.axis || (this.helper[0].style.top = this.position.top + "px"), i = this.items.length - 1; i >= 0; i--)if (s = this.items[i], n = s.item[0], o = this._intersectsWithPointer(s), o && s.instance === this.currentContainer && n !== this.currentItem[0] && this.placeholder[1 === o ? "next" : "prev"]()[0] !== n && !t.contains(this.placeholder[0], n) && ("semi-dynamic" === this.options.type ? !t.contains(this.element[0], n) : !0)) {
                if (this.direction = 1 === o ? "down" : "up", "pointer" !== this.options.tolerance && !this._intersectsWithSides(s))break;
                this._rearrange(e, s), this._trigger("change", e, this._uiHash());
                break
            }
            return this._contactContainers(e), t.ui.ddmanager && t.ui.ddmanager.drag(this, e), this._trigger("sort", e, this._uiHash()), this.lastPositionAbs = this.positionAbs, !1
        },
        _mouseStop: function (e, i) {
            if (e) {
                if (t.ui.ddmanager && !this.options.dropBehaviour && t.ui.ddmanager.drop(this, e), this.options.revert) {
                    var s = this, n = this.placeholder.offset(), o = this.options.axis, a = {};
                    o && "x" !== o || (a.left = n.left - this.offset.parent.left - this.margins.left + (this.offsetParent[0] === document.body ? 0 : this.offsetParent[0].scrollLeft)), o && "y" !== o || (a.top = n.top - this.offset.parent.top - this.margins.top + (this.offsetParent[0] === document.body ? 0 : this.offsetParent[0].scrollTop)), this.reverting = !0, t(this.helper).animate(a, parseInt(this.options.revert, 10) || 500, function () {
                        s._clear(e)
                    })
                } else this._clear(e, i);
                return !1
            }
        },
        cancel: function () {
            if (this.dragging) {
                this._mouseUp({target: null}), "original" === this.options.helper ? this.currentItem.css(this._storedCSS).removeClass("ui-sortable-helper") : this.currentItem.show();
                for (var e = this.containers.length - 1; e >= 0; e--)this.containers[e]._trigger("deactivate", null, this._uiHash(this)), this.containers[e].containerCache.over && (this.containers[e]._trigger("out", null, this._uiHash(this)), this.containers[e].containerCache.over = 0)
            }
            return this.placeholder && (this.placeholder[0].parentNode && this.placeholder[0].parentNode.removeChild(this.placeholder[0]), "original" !== this.options.helper && this.helper && this.helper[0].parentNode && this.helper.remove(), t.extend(this, {
                helper: null,
                dragging: !1,
                reverting: !1,
                _noFinalSort: null
            }), this.domPosition.prev ? t(this.domPosition.prev).after(this.currentItem) : t(this.domPosition.parent).prepend(this.currentItem)), this
        },
        serialize: function (e) {
            var i = this._getItemsAsjQuery(e && e.connected), s = [];
            return e = e || {}, t(i).each(function () {
                var i = (t(e.item || this).attr(e.attribute || "id") || "").match(e.expression || /(.+)[\-=_](.+)/);
                i && s.push((e.key || i[1] + "[]") + "=" + (e.key && e.expression ? i[1] : i[2]))
            }), !s.length && e.key && s.push(e.key + "="), s.join("&")
        },
        toArray: function (e) {
            var i = this._getItemsAsjQuery(e && e.connected), s = [];
            return e = e || {}, i.each(function () {
                s.push(t(e.item || this).attr(e.attribute || "id") || "")
            }), s
        },
        _intersectsWith: function (t) {
            var e = this.positionAbs.left, i = e + this.helperProportions.width, s = this.positionAbs.top, n = s + this.helperProportions.height, o = t.left, a = o + t.width, r = t.top, h = r + t.height, l = this.offset.click.top, c = this.offset.click.left, u = "x" === this.options.axis || s + l > r && h > s + l, d = "y" === this.options.axis || e + c > o && a > e + c, p = u && d;
            return "pointer" === this.options.tolerance || this.options.forcePointerForContainers || "pointer" !== this.options.tolerance && this.helperProportions[this.floating ? "width" : "height"] > t[this.floating ? "width" : "height"] ? p : e + this.helperProportions.width / 2 > o && a > i - this.helperProportions.width / 2 && s + this.helperProportions.height / 2 > r && h > n - this.helperProportions.height / 2
        },
        _intersectsWithPointer: function (t) {
            var i = "x" === this.options.axis || e(this.positionAbs.top + this.offset.click.top, t.top, t.height), s = "y" === this.options.axis || e(this.positionAbs.left + this.offset.click.left, t.left, t.width), n = i && s, o = this._getDragVerticalDirection(), a = this._getDragHorizontalDirection();
            return n ? this.floating ? a && "right" === a || "down" === o ? 2 : 1 : o && ("down" === o ? 2 : 1) : !1
        },
        _intersectsWithSides: function (t) {
            var i = e(this.positionAbs.top + this.offset.click.top, t.top + t.height / 2, t.height), s = e(this.positionAbs.left + this.offset.click.left, t.left + t.width / 2, t.width), n = this._getDragVerticalDirection(), o = this._getDragHorizontalDirection();
            return this.floating && o ? "right" === o && s || "left" === o && !s : n && ("down" === n && i || "up" === n && !i)
        },
        _getDragVerticalDirection: function () {
            var t = this.positionAbs.top - this.lastPositionAbs.top;
            return 0 !== t && (t > 0 ? "down" : "up")
        },
        _getDragHorizontalDirection: function () {
            var t = this.positionAbs.left - this.lastPositionAbs.left;
            return 0 !== t && (t > 0 ? "right" : "left")
        },
        refresh: function (t) {
            return this._refreshItems(t), this.refreshPositions(), this
        },
        _connectWith: function () {
            var t = this.options;
            return t.connectWith.constructor === String ? [t.connectWith] : t.connectWith
        },
        _getItemsAsjQuery: function (e) {
            function i() {
                r.push(this)
            }

            var s, n, o, a, r = [], h = [], l = this._connectWith();
            if (l && e)for (s = l.length - 1; s >= 0; s--)for (o = t(l[s]), n = o.length - 1; n >= 0; n--)a = t.data(o[n], this.widgetFullName), a && a !== this && !a.options.disabled && h.push([t.isFunction(a.options.items) ? a.options.items.call(a.element) : t(a.options.items, a.element).not(".ui-sortable-helper").not(".ui-sortable-placeholder"), a]);
            for (h.push([t.isFunction(this.options.items) ? this.options.items.call(this.element, null, {
                options: this.options,
                item: this.currentItem
            }) : t(this.options.items, this.element).not(".ui-sortable-helper").not(".ui-sortable-placeholder"), this]), s = h.length - 1; s >= 0; s--)h[s][0].each(i);
            return t(r)
        },
        _removeCurrentsFromItems: function () {
            var e = this.currentItem.find(":data(" + this.widgetName + "-item)");
            this.items = t.grep(this.items, function (t) {
                for (var i = 0; e.length > i; i++)if (e[i] === t.item[0])return !1;
                return !0
            })
        },
        _refreshItems: function (e) {
            this.items = [], this.containers = [this];
            var i, s, n, o, a, r, h, l, c = this.items, u = [[t.isFunction(this.options.items) ? this.options.items.call(this.element[0], e, {item: this.currentItem}) : t(this.options.items, this.element), this]], d = this._connectWith();
            if (d && this.ready)for (i = d.length - 1; i >= 0; i--)for (n = t(d[i]), s = n.length - 1; s >= 0; s--)o = t.data(n[s], this.widgetFullName), o && o !== this && !o.options.disabled && (u.push([t.isFunction(o.options.items) ? o.options.items.call(o.element[0], e, {item: this.currentItem}) : t(o.options.items, o.element), o]), this.containers.push(o));
            for (i = u.length - 1; i >= 0; i--)for (a = u[i][1], r = u[i][0], s = 0, l = r.length; l > s; s++)h = t(r[s]), h.data(this.widgetName + "-item", a), c.push({
                item: h,
                instance: a,
                width: 0,
                height: 0,
                left: 0,
                top: 0
            })
        },
        refreshPositions: function (e) {
            this.offsetParent && this.helper && (this.offset.parent = this._getParentOffset());
            var i, s, n, o;
            for (i = this.items.length - 1; i >= 0; i--)s = this.items[i], s.instance !== this.currentContainer && this.currentContainer && s.item[0] !== this.currentItem[0] || (n = this.options.toleranceElement ? t(this.options.toleranceElement, s.item) : s.item, e || (s.width = n.outerWidth(), s.height = n.outerHeight()), o = n.offset(), s.left = o.left, s.top = o.top);
            if (this.options.custom && this.options.custom.refreshContainers)this.options.custom.refreshContainers.call(this); else for (i = this.containers.length - 1; i >= 0; i--)o = this.containers[i].element.offset(), this.containers[i].containerCache.left = o.left, this.containers[i].containerCache.top = o.top, this.containers[i].containerCache.width = this.containers[i].element.outerWidth(), this.containers[i].containerCache.height = this.containers[i].element.outerHeight();
            return this
        },
        _createPlaceholder: function (e) {
            e = e || this;
            var i, s = e.options;
            s.placeholder && s.placeholder.constructor !== String || (i = s.placeholder, s.placeholder = {
                element: function () {
                    var s = e.currentItem[0].nodeName.toLowerCase(), n = t("<" + s + ">", e.document[0]).addClass(i || e.currentItem[0].className + " ui-sortable-placeholder").removeClass("ui-sortable-helper");
                    return "tr" === s ? e.currentItem.children().each(function () {
                        t("<td>&#160;</td>", e.document[0]).attr("colspan", t(this).attr("colspan") || 1).appendTo(n)
                    }) : "img" === s && n.attr("src", e.currentItem.attr("src")), i || n.css("visibility", "hidden"), n
                }, update: function (t, n) {
                    (!i || s.forcePlaceholderSize) && (n.height() || n.height(e.currentItem.innerHeight() - parseInt(e.currentItem.css("paddingTop") || 0, 10) - parseInt(e.currentItem.css("paddingBottom") || 0, 10)), n.width() || n.width(e.currentItem.innerWidth() - parseInt(e.currentItem.css("paddingLeft") || 0, 10) - parseInt(e.currentItem.css("paddingRight") || 0, 10)))
                }
            }), e.placeholder = t(s.placeholder.element.call(e.element, e.currentItem)), e.currentItem.after(e.placeholder), s.placeholder.update(e, e.placeholder)
        },
        _contactContainers: function (s) {
            var n, o, a, r, h, l, c, u, d, p, f = null, g = null;
            for (n = this.containers.length - 1; n >= 0; n--)if (!t.contains(this.currentItem[0], this.containers[n].element[0]))if (this._intersectsWith(this.containers[n].containerCache)) {
                if (f && t.contains(this.containers[n].element[0], f.element[0]))continue;
                f = this.containers[n], g = n
            } else this.containers[n].containerCache.over && (this.containers[n]._trigger("out", s, this._uiHash(this)), this.containers[n].containerCache.over = 0);
            if (f)if (1 === this.containers.length)this.containers[g].containerCache.over || (this.containers[g]._trigger("over", s, this._uiHash(this)), this.containers[g].containerCache.over = 1); else {
                for (a = 1e4, r = null, p = f.floating || i(this.currentItem), h = p ? "left" : "top", l = p ? "width" : "height", c = this.positionAbs[h] + this.offset.click[h], o = this.items.length - 1; o >= 0; o--)t.contains(this.containers[g].element[0], this.items[o].item[0]) && this.items[o].item[0] !== this.currentItem[0] && (!p || e(this.positionAbs.top + this.offset.click.top, this.items[o].top, this.items[o].height)) && (u = this.items[o].item.offset()[h], d = !1, Math.abs(u - c) > Math.abs(u + this.items[o][l] - c) && (d = !0, u += this.items[o][l]), a > Math.abs(u - c) && (a = Math.abs(u - c), r = this.items[o], this.direction = d ? "up" : "down"));
                if (!r && !this.options.dropOnEmpty)return;
                if (this.currentContainer === this.containers[g])return;
                r ? this._rearrange(s, r, null, !0) : this._rearrange(s, null, this.containers[g].element, !0), this._trigger("change", s, this._uiHash()), this.containers[g]._trigger("change", s, this._uiHash(this)), this.currentContainer = this.containers[g], this.options.placeholder.update(this.currentContainer, this.placeholder), this.containers[g]._trigger("over", s, this._uiHash(this)), this.containers[g].containerCache.over = 1
            }
        },
        _createHelper: function (e) {
            var i = this.options, s = t.isFunction(i.helper) ? t(i.helper.apply(this.element[0], [e, this.currentItem])) : "clone" === i.helper ? this.currentItem.clone() : this.currentItem;
            return s.parents("body").length || t("parent" !== i.appendTo ? i.appendTo : this.currentItem[0].parentNode)[0].appendChild(s[0]), s[0] === this.currentItem[0] && (this._storedCSS = {
                width: this.currentItem[0].style.width,
                height: this.currentItem[0].style.height,
                position: this.currentItem.css("position"),
                top: this.currentItem.css("top"),
                left: this.currentItem.css("left")
            }), (!s[0].style.width || i.forceHelperSize) && s.width(this.currentItem.width()), (!s[0].style.height || i.forceHelperSize) && s.height(this.currentItem.height()), s
        },
        _adjustOffsetFromHelper: function (e) {
            "string" == typeof e && (e = e.split(" ")), t.isArray(e) && (e = {
                left: +e[0],
                top: +e[1] || 0
            }), "left"in e && (this.offset.click.left = e.left + this.margins.left), "right"in e && (this.offset.click.left = this.helperProportions.width - e.right + this.margins.left), "top"in e && (this.offset.click.top = e.top + this.margins.top), "bottom"in e && (this.offset.click.top = this.helperProportions.height - e.bottom + this.margins.top)
        },
        _getParentOffset: function () {
            this.offsetParent = this.helper.offsetParent();
            var e = this.offsetParent.offset();
            return "absolute" === this.cssPosition && this.scrollParent[0] !== document && t.contains(this.scrollParent[0], this.offsetParent[0]) && (e.left += this.scrollParent.scrollLeft(), e.top += this.scrollParent.scrollTop()), (this.offsetParent[0] === document.body || this.offsetParent[0].tagName && "html" === this.offsetParent[0].tagName.toLowerCase() && t.ui.ie) && (e = {
                top: 0,
                left: 0
            }), {
                top: e.top + (parseInt(this.offsetParent.css("borderTopWidth"), 10) || 0),
                left: e.left + (parseInt(this.offsetParent.css("borderLeftWidth"), 10) || 0)
            }
        },
        _getRelativeOffset: function () {
            if ("relative" === this.cssPosition) {
                var t = this.currentItem.position();
                return {
                    top: t.top - (parseInt(this.helper.css("top"), 10) || 0) + this.scrollParent.scrollTop(),
                    left: t.left - (parseInt(this.helper.css("left"), 10) || 0) + this.scrollParent.scrollLeft()
                }
            }
            return {top: 0, left: 0}
        },
        _cacheMargins: function () {
            this.margins = {
                left: parseInt(this.currentItem.css("marginLeft"), 10) || 0,
                top: parseInt(this.currentItem.css("marginTop"), 10) || 0
            }
        },
        _cacheHelperProportions: function () {
            this.helperProportions = {width: this.helper.outerWidth(), height: this.helper.outerHeight()}
        },
        _setContainment: function () {
            var e, i, s, n = this.options;
            "parent" === n.containment && (n.containment = this.helper[0].parentNode), ("document" === n.containment || "window" === n.containment) && (this.containment = [0 - this.offset.relative.left - this.offset.parent.left, 0 - this.offset.relative.top - this.offset.parent.top, t("document" === n.containment ? document : window).width() - this.helperProportions.width - this.margins.left, (t("document" === n.containment ? document : window).height() || document.body.parentNode.scrollHeight) - this.helperProportions.height - this.margins.top]), /^(document|window|parent)$/.test(n.containment) || (e = t(n.containment)[0], i = t(n.containment).offset(), s = "hidden" !== t(e).css("overflow"), this.containment = [i.left + (parseInt(t(e).css("borderLeftWidth"), 10) || 0) + (parseInt(t(e).css("paddingLeft"), 10) || 0) - this.margins.left, i.top + (parseInt(t(e).css("borderTopWidth"), 10) || 0) + (parseInt(t(e).css("paddingTop"), 10) || 0) - this.margins.top, i.left + (s ? Math.max(e.scrollWidth, e.offsetWidth) : e.offsetWidth) - (parseInt(t(e).css("borderLeftWidth"), 10) || 0) - (parseInt(t(e).css("paddingRight"), 10) || 0) - this.helperProportions.width - this.margins.left, i.top + (s ? Math.max(e.scrollHeight, e.offsetHeight) : e.offsetHeight) - (parseInt(t(e).css("borderTopWidth"), 10) || 0) - (parseInt(t(e).css("paddingBottom"), 10) || 0) - this.helperProportions.height - this.margins.top])
        },
        _convertPositionTo: function (e, i) {
            i || (i = this.position);
            var s = "absolute" === e ? 1 : -1, n = "absolute" !== this.cssPosition || this.scrollParent[0] !== document && t.contains(this.scrollParent[0], this.offsetParent[0]) ? this.scrollParent : this.offsetParent, o = /(html|body)/i.test(n[0].tagName);
            return {
                top: i.top + this.offset.relative.top * s + this.offset.parent.top * s - ("fixed" === this.cssPosition ? -this.scrollParent.scrollTop() : o ? 0 : n.scrollTop()) * s,
                left: i.left + this.offset.relative.left * s + this.offset.parent.left * s - ("fixed" === this.cssPosition ? -this.scrollParent.scrollLeft() : o ? 0 : n.scrollLeft()) * s
            }
        },
        _generatePosition: function (e) {
            var i, s, n = this.options, o = e.pageX, a = e.pageY, r = "absolute" !== this.cssPosition || this.scrollParent[0] !== document && t.contains(this.scrollParent[0], this.offsetParent[0]) ? this.scrollParent : this.offsetParent, h = /(html|body)/i.test(r[0].tagName);
            return "relative" !== this.cssPosition || this.scrollParent[0] !== document && this.scrollParent[0] !== this.offsetParent[0] || (this.offset.relative = this._getRelativeOffset()), this.originalPosition && (this.containment && (e.pageX - this.offset.click.left < this.containment[0] && (o = this.containment[0] + this.offset.click.left), e.pageY - this.offset.click.top < this.containment[1] && (a = this.containment[1] + this.offset.click.top), e.pageX - this.offset.click.left > this.containment[2] && (o = this.containment[2] + this.offset.click.left), e.pageY - this.offset.click.top > this.containment[3] && (a = this.containment[3] + this.offset.click.top)), n.grid && (i = this.originalPageY + Math.round((a - this.originalPageY) / n.grid[1]) * n.grid[1], a = this.containment ? i - this.offset.click.top >= this.containment[1] && i - this.offset.click.top <= this.containment[3] ? i : i - this.offset.click.top >= this.containment[1] ? i - n.grid[1] : i + n.grid[1] : i, s = this.originalPageX + Math.round((o - this.originalPageX) / n.grid[0]) * n.grid[0], o = this.containment ? s - this.offset.click.left >= this.containment[0] && s - this.offset.click.left <= this.containment[2] ? s : s - this.offset.click.left >= this.containment[0] ? s - n.grid[0] : s + n.grid[0] : s)), {
                top: a - this.offset.click.top - this.offset.relative.top - this.offset.parent.top + ("fixed" === this.cssPosition ? -this.scrollParent.scrollTop() : h ? 0 : r.scrollTop()),
                left: o - this.offset.click.left - this.offset.relative.left - this.offset.parent.left + ("fixed" === this.cssPosition ? -this.scrollParent.scrollLeft() : h ? 0 : r.scrollLeft())
            }
        },
        _rearrange: function (t, e, i, s) {
            i ? i[0].appendChild(this.placeholder[0]) : e.item[0].parentNode.insertBefore(this.placeholder[0], "down" === this.direction ? e.item[0] : e.item[0].nextSibling), this.counter = this.counter ? ++this.counter : 1;
            var n = this.counter;
            this._delay(function () {
                n === this.counter && this.refreshPositions(!s)
            })
        },
        _clear: function (t, e) {
            function i(t, e, i) {
                return function (s) {
                    i._trigger(t, s, e._uiHash(e))
                }
            }

            this.reverting = !1;
            var s, n = [];
            if (!this._noFinalSort && this.currentItem.parent().length && this.placeholder.before(this.currentItem), this._noFinalSort = null, this.helper[0] === this.currentItem[0]) {
                for (s in this._storedCSS)("auto" === this._storedCSS[s] || "static" === this._storedCSS[s]) && (this._storedCSS[s] = "");
                this.currentItem.css(this._storedCSS).removeClass("ui-sortable-helper")
            } else this.currentItem.show();
            for (this.fromOutside && !e && n.push(function (t) {
                this._trigger("receive", t, this._uiHash(this.fromOutside))
            }), !this.fromOutside && this.domPosition.prev === this.currentItem.prev().not(".ui-sortable-helper")[0] && this.domPosition.parent === this.currentItem.parent()[0] || e || n.push(function (t) {
                this._trigger("update", t, this._uiHash())
            }), this !== this.currentContainer && (e || (n.push(function (t) {
                this._trigger("remove", t, this._uiHash())
            }), n.push(function (t) {
                return function (e) {
                    t._trigger("receive", e, this._uiHash(this))
                }
            }.call(this, this.currentContainer)), n.push(function (t) {
                return function (e) {
                    t._trigger("update", e, this._uiHash(this))
                }
            }.call(this, this.currentContainer)))), s = this.containers.length - 1; s >= 0; s--)e || n.push(i("deactivate", this, this.containers[s])), this.containers[s].containerCache.over && (n.push(i("out", this, this.containers[s])), this.containers[s].containerCache.over = 0);
            if (this.storedCursor && (this.document.find("body").css("cursor", this.storedCursor), this.storedStylesheet.remove()), this._storedOpacity && this.helper.css("opacity", this._storedOpacity), this._storedZIndex && this.helper.css("zIndex", "auto" === this._storedZIndex ? "" : this._storedZIndex), this.dragging = !1, this.cancelHelperRemoval) {
                if (!e) {
                    for (this._trigger("beforeStop", t, this._uiHash()), s = 0; n.length > s; s++)n[s].call(this, t);
                    this._trigger("stop", t, this._uiHash())
                }
                return this.fromOutside = !1, !1
            }
            if (e || this._trigger("beforeStop", t, this._uiHash()), this.placeholder[0].parentNode.removeChild(this.placeholder[0]), this.helper[0] !== this.currentItem[0] && this.helper.remove(), this.helper = null, !e) {
                for (s = 0; n.length > s; s++)n[s].call(this, t);
                this._trigger("stop", t, this._uiHash())
            }
            return this.fromOutside = !1, !0
        },
        _trigger: function () {
            t.Widget.prototype._trigger.apply(this, arguments) === !1 && this.cancel()
        },
        _uiHash: function (e) {
            var i = e || this;
            return {
                helper: i.helper,
                placeholder: i.placeholder || t([]),
                position: i.position,
                originalPosition: i.originalPosition,
                offset: i.positionAbs,
                item: i.currentItem,
                sender: e ? e.element : null
            }
        }
    })
})(jQuery);
(function (e) {
    var t = 0, i = {}, a = {};
    i.height = i.paddingTop = i.paddingBottom = i.borderTopWidth = i.borderBottomWidth = "hide", a.height = a.paddingTop = a.paddingBottom = a.borderTopWidth = a.borderBottomWidth = "show", e.widget("ui.accordion", {
        version: "1.10.4",
        options: {
            active: 0,
            animate: {},
            collapsible: !1,
            event: "click",
            header: "> li > :first-child,> :not(li):even",
            heightStyle: "auto",
            icons: {activeHeader: "ui-icon-triangle-1-s", header: "ui-icon-triangle-1-e"},
            activate: null,
            beforeActivate: null
        },
        _create: function () {
            var t = this.options;
            this.prevShow = this.prevHide = e(), this.element.addClass("ui-accordion ui-widget ui-helper-reset").attr("role", "tablist"), t.collapsible || t.active !== !1 && null != t.active || (t.active = 0), this._processPanels(), 0 > t.active && (t.active += this.headers.length), this._refresh()
        },
        _getCreateEventData: function () {
            return {
                header: this.active,
                panel: this.active.length ? this.active.next() : e(),
                content: this.active.length ? this.active.next() : e()
            }
        },
        _createIcons: function () {
            var t = this.options.icons;
            t && (e("<span>").addClass("ui-accordion-header-icon ui-icon " + t.header).prependTo(this.headers), this.active.children(".ui-accordion-header-icon").removeClass(t.header).addClass(t.activeHeader), this.headers.addClass("ui-accordion-icons"))
        },
        _destroyIcons: function () {
            this.headers.removeClass("ui-accordion-icons").children(".ui-accordion-header-icon").remove()
        },
        _destroy: function () {
            var e;
            this.element.removeClass("ui-accordion ui-widget ui-helper-reset").removeAttr("role"), this.headers.removeClass("ui-accordion-header ui-accordion-header-active ui-helper-reset ui-state-default ui-corner-all ui-state-active ui-state-disabled ui-corner-top").removeAttr("role").removeAttr("aria-expanded").removeAttr("aria-selected").removeAttr("aria-controls").removeAttr("tabIndex").each(function () {
                /^ui-accordion/.test(this.id) && this.removeAttribute("id")
            }), this._destroyIcons(), e = this.headers.next().css("display", "").removeAttr("role").removeAttr("aria-hidden").removeAttr("aria-labelledby").removeClass("ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content ui-accordion-content-active ui-state-disabled").each(function () {
                /^ui-accordion/.test(this.id) && this.removeAttribute("id")
            }), "content" !== this.options.heightStyle && e.css("height", "")
        },
        _setOption: function (e, t) {
            return "active" === e ? (this._activate(t), undefined) : ("event" === e && (this.options.event && this._off(this.headers, this.options.event), this._setupEvents(t)), this._super(e, t), "collapsible" !== e || t || this.options.active !== !1 || this._activate(0), "icons" === e && (this._destroyIcons(), t && this._createIcons()), "disabled" === e && this.headers.add(this.headers.next()).toggleClass("ui-state-disabled", !!t), undefined)
        },
        _keydown: function (t) {
            if (!t.altKey && !t.ctrlKey) {
                var i = e.ui.keyCode, a = this.headers.length, s = this.headers.index(t.target), n = !1;
                switch (t.keyCode) {
                    case i.RIGHT:
                    case i.DOWN:
                        n = this.headers[(s + 1) % a];
                        break;
                    case i.LEFT:
                    case i.UP:
                        n = this.headers[(s - 1 + a) % a];
                        break;
                    case i.SPACE:
                    case i.ENTER:
                        this._eventHandler(t);
                        break;
                    case i.HOME:
                        n = this.headers[0];
                        break;
                    case i.END:
                        n = this.headers[a - 1]
                }
                n && (e(t.target).attr("tabIndex", -1), e(n).attr("tabIndex", 0), n.focus(), t.preventDefault())
            }
        },
        _panelKeyDown: function (t) {
            t.keyCode === e.ui.keyCode.UP && t.ctrlKey && e(t.currentTarget).prev().focus()
        },
        refresh: function () {
            var t = this.options;
            this._processPanels(), t.active === !1 && t.collapsible === !0 || !this.headers.length ? (t.active = !1, this.active = e()) : t.active === !1 ? this._activate(0) : this.active.length && !e.contains(this.element[0], this.active[0]) ? this.headers.length === this.headers.find(".ui-state-disabled").length ? (t.active = !1, this.active = e()) : this._activate(Math.max(0, t.active - 1)) : t.active = this.headers.index(this.active), this._destroyIcons(), this._refresh()
        },
        _processPanels: function () {
            this.headers = this.element.find(this.options.header).addClass("ui-accordion-header ui-helper-reset ui-state-default ui-corner-all"), this.headers.next().addClass("ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom").filter(":not(.ui-accordion-content-active)").hide()
        },
        _refresh: function () {
            var i, a = this.options, s = a.heightStyle, n = this.element.parent(), r = this.accordionId = "ui-accordion-" + (this.element.attr("id") || ++t);
            this.active = this._findActive(a.active).addClass("ui-accordion-header-active ui-state-active ui-corner-top").removeClass("ui-corner-all"), this.active.next().addClass("ui-accordion-content-active").show(), this.headers.attr("role", "tab").each(function (t) {
                var i = e(this), a = i.attr("id"), s = i.next(), n = s.attr("id");
                a || (a = r + "-header-" + t, i.attr("id", a)), n || (n = r + "-panel-" + t, s.attr("id", n)), i.attr("aria-controls", n), s.attr("aria-labelledby", a)
            }).next().attr("role", "tabpanel"), this.headers.not(this.active).attr({
                "aria-selected": "false",
                "aria-expanded": "false",
                tabIndex: -1
            }).next().attr({"aria-hidden": "true"}).hide(), this.active.length ? this.active.attr({
                "aria-selected": "true",
                "aria-expanded": "true",
                tabIndex: 0
            }).next().attr({"aria-hidden": "false"}) : this.headers.eq(0).attr("tabIndex", 0), this._createIcons(), this._setupEvents(a.event), "fill" === s ? (i = n.height(), this.element.siblings(":visible").each(function () {
                var t = e(this), a = t.css("position");
                "absolute" !== a && "fixed" !== a && (i -= t.outerHeight(!0))
            }), this.headers.each(function () {
                i -= e(this).outerHeight(!0)
            }), this.headers.next().each(function () {
                e(this).height(Math.max(0, i - e(this).innerHeight() + e(this).height()))
            }).css("overflow", "auto")) : "auto" === s && (i = 0, this.headers.next().each(function () {
                i = Math.max(i, e(this).css("height", "").height())
            }).height(i))
        },
        _activate: function (t) {
            var i = this._findActive(t)[0];
            i !== this.active[0] && (i = i || this.active[0], this._eventHandler({
                target: i,
                currentTarget: i,
                preventDefault: e.noop
            }))
        },
        _findActive: function (t) {
            return "number" == typeof t ? this.headers.eq(t) : e()
        },
        _setupEvents: function (t) {
            var i = {keydown: "_keydown"};
            t && e.each(t.split(" "), function (e, t) {
                i[t] = "_eventHandler"
            }), this._off(this.headers.add(this.headers.next())), this._on(this.headers, i), this._on(this.headers.next(), {keydown: "_panelKeyDown"}), this._hoverable(this.headers), this._focusable(this.headers)
        },
        _eventHandler: function (t) {
            var i = this.options, a = this.active, s = e(t.currentTarget), n = s[0] === a[0], r = n && i.collapsible, o = r ? e() : s.next(), h = a.next(), d = {
                oldHeader: a,
                oldPanel: h,
                newHeader: r ? e() : s,
                newPanel: o
            };
            t.preventDefault(), n && !i.collapsible || this._trigger("beforeActivate", t, d) === !1 || (i.active = r ? !1 : this.headers.index(s), this.active = n ? e() : s, this._toggle(d), a.removeClass("ui-accordion-header-active ui-state-active"), i.icons && a.children(".ui-accordion-header-icon").removeClass(i.icons.activeHeader).addClass(i.icons.header), n || (s.removeClass("ui-corner-all").addClass("ui-accordion-header-active ui-state-active ui-corner-top"), i.icons && s.children(".ui-accordion-header-icon").removeClass(i.icons.header).addClass(i.icons.activeHeader), s.next().addClass("ui-accordion-content-active")))
        },
        _toggle: function (t) {
            var i = t.newPanel, a = this.prevShow.length ? this.prevShow : t.oldPanel;
            this.prevShow.add(this.prevHide).stop(!0, !0), this.prevShow = i, this.prevHide = a, this.options.animate ? this._animate(i, a, t) : (a.hide(), i.show(), this._toggleComplete(t)), a.attr({"aria-hidden": "true"}), a.prev().attr("aria-selected", "false"), i.length && a.length ? a.prev().attr({
                tabIndex: -1,
                "aria-expanded": "false"
            }) : i.length && this.headers.filter(function () {
                return 0 === e(this).attr("tabIndex")
            }).attr("tabIndex", -1), i.attr("aria-hidden", "false").prev().attr({
                "aria-selected": "true",
                tabIndex: 0,
                "aria-expanded": "true"
            })
        },
        _animate: function (e, t, s) {
            var n, r, o, h = this, d = 0, c = e.length && (!t.length || e.index() < t.index()), l = this.options.animate || {}, u = c && l.down || l, v = function () {
                h._toggleComplete(s)
            };
            return "number" == typeof u && (o = u), "string" == typeof u && (r = u), r = r || u.easing || l.easing, o = o || u.duration || l.duration, t.length ? e.length ? (n = e.show().outerHeight(), t.animate(i, {
                duration: o,
                easing: r,
                step: function (e, t) {
                    t.now = Math.round(e)
                }
            }), e.hide().animate(a, {
                duration: o, easing: r, complete: v, step: function (e, i) {
                    i.now = Math.round(e), "height" !== i.prop ? d += i.now : "content" !== h.options.heightStyle && (i.now = Math.round(n - t.outerHeight() - d), d = 0)
                }
            }), undefined) : t.animate(i, o, r, v) : e.animate(a, o, r, v)
        },
        _toggleComplete: function (e) {
            var t = e.oldPanel;
            t.removeClass("ui-accordion-content-active").prev().removeClass("ui-corner-top").addClass("ui-corner-all"), t.length && (t.parent()[0].className = t.parent()[0].className), this._trigger("activate", null, e)
        }
    })
})(jQuery);
(function (e) {
    e.widget("ui.autocomplete", {
        version: "1.10.4",
        defaultElement: "<input>",
        options: {
            appendTo: null,
            autoFocus: !1,
            delay: 300,
            minLength: 1,
            position: {my: "left top", at: "left bottom", collision: "none"},
            source: null,
            change: null,
            close: null,
            focus: null,
            open: null,
            response: null,
            search: null,
            select: null
        },
        requestIndex: 0,
        pending: 0,
        _create: function () {
            var t, i, s, n = this.element[0].nodeName.toLowerCase(), a = "textarea" === n, o = "input" === n;
            this.isMultiLine = a ? !0 : o ? !1 : this.element.prop("isContentEditable"), this.valueMethod = this.element[a || o ? "val" : "text"], this.isNewMenu = !0, this.element.addClass("ui-autocomplete-input").attr("autocomplete", "off"), this._on(this.element, {
                keydown: function (n) {
                    if (this.element.prop("readOnly"))return t = !0, s = !0, i = !0, undefined;
                    t = !1, s = !1, i = !1;
                    var a = e.ui.keyCode;
                    switch (n.keyCode) {
                        case a.PAGE_UP:
                            t = !0, this._move("previousPage", n);
                            break;
                        case a.PAGE_DOWN:
                            t = !0, this._move("nextPage", n);
                            break;
                        case a.UP:
                            t = !0, this._keyEvent("previous", n);
                            break;
                        case a.DOWN:
                            t = !0, this._keyEvent("next", n);
                            break;
                        case a.ENTER:
                        case a.NUMPAD_ENTER:
                            this.menu.active && (t = !0, n.preventDefault(), this.menu.select(n));
                            break;
                        case a.TAB:
                            this.menu.active && this.menu.select(n);
                            break;
                        case a.ESCAPE:
                            this.menu.element.is(":visible") && (this._value(this.term), this.close(n), n.preventDefault());
                            break;
                        default:
                            i = !0, this._searchTimeout(n)
                    }
                }, keypress: function (s) {
                    if (t)return t = !1, (!this.isMultiLine || this.menu.element.is(":visible")) && s.preventDefault(), undefined;
                    if (!i) {
                        var n = e.ui.keyCode;
                        switch (s.keyCode) {
                            case n.PAGE_UP:
                                this._move("previousPage", s);
                                break;
                            case n.PAGE_DOWN:
                                this._move("nextPage", s);
                                break;
                            case n.UP:
                                this._keyEvent("previous", s);
                                break;
                            case n.DOWN:
                                this._keyEvent("next", s)
                        }
                    }
                }, input: function (e) {
                    return s ? (s = !1, e.preventDefault(), undefined) : (this._searchTimeout(e), undefined)
                }, focus: function () {
                    this.selectedItem = null, this.previous = this._value()
                }, blur: function (e) {
                    return this.cancelBlur ? (delete this.cancelBlur, undefined) : (clearTimeout(this.searching), this.close(e), this._change(e), undefined)
                }
            }), this._initSource(), this.menu = e("<ul>").addClass("ui-autocomplete ui-front").appendTo(this._appendTo()).menu({role: null}).hide().data("ui-menu"), this._on(this.menu.element, {
                mousedown: function (t) {
                    t.preventDefault(), this.cancelBlur = !0, this._delay(function () {
                        delete this.cancelBlur
                    });
                    var i = this.menu.element[0];
                    e(t.target).closest(".ui-menu-item").length || this._delay(function () {
                        var t = this;
                        this.document.one("mousedown", function (s) {
                            s.target === t.element[0] || s.target === i || e.contains(i, s.target) || t.close()
                        })
                    })
                }, menufocus: function (t, i) {
                    if (this.isNewMenu && (this.isNewMenu = !1, t.originalEvent && /^mouse/.test(t.originalEvent.type)))return this.menu.blur(), this.document.one("mousemove", function () {
                        e(t.target).trigger(t.originalEvent)
                    }), undefined;
                    var s = i.item.data("ui-autocomplete-item");
                    !1 !== this._trigger("focus", t, {item: s}) ? t.originalEvent && /^key/.test(t.originalEvent.type) && this._value(s.value) : this.liveRegion.text(s.value)
                }, menuselect: function (e, t) {
                    var i = t.item.data("ui-autocomplete-item"), s = this.previous;
                    this.element[0] !== this.document[0].activeElement && (this.element.focus(), this.previous = s, this._delay(function () {
                        this.previous = s, this.selectedItem = i
                    })), !1 !== this._trigger("select", e, {item: i}) && this._value(i.value), this.term = this._value(), this.close(e), this.selectedItem = i
                }
            }), this.liveRegion = e("<span>", {
                role: "status",
                "aria-live": "polite"
            }).addClass("ui-helper-hidden-accessible").insertBefore(this.element), this._on(this.window, {
                beforeunload: function () {
                    this.element.removeAttr("autocomplete")
                }
            })
        },
        _destroy: function () {
            clearTimeout(this.searching), this.element.removeClass("ui-autocomplete-input").removeAttr("autocomplete"), this.menu.element.remove(), this.liveRegion.remove()
        },
        _setOption: function (e, t) {
            this._super(e, t), "source" === e && this._initSource(), "appendTo" === e && this.menu.element.appendTo(this._appendTo()), "disabled" === e && t && this.xhr && this.xhr.abort()
        },
        _appendTo: function () {
            var t = this.options.appendTo;
            return t && (t = t.jquery || t.nodeType ? e(t) : this.document.find(t).eq(0)), t || (t = this.element.closest(".ui-front")), t.length || (t = this.document[0].body), t
        },
        _initSource: function () {
            var t, i, s = this;
            e.isArray(this.options.source) ? (t = this.options.source, this.source = function (i, s) {
                s(e.ui.autocomplete.filter(t, i.term))
            }) : "string" == typeof this.options.source ? (i = this.options.source, this.source = function (t, n) {
                s.xhr && s.xhr.abort(), s.xhr = e.ajax({
                    url: i, data: t, dataType: "json", success: function (e) {
                        n(e)
                    }, error: function () {
                        n([])
                    }
                })
            }) : this.source = this.options.source
        },
        _searchTimeout: function (e) {
            clearTimeout(this.searching), this.searching = this._delay(function () {
                this.term !== this._value() && (this.selectedItem = null, this.search(null, e))
            }, this.options.delay)
        },
        search: function (e, t) {
            return e = null != e ? e : this._value(), this.term = this._value(), e.length < this.options.minLength ? this.close(t) : this._trigger("search", t) !== !1 ? this._search(e) : undefined
        },
        _search: function (e) {
            this.pending++, this.element.addClass("ui-autocomplete-loading"), this.cancelSearch = !1, this.source({term: e}, this._response())
        },
        _response: function () {
            var t = ++this.requestIndex;
            return e.proxy(function (e) {
                t === this.requestIndex && this.__response(e), this.pending--, this.pending || this.element.removeClass("ui-autocomplete-loading")
            }, this)
        },
        __response: function (e) {
            e && (e = this._normalize(e)), this._trigger("response", null, {content: e}), !this.options.disabled && e && e.length && !this.cancelSearch ? (this._suggest(e), this._trigger("open")) : this._close()
        },
        close: function (e) {
            this.cancelSearch = !0, this._close(e)
        },
        _close: function (e) {
            this.menu.element.is(":visible") && (this.menu.element.hide(), this.menu.blur(), this.isNewMenu = !0, this._trigger("close", e))
        },
        _change: function (e) {
            this.previous !== this._value() && this._trigger("change", e, {item: this.selectedItem})
        },
        _normalize: function (t) {
            return t.length && t[0].label && t[0].value ? t : e.map(t, function (t) {
                return "string" == typeof t ? {label: t, value: t} : e.extend({
                    label: t.label || t.value,
                    value: t.value || t.label
                }, t)
            })
        },
        _suggest: function (t) {
            var i = this.menu.element.empty();
            this._renderMenu(i, t), this.isNewMenu = !0, this.menu.refresh(), i.show(), this._resizeMenu(), i.position(e.extend({of: this.element}, this.options.position)), this.options.autoFocus && this.menu.next()
        },
        _resizeMenu: function () {
            var e = this.menu.element;
            e.outerWidth(Math.max(e.width("").outerWidth() + 1, this.element.outerWidth()))
        },
        _renderMenu: function (t, i) {
            var s = this;
            e.each(i, function (e, i) {
                s._renderItemData(t, i)
            })
        },
        _renderItemData: function (e, t) {
            return this._renderItem(e, t).data("ui-autocomplete-item", t)
        },
        _renderItem: function (t, i) {
            return e("<li>").append(e("<a>").text(i.label)).appendTo(t)
        },
        _move: function (e, t) {
            return this.menu.element.is(":visible") ? this.menu.isFirstItem() && /^previous/.test(e) || this.menu.isLastItem() && /^next/.test(e) ? (this._value(this.term), this.menu.blur(), undefined) : (this.menu[e](t), undefined) : (this.search(null, t), undefined)
        },
        widget: function () {
            return this.menu.element
        },
        _value: function () {
            return this.valueMethod.apply(this.element, arguments)
        },
        _keyEvent: function (e, t) {
            (!this.isMultiLine || this.menu.element.is(":visible")) && (this._move(e, t), t.preventDefault())
        }
    }), e.extend(e.ui.autocomplete, {
        escapeRegex: function (e) {
            return e.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, "\\$&")
        }, filter: function (t, i) {
            var s = RegExp(e.ui.autocomplete.escapeRegex(i), "i");
            return e.grep(t, function (e) {
                return s.test(e.label || e.value || e)
            })
        }
    }), e.widget("ui.autocomplete", e.ui.autocomplete, {
        options: {
            messages: {
                noResults: "No search results.",
                results: function (e) {
                    return e + (e > 1 ? " results are" : " result is") + " available, use up and down arrow keys to navigate."
                }
            }
        }, __response: function (e) {
            var t;
            this._superApply(arguments), this.options.disabled || this.cancelSearch || (t = e && e.length ? this.options.messages.results(e.length) : this.options.messages.noResults, this.liveRegion.text(t))
        }
    })
})(jQuery);
(function (e) {
    var t, i = "ui-button ui-widget ui-state-default ui-corner-all", n = "ui-button-icons-only ui-button-icon-only ui-button-text-icons ui-button-text-icon-primary ui-button-text-icon-secondary ui-button-text-only", s = function () {
        var t = e(this);
        setTimeout(function () {
            t.find(":ui-button").button("refresh")
        }, 1)
    }, a = function (t) {
        var i = t.name, n = t.form, s = e([]);
        return i && (i = i.replace(/'/g, "\\'"), s = n ? e(n).find("[name='" + i + "']") : e("[name='" + i + "']", t.ownerDocument).filter(function () {
            return !this.form
        })), s
    };
    e.widget("ui.button", {
        version: "1.10.4",
        defaultElement: "<button>",
        options: {disabled: null, text: !0, label: null, icons: {primary: null, secondary: null}},
        _create: function () {
            this.element.closest("form").unbind("reset" + this.eventNamespace).bind("reset" + this.eventNamespace, s), "boolean" != typeof this.options.disabled ? this.options.disabled = !!this.element.prop("disabled") : this.element.prop("disabled", this.options.disabled), this._determineButtonType(), this.hasTitle = !!this.buttonElement.attr("title");
            var n = this, o = this.options, r = "checkbox" === this.type || "radio" === this.type, h = r ? "" : "ui-state-active";
            null === o.label && (o.label = "input" === this.type ? this.buttonElement.val() : this.buttonElement.html()), this._hoverable(this.buttonElement), this.buttonElement.addClass(i).attr("role", "button").bind("mouseenter" + this.eventNamespace, function () {
                o.disabled || this === t && e(this).addClass("ui-state-active")
            }).bind("mouseleave" + this.eventNamespace, function () {
                o.disabled || e(this).removeClass(h)
            }).bind("click" + this.eventNamespace, function (e) {
                o.disabled && (e.preventDefault(), e.stopImmediatePropagation())
            }), this._on({
                focus: function () {
                    this.buttonElement.addClass("ui-state-focus")
                }, blur: function () {
                    this.buttonElement.removeClass("ui-state-focus")
                }
            }), r && this.element.bind("change" + this.eventNamespace, function () {
                n.refresh()
            }), "checkbox" === this.type ? this.buttonElement.bind("click" + this.eventNamespace, function () {
                return o.disabled ? !1 : undefined
            }) : "radio" === this.type ? this.buttonElement.bind("click" + this.eventNamespace, function () {
                if (o.disabled)return !1;
                e(this).addClass("ui-state-active"), n.buttonElement.attr("aria-pressed", "true");
                var t = n.element[0];
                a(t).not(t).map(function () {
                    return e(this).button("widget")[0]
                }).removeClass("ui-state-active").attr("aria-pressed", "false")
            }) : (this.buttonElement.bind("mousedown" + this.eventNamespace, function () {
                return o.disabled ? !1 : (e(this).addClass("ui-state-active"), t = this, n.document.one("mouseup", function () {
                    t = null
                }), undefined)
            }).bind("mouseup" + this.eventNamespace, function () {
                return o.disabled ? !1 : (e(this).removeClass("ui-state-active"), undefined)
            }).bind("keydown" + this.eventNamespace, function (t) {
                return o.disabled ? !1 : ((t.keyCode === e.ui.keyCode.SPACE || t.keyCode === e.ui.keyCode.ENTER) && e(this).addClass("ui-state-active"), undefined)
            }).bind("keyup" + this.eventNamespace + " blur" + this.eventNamespace, function () {
                e(this).removeClass("ui-state-active")
            }), this.buttonElement.is("a") && this.buttonElement.keyup(function (t) {
                t.keyCode === e.ui.keyCode.SPACE && e(this).click()
            })), this._setOption("disabled", o.disabled), this._resetButton()
        },
        _determineButtonType: function () {
            var e, t, i;
            this.type = this.element.is("[type=checkbox]") ? "checkbox" : this.element.is("[type=radio]") ? "radio" : this.element.is("input") ? "input" : "button", "checkbox" === this.type || "radio" === this.type ? (e = this.element.parents().last(), t = "label[for='" + this.element.attr("id") + "']", this.buttonElement = e.find(t), this.buttonElement.length || (e = e.length ? e.siblings() : this.element.siblings(), this.buttonElement = e.filter(t), this.buttonElement.length || (this.buttonElement = e.find(t))), this.element.addClass("ui-helper-hidden-accessible"), i = this.element.is(":checked"), i && this.buttonElement.addClass("ui-state-active"), this.buttonElement.prop("aria-pressed", i)) : this.buttonElement = this.element
        },
        widget: function () {
            return this.buttonElement
        },
        _destroy: function () {
            this.element.removeClass("ui-helper-hidden-accessible"), this.buttonElement.removeClass(i + " ui-state-active " + n).removeAttr("role").removeAttr("aria-pressed").html(this.buttonElement.find(".ui-button-text").html()), this.hasTitle || this.buttonElement.removeAttr("title")
        },
        _setOption: function (e, t) {
            return this._super(e, t), "disabled" === e ? (this.element.prop("disabled", !!t), t && this.buttonElement.removeClass("ui-state-focus"), undefined) : (this._resetButton(), undefined)
        },
        refresh: function () {
            var t = this.element.is("input, button") ? this.element.is(":disabled") : this.element.hasClass("ui-button-disabled");
            t !== this.options.disabled && this._setOption("disabled", t), "radio" === this.type ? a(this.element[0]).each(function () {
                e(this).is(":checked") ? e(this).button("widget").addClass("ui-state-active").attr("aria-pressed", "true") : e(this).button("widget").removeClass("ui-state-active").attr("aria-pressed", "false")
            }) : "checkbox" === this.type && (this.element.is(":checked") ? this.buttonElement.addClass("ui-state-active").attr("aria-pressed", "true") : this.buttonElement.removeClass("ui-state-active").attr("aria-pressed", "false"))
        },
        _resetButton: function () {
            if ("input" === this.type)return this.options.label && this.element.val(this.options.label), undefined;
            var t = this.buttonElement.removeClass(n), i = e("<span></span>", this.document[0]).addClass("ui-button-text").html(this.options.label).appendTo(t.empty()).text(), s = this.options.icons, a = s.primary && s.secondary, o = [];
            s.primary || s.secondary ? (this.options.text && o.push("ui-button-text-icon" + (a ? "s" : s.primary ? "-primary" : "-secondary")), s.primary && t.prepend("<span class='ui-button-icon-primary ui-icon " + s.primary + "'></span>"), s.secondary && t.append("<span class='ui-button-icon-secondary ui-icon " + s.secondary + "'></span>"), this.options.text || (o.push(a ? "ui-button-icons-only" : "ui-button-icon-only"), this.hasTitle || t.attr("title", e.trim(i)))) : o.push("ui-button-text-only"), t.addClass(o.join(" "))
        }
    }), e.widget("ui.buttonset", {
        version: "1.10.4",
        options: {items: "button, input[type=button], input[type=submit], input[type=reset], input[type=checkbox], input[type=radio], a, :data(ui-button)"},
        _create: function () {
            this.element.addClass("ui-buttonset")
        },
        _init: function () {
            this.refresh()
        },
        _setOption: function (e, t) {
            "disabled" === e && this.buttons.button("option", e, t), this._super(e, t)
        },
        refresh: function () {
            var t = "rtl" === this.element.css("direction");
            this.buttons = this.element.find(this.options.items).filter(":ui-button").button("refresh").end().not(":ui-button").button().end().map(function () {
                return e(this).button("widget")[0]
            }).removeClass("ui-corner-all ui-corner-left ui-corner-right").filter(":first").addClass(t ? "ui-corner-right" : "ui-corner-left").end().filter(":last").addClass(t ? "ui-corner-left" : "ui-corner-right").end().end()
        },
        _destroy: function () {
            this.element.removeClass("ui-buttonset"), this.buttons.map(function () {
                return e(this).button("widget")[0]
            }).removeClass("ui-corner-left ui-corner-right").end().button("destroy")
        }
    })
})(jQuery);
(function (e, t) {
    function i() {
        this._curInst = null, this._keyEvent = !1, this._disabledInputs = [], this._datepickerShowing = !1, this._inDialog = !1, this._mainDivId = "ui-datepicker-div", this._inlineClass = "ui-datepicker-inline", this._appendClass = "ui-datepicker-append", this._triggerClass = "ui-datepicker-trigger", this._dialogClass = "ui-datepicker-dialog", this._disableClass = "ui-datepicker-disabled", this._unselectableClass = "ui-datepicker-unselectable", this._currentClass = "ui-datepicker-current-day", this._dayOverClass = "ui-datepicker-days-cell-over", this.regional = [], this.regional[""] = {
            closeText: "Done",
            prevText: "Prev",
            nextText: "Next",
            currentText: "Today",
            monthNames: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
            monthNamesShort: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            dayNames: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
            dayNamesShort: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"],
            dayNamesMin: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
            weekHeader: "Wk",
            dateFormat: "mm/dd/yy",
            firstDay: 0,
            isRTL: !1,
            showMonthAfterYear: !1,
            yearSuffix: ""
        }, this._defaults = {
            showOn: "focus",
            showAnim: "fadeIn",
            showOptions: {},
            defaultDate: null,
            appendText: "",
            buttonText: "...",
            buttonImage: "",
            buttonImageOnly: !1,
            hideIfNoPrevNext: !1,
            navigationAsDateFormat: !1,
            gotoCurrent: !1,
            changeMonth: !1,
            changeYear: !1,
            yearRange: "c-10:c+10",
            showOtherMonths: !1,
            selectOtherMonths: !1,
            showWeek: !1,
            calculateWeek: this.iso8601Week,
            shortYearCutoff: "+10",
            minDate: null,
            maxDate: null,
            duration: "fast",
            beforeShowDay: null,
            beforeShow: null,
            onSelect: null,
            onChangeMonthYear: null,
            onClose: null,
            numberOfMonths: 1,
            showCurrentAtPos: 0,
            stepMonths: 1,
            stepBigMonths: 12,
            altField: "",
            altFormat: "",
            constrainInput: !0,
            showButtonPanel: !1,
            autoSize: !1,
            disabled: !1
        }, e.extend(this._defaults, this.regional[""]), this.dpDiv = a(e("<div id='" + this._mainDivId + "' class='ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all'></div>"))
    }

    function a(t) {
        var i = "button, .ui-datepicker-prev, .ui-datepicker-next, .ui-datepicker-calendar td a";
        return t.delegate(i, "mouseout", function () {
            e(this).removeClass("ui-state-hover"), -1 !== this.className.indexOf("ui-datepicker-prev") && e(this).removeClass("ui-datepicker-prev-hover"), -1 !== this.className.indexOf("ui-datepicker-next") && e(this).removeClass("ui-datepicker-next-hover")
        }).delegate(i, "mouseover", function () {
            e.datepicker._isDisabledDatepicker(n.inline ? t.parent()[0] : n.input[0]) || (e(this).parents(".ui-datepicker-calendar").find("a").removeClass("ui-state-hover"), e(this).addClass("ui-state-hover"), -1 !== this.className.indexOf("ui-datepicker-prev") && e(this).addClass("ui-datepicker-prev-hover"), -1 !== this.className.indexOf("ui-datepicker-next") && e(this).addClass("ui-datepicker-next-hover"))
        })
    }

    function s(t, i) {
        e.extend(t, i);
        for (var a in i)null == i[a] && (t[a] = i[a]);
        return t
    }

    e.extend(e.ui, {datepicker: {version: "1.10.4"}});
    var n, r = "datepicker";
    e.extend(i.prototype, {
        markerClassName: "hasDatepicker",
        maxRows: 4,
        _widgetDatepicker: function () {
            return this.dpDiv
        },
        setDefaults: function (e) {
            return s(this._defaults, e || {}), this
        },
        _attachDatepicker: function (t, i) {
            var a, s, n;
            a = t.nodeName.toLowerCase(), s = "div" === a || "span" === a, t.id || (this.uuid += 1, t.id = "dp" + this.uuid), n = this._newInst(e(t), s), n.settings = e.extend({}, i || {}), "input" === a ? this._connectDatepicker(t, n) : s && this._inlineDatepicker(t, n)
        },
        _newInst: function (t, i) {
            var s = t[0].id.replace(/([^A-Za-z0-9_\-])/g, "\\\\$1");
            return {
                id: s,
                input: t,
                selectedDay: 0,
                selectedMonth: 0,
                selectedYear: 0,
                drawMonth: 0,
                drawYear: 0,
                inline: i,
                dpDiv: i ? a(e("<div class='" + this._inlineClass + " ui-datepicker ui-widget ui-widget-content ui-helper-clearfix ui-corner-all'></div>")) : this.dpDiv
            }
        },
        _connectDatepicker: function (t, i) {
            var a = e(t);
            i.append = e([]), i.trigger = e([]), a.hasClass(this.markerClassName) || (this._attachments(a, i), a.addClass(this.markerClassName).keydown(this._doKeyDown).keypress(this._doKeyPress).keyup(this._doKeyUp), this._autoSize(i), e.data(t, r, i), i.settings.disabled && this._disableDatepicker(t))
        },
        _attachments: function (t, i) {
            var a, s, n, r = this._get(i, "appendText"), o = this._get(i, "isRTL");
            i.append && i.append.remove(), r && (i.append = e("<span class='" + this._appendClass + "'>" + r + "</span>"), t[o ? "before" : "after"](i.append)), t.unbind("focus", this._showDatepicker), i.trigger && i.trigger.remove(), a = this._get(i, "showOn"), ("focus" === a || "both" === a) && t.focus(this._showDatepicker), ("button" === a || "both" === a) && (s = this._get(i, "buttonText"), n = this._get(i, "buttonImage"), i.trigger = e(this._get(i, "buttonImageOnly") ? e("<img/>").addClass(this._triggerClass).attr({
                src: n,
                alt: s,
                title: s
            }) : e("<button type='button'></button>").addClass(this._triggerClass).html(n ? e("<img/>").attr({
                src: n,
                alt: s,
                title: s
            }) : s)), t[o ? "before" : "after"](i.trigger), i.trigger.click(function () {
                return e.datepicker._datepickerShowing && e.datepicker._lastInput === t[0] ? e.datepicker._hideDatepicker() : e.datepicker._datepickerShowing && e.datepicker._lastInput !== t[0] ? (e.datepicker._hideDatepicker(), e.datepicker._showDatepicker(t[0])) : e.datepicker._showDatepicker(t[0]), !1
            }))
        },
        _autoSize: function (e) {
            if (this._get(e, "autoSize") && !e.inline) {
                var t, i, a, s, n = new Date(2009, 11, 20), r = this._get(e, "dateFormat");
                r.match(/[DM]/) && (t = function (e) {
                    for (i = 0, a = 0, s = 0; e.length > s; s++)e[s].length > i && (i = e[s].length, a = s);
                    return a
                }, n.setMonth(t(this._get(e, r.match(/MM/) ? "monthNames" : "monthNamesShort"))), n.setDate(t(this._get(e, r.match(/DD/) ? "dayNames" : "dayNamesShort")) + 20 - n.getDay())), e.input.attr("size", this._formatDate(e, n).length)
            }
        },
        _inlineDatepicker: function (t, i) {
            var a = e(t);
            a.hasClass(this.markerClassName) || (a.addClass(this.markerClassName).append(i.dpDiv), e.data(t, r, i), this._setDate(i, this._getDefaultDate(i), !0), this._updateDatepicker(i), this._updateAlternate(i), i.settings.disabled && this._disableDatepicker(t), i.dpDiv.css("display", "block"))
        },
        _dialogDatepicker: function (t, i, a, n, o) {
            var u, c, h, l, d, p = this._dialogInst;
            return p || (this.uuid += 1, u = "dp" + this.uuid, this._dialogInput = e("<input type='text' id='" + u + "' style='position: absolute; top: -100px; width: 0px;'/>"), this._dialogInput.keydown(this._doKeyDown), e("body").append(this._dialogInput), p = this._dialogInst = this._newInst(this._dialogInput, !1), p.settings = {}, e.data(this._dialogInput[0], r, p)), s(p.settings, n || {}), i = i && i.constructor === Date ? this._formatDate(p, i) : i, this._dialogInput.val(i), this._pos = o ? o.length ? o : [o.pageX, o.pageY] : null, this._pos || (c = document.documentElement.clientWidth, h = document.documentElement.clientHeight, l = document.documentElement.scrollLeft || document.body.scrollLeft, d = document.documentElement.scrollTop || document.body.scrollTop, this._pos = [c / 2 - 100 + l, h / 2 - 150 + d]), this._dialogInput.css("left", this._pos[0] + 20 + "px").css("top", this._pos[1] + "px"), p.settings.onSelect = a, this._inDialog = !0, this.dpDiv.addClass(this._dialogClass), this._showDatepicker(this._dialogInput[0]), e.blockUI && e.blockUI(this.dpDiv), e.data(this._dialogInput[0], r, p), this
        },
        _destroyDatepicker: function (t) {
            var i, a = e(t), s = e.data(t, r);
            a.hasClass(this.markerClassName) && (i = t.nodeName.toLowerCase(), e.removeData(t, r), "input" === i ? (s.append.remove(), s.trigger.remove(), a.removeClass(this.markerClassName).unbind("focus", this._showDatepicker).unbind("keydown", this._doKeyDown).unbind("keypress", this._doKeyPress).unbind("keyup", this._doKeyUp)) : ("div" === i || "span" === i) && a.removeClass(this.markerClassName).empty())
        },
        _enableDatepicker: function (t) {
            var i, a, s = e(t), n = e.data(t, r);
            s.hasClass(this.markerClassName) && (i = t.nodeName.toLowerCase(), "input" === i ? (t.disabled = !1, n.trigger.filter("button").each(function () {
                this.disabled = !1
            }).end().filter("img").css({
                opacity: "1.0",
                cursor: ""
            })) : ("div" === i || "span" === i) && (a = s.children("." + this._inlineClass), a.children().removeClass("ui-state-disabled"), a.find("select.ui-datepicker-month, select.ui-datepicker-year").prop("disabled", !1)), this._disabledInputs = e.map(this._disabledInputs, function (e) {
                return e === t ? null : e
            }))
        },
        _disableDatepicker: function (t) {
            var i, a, s = e(t), n = e.data(t, r);
            s.hasClass(this.markerClassName) && (i = t.nodeName.toLowerCase(), "input" === i ? (t.disabled = !0, n.trigger.filter("button").each(function () {
                this.disabled = !0
            }).end().filter("img").css({
                opacity: "0.5",
                cursor: "default"
            })) : ("div" === i || "span" === i) && (a = s.children("." + this._inlineClass), a.children().addClass("ui-state-disabled"), a.find("select.ui-datepicker-month, select.ui-datepicker-year").prop("disabled", !0)), this._disabledInputs = e.map(this._disabledInputs, function (e) {
                return e === t ? null : e
            }), this._disabledInputs[this._disabledInputs.length] = t)
        },
        _isDisabledDatepicker: function (e) {
            if (!e)return !1;
            for (var t = 0; this._disabledInputs.length > t; t++)if (this._disabledInputs[t] === e)return !0;
            return !1
        },
        _getInst: function (t) {
            try {
                return e.data(t, r)
            } catch (i) {
                throw"Missing instance data for this datepicker"
            }
        },
        _optionDatepicker: function (i, a, n) {
            var r, o, u, c, h = this._getInst(i);
            return 2 === arguments.length && "string" == typeof a ? "defaults" === a ? e.extend({}, e.datepicker._defaults) : h ? "all" === a ? e.extend({}, h.settings) : this._get(h, a) : null : (r = a || {}, "string" == typeof a && (r = {}, r[a] = n), h && (this._curInst === h && this._hideDatepicker(), o = this._getDateDatepicker(i, !0), u = this._getMinMaxDate(h, "min"), c = this._getMinMaxDate(h, "max"), s(h.settings, r), null !== u && r.dateFormat !== t && r.minDate === t && (h.settings.minDate = this._formatDate(h, u)), null !== c && r.dateFormat !== t && r.maxDate === t && (h.settings.maxDate = this._formatDate(h, c)), "disabled"in r && (r.disabled ? this._disableDatepicker(i) : this._enableDatepicker(i)), this._attachments(e(i), h), this._autoSize(h), this._setDate(h, o), this._updateAlternate(h), this._updateDatepicker(h)), t)
        },
        _changeDatepicker: function (e, t, i) {
            this._optionDatepicker(e, t, i)
        },
        _refreshDatepicker: function (e) {
            var t = this._getInst(e);
            t && this._updateDatepicker(t)
        },
        _setDateDatepicker: function (e, t) {
            var i = this._getInst(e);
            i && (this._setDate(i, t), this._updateDatepicker(i), this._updateAlternate(i))
        },
        _getDateDatepicker: function (e, t) {
            var i = this._getInst(e);
            return i && !i.inline && this._setDateFromField(i, t), i ? this._getDate(i) : null
        },
        _doKeyDown: function (t) {
            var i, a, s, n = e.datepicker._getInst(t.target), r = !0, o = n.dpDiv.is(".ui-datepicker-rtl");
            if (n._keyEvent = !0, e.datepicker._datepickerShowing)switch (t.keyCode) {
                case 9:
                    e.datepicker._hideDatepicker(), r = !1;
                    break;
                case 13:
                    return s = e("td." + e.datepicker._dayOverClass + ":not(." + e.datepicker._currentClass + ")", n.dpDiv), s[0] && e.datepicker._selectDay(t.target, n.selectedMonth, n.selectedYear, s[0]), i = e.datepicker._get(n, "onSelect"), i ? (a = e.datepicker._formatDate(n), i.apply(n.input ? n.input[0] : null, [a, n])) : e.datepicker._hideDatepicker(), !1;
                case 27:
                    e.datepicker._hideDatepicker();
                    break;
                case 33:
                    e.datepicker._adjustDate(t.target, t.ctrlKey ? -e.datepicker._get(n, "stepBigMonths") : -e.datepicker._get(n, "stepMonths"), "M");
                    break;
                case 34:
                    e.datepicker._adjustDate(t.target, t.ctrlKey ? +e.datepicker._get(n, "stepBigMonths") : +e.datepicker._get(n, "stepMonths"), "M");
                    break;
                case 35:
                    (t.ctrlKey || t.metaKey) && e.datepicker._clearDate(t.target), r = t.ctrlKey || t.metaKey;
                    break;
                case 36:
                    (t.ctrlKey || t.metaKey) && e.datepicker._gotoToday(t.target), r = t.ctrlKey || t.metaKey;
                    break;
                case 37:
                    (t.ctrlKey || t.metaKey) && e.datepicker._adjustDate(t.target, o ? 1 : -1, "D"), r = t.ctrlKey || t.metaKey, t.originalEvent.altKey && e.datepicker._adjustDate(t.target, t.ctrlKey ? -e.datepicker._get(n, "stepBigMonths") : -e.datepicker._get(n, "stepMonths"), "M");
                    break;
                case 38:
                    (t.ctrlKey || t.metaKey) && e.datepicker._adjustDate(t.target, -7, "D"), r = t.ctrlKey || t.metaKey;
                    break;
                case 39:
                    (t.ctrlKey || t.metaKey) && e.datepicker._adjustDate(t.target, o ? -1 : 1, "D"), r = t.ctrlKey || t.metaKey, t.originalEvent.altKey && e.datepicker._adjustDate(t.target, t.ctrlKey ? +e.datepicker._get(n, "stepBigMonths") : +e.datepicker._get(n, "stepMonths"), "M");
                    break;
                case 40:
                    (t.ctrlKey || t.metaKey) && e.datepicker._adjustDate(t.target, 7, "D"), r = t.ctrlKey || t.metaKey;
                    break;
                default:
                    r = !1
            } else 36 === t.keyCode && t.ctrlKey ? e.datepicker._showDatepicker(this) : r = !1;
            r && (t.preventDefault(), t.stopPropagation())
        },
        _doKeyPress: function (i) {
            var a, s, n = e.datepicker._getInst(i.target);
            return e.datepicker._get(n, "constrainInput") ? (a = e.datepicker._possibleChars(e.datepicker._get(n, "dateFormat")), s = String.fromCharCode(null == i.charCode ? i.keyCode : i.charCode), i.ctrlKey || i.metaKey || " " > s || !a || a.indexOf(s) > -1) : t
        },
        _doKeyUp: function (t) {
            var i, a = e.datepicker._getInst(t.target);
            if (a.input.val() !== a.lastVal)try {
                i = e.datepicker.parseDate(e.datepicker._get(a, "dateFormat"), a.input ? a.input.val() : null, e.datepicker._getFormatConfig(a)), i && (e.datepicker._setDateFromField(a), e.datepicker._updateAlternate(a), e.datepicker._updateDatepicker(a))
            } catch (s) {
            }
            return !0
        },
        _showDatepicker: function (t) {
            if (t = t.target || t, "input" !== t.nodeName.toLowerCase() && (t = e("input", t.parentNode)[0]), !e.datepicker._isDisabledDatepicker(t) && e.datepicker._lastInput !== t) {
                var i, a, n, r, o, u, c;
                i = e.datepicker._getInst(t), e.datepicker._curInst && e.datepicker._curInst !== i && (e.datepicker._curInst.dpDiv.stop(!0, !0), i && e.datepicker._datepickerShowing && e.datepicker._hideDatepicker(e.datepicker._curInst.input[0])), a = e.datepicker._get(i, "beforeShow"), n = a ? a.apply(t, [t, i]) : {}, n !== !1 && (s(i.settings, n), i.lastVal = null, e.datepicker._lastInput = t, e.datepicker._setDateFromField(i), e.datepicker._inDialog && (t.value = ""), e.datepicker._pos || (e.datepicker._pos = e.datepicker._findPos(t), e.datepicker._pos[1] += t.offsetHeight), r = !1, e(t).parents().each(function () {
                    return r |= "fixed" === e(this).css("position"), !r
                }), o = {
                    left: e.datepicker._pos[0],
                    top: e.datepicker._pos[1]
                }, e.datepicker._pos = null, i.dpDiv.empty(), i.dpDiv.css({
                    position: "absolute",
                    display: "block",
                    top: "-1000px"
                }), e.datepicker._updateDatepicker(i), o = e.datepicker._checkOffset(i, o, r), i.dpDiv.css({
                    position: e.datepicker._inDialog && e.blockUI ? "static" : r ? "fixed" : "absolute",
                    display: "none",
                    left: o.left + "px",
                    top: o.top + "px"
                }), i.inline || (u = e.datepicker._get(i, "showAnim"), c = e.datepicker._get(i, "duration"), i.dpDiv.zIndex(e(t).zIndex() + 1), e.datepicker._datepickerShowing = !0, e.effects && e.effects.effect[u] ? i.dpDiv.show(u, e.datepicker._get(i, "showOptions"), c) : i.dpDiv[u || "show"](u ? c : null), e.datepicker._shouldFocusInput(i) && i.input.focus(), e.datepicker._curInst = i))
            }
        },
        _updateDatepicker: function (t) {
            this.maxRows = 4, n = t, t.dpDiv.empty().append(this._generateHTML(t)), this._attachHandlers(t), t.dpDiv.find("." + this._dayOverClass + " a").mouseover();
            var i, a = this._getNumberOfMonths(t), s = a[1], r = 17;
            t.dpDiv.removeClass("ui-datepicker-multi-2 ui-datepicker-multi-3 ui-datepicker-multi-4").width(""), s > 1 && t.dpDiv.addClass("ui-datepicker-multi-" + s).css("width", r * s + "em"), t.dpDiv[(1 !== a[0] || 1 !== a[1] ? "add" : "remove") + "Class"]("ui-datepicker-multi"), t.dpDiv[(this._get(t, "isRTL") ? "add" : "remove") + "Class"]("ui-datepicker-rtl"), t === e.datepicker._curInst && e.datepicker._datepickerShowing && e.datepicker._shouldFocusInput(t) && t.input.focus(), t.yearshtml && (i = t.yearshtml, setTimeout(function () {
                i === t.yearshtml && t.yearshtml && t.dpDiv.find("select.ui-datepicker-year:first").replaceWith(t.yearshtml), i = t.yearshtml = null
            }, 0))
        },
        _shouldFocusInput: function (e) {
            return e.input && e.input.is(":visible") && !e.input.is(":disabled") && !e.input.is(":focus")
        },
        _checkOffset: function (t, i, a) {
            var s = t.dpDiv.outerWidth(), n = t.dpDiv.outerHeight(), r = t.input ? t.input.outerWidth() : 0, o = t.input ? t.input.outerHeight() : 0, u = document.documentElement.clientWidth + (a ? 0 : e(document).scrollLeft()), c = document.documentElement.clientHeight + (a ? 0 : e(document).scrollTop());
            return i.left -= this._get(t, "isRTL") ? s - r : 0, i.left -= a && i.left === t.input.offset().left ? e(document).scrollLeft() : 0, i.top -= a && i.top === t.input.offset().top + o ? e(document).scrollTop() : 0, i.left -= Math.min(i.left, i.left + s > u && u > s ? Math.abs(i.left + s - u) : 0), i.top -= Math.min(i.top, i.top + n > c && c > n ? Math.abs(n + o) : 0), i
        },
        _findPos: function (t) {
            for (var i, a = this._getInst(t), s = this._get(a, "isRTL"); t && ("hidden" === t.type || 1 !== t.nodeType || e.expr.filters.hidden(t));)t = t[s ? "previousSibling" : "nextSibling"];
            return i = e(t).offset(), [i.left, i.top]
        },
        _hideDatepicker: function (t) {
            var i, a, s, n, o = this._curInst;
            !o || t && o !== e.data(t, r) || this._datepickerShowing && (i = this._get(o, "showAnim"), a = this._get(o, "duration"), s = function () {
                e.datepicker._tidyDialog(o)
            }, e.effects && (e.effects.effect[i] || e.effects[i]) ? o.dpDiv.hide(i, e.datepicker._get(o, "showOptions"), a, s) : o.dpDiv["slideDown" === i ? "slideUp" : "fadeIn" === i ? "fadeOut" : "hide"](i ? a : null, s), i || s(), this._datepickerShowing = !1, n = this._get(o, "onClose"), n && n.apply(o.input ? o.input[0] : null, [o.input ? o.input.val() : "", o]), this._lastInput = null, this._inDialog && (this._dialogInput.css({
                position: "absolute",
                left: "0",
                top: "-100px"
            }), e.blockUI && (e.unblockUI(), e("body").append(this.dpDiv))), this._inDialog = !1)
        },
        _tidyDialog: function (e) {
            e.dpDiv.removeClass(this._dialogClass).unbind(".ui-datepicker-calendar")
        },
        _checkExternalClick: function (t) {
            if (e.datepicker._curInst) {
                var i = e(t.target), a = e.datepicker._getInst(i[0]);
                (i[0].id !== e.datepicker._mainDivId && 0 === i.parents("#" + e.datepicker._mainDivId).length && !i.hasClass(e.datepicker.markerClassName) && !i.closest("." + e.datepicker._triggerClass).length && e.datepicker._datepickerShowing && (!e.datepicker._inDialog || !e.blockUI) || i.hasClass(e.datepicker.markerClassName) && e.datepicker._curInst !== a) && e.datepicker._hideDatepicker()
            }
        },
        _adjustDate: function (t, i, a) {
            var s = e(t), n = this._getInst(s[0]);
            this._isDisabledDatepicker(s[0]) || (this._adjustInstDate(n, i + ("M" === a ? this._get(n, "showCurrentAtPos") : 0), a), this._updateDatepicker(n))
        },
        _gotoToday: function (t) {
            var i, a = e(t), s = this._getInst(a[0]);
            this._get(s, "gotoCurrent") && s.currentDay ? (s.selectedDay = s.currentDay, s.drawMonth = s.selectedMonth = s.currentMonth, s.drawYear = s.selectedYear = s.currentYear) : (i = new Date, s.selectedDay = i.getDate(), s.drawMonth = s.selectedMonth = i.getMonth(), s.drawYear = s.selectedYear = i.getFullYear()), this._notifyChange(s), this._adjustDate(a)
        },
        _selectMonthYear: function (t, i, a) {
            var s = e(t), n = this._getInst(s[0]);
            n["selected" + ("M" === a ? "Month" : "Year")] = n["draw" + ("M" === a ? "Month" : "Year")] = parseInt(i.options[i.selectedIndex].value, 10), this._notifyChange(n), this._adjustDate(s)
        },
        _selectDay: function (t, i, a, s) {
            var n, r = e(t);
            e(s).hasClass(this._unselectableClass) || this._isDisabledDatepicker(r[0]) || (n = this._getInst(r[0]), n.selectedDay = n.currentDay = e("a", s).html(), n.selectedMonth = n.currentMonth = i, n.selectedYear = n.currentYear = a, this._selectDate(t, this._formatDate(n, n.currentDay, n.currentMonth, n.currentYear)))
        },
        _clearDate: function (t) {
            var i = e(t);
            this._selectDate(i, "")
        },
        _selectDate: function (t, i) {
            var a, s = e(t), n = this._getInst(s[0]);
            i = null != i ? i : this._formatDate(n), n.input && n.input.val(i), this._updateAlternate(n), a = this._get(n, "onSelect"), a ? a.apply(n.input ? n.input[0] : null, [i, n]) : n.input && n.input.trigger("change"), n.inline ? this._updateDatepicker(n) : (this._hideDatepicker(), this._lastInput = n.input[0], "object" != typeof n.input[0] && n.input.focus(), this._lastInput = null)
        },
        _updateAlternate: function (t) {
            var i, a, s, n = this._get(t, "altField");
            n && (i = this._get(t, "altFormat") || this._get(t, "dateFormat"), a = this._getDate(t), s = this.formatDate(i, a, this._getFormatConfig(t)), e(n).each(function () {
                e(this).val(s)
            }))
        },
        noWeekends: function (e) {
            var t = e.getDay();
            return [t > 0 && 6 > t, ""]
        },
        iso8601Week: function (e) {
            var t, i = new Date(e.getTime());
            return i.setDate(i.getDate() + 4 - (i.getDay() || 7)), t = i.getTime(), i.setMonth(0), i.setDate(1), Math.floor(Math.round((t - i) / 864e5) / 7) + 1
        },
        parseDate: function (i, a, s) {
            if (null == i || null == a)throw"Invalid arguments";
            if (a = "object" == typeof a ? "" + a : a + "", "" === a)return null;
            var n, r, o, u, c = 0, h = (s ? s.shortYearCutoff : null) || this._defaults.shortYearCutoff, l = "string" != typeof h ? h : (new Date).getFullYear() % 100 + parseInt(h, 10), d = (s ? s.dayNamesShort : null) || this._defaults.dayNamesShort, p = (s ? s.dayNames : null) || this._defaults.dayNames, g = (s ? s.monthNamesShort : null) || this._defaults.monthNamesShort, m = (s ? s.monthNames : null) || this._defaults.monthNames, f = -1, _ = -1, v = -1, k = -1, y = !1, b = function (e) {
                var t = i.length > n + 1 && i.charAt(n + 1) === e;
                return t && n++, t
            }, D = function (e) {
                var t = b(e), i = "@" === e ? 14 : "!" === e ? 20 : "y" === e && t ? 4 : "o" === e ? 3 : 2, s = RegExp("^\\d{1," + i + "}"), n = a.substring(c).match(s);
                if (!n)throw"Missing number at position " + c;
                return c += n[0].length, parseInt(n[0], 10)
            }, w = function (i, s, n) {
                var r = -1, o = e.map(b(i) ? n : s, function (e, t) {
                    return [[t, e]]
                }).sort(function (e, t) {
                    return -(e[1].length - t[1].length)
                });
                if (e.each(o, function (e, i) {
                        var s = i[1];
                        return a.substr(c, s.length).toLowerCase() === s.toLowerCase() ? (r = i[0], c += s.length, !1) : t
                    }), -1 !== r)return r + 1;
                throw"Unknown name at position " + c
            }, M = function () {
                if (a.charAt(c) !== i.charAt(n))throw"Unexpected literal at position " + c;
                c++
            };
            for (n = 0; i.length > n; n++)if (y)"'" !== i.charAt(n) || b("'") ? M() : y = !1; else switch (i.charAt(n)) {
                case"d":
                    v = D("d");
                    break;
                case"D":
                    w("D", d, p);
                    break;
                case"o":
                    k = D("o");
                    break;
                case"m":
                    _ = D("m");
                    break;
                case"M":
                    _ = w("M", g, m);
                    break;
                case"y":
                    f = D("y");
                    break;
                case"@":
                    u = new Date(D("@")), f = u.getFullYear(), _ = u.getMonth() + 1, v = u.getDate();
                    break;
                case"!":
                    u = new Date((D("!") - this._ticksTo1970) / 1e4), f = u.getFullYear(), _ = u.getMonth() + 1, v = u.getDate();
                    break;
                case"'":
                    b("'") ? M() : y = !0;
                    break;
                default:
                    M()
            }
            if (a.length > c && (o = a.substr(c), !/^\s+/.test(o)))throw"Extra/unparsed characters found in date: " + o;
            if (-1 === f ? f = (new Date).getFullYear() : 100 > f && (f += (new Date).getFullYear() - (new Date).getFullYear() % 100 + (l >= f ? 0 : -100)), k > -1)for (_ = 1, v = k; ;) {
                if (r = this._getDaysInMonth(f, _ - 1), r >= v)break;
                _++, v -= r
            }
            if (u = this._daylightSavingAdjust(new Date(f, _ - 1, v)), u.getFullYear() !== f || u.getMonth() + 1 !== _ || u.getDate() !== v)throw"Invalid date";
            return u
        },
        ATOM: "yy-mm-dd",
        COOKIE: "D, dd M yy",
        ISO_8601: "yy-mm-dd",
        RFC_822: "D, d M y",
        RFC_850: "DD, dd-M-y",
        RFC_1036: "D, d M y",
        RFC_1123: "D, d M yy",
        RFC_2822: "D, d M yy",
        RSS: "D, d M y",
        TICKS: "!",
        TIMESTAMP: "@",
        W3C: "yy-mm-dd",
        _ticksTo1970: 1e7 * 60 * 60 * 24 * (718685 + Math.floor(492.5) - Math.floor(19.7) + Math.floor(4.925)),
        formatDate: function (e, t, i) {
            if (!t)return "";
            var a, s = (i ? i.dayNamesShort : null) || this._defaults.dayNamesShort, n = (i ? i.dayNames : null) || this._defaults.dayNames, r = (i ? i.monthNamesShort : null) || this._defaults.monthNamesShort, o = (i ? i.monthNames : null) || this._defaults.monthNames, u = function (t) {
                var i = e.length > a + 1 && e.charAt(a + 1) === t;
                return i && a++, i
            }, c = function (e, t, i) {
                var a = "" + t;
                if (u(e))for (; i > a.length;)a = "0" + a;
                return a
            }, h = function (e, t, i, a) {
                return u(e) ? a[t] : i[t]
            }, l = "", d = !1;
            if (t)for (a = 0; e.length > a; a++)if (d)"'" !== e.charAt(a) || u("'") ? l += e.charAt(a) : d = !1; else switch (e.charAt(a)) {
                case"d":
                    l += c("d", t.getDate(), 2);
                    break;
                case"D":
                    l += h("D", t.getDay(), s, n);
                    break;
                case"o":
                    l += c("o", Math.round((new Date(t.getFullYear(), t.getMonth(), t.getDate()).getTime() - new Date(t.getFullYear(), 0, 0).getTime()) / 864e5), 3);
                    break;
                case"m":
                    l += c("m", t.getMonth() + 1, 2);
                    break;
                case"M":
                    l += h("M", t.getMonth(), r, o);
                    break;
                case"y":
                    l += u("y") ? t.getFullYear() : (10 > t.getYear() % 100 ? "0" : "") + t.getYear() % 100;
                    break;
                case"@":
                    l += t.getTime();
                    break;
                case"!":
                    l += 1e4 * t.getTime() + this._ticksTo1970;
                    break;
                case"'":
                    u("'") ? l += "'" : d = !0;
                    break;
                default:
                    l += e.charAt(a)
            }
            return l
        },
        _possibleChars: function (e) {
            var t, i = "", a = !1, s = function (i) {
                var a = e.length > t + 1 && e.charAt(t + 1) === i;
                return a && t++, a
            };
            for (t = 0; e.length > t; t++)if (a)"'" !== e.charAt(t) || s("'") ? i += e.charAt(t) : a = !1; else switch (e.charAt(t)) {
                case"d":
                case"m":
                case"y":
                case"@":
                    i += "0123456789";
                    break;
                case"D":
                case"M":
                    return null;
                case"'":
                    s("'") ? i += "'" : a = !0;
                    break;
                default:
                    i += e.charAt(t)
            }
            return i
        },
        _get: function (e, i) {
            return e.settings[i] !== t ? e.settings[i] : this._defaults[i]
        },
        _setDateFromField: function (e, t) {
            if (e.input.val() !== e.lastVal) {
                var i = this._get(e, "dateFormat"), a = e.lastVal = e.input ? e.input.val() : null, s = this._getDefaultDate(e), n = s, r = this._getFormatConfig(e);
                try {
                    n = this.parseDate(i, a, r) || s
                } catch (o) {
                    a = t ? "" : a
                }
                e.selectedDay = n.getDate(), e.drawMonth = e.selectedMonth = n.getMonth(), e.drawYear = e.selectedYear = n.getFullYear(), e.currentDay = a ? n.getDate() : 0, e.currentMonth = a ? n.getMonth() : 0, e.currentYear = a ? n.getFullYear() : 0, this._adjustInstDate(e)
            }
        },
        _getDefaultDate: function (e) {
            return this._restrictMinMax(e, this._determineDate(e, this._get(e, "defaultDate"), new Date))
        },
        _determineDate: function (t, i, a) {
            var s = function (e) {
                var t = new Date;
                return t.setDate(t.getDate() + e), t
            }, n = function (i) {
                try {
                    return e.datepicker.parseDate(e.datepicker._get(t, "dateFormat"), i, e.datepicker._getFormatConfig(t))
                } catch (a) {
                }
                for (var s = (i.toLowerCase().match(/^c/) ? e.datepicker._getDate(t) : null) || new Date, n = s.getFullYear(), r = s.getMonth(), o = s.getDate(), u = /([+\-]?[0-9]+)\s*(d|D|w|W|m|M|y|Y)?/g, c = u.exec(i); c;) {
                    switch (c[2] || "d") {
                        case"d":
                        case"D":
                            o += parseInt(c[1], 10);
                            break;
                        case"w":
                        case"W":
                            o += 7 * parseInt(c[1], 10);
                            break;
                        case"m":
                        case"M":
                            r += parseInt(c[1], 10), o = Math.min(o, e.datepicker._getDaysInMonth(n, r));
                            break;
                        case"y":
                        case"Y":
                            n += parseInt(c[1], 10), o = Math.min(o, e.datepicker._getDaysInMonth(n, r))
                    }
                    c = u.exec(i)
                }
                return new Date(n, r, o)
            }, r = null == i || "" === i ? a : "string" == typeof i ? n(i) : "number" == typeof i ? isNaN(i) ? a : s(i) : new Date(i.getTime());
            return r = r && "Invalid Date" == "" + r ? a : r, r && (r.setHours(0), r.setMinutes(0), r.setSeconds(0), r.setMilliseconds(0)), this._daylightSavingAdjust(r)
        },
        _daylightSavingAdjust: function (e) {
            return e ? (e.setHours(e.getHours() > 12 ? e.getHours() + 2 : 0), e) : null
        },
        _setDate: function (e, t, i) {
            var a = !t, s = e.selectedMonth, n = e.selectedYear, r = this._restrictMinMax(e, this._determineDate(e, t, new Date));
            e.selectedDay = e.currentDay = r.getDate(), e.drawMonth = e.selectedMonth = e.currentMonth = r.getMonth(), e.drawYear = e.selectedYear = e.currentYear = r.getFullYear(), s === e.selectedMonth && n === e.selectedYear || i || this._notifyChange(e), this._adjustInstDate(e), e.input && e.input.val(a ? "" : this._formatDate(e))
        },
        _getDate: function (e) {
            var t = !e.currentYear || e.input && "" === e.input.val() ? null : this._daylightSavingAdjust(new Date(e.currentYear, e.currentMonth, e.currentDay));
            return t
        },
        _attachHandlers: function (t) {
            var i = this._get(t, "stepMonths"), a = "#" + t.id.replace(/\\\\/g, "\\");
            t.dpDiv.find("[data-handler]").map(function () {
                var t = {
                    prev: function () {
                        e.datepicker._adjustDate(a, -i, "M")
                    }, next: function () {
                        e.datepicker._adjustDate(a, +i, "M")
                    }, hide: function () {
                        e.datepicker._hideDatepicker()
                    }, today: function () {
                        e.datepicker._gotoToday(a)
                    }, selectDay: function () {
                        return e.datepicker._selectDay(a, +this.getAttribute("data-month"), +this.getAttribute("data-year"), this), !1
                    }, selectMonth: function () {
                        return e.datepicker._selectMonthYear(a, this, "M"), !1
                    }, selectYear: function () {
                        return e.datepicker._selectMonthYear(a, this, "Y"), !1
                    }
                };
                e(this).bind(this.getAttribute("data-event"), t[this.getAttribute("data-handler")])
            })
        },
        _generateHTML: function (e) {
            var t, i, a, s, n, r, o, u, c, h, l, d, p, g, m, f, _, v, k, y, b, D, w, M, C, x, I, N, T, A, E, S, Y, F, P, O, j, K, R, H = new Date, W = this._daylightSavingAdjust(new Date(H.getFullYear(), H.getMonth(), H.getDate())), L = this._get(e, "isRTL"), U = this._get(e, "showButtonPanel"), B = this._get(e, "hideIfNoPrevNext"), z = this._get(e, "navigationAsDateFormat"), q = this._getNumberOfMonths(e), G = this._get(e, "showCurrentAtPos"), J = this._get(e, "stepMonths"), Q = 1 !== q[0] || 1 !== q[1], V = this._daylightSavingAdjust(e.currentDay ? new Date(e.currentYear, e.currentMonth, e.currentDay) : new Date(9999, 9, 9)), $ = this._getMinMaxDate(e, "min"), X = this._getMinMaxDate(e, "max"), Z = e.drawMonth - G, et = e.drawYear;
            if (0 > Z && (Z += 12, et--), X)for (t = this._daylightSavingAdjust(new Date(X.getFullYear(), X.getMonth() - q[0] * q[1] + 1, X.getDate())), t = $ && $ > t ? $ : t; this._daylightSavingAdjust(new Date(et, Z, 1)) > t;)Z--, 0 > Z && (Z = 11, et--);
            for (e.drawMonth = Z, e.drawYear = et, i = this._get(e, "prevText"), i = z ? this.formatDate(i, this._daylightSavingAdjust(new Date(et, Z - J, 1)), this._getFormatConfig(e)) : i, a = this._canAdjustMonth(e, -1, et, Z) ? "<a class='ui-datepicker-prev ui-corner-all' data-handler='prev' data-event='click' title='" + i + "'><span class='ui-icon ui-icon-circle-triangle-" + (L ? "e" : "w") + "'>" + i + "</span></a>" : B ? "" : "<a class='ui-datepicker-prev ui-corner-all ui-state-disabled' title='" + i + "'><span class='ui-icon ui-icon-circle-triangle-" + (L ? "e" : "w") + "'>" + i + "</span></a>", s = this._get(e, "nextText"), s = z ? this.formatDate(s, this._daylightSavingAdjust(new Date(et, Z + J, 1)), this._getFormatConfig(e)) : s, n = this._canAdjustMonth(e, 1, et, Z) ? "<a class='ui-datepicker-next ui-corner-all' data-handler='next' data-event='click' title='" + s + "'><span class='ui-icon ui-icon-circle-triangle-" + (L ? "w" : "e") + "'>" + s + "</span></a>" : B ? "" : "<a class='ui-datepicker-next ui-corner-all ui-state-disabled' title='" + s + "'><span class='ui-icon ui-icon-circle-triangle-" + (L ? "w" : "e") + "'>" + s + "</span></a>", r = this._get(e, "currentText"), o = this._get(e, "gotoCurrent") && e.currentDay ? V : W, r = z ? this.formatDate(r, o, this._getFormatConfig(e)) : r, u = e.inline ? "" : "<button type='button' class='ui-datepicker-close ui-state-default ui-priority-primary ui-corner-all' data-handler='hide' data-event='click'>" + this._get(e, "closeText") + "</button>", c = U ? "<div class='ui-datepicker-buttonpane ui-widget-content'>" + (L ? u : "") + (this._isInRange(e, o) ? "<button type='button' class='ui-datepicker-current ui-state-default ui-priority-secondary ui-corner-all' data-handler='today' data-event='click'>" + r + "</button>" : "") + (L ? "" : u) + "</div>" : "", h = parseInt(this._get(e, "firstDay"), 10), h = isNaN(h) ? 0 : h, l = this._get(e, "showWeek"), d = this._get(e, "dayNames"), p = this._get(e, "dayNamesMin"), g = this._get(e, "monthNames"), m = this._get(e, "monthNamesShort"), f = this._get(e, "beforeShowDay"), _ = this._get(e, "showOtherMonths"), v = this._get(e, "selectOtherMonths"), k = this._getDefaultDate(e), y = "", D = 0; q[0] > D; D++) {
                for (w = "", this.maxRows = 4, M = 0; q[1] > M; M++) {
                    if (C = this._daylightSavingAdjust(new Date(et, Z, e.selectedDay)), x = " ui-corner-all", I = "", Q) {
                        if (I += "<div class='ui-datepicker-group", q[1] > 1)switch (M) {
                            case 0:
                                I += " ui-datepicker-group-first", x = " ui-corner-" + (L ? "right" : "left");
                                break;
                            case q[1] - 1:
                                I += " ui-datepicker-group-last", x = " ui-corner-" + (L ? "left" : "right");
                                break;
                            default:
                                I += " ui-datepicker-group-middle", x = ""
                        }
                        I += "'>"
                    }
                    for (I += "<div class='ui-datepicker-header ui-widget-header ui-helper-clearfix" + x + "'>" + (/all|left/.test(x) && 0 === D ? L ? n : a : "") + (/all|right/.test(x) && 0 === D ? L ? a : n : "") + this._generateMonthYearHeader(e, Z, et, $, X, D > 0 || M > 0, g, m) + "</div><table class='ui-datepicker-calendar'><thead>" + "<tr>", N = l ? "<th class='ui-datepicker-week-col'>" + this._get(e, "weekHeader") + "</th>" : "", b = 0; 7 > b; b++)T = (b + h) % 7, N += "<th" + ((b + h + 6) % 7 >= 5 ? " class='ui-datepicker-week-end'" : "") + ">" + "<span title='" + d[T] + "'>" + p[T] + "</span></th>";
                    for (I += N + "</tr></thead><tbody>", A = this._getDaysInMonth(et, Z), et === e.selectedYear && Z === e.selectedMonth && (e.selectedDay = Math.min(e.selectedDay, A)), E = (this._getFirstDayOfMonth(et, Z) - h + 7) % 7, S = Math.ceil((E + A) / 7), Y = Q ? this.maxRows > S ? this.maxRows : S : S, this.maxRows = Y, F = this._daylightSavingAdjust(new Date(et, Z, 1 - E)), P = 0; Y > P; P++) {
                        for (I += "<tr>", O = l ? "<td class='ui-datepicker-week-col'>" + this._get(e, "calculateWeek")(F) + "</td>" : "", b = 0; 7 > b; b++)j = f ? f.apply(e.input ? e.input[0] : null, [F]) : [!0, ""], K = F.getMonth() !== Z, R = K && !v || !j[0] || $ && $ > F || X && F > X, O += "<td class='" + ((b + h + 6) % 7 >= 5 ? " ui-datepicker-week-end" : "") + (K ? " ui-datepicker-other-month" : "") + (F.getTime() === C.getTime() && Z === e.selectedMonth && e._keyEvent || k.getTime() === F.getTime() && k.getTime() === C.getTime() ? " " + this._dayOverClass : "") + (R ? " " + this._unselectableClass + " ui-state-disabled" : "") + (K && !_ ? "" : " " + j[1] + (F.getTime() === V.getTime() ? " " + this._currentClass : "") + (F.getTime() === W.getTime() ? " ui-datepicker-today" : "")) + "'" + (K && !_ || !j[2] ? "" : " title='" + j[2].replace(/'/g, "&#39;") + "'") + (R ? "" : " data-handler='selectDay' data-event='click' data-month='" + F.getMonth() + "' data-year='" + F.getFullYear() + "'") + ">" + (K && !_ ? "&#xa0;" : R ? "<span class='ui-state-default'>" + F.getDate() + "</span>" : "<a class='ui-state-default" + (F.getTime() === W.getTime() ? " ui-state-highlight" : "") + (F.getTime() === V.getTime() ? " ui-state-active" : "") + (K ? " ui-priority-secondary" : "") + "' href='#'>" + F.getDate() + "</a>") + "</td>", F.setDate(F.getDate() + 1), F = this._daylightSavingAdjust(F);
                        I += O + "</tr>"
                    }
                    Z++, Z > 11 && (Z = 0, et++), I += "</tbody></table>" + (Q ? "</div>" + (q[0] > 0 && M === q[1] - 1 ? "<div class='ui-datepicker-row-break'></div>" : "") : ""), w += I
                }
                y += w
            }
            return y += c, e._keyEvent = !1, y
        },
        _generateMonthYearHeader: function (e, t, i, a, s, n, r, o) {
            var u, c, h, l, d, p, g, m, f = this._get(e, "changeMonth"), _ = this._get(e, "changeYear"), v = this._get(e, "showMonthAfterYear"), k = "<div class='ui-datepicker-title'>", y = "";
            if (n || !f)y += "<span class='ui-datepicker-month'>" + r[t] + "</span>"; else {
                for (u = a && a.getFullYear() === i, c = s && s.getFullYear() === i, y += "<select class='ui-datepicker-month' data-handler='selectMonth' data-event='change'>", h = 0; 12 > h; h++)(!u || h >= a.getMonth()) && (!c || s.getMonth() >= h) && (y += "<option value='" + h + "'" + (h === t ? " selected='selected'" : "") + ">" + o[h] + "</option>");
                y += "</select>"
            }
            if (v || (k += y + (!n && f && _ ? "" : "&#xa0;")), !e.yearshtml)if (e.yearshtml = "", n || !_)k += "<span class='ui-datepicker-year'>" + i + "</span>"; else {
                for (l = this._get(e, "yearRange").split(":"), d = (new Date).getFullYear(), p = function (e) {
                    var t = e.match(/c[+\-].*/) ? i + parseInt(e.substring(1), 10) : e.match(/[+\-].*/) ? d + parseInt(e, 10) : parseInt(e, 10);
                    return isNaN(t) ? d : t
                }, g = p(l[0]), m = Math.max(g, p(l[1] || "")), g = a ? Math.max(g, a.getFullYear()) : g, m = s ? Math.min(m, s.getFullYear()) : m, e.yearshtml += "<select class='ui-datepicker-year' data-handler='selectYear' data-event='change'>"; m >= g; g++)e.yearshtml += "<option value='" + g + "'" + (g === i ? " selected='selected'" : "") + ">" + g + "</option>";
                e.yearshtml += "</select>", k += e.yearshtml, e.yearshtml = null
            }
            return k += this._get(e, "yearSuffix"), v && (k += (!n && f && _ ? "" : "&#xa0;") + y), k += "</div>"
        },
        _adjustInstDate: function (e, t, i) {
            var a = e.drawYear + ("Y" === i ? t : 0), s = e.drawMonth + ("M" === i ? t : 0), n = Math.min(e.selectedDay, this._getDaysInMonth(a, s)) + ("D" === i ? t : 0), r = this._restrictMinMax(e, this._daylightSavingAdjust(new Date(a, s, n)));
            e.selectedDay = r.getDate(), e.drawMonth = e.selectedMonth = r.getMonth(), e.drawYear = e.selectedYear = r.getFullYear(), ("M" === i || "Y" === i) && this._notifyChange(e)
        },
        _restrictMinMax: function (e, t) {
            var i = this._getMinMaxDate(e, "min"), a = this._getMinMaxDate(e, "max"), s = i && i > t ? i : t;
            return a && s > a ? a : s
        },
        _notifyChange: function (e) {
            var t = this._get(e, "onChangeMonthYear");
            t && t.apply(e.input ? e.input[0] : null, [e.selectedYear, e.selectedMonth + 1, e])
        },
        _getNumberOfMonths: function (e) {
            var t = this._get(e, "numberOfMonths");
            return null == t ? [1, 1] : "number" == typeof t ? [1, t] : t
        },
        _getMinMaxDate: function (e, t) {
            return this._determineDate(e, this._get(e, t + "Date"), null)
        },
        _getDaysInMonth: function (e, t) {
            return 32 - this._daylightSavingAdjust(new Date(e, t, 32)).getDate()
        },
        _getFirstDayOfMonth: function (e, t) {
            return new Date(e, t, 1).getDay()
        },
        _canAdjustMonth: function (e, t, i, a) {
            var s = this._getNumberOfMonths(e), n = this._daylightSavingAdjust(new Date(i, a + (0 > t ? t : s[0] * s[1]), 1));
            return 0 > t && n.setDate(this._getDaysInMonth(n.getFullYear(), n.getMonth())), this._isInRange(e, n)
        },
        _isInRange: function (e, t) {
            var i, a, s = this._getMinMaxDate(e, "min"), n = this._getMinMaxDate(e, "max"), r = null, o = null, u = this._get(e, "yearRange");
            return u && (i = u.split(":"), a = (new Date).getFullYear(), r = parseInt(i[0], 10), o = parseInt(i[1], 10), i[0].match(/[+\-].*/) && (r += a), i[1].match(/[+\-].*/) && (o += a)), (!s || t.getTime() >= s.getTime()) && (!n || t.getTime() <= n.getTime()) && (!r || t.getFullYear() >= r) && (!o || o >= t.getFullYear())
        },
        _getFormatConfig: function (e) {
            var t = this._get(e, "shortYearCutoff");
            return t = "string" != typeof t ? t : (new Date).getFullYear() % 100 + parseInt(t, 10), {
                shortYearCutoff: t,
                dayNamesShort: this._get(e, "dayNamesShort"),
                dayNames: this._get(e, "dayNames"),
                monthNamesShort: this._get(e, "monthNamesShort"),
                monthNames: this._get(e, "monthNames")
            }
        },
        _formatDate: function (e, t, i, a) {
            t || (e.currentDay = e.selectedDay, e.currentMonth = e.selectedMonth, e.currentYear = e.selectedYear);
            var s = t ? "object" == typeof t ? t : this._daylightSavingAdjust(new Date(a, i, t)) : this._daylightSavingAdjust(new Date(e.currentYear, e.currentMonth, e.currentDay));
            return this.formatDate(this._get(e, "dateFormat"), s, this._getFormatConfig(e))
        }
    }), e.fn.datepicker = function (t) {
        if (!this.length)return this;
        e.datepicker.initialized || (e(document).mousedown(e.datepicker._checkExternalClick), e.datepicker.initialized = !0), 0 === e("#" + e.datepicker._mainDivId).length && e("body").append(e.datepicker.dpDiv);
        var i = Array.prototype.slice.call(arguments, 1);
        return "string" != typeof t || "isDisabled" !== t && "getDate" !== t && "widget" !== t ? "option" === t && 2 === arguments.length && "string" == typeof arguments[1] ? e.datepicker["_" + t + "Datepicker"].apply(e.datepicker, [this[0]].concat(i)) : this.each(function () {
            "string" == typeof t ? e.datepicker["_" + t + "Datepicker"].apply(e.datepicker, [this].concat(i)) : e.datepicker._attachDatepicker(this, t)
        }) : e.datepicker["_" + t + "Datepicker"].apply(e.datepicker, [this[0]].concat(i))
    }, e.datepicker = new i, e.datepicker.initialized = !1, e.datepicker.uuid = (new Date).getTime(), e.datepicker.version = "1.10.4"
})(jQuery);
(function (e) {
    var t = {
        buttons: !0,
        height: !0,
        maxHeight: !0,
        maxWidth: !0,
        minHeight: !0,
        minWidth: !0,
        width: !0
    }, i = {maxHeight: !0, maxWidth: !0, minHeight: !0, minWidth: !0};
    e.widget("ui.dialog", {
        version: "1.10.4",
        options: {
            appendTo: "body",
            autoOpen: !0,
            buttons: [],
            closeOnEscape: !0,
            closeText: "close",
            dialogClass: "",
            draggable: !0,
            hide: null,
            height: "auto",
            maxHeight: null,
            maxWidth: null,
            minHeight: 150,
            minWidth: 150,
            modal: !1,
            position: {
                my: "center", at: "center", of: window, collision: "fit", using: function (t) {
                    var i = e(this).css(t).offset().top;
                    0 > i && e(this).css("top", t.top - i)
                }
            },
            resizable: !0,
            show: null,
            title: null,
            width: 300,
            beforeClose: null,
            close: null,
            drag: null,
            dragStart: null,
            dragStop: null,
            focus: null,
            open: null,
            resize: null,
            resizeStart: null,
            resizeStop: null
        },
        _create: function () {
            this.originalCss = {
                display: this.element[0].style.display,
                width: this.element[0].style.width,
                minHeight: this.element[0].style.minHeight,
                maxHeight: this.element[0].style.maxHeight,
                height: this.element[0].style.height
            }, this.originalPosition = {
                parent: this.element.parent(),
                index: this.element.parent().children().index(this.element)
            }, this.originalTitle = this.element.attr("title"), this.options.title = this.options.title || this.originalTitle, this._createWrapper(), this.element.show().removeAttr("title").addClass("ui-dialog-content ui-widget-content").appendTo(this.uiDialog), this._createTitlebar(), this._createButtonPane(), this.options.draggable && e.fn.draggable && this._makeDraggable(), this.options.resizable && e.fn.resizable && this._makeResizable(), this._isOpen = !1
        },
        _init: function () {
            this.options.autoOpen && this.open()
        },
        _appendTo: function () {
            var t = this.options.appendTo;
            return t && (t.jquery || t.nodeType) ? e(t) : this.document.find(t || "body").eq(0)
        },
        _destroy: function () {
            var e, t = this.originalPosition;
            this._destroyOverlay(), this.element.removeUniqueId().removeClass("ui-dialog-content ui-widget-content").css(this.originalCss).detach(), this.uiDialog.stop(!0, !0).remove(), this.originalTitle && this.element.attr("title", this.originalTitle), e = t.parent.children().eq(t.index), e.length && e[0] !== this.element[0] ? e.before(this.element) : t.parent.append(this.element)
        },
        widget: function () {
            return this.uiDialog
        },
        disable: e.noop,
        enable: e.noop,
        close: function (t) {
            var i, a = this;
            if (this._isOpen && this._trigger("beforeClose", t) !== !1) {
                if (this._isOpen = !1, this._destroyOverlay(), !this.opener.filter(":focusable").focus().length)try {
                    i = this.document[0].activeElement, i && "body" !== i.nodeName.toLowerCase() && e(i).blur()
                } catch (s) {
                }
                this._hide(this.uiDialog, this.options.hide, function () {
                    a._trigger("close", t)
                })
            }
        },
        isOpen: function () {
            return this._isOpen
        },
        moveToTop: function () {
            this._moveToTop()
        },
        _moveToTop: function (e, t) {
            var i = !!this.uiDialog.nextAll(":visible").insertBefore(this.uiDialog).length;
            return i && !t && this._trigger("focus", e), i
        },
        open: function () {
            var t = this;
            return this._isOpen ? (this._moveToTop() && this._focusTabbable(), undefined) : (this._isOpen = !0, this.opener = e(this.document[0].activeElement), this._size(), this._position(), this._createOverlay(), this._moveToTop(null, !0), this._show(this.uiDialog, this.options.show, function () {
                t._focusTabbable(), t._trigger("focus")
            }), this._trigger("open"), undefined)
        },
        _focusTabbable: function () {
            var e = this.element.find("[autofocus]");
            e.length || (e = this.element.find(":tabbable")), e.length || (e = this.uiDialogButtonPane.find(":tabbable")), e.length || (e = this.uiDialogTitlebarClose.filter(":tabbable")), e.length || (e = this.uiDialog), e.eq(0).focus()
        },
        _keepFocus: function (t) {
            function i() {
                var t = this.document[0].activeElement, i = this.uiDialog[0] === t || e.contains(this.uiDialog[0], t);
                i || this._focusTabbable()
            }

            t.preventDefault(), i.call(this), this._delay(i)
        },
        _createWrapper: function () {
            this.uiDialog = e("<div>").addClass("ui-dialog ui-widget ui-widget-content ui-corner-all ui-front " + this.options.dialogClass).hide().attr({
                tabIndex: -1,
                role: "dialog"
            }).appendTo(this._appendTo()), this._on(this.uiDialog, {
                keydown: function (t) {
                    if (this.options.closeOnEscape && !t.isDefaultPrevented() && t.keyCode && t.keyCode === e.ui.keyCode.ESCAPE)return t.preventDefault(), this.close(t), undefined;
                    if (t.keyCode === e.ui.keyCode.TAB) {
                        var i = this.uiDialog.find(":tabbable"), a = i.filter(":first"), s = i.filter(":last");
                        t.target !== s[0] && t.target !== this.uiDialog[0] || t.shiftKey ? t.target !== a[0] && t.target !== this.uiDialog[0] || !t.shiftKey || (s.focus(1), t.preventDefault()) : (a.focus(1), t.preventDefault())
                    }
                }, mousedown: function (e) {
                    this._moveToTop(e) && this._focusTabbable()
                }
            }), this.element.find("[aria-describedby]").length || this.uiDialog.attr({"aria-describedby": this.element.uniqueId().attr("id")})
        },
        _createTitlebar: function () {
            var t;
            this.uiDialogTitlebar = e("<div>").addClass("ui-dialog-titlebar ui-widget-header ui-corner-all ui-helper-clearfix").prependTo(this.uiDialog), this._on(this.uiDialogTitlebar, {
                mousedown: function (t) {
                    e(t.target).closest(".ui-dialog-titlebar-close") || this.uiDialog.focus()
                }
            }), this.uiDialogTitlebarClose = e("<button type='button'></button>").button({
                label: this.options.closeText,
                icons: {primary: "ui-icon-closethick"},
                text: !1
            }).addClass("ui-dialog-titlebar-close").appendTo(this.uiDialogTitlebar), this._on(this.uiDialogTitlebarClose, {
                click: function (e) {
                    e.preventDefault(), this.close(e)
                }
            }), t = e("<span>").uniqueId().addClass("ui-dialog-title").prependTo(this.uiDialogTitlebar), this._title(t), this.uiDialog.attr({"aria-labelledby": t.attr("id")})
        },
        _title: function (e) {
            this.options.title || e.html("&#160;"), e.text(this.options.title)
        },
        _createButtonPane: function () {
            this.uiDialogButtonPane = e("<div>").addClass("ui-dialog-buttonpane ui-widget-content ui-helper-clearfix"), this.uiButtonSet = e("<div>").addClass("ui-dialog-buttonset").appendTo(this.uiDialogButtonPane), this._createButtons()
        },
        _createButtons: function () {
            var t = this, i = this.options.buttons;
            return this.uiDialogButtonPane.remove(), this.uiButtonSet.empty(), e.isEmptyObject(i) || e.isArray(i) && !i.length ? (this.uiDialog.removeClass("ui-dialog-buttons"), undefined) : (e.each(i, function (i, a) {
                var s, n;
                a = e.isFunction(a) ? {
                    click: a,
                    text: i
                } : a, a = e.extend({type: "button"}, a), s = a.click, a.click = function () {
                    s.apply(t.element[0], arguments)
                }, n = {
                    icons: a.icons,
                    text: a.showText
                }, delete a.icons, delete a.showText, e("<button></button>", a).button(n).appendTo(t.uiButtonSet)
            }), this.uiDialog.addClass("ui-dialog-buttons"), this.uiDialogButtonPane.appendTo(this.uiDialog), undefined)
        },
        _makeDraggable: function () {
            function t(e) {
                return {position: e.position, offset: e.offset}
            }

            var i = this, a = this.options;
            this.uiDialog.draggable({
                cancel: ".ui-dialog-content, .ui-dialog-titlebar-close",
                handle: ".ui-dialog-titlebar",
                containment: "document",
                start: function (a, s) {
                    e(this).addClass("ui-dialog-dragging"), i._blockFrames(), i._trigger("dragStart", a, t(s))
                },
                drag: function (e, a) {
                    i._trigger("drag", e, t(a))
                },
                stop: function (s, n) {
                    a.position = [n.position.left - i.document.scrollLeft(), n.position.top - i.document.scrollTop()], e(this).removeClass("ui-dialog-dragging"), i._unblockFrames(), i._trigger("dragStop", s, t(n))
                }
            })
        },
        _makeResizable: function () {
            function t(e) {
                return {
                    originalPosition: e.originalPosition,
                    originalSize: e.originalSize,
                    position: e.position,
                    size: e.size
                }
            }

            var i = this, a = this.options, s = a.resizable, n = this.uiDialog.css("position"), r = "string" == typeof s ? s : "n,e,s,w,se,sw,ne,nw";
            this.uiDialog.resizable({
                cancel: ".ui-dialog-content",
                containment: "document",
                alsoResize: this.element,
                maxWidth: a.maxWidth,
                maxHeight: a.maxHeight,
                minWidth: a.minWidth,
                minHeight: this._minHeight(),
                handles: r,
                start: function (a, s) {
                    e(this).addClass("ui-dialog-resizing"), i._blockFrames(), i._trigger("resizeStart", a, t(s))
                },
                resize: function (e, a) {
                    i._trigger("resize", e, t(a))
                },
                stop: function (s, n) {
                    a.height = e(this).height(), a.width = e(this).width(), e(this).removeClass("ui-dialog-resizing"), i._unblockFrames(), i._trigger("resizeStop", s, t(n))
                }
            }).css("position", n)
        },
        _minHeight: function () {
            var e = this.options;
            return "auto" === e.height ? e.minHeight : Math.min(e.minHeight, e.height)
        },
        _position: function () {
            var e = this.uiDialog.is(":visible");
            e || this.uiDialog.show(), this.uiDialog.position(this.options.position), e || this.uiDialog.hide()
        },
        _setOptions: function (a) {
            var s = this, n = !1, r = {};
            e.each(a, function (e, a) {
                s._setOption(e, a), e in t && (n = !0), e in i && (r[e] = a)
            }), n && (this._size(), this._position()), this.uiDialog.is(":data(ui-resizable)") && this.uiDialog.resizable("option", r)
        },
        _setOption: function (e, t) {
            var i, a, s = this.uiDialog;
            "dialogClass" === e && s.removeClass(this.options.dialogClass).addClass(t), "disabled" !== e && (this._super(e, t), "appendTo" === e && this.uiDialog.appendTo(this._appendTo()), "buttons" === e && this._createButtons(), "closeText" === e && this.uiDialogTitlebarClose.button({label: "" + t}), "draggable" === e && (i = s.is(":data(ui-draggable)"), i && !t && s.draggable("destroy"), !i && t && this._makeDraggable()), "position" === e && this._position(), "resizable" === e && (a = s.is(":data(ui-resizable)"), a && !t && s.resizable("destroy"), a && "string" == typeof t && s.resizable("option", "handles", t), a || t === !1 || this._makeResizable()), "title" === e && this._title(this.uiDialogTitlebar.find(".ui-dialog-title")))
        },
        _size: function () {
            var e, t, i, a = this.options;
            this.element.show().css({
                width: "auto",
                minHeight: 0,
                maxHeight: "none",
                height: 0
            }), a.minWidth > a.width && (a.width = a.minWidth), e = this.uiDialog.css({
                height: "auto",
                width: a.width
            }).outerHeight(), t = Math.max(0, a.minHeight - e), i = "number" == typeof a.maxHeight ? Math.max(0, a.maxHeight - e) : "none", "auto" === a.height ? this.element.css({
                minHeight: t,
                maxHeight: i,
                height: "auto"
            }) : this.element.height(Math.max(0, a.height - e)), this.uiDialog.is(":data(ui-resizable)") && this.uiDialog.resizable("option", "minHeight", this._minHeight())
        },
        _blockFrames: function () {
            this.iframeBlocks = this.document.find("iframe").map(function () {
                var t = e(this);
                return e("<div>").css({
                    position: "absolute",
                    width: t.outerWidth(),
                    height: t.outerHeight()
                }).appendTo(t.parent()).offset(t.offset())[0]
            })
        },
        _unblockFrames: function () {
            this.iframeBlocks && (this.iframeBlocks.remove(), delete this.iframeBlocks)
        },
        _allowInteraction: function (t) {
            return e(t.target).closest(".ui-dialog").length ? !0 : !!e(t.target).closest(".ui-datepicker").length
        },
        _createOverlay: function () {
            if (this.options.modal) {
                var t = this, i = this.widgetFullName;
                e.ui.dialog.overlayInstances || this._delay(function () {
                    e.ui.dialog.overlayInstances && this.document.bind("focusin.dialog", function (a) {
                        t._allowInteraction(a) || (a.preventDefault(), e(".ui-dialog:visible:last .ui-dialog-content").data(i)._focusTabbable())
                    })
                }), this.overlay = e("<div>").addClass("ui-widget-overlay ui-front").appendTo(this._appendTo()), this._on(this.overlay, {mousedown: "_keepFocus"}), e.ui.dialog.overlayInstances++
            }
        },
        _destroyOverlay: function () {
            this.options.modal && this.overlay && (e.ui.dialog.overlayInstances--, e.ui.dialog.overlayInstances || this.document.unbind("focusin.dialog"), this.overlay.remove(), this.overlay = null)
        }
    }), e.ui.dialog.overlayInstances = 0, e.uiBackCompat !== !1 && e.widget("ui.dialog", e.ui.dialog, {
        _position: function () {
            var t, i = this.options.position, a = [], s = [0, 0];
            i ? (("string" == typeof i || "object" == typeof i && "0"in i) && (a = i.split ? i.split(" ") : [i[0], i[1]], 1 === a.length && (a[1] = a[0]), e.each(["left", "top"], function (e, t) {
                +a[e] === a[e] && (s[e] = a[e], a[e] = t)
            }), i = {
                my: a[0] + (0 > s[0] ? s[0] : "+" + s[0]) + " " + a[1] + (0 > s[1] ? s[1] : "+" + s[1]),
                at: a.join(" ")
            }), i = e.extend({}, e.ui.dialog.prototype.options.position, i)) : i = e.ui.dialog.prototype.options.position, t = this.uiDialog.is(":visible"), t || this.uiDialog.show(), this.uiDialog.position(i), t || this.uiDialog.hide()
        }
    })
})(jQuery);
(function (t) {
    t.widget("ui.menu", {
        version: "1.10.4",
        defaultElement: "<ul>",
        delay: 300,
        options: {
            icons: {submenu: "ui-icon-carat-1-e"},
            menus: "ul",
            position: {my: "left top", at: "right top"},
            role: "menu",
            blur: null,
            focus: null,
            select: null
        },
        _create: function () {
            this.activeMenu = this.element, this.mouseHandled = !1, this.element.uniqueId().addClass("ui-menu ui-widget ui-widget-content ui-corner-all").toggleClass("ui-menu-icons", !!this.element.find(".ui-icon").length).attr({
                role: this.options.role,
                tabIndex: 0
            }).bind("click" + this.eventNamespace, t.proxy(function (t) {
                this.options.disabled && t.preventDefault()
            }, this)), this.options.disabled && this.element.addClass("ui-state-disabled").attr("aria-disabled", "true"), this._on({
                "mousedown .ui-menu-item > a": function (t) {
                    t.preventDefault()
                }, "click .ui-state-disabled > a": function (t) {
                    t.preventDefault()
                }, "click .ui-menu-item:has(a)": function (e) {
                    var i = t(e.target).closest(".ui-menu-item");
                    !this.mouseHandled && i.not(".ui-state-disabled").length && (this.select(e), e.isPropagationStopped() || (this.mouseHandled = !0), i.has(".ui-menu").length ? this.expand(e) : !this.element.is(":focus") && t(this.document[0].activeElement).closest(".ui-menu").length && (this.element.trigger("focus", [!0]), this.active && 1 === this.active.parents(".ui-menu").length && clearTimeout(this.timer)))
                }, "mouseenter .ui-menu-item": function (e) {
                    var i = t(e.currentTarget);
                    i.siblings().children(".ui-state-active").removeClass("ui-state-active"), this.focus(e, i)
                }, mouseleave: "collapseAll", "mouseleave .ui-menu": "collapseAll", focus: function (t, e) {
                    var i = this.active || this.element.children(".ui-menu-item").eq(0);
                    e || this.focus(t, i)
                }, blur: function (e) {
                    this._delay(function () {
                        t.contains(this.element[0], this.document[0].activeElement) || this.collapseAll(e)
                    })
                }, keydown: "_keydown"
            }), this.refresh(), this._on(this.document, {
                click: function (e) {
                    t(e.target).closest(".ui-menu").length || this.collapseAll(e), this.mouseHandled = !1
                }
            })
        },
        _destroy: function () {
            this.element.removeAttr("aria-activedescendant").find(".ui-menu").addBack().removeClass("ui-menu ui-widget ui-widget-content ui-corner-all ui-menu-icons").removeAttr("role").removeAttr("tabIndex").removeAttr("aria-labelledby").removeAttr("aria-expanded").removeAttr("aria-hidden").removeAttr("aria-disabled").removeUniqueId().show(), this.element.find(".ui-menu-item").removeClass("ui-menu-item").removeAttr("role").removeAttr("aria-disabled").children("a").removeUniqueId().removeClass("ui-corner-all ui-state-hover").removeAttr("tabIndex").removeAttr("role").removeAttr("aria-haspopup").children().each(function () {
                var e = t(this);
                e.data("ui-menu-submenu-carat") && e.remove()
            }), this.element.find(".ui-menu-divider").removeClass("ui-menu-divider ui-widget-content")
        },
        _keydown: function (e) {
            function i(t) {
                return t.replace(/[\-\[\]{}()*+?.,\\\^$|#\s]/g, "\\$&")
            }

            var s, n, a, o, r, l = !0;
            switch (e.keyCode) {
                case t.ui.keyCode.PAGE_UP:
                    this.previousPage(e);
                    break;
                case t.ui.keyCode.PAGE_DOWN:
                    this.nextPage(e);
                    break;
                case t.ui.keyCode.HOME:
                    this._move("first", "first", e);
                    break;
                case t.ui.keyCode.END:
                    this._move("last", "last", e);
                    break;
                case t.ui.keyCode.UP:
                    this.previous(e);
                    break;
                case t.ui.keyCode.DOWN:
                    this.next(e);
                    break;
                case t.ui.keyCode.LEFT:
                    this.collapse(e);
                    break;
                case t.ui.keyCode.RIGHT:
                    this.active && !this.active.is(".ui-state-disabled") && this.expand(e);
                    break;
                case t.ui.keyCode.ENTER:
                case t.ui.keyCode.SPACE:
                    this._activate(e);
                    break;
                case t.ui.keyCode.ESCAPE:
                    this.collapse(e);
                    break;
                default:
                    l = !1, n = this.previousFilter || "", a = String.fromCharCode(e.keyCode), o = !1, clearTimeout(this.filterTimer), a === n ? o = !0 : a = n + a, r = RegExp("^" + i(a), "i"), s = this.activeMenu.children(".ui-menu-item").filter(function () {
                        return r.test(t(this).children("a").text())
                    }), s = o && -1 !== s.index(this.active.next()) ? this.active.nextAll(".ui-menu-item") : s, s.length || (a = String.fromCharCode(e.keyCode), r = RegExp("^" + i(a), "i"), s = this.activeMenu.children(".ui-menu-item").filter(function () {
                        return r.test(t(this).children("a").text())
                    })), s.length ? (this.focus(e, s), s.length > 1 ? (this.previousFilter = a, this.filterTimer = this._delay(function () {
                        delete this.previousFilter
                    }, 1e3)) : delete this.previousFilter) : delete this.previousFilter
            }
            l && e.preventDefault()
        },
        _activate: function (t) {
            this.active.is(".ui-state-disabled") || (this.active.children("a[aria-haspopup='true']").length ? this.expand(t) : this.select(t))
        },
        refresh: function () {
            var e, i = this.options.icons.submenu, s = this.element.find(this.options.menus);
            this.element.toggleClass("ui-menu-icons", !!this.element.find(".ui-icon").length), s.filter(":not(.ui-menu)").addClass("ui-menu ui-widget ui-widget-content ui-corner-all").hide().attr({
                role: this.options.role,
                "aria-hidden": "true",
                "aria-expanded": "false"
            }).each(function () {
                var e = t(this), s = e.prev("a"), n = t("<span>").addClass("ui-menu-icon ui-icon " + i).data("ui-menu-submenu-carat", !0);
                s.attr("aria-haspopup", "true").prepend(n), e.attr("aria-labelledby", s.attr("id"))
            }), e = s.add(this.element), e.children(":not(.ui-menu-item):has(a)").addClass("ui-menu-item").attr("role", "presentation").children("a").uniqueId().addClass("ui-corner-all").attr({
                tabIndex: -1,
                role: this._itemRole()
            }), e.children(":not(.ui-menu-item)").each(function () {
                var e = t(this);
                /[^\-\u2014\u2013\s]/.test(e.text()) || e.addClass("ui-widget-content ui-menu-divider")
            }), e.children(".ui-state-disabled").attr("aria-disabled", "true"), this.active && !t.contains(this.element[0], this.active[0]) && this.blur()
        },
        _itemRole: function () {
            return {menu: "menuitem", listbox: "option"}[this.options.role]
        },
        _setOption: function (t, e) {
            "icons" === t && this.element.find(".ui-menu-icon").removeClass(this.options.icons.submenu).addClass(e.submenu), this._super(t, e)
        },
        focus: function (t, e) {
            var i, s;
            this.blur(t, t && "focus" === t.type), this._scrollIntoView(e), this.active = e.first(), s = this.active.children("a").addClass("ui-state-focus"), this.options.role && this.element.attr("aria-activedescendant", s.attr("id")), this.active.parent().closest(".ui-menu-item").children("a:first").addClass("ui-state-active"), t && "keydown" === t.type ? this._close() : this.timer = this._delay(function () {
                this._close()
            }, this.delay), i = e.children(".ui-menu"), i.length && t && /^mouse/.test(t.type) && this._startOpening(i), this.activeMenu = e.parent(), this._trigger("focus", t, {item: e})
        },
        _scrollIntoView: function (e) {
            var i, s, n, a, o, r;
            this._hasScroll() && (i = parseFloat(t.css(this.activeMenu[0], "borderTopWidth")) || 0, s = parseFloat(t.css(this.activeMenu[0], "paddingTop")) || 0, n = e.offset().top - this.activeMenu.offset().top - i - s, a = this.activeMenu.scrollTop(), o = this.activeMenu.height(), r = e.height(), 0 > n ? this.activeMenu.scrollTop(a + n) : n + r > o && this.activeMenu.scrollTop(a + n - o + r))
        },
        blur: function (t, e) {
            e || clearTimeout(this.timer), this.active && (this.active.children("a").removeClass("ui-state-focus"), this.active = null, this._trigger("blur", t, {item: this.active}))
        },
        _startOpening: function (t) {
            clearTimeout(this.timer), "true" === t.attr("aria-hidden") && (this.timer = this._delay(function () {
                this._close(), this._open(t)
            }, this.delay))
        },
        _open: function (e) {
            var i = t.extend({of: this.active}, this.options.position);
            clearTimeout(this.timer), this.element.find(".ui-menu").not(e.parents(".ui-menu")).hide().attr("aria-hidden", "true"), e.show().removeAttr("aria-hidden").attr("aria-expanded", "true").position(i)
        },
        collapseAll: function (e, i) {
            clearTimeout(this.timer), this.timer = this._delay(function () {
                var s = i ? this.element : t(e && e.target).closest(this.element.find(".ui-menu"));
                s.length || (s = this.element), this._close(s), this.blur(e), this.activeMenu = s
            }, this.delay)
        },
        _close: function (t) {
            t || (t = this.active ? this.active.parent() : this.element), t.find(".ui-menu").hide().attr("aria-hidden", "true").attr("aria-expanded", "false").end().find("a.ui-state-active").removeClass("ui-state-active")
        },
        collapse: function (t) {
            var e = this.active && this.active.parent().closest(".ui-menu-item", this.element);
            e && e.length && (this._close(), this.focus(t, e))
        },
        expand: function (t) {
            var e = this.active && this.active.children(".ui-menu ").children(".ui-menu-item").first();
            e && e.length && (this._open(e.parent()), this._delay(function () {
                this.focus(t, e)
            }))
        },
        next: function (t) {
            this._move("next", "first", t)
        },
        previous: function (t) {
            this._move("prev", "last", t)
        },
        isFirstItem: function () {
            return this.active && !this.active.prevAll(".ui-menu-item").length
        },
        isLastItem: function () {
            return this.active && !this.active.nextAll(".ui-menu-item").length
        },
        _move: function (t, e, i) {
            var s;
            this.active && (s = "first" === t || "last" === t ? this.active["first" === t ? "prevAll" : "nextAll"](".ui-menu-item").eq(-1) : this.active[t + "All"](".ui-menu-item").eq(0)), s && s.length && this.active || (s = this.activeMenu.children(".ui-menu-item")[e]()), this.focus(i, s)
        },
        nextPage: function (e) {
            var i, s, n;
            return this.active ? (this.isLastItem() || (this._hasScroll() ? (s = this.active.offset().top, n = this.element.height(), this.active.nextAll(".ui-menu-item").each(function () {
                return i = t(this), 0 > i.offset().top - s - n
            }), this.focus(e, i)) : this.focus(e, this.activeMenu.children(".ui-menu-item")[this.active ? "last" : "first"]())), undefined) : (this.next(e), undefined)
        },
        previousPage: function (e) {
            var i, s, n;
            return this.active ? (this.isFirstItem() || (this._hasScroll() ? (s = this.active.offset().top, n = this.element.height(), this.active.prevAll(".ui-menu-item").each(function () {
                return i = t(this), i.offset().top - s + n > 0
            }), this.focus(e, i)) : this.focus(e, this.activeMenu.children(".ui-menu-item").first())), undefined) : (this.next(e), undefined)
        },
        _hasScroll: function () {
            return this.element.outerHeight() < this.element.prop("scrollHeight")
        },
        select: function (e) {
            this.active = this.active || t(e.target).closest(".ui-menu-item");
            var i = {item: this.active};
            this.active.has(".ui-menu").length || this.collapseAll(e, !0), this._trigger("select", e, i)
        }
    })
})(jQuery);
(function (t, e) {
    t.widget("ui.progressbar", {
        version: "1.10.4",
        options: {max: 100, value: 0, change: null, complete: null},
        min: 0,
        _create: function () {
            this.oldValue = this.options.value = this._constrainedValue(), this.element.addClass("ui-progressbar ui-widget ui-widget-content ui-corner-all").attr({
                role: "progressbar",
                "aria-valuemin": this.min
            }), this.valueDiv = t("<div class='ui-progressbar-value ui-widget-header ui-corner-left'></div>").appendTo(this.element), this._refreshValue()
        },
        _destroy: function () {
            this.element.removeClass("ui-progressbar ui-widget ui-widget-content ui-corner-all").removeAttr("role").removeAttr("aria-valuemin").removeAttr("aria-valuemax").removeAttr("aria-valuenow"), this.valueDiv.remove()
        },
        value: function (t) {
            return t === e ? this.options.value : (this.options.value = this._constrainedValue(t), this._refreshValue(), e)
        },
        _constrainedValue: function (t) {
            return t === e && (t = this.options.value), this.indeterminate = t === !1, "number" != typeof t && (t = 0), this.indeterminate ? !1 : Math.min(this.options.max, Math.max(this.min, t))
        },
        _setOptions: function (t) {
            var e = t.value;
            delete t.value, this._super(t), this.options.value = this._constrainedValue(e), this._refreshValue()
        },
        _setOption: function (t, e) {
            "max" === t && (e = Math.max(this.min, e)), this._super(t, e)
        },
        _percentage: function () {
            return this.indeterminate ? 100 : 100 * (this.options.value - this.min) / (this.options.max - this.min)
        },
        _refreshValue: function () {
            var e = this.options.value, i = this._percentage();
            this.valueDiv.toggle(this.indeterminate || e > this.min).toggleClass("ui-corner-right", e === this.options.max).width(i.toFixed(0) + "%"), this.element.toggleClass("ui-progressbar-indeterminate", this.indeterminate), this.indeterminate ? (this.element.removeAttr("aria-valuenow"), this.overlayDiv || (this.overlayDiv = t("<div class='ui-progressbar-overlay'></div>").appendTo(this.valueDiv))) : (this.element.attr({
                "aria-valuemax": this.options.max,
                "aria-valuenow": e
            }), this.overlayDiv && (this.overlayDiv.remove(), this.overlayDiv = null)), this.oldValue !== e && (this.oldValue = e, this._trigger("change")), e === this.options.max && this._trigger("complete")
        }
    })
})(jQuery);
(function (t) {
    var e = 5;
    t.widget("ui.slider", t.ui.mouse, {
        version: "1.10.4",
        widgetEventPrefix: "slide",
        options: {
            animate: !1,
            distance: 0,
            max: 100,
            min: 0,
            orientation: "horizontal",
            range: !1,
            step: 1,
            value: 0,
            values: null,
            change: null,
            slide: null,
            start: null,
            stop: null
        },
        _create: function () {
            this._keySliding = !1, this._mouseSliding = !1, this._animateOff = !0, this._handleIndex = null, this._detectOrientation(), this._mouseInit(), this.element.addClass("ui-slider ui-slider-" + this.orientation + " ui-widget" + " ui-widget-content" + " ui-corner-all"), this._refresh(), this._setOption("disabled", this.options.disabled), this._animateOff = !1
        },
        _refresh: function () {
            this._createRange(), this._createHandles(), this._setupEvents(), this._refreshValue()
        },
        _createHandles: function () {
            var e, i, s = this.options, n = this.element.find(".ui-slider-handle").addClass("ui-state-default ui-corner-all"), a = "<a class='ui-slider-handle ui-state-default ui-corner-all' href='#'></a>", o = [];
            for (i = s.values && s.values.length || 1, n.length > i && (n.slice(i).remove(), n = n.slice(0, i)), e = n.length; i > e; e++)o.push(a);
            this.handles = n.add(t(o.join("")).appendTo(this.element)), this.handle = this.handles.eq(0), this.handles.each(function (e) {
                t(this).data("ui-slider-handle-index", e)
            })
        },
        _createRange: function () {
            var e = this.options, i = "";
            e.range ? (e.range === !0 && (e.values ? e.values.length && 2 !== e.values.length ? e.values = [e.values[0], e.values[0]] : t.isArray(e.values) && (e.values = e.values.slice(0)) : e.values = [this._valueMin(), this._valueMin()]), this.range && this.range.length ? this.range.removeClass("ui-slider-range-min ui-slider-range-max").css({
                left: "",
                bottom: ""
            }) : (this.range = t("<div></div>").appendTo(this.element), i = "ui-slider-range ui-widget-header ui-corner-all"), this.range.addClass(i + ("min" === e.range || "max" === e.range ? " ui-slider-range-" + e.range : ""))) : (this.range && this.range.remove(), this.range = null)
        },
        _setupEvents: function () {
            var t = this.handles.add(this.range).filter("a");
            this._off(t), this._on(t, this._handleEvents), this._hoverable(t), this._focusable(t)
        },
        _destroy: function () {
            this.handles.remove(), this.range && this.range.remove(), this.element.removeClass("ui-slider ui-slider-horizontal ui-slider-vertical ui-widget ui-widget-content ui-corner-all"), this._mouseDestroy()
        },
        _mouseCapture: function (e) {
            var i, s, n, a, o, r, l, h, u = this, c = this.options;
            return c.disabled ? !1 : (this.elementSize = {
                width: this.element.outerWidth(),
                height: this.element.outerHeight()
            }, this.elementOffset = this.element.offset(), i = {
                x: e.pageX,
                y: e.pageY
            }, s = this._normValueFromMouse(i), n = this._valueMax() - this._valueMin() + 1, this.handles.each(function (e) {
                var i = Math.abs(s - u.values(e));
                (n > i || n === i && (e === u._lastChangedValue || u.values(e) === c.min)) && (n = i, a = t(this), o = e)
            }), r = this._start(e, o), r === !1 ? !1 : (this._mouseSliding = !0, this._handleIndex = o, a.addClass("ui-state-active").focus(), l = a.offset(), h = !t(e.target).parents().addBack().is(".ui-slider-handle"), this._clickOffset = h ? {
                left: 0,
                top: 0
            } : {
                left: e.pageX - l.left - a.width() / 2,
                top: e.pageY - l.top - a.height() / 2 - (parseInt(a.css("borderTopWidth"), 10) || 0) - (parseInt(a.css("borderBottomWidth"), 10) || 0) + (parseInt(a.css("marginTop"), 10) || 0)
            }, this.handles.hasClass("ui-state-hover") || this._slide(e, o, s), this._animateOff = !0, !0))
        },
        _mouseStart: function () {
            return !0
        },
        _mouseDrag: function (t) {
            var e = {x: t.pageX, y: t.pageY}, i = this._normValueFromMouse(e);
            return this._slide(t, this._handleIndex, i), !1
        },
        _mouseStop: function (t) {
            return this.handles.removeClass("ui-state-active"), this._mouseSliding = !1, this._stop(t, this._handleIndex), this._change(t, this._handleIndex), this._handleIndex = null, this._clickOffset = null, this._animateOff = !1, !1
        },
        _detectOrientation: function () {
            this.orientation = "vertical" === this.options.orientation ? "vertical" : "horizontal"
        },
        _normValueFromMouse: function (t) {
            var e, i, s, n, a;
            return "horizontal" === this.orientation ? (e = this.elementSize.width, i = t.x - this.elementOffset.left - (this._clickOffset ? this._clickOffset.left : 0)) : (e = this.elementSize.height, i = t.y - this.elementOffset.top - (this._clickOffset ? this._clickOffset.top : 0)), s = i / e, s > 1 && (s = 1), 0 > s && (s = 0), "vertical" === this.orientation && (s = 1 - s), n = this._valueMax() - this._valueMin(), a = this._valueMin() + s * n, this._trimAlignValue(a)
        },
        _start: function (t, e) {
            var i = {handle: this.handles[e], value: this.value()};
            return this.options.values && this.options.values.length && (i.value = this.values(e), i.values = this.values()), this._trigger("start", t, i)
        },
        _slide: function (t, e, i) {
            var s, n, a;
            this.options.values && this.options.values.length ? (s = this.values(e ? 0 : 1), 2 === this.options.values.length && this.options.range === !0 && (0 === e && i > s || 1 === e && s > i) && (i = s), i !== this.values(e) && (n = this.values(), n[e] = i, a = this._trigger("slide", t, {
                handle: this.handles[e],
                value: i,
                values: n
            }), s = this.values(e ? 0 : 1), a !== !1 && this.values(e, i))) : i !== this.value() && (a = this._trigger("slide", t, {
                handle: this.handles[e],
                value: i
            }), a !== !1 && this.value(i))
        },
        _stop: function (t, e) {
            var i = {handle: this.handles[e], value: this.value()};
            this.options.values && this.options.values.length && (i.value = this.values(e), i.values = this.values()), this._trigger("stop", t, i)
        },
        _change: function (t, e) {
            if (!this._keySliding && !this._mouseSliding) {
                var i = {handle: this.handles[e], value: this.value()};
                this.options.values && this.options.values.length && (i.value = this.values(e), i.values = this.values()), this._lastChangedValue = e, this._trigger("change", t, i)
            }
        },
        value: function (t) {
            return arguments.length ? (this.options.value = this._trimAlignValue(t), this._refreshValue(), this._change(null, 0), undefined) : this._value()
        },
        values: function (e, i) {
            var s, n, a;
            if (arguments.length > 1)return this.options.values[e] = this._trimAlignValue(i), this._refreshValue(), this._change(null, e), undefined;
            if (!arguments.length)return this._values();
            if (!t.isArray(arguments[0]))return this.options.values && this.options.values.length ? this._values(e) : this.value();
            for (s = this.options.values, n = arguments[0], a = 0; s.length > a; a += 1)s[a] = this._trimAlignValue(n[a]), this._change(null, a);
            this._refreshValue()
        },
        _setOption: function (e, i) {
            var s, n = 0;
            switch ("range" === e && this.options.range === !0 && ("min" === i ? (this.options.value = this._values(0), this.options.values = null) : "max" === i && (this.options.value = this._values(this.options.values.length - 1), this.options.values = null)), t.isArray(this.options.values) && (n = this.options.values.length), t.Widget.prototype._setOption.apply(this, arguments), e) {
                case"orientation":
                    this._detectOrientation(), this.element.removeClass("ui-slider-horizontal ui-slider-vertical").addClass("ui-slider-" + this.orientation), this._refreshValue();
                    break;
                case"value":
                    this._animateOff = !0, this._refreshValue(), this._change(null, 0), this._animateOff = !1;
                    break;
                case"values":
                    for (this._animateOff = !0, this._refreshValue(), s = 0; n > s; s += 1)this._change(null, s);
                    this._animateOff = !1;
                    break;
                case"min":
                case"max":
                    this._animateOff = !0, this._refreshValue(), this._animateOff = !1;
                    break;
                case"range":
                    this._animateOff = !0, this._refresh(), this._animateOff = !1
            }
        },
        _value: function () {
            var t = this.options.value;
            return t = this._trimAlignValue(t)
        },
        _values: function (t) {
            var e, i, s;
            if (arguments.length)return e = this.options.values[t], e = this._trimAlignValue(e);
            if (this.options.values && this.options.values.length) {
                for (i = this.options.values.slice(), s = 0; i.length > s; s += 1)i[s] = this._trimAlignValue(i[s]);
                return i
            }
            return []
        },
        _trimAlignValue: function (t) {
            if (this._valueMin() >= t)return this._valueMin();
            if (t >= this._valueMax())return this._valueMax();
            var e = this.options.step > 0 ? this.options.step : 1, i = (t - this._valueMin()) % e, s = t - i;
            return 2 * Math.abs(i) >= e && (s += i > 0 ? e : -e), parseFloat(s.toFixed(5))
        },
        _valueMin: function () {
            return this.options.min
        },
        _valueMax: function () {
            return this.options.max
        },
        _refreshValue: function () {
            var e, i, s, n, a, o = this.options.range, r = this.options, l = this, h = this._animateOff ? !1 : r.animate, u = {};
            this.options.values && this.options.values.length ? this.handles.each(function (s) {
                i = 100 * ((l.values(s) - l._valueMin()) / (l._valueMax() - l._valueMin())), u["horizontal" === l.orientation ? "left" : "bottom"] = i + "%", t(this).stop(1, 1)[h ? "animate" : "css"](u, r.animate), l.options.range === !0 && ("horizontal" === l.orientation ? (0 === s && l.range.stop(1, 1)[h ? "animate" : "css"]({left: i + "%"}, r.animate), 1 === s && l.range[h ? "animate" : "css"]({width: i - e + "%"}, {
                    queue: !1,
                    duration: r.animate
                })) : (0 === s && l.range.stop(1, 1)[h ? "animate" : "css"]({bottom: i + "%"}, r.animate), 1 === s && l.range[h ? "animate" : "css"]({height: i - e + "%"}, {
                    queue: !1,
                    duration: r.animate
                }))), e = i
            }) : (s = this.value(), n = this._valueMin(), a = this._valueMax(), i = a !== n ? 100 * ((s - n) / (a - n)) : 0, u["horizontal" === this.orientation ? "left" : "bottom"] = i + "%", this.handle.stop(1, 1)[h ? "animate" : "css"](u, r.animate), "min" === o && "horizontal" === this.orientation && this.range.stop(1, 1)[h ? "animate" : "css"]({width: i + "%"}, r.animate), "max" === o && "horizontal" === this.orientation && this.range[h ? "animate" : "css"]({width: 100 - i + "%"}, {
                queue: !1,
                duration: r.animate
            }), "min" === o && "vertical" === this.orientation && this.range.stop(1, 1)[h ? "animate" : "css"]({height: i + "%"}, r.animate), "max" === o && "vertical" === this.orientation && this.range[h ? "animate" : "css"]({height: 100 - i + "%"}, {
                queue: !1,
                duration: r.animate
            }))
        },
        _handleEvents: {
            keydown: function (i) {
                var s, n, a, o, r = t(i.target).data("ui-slider-handle-index");
                switch (i.keyCode) {
                    case t.ui.keyCode.HOME:
                    case t.ui.keyCode.END:
                    case t.ui.keyCode.PAGE_UP:
                    case t.ui.keyCode.PAGE_DOWN:
                    case t.ui.keyCode.UP:
                    case t.ui.keyCode.RIGHT:
                    case t.ui.keyCode.DOWN:
                    case t.ui.keyCode.LEFT:
                        if (i.preventDefault(), !this._keySliding && (this._keySliding = !0, t(i.target).addClass("ui-state-active"), s = this._start(i, r), s === !1))return
                }
                switch (o = this.options.step, n = a = this.options.values && this.options.values.length ? this.values(r) : this.value(), i.keyCode) {
                    case t.ui.keyCode.HOME:
                        a = this._valueMin();
                        break;
                    case t.ui.keyCode.END:
                        a = this._valueMax();
                        break;
                    case t.ui.keyCode.PAGE_UP:
                        a = this._trimAlignValue(n + (this._valueMax() - this._valueMin()) / e);
                        break;
                    case t.ui.keyCode.PAGE_DOWN:
                        a = this._trimAlignValue(n - (this._valueMax() - this._valueMin()) / e);
                        break;
                    case t.ui.keyCode.UP:
                    case t.ui.keyCode.RIGHT:
                        if (n === this._valueMax())return;
                        a = this._trimAlignValue(n + o);
                        break;
                    case t.ui.keyCode.DOWN:
                    case t.ui.keyCode.LEFT:
                        if (n === this._valueMin())return;
                        a = this._trimAlignValue(n - o)
                }
                this._slide(i, r, a)
            }, click: function (t) {
                t.preventDefault()
            }, keyup: function (e) {
                var i = t(e.target).data("ui-slider-handle-index");
                this._keySliding && (this._keySliding = !1, this._stop(e, i), this._change(e, i), t(e.target).removeClass("ui-state-active"))
            }
        }
    })
})(jQuery);
(function (t) {
    function e(t) {
        return function () {
            var e = this.element.val();
            t.apply(this, arguments), this._refresh(), e !== this.element.val() && this._trigger("change")
        }
    }

    t.widget("ui.spinner", {
        version: "1.10.4",
        defaultElement: "<input>",
        widgetEventPrefix: "spin",
        options: {
            culture: null,
            icons: {down: "ui-icon-triangle-1-s", up: "ui-icon-triangle-1-n"},
            incremental: !0,
            max: null,
            min: null,
            numberFormat: null,
            page: 10,
            step: 1,
            change: null,
            spin: null,
            start: null,
            stop: null
        },
        _create: function () {
            this._setOption("max", this.options.max), this._setOption("min", this.options.min), this._setOption("step", this.options.step), "" !== this.value() && this._value(this.element.val(), !0), this._draw(), this._on(this._events), this._refresh(), this._on(this.window, {
                beforeunload: function () {
                    this.element.removeAttr("autocomplete")
                }
            })
        },
        _getCreateOptions: function () {
            var e = {}, i = this.element;
            return t.each(["min", "max", "step"], function (t, s) {
                var n = i.attr(s);
                void 0 !== n && n.length && (e[s] = n)
            }), e
        },
        _events: {
            keydown: function (t) {
                this._start(t) && this._keydown(t) && t.preventDefault()
            }, keyup: "_stop", focus: function () {
                this.previous = this.element.val()
            }, blur: function (t) {
                return this.cancelBlur ? (delete this.cancelBlur, void 0) : (this._stop(), this._refresh(), this.previous !== this.element.val() && this._trigger("change", t), void 0)
            }, mousewheel: function (t, e) {
                if (e) {
                    if (!this.spinning && !this._start(t))return !1;
                    this._spin((e > 0 ? 1 : -1) * this.options.step, t), clearTimeout(this.mousewheelTimer), this.mousewheelTimer = this._delay(function () {
                        this.spinning && this._stop(t)
                    }, 100), t.preventDefault()
                }
            }, "mousedown .ui-spinner-button": function (e) {
                function i() {
                    var t = this.element[0] === this.document[0].activeElement;
                    t || (this.element.focus(), this.previous = s, this._delay(function () {
                        this.previous = s
                    }))
                }

                var s;
                s = this.element[0] === this.document[0].activeElement ? this.previous : this.element.val(), e.preventDefault(), i.call(this), this.cancelBlur = !0, this._delay(function () {
                    delete this.cancelBlur, i.call(this)
                }), this._start(e) !== !1 && this._repeat(null, t(e.currentTarget).hasClass("ui-spinner-up") ? 1 : -1, e)
            }, "mouseup .ui-spinner-button": "_stop", "mouseenter .ui-spinner-button": function (e) {
                return t(e.currentTarget).hasClass("ui-state-active") ? this._start(e) === !1 ? !1 : (this._repeat(null, t(e.currentTarget).hasClass("ui-spinner-up") ? 1 : -1, e), void 0) : void 0
            }, "mouseleave .ui-spinner-button": "_stop"
        },
        _draw: function () {
            var t = this.uiSpinner = this.element.addClass("ui-spinner-input").attr("autocomplete", "off").wrap(this._uiSpinnerHtml()).parent().append(this._buttonHtml());
            this.element.attr("role", "spinbutton"), this.buttons = t.find(".ui-spinner-button").attr("tabIndex", -1).button().removeClass("ui-corner-all"), this.buttons.height() > Math.ceil(.5 * t.height()) && t.height() > 0 && t.height(t.height()), this.options.disabled && this.disable()
        },
        _keydown: function (e) {
            var i = this.options, s = t.ui.keyCode;
            switch (e.keyCode) {
                case s.UP:
                    return this._repeat(null, 1, e), !0;
                case s.DOWN:
                    return this._repeat(null, -1, e), !0;
                case s.PAGE_UP:
                    return this._repeat(null, i.page, e), !0;
                case s.PAGE_DOWN:
                    return this._repeat(null, -i.page, e), !0
            }
            return !1
        },
        _uiSpinnerHtml: function () {
            return "<span class='ui-spinner ui-widget ui-widget-content ui-corner-all'></span>"
        },
        _buttonHtml: function () {
            return "<a class='ui-spinner-button ui-spinner-up ui-corner-tr'><span class='ui-icon " + this.options.icons.up + "'>&#9650;</span>" + "</a>" + "<a class='ui-spinner-button ui-spinner-down ui-corner-br'>" + "<span class='ui-icon " + this.options.icons.down + "'>&#9660;</span>" + "</a>"
        },
        _start: function (t) {
            return this.spinning || this._trigger("start", t) !== !1 ? (this.counter || (this.counter = 1), this.spinning = !0, !0) : !1
        },
        _repeat: function (t, e, i) {
            t = t || 500, clearTimeout(this.timer), this.timer = this._delay(function () {
                this._repeat(40, e, i)
            }, t), this._spin(e * this.options.step, i)
        },
        _spin: function (t, e) {
            var i = this.value() || 0;
            this.counter || (this.counter = 1), i = this._adjustValue(i + t * this._increment(this.counter)), this.spinning && this._trigger("spin", e, {value: i}) === !1 || (this._value(i), this.counter++)
        },
        _increment: function (e) {
            var i = this.options.incremental;
            return i ? t.isFunction(i) ? i(e) : Math.floor(e * e * e / 5e4 - e * e / 500 + 17 * e / 200 + 1) : 1
        },
        _precision: function () {
            var t = this._precisionOf(this.options.step);
            return null !== this.options.min && (t = Math.max(t, this._precisionOf(this.options.min))), t
        },
        _precisionOf: function (t) {
            var e = "" + t, i = e.indexOf(".");
            return -1 === i ? 0 : e.length - i - 1
        },
        _adjustValue: function (t) {
            var e, i, s = this.options;
            return e = null !== s.min ? s.min : 0, i = t - e, i = Math.round(i / s.step) * s.step, t = e + i, t = parseFloat(t.toFixed(this._precision())), null !== s.max && t > s.max ? s.max : null !== s.min && s.min > t ? s.min : t
        },
        _stop: function (t) {
            this.spinning && (clearTimeout(this.timer), clearTimeout(this.mousewheelTimer), this.counter = 0, this.spinning = !1, this._trigger("stop", t))
        },
        _setOption: function (t, e) {
            if ("culture" === t || "numberFormat" === t) {
                var i = this._parse(this.element.val());
                return this.options[t] = e, this.element.val(this._format(i)), void 0
            }
            ("max" === t || "min" === t || "step" === t) && "string" == typeof e && (e = this._parse(e)), "icons" === t && (this.buttons.first().find(".ui-icon").removeClass(this.options.icons.up).addClass(e.up), this.buttons.last().find(".ui-icon").removeClass(this.options.icons.down).addClass(e.down)), this._super(t, e), "disabled" === t && (e ? (this.element.prop("disabled", !0), this.buttons.button("disable")) : (this.element.prop("disabled", !1), this.buttons.button("enable")))
        },
        _setOptions: e(function (t) {
            this._super(t), this._value(this.element.val())
        }),
        _parse: function (t) {
            return "string" == typeof t && "" !== t && (t = window.Globalize && this.options.numberFormat ? Globalize.parseFloat(t, 10, this.options.culture) : +t), "" === t || isNaN(t) ? null : t
        },
        _format: function (t) {
            return "" === t ? "" : window.Globalize && this.options.numberFormat ? Globalize.format(t, this.options.numberFormat, this.options.culture) : t
        },
        _refresh: function () {
            this.element.attr({
                "aria-valuemin": this.options.min,
                "aria-valuemax": this.options.max,
                "aria-valuenow": this._parse(this.element.val())
            })
        },
        _value: function (t, e) {
            var i;
            "" !== t && (i = this._parse(t), null !== i && (e || (i = this._adjustValue(i)), t = this._format(i))), this.element.val(t), this._refresh()
        },
        _destroy: function () {
            this.element.removeClass("ui-spinner-input").prop("disabled", !1).removeAttr("autocomplete").removeAttr("role").removeAttr("aria-valuemin").removeAttr("aria-valuemax").removeAttr("aria-valuenow"), this.uiSpinner.replaceWith(this.element)
        },
        stepUp: e(function (t) {
            this._stepUp(t)
        }),
        _stepUp: function (t) {
            this._start() && (this._spin((t || 1) * this.options.step), this._stop())
        },
        stepDown: e(function (t) {
            this._stepDown(t)
        }),
        _stepDown: function (t) {
            this._start() && (this._spin((t || 1) * -this.options.step), this._stop())
        },
        pageUp: e(function (t) {
            this._stepUp((t || 1) * this.options.page)
        }),
        pageDown: e(function (t) {
            this._stepDown((t || 1) * this.options.page)
        }),
        value: function (t) {
            return arguments.length ? (e(this._value).call(this, t), void 0) : this._parse(this.element.val())
        },
        widget: function () {
            return this.uiSpinner
        }
    })
})(jQuery);
(function (t, e) {
    function i() {
        return ++n
    }

    function s(t) {
        return t = t.cloneNode(!1), t.hash.length > 1 && decodeURIComponent(t.href.replace(a, "")) === decodeURIComponent(location.href.replace(a, ""))
    }

    var n = 0, a = /#.*$/;
    t.widget("ui.tabs", {
        version: "1.10.4",
        delay: 300,
        options: {
            active: null,
            collapsible: !1,
            event: "click",
            heightStyle: "content",
            hide: null,
            show: null,
            activate: null,
            beforeActivate: null,
            beforeLoad: null,
            load: null
        },
        _create: function () {
            var e = this, i = this.options;
            this.running = !1, this.element.addClass("ui-tabs ui-widget ui-widget-content ui-corner-all").toggleClass("ui-tabs-collapsible", i.collapsible).delegate(".ui-tabs-nav > li", "mousedown" + this.eventNamespace, function (e) {
                t(this).is(".ui-state-disabled") && e.preventDefault()
            }).delegate(".ui-tabs-anchor", "focus" + this.eventNamespace, function () {
                t(this).closest("li").is(".ui-state-disabled") && this.blur()
            }), this._processTabs(), i.active = this._initialActive(), t.isArray(i.disabled) && (i.disabled = t.unique(i.disabled.concat(t.map(this.tabs.filter(".ui-state-disabled"), function (t) {
                return e.tabs.index(t)
            }))).sort()), this.active = this.options.active !== !1 && this.anchors.length ? this._findActive(i.active) : t(), this._refresh(), this.active.length && this.load(i.active)
        },
        _initialActive: function () {
            var i = this.options.active, s = this.options.collapsible, n = location.hash.substring(1);
            return null === i && (n && this.tabs.each(function (s, a) {
                return t(a).attr("aria-controls") === n ? (i = s, !1) : e
            }), null === i && (i = this.tabs.index(this.tabs.filter(".ui-tabs-active"))), (null === i || -1 === i) && (i = this.tabs.length ? 0 : !1)), i !== !1 && (i = this.tabs.index(this.tabs.eq(i)), -1 === i && (i = s ? !1 : 0)), !s && i === !1 && this.anchors.length && (i = 0), i
        },
        _getCreateEventData: function () {
            return {tab: this.active, panel: this.active.length ? this._getPanelForTab(this.active) : t()}
        },
        _tabKeydown: function (i) {
            var s = t(this.document[0].activeElement).closest("li"), n = this.tabs.index(s), a = !0;
            if (!this._handlePageNav(i)) {
                switch (i.keyCode) {
                    case t.ui.keyCode.RIGHT:
                    case t.ui.keyCode.DOWN:
                        n++;
                        break;
                    case t.ui.keyCode.UP:
                    case t.ui.keyCode.LEFT:
                        a = !1, n--;
                        break;
                    case t.ui.keyCode.END:
                        n = this.anchors.length - 1;
                        break;
                    case t.ui.keyCode.HOME:
                        n = 0;
                        break;
                    case t.ui.keyCode.SPACE:
                        return i.preventDefault(), clearTimeout(this.activating), this._activate(n), e;
                    case t.ui.keyCode.ENTER:
                        return i.preventDefault(), clearTimeout(this.activating), this._activate(n === this.options.active ? !1 : n), e;
                    default:
                        return
                }
                i.preventDefault(), clearTimeout(this.activating), n = this._focusNextTab(n, a), i.ctrlKey || (s.attr("aria-selected", "false"), this.tabs.eq(n).attr("aria-selected", "true"), this.activating = this._delay(function () {
                    this.option("active", n)
                }, this.delay))
            }
        },
        _panelKeydown: function (e) {
            this._handlePageNav(e) || e.ctrlKey && e.keyCode === t.ui.keyCode.UP && (e.preventDefault(), this.active.focus())
        },
        _handlePageNav: function (i) {
            return i.altKey && i.keyCode === t.ui.keyCode.PAGE_UP ? (this._activate(this._focusNextTab(this.options.active - 1, !1)), !0) : i.altKey && i.keyCode === t.ui.keyCode.PAGE_DOWN ? (this._activate(this._focusNextTab(this.options.active + 1, !0)), !0) : e
        },
        _findNextTab: function (e, i) {
            function s() {
                return e > n && (e = 0), 0 > e && (e = n), e
            }

            for (var n = this.tabs.length - 1; -1 !== t.inArray(s(), this.options.disabled);)e = i ? e + 1 : e - 1;
            return e
        },
        _focusNextTab: function (t, e) {
            return t = this._findNextTab(t, e), this.tabs.eq(t).focus(), t
        },
        _setOption: function (t, i) {
            return "active" === t ? (this._activate(i), e) : "disabled" === t ? (this._setupDisabled(i), e) : (this._super(t, i), "collapsible" === t && (this.element.toggleClass("ui-tabs-collapsible", i), i || this.options.active !== !1 || this._activate(0)), "event" === t && this._setupEvents(i), "heightStyle" === t && this._setupHeightStyle(i), e)
        },
        _tabId: function (t) {
            return t.attr("aria-controls") || "ui-tabs-" + i()
        },
        _sanitizeSelector: function (t) {
            return t ? t.replace(/[!"$%&'()*+,.\/:;<=>?@\[\]\^`{|}~]/g, "\\$&") : ""
        },
        refresh: function () {
            var e = this.options, i = this.tablist.children(":has(a[href])");
            e.disabled = t.map(i.filter(".ui-state-disabled"), function (t) {
                return i.index(t)
            }), this._processTabs(), e.active !== !1 && this.anchors.length ? this.active.length && !t.contains(this.tablist[0], this.active[0]) ? this.tabs.length === e.disabled.length ? (e.active = !1, this.active = t()) : this._activate(this._findNextTab(Math.max(0, e.active - 1), !1)) : e.active = this.tabs.index(this.active) : (e.active = !1, this.active = t()), this._refresh()
        },
        _refresh: function () {
            this._setupDisabled(this.options.disabled), this._setupEvents(this.options.event), this._setupHeightStyle(this.options.heightStyle), this.tabs.not(this.active).attr({
                "aria-selected": "false",
                tabIndex: -1
            }), this.panels.not(this._getPanelForTab(this.active)).hide().attr({
                "aria-expanded": "false",
                "aria-hidden": "true"
            }), this.active.length ? (this.active.addClass("ui-tabs-active ui-state-active").attr({
                "aria-selected": "true",
                tabIndex: 0
            }), this._getPanelForTab(this.active).show().attr({
                "aria-expanded": "true",
                "aria-hidden": "false"
            })) : this.tabs.eq(0).attr("tabIndex", 0)
        },
        _processTabs: function () {
            var e = this;
            this.tablist = this._getList().addClass("ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all").attr("role", "tablist"), this.tabs = this.tablist.find("> li:has(a[href])").addClass("ui-state-default ui-corner-top").attr({
                role: "tab",
                tabIndex: -1
            }), this.anchors = this.tabs.map(function () {
                return t("a", this)[0]
            }).addClass("ui-tabs-anchor").attr({
                role: "presentation",
                tabIndex: -1
            }), this.panels = t(), this.anchors.each(function (i, n) {
                var a, o, r, h = t(n).uniqueId().attr("id"), l = t(n).closest("li"), c = l.attr("aria-controls");
                s(n) ? (a = n.hash, o = e.element.find(e._sanitizeSelector(a))) : (r = e._tabId(l), a = "#" + r, o = e.element.find(a), o.length || (o = e._createPanel(r), o.insertAfter(e.panels[i - 1] || e.tablist)), o.attr("aria-live", "polite")), o.length && (e.panels = e.panels.add(o)), c && l.data("ui-tabs-aria-controls", c), l.attr({
                    "aria-controls": a.substring(1),
                    "aria-labelledby": h
                }), o.attr("aria-labelledby", h)
            }), this.panels.addClass("ui-tabs-panel ui-widget-content ui-corner-bottom").attr("role", "tabpanel")
        },
        _getList: function () {
            return this.tablist || this.element.find("ol,ul").eq(0)
        },
        _createPanel: function (e) {
            return t("<div>").attr("id", e).addClass("ui-tabs-panel ui-widget-content ui-corner-bottom").data("ui-tabs-destroy", !0)
        },
        _setupDisabled: function (e) {
            t.isArray(e) && (e.length ? e.length === this.anchors.length && (e = !0) : e = !1);
            for (var i, s = 0; i = this.tabs[s]; s++)e === !0 || -1 !== t.inArray(s, e) ? t(i).addClass("ui-state-disabled").attr("aria-disabled", "true") : t(i).removeClass("ui-state-disabled").removeAttr("aria-disabled");
            this.options.disabled = e
        },
        _setupEvents: function (e) {
            var i = {
                click: function (t) {
                    t.preventDefault()
                }
            };
            e && t.each(e.split(" "), function (t, e) {
                i[e] = "_eventHandler"
            }), this._off(this.anchors.add(this.tabs).add(this.panels)), this._on(this.anchors, i), this._on(this.tabs, {keydown: "_tabKeydown"}), this._on(this.panels, {keydown: "_panelKeydown"}), this._focusable(this.tabs), this._hoverable(this.tabs)
        },
        _setupHeightStyle: function (e) {
            var i, s = this.element.parent();
            "fill" === e ? (i = s.height(), i -= this.element.outerHeight() - this.element.height(), this.element.siblings(":visible").each(function () {
                var e = t(this), s = e.css("position");
                "absolute" !== s && "fixed" !== s && (i -= e.outerHeight(!0))
            }), this.element.children().not(this.panels).each(function () {
                i -= t(this).outerHeight(!0)
            }), this.panels.each(function () {
                t(this).height(Math.max(0, i - t(this).innerHeight() + t(this).height()))
            }).css("overflow", "auto")) : "auto" === e && (i = 0, this.panels.each(function () {
                i = Math.max(i, t(this).height("").height())
            }).height(i))
        },
        _eventHandler: function (e) {
            var i = this.options, s = this.active, n = t(e.currentTarget), a = n.closest("li"), o = a[0] === s[0], r = o && i.collapsible, h = r ? t() : this._getPanelForTab(a), l = s.length ? this._getPanelForTab(s) : t(), c = {
                oldTab: s,
                oldPanel: l,
                newTab: r ? t() : a,
                newPanel: h
            };
            e.preventDefault(), a.hasClass("ui-state-disabled") || a.hasClass("ui-tabs-loading") || this.running || o && !i.collapsible || this._trigger("beforeActivate", e, c) === !1 || (i.active = r ? !1 : this.tabs.index(a), this.active = o ? t() : a, this.xhr && this.xhr.abort(), l.length || h.length || t.error("jQuery UI Tabs: Mismatching fragment identifier."), h.length && this.load(this.tabs.index(a), e), this._toggle(e, c))
        },
        _toggle: function (e, i) {
            function s() {
                a.running = !1, a._trigger("activate", e, i)
            }

            function n() {
                i.newTab.closest("li").addClass("ui-tabs-active ui-state-active"), o.length && a.options.show ? a._show(o, a.options.show, s) : (o.show(), s())
            }

            var a = this, o = i.newPanel, r = i.oldPanel;
            this.running = !0, r.length && this.options.hide ? this._hide(r, this.options.hide, function () {
                i.oldTab.closest("li").removeClass("ui-tabs-active ui-state-active"), n()
            }) : (i.oldTab.closest("li").removeClass("ui-tabs-active ui-state-active"), r.hide(), n()), r.attr({
                "aria-expanded": "false",
                "aria-hidden": "true"
            }), i.oldTab.attr("aria-selected", "false"), o.length && r.length ? i.oldTab.attr("tabIndex", -1) : o.length && this.tabs.filter(function () {
                return 0 === t(this).attr("tabIndex")
            }).attr("tabIndex", -1), o.attr({
                "aria-expanded": "true",
                "aria-hidden": "false"
            }), i.newTab.attr({"aria-selected": "true", tabIndex: 0})
        },
        _activate: function (e) {
            var i, s = this._findActive(e);
            s[0] !== this.active[0] && (s.length || (s = this.active), i = s.find(".ui-tabs-anchor")[0], this._eventHandler({
                target: i,
                currentTarget: i,
                preventDefault: t.noop
            }))
        },
        _findActive: function (e) {
            return e === !1 ? t() : this.tabs.eq(e)
        },
        _getIndex: function (t) {
            return "string" == typeof t && (t = this.anchors.index(this.anchors.filter("[href$='" + t + "']"))), t
        },
        _destroy: function () {
            this.xhr && this.xhr.abort(), this.element.removeClass("ui-tabs ui-widget ui-widget-content ui-corner-all ui-tabs-collapsible"), this.tablist.removeClass("ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all").removeAttr("role"), this.anchors.removeClass("ui-tabs-anchor").removeAttr("role").removeAttr("tabIndex").removeUniqueId(), this.tabs.add(this.panels).each(function () {
                t.data(this, "ui-tabs-destroy") ? t(this).remove() : t(this).removeClass("ui-state-default ui-state-active ui-state-disabled ui-corner-top ui-corner-bottom ui-widget-content ui-tabs-active ui-tabs-panel").removeAttr("tabIndex").removeAttr("aria-live").removeAttr("aria-busy").removeAttr("aria-selected").removeAttr("aria-labelledby").removeAttr("aria-hidden").removeAttr("aria-expanded").removeAttr("role")
            }), this.tabs.each(function () {
                var e = t(this), i = e.data("ui-tabs-aria-controls");
                i ? e.attr("aria-controls", i).removeData("ui-tabs-aria-controls") : e.removeAttr("aria-controls")
            }), this.panels.show(), "content" !== this.options.heightStyle && this.panels.css("height", "")
        },
        enable: function (i) {
            var s = this.options.disabled;
            s !== !1 && (i === e ? s = !1 : (i = this._getIndex(i), s = t.isArray(s) ? t.map(s, function (t) {
                return t !== i ? t : null
            }) : t.map(this.tabs, function (t, e) {
                return e !== i ? e : null
            })), this._setupDisabled(s))
        },
        disable: function (i) {
            var s = this.options.disabled;
            if (s !== !0) {
                if (i === e)s = !0; else {
                    if (i = this._getIndex(i), -1 !== t.inArray(i, s))return;
                    s = t.isArray(s) ? t.merge([i], s).sort() : [i]
                }
                this._setupDisabled(s)
            }
        },
        load: function (e, i) {
            e = this._getIndex(e);
            var n = this, a = this.tabs.eq(e), o = a.find(".ui-tabs-anchor"), r = this._getPanelForTab(a), h = {
                tab: a,
                panel: r
            };
            s(o[0]) || (this.xhr = t.ajax(this._ajaxSettings(o, i, h)), this.xhr && "canceled" !== this.xhr.statusText && (a.addClass("ui-tabs-loading"), r.attr("aria-busy", "true"), this.xhr.success(function (t) {
                setTimeout(function () {
                    r.html(t), n._trigger("load", i, h)
                }, 1)
            }).complete(function (t, e) {
                setTimeout(function () {
                    "abort" === e && n.panels.stop(!1, !0), a.removeClass("ui-tabs-loading"), r.removeAttr("aria-busy"), t === n.xhr && delete n.xhr
                }, 1)
            })))
        },
        _ajaxSettings: function (e, i, s) {
            var n = this;
            return {
                url: e.attr("href"), beforeSend: function (e, a) {
                    return n._trigger("beforeLoad", i, t.extend({jqXHR: e, ajaxSettings: a}, s))
                }
            }
        },
        _getPanelForTab: function (e) {
            var i = t(e).attr("aria-controls");
            return this.element.find(this._sanitizeSelector("#" + i))
        }
    })
})(jQuery);
(function (t) {
    function e(e, i) {
        var s = (e.attr("aria-describedby") || "").split(/\s+/);
        s.push(i), e.data("ui-tooltip-id", i).attr("aria-describedby", t.trim(s.join(" ")))
    }

    function i(e) {
        var i = e.data("ui-tooltip-id"), s = (e.attr("aria-describedby") || "").split(/\s+/), n = t.inArray(i, s);
        -1 !== n && s.splice(n, 1), e.removeData("ui-tooltip-id"), s = t.trim(s.join(" ")), s ? e.attr("aria-describedby", s) : e.removeAttr("aria-describedby")
    }

    var s = 0;
    t.widget("ui.tooltip", {
        version: "1.10.4", options: {
            content: function () {
                var e = t(this).attr("title") || "";
                return t("<a>").text(e).html()
            },
            hide: !0,
            items: "[title]:not([disabled])",
            position: {my: "left top+15", at: "left bottom", collision: "flipfit flip"},
            show: !0,
            tooltipClass: null,
            track: !1,
            close: null,
            open: null
        }, _create: function () {
            this._on({
                mouseover: "open",
                focusin: "open"
            }), this.tooltips = {}, this.parents = {}, this.options.disabled && this._disable()
        }, _setOption: function (e, i) {
            var s = this;
            return "disabled" === e ? (this[i ? "_disable" : "_enable"](), this.options[e] = i, void 0) : (this._super(e, i), "content" === e && t.each(this.tooltips, function (t, e) {
                s._updateContent(e)
            }), void 0)
        }, _disable: function () {
            var e = this;
            t.each(this.tooltips, function (i, s) {
                var n = t.Event("blur");
                n.target = n.currentTarget = s[0], e.close(n, !0)
            }), this.element.find(this.options.items).addBack().each(function () {
                var e = t(this);
                e.is("[title]") && e.data("ui-tooltip-title", e.attr("title")).attr("title", "")
            })
        }, _enable: function () {
            this.element.find(this.options.items).addBack().each(function () {
                var e = t(this);
                e.data("ui-tooltip-title") && e.attr("title", e.data("ui-tooltip-title"))
            })
        }, open: function (e) {
            var i = this, s = t(e ? e.target : this.element).closest(this.options.items);
            s.length && !s.data("ui-tooltip-id") && (s.attr("title") && s.data("ui-tooltip-title", s.attr("title")), s.data("ui-tooltip-open", !0), e && "mouseover" === e.type && s.parents().each(function () {
                var e, s = t(this);
                s.data("ui-tooltip-open") && (e = t.Event("blur"), e.target = e.currentTarget = this, i.close(e, !0)), s.attr("title") && (s.uniqueId(), i.parents[this.id] = {
                    element: this,
                    title: s.attr("title")
                }, s.attr("title", ""))
            }), this._updateContent(s, e))
        }, _updateContent: function (t, e) {
            var i, s = this.options.content, n = this, o = e ? e.type : null;
            return "string" == typeof s ? this._open(e, t, s) : (i = s.call(t[0], function (i) {
                t.data("ui-tooltip-open") && n._delay(function () {
                    e && (e.type = o), this._open(e, t, i)
                })
            }), i && this._open(e, t, i), void 0)
        }, _open: function (i, s, n) {
            function o(t) {
                l.of = t, a.is(":hidden") || a.position(l)
            }

            var a, r, h, l = t.extend({}, this.options.position);
            if (n) {
                if (a = this._find(s), a.length)return a.find(".ui-tooltip-content").html(n), void 0;
                s.is("[title]") && (i && "mouseover" === i.type ? s.attr("title", "") : s.removeAttr("title")), a = this._tooltip(s), e(s, a.attr("id")), a.find(".ui-tooltip-content").html(n), this.options.track && i && /^mouse/.test(i.type) ? (this._on(this.document, {mousemove: o}), o(i)) : a.position(t.extend({of: s}, this.options.position)), a.hide(), this._show(a, this.options.show), this.options.show && this.options.show.delay && (h = this.delayedShow = setInterval(function () {
                    a.is(":visible") && (o(l.of), clearInterval(h))
                }, t.fx.interval)), this._trigger("open", i, {tooltip: a}), r = {
                    keyup: function (e) {
                        if (e.keyCode === t.ui.keyCode.ESCAPE) {
                            var i = t.Event(e);
                            i.currentTarget = s[0], this.close(i, !0)
                        }
                    }, remove: function () {
                        this._removeTooltip(a)
                    }
                }, i && "mouseover" !== i.type || (r.mouseleave = "close"), i && "focusin" !== i.type || (r.focusout = "close"), this._on(!0, s, r)
            }
        }, close: function (e) {
            var s = this, n = t(e ? e.currentTarget : this.element), o = this._find(n);
            this.closing || (clearInterval(this.delayedShow), n.data("ui-tooltip-title") && n.attr("title", n.data("ui-tooltip-title")), i(n), o.stop(!0), this._hide(o, this.options.hide, function () {
                s._removeTooltip(t(this))
            }), n.removeData("ui-tooltip-open"), this._off(n, "mouseleave focusout keyup"), n[0] !== this.element[0] && this._off(n, "remove"), this._off(this.document, "mousemove"), e && "mouseleave" === e.type && t.each(this.parents, function (e, i) {
                t(i.element).attr("title", i.title), delete s.parents[e]
            }), this.closing = !0, this._trigger("close", e, {tooltip: o}), this.closing = !1)
        }, _tooltip: function (e) {
            var i = "ui-tooltip-" + s++, n = t("<div>").attr({
                id: i,
                role: "tooltip"
            }).addClass("ui-tooltip ui-widget ui-corner-all ui-widget-content " + (this.options.tooltipClass || ""));
            return t("<div>").addClass("ui-tooltip-content").appendTo(n), n.appendTo(this.document[0].body), this.tooltips[i] = e, n
        }, _find: function (e) {
            var i = e.data("ui-tooltip-id");
            return i ? t("#" + i) : t()
        }, _removeTooltip: function (t) {
            t.remove(), delete this.tooltips[t.attr("id")]
        }, _destroy: function () {
            var e = this;
            t.each(this.tooltips, function (i, s) {
                var n = t.Event("blur");
                n.target = n.currentTarget = s[0], e.close(n, !0), t("#" + i).remove(), s.data("ui-tooltip-title") && (s.attr("title", s.data("ui-tooltip-title")), s.removeData("ui-tooltip-title"))
            })
        }
    })
})(jQuery);
(function (t, e) {
    var i = "ui-effects-";
    t.effects = {effect: {}}, function (t, e) {
        function i(t, e, i) {
            var s = u[e.type] || {};
            return null == t ? i || !e.def ? null : e.def : (t = s.floor ? ~~t : parseFloat(t), isNaN(t) ? e.def : s.mod ? (t + s.mod) % s.mod : 0 > t ? 0 : t > s.max ? s.max : t)
        }

        function s(i) {
            var s = h(), n = s._rgba = [];
            return i = i.toLowerCase(), f(l, function (t, a) {
                var o, r = a.re.exec(i), l = r && a.parse(r), h = a.space || "rgba";
                return l ? (o = s[h](l), s[c[h].cache] = o[c[h].cache], n = s._rgba = o._rgba, !1) : e
            }), n.length ? ("0,0,0,0" === n.join() && t.extend(n, a.transparent), s) : a[i]
        }

        function n(t, e, i) {
            return i = (i + 1) % 1, 1 > 6 * i ? t + 6 * (e - t) * i : 1 > 2 * i ? e : 2 > 3 * i ? t + 6 * (e - t) * (2 / 3 - i) : t
        }

        var a, o = "backgroundColor borderBottomColor borderLeftColor borderRightColor borderTopColor color columnRuleColor outlineColor textDecorationColor textEmphasisColor", r = /^([\-+])=\s*(\d+\.?\d*)/, l = [{
            re: /rgba?\(\s*(\d{1,3})\s*,\s*(\d{1,3})\s*,\s*(\d{1,3})\s*(?:,\s*(\d?(?:\.\d+)?)\s*)?\)/,
            parse: function (t) {
                return [t[1], t[2], t[3], t[4]]
            }
        }, {
            re: /rgba?\(\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*(?:,\s*(\d?(?:\.\d+)?)\s*)?\)/,
            parse: function (t) {
                return [2.55 * t[1], 2.55 * t[2], 2.55 * t[3], t[4]]
            }
        }, {
            re: /#([a-f0-9]{2})([a-f0-9]{2})([a-f0-9]{2})/, parse: function (t) {
                return [parseInt(t[1], 16), parseInt(t[2], 16), parseInt(t[3], 16)]
            }
        }, {
            re: /#([a-f0-9])([a-f0-9])([a-f0-9])/, parse: function (t) {
                return [parseInt(t[1] + t[1], 16), parseInt(t[2] + t[2], 16), parseInt(t[3] + t[3], 16)]
            }
        }, {
            re: /hsla?\(\s*(\d+(?:\.\d+)?)\s*,\s*(\d+(?:\.\d+)?)\%\s*,\s*(\d+(?:\.\d+)?)\%\s*(?:,\s*(\d?(?:\.\d+)?)\s*)?\)/,
            space: "hsla",
            parse: function (t) {
                return [t[1], t[2] / 100, t[3] / 100, t[4]]
            }
        }], h = t.Color = function (e, i, s, n) {
            return new t.Color.fn.parse(e, i, s, n)
        }, c = {
            rgba: {
                props: {
                    red: {idx: 0, type: "byte"},
                    green: {idx: 1, type: "byte"},
                    blue: {idx: 2, type: "byte"}
                }
            },
            hsla: {
                props: {
                    hue: {idx: 0, type: "degrees"},
                    saturation: {idx: 1, type: "percent"},
                    lightness: {idx: 2, type: "percent"}
                }
            }
        }, u = {
            "byte": {floor: !0, max: 255},
            percent: {max: 1},
            degrees: {mod: 360, floor: !0}
        }, d = h.support = {}, p = t("<p>")[0], f = t.each;
        p.style.cssText = "background-color:rgba(1,1,1,.5)", d.rgba = p.style.backgroundColor.indexOf("rgba") > -1, f(c, function (t, e) {
            e.cache = "_" + t, e.props.alpha = {idx: 3, type: "percent", def: 1}
        }), h.fn = t.extend(h.prototype, {
            parse: function (n, o, r, l) {
                if (n === e)return this._rgba = [null, null, null, null], this;
                (n.jquery || n.nodeType) && (n = t(n).css(o), o = e);
                var u = this, d = t.type(n), p = this._rgba = [];
                return o !== e && (n = [n, o, r, l], d = "array"), "string" === d ? this.parse(s(n) || a._default) : "array" === d ? (f(c.rgba.props, function (t, e) {
                    p[e.idx] = i(n[e.idx], e)
                }), this) : "object" === d ? (n instanceof h ? f(c, function (t, e) {
                    n[e.cache] && (u[e.cache] = n[e.cache].slice())
                }) : f(c, function (e, s) {
                    var a = s.cache;
                    f(s.props, function (t, e) {
                        if (!u[a] && s.to) {
                            if ("alpha" === t || null == n[t])return;
                            u[a] = s.to(u._rgba)
                        }
                        u[a][e.idx] = i(n[t], e, !0)
                    }), u[a] && 0 > t.inArray(null, u[a].slice(0, 3)) && (u[a][3] = 1, s.from && (u._rgba = s.from(u[a])))
                }), this) : e
            }, is: function (t) {
                var i = h(t), s = !0, n = this;
                return f(c, function (t, a) {
                    var o, r = i[a.cache];
                    return r && (o = n[a.cache] || a.to && a.to(n._rgba) || [], f(a.props, function (t, i) {
                        return null != r[i.idx] ? s = r[i.idx] === o[i.idx] : e
                    })), s
                }), s
            }, _space: function () {
                var t = [], e = this;
                return f(c, function (i, s) {
                    e[s.cache] && t.push(i)
                }), t.pop()
            }, transition: function (t, e) {
                var s = h(t), n = s._space(), a = c[n], o = 0 === this.alpha() ? h("transparent") : this, r = o[a.cache] || a.to(o._rgba), l = r.slice();
                return s = s[a.cache], f(a.props, function (t, n) {
                    var a = n.idx, o = r[a], h = s[a], c = u[n.type] || {};
                    null !== h && (null === o ? l[a] = h : (c.mod && (h - o > c.mod / 2 ? o += c.mod : o - h > c.mod / 2 && (o -= c.mod)), l[a] = i((h - o) * e + o, n)))
                }), this[n](l)
            }, blend: function (e) {
                if (1 === this._rgba[3])return this;
                var i = this._rgba.slice(), s = i.pop(), n = h(e)._rgba;
                return h(t.map(i, function (t, e) {
                    return (1 - s) * n[e] + s * t
                }))
            }, toRgbaString: function () {
                var e = "rgba(", i = t.map(this._rgba, function (t, e) {
                    return null == t ? e > 2 ? 1 : 0 : t
                });
                return 1 === i[3] && (i.pop(), e = "rgb("), e + i.join() + ")"
            }, toHslaString: function () {
                var e = "hsla(", i = t.map(this.hsla(), function (t, e) {
                    return null == t && (t = e > 2 ? 1 : 0), e && 3 > e && (t = Math.round(100 * t) + "%"), t
                });
                return 1 === i[3] && (i.pop(), e = "hsl("), e + i.join() + ")"
            }, toHexString: function (e) {
                var i = this._rgba.slice(), s = i.pop();
                return e && i.push(~~(255 * s)), "#" + t.map(i, function (t) {
                    return t = (t || 0).toString(16), 1 === t.length ? "0" + t : t
                }).join("")
            }, toString: function () {
                return 0 === this._rgba[3] ? "transparent" : this.toRgbaString()
            }
        }), h.fn.parse.prototype = h.fn, c.hsla.to = function (t) {
            if (null == t[0] || null == t[1] || null == t[2])return [null, null, null, t[3]];
            var e, i, s = t[0] / 255, n = t[1] / 255, a = t[2] / 255, o = t[3], r = Math.max(s, n, a), l = Math.min(s, n, a), h = r - l, c = r + l, u = .5 * c;
            return e = l === r ? 0 : s === r ? 60 * (n - a) / h + 360 : n === r ? 60 * (a - s) / h + 120 : 60 * (s - n) / h + 240, i = 0 === h ? 0 : .5 >= u ? h / c : h / (2 - c), [Math.round(e) % 360, i, u, null == o ? 1 : o]
        }, c.hsla.from = function (t) {
            if (null == t[0] || null == t[1] || null == t[2])return [null, null, null, t[3]];
            var e = t[0] / 360, i = t[1], s = t[2], a = t[3], o = .5 >= s ? s * (1 + i) : s + i - s * i, r = 2 * s - o;
            return [Math.round(255 * n(r, o, e + 1 / 3)), Math.round(255 * n(r, o, e)), Math.round(255 * n(r, o, e - 1 / 3)), a]
        }, f(c, function (s, n) {
            var a = n.props, o = n.cache, l = n.to, c = n.from;
            h.fn[s] = function (s) {
                if (l && !this[o] && (this[o] = l(this._rgba)), s === e)return this[o].slice();
                var n, r = t.type(s), u = "array" === r || "object" === r ? s : arguments, d = this[o].slice();
                return f(a, function (t, e) {
                    var s = u["object" === r ? t : e.idx];
                    null == s && (s = d[e.idx]), d[e.idx] = i(s, e)
                }), c ? (n = h(c(d)), n[o] = d, n) : h(d)
            }, f(a, function (e, i) {
                h.fn[e] || (h.fn[e] = function (n) {
                    var a, o = t.type(n), l = "alpha" === e ? this._hsla ? "hsla" : "rgba" : s, h = this[l](), c = h[i.idx];
                    return "undefined" === o ? c : ("function" === o && (n = n.call(this, c), o = t.type(n)), null == n && i.empty ? this : ("string" === o && (a = r.exec(n), a && (n = c + parseFloat(a[2]) * ("+" === a[1] ? 1 : -1))), h[i.idx] = n, this[l](h)))
                })
            })
        }), h.hook = function (e) {
            var i = e.split(" ");
            f(i, function (e, i) {
                t.cssHooks[i] = {
                    set: function (e, n) {
                        var a, o, r = "";
                        if ("transparent" !== n && ("string" !== t.type(n) || (a = s(n)))) {
                            if (n = h(a || n), !d.rgba && 1 !== n._rgba[3]) {
                                for (o = "backgroundColor" === i ? e.parentNode : e; ("" === r || "transparent" === r) && o && o.style;)try {
                                    r = t.css(o, "backgroundColor"), o = o.parentNode
                                } catch (l) {
                                }
                                n = n.blend(r && "transparent" !== r ? r : "_default")
                            }
                            n = n.toRgbaString()
                        }
                        try {
                            e.style[i] = n
                        } catch (l) {
                        }
                    }
                }, t.fx.step[i] = function (e) {
                    e.colorInit || (e.start = h(e.elem, i), e.end = h(e.end), e.colorInit = !0), t.cssHooks[i].set(e.elem, e.start.transition(e.end, e.pos))
                }
            })
        }, h.hook(o), t.cssHooks.borderColor = {
            expand: function (t) {
                var e = {};
                return f(["Top", "Right", "Bottom", "Left"], function (i, s) {
                    e["border" + s + "Color"] = t
                }), e
            }
        }, a = t.Color.names = {
            aqua: "#00ffff",
            black: "#000000",
            blue: "#0000ff",
            fuchsia: "#ff00ff",
            gray: "#808080",
            green: "#008000",
            lime: "#00ff00",
            maroon: "#800000",
            navy: "#000080",
            olive: "#808000",
            purple: "#800080",
            red: "#ff0000",
            silver: "#c0c0c0",
            teal: "#008080",
            white: "#ffffff",
            yellow: "#ffff00",
            transparent: [null, null, null, 0],
            _default: "#ffffff"
        }
    }(jQuery), function () {
        function i(e) {
            var i, s, n = e.ownerDocument.defaultView ? e.ownerDocument.defaultView.getComputedStyle(e, null) : e.currentStyle, a = {};
            if (n && n.length && n[0] && n[n[0]])for (s = n.length; s--;)i = n[s], "string" == typeof n[i] && (a[t.camelCase(i)] = n[i]); else for (i in n)"string" == typeof n[i] && (a[i] = n[i]);
            return a
        }

        function s(e, i) {
            var s, n, o = {};
            for (s in i)n = i[s], e[s] !== n && (a[s] || (t.fx.step[s] || !isNaN(parseFloat(n))) && (o[s] = n));
            return o
        }

        var n = ["add", "remove", "toggle"], a = {
            border: 1,
            borderBottom: 1,
            borderColor: 1,
            borderLeft: 1,
            borderRight: 1,
            borderTop: 1,
            borderWidth: 1,
            margin: 1,
            padding: 1
        };
        t.each(["borderLeftStyle", "borderRightStyle", "borderBottomStyle", "borderTopStyle"], function (e, i) {
            t.fx.step[i] = function (t) {
                ("none" !== t.end && !t.setAttr || 1 === t.pos && !t.setAttr) && (jQuery.style(t.elem, i, t.end), t.setAttr = !0)
            }
        }), t.fn.addBack || (t.fn.addBack = function (t) {
            return this.add(null == t ? this.prevObject : this.prevObject.filter(t))
        }), t.effects.animateClass = function (e, a, o, r) {
            var l = t.speed(a, o, r);
            return this.queue(function () {
                var a, o = t(this), r = o.attr("class") || "", h = l.children ? o.find("*").addBack() : o;
                h = h.map(function () {
                    var e = t(this);
                    return {el: e, start: i(this)}
                }), a = function () {
                    t.each(n, function (t, i) {
                        e[i] && o[i + "Class"](e[i])
                    })
                }, a(), h = h.map(function () {
                    return this.end = i(this.el[0]), this.diff = s(this.start, this.end), this
                }), o.attr("class", r), h = h.map(function () {
                    var e = this, i = t.Deferred(), s = t.extend({}, l, {
                        queue: !1, complete: function () {
                            i.resolve(e)
                        }
                    });
                    return this.el.animate(this.diff, s), i.promise()
                }), t.when.apply(t, h.get()).done(function () {
                    a(), t.each(arguments, function () {
                        var e = this.el;
                        t.each(this.diff, function (t) {
                            e.css(t, "")
                        })
                    }), l.complete.call(o[0])
                })
            })
        }, t.fn.extend({
            addClass: function (e) {
                return function (i, s, n, a) {
                    return s ? t.effects.animateClass.call(this, {add: i}, s, n, a) : e.apply(this, arguments)
                }
            }(t.fn.addClass), removeClass: function (e) {
                return function (i, s, n, a) {
                    return arguments.length > 1 ? t.effects.animateClass.call(this, {remove: i}, s, n, a) : e.apply(this, arguments)
                }
            }(t.fn.removeClass), toggleClass: function (i) {
                return function (s, n, a, o, r) {
                    return "boolean" == typeof n || n === e ? a ? t.effects.animateClass.call(this, n ? {add: s} : {remove: s}, a, o, r) : i.apply(this, arguments) : t.effects.animateClass.call(this, {toggle: s}, n, a, o)
                }
            }(t.fn.toggleClass), switchClass: function (e, i, s, n, a) {
                return t.effects.animateClass.call(this, {add: i, remove: e}, s, n, a)
            }
        })
    }(), function () {
        function s(e, i, s, n) {
            return t.isPlainObject(e) && (i = e, e = e.effect), e = {effect: e}, null == i && (i = {}), t.isFunction(i) && (n = i, s = null, i = {}), ("number" == typeof i || t.fx.speeds[i]) && (n = s, s = i, i = {}), t.isFunction(s) && (n = s, s = null), i && t.extend(e, i), s = s || i.duration, e.duration = t.fx.off ? 0 : "number" == typeof s ? s : s in t.fx.speeds ? t.fx.speeds[s] : t.fx.speeds._default, e.complete = n || i.complete, e
        }

        function n(e) {
            return !e || "number" == typeof e || t.fx.speeds[e] ? !0 : "string" != typeof e || t.effects.effect[e] ? t.isFunction(e) ? !0 : "object" != typeof e || e.effect ? !1 : !0 : !0
        }

        t.extend(t.effects, {
            version: "1.10.4", save: function (t, e) {
                for (var s = 0; e.length > s; s++)null !== e[s] && t.data(i + e[s], t[0].style[e[s]])
            }, restore: function (t, s) {
                var n, a;
                for (a = 0; s.length > a; a++)null !== s[a] && (n = t.data(i + s[a]), n === e && (n = ""), t.css(s[a], n))
            }, setMode: function (t, e) {
                return "toggle" === e && (e = t.is(":hidden") ? "show" : "hide"), e
            }, getBaseline: function (t, e) {
                var i, s;
                switch (t[0]) {
                    case"top":
                        i = 0;
                        break;
                    case"middle":
                        i = .5;
                        break;
                    case"bottom":
                        i = 1;
                        break;
                    default:
                        i = t[0] / e.height
                }
                switch (t[1]) {
                    case"left":
                        s = 0;
                        break;
                    case"center":
                        s = .5;
                        break;
                    case"right":
                        s = 1;
                        break;
                    default:
                        s = t[1] / e.width
                }
                return {x: s, y: i}
            }, createWrapper: function (e) {
                if (e.parent().is(".ui-effects-wrapper"))return e.parent();
                var i = {
                    width: e.outerWidth(!0),
                    height: e.outerHeight(!0),
                    "float": e.css("float")
                }, s = t("<div></div>").addClass("ui-effects-wrapper").css({
                    fontSize: "100%",
                    background: "transparent",
                    border: "none",
                    margin: 0,
                    padding: 0
                }), n = {width: e.width(), height: e.height()}, a = document.activeElement;
                try {
                    a.id
                } catch (o) {
                    a = document.body
                }
                return e.wrap(s), (e[0] === a || t.contains(e[0], a)) && t(a).focus(), s = e.parent(), "static" === e.css("position") ? (s.css({position: "relative"}), e.css({position: "relative"})) : (t.extend(i, {
                    position: e.css("position"),
                    zIndex: e.css("z-index")
                }), t.each(["top", "left", "bottom", "right"], function (t, s) {
                    i[s] = e.css(s), isNaN(parseInt(i[s], 10)) && (i[s] = "auto")
                }), e.css({
                    position: "relative",
                    top: 0,
                    left: 0,
                    right: "auto",
                    bottom: "auto"
                })), e.css(n), s.css(i).show()
            }, removeWrapper: function (e) {
                var i = document.activeElement;
                return e.parent().is(".ui-effects-wrapper") && (e.parent().replaceWith(e), (e[0] === i || t.contains(e[0], i)) && t(i).focus()), e
            }, setTransition: function (e, i, s, n) {
                return n = n || {}, t.each(i, function (t, i) {
                    var a = e.cssUnit(i);
                    a[0] > 0 && (n[i] = a[0] * s + a[1])
                }), n
            }
        }), t.fn.extend({
            effect: function () {
                function e(e) {
                    function s() {
                        t.isFunction(a) && a.call(n[0]), t.isFunction(e) && e()
                    }

                    var n = t(this), a = i.complete, r = i.mode;
                    (n.is(":hidden") ? "hide" === r : "show" === r) ? (n[r](), s()) : o.call(n[0], i, s)
                }

                var i = s.apply(this, arguments), n = i.mode, a = i.queue, o = t.effects.effect[i.effect];
                return t.fx.off || !o ? n ? this[n](i.duration, i.complete) : this.each(function () {
                    i.complete && i.complete.call(this)
                }) : a === !1 ? this.each(e) : this.queue(a || "fx", e)
            }, show: function (t) {
                return function (e) {
                    if (n(e))return t.apply(this, arguments);
                    var i = s.apply(this, arguments);
                    return i.mode = "show", this.effect.call(this, i)
                }
            }(t.fn.show), hide: function (t) {
                return function (e) {
                    if (n(e))return t.apply(this, arguments);
                    var i = s.apply(this, arguments);
                    return i.mode = "hide", this.effect.call(this, i)
                }
            }(t.fn.hide), toggle: function (t) {
                return function (e) {
                    if (n(e) || "boolean" == typeof e)return t.apply(this, arguments);
                    var i = s.apply(this, arguments);
                    return i.mode = "toggle", this.effect.call(this, i)
                }
            }(t.fn.toggle), cssUnit: function (e) {
                var i = this.css(e), s = [];
                return t.each(["em", "px", "%", "pt"], function (t, e) {
                    i.indexOf(e) > 0 && (s = [parseFloat(i), e])
                }), s
            }
        })
    }(), function () {
        var e = {};
        t.each(["Quad", "Cubic", "Quart", "Quint", "Expo"], function (t, i) {
            e[i] = function (e) {
                return Math.pow(e, t + 2)
            }
        }), t.extend(e, {
            Sine: function (t) {
                return 1 - Math.cos(t * Math.PI / 2)
            }, Circ: function (t) {
                return 1 - Math.sqrt(1 - t * t)
            }, Elastic: function (t) {
                return 0 === t || 1 === t ? t : -Math.pow(2, 8 * (t - 1)) * Math.sin((80 * (t - 1) - 7.5) * Math.PI / 15)
            }, Back: function (t) {
                return t * t * (3 * t - 2)
            }, Bounce: function (t) {
                for (var e, i = 4; ((e = Math.pow(2, --i)) - 1) / 11 > t;);
                return 1 / Math.pow(4, 3 - i) - 7.5625 * Math.pow((3 * e - 2) / 22 - t, 2)
            }
        }), t.each(e, function (e, i) {
            t.easing["easeIn" + e] = i, t.easing["easeOut" + e] = function (t) {
                return 1 - i(1 - t)
            }, t.easing["easeInOut" + e] = function (t) {
                return .5 > t ? i(2 * t) / 2 : 1 - i(-2 * t + 2) / 2
            }
        })
    }()
})(jQuery);
(function (t) {
    var e = /up|down|vertical/, i = /up|left|vertical|horizontal/;
    t.effects.effect.blind = function (s, n) {
        var a, o, r, l = t(this), h = ["position", "top", "bottom", "left", "right", "height", "width"], c = t.effects.setMode(l, s.mode || "hide"), u = s.direction || "up", d = e.test(u), p = d ? "height" : "width", f = d ? "top" : "left", g = i.test(u), m = {}, v = "show" === c;
        l.parent().is(".ui-effects-wrapper") ? t.effects.save(l.parent(), h) : t.effects.save(l, h), l.show(), a = t.effects.createWrapper(l).css({overflow: "hidden"}), o = a[p](), r = parseFloat(a.css(f)) || 0, m[p] = v ? o : 0, g || (l.css(d ? "bottom" : "right", 0).css(d ? "top" : "left", "auto").css({position: "absolute"}), m[f] = v ? r : o + r), v && (a.css(p, 0), g || a.css(f, r + o)), a.animate(m, {
            duration: s.duration,
            easing: s.easing,
            queue: !1,
            complete: function () {
                "hide" === c && l.hide(), t.effects.restore(l, h), t.effects.removeWrapper(l), n()
            }
        })
    }
})(jQuery);
(function (t) {
    t.effects.effect.bounce = function (e, i) {
        var s, n, a, o = t(this), r = ["position", "top", "bottom", "left", "right", "height", "width"], l = t.effects.setMode(o, e.mode || "effect"), h = "hide" === l, c = "show" === l, u = e.direction || "up", d = e.distance, p = e.times || 5, f = 2 * p + (c || h ? 1 : 0), g = e.duration / f, m = e.easing, v = "up" === u || "down" === u ? "top" : "left", _ = "up" === u || "left" === u, b = o.queue(), y = b.length;
        for ((c || h) && r.push("opacity"), t.effects.save(o, r), o.show(), t.effects.createWrapper(o), d || (d = o["top" === v ? "outerHeight" : "outerWidth"]() / 3), c && (a = {opacity: 1}, a[v] = 0, o.css("opacity", 0).css(v, _ ? 2 * -d : 2 * d).animate(a, g, m)), h && (d /= Math.pow(2, p - 1)), a = {}, a[v] = 0, s = 0; p > s; s++)n = {}, n[v] = (_ ? "-=" : "+=") + d, o.animate(n, g, m).animate(a, g, m), d = h ? 2 * d : d / 2;
        h && (n = {opacity: 0}, n[v] = (_ ? "-=" : "+=") + d, o.animate(n, g, m)), o.queue(function () {
            h && o.hide(), t.effects.restore(o, r), t.effects.removeWrapper(o), i()
        }), y > 1 && b.splice.apply(b, [1, 0].concat(b.splice(y, f + 1))), o.dequeue()
    }
})(jQuery);
(function (t) {
    t.effects.effect.clip = function (e, i) {
        var s, n, a, o = t(this), r = ["position", "top", "bottom", "left", "right", "height", "width"], l = t.effects.setMode(o, e.mode || "hide"), h = "show" === l, c = e.direction || "vertical", u = "vertical" === c, d = u ? "height" : "width", p = u ? "top" : "left", f = {};
        t.effects.save(o, r), o.show(), s = t.effects.createWrapper(o).css({overflow: "hidden"}), n = "IMG" === o[0].tagName ? s : o, a = n[d](), h && (n.css(d, 0), n.css(p, a / 2)), f[d] = h ? a : 0, f[p] = h ? 0 : a / 2, n.animate(f, {
            queue: !1,
            duration: e.duration,
            easing: e.easing,
            complete: function () {
                h || o.hide(), t.effects.restore(o, r), t.effects.removeWrapper(o), i()
            }
        })
    }
})(jQuery);
(function (t) {
    t.effects.effect.drop = function (e, i) {
        var s, n = t(this), a = ["position", "top", "bottom", "left", "right", "opacity", "height", "width"], o = t.effects.setMode(n, e.mode || "hide"), r = "show" === o, l = e.direction || "left", h = "up" === l || "down" === l ? "top" : "left", c = "up" === l || "left" === l ? "pos" : "neg", u = {opacity: r ? 1 : 0};
        t.effects.save(n, a), n.show(), t.effects.createWrapper(n), s = e.distance || n["top" === h ? "outerHeight" : "outerWidth"](!0) / 2, r && n.css("opacity", 0).css(h, "pos" === c ? -s : s), u[h] = (r ? "pos" === c ? "+=" : "-=" : "pos" === c ? "-=" : "+=") + s, n.animate(u, {
            queue: !1,
            duration: e.duration,
            easing: e.easing,
            complete: function () {
                "hide" === o && n.hide(), t.effects.restore(n, a), t.effects.removeWrapper(n), i()
            }
        })
    }
})(jQuery);
(function (t) {
    t.effects.effect.explode = function (e, i) {
        function s() {
            b.push(this), b.length === u * d && n()
        }

        function n() {
            p.css({visibility: "visible"}), t(b).remove(), g || p.hide(), i()
        }

        var a, o, r, l, h, c, u = e.pieces ? Math.round(Math.sqrt(e.pieces)) : 3, d = u, p = t(this), f = t.effects.setMode(p, e.mode || "hide"), g = "show" === f, m = p.show().css("visibility", "hidden").offset(), v = Math.ceil(p.outerWidth() / d), _ = Math.ceil(p.outerHeight() / u), b = [];
        for (a = 0; u > a; a++)for (l = m.top + a * _, c = a - (u - 1) / 2, o = 0; d > o; o++)r = m.left + o * v, h = o - (d - 1) / 2, p.clone().appendTo("body").wrap("<div></div>").css({
            position: "absolute",
            visibility: "visible",
            left: -o * v,
            top: -a * _
        }).parent().addClass("ui-effects-explode").css({
            position: "absolute",
            overflow: "hidden",
            width: v,
            height: _,
            left: r + (g ? h * v : 0),
            top: l + (g ? c * _ : 0),
            opacity: g ? 0 : 1
        }).animate({
            left: r + (g ? 0 : h * v),
            top: l + (g ? 0 : c * _),
            opacity: g ? 1 : 0
        }, e.duration || 500, e.easing, s)
    }
})(jQuery);
(function (t) {
    t.effects.effect.fade = function (e, i) {
        var s = t(this), n = t.effects.setMode(s, e.mode || "toggle");
        s.animate({opacity: n}, {queue: !1, duration: e.duration, easing: e.easing, complete: i})
    }
})(jQuery);
(function (t) {
    t.effects.effect.fold = function (e, i) {
        var s, n, a = t(this), o = ["position", "top", "bottom", "left", "right", "height", "width"], r = t.effects.setMode(a, e.mode || "hide"), l = "show" === r, h = "hide" === r, c = e.size || 15, u = /([0-9]+)%/.exec(c), d = !!e.horizFirst, p = l !== d, f = p ? ["width", "height"] : ["height", "width"], g = e.duration / 2, m = {}, v = {};
        t.effects.save(a, o), a.show(), s = t.effects.createWrapper(a).css({overflow: "hidden"}), n = p ? [s.width(), s.height()] : [s.height(), s.width()], u && (c = parseInt(u[1], 10) / 100 * n[h ? 0 : 1]), l && s.css(d ? {
            height: 0,
            width: c
        } : {
            height: c,
            width: 0
        }), m[f[0]] = l ? n[0] : c, v[f[1]] = l ? n[1] : 0, s.animate(m, g, e.easing).animate(v, g, e.easing, function () {
            h && a.hide(), t.effects.restore(a, o), t.effects.removeWrapper(a), i()
        })
    }
})(jQuery);
(function (t) {
    t.effects.effect.highlight = function (e, i) {
        var s = t(this), n = ["backgroundImage", "backgroundColor", "opacity"], a = t.effects.setMode(s, e.mode || "show"), o = {backgroundColor: s.css("backgroundColor")};
        "hide" === a && (o.opacity = 0), t.effects.save(s, n), s.show().css({
            backgroundImage: "none",
            backgroundColor: e.color || "#ffff99"
        }).animate(o, {
            queue: !1, duration: e.duration, easing: e.easing, complete: function () {
                "hide" === a && s.hide(), t.effects.restore(s, n), i()
            }
        })
    }
})(jQuery);
(function (t) {
    t.effects.effect.pulsate = function (e, i) {
        var s, n = t(this), a = t.effects.setMode(n, e.mode || "show"), o = "show" === a, r = "hide" === a, l = o || "hide" === a, h = 2 * (e.times || 5) + (l ? 1 : 0), c = e.duration / h, u = 0, d = n.queue(), p = d.length;
        for ((o || !n.is(":visible")) && (n.css("opacity", 0).show(), u = 1), s = 1; h > s; s++)n.animate({opacity: u}, c, e.easing), u = 1 - u;
        n.animate({opacity: u}, c, e.easing), n.queue(function () {
            r && n.hide(), i()
        }), p > 1 && d.splice.apply(d, [1, 0].concat(d.splice(p, h + 1))), n.dequeue()
    }
})(jQuery);
(function (t) {
    t.effects.effect.puff = function (e, i) {
        var s = t(this), n = t.effects.setMode(s, e.mode || "hide"), a = "hide" === n, o = parseInt(e.percent, 10) || 150, r = o / 100, l = {
            height: s.height(),
            width: s.width(),
            outerHeight: s.outerHeight(),
            outerWidth: s.outerWidth()
        };
        t.extend(e, {
            effect: "scale",
            queue: !1,
            fade: !0,
            mode: n,
            complete: i,
            percent: a ? o : 100,
            from: a ? l : {
                height: l.height * r,
                width: l.width * r,
                outerHeight: l.outerHeight * r,
                outerWidth: l.outerWidth * r
            }
        }), s.effect(e)
    }, t.effects.effect.scale = function (e, i) {
        var s = t(this), n = t.extend(!0, {}, e), a = t.effects.setMode(s, e.mode || "effect"), o = parseInt(e.percent, 10) || (0 === parseInt(e.percent, 10) ? 0 : "hide" === a ? 0 : 100), r = e.direction || "both", l = e.origin, h = {
            height: s.height(),
            width: s.width(),
            outerHeight: s.outerHeight(),
            outerWidth: s.outerWidth()
        }, c = {y: "horizontal" !== r ? o / 100 : 1, x: "vertical" !== r ? o / 100 : 1};
        n.effect = "size", n.queue = !1, n.complete = i, "effect" !== a && (n.origin = l || ["middle", "center"], n.restore = !0), n.from = e.from || ("show" === a ? {
            height: 0,
            width: 0,
            outerHeight: 0,
            outerWidth: 0
        } : h), n.to = {
            height: h.height * c.y,
            width: h.width * c.x,
            outerHeight: h.outerHeight * c.y,
            outerWidth: h.outerWidth * c.x
        }, n.fade && ("show" === a && (n.from.opacity = 0, n.to.opacity = 1), "hide" === a && (n.from.opacity = 1, n.to.opacity = 0)), s.effect(n)
    }, t.effects.effect.size = function (e, i) {
        var s, n, a, o = t(this), r = ["position", "top", "bottom", "left", "right", "width", "height", "overflow", "opacity"], l = ["position", "top", "bottom", "left", "right", "overflow", "opacity"], h = ["width", "height", "overflow"], c = ["fontSize"], u = ["borderTopWidth", "borderBottomWidth", "paddingTop", "paddingBottom"], d = ["borderLeftWidth", "borderRightWidth", "paddingLeft", "paddingRight"], p = t.effects.setMode(o, e.mode || "effect"), f = e.restore || "effect" !== p, g = e.scale || "both", m = e.origin || ["middle", "center"], v = o.css("position"), _ = f ? r : l, b = {
            height: 0,
            width: 0,
            outerHeight: 0,
            outerWidth: 0
        };
        "show" === p && o.show(), s = {
            height: o.height(),
            width: o.width(),
            outerHeight: o.outerHeight(),
            outerWidth: o.outerWidth()
        }, "toggle" === e.mode && "show" === p ? (o.from = e.to || b, o.to = e.from || s) : (o.from = e.from || ("show" === p ? b : s), o.to = e.to || ("hide" === p ? b : s)), a = {
            from: {
                y: o.from.height / s.height,
                x: o.from.width / s.width
            }, to: {y: o.to.height / s.height, x: o.to.width / s.width}
        }, ("box" === g || "both" === g) && (a.from.y !== a.to.y && (_ = _.concat(u), o.from = t.effects.setTransition(o, u, a.from.y, o.from), o.to = t.effects.setTransition(o, u, a.to.y, o.to)), a.from.x !== a.to.x && (_ = _.concat(d), o.from = t.effects.setTransition(o, d, a.from.x, o.from), o.to = t.effects.setTransition(o, d, a.to.x, o.to))), ("content" === g || "both" === g) && a.from.y !== a.to.y && (_ = _.concat(c).concat(h), o.from = t.effects.setTransition(o, c, a.from.y, o.from), o.to = t.effects.setTransition(o, c, a.to.y, o.to)), t.effects.save(o, _), o.show(), t.effects.createWrapper(o), o.css("overflow", "hidden").css(o.from), m && (n = t.effects.getBaseline(m, s), o.from.top = (s.outerHeight - o.outerHeight()) * n.y, o.from.left = (s.outerWidth - o.outerWidth()) * n.x, o.to.top = (s.outerHeight - o.to.outerHeight) * n.y, o.to.left = (s.outerWidth - o.to.outerWidth) * n.x), o.css(o.from), ("content" === g || "both" === g) && (u = u.concat(["marginTop", "marginBottom"]).concat(c), d = d.concat(["marginLeft", "marginRight"]), h = r.concat(u).concat(d), o.find("*[width]").each(function () {
            var i = t(this), s = {
                height: i.height(),
                width: i.width(),
                outerHeight: i.outerHeight(),
                outerWidth: i.outerWidth()
            };
            f && t.effects.save(i, h), i.from = {
                height: s.height * a.from.y,
                width: s.width * a.from.x,
                outerHeight: s.outerHeight * a.from.y,
                outerWidth: s.outerWidth * a.from.x
            }, i.to = {
                height: s.height * a.to.y,
                width: s.width * a.to.x,
                outerHeight: s.height * a.to.y,
                outerWidth: s.width * a.to.x
            }, a.from.y !== a.to.y && (i.from = t.effects.setTransition(i, u, a.from.y, i.from), i.to = t.effects.setTransition(i, u, a.to.y, i.to)), a.from.x !== a.to.x && (i.from = t.effects.setTransition(i, d, a.from.x, i.from), i.to = t.effects.setTransition(i, d, a.to.x, i.to)), i.css(i.from), i.animate(i.to, e.duration, e.easing, function () {
                f && t.effects.restore(i, h)
            })
        })), o.animate(o.to, {
            queue: !1, duration: e.duration, easing: e.easing, complete: function () {
                0 === o.to.opacity && o.css("opacity", o.from.opacity), "hide" === p && o.hide(), t.effects.restore(o, _), f || ("static" === v ? o.css({
                    position: "relative",
                    top: o.to.top,
                    left: o.to.left
                }) : t.each(["top", "left"], function (t, e) {
                    o.css(e, function (e, i) {
                        var s = parseInt(i, 10), n = t ? o.to.left : o.to.top;
                        return "auto" === i ? n + "px" : s + n + "px"
                    })
                })), t.effects.removeWrapper(o), i()
            }
        })
    }
})(jQuery);
(function (t) {
    t.effects.effect.shake = function (e, i) {
        var s, n = t(this), a = ["position", "top", "bottom", "left", "right", "height", "width"], o = t.effects.setMode(n, e.mode || "effect"), r = e.direction || "left", l = e.distance || 20, h = e.times || 3, c = 2 * h + 1, u = Math.round(e.duration / c), d = "up" === r || "down" === r ? "top" : "left", p = "up" === r || "left" === r, f = {}, g = {}, m = {}, v = n.queue(), _ = v.length;
        for (t.effects.save(n, a), n.show(), t.effects.createWrapper(n), f[d] = (p ? "-=" : "+=") + l, g[d] = (p ? "+=" : "-=") + 2 * l, m[d] = (p ? "-=" : "+=") + 2 * l, n.animate(f, u, e.easing), s = 1; h > s; s++)n.animate(g, u, e.easing).animate(m, u, e.easing);
        n.animate(g, u, e.easing).animate(f, u / 2, e.easing).queue(function () {
            "hide" === o && n.hide(), t.effects.restore(n, a), t.effects.removeWrapper(n), i()
        }), _ > 1 && v.splice.apply(v, [1, 0].concat(v.splice(_, c + 1))), n.dequeue()
    }
})(jQuery);
(function (t) {
    t.effects.effect.slide = function (e, i) {
        var s, n = t(this), a = ["position", "top", "bottom", "left", "right", "width", "height"], o = t.effects.setMode(n, e.mode || "show"), r = "show" === o, l = e.direction || "left", h = "up" === l || "down" === l ? "top" : "left", c = "up" === l || "left" === l, u = {};
        t.effects.save(n, a), n.show(), s = e.distance || n["top" === h ? "outerHeight" : "outerWidth"](!0), t.effects.createWrapper(n).css({overflow: "hidden"}), r && n.css(h, c ? isNaN(s) ? "-" + s : -s : s), u[h] = (r ? c ? "+=" : "-=" : c ? "-=" : "+=") + s, n.animate(u, {
            queue: !1,
            duration: e.duration,
            easing: e.easing,
            complete: function () {
                "hide" === o && n.hide(), t.effects.restore(n, a), t.effects.removeWrapper(n), i()
            }
        })
    }
})(jQuery);
(function (t) {
    t.effects.effect.transfer = function (e, i) {
        var s = t(this), n = t(e.to), a = "fixed" === n.css("position"), o = t("body"), r = a ? o.scrollTop() : 0, l = a ? o.scrollLeft() : 0, h = n.offset(), c = {
            top: h.top - r,
            left: h.left - l,
            height: n.innerHeight(),
            width: n.innerWidth()
        }, u = s.offset(), d = t("<div class='ui-effects-transfer'></div>").appendTo(document.body).addClass(e.className).css({
            top: u.top - r,
            left: u.left - l,
            height: s.innerHeight(),
            width: s.innerWidth(),
            position: a ? "fixed" : "absolute"
        }).animate(c, e.duration, e.easing, function () {
            d.remove(), i()
        })
    }
})(jQuery);
/**
 * jscolor, JavaScript Color Picker
 *
 * @version 1.4.2
 * @license GNU Lesser General Public License, http://www.gnu.org/copyleft/lesser.html
 * @author  Jan Odvarko, http://odvarko.cz
 * @created 2008-06-15
 * @updated 2013-11-25
 * @link    http://jscolor.com
 */


var jscolor = {


    dir: '', // location of jscolor directory (leave empty to autodetect)
    bindClass: 'color', // class name
    binding: true, // automatic binding via <input class="...">
    preloading: true, // use image preloading?


    install: function () {
        jscolor.addEvent(window, 'load', jscolor.init);
    },


    init: function () {
        if (jscolor.binding) {
            jscolor.bind();
        }
        if (jscolor.preloading) {
            jscolor.preload();
        }
    },


    getDir: function () {
        if (!jscolor.dir) {
            var detected = jscolor.detectDir();
            jscolor.dir = detected !== false ? detected : 'jscolor/';
        }
        return jscolor.dir;
    },


    detectDir: function () {
        var base = location.href;

        var e = document.getElementsByTagName('base');
        for (var i = 0; i < e.length; i += 1) {
            if (e[i].href) {
                base = e[i].href;
            }
        }

        var e = document.getElementsByTagName('script');
        for (var i = 0; i < e.length; i += 1) {
            if (e[i].src && /(^|\/)jscolor\.js([?#].*)?$/i.test(e[i].src)) {
                var src = new jscolor.URI(e[i].src);
                var srcAbs = src.toAbsolute(base);
                srcAbs.path = srcAbs.path.replace(/[^\/]+$/, ''); // remove filename
                srcAbs.query = null;
                srcAbs.fragment = null;
                return srcAbs.toString();
            }
        }
        return false;
    },


    bind: function () {
        var matchClass = new RegExp('(^|\\s)(' + jscolor.bindClass + ')\\s*(\\{[^}]*\\})?', 'i');
        var e = document.getElementsByTagName('input');
        for (var i = 0; i < e.length; i += 1) {
            var m;
            if (!e[i].color && e[i].className && (m = e[i].className.match(matchClass))) {
                var prop = {};
                if (m[3]) {
                    try {
                        prop = (new Function('return (' + m[3] + ')'))();
                    } catch (eInvalidProp) {
                    }
                }
                e[i].color = new jscolor.color(e[i], prop);
            }
        }
    },


    preload: function () {
        for (var fn in jscolor.imgRequire) {
            if (jscolor.imgRequire.hasOwnProperty(fn)) {
                jscolor.loadImage(fn);
            }
        }
    },


    images: {
        pad: [181, 101],
        sld: [16, 101],
        cross: [15, 15],
        arrow: [7, 11]
    },


    imgRequire: {},
    imgLoaded: {},


    requireImage: function (filename) {
        jscolor.imgRequire[filename] = true;
    },


    loadImage: function (filename) {
        if (!jscolor.imgLoaded[filename]) {
            jscolor.imgLoaded[filename] = new Image();
            jscolor.imgLoaded[filename].src = jscolor.getDir() + filename;
        }
    },


    fetchElement: function (mixed) {
        return typeof mixed === 'string' ? document.getElementById(mixed) : mixed;
    },


    addEvent: function (el, evnt, func) {
        if (el.addEventListener) {
            el.addEventListener(evnt, func, false);
        } else if (el.attachEvent) {
            el.attachEvent('on' + evnt, func);
        }
    },


    fireEvent: function (el, evnt) {
        if (!el) {
            return;
        }
        if (document.createEvent) {
            var ev = document.createEvent('HTMLEvents');
            ev.initEvent(evnt, true, true);
            el.dispatchEvent(ev);
        } else if (document.createEventObject) {
            var ev = document.createEventObject();
            el.fireEvent('on' + evnt, ev);
        } else if (el['on' + evnt]) { // alternatively use the traditional event model (IE5)
            el['on' + evnt]();
        }
    },


    getElementPos: function (e) {
        var e1 = e, e2 = e;
        var x = 0, y = 0;
        if (e1.offsetParent) {
            do {
                x += e1.offsetLeft;
                y += e1.offsetTop;
            } while (e1 = e1.offsetParent);
        }
        while ((e2 = e2.parentNode) && e2.nodeName.toUpperCase() !== 'BODY') {
            x -= e2.scrollLeft;
            y -= e2.scrollTop;
        }
        return [x, y];
    },


    getElementSize: function (e) {
        return [e.offsetWidth, e.offsetHeight];
    },


    getRelMousePos: function (e) {
        var x = 0, y = 0;
        if (!e) {
            e = window.event;
        }
        if (typeof e.offsetX === 'number') {
            x = e.offsetX;
            y = e.offsetY;
        } else if (typeof e.layerX === 'number') {
            x = e.layerX;
            y = e.layerY;
        }
        return {x: x, y: y};
    },


    getViewPos: function () {
        if (typeof window.pageYOffset === 'number') {
            return [window.pageXOffset, window.pageYOffset];
        } else if (document.body && (document.body.scrollLeft || document.body.scrollTop)) {
            return [document.body.scrollLeft, document.body.scrollTop];
        } else if (document.documentElement && (document.documentElement.scrollLeft || document.documentElement.scrollTop)) {
            return [document.documentElement.scrollLeft, document.documentElement.scrollTop];
        } else {
            return [0, 0];
        }
    },


    getViewSize: function () {
        if (typeof window.innerWidth === 'number') {
            return [window.innerWidth, window.innerHeight];
        } else if (document.body && (document.body.clientWidth || document.body.clientHeight)) {
            return [document.body.clientWidth, document.body.clientHeight];
        } else if (document.documentElement && (document.documentElement.clientWidth || document.documentElement.clientHeight)) {
            return [document.documentElement.clientWidth, document.documentElement.clientHeight];
        } else {
            return [0, 0];
        }
    },


    URI: function (uri) { // See RFC3986

        this.scheme = null;
        this.authority = null;
        this.path = '';
        this.query = null;
        this.fragment = null;

        this.parse = function (uri) {
            var m = uri.match(/^(([A-Za-z][0-9A-Za-z+.-]*)(:))?((\/\/)([^\/?#]*))?([^?#]*)((\?)([^#]*))?((#)(.*))?/);
            this.scheme = m[3] ? m[2] : null;
            this.authority = m[5] ? m[6] : null;
            this.path = m[7];
            this.query = m[9] ? m[10] : null;
            this.fragment = m[12] ? m[13] : null;
            return this;
        };

        this.toString = function () {
            var result = '';
            if (this.scheme !== null) {
                result = result + this.scheme + ':';
            }
            if (this.authority !== null) {
                result = result + '//' + this.authority;
            }
            if (this.path !== null) {
                result = result + this.path;
            }
            if (this.query !== null) {
                result = result + '?' + this.query;
            }
            if (this.fragment !== null) {
                result = result + '#' + this.fragment;
            }
            return result;
        };

        this.toAbsolute = function (base) {
            var base = new jscolor.URI(base);
            var r = this;
            var t = new jscolor.URI;

            if (base.scheme === null) {
                return false;
            }

            if (r.scheme !== null && r.scheme.toLowerCase() === base.scheme.toLowerCase()) {
                r.scheme = null;
            }

            if (r.scheme !== null) {
                t.scheme = r.scheme;
                t.authority = r.authority;
                t.path = removeDotSegments(r.path);
                t.query = r.query;
            } else {
                if (r.authority !== null) {
                    t.authority = r.authority;
                    t.path = removeDotSegments(r.path);
                    t.query = r.query;
                } else {
                    if (r.path === '') {
                        t.path = base.path;
                        if (r.query !== null) {
                            t.query = r.query;
                        } else {
                            t.query = base.query;
                        }
                    } else {
                        if (r.path.substr(0, 1) === '/') {
                            t.path = removeDotSegments(r.path);
                        } else {
                            if (base.authority !== null && base.path === '') {
                                t.path = '/' + r.path;
                            } else {
                                t.path = base.path.replace(/[^\/]+$/, '') + r.path;
                            }
                            t.path = removeDotSegments(t.path);
                        }
                        t.query = r.query;
                    }
                    t.authority = base.authority;
                }
                t.scheme = base.scheme;
            }
            t.fragment = r.fragment;

            return t;
        };

        function removeDotSegments(path) {
            var out = '';
            while (path) {
                if (path.substr(0, 3) === '../' || path.substr(0, 2) === './') {
                    path = path.replace(/^\.+/, '').substr(1);
                } else if (path.substr(0, 3) === '/./' || path === '/.') {
                    path = '/' + path.substr(3);
                } else if (path.substr(0, 4) === '/../' || path === '/..') {
                    path = '/' + path.substr(4);
                    out = out.replace(/\/?[^\/]*$/, '');
                } else if (path === '.' || path === '..') {
                    path = '';
                } else {
                    var rm = path.match(/^\/?[^\/]*/)[0];
                    path = path.substr(rm.length);
                    out = out + rm;
                }
            }
            return out;
        }

        if (uri) {
            this.parse(uri);
        }

    },


    //
    // Usage example:
    // var myColor = new jscolor.color(myInputElement)
    //

    color: function (target, prop) {


        this.required = true; // refuse empty values?
        this.adjust = true; // adjust value to uniform notation?
        this.hash = false; // prefix color with # symbol?
        this.caps = true; // uppercase?
        this.slider = true; // show the value/saturation slider?
        this.valueElement = target; // value holder
        this.styleElement = target; // where to reflect current color
        this.onImmediateChange = null; // onchange callback (can be either string or function)
        this.hsv = [0, 0, 1]; // read-only  0-6, 0-1, 0-1
        this.rgb = [1, 1, 1]; // read-only  0-1, 0-1, 0-1
        this.minH = 0; // read-only  0-6
        this.maxH = 6; // read-only  0-6
        this.minS = 0; // read-only  0-1
        this.maxS = 1; // read-only  0-1
        this.minV = 0; // read-only  0-1
        this.maxV = 1; // read-only  0-1

        this.pickerOnfocus = true; // display picker on focus?
        this.pickerMode = 'HSV'; // HSV | HVS
        this.pickerPosition = 'bottom'; // left | right | top | bottom
        this.pickerSmartPosition = true; // automatically adjust picker position when necessary
        this.pickerButtonHeight = 20; // px
        this.pickerClosable = false;
        this.pickerCloseText = 'Close';
        this.pickerButtonColor = 'ButtonText'; // px
        this.pickerFace = 10; // px
        this.pickerFaceColor = 'ThreeDFace'; // CSS color
        this.pickerBorder = 1; // px
        this.pickerBorderColor = 'ThreeDHighlight ThreeDShadow ThreeDShadow ThreeDHighlight'; // CSS color
        this.pickerInset = 1; // px
        this.pickerInsetColor = 'ThreeDShadow ThreeDHighlight ThreeDHighlight ThreeDShadow'; // CSS color
        this.pickerZIndex = 10000;


        for (var p in prop) {
            if (prop.hasOwnProperty(p)) {
                this[p] = prop[p];
            }
        }


        this.hidePicker = function () {
            if (isPickerOwner()) {
                removePicker();
            }
        };


        this.showPicker = function () {
            if (!isPickerOwner()) {
                var tp = jscolor.getElementPos(target); // target pos
                var ts = jscolor.getElementSize(target); // target size
                var vp = jscolor.getViewPos(); // view pos
                var vs = jscolor.getViewSize(); // view size
                var ps = getPickerDims(this); // picker size
                var a, b, c;
                switch (this.pickerPosition.toLowerCase()) {
                    case 'left':
                        a = 1;
                        b = 0;
                        c = -1;
                        break;
                    case 'right':
                        a = 1;
                        b = 0;
                        c = 1;
                        break;
                    case 'top':
                        a = 0;
                        b = 1;
                        c = -1;
                        break;
                    default:
                        a = 0;
                        b = 1;
                        c = 1;
                        break;
                }
                var l = (ts[b] + ps[b]) / 2;

                // picker pos
                if (!this.pickerSmartPosition) {
                    var pp = [
                        tp[a],
                        tp[b] + ts[b] - l + l * c
                    ];
                } else {
                    var pp = [
                        -vp[a] + tp[a] + ps[a] > vs[a] ?
                            (-vp[a] + tp[a] + ts[a] / 2 > vs[a] / 2 && tp[a] + ts[a] - ps[a] >= 0 ? tp[a] + ts[a] - ps[a] : tp[a]) :
                            tp[a],
                        -vp[b] + tp[b] + ts[b] + ps[b] - l + l * c > vs[b] ?
                            (-vp[b] + tp[b] + ts[b] / 2 > vs[b] / 2 && tp[b] + ts[b] - l - l * c >= 0 ? tp[b] + ts[b] - l - l * c : tp[b] + ts[b] - l + l * c) :
                            (tp[b] + ts[b] - l + l * c >= 0 ? tp[b] + ts[b] - l + l * c : tp[b] + ts[b] - l - l * c)
                    ];
                }
                drawPicker(pp[a], pp[b]);
            }
        };


        this.importColor = function () {
            if (!valueElement) {
                this.exportColor();
            } else {
                if (!this.adjust) {
                    if (!this.fromString(valueElement.value, leaveValue)) {
                        styleElement.style.backgroundImage = styleElement.jscStyle.backgroundImage;
                        styleElement.style.backgroundColor = styleElement.jscStyle.backgroundColor;
                        styleElement.style.color = styleElement.jscStyle.color;
                        this.exportColor(leaveValue | leaveStyle);
                    }
                } else if (!this.required && /^\s*$/.test(valueElement.value)) {
                    valueElement.value = '';
                    styleElement.style.backgroundImage = styleElement.jscStyle.backgroundImage;
                    styleElement.style.backgroundColor = styleElement.jscStyle.backgroundColor;
                    styleElement.style.color = styleElement.jscStyle.color;
                    this.exportColor(leaveValue | leaveStyle);

                } else if (this.fromString(valueElement.value)) {
                    // OK
                } else {
                    this.exportColor();
                }
            }
        };


        this.exportColor = function (flags) {
            if (!(flags & leaveValue) && valueElement) {
                var value = this.toString();
                if (this.caps) {
                    value = value.toUpperCase();
                }
                if (this.hash) {
                    value = '#' + value;
                }
                valueElement.value = value;
            }
            if (!(flags & leaveStyle) && styleElement) {
                styleElement.style.backgroundImage = "none";
                styleElement.style.backgroundColor =
                    '#' + this.toString();
                styleElement.style.color =
                    0.213 * this.rgb[0] +
                    0.715 * this.rgb[1] +
                    0.072 * this.rgb[2]
                    < 0.5 ? '#FFF' : '#000';
            }
            if (!(flags & leavePad) && isPickerOwner()) {
                redrawPad();
            }
            if (!(flags & leaveSld) && isPickerOwner()) {
                redrawSld();
            }
        };


        this.fromHSV = function (h, s, v, flags) { // null = don't change
            if (h !== null) {
                h = Math.max(0.0, this.minH, Math.min(6.0, this.maxH, h));
            }
            if (s !== null) {
                s = Math.max(0.0, this.minS, Math.min(1.0, this.maxS, s));
            }
            if (v !== null) {
                v = Math.max(0.0, this.minV, Math.min(1.0, this.maxV, v));
            }

            this.rgb = HSV_RGB(
                h === null ? this.hsv[0] : (this.hsv[0] = h),
                s === null ? this.hsv[1] : (this.hsv[1] = s),
                v === null ? this.hsv[2] : (this.hsv[2] = v)
            );

            this.exportColor(flags);
        };


        this.fromRGB = function (r, g, b, flags) { // null = don't change
            if (r !== null) {
                r = Math.max(0.0, Math.min(1.0, r));
            }
            if (g !== null) {
                g = Math.max(0.0, Math.min(1.0, g));
            }
            if (b !== null) {
                b = Math.max(0.0, Math.min(1.0, b));
            }

            var hsv = RGB_HSV(
                r === null ? this.rgb[0] : r,
                g === null ? this.rgb[1] : g,
                b === null ? this.rgb[2] : b
            );
            if (hsv[0] !== null) {
                this.hsv[0] = Math.max(0.0, this.minH, Math.min(6.0, this.maxH, hsv[0]));
            }
            if (hsv[2] !== 0) {
                this.hsv[1] = hsv[1] === null ? null : Math.max(0.0, this.minS, Math.min(1.0, this.maxS, hsv[1]));
            }
            this.hsv[2] = hsv[2] === null ? null : Math.max(0.0, this.minV, Math.min(1.0, this.maxV, hsv[2]));

            // update RGB according to final HSV, as some values might be trimmed
            var rgb = HSV_RGB(this.hsv[0], this.hsv[1], this.hsv[2]);
            this.rgb[0] = rgb[0];
            this.rgb[1] = rgb[1];
            this.rgb[2] = rgb[2];

            this.exportColor(flags);
        };


        this.fromString = function (hex, flags) {
            var m = hex.match(/^\W*([0-9A-F]{3}([0-9A-F]{3})?)\W*$/i);
            if (!m) {
                return false;
            } else {
                if (m[1].length === 6) { // 6-char notation
                    this.fromRGB(
                        parseInt(m[1].substr(0, 2), 16) / 255,
                        parseInt(m[1].substr(2, 2), 16) / 255,
                        parseInt(m[1].substr(4, 2), 16) / 255,
                        flags
                    );
                } else { // 3-char notation
                    this.fromRGB(
                        parseInt(m[1].charAt(0) + m[1].charAt(0), 16) / 255,
                        parseInt(m[1].charAt(1) + m[1].charAt(1), 16) / 255,
                        parseInt(m[1].charAt(2) + m[1].charAt(2), 16) / 255,
                        flags
                    );
                }
                return true;
            }
        };


        this.toString = function () {
            return (
            (0x100 | Math.round(255 * this.rgb[0])).toString(16).substr(1) +
            (0x100 | Math.round(255 * this.rgb[1])).toString(16).substr(1) +
            (0x100 | Math.round(255 * this.rgb[2])).toString(16).substr(1)
            );
        };


        function RGB_HSV(r, g, b) {
            var n = Math.min(Math.min(r, g), b);
            var v = Math.max(Math.max(r, g), b);
            var m = v - n;
            if (m === 0) {
                return [null, 0, v];
            }
            var h = r === n ? 3 + (b - g) / m : (g === n ? 5 + (r - b) / m : 1 + (g - r) / m);
            return [h === 6 ? 0 : h, m / v, v];
        }


        function HSV_RGB(h, s, v) {
            if (h === null) {
                return [v, v, v];
            }
            var i = Math.floor(h);
            var f = i % 2 ? h - i : 1 - (h - i);
            var m = v * (1 - s);
            var n = v * (1 - s * f);
            switch (i) {
                case 6:
                case 0:
                    return [v, n, m];
                case 1:
                    return [n, v, m];
                case 2:
                    return [m, v, n];
                case 3:
                    return [m, n, v];
                case 4:
                    return [n, m, v];
                case 5:
                    return [v, m, n];
            }
        }


        function removePicker() {
            delete jscolor.picker.owner;
            document.getElementsByTagName('body')[0].removeChild(jscolor.picker.boxB);
        }


        function drawPicker(x, y) {
            if (!jscolor.picker) {
                jscolor.picker = {
                    box: document.createElement('div'),
                    boxB: document.createElement('div'),
                    pad: document.createElement('div'),
                    padB: document.createElement('div'),
                    padM: document.createElement('div'),
                    sld: document.createElement('div'),
                    sldB: document.createElement('div'),
                    sldM: document.createElement('div'),
                    btn: document.createElement('div'),
                    btnS: document.createElement('span'),
                    btnT: document.createTextNode(THIS.pickerCloseText)
                };
                for (var i = 0, segSize = 4; i < jscolor.images.sld[1]; i += segSize) {
                    var seg = document.createElement('div');
                    seg.style.height = segSize + 'px';
                    seg.style.fontSize = '1px';
                    seg.style.lineHeight = '0';
                    jscolor.picker.sld.appendChild(seg);
                }
                jscolor.picker.sldB.appendChild(jscolor.picker.sld);
                jscolor.picker.box.appendChild(jscolor.picker.sldB);
                jscolor.picker.box.appendChild(jscolor.picker.sldM);
                jscolor.picker.padB.appendChild(jscolor.picker.pad);
                jscolor.picker.box.appendChild(jscolor.picker.padB);
                jscolor.picker.box.appendChild(jscolor.picker.padM);
                jscolor.picker.btnS.appendChild(jscolor.picker.btnT);
                jscolor.picker.btn.appendChild(jscolor.picker.btnS);
                jscolor.picker.box.appendChild(jscolor.picker.btn);
                jscolor.picker.boxB.appendChild(jscolor.picker.box);
            }

            var p = jscolor.picker;

            // controls interaction
            p.box.onmouseup =
                p.box.onmouseout = function () {
                    target.focus();
                };
            p.box.onmousedown = function () {
                abortBlur = true;
            };
            p.box.onmousemove = function (e) {
                if (holdPad || holdSld) {
                    holdPad && setPad(e);
                    holdSld && setSld(e);
                    if (document.selection) {
                        document.selection.empty();
                    } else if (window.getSelection) {
                        window.getSelection().removeAllRanges();
                    }
                    dispatchImmediateChange();
                }
            };
            if ('ontouchstart' in window) { // if touch device
                var handle_touchmove = function (e) {
                    var event = {
                        'offsetX': e.touches[0].pageX - touchOffset.X,
                        'offsetY': e.touches[0].pageY - touchOffset.Y
                    };
                    if (holdPad || holdSld) {
                        holdPad && setPad(event);
                        holdSld && setSld(event);
                        dispatchImmediateChange();
                    }
                    e.stopPropagation(); // prevent move "view" on broswer
                    e.preventDefault(); // prevent Default - Android Fix (else android generated only 1-2 touchmove events)
                };
                p.box.removeEventListener('touchmove', handle_touchmove, false)
                p.box.addEventListener('touchmove', handle_touchmove, false)
            }
            p.padM.onmouseup =
                p.padM.onmouseout = function () {
                    if (holdPad) {
                        holdPad = false;
                        jscolor.fireEvent(valueElement, 'change');
                    }
                };
            p.padM.onmousedown = function (e) {
                // if the slider is at the bottom, move it up
                switch (modeID) {
                    case 0:
                        if (THIS.hsv[2] === 0) {
                            THIS.fromHSV(null, null, 1.0);
                        }
                        ;
                        break;
                    case 1:
                        if (THIS.hsv[1] === 0) {
                            THIS.fromHSV(null, 1.0, null);
                        }
                        ;
                        break;
                }
                holdSld = false;
                holdPad = true;
                setPad(e);
                dispatchImmediateChange();
            };
            if ('ontouchstart' in window) {
                p.padM.addEventListener('touchstart', function (e) {
                    touchOffset = {
                        'X': e.target.offsetParent.offsetLeft,
                        'Y': e.target.offsetParent.offsetTop
                    };
                    this.onmousedown({
                        'offsetX': e.touches[0].pageX - touchOffset.X,
                        'offsetY': e.touches[0].pageY - touchOffset.Y
                    });
                });
            }
            p.sldM.onmouseup =
                p.sldM.onmouseout = function () {
                    if (holdSld) {
                        holdSld = false;
                        jscolor.fireEvent(valueElement, 'change');
                    }
                };
            p.sldM.onmousedown = function (e) {
                holdPad = false;
                holdSld = true;
                setSld(e);
                dispatchImmediateChange();
            };
            if ('ontouchstart' in window) {
                p.sldM.addEventListener('touchstart', function (e) {
                    touchOffset = {
                        'X': e.target.offsetParent.offsetLeft,
                        'Y': e.target.offsetParent.offsetTop
                    };
                    this.onmousedown({
                        'offsetX': e.touches[0].pageX - touchOffset.X,
                        'offsetY': e.touches[0].pageY - touchOffset.Y
                    });
                });
            }

            // picker
            var dims = getPickerDims(THIS);
            p.box.style.width = dims[0] + 'px';
            p.box.style.height = dims[1] + 'px';

            // picker border
            p.boxB.style.position = 'absolute';
            p.boxB.style.clear = 'both';
            p.boxB.style.left = x + 'px';
            p.boxB.style.top = y + 'px';
            p.boxB.style.zIndex = THIS.pickerZIndex;
            p.boxB.style.border = THIS.pickerBorder + 'px solid';
            p.boxB.style.borderColor = THIS.pickerBorderColor;
            p.boxB.style.background = THIS.pickerFaceColor;

            // pad image
            p.pad.style.width = jscolor.images.pad[0] + 'px';
            p.pad.style.height = jscolor.images.pad[1] + 'px';

            // pad border
            p.padB.style.position = 'absolute';
            p.padB.style.left = THIS.pickerFace + 'px';
            p.padB.style.top = THIS.pickerFace + 'px';
            p.padB.style.border = THIS.pickerInset + 'px solid';
            p.padB.style.borderColor = THIS.pickerInsetColor;

            // pad mouse area
            p.padM.style.position = 'absolute';
            p.padM.style.left = '0';
            p.padM.style.top = '0';
            p.padM.style.width = THIS.pickerFace + 2 * THIS.pickerInset + jscolor.images.pad[0] + jscolor.images.arrow[0] + 'px';
            p.padM.style.height = p.box.style.height;
            p.padM.style.cursor = 'crosshair';

            // slider image
            p.sld.style.overflow = 'hidden';
            p.sld.style.width = jscolor.images.sld[0] + 'px';
            p.sld.style.height = jscolor.images.sld[1] + 'px';

            // slider border
            p.sldB.style.display = THIS.slider ? 'block' : 'none';
            p.sldB.style.position = 'absolute';
            p.sldB.style.right = THIS.pickerFace + 'px';
            p.sldB.style.top = THIS.pickerFace + 'px';
            p.sldB.style.border = THIS.pickerInset + 'px solid';
            p.sldB.style.borderColor = THIS.pickerInsetColor;

            // slider mouse area
            p.sldM.style.display = THIS.slider ? 'block' : 'none';
            p.sldM.style.position = 'absolute';
            p.sldM.style.right = '0';
            p.sldM.style.top = '0';
            p.sldM.style.width = jscolor.images.sld[0] + jscolor.images.arrow[0] + THIS.pickerFace + 2 * THIS.pickerInset + 'px';
            p.sldM.style.height = p.box.style.height;
            try {
                p.sldM.style.cursor = 'pointer';
            } catch (eOldIE) {
                p.sldM.style.cursor = 'hand';
            }

            // "close" button
            function setBtnBorder() {
                var insetColors = THIS.pickerInsetColor.split(/\s+/);
                var pickerOutsetColor = insetColors.length < 2 ? insetColors[0] : insetColors[1] + ' ' + insetColors[0] + ' ' + insetColors[0] + ' ' + insetColors[1];
                p.btn.style.borderColor = pickerOutsetColor;
            }

            p.btn.style.display = THIS.pickerClosable ? 'block' : 'none';
            p.btn.style.position = 'absolute';
            p.btn.style.left = THIS.pickerFace + 'px';
            p.btn.style.bottom = THIS.pickerFace + 'px';
            p.btn.style.padding = '0 15px';
            p.btn.style.height = '18px';
            p.btn.style.border = THIS.pickerInset + 'px solid';
            setBtnBorder();
            p.btn.style.color = THIS.pickerButtonColor;
            p.btn.style.font = '12px sans-serif';
            p.btn.style.textAlign = 'center';
            try {
                p.btn.style.cursor = 'pointer';
            } catch (eOldIE) {
                p.btn.style.cursor = 'hand';
            }
            p.btn.onmousedown = function () {
                THIS.hidePicker();
            };
            p.btnS.style.lineHeight = p.btn.style.height;

            // load images in optimal order
            switch (modeID) {
                case 0:
                    var padImg = 'hs.png';
                    break;
                case 1:
                    var padImg = 'hv.png';
                    break;
            }
            p.padM.style.backgroundImage = "url('" + jscolor.getDir() + "cross.gif')";
            p.padM.style.backgroundRepeat = "no-repeat";
            p.sldM.style.backgroundImage = "url('" + jscolor.getDir() + "arrow.gif')";
            p.sldM.style.backgroundRepeat = "no-repeat";
            p.pad.style.backgroundImage = "url('" + jscolor.getDir() + padImg + "')";
            p.pad.style.backgroundRepeat = "no-repeat";
            p.pad.style.backgroundPosition = "0 0";

            // place pointers
            redrawPad();
            redrawSld();

            jscolor.picker.owner = THIS;
            document.getElementsByTagName('body')[0].appendChild(p.boxB);
        }


        function getPickerDims(o) {
            var dims = [
                2 * o.pickerInset + 2 * o.pickerFace + jscolor.images.pad[0] +
                (o.slider ? 2 * o.pickerInset + 2 * jscolor.images.arrow[0] + jscolor.images.sld[0] : 0),
                o.pickerClosable ?
                4 * o.pickerInset + 3 * o.pickerFace + jscolor.images.pad[1] + o.pickerButtonHeight :
                2 * o.pickerInset + 2 * o.pickerFace + jscolor.images.pad[1]
            ];
            return dims;
        }


        function redrawPad() {
            // redraw the pad pointer
            switch (modeID) {
                case 0:
                    var yComponent = 1;
                    break;
                case 1:
                    var yComponent = 2;
                    break;
            }
            var x = Math.round((THIS.hsv[0] / 6) * (jscolor.images.pad[0] - 1));
            var y = Math.round((1 - THIS.hsv[yComponent]) * (jscolor.images.pad[1] - 1));
            jscolor.picker.padM.style.backgroundPosition =
                (THIS.pickerFace + THIS.pickerInset + x - Math.floor(jscolor.images.cross[0] / 2)) + 'px ' +
                (THIS.pickerFace + THIS.pickerInset + y - Math.floor(jscolor.images.cross[1] / 2)) + 'px';

            // redraw the slider image
            var seg = jscolor.picker.sld.childNodes;

            switch (modeID) {
                case 0:
                    var rgb = HSV_RGB(THIS.hsv[0], THIS.hsv[1], 1);
                    for (var i = 0; i < seg.length; i += 1) {
                        seg[i].style.backgroundColor = 'rgb(' +
                        (rgb[0] * (1 - i / seg.length) * 100) + '%,' +
                        (rgb[1] * (1 - i / seg.length) * 100) + '%,' +
                        (rgb[2] * (1 - i / seg.length) * 100) + '%)';
                    }
                    break;
                case 1:
                    var rgb, s, c = [THIS.hsv[2], 0, 0];
                    var i = Math.floor(THIS.hsv[0]);
                    var f = i % 2 ? THIS.hsv[0] - i : 1 - (THIS.hsv[0] - i);
                    switch (i) {
                        case 6:
                        case 0:
                            rgb = [0, 1, 2];
                            break;
                        case 1:
                            rgb = [1, 0, 2];
                            break;
                        case 2:
                            rgb = [2, 0, 1];
                            break;
                        case 3:
                            rgb = [2, 1, 0];
                            break;
                        case 4:
                            rgb = [1, 2, 0];
                            break;
                        case 5:
                            rgb = [0, 2, 1];
                            break;
                    }
                    for (var i = 0; i < seg.length; i += 1) {
                        s = 1 - 1 / (seg.length - 1) * i;
                        c[1] = c[0] * (1 - s * f);
                        c[2] = c[0] * (1 - s);
                        seg[i].style.backgroundColor = 'rgb(' +
                        (c[rgb[0]] * 100) + '%,' +
                        (c[rgb[1]] * 100) + '%,' +
                        (c[rgb[2]] * 100) + '%)';
                    }
                    break;
            }
        }


        function redrawSld() {
            // redraw the slider pointer
            switch (modeID) {
                case 0:
                    var yComponent = 2;
                    break;
                case 1:
                    var yComponent = 1;
                    break;
            }
            var y = Math.round((1 - THIS.hsv[yComponent]) * (jscolor.images.sld[1] - 1));
            jscolor.picker.sldM.style.backgroundPosition =
                '0 ' + (THIS.pickerFace + THIS.pickerInset + y - Math.floor(jscolor.images.arrow[1] / 2)) + 'px';
        }


        function isPickerOwner() {
            return jscolor.picker && jscolor.picker.owner === THIS;
        }


        function blurTarget() {
            if (valueElement === target) {
                THIS.importColor();
            }
            if (THIS.pickerOnfocus) {
                THIS.hidePicker();
            }
        }


        function blurValue() {
            if (valueElement !== target) {
                THIS.importColor();
            }
        }


        function setPad(e) {
            var mpos = jscolor.getRelMousePos(e);
            var x = mpos.x - THIS.pickerFace - THIS.pickerInset;
            var y = mpos.y - THIS.pickerFace - THIS.pickerInset;
            switch (modeID) {
                case 0:
                    THIS.fromHSV(x * (6 / (jscolor.images.pad[0] - 1)), 1 - y / (jscolor.images.pad[1] - 1), null, leaveSld);
                    break;
                case 1:
                    THIS.fromHSV(x * (6 / (jscolor.images.pad[0] - 1)), null, 1 - y / (jscolor.images.pad[1] - 1), leaveSld);
                    break;
            }
        }


        function setSld(e) {
            var mpos = jscolor.getRelMousePos(e);
            var y = mpos.y - THIS.pickerFace - THIS.pickerInset;
            switch (modeID) {
                case 0:
                    THIS.fromHSV(null, null, 1 - y / (jscolor.images.sld[1] - 1), leavePad);
                    break;
                case 1:
                    THIS.fromHSV(null, 1 - y / (jscolor.images.sld[1] - 1), null, leavePad);
                    break;
            }
        }


        function dispatchImmediateChange() {
            if (THIS.onImmediateChange) {
                var callback;
                if (typeof THIS.onImmediateChange === 'string') {
                    callback = new Function(THIS.onImmediateChange);
                } else {
                    callback = THIS.onImmediateChange;
                }
                callback.call(THIS);
            }
        }


        var THIS = this;
        var modeID = this.pickerMode.toLowerCase() === 'hvs' ? 1 : 0;
        var abortBlur = false;
        var
            valueElement = jscolor.fetchElement(this.valueElement),
            styleElement = jscolor.fetchElement(this.styleElement);
        var
            holdPad = false,
            holdSld = false,
            touchOffset = {};
        var
            leaveValue = 1 << 0,
            leaveStyle = 1 << 1,
            leavePad = 1 << 2,
            leaveSld = 1 << 3;

        // target
        jscolor.addEvent(target, 'focus', function () {
            if (THIS.pickerOnfocus) {
                THIS.showPicker();
            }
        });
        jscolor.addEvent(target, 'blur', function () {
            if (!abortBlur) {
                window.setTimeout(function () {
                    abortBlur || blurTarget();
                    abortBlur = false;
                }, 0);
            } else {
                abortBlur = false;
            }
        });

        // valueElement
        if (valueElement) {
            var updateField = function () {
                THIS.fromString(valueElement.value, leaveValue);
                dispatchImmediateChange();
            };
            jscolor.addEvent(valueElement, 'keyup', updateField);
            jscolor.addEvent(valueElement, 'input', updateField);
            jscolor.addEvent(valueElement, 'blur', blurValue);
            valueElement.setAttribute('autocomplete', 'off');
        }

        // styleElement
        if (styleElement) {
            styleElement.jscStyle = {
                backgroundImage: styleElement.style.backgroundImage,
                backgroundColor: styleElement.style.backgroundColor,
                color: styleElement.style.color
            };
        }

        // require images
        switch (modeID) {
            case 0:
                jscolor.requireImage('hs.png');
                break;
            case 1:
                jscolor.requireImage('hv.png');
                break;
        }
        jscolor.requireImage('cross.gif');
        jscolor.requireImage('arrow.gif');

        this.importColor();
    }

};


jscolor.install();

(function ($) {

    $.fn.flash = function () {
        try {
            var ActiveXFlash = new ActiveXObject('ShockwaveFlash.ShockwaveFlash');
            if (ActiveXFlash) {
                return true;
            }
        } catch (e) {
            var MimeTypes = navigator.mimeTypes;
            if (MimeTypes["application/x-shockwave-flash"] != undefined) {
                console.info(MimeTypes["application/x-shockwave-flash"]);

                if (MimeTypes["application/x-shockwave-flash"].enabledPlugin) {
                    return true;
                }
            }
        }
        return false;
    }
})($)
jQuery.fn.extend({
    toggleText: function (a, b) {
        var that = this;
        if (that.text() != a && that.text() != b) {
            that.text(a);
        }
        else if (that.text() == a) {
            that.text(b);
        }
        else if (that.text() == b) {
            that.text(a);
        }
        return this;
    }
});