(function (d) {
    var j = 0;
    d.widget("ech.multiselect", {
            options: {
                header: !0,
                height: 175,
                minWidth: 225,
                classes: "",
                checkAllText: i18n_checkAllText,
                uncheckAllText: i18n_uncheckAllText,
                noneSelectedText: i18n_noneSelectedText,
                selectedText: i18n_selectedText,
                selectedList: 0,
                show: "",
                hide: "",
                autoOpen: !1,
                multiple: !0,
                position: {}
            },
            _create: function () {
                var a = this.element.hide(),
                    b = this.options;
                this.speed = d.fx.speeds._default;
                this._isOpen = !1;
                a = (this.button = d('<button type="button"><span class="ui-icon ui-icon-triangle-2-n-s"></span></button>')).addClass("ui-multiselect ui-widget ui-state-default ui-corner-all").addClass(b.classes).attr({
                        title: a.attr("title"),
                        "aria-haspopup": !0,
                        tabIndex: a.attr("tabIndex")
                    }).insertAfter(a);
                (this.buttonlabel = d("<span />")).html(b.noneSelectedText).appendTo(a);
                var a = (this.menu = d("<div />")).addClass("ui-multiselect-menu ui-widget ui-widget-content ui-corner-all").addClass(b.classes).appendTo(document.body),
                    c = (this.header = d("<div />")).addClass("ui-widget-header ui-corner-all ui-multiselect-header ui-helper-clearfix").appendTo(a);
                (this.headerLinkContainer = d("<ul />")).addClass("ui-helper-reset").html(function () {
                    return !0 === b.header ? '<li><a class="ui-multiselect-all" href="#"><span class="ui-icon ui-icon-check"></span><span>' + b.checkAllText + '</span></a></li><li><a class="ui-multiselect-none" href="#"><span class="ui-icon ui-icon-closethick"></span><span>' + b.uncheckAllText + "</span></a></li>" : "string" === typeof b.header ? "<li>" + b.header + "</li>" : ""
                }).append('<li class="ui-multiselect-close"><a href="#" class="ui-multiselect-close"><span class="ui-icon ui-icon-circle-close"></span></a></li>').appendTo(c);
                (this.checkboxContainer = d("<ul />")).addClass("ui-multiselect-checkboxes ui-helper-reset").appendTo(a);
                this._bindEvents();
                this.refresh(!0);
                b.multiple || a.addClass("ui-multiselect-single")
            },
            _init: function () {
                !1 === this.options.header && this.header.hide();
                this.options.multiple || this.headerLinkContainer.find(".ui-multiselect-all, .ui-multiselect-none").hide();
                this.options.autoOpen && this.open();
                this.element.is(":disabled") && this.disable()
            },
            refresh: function (a) {
                var b = this.element,
                    c = this.options,
                    e = this.menu,
                    h = this.checkboxContainer,
                    g = [],
                    f = [],
                    i = b.attr("id") || j++;
                b.find("option").each(function (b) {
                    d(this);
                    var a = this.parentNode,
                        e = this.innerHTML,
                        h = this.title,
                        j = this.value,
                        b = this.id || "ui-multiselect-" + i + "-option-" + b,
                        k = this.disabled,
                        m = this.selected,
                        l = ["ui-corner-all"];
                    "optgroup" === a.tagName.toLowerCase() && (a = a.getAttribute("label"), -1 === d.inArray(a, g) && (f.push('<li class="ui-multiselect-optgroup-label"><a href="#">' + a + "</a></li>"), g.push(a)));
                    k && l.push("ui-state-disabled");
                    m && !c.multiple && l.push("ui-state-active");
                    f.push('<li class="' + (k ? "ui-multiselect-disabled" : "") + '">');
                    f.push('<label for="' + b + '" title="' + h + '" class="' + l.join(" ") + '">');
                    f.push('<input id="' + b + '" name="multiselect_' + i + '" type="' + (c.multiple ? "checkbox" : "radio") + '" value="' + j + '" title="' + e + '"');
                    m && (f.push(' checked="checked"'), f.push(' aria-selected="true"'));
                    k && (f.push(' disabled="disabled"'), f.push(' aria-disabled="true"'));
                    f.push(" /><span>" + e + "</span></label></li>")
                });
                h.html(f.join(""));
                this.labels = e.find("label");
                this._setButtonWidth();
                this._setMenuWidth();
                this.button[0].defaultValue = this.update();
                a || this._trigger("refresh")
            },
            update: function () {
                var a = this.options,
                    b = this.labels.find("input"),
                    c = b.filter("[checked]"),
                    e = c.length,
                    a = 0 === e ? a.noneSelectedText : d.isFunction(a.selectedText) ? a.selectedText.call(this, e, b.length, c.get()) : /\d/.test(a.selectedList) && 0 < a.selectedList && e <= a.selectedList ? c.map(function () {
                        return d(this).next().text()
                    }).get().join(", ") : a.selectedText.replace("#", e).replace("#", b.length);
                this.buttonlabel.html(a);
                return a
            },
            _bindEvents: function () {
                function a() {
                    b[b._isOpen ? "close" : "open"]();
                    return !1
                }
                var b = this,
                    c = this.button;
                c.find("span").bind("click.multiselect", a);
                c.bind({
                        click: a,
                        keypress: function (a) {
                            switch (a.which) {
                            case 27:
                            case 38:
                            case 37:
                                b.close();
                                break;
                            case 39:
                            case 40:
                                b.open()
                            }
                        },
                        mouseenter: function () {
                            c.hasClass("ui-state-disabled") || d(this).addClass("ui-state-hover")
                        },
                        mouseleave: function () {
                            d(this).removeClass("ui-state-hover")
                        },
                        focus: function () {
                            c.hasClass("ui-state-disabled") || d(this).addClass("ui-state-focus")
                        },
                        blur: function () {
                            d(this).removeClass("ui-state-focus")
                        }
                    });
                this.header.delegate("a", "click.multiselect", function (a) {
                    if (d(this).hasClass("ui-multiselect-close")) b.close();
                    else b[d(this).hasClass("ui-multiselect-all") ? "checkAll" : "uncheckAll"]();
                    a.preventDefault()
                });
                this.menu.delegate("li.ui-multiselect-optgroup-label a", "click.multiselect", function (a) {
                    a.preventDefault();
                    var c = d(this),
                        g = c.parent().nextUntil("li.ui-multiselect-optgroup-label").find("input:visible:not(:disabled)"),
                        f = g.get(),
                        c = c.parent().text();
                    !1 !== b._trigger("beforeoptgrouptoggle", a, {
                            inputs: f,
                            label: c
                        }) && (b._toggleChecked(g.filter("[checked]").length !== g.length, g), b._trigger("optgrouptoggle", a, {
                                inputs: f,
                                label: c,
                                checked: f[0].checked
                            }))
                }).delegate("label", "mouseenter.multiselect", function () {
                    d(this).hasClass("ui-state-disabled") || (b.labels.removeClass("ui-state-hover"), d(this).addClass("ui-state-hover").find("input").focus())
                }).delegate("label", "keydown.multiselect", function (a) {
                    a.preventDefault();
                    switch (a.which) {
                    case 9:
                    case 27:
                        b.close();
                        break;
                    case 38:
                    case 40:
                    case 37:
                    case 39:
                        b._traverse(a.which, this);
                        break;
                    case 13:
                        d(this).find("input")[0].click()
                    }
                }).delegate('input[type="checkbox"], input[type="radio"]', "click.multiselect", function (a) {
                    var c = d(this),
                        g = this.value,
                        f = this.checked,
                        i = b.element.find("option");
                    this.disabled || !1 === b._trigger("click", a, {
                            value: g,
                            text: this.title,
                            checked: f
                        }) ? a.preventDefault() : (c.focus(), c.attr("aria-selected", f), i.each(function () {
                                if (this.value === g) this.selected = f;
                                else if (!b.options.multiple) this.selected = !1
                            }), b.options.multiple || (b.labels.removeClass("ui-state-active"), c.closest("label").toggleClass("ui-state-active", f), b.close()), b.element.trigger("change"), setTimeout(d.proxy(b.update, b), 10))
                });
                d(document).bind("mousedown.multiselect", function (a) {
                    b._isOpen && !d.contains(b.menu[0], a.target) && !d.contains(b.button[0], a.target) && a.target !== b.button[0] && b.close()
                });
                d(this.element[0].form).bind("reset.multiselect", function () {
                    setTimeout(d.proxy(b.refresh, b), 10)
                })
            },
            _setButtonWidth: function () {
                var a = this.element.outerWidth(),
                    b = this.options;
                if (/\d/.test(b.minWidth) && a < b.minWidth) a = b.minWidth;
                this.button.width(a)
            },
            _setMenuWidth: function () {
                var a = this.menu,
                    b = this.button.outerWidth() - parseInt(a.css("padding-left"), 10) - parseInt(a.css("padding-right"), 10) - parseInt(a.css("border-right-width"), 10) - parseInt(a.css("border-left-width"), 10);
                a.width(b || this.button.outerWidth())
            },
            _traverse: function (a, b) {
                var c = d(b),
                    e = 38 === a || 37 === a,
                    c = c.parent()[e ? "prevAll" : "nextAll"]("li:not(.ui-multiselect-disabled, .ui-multiselect-optgroup-label)")[e ? "last" : "first"]();
                c.length ? c.find("label").trigger("mouseover") : (c = this.menu.find("ul").last(), this.menu.find("label")[e ? "last" : "first"]().trigger("mouseover"), c.scrollTop(e ? c.height() : 0))
            },
            _toggleState: function (a, b) {
                return function () {
                    this.disabled || (this[a] = b);
                    b ? this.setAttribute("aria-selected", !0) : this.removeAttribute("aria-selected")
                }
            },
            _toggleChecked: function (a, b) {
                var c = b && b.length ? b : this.labels.find("input"),
                    e = this;
                c.each(this._toggleState("checked", a));
                c.eq(0).focus();
                this.update();
                var h = c.map(function () {
                    return this.value
                }).get();
                this.element.find("option").each(function () {
                    !this.disabled && -1 < d.inArray(this.value, h) && e._toggleState("selected", a).call(this)
                });
                c.length && this.element.trigger("change")
            },
            _toggleDisabled: function (a) {
                this.button.attr({
                        disabled: a,
                        "aria-disabled": a
                    })[a ? "addClass" : "removeClass"]("ui-state-disabled");
                this.menu.find("input").attr({
                        disabled: a,
                        "aria-disabled": a
                    }).parent()[a ? "addClass" : "removeClass"]("ui-state-disabled");
                this.element.attr({
                        disabled: a,
                        "aria-disabled": a
                    })
            },
            open: function () {
                var a = this.button,
                    b = this.menu,
                    c = this.speed,
                    e = this.options;
                if (!(!1 === this._trigger("beforeopen") || a.hasClass("ui-state-disabled") || this._isOpen)) {
                    var h = b.find("ul").last(),
                        g = e.show,
                        f = a.offset();
                    d.isArray(e.show) && (g = e.show[0], c = e.show[1] || this.speed);
                    h.scrollTop(0).height(e.height);
                    d.ui.position && !d.isEmptyObject(e.position) ? (e.position.of = e.position.of || a, b.show().position(e.position).hide().show(g, c)) : b.css({
                            top: f.top + a.outerHeight(),
                            left: f.left
                        }).show(g, c);
                    this.labels.eq(0).trigger("mouseover").trigger("mouseenter").find("input").trigger("focus");
                    a.addClass("ui-state-active");
                    this._isOpen = !0;
                    this._trigger("open")
                }
            },
            close: function () {
                if (!1 !== this._trigger("beforeclose")) {
                    var a = this.options,
                        b = a.hide,
                        c = this.speed;
                    d.isArray(a.hide) && (b = a.hide[0], c = a.hide[1] || this.speed);
                    this.menu.hide(b, c);
                    this.button.removeClass("ui-state-active").trigger("blur").trigger("mouseleave");
                    this._isOpen = !1;
                    this._trigger("close")
                }
            },
            enable: function () {
                this._toggleDisabled(!1)
            },
            disable: function () {
                this._toggleDisabled(!0)
            },
            checkAll: function () {
                this._toggleChecked(!0);
                this._trigger("checkAll")
            },
            uncheckAll: function () {
                this._toggleChecked(!1);
                this._trigger("uncheckAll")
            },
            getChecked: function () {
                return this.menu.find("input").filter("[checked]")
            },
            destroy: function () {
                d.Widget.prototype.destroy.call(this);
                this.button.remove();
                this.menu.remove();
                this.element.show();
                return this
            },
            isOpen: function () {
                return this._isOpen
            },
            widget: function () {
                return this.menu
            },
            _setOption: function (a, b) {
                var c = this.menu;
                switch (a) {
                case "header":
                    c.find("div.ui-multiselect-header")[b ? "show" : "hide"]();
                    break;
                case "checkAllText":
                    c.find("a.ui-multiselect-all span").eq(-1).text(b);
                    break;
                case "uncheckAllText":
                    c.find("a.ui-multiselect-none span").eq(-1).text(b);
                    break;
                case "height":
                    c.find("ul").last().height(parseInt(b, 10));
                    break;
                case "minWidth":
                    this.options[a] = parseInt(b, 10);
                    this._setButtonWidth();
                    this._setMenuWidth();
                    break;
                case "selectedText":
                case "selectedList":
                case "noneSelectedText":
                    this.options[a] = b;
                    this.update();
                    break;
                case "classes":
                    c.add(this.button).removeClass(this.options.classes).addClass(b)
                }
                d.Widget.prototype._setOption.apply(this, arguments)
            }
        })
})(jQuery);

jQuery.easing['jswing'] = jQuery.easing['swing'];
jQuery.extend(jQuery.easing, {
        def: 'easeOutQuad',
        swing: function (x, t, b, c, d) {
            return jQuery.easing[jQuery.easing.def](x, t, b, c, d);
        },
        easeInQuad: function (x, t, b, c, d) {
            return c * (t /= d) * t + b;
        },
        easeOutQuad: function (x, t, b, c, d) {
            return -c * (t /= d) * (t - 2) + b;
        },
        easeInOutQuad: function (x, t, b, c, d) {
            if ((t /= d / 2) < 1) return c / 2 * t * t + b;
            return -c / 2 * ((--t) * (t - 2) - 1) + b;
        },
        easeInCubic: function (x, t, b, c, d) {
            return c * (t /= d) * t * t + b;
        },
        easeOutCubic: function (x, t, b, c, d) {
            return c * ((t = t / d - 1) * t * t + 1) + b;
        },
        easeInOutCubic: function (x, t, b, c, d) {
            if ((t /= d / 2) < 1) return c / 2 * t * t * t + b;
            return c / 2 * ((t -= 2) * t * t + 2) + b;
        },
        easeInQuart: function (x, t, b, c, d) {
            return c * (t /= d) * t * t * t + b;
        },
        easeOutQuart: function (x, t, b, c, d) {
            return -c * ((t = t / d - 1) * t * t * t - 1) + b;
        },
        easeInOutQuart: function (x, t, b, c, d) {
            if ((t /= d / 2) < 1) return c / 2 * t * t * t * t + b;
            return -c / 2 * ((t -= 2) * t * t * t - 2) + b;
        },
        easeInQuint: function (x, t, b, c, d) {
            return c * (t /= d) * t * t * t * t + b;
        },
        easeOutQuint: function (x, t, b, c, d) {
            return c * ((t = t / d - 1) * t * t * t * t + 1) + b;
        },
        easeInOutQuint: function (x, t, b, c, d) {
            if ((t /= d / 2) < 1) return c / 2 * t * t * t * t * t + b;
            return c / 2 * ((t -= 2) * t * t * t * t + 2) + b;
        },
        easeInSine: function (x, t, b, c, d) {
            return -c * Math.cos(t / d * (Math.PI / 2)) + c + b;
        },
        easeOutSine: function (x, t, b, c, d) {
            return c * Math.sin(t / d * (Math.PI / 2)) + b;
        },
        easeInOutSine: function (x, t, b, c, d) {
            return -c / 2 * (Math.cos(Math.PI * t / d) - 1) + b;
        },
        easeInExpo: function (x, t, b, c, d) {
            return (t == 0) ? b : c * Math.pow(2, 10 * (t / d - 1)) + b;
        },
        easeOutExpo: function (x, t, b, c, d) {
            return (t == d) ? b + c : c * (-Math.pow(2, -10 * t / d) + 1) + b;
        },
        easeInOutExpo: function (x, t, b, c, d) {
            if (t == 0) return b;
            if (t == d) return b + c;
            if ((t /= d / 2) < 1) return c / 2 * Math.pow(2, 10 * (t - 1)) + b;
            return c / 2 * (-Math.pow(2, -10 * --t) + 2) + b;
        },
        easeInCirc: function (x, t, b, c, d) {
            return -c * (Math.sqrt(1 - (t /= d) * t) - 1) + b;
        },
        easeOutCirc: function (x, t, b, c, d) {
            return c * Math.sqrt(1 - (t = t / d - 1) * t) + b;
        },
        easeInOutCirc: function (x, t, b, c, d) {
            if ((t /= d / 2) < 1) return -c / 2 * (Math.sqrt(1 - t * t) - 1) + b;
            return c / 2 * (Math.sqrt(1 - (t -= 2) * t) + 1) + b;
        },
        easeInElastic: function (x, t, b, c, d) {
            var s = 1.70158;
            var p = 0;
            var a = c;
            if (t == 0) return b;
            if ((t /= d) == 1) return b + c;
            if (!p) p = d * .3;
            if (a < Math.abs(c)) {
                a = c;
                var s = p / 4;
            } else var s = p / (2 * Math.PI) * Math.asin(c / a);
            return -(a * Math.pow(2, 10 * (t -= 1)) * Math.sin((t * d - s) * (2 * Math.PI) / p)) + b;
        },
        easeOutElastic: function (x, t, b, c, d) {
            var s = 1.70158;
            var p = 0;
            var a = c;
            if (t == 0) return b;
            if ((t /= d) == 1) return b + c;
            if (!p) p = d * .3;
            if (a < Math.abs(c)) {
                a = c;
                var s = p / 4;
            } else var s = p / (2 * Math.PI) * Math.asin(c / a);
            return a * Math.pow(2, -10 * t) * Math.sin((t * d - s) * (2 * Math.PI) / p) + c + b;
        },
        easeInOutElastic: function (x, t, b, c, d) {
            var s = 1.70158;
            var p = 0;
            var a = c;
            if (t == 0) return b;
            if ((t /= d / 2) == 2) return b + c;
            if (!p) p = d * (.3 * 1.5);
            if (a < Math.abs(c)) {
                a = c;
                var s = p / 4;
            } else var s = p / (2 * Math.PI) * Math.asin(c / a); if (t < 1) return -.5 * (a * Math.pow(2, 10 * (t -= 1)) * Math.sin((t * d - s) * (2 * Math.PI) / p)) + b;
            return a * Math.pow(2, -10 * (t -= 1)) * Math.sin((t * d - s) * (2 * Math.PI) / p) * .5 + c + b;
        },
        easeInBack: function (x, t, b, c, d, s) {
            if (s == undefined) s = 1.70158;
            return c * (t /= d) * t * ((s + 1) * t - s) + b;
        },
        easeOutBack: function (x, t, b, c, d, s) {
            if (s == undefined) s = 1.70158;
            return c * ((t = t / d - 1) * t * ((s + 1) * t + s) + 1) + b;
        },
        easeInOutBack: function (x, t, b, c, d, s) {
            if (s == undefined) s = 1.70158;
            if ((t /= d / 2) < 1) return c / 2 * (t * t * (((s *= (1.525)) + 1) * t - s)) + b;
            return c / 2 * ((t -= 2) * t * (((s *= (1.525)) + 1) * t + s) + 2) + b;
        },
        easeInBounce: function (x, t, b, c, d) {
            return c - jQuery.easing.easeOutBounce(x, d - t, 0, c, d) + b;
        },
        easeOutBounce: function (x, t, b, c, d) {
            if ((t /= d) < (1 / 2.75)) {
                return c * (7.5625 * t * t) + b;
            } else if (t < (2 / 2.75)) {
                return c * (7.5625 * (t -= (1.5 / 2.75)) * t + .75) + b;
            } else if (t < (2.5 / 2.75)) {
                return c * (7.5625 * (t -= (2.25 / 2.75)) * t + .9375) + b;
            } else {
                return c * (7.5625 * (t -= (2.625 / 2.75)) * t + .984375) + b;
            }
        },
        easeInOutBounce: function (x, t, b, c, d) {
            if (t < d / 2) return jQuery.easing.easeInBounce(x, t * 2, 0, c, d) * .5 + b;
            return jQuery.easing.easeOutBounce(x, t * 2 - d, 0, c, d) * .5 + c * .5 + b;
        }
    });

(function ($) {
    $.fn.flipCounter = function (j) {
        var k = false;
        var l = {
            number: 0,
            numIntegralDigits: 1,
            numFractionalDigits: 0,
            digitClass: "counter-digit",
            counterFieldName: "counter-value",
            digitHeight: 40,
            digitWidth: 30,
            imagePath: plgroot + "img/flipCounter-medium.png",
            easing: false,
            duration: 1E4,
            onAnimationStarted: false,
            onAnimationStopped: false,
            onAnimationPaused: false,
            onAnimationResumed: false,
            formatNumberOptions: false
        };
        var m = {
            init: function (e) {
                return this.each(function () {
                    k = $(this);
                    var c = $.extend(l, e);
                    var d = k.data("flipCounter");
                    e = $.extend(d, c);
                    k.data("flipCounter", e);
                    if (e.number === false || e.number == 0) {
                        _getCounterValue() !== false ? e.number = _getCounterValue() : e.number = 0;
                        _setOption("number", e.number)
                    }
                    _setOption("animating", false);
                    _setOption("start_time", false);
                    k.bind("startAnimation", function (a, b) {
                        _startAnimation(b)
                    });
                    k.bind("pauseAnimation", function (a) {
                        _pauseAnimation()
                    });
                    k.bind("resumeAnimation", function (a) {
                        _resumeAnimation()
                    });
                    k.bind("stopAnimation", function (a) {
                        _stopAnimation()
                    });
                    k.htmlClean();
                    _renderCounter()
                })
            },
            renderCounter: function (a) {
                return this.each(function () {
                    k = $(this);
                    if (!_isInitialized()) {
                        $(this).flipCounter()
                    }
                    _setOption("number", a);
                    _renderCounter()
                })
            },
            setNumber: function (a) {
                return this.each(function () {
                    k = $(this);
                    if (!_isInitialized()) {
                        $(this).flipCounter()
                    }
                    _setOption("number", a);
                    _renderCounter()
                })
            },
            getNumber: function () {
                var a = false;
                this.each(a = function () {
                    k = $(this);
                    if (!_isInitialized()) {
                        $(this).flipCounter()
                    }
                    a = _getOption("number");
                    return a
                });
                return a
            },
            startAnimation: function (a) {
                return this.each(function () {
                    k = $(this);
                    if (!_isInitialized()) {
                        $(this).flipCounter()
                    }
                    k.trigger("startAnimation", a)
                })
            },
            stopAnimation: function () {
                return this.each(function () {
                    k = $(this);
                    if (!_isInitialized()) {
                        $(this).flipCounter()
                    }
                    k.trigger("stopAnimation")
                })
            },
            pauseAnimation: function () {
                return this.each(function () {
                    k = $(this);
                    if (!_isInitialized()) {
                        $(this).flipCounter()
                    }
                    k.trigger("pauseAnimation")
                })
            },
            resumeAnimation: function () {
                return this.each(function () {
                    k = $(this);
                    if (!_isInitialized()) {
                        $(this).flipCounter()
                    }
                    k.trigger("resumeAnimation")
                })
            }
        };
        if (m[j]) {
            return m[j].apply(this, Array.prototype.slice.call(arguments, 1))
        } else {
            if (typeof j === "object" || !j) {
                return m.init.apply(this, arguments)
            } else {
                $.error("Method " + j + " does not exist on jQuery.flipCounter")
            }
        }

        function _isInitialized() {
            var a = k.data("flipCounter");
            if (typeof a == "undefined") {
                return false
            }
            return true
        }

        function _getOption(a) {
            var b = k.data("flipCounter");
            var c = b[a];
            if (typeof c !== "undefined") {
                return c
            }
            return false
        }

        function _setOption(a, b) {
            var c = k.data("flipCounter");
            c[a] = b;
            k.data("flipCounter", c)
        }

        function _setupCounter() {
            if (k.children('[name="' + _getOption("counterFieldName") + '"]').length < 1) {
                k.append('<input type="hidden" name="' + _getOption("counterFieldName") + '" value="' + _getOption("number") + '" />')
            }
            var a = _getDigitsLength();
            var b = _getNumberFormatted().length;
            if (b > a) {
                for (i = 0; i < b - a; i++) {
                    var c = $('<span class="' + _getOption("digitClass") + '" style="' + _getDigitStyle("0") + '" />');
                    k.prepend(c)
                }
            } else {
                if (b < a) {
                    for (i = 0; i < a - b; i++) {
                        k.children("." + _getOption("digitClass")).first().remove()
                    }
                }
            }
            k.find("." + _getOption("digitClass")).each(function () {
                if (0 == $(this).find("span").length) {
                    $(this).append('<span style="visibility:hidden">0</span>')
                }
            })
        }

        function _renderCounter() {
            _setupCounter();
            var c = _getNumberFormatted();
            var d = _getDigits();
            var e = 0;
            $.each(d, function (a, b) {
                digit = c.toString().charAt(e);
                $(this).attr("style", _getDigitStyle(digit));
                $(this).find("span").text(digit.replace(" ", "&nbsp;").toString());
                e++
            });
            _setCounterValue()
        }

        function _getDigits() {
            return k.children("." + _getOption("digitClass"))
        }

        function _getDigitsLength() {
            return _getDigits().length
        }

        function _getCounterValue() {
            var a = parseFloat(k.children('[name="' + _getOption("counterFieldName") + '"]').val());
            if (a == a == false) {
                return false
            }
            return a
        }

        function _setCounterValue() {
            k.children('[name="' + _getOption("counterFieldName") + '"]').val(_getOption("number"))
        }

        function _getNumberFormatted() {
            var a = _getOption("number");
            if (typeof a !== "number") {
                $.error("Attempting to render non-numeric value.");
                return "0"
            }
            var b = "";
            if (_getOption("formatNumberOptions")) {
                if ($.formatNumber) {
                    b = $.formatNumber(a, _getOption("formatNumberOptions"))
                } else {
                    $.error("The numberformatter jQuery plugin is not loaded. This plugin is required to use the formatNumberOptions setting.")
                }
            } else {
                if (a >= 0) {
                    var c = _getOption("numIntegralDigits");
                    var d = c - a.toFixed().toString().length;
                    for (var i = 0; i < d; i++) {
                        b += "0"
                    }
                    b += a.toFixed(_getOption("numFractionalDigits"))
                } else {
                    b = "-" + Math.abs(a.toFixed(_getOption("numFractionalDigits")))
                }
            }
            return b
        }

        function _getDigitStyle(a) {
            var b = "height:" + _getOption("digitHeight") + "px; width:" + _getOption("digitWidth") + "px; display:inline-block; background-image:url('" + _getOption("imagePath") + "'); background-repeat:no-repeat; ";
            var c = new Array;
            c["1"] = _getOption("digitWidth") * 0;
            c["2"] = _getOption("digitWidth") * -1;
            c["3"] = _getOption("digitWidth") * -2;
            c["4"] = _getOption("digitWidth") * -3;
            c["5"] = _getOption("digitWidth") * -4;
            c["6"] = _getOption("digitWidth") * -5;
            c["7"] = _getOption("digitWidth") * -6;
            c["8"] = _getOption("digitWidth") * -7;
            c["9"] = _getOption("digitWidth") * -8;
            c["0"] = _getOption("digitWidth") * -9;
            c["."] = _getOption("digitWidth") * -10;
            c["-"] = _getOption("digitWidth") * -11;
            c[","] = _getOption("digitWidth") * -12;
            c[" "] = _getOption("digitWidth") * -13;
            if (a in c) {
                return b + "background-position: " + c[a] + "px 0px;"
            }
            return b
        }

        function _startAnimation(a) {
            if (true == _getOption("animating")) {
                _stopAnimation()
            }
            if (typeof a !== "undefined") {
                a = $.extend(k.data("flipCounter"), a);
                k.data("flipCounter", a)
            } else {
                a = k.data("flipCounter")
            } if (false == _getOption("start_time")) {
                _setOption("start_time", (new Date).getTime())
            }
            if (false == _getOption("time")) {
                _setOption("time", 0)
            }
            if (false == _getOption("elapsed")) {
                _setOption("elapsed", "0.0")
            }
            if (false == _getOption("start_number")) {
                _setOption("start_number", _getOption("number"));
                if (false == _getOption("start_number")) {
                    _setOption("start_number", 0)
                }
            }
            _doAnimation();
            var b = _getOption("onAnimationStarted");
            if (typeof b == "function") {
                b.call(k, k)
            }
        }

        function _doAnimation() {
            var c = _getOption("start_time");
            var d = _getOption("time");
            var e = _getOption("elapsed");
            var f = _getOption("start_number");
            var g = _getOption("end_number") - _getOption("start_number");
            if (g == 0) {
                return false
            }
            var h = _getOption("duration");
            var i = _getOption("easing");
            _setOption("animating", true);

            function animation_step() {
                d += 10;
                e = Math.floor(d / 10) / 10;
                if (Math.round(e) == e) {
                    e += ".0"
                }
                _setOption("elapsed", e);
                var a = (new Date).getTime() - c - d;
                var b = 0;
                if (typeof i == "function") {
                    b = i.apply(k, [false, d, f, g, h])
                } else {
                    b = _noEasing(false, d, f, g, h)
                }
                _setOption("number", b);
                _setOption("time", d);
                _renderCounter();
                if (d < h) {
                    _setOption("interval", window.setTimeout(animation_step, 10 - a))
                } else {
                    _stopAnimation()
                }
            }
            window.setTimeout(animation_step, 10)
        }

        function _stopAnimation() {
            if (false == _getOption("animating")) {
                return false
            }
            clearTimeout(_getOption("interval"));
            _setOption("start_time", false);
            _setOption("start_number", false);
            _setOption("end_number", false);
            _setOption("time", 0);
            _setOption("animating", false);
            _setOption("paused", false);
            var a = _getOption("onAnimationStopped");
            if (typeof a == "function") {
                a.call(k, k)
            }
        }

        function _pauseAnimation() {
            if (false == _getOption("animating") || true == _getOption("paused")) {
                return false
            }
            clearTimeout(_getOption("interval"));
            _setOption("paused", true);
            var a = _getOption("onAnimationPaused");
            if (typeof a == "function") {
                a.call(k, k)
            }
        }

        function _resumeAnimation() {
            if (false == _getOption("animating") || false == _getOption("paused")) {
                return false
            }
            _setOption("paused", false);
            _doAnimation();
            var a = _getOption("onAnimationResumed");
            if (typeof a == "function") {
                a.call(k, k)
            }
        }

        function _noEasing(x, t, b, c, d) {
            return t / d * c + b
        }
    }
})(jQuery);
jQuery.fn.htmlClean = function () {
    this.contents().filter(function () {
        if (this.nodeType != 3) {
            $(this).htmlClean();
            return false
        } else {
            return !/\S/.test(this.nodeValue)
        }
    }).remove()
};

$(function() {
		$(".jpbtn").first().addClass('orange');
		$(".jpbtn").click(function(){
		$(".jpbtn").removeClass("orange").addClass("green");
		$(this).addClass("orange");
		});
		
		var warning = $(".message");

		$("#comparing").multiselect({ 
		header: i18n_compareHeaderText,
		click: function(e){
			if( $(this).multiselect("widget").find("input:checked").length > 3 ){
				warning.addClass("error").removeClass("success").html(i18n_compareWarningText);
				return false;
			} else {
				warning.addClass("success").removeClass("error").html(i18n_compareWarningText2);
			}
		},
		position: {
		my: 'left bottom',
		at: 'left top'
		}
		
		});
		
		graph();
		
	});
	
google.load('visualization', '1.1', {packages: ['corechart', 'controls'], 'language': i18n_ISO639lang});
	
	  //google.setOnLoadCallback(chooselotto('mm'));
	  
	  function chooselotto(lotto,from,to) {
	  
	  var from = Math.round(from);
	  var to = Math.round(to);
	  
	  if(isNaN(from))
	  var from = '';
	  
	  if(isNaN(to))
	  var to = '';
	  
		$.ajax({
          url: siteroot + '?graph_js_php_db=true&view=hotcold&chooselotto=yes&lotto=' + lotto + '&from=' + from + '&to=' + to,
          dataType:'script'
          });
		
      }
	  
	  function hotcold(lotto,from,to) {
	  
	  var from = Math.round(from);
	  var to = Math.round(to);
	  
	  if(isNaN(from))
	  var from = '';
	  
	  if(isNaN(to))
	  var to = '';
	  
		$.ajax({
          url: siteroot + '?graph_js_php_db=true&view=hotcold&lotto=' + lotto + '&from=' + from + '&to=' + to,
          dataType:'script'
          });
		
      }
	
	  function toggle(action) {
		
			if(action == 'jp') {
			$("#predictedjps").show();
			$("#hotcold").hide();
			} else if(action == 'hc') {
			$("#predictedjps").hide();
			$("#hotcold").show();
			chooselotto('mm');
			}
		}
		
      function graph(lotto) {

		$.ajax({
          url: siteroot + '?graph_js_php_db=true&lotto=' + lotto,
          dataType:'script',
          async: false
          });
		
      }
	
	function compare() {
	var compare = $("select[id='comparing']").val();
	
    if (!compare) {
    alert(i18n_compareMin2lottos);
    } else {
    graph(compare);
	}
	
	}