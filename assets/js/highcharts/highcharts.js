!function() {
    function a(a, b) {
        var c;
        a || (a = {});
        for (c in b)
            a[c] = b[c];
        return a;
    }
    function b() {
        var a, b = arguments, c, d = {}, e = function(a, b) {
            var c, d;
            "object" !== typeof a && (a = {});
            for (d in b)
                b.hasOwnProperty(d) && (c = b[d], a[d] = c && "object" === typeof c && "[object Array]" !== Object.prototype.toString.call(c) && "renderTo" !== d && "number" !== typeof c.nodeType ? e(a[d] || {}, c) : b[d]);
            return a;
        };
        b[0] === !0 && (d = b[1], b = Array.prototype.slice.call(b, 2));
        c = b.length;
        for (a = 0; a < c; a++)
            d = e(d, b[a]);
        return d;
    }
    function c(a, b) {
        return parseInt(a, b || 10);
    }
    function d(a) {
        return "string" === typeof a;
    }
    function e(a) {
        return a && "object" === typeof a;
    }
    function f(a) {
        return "[object Array]" === Object.prototype.toString.call(a);
    }
    function g(a) {
        return "number" === typeof a;
    }
    function h(a) {
        return N.log(a) / N.LN10;
    }
    function i(a) {
        return N.pow(10, a);
    }
    function j(a, b) {
        for (var c = a.length; c--; )
            if (a[c] === b) {
                a.splice(c, 1);
                break;
            }
    }
    function k(a) {
        return a !== K && null !== a;
    }
    function l(a, b, c) {
        var f, g;
        if (d(b))
            k(c) ? a.setAttribute(b, c) : a && a.getAttribute && (g = a.getAttribute(b));
        else if (k(b) && e(b))
            for (f in b)
                a.setAttribute(f, b[f]);
        return g;
    }
    function m(a) {
        return f(a) ? a : [a];
    }
    function n() {
        var a = arguments, b, c, d = a.length;
        for (b = 0; b < d; b++)
            if (c = a[b], c !== K && null !== c)
                return c;
    }
    function o(b, c) {
        if ($ && !eb && c && c.opacity !== K)
            c.filter = "alpha(opacity=" + 100 * c.opacity + ")";
        a(b.style, c);
    }
    function p(b, c, d, e, f) {
        b = L.createElement(b);
        c && a(b, c);
        f && o(b, {
            padding: 0,
            border: wb,
            margin: 0
        });
        d && o(b, d);
        e && e.appendChild(b);
        return b;
    }
    function q(b, c) {
        var d = function() {
            return K;
        };
        d.prototype = new b();
        a(d.prototype, c);
        return d;
    }
    function r(a, b, d, e) {
        var f = Ob.numberFormat, g = mb.lang, h = +a || 0, i = b === -1 ? (h.toString().split(".")[1] || "").length : isNaN(b = T(b)) ? 2 : b, j = d === void 0 ? g.decimalPoint : d, g = e === void 0 ? g.thousandsSep : e, k = h < 0 ? "-" : "", l = String(c(h = T(h).toFixed(i))), m = l.length > 3 ? l.length % 3 : 0;
        return f !== r ? f(a, b, d, e) : k + (m ? l.substr(0, m) + g : "") + l.substr(m).replace(/(\d{3})(?=\d)/g, "$1" + g) + (i ? j + T(h - l).toFixed(i).slice(2) : "");
    }
    function s(a, b) {
        return Array((b || 2) + 1 - String(a).length).join(0) + a;
    }
    function t(a, b, c) {
        var d = a[b];
        a[b] = function() {
            var a = Array.prototype.slice.call(arguments);
            a.unshift(d);
            return c.apply(this, a);
        };
    }
    function u(a, b) {
        for (var c = "{", d = !1, e, f, g, h, i, j = []; (c = a.indexOf(c)) !== -1; ) {
            e = a.slice(0, c);
            if (d) {
                f = e.split(":");
                g = f.shift().split(".");
                i = g.length;
                e = b;
                for (h = 0; h < i; h++)
                    e = e[g[h]];
                if (f.length)
                    f = f.join(":"), g = /\.([0-9])/, h = mb.lang, i = void 0, /f$/.test(f) ? (i = (i = f.match(g)) ? i[1] : -1,
                            null !== e && (e = r(e, i, h.decimalPoint, f.indexOf(",") > -1 ? h.thousandsSep : ""))) : e = nb(f, e);
            }
            j.push(e);
            a = a.slice(c + 1);
            c = (d = !d) ? "}" : "{";
        }
        j.push(a);
        return j.join("");
    }
    function v(a) {
        return N.pow(10, P(N.log(a) / N.LN10));
    }
    function w(a, b, c, d) {
        var e, c = n(c, 1);
        e = a / c;
        b || (b = [1, 2, 2.5, 5, 10], d === !1 && (1 === c ? b = [1, 2, 5, 10] : c <= .1 && (b = [1 / c])));
        for (d = 0; d < b.length; d++)
            if (a = b[d], e <= (b[d] + (b[d + 1] || b[d])) / 2)
                break;
        a *= c;
        return a;
    }
    function x(a, b) {
        var c = a.length, d, e;
        for (e = 0; e < c; e++)
            a[e].ss_i = e;
        a.sort(function(a, c) {
            d = b(a, c);
            return 0 === d ? a.ss_i - c.ss_i : d;
        });
        for (e = 0; e < c; e++)
            delete a[e].ss_i;
    }
    function y(a) {
        for (var b = a.length, c = a[0]; b--; )
            a[b] < c && (c = a[b]);
        return c;
    }
    function z(a) {
        for (var b = a.length, c = a[0]; b--; )
            a[b] > c && (c = a[b]);
        return c;
    }
    function A(a, b) {
        for (var c in a)
            a[c] && a[c] !== b && a[c].destroy && a[c].destroy(), delete a[c];
    }
    function B(a) {
        lb || (lb = p(vb));
        a && lb.appendChild(a);
        lb.innerHTML = "";
    }
    function C(a) {
        return parseFloat(a.toPrecision(14));
    }
    function D(a, b) {
        ob = n(a, b.animation);
    }
    function E() {
        var a = mb.global.useUTC, b = a ? "getUTC" : "get", c = a ? "setUTC" : "set";
        zb = mb.global.Date || window.Date;
        Bb = 6e4 * (a && mb.global.timezoneOffset || 0);
        Ab = a ? zb.UTC : function(a, b, c, d, e, f) {
            return new zb(a, b, n(c, 1), n(d, 0), n(e, 0), n(f, 0)).getTime();
        };
        Cb = b + "Minutes";
        Db = b + "Hours";
        Eb = b + "Day";
        Fb = b + "Date";
        Gb = b + "Month";
        Hb = b + "FullYear";
        Ib = c + "Minutes";
        Jb = c + "Hours";
        Kb = c + "Date";
        Lb = c + "Month";
        Mb = c + "FullYear";
    }
    function F() {
    }
    function G(a, b, c, d) {
        this.axis = a;
        this.pos = b;
        this.type = c || "";
        this.isNew = !0;
        !c && !d && this.addLabel();
    }
    function H() {
        this.init.apply(this, arguments);
    }
    function I() {
        this.init.apply(this, arguments);
    }
    function J(a, b, c, d, e) {
        var f = a.chart.inverted;
        this.axis = a;
        this.isNegative = c;
        this.options = b;
        this.x = d;
        this.total = null;
        this.points = {};
        this.stack = e;
        this.alignOptions = {
            align: b.align || (f ? c ? "left" : "right" : "center"),
            verticalAlign: b.verticalAlign || (f ? "middle" : c ? "bottom" : "top"),
            y: n(b.y, f ? 4 : c ? 14 : -6),
            x: n(b.x, f ? c ? -6 : 6 : 0)
        };
        this.textAlign = b.textAlign || (f ? c ? "right" : "left" : "center");
    }
    var K, L = document, M = window, N = Math, O = N.round, P = N.floor, Q = N.ceil, R = N.max, S = N.min, T = N.abs, U = N.cos, V = N.sin, W = N.PI, X = 2 * W / 360, Y = navigator.userAgent, Z = M.opera, $ = /msie/i.test(Y) && !Z, _ = 8 === L.documentMode, ab = /AppleWebKit/.test(Y), bb = /Firefox/.test(Y), cb = /(Mobile|Android|Windows Phone)/.test(Y), db = "http://www.w3.org/2000/svg", eb = !!L.createElementNS && !!L.createElementNS(db, "svg").createSVGRect, fb = bb && parseInt(Y.split("Firefox/")[1], 10) < 4, gb = !eb && !$ && !!L.createElement("canvas").getContext, hb, ib, jb = {}, kb = 0, lb, mb, nb, ob, pb, qb, rb, sb = function() {
        return K;
    }, tb = [], ub = 0, vb = "div", wb = "none", xb = /^[0-9]+$/, yb = "stroke-width", zb, Ab, Bb, Cb, Db, Eb, Fb, Gb, Hb, Ib, Jb, Kb, Lb, Mb, Nb = {}, Ob;
    M.Highcharts ? rb(16, !0) : Ob = M.Highcharts = {};
    nb = function(b, c, d) {
        if (!k(c) || isNaN(c))
            return "Invalid date";
        var b = n(b, "%Y-%m-%d %H:%M:%S"), e = new zb(c - Bb), f, g = e[Db](), h = e[Eb](), i = e[Fb](), j = e[Gb](), l = e[Hb](), m = mb.lang, o = m.weekdays, e = a({
            a: o[h].substr(0, 3),
            A: o[h],
            d: s(i),
            e: i,
            b: m.shortMonths[j],
            B: m.months[j],
            m: s(j + 1),
            y: l.toString().substr(2, 2),
            Y: l,
            H: s(g),
            I: s(g % 12 || 12),
            l: g % 12 || 12,
            M: s(e[Cb]()),
            p: g < 12 ? "AM" : "PM",
            P: g < 12 ? "am" : "pm",
            S: s(e.getSeconds()),
            L: s(O(c % 1e3), 3)
        }, Ob.dateFormats);
        for (f in e)
            for (; b.indexOf("%" + f) !== - 1; )
                b = b.replace("%" + f, "function" === typeof e[f] ? e[f](c) : e[f]);
        return d ? b.substr(0, 1).toUpperCase() + b.substr(1) : b;
    };
    rb = function(a, b) {
        var c = "Highcharts error #" + a + ": www.highcharts.com/errors/" + a;
        if (b)
            throw c;
        M.console && console.log(c);
    };
    qb = {
        millisecond: 1,
        second: 1e3,
        minute: 6e4,
        hour: 36e5,
        day: 864e5,
        week: 6048e5,
        month: 26784e5,
        year: 31556952e3
    };
    pb = {
        init: function(a, b, c) {
            var b = b || "", d = a.shift, e = b.indexOf("C") > -1, f = e ? 7 : 3, g, b = b.split(" "), c = [].concat(c), h, i, j = function(a) {
                for (g = a.length; g--; )
                    "M" === a[g] && a.splice(g + 1, 0, a[g + 1], a[g + 2], a[g + 1], a[g + 2]);
            };
            e && (j(b), j(c));
            a.isArea && (h = b.splice(b.length - 6, 6), i = c.splice(c.length - 6, 6));
            if (d <= c.length / f && b.length === c.length)
                for (; d--; )
                    c = [].concat(c).splice(0, f).concat(c);
            a.shift = 0;
            if (b.length)
                for (a = c.length; b.length < a; )
                    d = [].concat(b).splice(b.length - f, f),
                            e && (d[f - 6] = d[f - 2], d[f - 5] = d[f - 1]), b = b.concat(d);
            h && (b = b.concat(h), c = c.concat(i));
            return [b, c];
        },
        step: function(a, b, c, d) {
            var e = [], f = a.length;
            if (1 === c)
                e = d;
            else if (f === b.length && c < 1)
                for (; f--; )
                    d = parseFloat(a[f]),
                            e[f] = isNaN(d) ? a[f] : c * parseFloat(b[f] - d) + d;
            else
                e = b;
            return e;
        }
    };
    !function(b) {
        M.HighchartsAdapter = M.HighchartsAdapter || b && {
            init: function(a) {
                var c = b.fx;
                b.extend(b.easing, {
                    easeOutQuad: function(a, b, c, d, e) {
                        return -d * (b /= e) * (b - 2) + c;
                    }
                });
                b.each(["cur", "_default", "width", "height", "opacity"], function(a, d) {
                    var e = c.step, f;
                    "cur" === d ? e = c.prototype : "_default" === d && b.Tween && (e = b.Tween.propHooks[d],
                            d = "set");
                    (f = e[d]) && (e[d] = function(b) {
                        var c, b = a ? b : this;
                        if ("align" !== b.prop)
                            return c = b.elem, c.attr ? c.attr(b.prop, "cur" === d ? K : b.now) : f.apply(this, arguments);
                    });
                });
                t(b.cssHooks.opacity, "get", function(a, b, c) {
                    return b.attr ? b.opacity || 0 : a.call(this, b, c);
                });
                this.addAnimSetter("d", function(b) {
                    var c = b.elem, d;
                    if (!b.started)
                        d = a.init(c, c.d, c.toD), b.start = d[0], b.end = d[1], b.started = !0;
                    c.attr("d", a.step(b.start, b.end, b.pos, c.toD));
                });
                this.each = Array.prototype.forEach ? function(a, b) {
                    return Array.prototype.forEach.call(a, b);
                } : function(a, b) {
                    var c, d = a.length;
                    for (c = 0; c < d; c++)
                        if (b.call(a[c], a[c], c, a) === !1)
                            return c;
                };
                b.fn.highcharts = function() {
                    var a = "Chart", b = arguments, c, e;
                    if (this[0]) {
                        d(b[0]) && (a = b[0], b = Array.prototype.slice.call(b, 1));
                        c = b[0];
                        if (c !== K)
                            c.chart = c.chart || {}, c.chart.renderTo = this[0], new Ob[a](c, b[1]),
                                    e = this;
                        c === K && (e = tb[l(this[0], "data-highcharts-chart")]);
                    }
                    return e;
                };
            },
            addAnimSetter: function(a, c) {
                b.Tween ? b.Tween.propHooks[a] = {
                    set: c
                } : b.fx.step[a] = c;
            },
            getScript: b.getScript,
            inArray: b.inArray,
            adapterRun: function(a, c) {
                return b(a)[c]();
            },
            grep: b.grep,
            map: function(a, b) {
                for (var c = [], d = 0, e = a.length; d < e; d++)
                    c[d] = b.call(a[d], a[d], d, a);
                return c;
            },
            offset: function(a) {
                return b(a).offset();
            },
            addEvent: function(a, c, d) {
                b(a).bind(c, d);
            },
            removeEvent: function(a, c, d) {
                var e = L.removeEventListener ? "removeEventListener" : "detachEvent";
                L[e] && a && !a[e] && (a[e] = function() {
                });
                b(a).unbind(c, d);
            },
            fireEvent: function(c, d, e, f) {
                var g = b.Event(d), h = "detached" + d, i;
                !$ && e && (delete e.layerX, delete e.layerY, delete e.returnValue);
                a(g, e);
                c[d] && (c[h] = c[d], c[d] = null);
                b.each(["preventDefault", "stopPropagation"], function(a, b) {
                    var c = g[b];
                    g[b] = function() {
                        try {
                            c.call(g);
                        } catch (a) {
                            "preventDefault" === b && (i = !0);
                        }
                    };
                });
                b(c).trigger(g);
                c[h] && (c[d] = c[h], c[h] = null);
                f && !g.isDefaultPrevented() && !i && f(g);
            },
            washMouseEvent: function(a) {
                var b = a.originalEvent || a;
                if (b.pageX === K)
                    b.pageX = a.pageX, b.pageY = a.pageY;
                return b;
            },
            animate: function(a, c, d) {
                var e = b(a);
                if (!a.style)
                    a.style = {};
                if (c.d)
                    a.toD = c.d, c.d = 1;
                e.stop();
                c.opacity !== K && a.attr && (c.opacity += "px");
                a.hasAnim = 1;
                e.animate(c, d);
            },
            stop: function(a) {
                a.hasAnim && b(a).stop();
            }
        };
    }(M.jQuery);
    var Pb = M.HighchartsAdapter, Qb = Pb || {};
    Pb && Pb.init.call(Pb, pb);
    var Rb = Qb.adapterRun, Sb = Qb.getScript, Tb = Qb.inArray, Ub = Qb.each, Vb = Qb.grep, Wb = Qb.offset, Xb = Qb.map, Yb = Qb.addEvent, Zb = Qb.removeEvent, $b = Qb.fireEvent, _b = Qb.washMouseEvent, ac = Qb.animate, bc = Qb.stop, Qb = {
        enabled: !0,
        x: 0,
        y: 15,
        style: {
            color: "#606060",
            cursor: "default",
            fontSize: "11px"
        }
    };
    mb = {
        colors: "#7cb5ec,#434348,#90ed7d,#f7a35c,#8085e9,#f15c80,#e4d354,#8085e8,#8d4653,#91e8e1".split(","),
        symbols: ["circle", "diamond", "square", "triangle", "triangle-down"],
        lang: {
            loading: "Loading...",
            months: "January,February,March,April,May,June,July,August,September,October,November,December".split(","),
            shortMonths: "Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec".split(","),
            weekdays: "Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday".split(","),
            decimalPoint: ".",
            numericSymbols: "k,M,G,T,P,E".split(","),
            resetZoom: "Reset zoom",
            resetZoomTitle: "Reset zoom level 1:1",
            thousandsSep: ","
        },
        global: {
            useUTC: !0,
            canvasToolsURL: "http://code.highcharts.com/4.0.4/modules/canvas-tools.js",
            VMLRadialGradientURL: "http://code.highcharts.com/4.0.4/gfx/vml-radial-gradient.png"
        },
        chart: {
            borderColor: "#4572A7",
            borderRadius: 0,
            defaultSeriesType: "line",
            ignoreHiddenSeries: !0,
            spacing: [10, 10, 15, 10],
            backgroundColor: "#FFFFFF",
            plotBorderColor: "#C0C0C0",
            resetZoomButton: {
                theme: {
                    zIndex: 20
                },
                position: {
                    align: "right",
                    x: -10,
                    y: 10
                }
            }
        },
        title: {
            text: "Chart title",
            align: "center",
            margin: 15,
            style: {
                color: "#333333",
                fontSize: "18px"
            }
        },
        subtitle: {
            text: "",
            align: "center",
            style: {
                color: "#555555"
            }
        },
        plotOptions: {
            line: {
                allowPointSelect: !1,
                showCheckbox: !1,
                animation: {
                    duration: 1e3
                },
                events: {},
                lineWidth: 2,
                marker: {
                    lineWidth: 0,
                    radius: 4,
                    lineColor: "#FFFFFF",
                    states: {
                        hover: {
                            enabled: !0,
                            lineWidthPlus: 1,
                            radiusPlus: 2
                        },
                        select: {
                            fillColor: "#FFFFFF",
                            lineColor: "#000000",
                            lineWidth: 2
                        }
                    }
                },
                point: {
                    events: {}
                },
                dataLabels: b(Qb, {
                    align: "center",
                    enabled: !1,
                    formatter: function() {
                        return null === this.y ? "" : r(this.y, -1);
                    },
                    verticalAlign: "bottom",
                    y: 0
                }),
                cropThreshold: 300,
                pointRange: 0,
                states: {
                    hover: {
                        lineWidthPlus: 1,
                        marker: {},
                        halo: {
                            size: 10,
                            opacity: .25
                        }
                    },
                    select: {
                        marker: {}
                    }
                },
                stickyTracking: !0,
                turboThreshold: 1e3
            }
        },
        labels: {
            style: {
                position: "absolute",
                color: "#3E576F"
            }
        },
        legend: {
            enabled: !0,
            align: "center",
            layout: "horizontal",
            labelFormatter: function() {
                return this.name;
            },
            borderColor: "#909090",
            borderRadius: 0,
            navigation: {
                activeColor: "#274b6d",
                inactiveColor: "#CCC"
            },
            shadow: !1,
            itemStyle: {
                color: "#333333",
                fontSize: "12px",
                fontWeight: "bold"
            },
            itemHoverStyle: {
                color: "#000"
            },
            itemHiddenStyle: {
                color: "#CCC"
            },
            itemCheckboxStyle: {
                position: "absolute",
                width: "13px",
                height: "13px"
            },
            symbolPadding: 5,
            verticalAlign: "bottom",
            x: 0,
            y: 0,
            title: {
                style: {
                    fontWeight: "bold"
                }
            }
        },
        loading: {
            labelStyle: {
                fontWeight: "bold",
                position: "relative",
                top: "45%"
            },
            style: {
                position: "absolute",
                backgroundColor: "white",
                opacity: .5,
                textAlign: "center"
            }
        },
        tooltip: {
            enabled: !0,
            animation: eb,
            backgroundColor: "rgba(249, 249, 249, .85)",
            borderWidth: 1,
            borderRadius: 3,
            dateTimeLabelFormats: {
                millisecond: "%A, %b %e, %H:%M:%S.%L",
                second: "%A, %b %e, %H:%M:%S",
                minute: "%A, %b %e, %H:%M",
                hour: "%A, %b %e, %H:%M",
                day: "%A, %b %e, %Y",
                week: "Week from %A, %b %e, %Y",
                month: "%B %Y",
                year: "%Y"
            },
            headerFormat: '<span style="font-size: 10px">{point.key}</span><br/>',
            pointFormat: '<span style="color:{series.color}">●</span> {series.name}: <b>{point.y}</b><br/>',
            shadow: !0,
            snap: cb ? 25 : 10,
            style: {
                color: "#333333",
                cursor: "default",
                fontSize: "12px",
                padding: "8px",
                whiteSpace: "nowrap"
            }
        },
        credits: {
            enabled: !0,
            text: "",
            href: "",
            position: {
                align: "right",
                x: -10,
                verticalAlign: "bottom",
                y: -5
            },
            style: {
                cursor: "pointer",
                color: "#909090",
                fontSize: "9px"
            }
        }
    };
    var cc = mb.plotOptions, Pb = cc.line;
    E();
    var dc = /rgba\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]?(?:\.[0-9]+)?)\s*\)/, ec = /#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/, fc = /rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)/, gc = function(a) {
        var d = [], e, f;
        !function(a) {
            a && a.stops ? f = Xb(a.stops, function(a) {
                return gc(a[1]);
            }) : (e = dc.exec(a)) ? d = [c(e[1]), c(e[2]), c(e[3]), parseFloat(e[4], 10)] : (e = ec.exec(a)) ? d = [c(e[1], 16), c(e[2], 16), c(e[3], 16), 1] : (e = fc.exec(a)) && (d = [c(e[1]), c(e[2]), c(e[3]), 1]);
        }(a);
        return {
            get: function(c) {
                var e;
                f ? (e = b(a), e.stops = [].concat(e.stops), Ub(f, function(a, b) {
                    e.stops[b] = [e.stops[b][0], a.get(c)];
                })) : e = d && !isNaN(d[0]) ? "rgb" === c ? "rgb(" + d[0] + "," + d[1] + "," + d[2] + ")" : "a" === c ? d[3] : "rgba(" + d.join(",") + ")" : a;
                return e;
            },
            brighten: function(a) {
                if (f)
                    Ub(f, function(b) {
                        b.brighten(a);
                    });
                else if (g(a) && 0 !== a) {
                    var b;
                    for (b = 0; b < 3; b++)
                        d[b] += c(255 * a), d[b] < 0 && (d[b] = 0), d[b] > 255 && (d[b] = 255);
                }
                return this;
            },
            rgba: d,
            setOpacity: function(a) {
                d[3] = a;
                return this;
            }
        };
    };
    F.prototype = {
        opacity: 1,
        textProps: "fontSize,fontWeight,fontFamily,color,lineHeight,width,textDecoration,textShadow,HcTextStroke".split(","),
        init: function(a, b) {
            this.element = "span" === b ? p(b) : L.createElementNS(db, b);
            this.renderer = a;
        },
        animate: function(a, c, d) {
            c = n(c, ob, !0);
            bc(this);
            if (c) {
                c = b(c, {});
                if (d)
                    c.complete = d;
                ac(this, a, c);
            } else
                this.attr(a), d && d();
            return this;
        },
        colorGradient: function(a, c, d) {
            var e = this.renderer, g, h, i, j, l, m, n, o, p, q, r = [];
            a.linearGradient ? h = "linearGradient" : a.radialGradient && (h = "radialGradient");
            if (h) {
                i = a[h];
                j = e.gradients;
                m = a.stops;
                p = d.radialReference;
                f(i) && (a[h] = i = {
                    x1: i[0],
                    y1: i[1],
                    x2: i[2],
                    y2: i[3],
                    gradientUnits: "userSpaceOnUse"
                });
                "radialGradient" === h && p && !k(i.gradientUnits) && (i = b(i, {
                    cx: p[0] - p[2] / 2 + i.cx * p[2],
                    cy: p[1] - p[2] / 2 + i.cy * p[2],
                    r: i.r * p[2],
                    gradientUnits: "userSpaceOnUse"
                }));
                for (q in i)
                    "id" !== q && r.push(q, i[q]);
                for (q in m)
                    r.push(m[q]);
                r = r.join(",");
                j[r] ? a = j[r].attr("id") : (i.id = a = "highcharts-" + kb++, j[r] = l = e.createElement(h).attr(i).add(e.defs),
                        l.stops = [], Ub(m, function(a) {
                    0 === a[1].indexOf("rgba") ? (g = gc(a[1]), n = g.get("rgb"), o = g.get("a")) : (n = a[1],
                            o = 1);
                    a = e.createElement("stop").attr({
                        offset: a[0],
                        "stop-color": n,
                        "stop-opacity": o
                    }).add(l);
                    l.stops.push(a);
                }));
                d.setAttribute(c, "url(" + e.url + "#" + a + ")");
            }
        },
        attr: function(a, b) {
            var c, d, e = this.element, f, g = this, h;
            "string" === typeof a && b !== K && (c = a, a = {}, a[c] = b);
            if ("string" === typeof a)
                g = (this[a + "Getter"] || this._defaultGetter).call(this, a, e);
            else {
                for (c in a) {
                    d = a[c];
                    h = !1;
                    this.symbolName && /^(x|y|width|height|r|start|end|innerR|anchorX|anchorY)/.test(c) && (f || (this.symbolAttr(a),
                            f = !0), h = !0);
                    if (this.rotation && ("x" === c || "y" === c))
                        this.doTransform = !0;
                    h || (this[c + "Setter"] || this._defaultSetter).call(this, d, c, e);
                    this.shadows && /^(width|height|visibility|x|y|d|transform|cx|cy|r)$/.test(c) && this.updateShadows(c, d);
                }
                if (this.doTransform)
                    this.updateTransform(), this.doTransform = !1;
            }
            return g;
        },
        updateShadows: function(a, b) {
            for (var c = this.shadows, d = c.length; d--; )
                c[d].setAttribute(a, "height" === a ? R(b - (c[d].cutHeight || 0), 0) : "d" === a ? this.d : b);
        },
        addClass: function(a) {
            var b = this.element, c = l(b, "class") || "";
            c.indexOf(a) === -1 && l(b, "class", c + " " + a);
            return this;
        },
        symbolAttr: function(a) {
            var b = this;
            Ub("x,y,r,start,end,width,height,innerR,anchorX,anchorY".split(","), function(c) {
                b[c] = n(a[c], b[c]);
            });
            b.attr({
                d: b.renderer.symbols[b.symbolName](b.x, b.y, b.width, b.height, b)
            });
        },
        clip: function(a) {
            return this.attr("clip-path", a ? "url(" + this.renderer.url + "#" + a.id + ")" : wb);
        },
        crisp: function(a) {
            var b, c = {}, d, e = a.strokeWidth || this.strokeWidth || 0;
            d = O(e) % 2 / 2;
            a.x = P(a.x || this.x || 0) + d;
            a.y = P(a.y || this.y || 0) + d;
            a.width = P((a.width || this.width || 0) - 2 * d);
            a.height = P((a.height || this.height || 0) - 2 * d);
            a.strokeWidth = e;
            for (b in a)
                this[b] !== a[b] && (this[b] = c[b] = a[b]);
            return c;
        },
        css: function(b) {
            var d = this.styles, e = {}, f = this.element, g, h, i = "";
            g = !d;
            if (b && b.color)
                b.fill = b.color;
            if (d)
                for (h in b)
                    b[h] !== d[h] && (e[h] = b[h], g = !0);
            if (g) {
                g = this.textWidth = b && b.width && "text" === f.nodeName.toLowerCase() && c(b.width);
                d && (b = a(d, e));
                this.styles = b;
                g && (gb || !eb && this.renderer.forExport) && delete b.width;
                if ($ && !eb)
                    o(this.element, b);
                else {
                    d = function(a, b) {
                        return "-" + b.toLowerCase();
                    };
                    for (h in b)
                        i += h.replace(/([A-Z])/g, d) + ":" + b[h] + ";";
                    l(f, "style", i);
                }
                g && this.added && this.renderer.buildText(this);
            }
            return this;
        },
        on: function(a, b) {
            var c = this, d = c.element;
            ib && "click" === a ? (d.ontouchstart = function(a) {
                c.touchEventFired = zb.now();
                a.preventDefault();
                b.call(d, a);
            }, d.onclick = function(a) {
                (Y.indexOf("Android") === -1 || zb.now() - (c.touchEventFired || 0) > 1100) && b.call(d, a);
            }) : d["on" + a] = b;
            return this;
        },
        setRadialReference: function(a) {
            this.element.radialReference = a;
            return this;
        },
        translate: function(a, b) {
            return this.attr({
                translateX: a,
                translateY: b
            });
        },
        invert: function() {
            this.inverted = !0;
            this.updateTransform();
            return this;
        },
        updateTransform: function() {
            var a = this.translateX || 0, b = this.translateY || 0, c = this.scaleX, d = this.scaleY, e = this.inverted, f = this.rotation, g = this.element;
            e && (a += this.attr("width"), b += this.attr("height"));
            a = ["translate(" + a + "," + b + ")"];
            e ? a.push("rotate(90) scale(-1,1)") : f && a.push("rotate(" + f + " " + (g.getAttribute("x") || 0) + " " + (g.getAttribute("y") || 0) + ")");
            (k(c) || k(d)) && a.push("scale(" + n(c, 1) + " " + n(d, 1) + ")");
            a.length && g.setAttribute("transform", a.join(" "));
        },
        toFront: function() {
            var a = this.element;
            a.parentNode.appendChild(a);
            return this;
        },
        align: function(a, b, c) {
            var e, f, g, h, i = {};
            f = this.renderer;
            g = f.alignedObjects;
            if (a) {
                if (this.alignOptions = a, this.alignByTranslate = b, !c || d(c))
                    this.alignTo = e = c || "renderer",
                            j(g, this), g.push(this), c = null;
            } else
                a = this.alignOptions, b = this.alignByTranslate, e = this.alignTo;
            c = n(c, f[e], f);
            e = a.align;
            f = a.verticalAlign;
            g = (c.x || 0) + (a.x || 0);
            h = (c.y || 0) + (a.y || 0);
            if ("right" === e || "center" === e)
                g += (c.width - (a.width || 0)) / {
                    right: 1,
                    center: 2
                }[e];
            i[b ? "translateX" : "x"] = O(g);
            if ("bottom" === f || "middle" === f)
                h += (c.height - (a.height || 0)) / ({
                    bottom: 1,
                    middle: 2
                }[f] || 1);
            i[b ? "translateY" : "y"] = O(h);
            this[this.placed ? "animate" : "attr"](i);
            this.placed = !0;
            this.alignAttr = i;
            return this;
        },
        getBBox: function() {
            var b = this.bBox, c = this.renderer, d, e, f = this.rotation;
            d = this.element;
            var g = this.styles, h = f * X;
            e = this.textStr;
            var i;
            if ("" === e || xb.test(e))
                i = "num." + e.toString().length + (g ? "|" + g.fontSize + "|" + g.fontFamily : "");
            i && (b = c.cache[i]);
            if (!b) {
                if (d.namespaceURI === db || c.forExport) {
                    try {
                        b = d.getBBox ? a({}, d.getBBox()) : {
                            width: d.offsetWidth,
                            height: d.offsetHeight
                        };
                    } catch (j) {
                    }
                    if (!b || b.width < 0)
                        b = {
                            width: 0,
                            height: 0
                        };
                } else
                    b = this.htmlGetBBox();
                if (c.isSVG) {
                    d = b.width;
                    e = b.height;
                    if ($ && g && "11px" === g.fontSize && "16.9" === e.toPrecision(3))
                        b.height = e = 14;
                    if (f)
                        b.width = T(e * V(h)) + T(d * U(h)), b.height = T(e * U(h)) + T(d * V(h));
                }
                this.bBox = b;
                i && (c.cache[i] = b);
            }
            return b;
        },
        show: function(a) {
            a && this.element.namespaceURI === db ? this.element.removeAttribute("visibility") : this.attr({
                visibility: a ? "inherit" : "visible"
            });
            return this;
        },
        hide: function() {
            return this.attr({
                visibility: "hidden"
            });
        },
        fadeOut: function(a) {
            var b = this;
            b.animate({
                opacity: 0
            }, {
                duration: a || 150,
                complete: function() {
                    b.attr({
                        y: -9999
                    });
                }
            });
        },
        add: function(a) {
            var b = this.renderer, d = a || b, e = d.element || b.box, f = this.element, g = this.zIndex, h, i;
            if (a)
                this.parentGroup = a;
            this.parentInverted = a && a.inverted;
            this.textStr !== void 0 && b.buildText(this);
            if (g)
                d.handleZ = !0, g = c(g);
            if (d.handleZ) {
                a = e.childNodes;
                for (h = 0; h < a.length; h++)
                    if (b = a[h], d = l(b, "zIndex"), b !== f && (c(d) > g || !k(g) && k(d))) {
                        e.insertBefore(f, b);
                        i = !0;
                        break;
                    }
            }
            i || e.appendChild(f);
            this.added = !0;
            if (this.onAdd)
                this.onAdd();
            return this;
        },
        safeRemoveChild: function(a) {
            var b = a.parentNode;
            b && b.removeChild(a);
        },
        destroy: function() {
            var a = this, b = a.element || {}, c = a.shadows, d = a.renderer.isSVG && "SPAN" === b.nodeName && a.parentGroup, e, f;
            b.onclick = b.onmouseout = b.onmouseover = b.onmousemove = b.point = null;
            bc(a);
            if (a.clipPath)
                a.clipPath = a.clipPath.destroy();
            if (a.stops) {
                for (f = 0; f < a.stops.length; f++)
                    a.stops[f] = a.stops[f].destroy();
                a.stops = null;
            }
            a.safeRemoveChild(b);
            for (c && Ub(c, function(b) {
                a.safeRemoveChild(b);
            }); d && d.div && 0 === d.div.childNodes.length; )
                b = d.parentGroup, a.safeRemoveChild(d.div),
                        delete d.div, d = b;
            a.alignTo && j(a.renderer.alignedObjects, a);
            for (e in a)
                delete a[e];
            return null;
        },
        shadow: function(a, b, c) {
            var d = [], e, f, g = this.element, h, i, j, k;
            if (a) {
                i = n(a.width, 3);
                j = (a.opacity || .15) / i;
                k = this.parentInverted ? "(-1,-1)" : "(" + n(a.offsetX, 1) + ", " + n(a.offsetY, 1) + ")";
                for (e = 1; e <= i; e++) {
                    f = g.cloneNode(0);
                    h = 2 * i + 1 - 2 * e;
                    l(f, {
                        isShadow: "true",
                        stroke: a.color || "black",
                        "stroke-opacity": j * e,
                        "stroke-width": h,
                        transform: "translate" + k,
                        fill: wb
                    });
                    if (c)
                        l(f, "height", R(l(f, "height") - h, 0)), f.cutHeight = h;
                    b ? b.element.appendChild(f) : g.parentNode.insertBefore(f, g);
                    d.push(f);
                }
                this.shadows = d;
            }
            return this;
        },
        xGetter: function(a) {
            "circle" === this.element.nodeName && (a = {
                x: "cx",
                y: "cy"
            }[a] || a);
            return this._defaultGetter(a);
        },
        _defaultGetter: function(a) {
            a = n(this[a], this.element ? this.element.getAttribute(a) : null, 0);
            /^[\-0-9\.]+$/.test(a) && (a = parseFloat(a));
            return a;
        },
        dSetter: function(a, b, c) {
            a && a.join && (a = a.join(" "));
            /(NaN| {2}|^$)/.test(a) && (a = "M 0 0");
            c.setAttribute(b, a);
            this[b] = a;
        },
        dashstyleSetter: function(a) {
            var b;
            if (a = a && a.toLowerCase()) {
                a = a.replace("shortdashdotdot", "3,1,1,1,1,1,").replace("shortdashdot", "3,1,1,1").replace("shortdot", "1,1,").replace("shortdash", "3,1,").replace("longdash", "8,3,").replace(/dot/g, "1,3,").replace("dash", "4,3,").replace(/,$/, "").split(",");
                for (b = a.length; b--; )
                    a[b] = c(a[b]) * this["stroke-width"];
                a = a.join(",").replace("NaN", "none");
                this.element.setAttribute("stroke-dasharray", a);
            }
        },
        alignSetter: function(a) {
            this.element.setAttribute("text-anchor", {
                left: "start",
                center: "middle",
                right: "end"
            }[a]);
        },
        opacitySetter: function(a, b, c) {
            this[b] = a;
            c.setAttribute(b, a);
        },
        titleSetter: function(a) {
            var b = this.element.getElementsByTagName("title")[0];
            b || (b = L.createElementNS(db, "title"), this.element.appendChild(b));
            b.textContent = n(a, "").replace(/<[^>]*>/g, "");
        },
        textSetter: function(a) {
            if (a !== this.textStr)
                delete this.bBox, this.textStr = a, this.added && this.renderer.buildText(this);
        },
        fillSetter: function(a, b, c) {
            "string" === typeof a ? c.setAttribute(b, a) : a && this.colorGradient(a, b, c);
        },
        zIndexSetter: function(a, b, c) {
            c.setAttribute(b, a);
            this[b] = a;
        },
        _defaultSetter: function(a, b, c) {
            c.setAttribute(b, a);
        }
    };
    F.prototype.yGetter = F.prototype.xGetter;
    F.prototype.translateXSetter = F.prototype.translateYSetter = F.prototype.rotationSetter = F.prototype.verticalAlignSetter = F.prototype.scaleXSetter = F.prototype.scaleYSetter = function(a, b) {
        this[b] = a;
        this.doTransform = !0;
    };
    F.prototype["stroke-widthSetter"] = F.prototype.strokeSetter = function(a, b, c) {
        this[b] = a;
        if (this.stroke && this["stroke-width"])
            this.strokeWidth = this["stroke-width"],
                    F.prototype.fillSetter.call(this, this.stroke, "stroke", c), c.setAttribute("stroke-width", this["stroke-width"]),
                    this.hasStroke = !0;
        else if ("stroke-width" === b && 0 === a && this.hasStroke)
            c.removeAttribute("stroke"),
                    this.hasStroke = !1;
    };
    var hc = function() {
        this.init.apply(this, arguments);
    };
    hc.prototype = {
        Element: F,
        init: function(a, b, c, d, e) {
            var f = location, g, d = this.createElement("svg").attr({
                version: "1.1"
            }).css(this.getStyle(d));
            g = d.element;
            a.appendChild(g);
            a.innerHTML.indexOf("xmlns") === -1 && l(g, "xmlns", db);
            this.isSVG = !0;
            this.box = g;
            this.boxWrapper = d;
            this.alignedObjects = [];
            this.url = (bb || ab) && L.getElementsByTagName("base").length ? f.href.replace(/#.*?$/, "").replace(/([\('\)])/g, "\\$1").replace(/ /g, "%20") : "";
            this.createElement("desc").add().element.appendChild(L.createTextNode("Created with Highcharts 4.0.4"));
            this.defs = this.createElement("defs").add();
            this.forExport = e;
            this.gradients = {};
            this.cache = {};
            this.setSize(b, c, !1);
            var h;
            if (bb && a.getBoundingClientRect)
                this.subPixelFix = b = function() {
                    o(a, {
                        left: 0,
                        top: 0
                    });
                    h = a.getBoundingClientRect();
                    o(a, {
                        left: Q(h.left) - h.left + "px",
                        top: Q(h.top) - h.top + "px"
                    });
                }, b(), Yb(M, "resize", b);
        },
        getStyle: function(b) {
            return this.style = a({
                fontFamily: '"Lucida Grande", "Lucida Sans Unicode", Arial, Helvetica, sans-serif',
                fontSize: "12px"
            }, b);
        },
        isHidden: function() {
            return !this.boxWrapper.getBBox().width;
        },
        destroy: function() {
            var a = this.defs;
            this.box = null;
            this.boxWrapper = this.boxWrapper.destroy();
            A(this.gradients || {});
            this.gradients = null;
            if (a)
                this.defs = a.destroy();
            this.subPixelFix && Zb(M, "resize", this.subPixelFix);
            return this.alignedObjects = null;
        },
        createElement: function(a) {
            var b = new this.Element();
            b.init(this, a);
            return b;
        },
        draw: function() {
        },
        buildText: function(a) {
            for (var b = a.element, d = this, e = d.forExport, f = n(a.textStr, "").toString(), g = f.indexOf("<") !== -1, h = b.childNodes, i, j, k = l(b, "x"), m = a.styles, p = a.textWidth, q = m && m.lineHeight, r = m && m.HcTextStroke, s = h.length, t = function(a) {
                return q ? c(q) : d.fontMetrics(/(px|em)$/.test(a && a.style.fontSize) ? a.style.fontSize : m && m.fontSize || d.style.fontSize || 12, a).h;
            }; s--; )
                b.removeChild(h[s]);
            !g && !r && f.indexOf(" ") === -1 ? b.appendChild(L.createTextNode(f)) : (i = /<.*style="([^"]+)".*>/,
                    j = /<.*href="(http[^"]+)".*>/, p && !a.added && this.box.appendChild(b), f = g ? f.replace(/<(b|strong)>/g, '<span style="font-weight:bold">').replace(/<(i|em)>/g, '<span style="font-style:italic">').replace(/<a/g, "<span").replace(/<\/(b|strong|i|em|a)>/g, "</span>").split(/<br.*?>/g) : [f],
                    "" === f[f.length - 1] && f.pop(), Ub(f, function(c, f) {
                var g, h = 0, c = c.replace(/<span/g, "|||<span").replace(/<\/span>/g, "</span>|||");
                g = c.split("|||");
                Ub(g, function(c) {
                    if ("" !== c || 1 === g.length) {
                        var n = {}, q = L.createElementNS(db, "tspan"), r;
                        i.test(c) && (r = c.match(i)[1].replace(/(;| |^)color([ :])/, "$1fill$2"), l(q, "style", r));
                        j.test(c) && !e && (l(q, "onclick", 'location.href="' + c.match(j)[1] + '"'), o(q, {
                            cursor: "pointer"
                        }));
                        c = (c.replace(/<(.|\n)*?>/g, "") || " ").replace(/&lt;/g, "<").replace(/&gt;/g, ">");
                        if (" " !== c) {
                            q.appendChild(L.createTextNode(c));
                            if (h)
                                n.dx = 0;
                            else if (f && null !== k)
                                n.x = k;
                            l(q, n);
                            b.appendChild(q);
                            !h && f && (!eb && e && o(q, {
                                display: "block"
                            }), l(q, "dy", t(q)));
                            if (p)
                                for (var c = c.replace(/([^\^])-/g, "$1- ").split(" "), n = g.length > 1 || c.length > 1 && "nowrap" !== m.whiteSpace, s, u, v = m.HcHeight, w = [], x = t(q), y = 1; n && (c.length || w.length); )
                                    delete a.bBox,
                                            s = a.getBBox(), u = s.width, !eb && d.forExport && (u = d.measureSpanWidth(q.firstChild.data, a.styles)),
                                            s = u > p, !s || 1 === c.length ? (c = w, w = [], c.length && (y++, v && y * x > v ? (c = ["..."],
                                                    a.attr("title", a.textStr)) : (q = L.createElementNS(db, "tspan"), l(q, {
                                                dy: x,
                                                x: k
                                            }), r && l(q, "style", r), b.appendChild(q))), u > p && (p = u)) : (q.removeChild(q.firstChild),
                                            w.unshift(c.pop())), c.length && q.appendChild(L.createTextNode(c.join(" ").replace(/- /g, "-")));
                            h++;
                        }
                    }
                });
            }));
        },
        button: function(c, d, e, f, g, h, i, j, k) {
            var l = this.label(c, d, e, k, null, null, null, null, "button"), m = 0, n, o, p, q, r, s, c = {
                x1: 0,
                y1: 0,
                x2: 0,
                y2: 1
            }, g = b({
                "stroke-width": 1,
                stroke: "#CCCCCC",
                fill: {
                    linearGradient: c,
                    stops: [[0, "#FEFEFE"], [1, "#F6F6F6"]]
                },
                r: 2,
                padding: 5,
                style: {
                    color: "black"
                }
            }, g);
            p = g.style;
            delete g.style;
            h = b(g, {
                stroke: "#68A",
                fill: {
                    linearGradient: c,
                    stops: [[0, "#FFF"], [1, "#ACF"]]
                }
            }, h);
            q = h.style;
            delete h.style;
            i = b(g, {
                stroke: "#68A",
                fill: {
                    linearGradient: c,
                    stops: [[0, "#9BD"], [1, "#CDF"]]
                }
            }, i);
            r = i.style;
            delete i.style;
            j = b(g, {
                style: {
                    color: "#CCC"
                }
            }, j);
            s = j.style;
            delete j.style;
            Yb(l.element, $ ? "mouseover" : "mouseenter", function() {
                3 !== m && l.attr(h).css(q);
            });
            Yb(l.element, $ ? "mouseout" : "mouseleave", function() {
                3 !== m && (n = [g, h, i][m], o = [p, q, r][m], l.attr(n).css(o));
            });
            l.setState = function(a) {
                (l.state = m = a) ? 2 === a ? l.attr(i).css(r) : 3 === a && l.attr(j).css(s) : l.attr(g).css(p);
            };
            return l.on("click", function() {
                3 !== m && f.call(l);
            }).attr(g).css(a({
                cursor: "default"
            }, p));
        },
        crispLine: function(a, b) {
            a[1] === a[4] && (a[1] = a[4] = O(a[1]) - b % 2 / 2);
            a[2] === a[5] && (a[2] = a[5] = O(a[2]) + b % 2 / 2);
            return a;
        },
        path: function(b) {
            var c = {
                fill: wb
            };
            f(b) ? c.d = b : e(b) && a(c, b);
            return this.createElement("path").attr(c);
        },
        circle: function(a, b, c) {
            a = e(a) ? a : {
                x: a,
                y: b,
                r: c
            };
            b = this.createElement("circle");
            b.xSetter = function(a) {
                this.element.setAttribute("cx", a);
            };
            b.ySetter = function(a) {
                this.element.setAttribute("cy", a);
            };
            return b.attr(a);
        },
        arc: function(a, b, c, d, f, g) {
            if (e(a))
                b = a.y, c = a.r, d = a.innerR, f = a.start, g = a.end, a = a.x;
            a = this.symbol("arc", a || 0, b || 0, c || 0, c || 0, {
                innerR: d || 0,
                start: f || 0,
                end: g || 0
            });
            a.r = c;
            return a;
        },
        rect: function(a, b, c, d, f, g) {
            var f = e(a) ? a.r : f, h = this.createElement("rect"), a = e(a) ? a : a === K ? {} : {
                x: a,
                y: b,
                width: R(c, 0),
                height: R(d, 0)
            };
            if (g !== K)
                a.strokeWidth = g, a = h.crisp(a);
            if (f)
                a.r = f;
            h.rSetter = function(a) {
                l(this.element, {
                    rx: a,
                    ry: a
                });
            };
            return h.attr(a);
        },
        setSize: function(a, b, c) {
            var d = this.alignedObjects, e = d.length;
            this.width = a;
            this.height = b;
            for (this.boxWrapper[n(c, !0) ? "animate" : "attr"]({
            width: a,
                    height: b
            }); e--; )
                d[e].align();
        },
        g: function(a) {
            var b = this.createElement("g");
            return k(a) ? b.attr({
                "class": "highcharts-" + a
            }) : b;
        },
        image: function(b, c, d, e, f) {
            var g = {
                preserveAspectRatio: wb
            };
            arguments.length > 1 && a(g, {
                x: c,
                y: d,
                width: e,
                height: f
            });
            g = this.createElement("image").attr(g);
            g.element.setAttributeNS ? g.element.setAttributeNS("http://www.w3.org/1999/xlink", "href", b) : g.element.setAttribute("hc-svg-href", b);
            return g;
        },
        symbol: function(b, c, d, e, f, g) {
            var h, i = this.symbols[b], i = i && i(O(c), O(d), e, f, g), j = /^url\((.*?)\)$/, k, l;
            if (i)
                h = this.path(i), a(h, {
                    symbolName: b,
                    x: c,
                    y: d,
                    width: e,
                    height: f
                }), g && a(h, g);
            else if (j.test(b))
                l = function(a, b) {
                    a.element && (a.attr({
                        width: b[0],
                        height: b[1]
                    }), a.alignByTranslate || a.translate(O((e - b[0]) / 2), O((f - b[1]) / 2)));
                }, k = b.match(j)[1], b = jb[k] || g && g.width && g.height && [g.width, g.height],
                        h = this.image(k).attr({
                    x: c,
                    y: d
                }), h.isImg = !0, b ? l(h, b) : (h.attr({
                    width: 0,
                    height: 0
                }), p("img", {
                    onload: function() {
                        l(h, jb[k] = [this.width, this.height]);
                    },
                    src: k
                }));
            return h;
        },
        symbols: {
            circle: function(a, b, c, d) {
                var e = .166 * c;
                return ["M", a + c / 2, b, "C", a + c + e, b, a + c + e, b + d, a + c / 2, b + d, "C", a - e, b + d, a - e, b, a + c / 2, b, "Z"];
            },
            square: function(a, b, c, d) {
                return ["M", a, b, "L", a + c, b, a + c, b + d, a, b + d, "Z"];
            },
            triangle: function(a, b, c, d) {
                return ["M", a + c / 2, b, "L", a + c, b + d, a, b + d, "Z"];
            },
            "triangle-down": function(a, b, c, d) {
                return ["M", a, b, "L", a + c, b, a + c / 2, b + d, "Z"];
            },
            diamond: function(a, b, c, d) {
                return ["M", a + c / 2, b, "L", a + c, b + d / 2, a + c / 2, b + d, a, b + d / 2, "Z"];
            },
            arc: function(a, b, c, d, e) {
                var f = e.start, c = e.r || c || d, g = e.end - .001, d = e.innerR, h = e.open, i = U(f), j = V(f), k = U(g), g = V(g), e = e.end - f < W ? 0 : 1;
                return ["M", a + c * i, b + c * j, "A", c, c, 0, e, 1, a + c * k, b + c * g, h ? "M" : "L", a + d * k, b + d * g, "A", d, d, 0, e, 0, a + d * i, b + d * j, h ? "" : "Z"];
            },
            callout: function(a, b, c, d, e) {
                var f = S(e && e.r || 0, c, d), g = f + 6, h = e && e.anchorX, i = e && e.anchorY, e = O(e.strokeWidth || 0) % 2 / 2;
                a += e;
                b += e;
                e = ["M", a + f, b, "L", a + c - f, b, "C", a + c, b, a + c, b, a + c, b + f, "L", a + c, b + d - f, "C", a + c, b + d, a + c, b + d, a + c - f, b + d, "L", a + f, b + d, "C", a, b + d, a, b + d, a, b + d - f, "L", a, b + f, "C", a, b, a, b, a + f, b];
                h && h > c && i > b + g && i < b + d - g ? e.splice(13, 3, "L", a + c, i - 6, a + c + 6, i, a + c, i + 6, a + c, b + d - f) : h && h < 0 && i > b + g && i < b + d - g ? e.splice(33, 3, "L", a, i + 6, a - 6, i, a, i - 6, a, b + f) : i && i > d && h > a + g && h < a + c - g ? e.splice(23, 3, "L", h + 6, b + d, h, b + d + 6, h - 6, b + d, a + f, b + d) : i && i < 0 && h > a + g && h < a + c - g && e.splice(3, 3, "L", h - 6, b, h, b - 6, h + 6, b, c - f, b);
                return e;
            }
        },
        clipRect: function(a, b, c, d) {
            var e = "highcharts-" + kb++, f = this.createElement("clipPath").attr({
                id: e
            }).add(this.defs), a = this.rect(a, b, c, d, 0).add(f);
            a.id = e;
            a.clipPath = f;
            return a;
        },
        text: function(a, b, c, d) {
            var e = gb || !eb && this.forExport, f = {};
            if (d && !this.forExport)
                return this.html(a, b, c);
            f.x = Math.round(b || 0);
            if (c)
                f.y = Math.round(c);
            if (a || 0 === a)
                f.text = a;
            a = this.createElement("text").attr(f);
            e && a.css({
                position: "absolute"
            });
            if (!d)
                a.xSetter = function(a, b, c) {
                    var d = c.getElementsByTagName("tspan"), e, f = c.getAttribute(b), g;
                    for (g = 0; g < d.length; g++)
                        e = d[g], e.getAttribute(b) === f && e.setAttribute(b, a);
                    c.setAttribute(b, a);
                };
            return a;
        },
        fontMetrics: function(a, b) {
            a = a || this.style.fontSize;
            if (b && M.getComputedStyle)
                b = b.element || b, a = M.getComputedStyle(b, "").fontSize;
            var a = /px/.test(a) ? c(a) : /em/.test(a) ? 12 * parseFloat(a) : 12, d = a < 24 ? a + 4 : O(1.2 * a), e = O(.8 * d);
            return {
                h: d,
                b: e,
                f: a
            };
        },
        label: function(c, d, e, f, g, h, i, j, l) {
            function m() {
                var b, c;
                b = r.element.style;
                t = (x === void 0 || y === void 0 || q.styles.textAlign) && r.textStr && r.getBBox();
                q.width = (x || t.width || 0) + 2 * v + w;
                q.height = (y || t.height || 0) + 2 * v;
                D = v + p.fontMetrics(b && b.fontSize, r).b;
                if (E) {
                    if (!s)
                        b = O(-u * v), c = j ? -D : 0, q.box = s = f ? p.symbol(f, b, c, q.width, q.height, C) : p.rect(b, c, q.width, q.height, 0, C[yb]),
                                s.attr("fill", wb).add(q);
                    s.isImg || s.attr(a({
                        width: O(q.width),
                        height: O(q.height)
                    }, C));
                    C = null;
                }
            }
            function n() {
                var a = q.styles, a = a && a.textAlign, b = w + v * (1 - u), c;
                c = j ? 0 : D;
                if (k(x) && t && ("center" === a || "right" === a))
                    b += {
                        center: .5,
                        right: 1
                    }[a] * (x - t.width);
                if (b !== r.x || c !== r.y)
                    r.attr("x", b), c !== K && r.attr("y", c);
                r.x = b;
                r.y = c;
            }
            function o(a, b) {
                s ? s.attr(a, b) : C[a] = b;
            }
            var p = this, q = p.g(l), r = p.text("", 0, 0, i).attr({
                zIndex: 1
            }), s, t, u = 0, v = 3, w = 0, x, y, z, A, B = 0, C = {}, D, E;
            q.onAdd = function() {
                r.add(q);
                q.attr({
                    text: c || 0 === c ? c : "",
                    x: d,
                    y: e
                });
                s && k(g) && q.attr({
                    anchorX: g,
                    anchorY: h
                });
            };
            q.widthSetter = function(a) {
                x = a;
            };
            q.heightSetter = function(a) {
                y = a;
            };
            q.paddingSetter = function(a) {
                k(a) && a !== v && (v = a, n());
            };
            q.paddingLeftSetter = function(a) {
                k(a) && a !== w && (w = a, n());
            };
            q.alignSetter = function(a) {
                u = {
                    left: 0,
                    center: .5,
                    right: 1
                }[a];
            };
            q.textSetter = function(a) {
                a !== K && r.textSetter(a);
                m();
                n();
            };
            q["stroke-widthSetter"] = function(a, b) {
                a && (E = !0);
                B = a % 2 / 2;
                o(b, a);
            };
            q.strokeSetter = q.fillSetter = q.rSetter = function(a, b) {
                "fill" === b && a && (E = !0);
                o(b, a);
            };
            q.anchorXSetter = function(a, b) {
                g = a;
                o(b, a + B - z);
            };
            q.anchorYSetter = function(a, b) {
                h = a;
                o(b, a - A);
            };
            q.xSetter = function(a) {
                q.x = a;
                u && (a -= u * ((x || t.width) + v));
                z = O(a);
                q.attr("translateX", z);
            };
            q.ySetter = function(a) {
                A = q.y = O(a);
                q.attr("translateY", A);
            };
            var G = q.css;
            return a(q, {
                css: function(a) {
                    if (a) {
                        var c = {}, a = b(a);
                        Ub(q.textProps, function(b) {
                            a[b] !== K && (c[b] = a[b], delete a[b]);
                        });
                        r.css(c);
                    }
                    return G.call(q, a);
                },
                getBBox: function() {
                    return {
                        width: t.width + 2 * v,
                        height: t.height + 2 * v,
                        x: t.x - v,
                        y: t.y - v
                    };
                },
                shadow: function(a) {
                    s && s.shadow(a);
                    return q;
                },
                destroy: function() {
                    Zb(q.element, "mouseenter");
                    Zb(q.element, "mouseleave");
                    r && (r = r.destroy());
                    s && (s = s.destroy());
                    F.prototype.destroy.call(q);
                    q = p = m = n = o = null;
                }
            });
        }
    };
    hb = hc;
    a(F.prototype, {
        htmlCss: function(b) {
            var c = this.element;
            if (c = b && "SPAN" === c.tagName && b.width)
                delete b.width, this.textWidth = c,
                        this.updateTransform();
            this.styles = a(this.styles, b);
            o(this.element, b);
            return this;
        },
        htmlGetBBox: function() {
            var a = this.element, b = this.bBox;
            if (!b) {
                if ("text" === a.nodeName)
                    a.style.position = "absolute";
                b = this.bBox = {
                    x: a.offsetLeft,
                    y: a.offsetTop,
                    width: a.offsetWidth,
                    height: a.offsetHeight
                };
            }
            return b;
        },
        htmlUpdateTransform: function() {
            if (this.added) {
                var a = this.renderer, b = this.element, d = this.translateX || 0, e = this.translateY || 0, f = this.x || 0, g = this.y || 0, h = this.textAlign || "left", i = {
                    left: 0,
                    center: .5,
                    right: 1
                }[h], j = this.shadows;
                o(b, {
                    marginLeft: d,
                    marginTop: e
                });
                j && Ub(j, function(a) {
                    o(a, {
                        marginLeft: d + 1,
                        marginTop: e + 1
                    });
                });
                this.inverted && Ub(b.childNodes, function(c) {
                    a.invertChild(c, b);
                });
                if ("SPAN" === b.tagName) {
                    var l = this.rotation, m, p = c(this.textWidth), q = [l, h, b.innerHTML, this.textWidth].join(",");
                    if (q !== this.cTT) {
                        m = a.fontMetrics(b.style.fontSize).b;
                        k(l) && this.setSpanRotation(l, i, m);
                        j = n(this.elemWidth, b.offsetWidth);
                        if (j > p && /[ \-]/.test(b.textContent || b.innerText))
                            o(b, {
                                width: p + "px",
                                display: "block",
                                whiteSpace: "normal"
                            }), j = p;
                        this.getSpanCorrection(j, m, i, l, h);
                    }
                    o(b, {
                        left: f + (this.xCorr || 0) + "px",
                        top: g + (this.yCorr || 0) + "px"
                    });
                    if (ab)
                        m = b.offsetHeight;
                    this.cTT = q;
                }
            } else
                this.alignOnAdd = !0;
        },
        setSpanRotation: function(a, b, c) {
            var d = {}, e = $ ? "-ms-transform" : ab ? "-webkit-transform" : bb ? "MozTransform" : Z ? "-o-transform" : "";
            d[e] = d.transform = "rotate(" + a + "deg)";
            d[e + (bb ? "Origin" : "-origin")] = d.transformOrigin = 100 * b + "% " + c + "px";
            o(this.element, d);
        },
        getSpanCorrection: function(a, b, c) {
            this.xCorr = -a * c;
            this.yCorr = -b;
        }
    });
    a(hc.prototype, {
        html: function(b, c, d) {
            var e = this.createElement("span"), f = e.element, g = e.renderer;
            e.textSetter = function(a) {
                a !== f.innerHTML && delete this.bBox;
                f.innerHTML = this.textStr = a;
            };
            e.xSetter = e.ySetter = e.alignSetter = e.rotationSetter = function(a, b) {
                "align" === b && (b = "textAlign");
                e[b] = a;
                e.htmlUpdateTransform();
            };
            e.attr({
                text: b,
                x: O(c),
                y: O(d)
            }).css({
                position: "absolute",
                whiteSpace: "nowrap",
                fontFamily: this.style.fontFamily,
                fontSize: this.style.fontSize
            });
            e.css = e.htmlCss;
            if (g.isSVG)
                e.add = function(b) {
                    var c, d = g.box.parentNode, h = [];
                    if (this.parentGroup = b) {
                        if (c = b.div, !c) {
                            for (; b; )
                                h.push(b), b = b.parentGroup;
                            Ub(h.reverse(), function(b) {
                                var e;
                                c = b.div = b.div || p(vb, {
                                    className: l(b.element, "class")
                                }, {
                                    position: "absolute",
                                    left: (b.translateX || 0) + "px",
                                    top: (b.translateY || 0) + "px"
                                }, c || d);
                                e = c.style;
                                a(b, {
                                    translateXSetter: function(a, c) {
                                        e.left = a + "px";
                                        b[c] = a;
                                        b.doTransform = !0;
                                    },
                                    translateYSetter: function(a, c) {
                                        e.top = a + "px";
                                        b[c] = a;
                                        b.doTransform = !0;
                                    },
                                    visibilitySetter: function(a, b) {
                                        e[b] = a;
                                    }
                                });
                            });
                        }
                    } else
                        c = d;
                    c.appendChild(f);
                    e.added = !0;
                    e.alignOnAdd && e.htmlUpdateTransform();
                    return e;
                };
            return e;
        }
    });
    var ic;
    if (!eb && !gb) {
        ic = {
            init: function(a, b) {
                var c = ["<", b, ' filled="f" stroked="f"'], d = ["position: ", "absolute", ";"], e = b === vb;
                ("shape" === b || e) && d.push("left:0;top:0;width:1px;height:1px;");
                d.push("visibility: ", e ? "hidden" : "visible");
                c.push(' style="', d.join(""), '"/>');
                if (b)
                    c = e || "span" === b || "img" === b ? c.join("") : a.prepVML(c), this.element = p(c);
                this.renderer = a;
            },
            add: function(a) {
                var b = this.renderer, c = this.element, d = b.box, d = a ? a.element || a : d;
                a && a.inverted && b.invertChild(c, d);
                d.appendChild(c);
                this.added = !0;
                this.alignOnAdd && !this.deferUpdateTransform && this.updateTransform();
                if (this.onAdd)
                    this.onAdd();
                return this;
            },
            updateTransform: F.prototype.htmlUpdateTransform,
            setSpanRotation: function() {
                var a = this.rotation, b = U(a * X), c = V(a * X);
                o(this.element, {
                    filter: a ? ["progid:DXImageTransform.Microsoft.Matrix(M11=", b, ", M12=", -c, ", M21=", c, ", M22=", b, ", sizingMethod='auto expand')"].join("") : wb
                });
            },
            getSpanCorrection: function(a, b, c, d, e) {
                var f = d ? U(d * X) : 1, g = d ? V(d * X) : 0, h = n(this.elemHeight, this.element.offsetHeight), i;
                this.xCorr = f < 0 && -a;
                this.yCorr = g < 0 && -h;
                i = f * g < 0;
                this.xCorr += g * b * (i ? 1 - c : c);
                this.yCorr -= f * b * (d ? i ? c : 1 - c : 1);
                e && "left" !== e && (this.xCorr -= a * c * (f < 0 ? -1 : 1), d && (this.yCorr -= h * c * (g < 0 ? -1 : 1)),
                        o(this.element, {
                            textAlign: e
                        }));
            },
            pathToVML: function(a) {
                for (var b = a.length, c = []; b--; )
                    if (g(a[b]))
                        c[b] = O(10 * a[b]) - 5;
                    else if ("Z" === a[b])
                        c[b] = "x";
                    else if (c[b] = a[b],
                            a.isArc && ("wa" === a[b] || "at" === a[b]))
                        c[b + 5] === c[b + 7] && (c[b + 7] += a[b + 7] > a[b + 5] ? 1 : -1),
                                c[b + 6] === c[b + 8] && (c[b + 8] += a[b + 8] > a[b + 6] ? 1 : -1);
                return c.join(" ") || "x";
            },
            clip: function(a) {
                var b = this, c;
                a ? (c = a.members, j(c, b), c.push(b), b.destroyClip = function() {
                    j(c, b);
                }, a = a.getCSS(b)) : (b.destroyClip && b.destroyClip(), a = {
                    clip: _ ? "inherit" : "rect(auto)"
                });
                return b.css(a);
            },
            css: F.prototype.htmlCss,
            safeRemoveChild: function(a) {
                a.parentNode && B(a);
            },
            destroy: function() {
                this.destroyClip && this.destroyClip();
                return F.prototype.destroy.apply(this);
            },
            on: function(a, b) {
                this.element["on" + a] = function() {
                    var a = M.event;
                    a.target = a.srcElement;
                    b(a);
                };
                return this;
            },
            cutOffPath: function(a, b) {
                var d, a = a.split(/[ ,]/);
                d = a.length;
                if (9 === d || 11 === d)
                    a[d - 4] = a[d - 2] = c(a[d - 2]) - 10 * b;
                return a.join(" ");
            },
            shadow: function(a, b, d) {
                var e = [], f, g = this.element, h = this.renderer, i, j = g.style, k, l = g.path, m, o, q, r;
                l && "string" !== typeof l.value && (l = "x");
                o = l;
                if (a) {
                    q = n(a.width, 3);
                    r = (a.opacity || .15) / q;
                    for (f = 1; f <= 3; f++) {
                        m = 2 * q + 1 - 2 * f;
                        d && (o = this.cutOffPath(l.value, m + .5));
                        k = ['<shape isShadow="true" strokeweight="', m, '" filled="false" path="', o, '" coordsize="10 10" style="', g.style.cssText, '" />'];
                        i = p(h.prepVML(k), null, {
                            left: c(j.left) + n(a.offsetX, 1),
                            top: c(j.top) + n(a.offsetY, 1)
                        });
                        if (d)
                            i.cutOff = m + 1;
                        k = ['<stroke color="', a.color || "black", '" opacity="', r * f, '"/>'];
                        p(h.prepVML(k), null, null, i);
                        b ? b.element.appendChild(i) : g.parentNode.insertBefore(i, g);
                        e.push(i);
                    }
                    this.shadows = e;
                }
                return this;
            },
            updateShadows: sb,
            setAttr: function(a, b) {
                _ ? this.element[a] = b : this.element.setAttribute(a, b);
            },
            classSetter: function(a) {
                this.element.className = a;
            },
            dashstyleSetter: function(a, b, c) {
                (c.getElementsByTagName("stroke")[0] || p(this.renderer.prepVML(["<stroke/>"]), null, null, c))[b] = a || "solid";
                this[b] = a;
            },
            dSetter: function(a, b, c) {
                var d = this.shadows, a = a || [];
                this.d = a.join && a.join(" ");
                c.path = a = this.pathToVML(a);
                if (d)
                    for (c = d.length; c--; )
                        d[c].path = d[c].cutOff ? this.cutOffPath(a, d[c].cutOff) : a;
                this.setAttr(b, a);
            },
            fillSetter: function(a, b, c) {
                var d = c.nodeName;
                if ("SPAN" === d)
                    c.style.color = a;
                else if ("IMG" !== d)
                    c.filled = a !== wb,
                            this.setAttr("fillcolor", this.renderer.color(a, c, b, this));
            },
            opacitySetter: sb,
            rotationSetter: function(a, b, c) {
                c = c.style;
                this[b] = c[b] = a;
                c.left = -O(V(a * X) + 1) + "px";
                c.top = O(U(a * X)) + "px";
            },
            strokeSetter: function(a, b, c) {
                this.setAttr("strokecolor", this.renderer.color(a, c, b));
            },
            "stroke-widthSetter": function(a, b, c) {
                c.stroked = !!a;
                this[b] = a;
                g(a) && (a += "px");
                this.setAttr("strokeweight", a);
            },
            titleSetter: function(a, b) {
                this.setAttr(b, a);
            },
            visibilitySetter: function(a, b, c) {
                "inherit" === a && (a = "visible");
                this.shadows && Ub(this.shadows, function(c) {
                    c.style[b] = a;
                });
                "DIV" === c.nodeName && (a = "hidden" === a ? "-999em" : 0, _ || (c.style[b] = a ? "visible" : "hidden"),
                        b = "top");
                c.style[b] = a;
            },
            xSetter: function(a, b, c) {
                this[b] = a;
                "x" === b ? b = "left" : "y" === b && (b = "top");
                this.updateClipping ? (this[b] = a, this.updateClipping()) : c.style[b] = a;
            },
            zIndexSetter: function(a, b, c) {
                c.style[b] = a;
            }
        };
        Ob.VMLElement = ic = q(F, ic);
        ic.prototype.ySetter = ic.prototype.widthSetter = ic.prototype.heightSetter = ic.prototype.xSetter;
        var jc = {
            Element: ic,
            isIE8: Y.indexOf("MSIE 8.0") > -1,
            init: function(b, c, d, e) {
                var f;
                this.alignedObjects = [];
                e = this.createElement(vb).css(a(this.getStyle(e), {
                    position: "relative"
                }));
                f = e.element;
                b.appendChild(e.element);
                this.isVML = !0;
                this.box = f;
                this.boxWrapper = e;
                this.cache = {};
                this.setSize(c, d, !1);
                if (!L.namespaces.hcv) {
                    L.namespaces.add("hcv", "urn:schemas-microsoft-com:vml");
                    try {
                        L.createStyleSheet().cssText = "hcv\\:fill, hcv\\:path, hcv\\:shape, hcv\\:stroke{ behavior:url(#default#VML); display: inline-block; } ";
                    } catch (g) {
                        L.styleSheets[0].cssText += "hcv\\:fill, hcv\\:path, hcv\\:shape, hcv\\:stroke{ behavior:url(#default#VML); display: inline-block; } ";
                    }
                }
            },
            isHidden: function() {
                return !this.box.offsetWidth;
            },
            clipRect: function(b, c, d, f) {
                var g = this.createElement(), h = e(b);
                return a(g, {
                    members: [],
                    left: (h ? b.x : b) + 1,
                    top: (h ? b.y : c) + 1,
                    width: (h ? b.width : d) - 1,
                    height: (h ? b.height : f) - 1,
                    getCSS: function(b) {
                        var c = b.element, d = c.nodeName, b = b.inverted, e = this.top - ("shape" === d ? c.offsetTop : 0), f = this.left, c = f + this.width, g = e + this.height, e = {
                            clip: "rect(" + O(b ? f : e) + "px," + O(b ? g : c) + "px," + O(b ? c : g) + "px," + O(b ? e : f) + "px)"
                        };
                        !b && _ && "DIV" === d && a(e, {
                            width: c + "px",
                            height: g + "px"
                        });
                        return e;
                    },
                    updateClipping: function() {
                        Ub(g.members, function(a) {
                            a.element && a.css(g.getCSS(a));
                        });
                    }
                });
            },
            color: function(a, b, c, d) {
                var e = this, f, g = /^rgba/, h, i, j = wb;
                a && a.linearGradient ? i = "gradient" : a && a.radialGradient && (i = "pattern");
                if (i) {
                    var k, l, m = a.linearGradient || a.radialGradient, n, o, q, r, s, t = "", a = a.stops, u, v = [], w = function() {
                        h = ['<fill colors="' + v.join(",") + '" opacity="', q, '" o:opacity2="', o, '" type="', i, '" ', t, 'focus="100%" method="any" />'];
                        p(e.prepVML(h), null, null, b);
                    };
                    n = a[0];
                    u = a[a.length - 1];
                    n[0] > 0 && a.unshift([0, n[1]]);
                    u[0] < 1 && a.push([1, u[1]]);
                    Ub(a, function(a, b) {
                        g.test(a[1]) ? (f = gc(a[1]), k = f.get("rgb"), l = f.get("a")) : (k = a[1], l = 1);
                        v.push(100 * a[0] + "% " + k);
                        b ? (q = l, r = k) : (o = l, s = k);
                    });
                    if ("fill" === c)
                        if ("gradient" === i)
                            c = m.x1 || m[0] || 0, a = m.y1 || m[1] || 0,
                                    n = m.x2 || m[2] || 0, m = m.y2 || m[3] || 0, t = 'angle="' + (90 - 180 * N.atan((m - a) / (n - c)) / W) + '"',
                                    w();
                        else {
                            var j = m.r, x = 2 * j, y = 2 * j, z = m.cx, A = m.cy, B = b.radialReference, C, j = function() {
                                B && (C = d.getBBox(), z += (B[0] - C.x) / C.width - .5, A += (B[1] - C.y) / C.height - .5,
                                        x *= B[2] / C.width, y *= B[2] / C.height);
                                t = 'src="' + mb.global.VMLRadialGradientURL + '" size="' + x + "," + y + '" origin="0.5,0.5" position="' + z + "," + A + '" color2="' + s + '" ';
                                w();
                            };
                            d.added ? j() : d.onAdd = j;
                            j = r;
                        }
                    else
                        j = k;
                } else if (g.test(a) && "IMG" !== b.tagName)
                    f = gc(a), h = ["<", c, ' opacity="', f.get("a"), '"/>'],
                            p(this.prepVML(h), null, null, b), j = f.get("rgb");
                else {
                    j = b.getElementsByTagName(c);
                    if (j.length)
                        j[0].opacity = 1, j[0].type = "solid";
                    j = a;
                }
                return j;
            },
            prepVML: function(a) {
                var b = this.isIE8, a = a.join("");
                b ? (a = a.replace("/>", ' xmlns="urn:schemas-microsoft-com:vml" />'), a = a.indexOf('style="') === -1 ? a.replace("/>", ' style="display:inline-block;behavior:url(#default#VML);" />') : a.replace('style="', 'style="display:inline-block;behavior:url(#default#VML);')) : a = a.replace("<", "<hcv:");
                return a;
            },
            text: hc.prototype.html,
            path: function(b) {
                var c = {
                    coordsize: "10 10"
                };
                f(b) ? c.d = b : e(b) && a(c, b);
                return this.createElement("shape").attr(c);
            },
            circle: function(a, b, c) {
                var d = this.symbol("circle");
                if (e(a))
                    c = a.r, b = a.y, a = a.x;
                d.isCircle = !0;
                d.r = c;
                return d.attr({
                    x: a,
                    y: b
                });
            },
            g: function(a) {
                var b;
                a && (b = {
                    className: "highcharts-" + a,
                    "class": "highcharts-" + a
                });
                return this.createElement(vb).attr(b);
            },
            image: function(a, b, c, d, e) {
                var f = this.createElement("img").attr({
                    src: a
                });
                arguments.length > 1 && f.attr({
                    x: b,
                    y: c,
                    width: d,
                    height: e
                });
                return f;
            },
            createElement: function(a) {
                return "rect" === a ? this.symbol(a) : hc.prototype.createElement.call(this, a);
            },
            invertChild: function(a, b) {
                var d = this, e = b.style, f = "IMG" === a.tagName && a.style;
                o(a, {
                    flip: "x",
                    left: c(e.width) - (f ? c(f.top) : 1),
                    top: c(e.height) - (f ? c(f.left) : 1),
                    rotation: -90
                });
                Ub(a.childNodes, function(b) {
                    d.invertChild(b, a);
                });
            },
            symbols: {
                arc: function(a, b, c, d, e) {
                    var f = e.start, g = e.end, h = e.r || c || d, c = e.innerR, d = U(f), i = V(f), j = U(g), k = V(g);
                    if (g - f === 0)
                        return ["x"];
                    f = ["wa", a - h, b - h, a + h, b + h, a + h * d, b + h * i, a + h * j, b + h * k];
                    e.open && !c && f.push("e", "M", a, b);
                    f.push("at", a - c, b - c, a + c, b + c, a + c * j, b + c * k, a + c * d, b + c * i, "x", "e");
                    f.isArc = !0;
                    return f;
                },
                circle: function(a, b, c, d, e) {
                    e && (c = d = 2 * e.r);
                    e && e.isCircle && (a -= c / 2, b -= d / 2);
                    return ["wa", a, b, a + c, b + d, a + c, b + d / 2, a + c, b + d / 2, "e"];
                },
                rect: function(a, b, c, d, e) {
                    return hc.prototype.symbols[!k(e) || !e.r ? "square" : "callout"].call(0, a, b, c, d, e);
                }
            }
        };
        Ob.VMLRenderer = ic = function() {
            this.init.apply(this, arguments);
        };
        ic.prototype = b(hc.prototype, jc);
        hb = ic;
    }
    hc.prototype.measureSpanWidth = function(a, b) {
        var c = L.createElement("span"), d;
        d = L.createTextNode(a);
        c.appendChild(d);
        o(c, b);
        this.box.appendChild(c);
        d = c.offsetWidth;
        B(c);
        return d;
    };
    var kc;
    if (gb)
        Ob.CanVGRenderer = ic = function() {
            db = "http://www.w3.org/1999/xhtml";
        }, ic.prototype.symbols = {}, kc = function() {
            function a() {
                var a = b.length, c;
                for (c = 0; c < a; c++)
                    b[c]();
                b = [];
            }
            var b = [];
            return {
                push: function(c, d) {
                    0 === b.length && Sb(d, a);
                    b.push(c);
                }
            };
        }(), hb = ic;
    G.prototype = {
        addLabel: function() {
            var b = this.axis, c = b.options, d = b.chart, e = b.horiz, f = b.categories, h = b.names, j = this.pos, l = c.labels, m = l.rotation, o = b.tickPositions, e = e && f && !l.step && !l.staggerLines && !l.rotation && d.plotWidth / o.length || !e && (d.margin[3] || .33 * d.chartWidth), p = j === o[0], q = j === o[o.length - 1], r, h = f ? n(f[j], h[j], j) : j, f = this.label, s = o.info;
            b.isDatetimeAxis && s && (r = c.dateTimeLabelFormats[s.higherRanks[j] || s.unitName]);
            this.isFirst = p;
            this.isLast = q;
            c = b.labelFormatter.call({
                axis: b,
                chart: d,
                isFirst: p,
                isLast: q,
                dateTimeLabelFormat: r,
                value: b.isLog ? C(i(h)) : h
            });
            j = e && {
                width: R(1, O(e - 2 * (l.padding || 10))) + "px"
            };
            if (k(f))
                f && f.attr({
                    text: c
                }).css(j);
            else {
                r = {
                    align: b.labelAlign
                };
                if (g(m))
                    r.rotation = m;
                if (e && l.ellipsis)
                    j.HcHeight = b.len / o.length;
                this.label = f = k(c) && l.enabled ? d.renderer.text(c, 0, 0, l.useHTML).attr(r).css(a(j, l.style)).add(b.labelGroup) : null;
                b.tickBaseline = d.renderer.fontMetrics(l.style.fontSize, f).b;
                m && 2 === b.side && (b.tickBaseline *= U(m * X));
            }
            this.yOffset = f ? n(l.y, b.tickBaseline + (2 === b.side ? 8 : -(f.getBBox().height / 2))) : 0;
        },
        getLabelSize: function() {
            var a = this.label, b = this.axis;
            return a ? a.getBBox()[b.horiz ? "height" : "width"] : 0;
        },
        getLabelSides: function() {
            var a = this.label.getBBox(), b = this.axis, c = b.horiz, d = b.options.labels, a = c ? a.width : a.height, b = c ? d.x - a * {
                left: 0,
                center: .5,
                right: 1
            }[b.labelAlign] : 0;
            return [b, c ? a + b : a];
        },
        handleOverflow: function(a, b) {
            var c = !0, d = this.axis, e = this.isFirst, f = this.isLast, g = d.horiz ? b.x : b.y, h = d.reversed, i = d.tickPositions, j = this.getLabelSides(), k = j[0], j = j[1], l, m, n, o = this.label.line;
            l = o || 0;
            m = d.labelEdge;
            n = d.justifyLabels && (e || f);
            m[l] === K || g + k > m[l] ? m[l] = g + j : n || (c = !1);
            if (n) {
                l = (m = d.justifyToPlot) ? d.pos : 0;
                m = m ? l + d.len : d.chart.chartWidth;
                do
                    a += e ? 1 : -1, n = d.ticks[i[a]];
                while (i[a] && (!n || !n.label || n.label.line !== o));
                d = n && n.label.xy && n.label.xy.x + n.getLabelSides()[e ? 0 : 1];
                e && !h || f && h ? g + k < l && (g = l - k, n && g + j > d && (c = !1)) : g + j > m && (g = m - j,
                        n && g + k < d && (c = !1));
                b.x = g;
            }
            return c;
        },
        getPosition: function(a, b, c, d) {
            var e = this.axis, f = e.chart, g = d && f.oldChartHeight || f.chartHeight;
            return {
                x: a ? e.translate(b + c, null, null, d) + e.transB : e.left + e.offset + (e.opposite ? (d && f.oldChartWidth || f.chartWidth) - e.right - e.left : 0),
                y: a ? g - e.bottom + e.offset - (e.opposite ? e.height : 0) : g - e.translate(b + c, null, null, d) - e.transB
            };
        },
        getLabelPosition: function(a, b, c, d, e, f, g, h) {
            var i = this.axis, j = i.transA, k = i.reversed, l = i.staggerLines, a = a + e.x - (f && d ? f * j * (k ? -1 : 1) : 0), b = b + this.yOffset - (f && !d ? f * j * (k ? 1 : -1) : 0);
            if (l)
                c.line = g / (h || 1) % l, b += c.line * (i.labelOffset / l);
            return {
                x: a,
                y: b
            };
        },
        getMarkPath: function(a, b, c, d, e, f) {
            return f.crispLine(["M", a, b, "L", a + (e ? 0 : -c), b + (e ? c : 0)], d);
        },
        render: function(a, b, c) {
            var d = this.axis, e = d.options, f = d.chart.renderer, g = d.horiz, h = this.type, i = this.label, j = this.pos, k = e.labels, l = this.gridLine, m = h ? h + "Grid" : "grid", o = h ? h + "Tick" : "tick", p = e[m + "LineWidth"], q = e[m + "LineColor"], r = e[m + "LineDashStyle"], s = e[o + "Length"], m = e[o + "Width"] || 0, t = e[o + "Color"], u = e[o + "Position"], o = this.mark, v = k.step, w = !0, x = d.tickmarkOffset, y = this.getPosition(g, j, x, b), z = y.x, y = y.y, A = g && z === d.pos + d.len || !g && y === d.pos ? -1 : 1, c = n(c, 1);
            this.isActive = !0;
            if (p) {
                j = d.getPlotLinePath(j + x, p * A, b, !0);
                if (l === K) {
                    l = {
                        stroke: q,
                        "stroke-width": p
                    };
                    if (r)
                        l.dashstyle = r;
                    if (!h)
                        l.zIndex = 1;
                    if (b)
                        l.opacity = 0;
                    this.gridLine = l = p ? f.path(j).attr(l).add(d.gridGroup) : null;
                }
                if (!b && l && j)
                    l[this.isNew ? "attr" : "animate"]({
                        d: j,
                        opacity: c
                    });
            }
            if (m && s)
                "inside" === u && (s = -s), d.opposite && (s = -s), h = this.getMarkPath(z, y, s, m * A, g, f),
                        o ? o.animate({
                            d: h,
                            opacity: c
                        }) : this.mark = f.path(h).attr({
                    stroke: t,
                    "stroke-width": m,
                    opacity: c
                }).add(d.axisGroup);
            if (i && !isNaN(z))
                i.xy = y = this.getLabelPosition(z, y, i, g, k, x, a, v), this.isFirst && !this.isLast && !n(e.showFirstLabel, 1) || this.isLast && !this.isFirst && !n(e.showLastLabel, 1) ? w = !1 : !d.isRadial && !k.step && !k.rotation && !b && 0 !== c && (w = this.handleOverflow(a, y)),
                        v && a % v && (w = !1), w && !isNaN(y.y) ? (y.opacity = c, i[this.isNew ? "attr" : "animate"](y),
                        this.isNew = !1) : i.attr("y", -9999);
        },
        destroy: function() {
            A(this, this.axis);
        }
    };
    Ob.PlotLineOrBand = function(a, b) {
        this.axis = a;
        if (b)
            this.options = b, this.id = b.id;
    };
    Ob.PlotLineOrBand.prototype = {
        render: function() {
            var a = this, c = a.axis, d = c.horiz, e = (c.pointRange || 0) / 2, f = a.options, g = f.label, i = a.label, j = f.width, l = f.to, m = f.from, n = k(m) && k(l), o = f.value, p = f.dashStyle, q = a.svgElem, r = [], s, t = f.color, u = f.zIndex, v = f.events, w = {}, x = c.chart.renderer;
            c.isLog && (m = h(m), l = h(l), o = h(o));
            if (j) {
                if (r = c.getPlotLinePath(o, j), w = {
                    stroke: t,
                    "stroke-width": j
                }, p)
                    w.dashstyle = p;
            } else if (n) {
                m = R(m, c.min - e);
                l = S(l, c.max + e);
                r = c.getPlotBandPath(m, l, f);
                if (t)
                    w.fill = t;
                if (f.borderWidth)
                    w.stroke = f.borderColor, w["stroke-width"] = f.borderWidth;
            } else
                return;
            if (k(u))
                w.zIndex = u;
            if (q) {
                if (r)
                    q.animate({
                        d: r
                    }, null, q.onGetPath);
                else if (q.hide(), q.onGetPath = function() {
                    q.show();
                }, i)
                    a.label = i = i.destroy();
            } else if (r && r.length && (a.svgElem = q = x.path(r).attr(w).add(), v))
                for (s in e = function(b) {
                    q.on(b, function(c) {
                        v[b].apply(a, [c]);
                    });
                }, v)
                    e(s);
            if (g && k(g.text) && r && r.length && c.width > 0 && c.height > 0) {
                g = b({
                    align: d && n && "center",
                    x: d ? !n && 4 : 10,
                    verticalAlign: !d && n && "middle",
                    y: d ? n ? 16 : 10 : n ? 6 : -4,
                    rotation: d && !n && 90
                }, g);
                if (!i) {
                    w = {
                        align: g.textAlign || g.align,
                        rotation: g.rotation
                    };
                    if (k(u))
                        w.zIndex = u;
                    a.label = i = x.text(g.text, 0, 0, g.useHTML).attr(w).css(g.style).add();
                }
                c = [r[1], r[4], n ? r[6] : r[1]];
                n = [r[2], r[5], n ? r[7] : r[2]];
                r = y(c);
                d = y(n);
                i.align(g, !1, {
                    x: r,
                    y: d,
                    width: z(c) - r,
                    height: z(n) - d
                });
                i.show();
            } else
                i && i.hide();
            return a;
        },
        destroy: function() {
            j(this.axis.plotLinesAndBands, this);
            delete this.axis;
            A(this);
        }
    };
    H.prototype = {
        defaultOptions: {
            dateTimeLabelFormats: {
                millisecond: "%H:%M:%S.%L",
                second: "%H:%M:%S",
                minute: "%H:%M",
                hour: "%H:%M",
                day: "%e. %b",
                week: "%e. %b",
                month: "%b '%y",
                year: "%Y"
            },
            endOnTick: !1,
            gridLineColor: "#C0C0C0",
            labels: Qb,
            lineColor: "#C0D0E0",
            lineWidth: 1,
            minPadding: .01,
            maxPadding: .01,
            minorGridLineColor: "#E0E0E0",
            minorGridLineWidth: 1,
            minorTickColor: "#A0A0A0",
            minorTickLength: 2,
            minorTickPosition: "outside",
            startOfWeek: 1,
            startOnTick: !1,
            tickColor: "#C0D0E0",
            tickLength: 10,
            tickmarkPlacement: "between",
            tickPixelInterval: 100,
            tickPosition: "outside",
            tickWidth: 1,
            title: {
                align: "middle",
                style: {
                    color: "#707070"
                }
            },
            type: "linear"
        },
        defaultYAxisOptions: {
            endOnTick: !0,
            gridLineWidth: 1,
            tickPixelInterval: 72,
            showLastLabel: !0,
            labels: {
                x: -8,
                y: 3
            },
            lineWidth: 0,
            maxPadding: .05,
            minPadding: .05,
            startOnTick: !0,
            tickWidth: 0,
            title: {
                rotation: 270,
                text: "Values"
            },
            stackLabels: {
                enabled: !1,
                formatter: function() {
                    return r(this.total, -1);
                },
                style: Qb.style
            }
        },
        defaultLeftAxisOptions: {
            labels: {
                x: -15,
                y: null
            },
            title: {
                rotation: 270
            }
        },
        defaultRightAxisOptions: {
            labels: {
                x: 15,
                y: null
            },
            title: {
                rotation: 90
            }
        },
        defaultBottomAxisOptions: {
            labels: {
                x: 0,
                y: null
            },
            title: {
                rotation: 0
            }
        },
        defaultTopAxisOptions: {
            labels: {
                x: 0,
                y: -15
            },
            title: {
                rotation: 0
            }
        },
        init: function(a, b) {
            var c = b.isX;
            this.horiz = a.inverted ? !c : c;
            this.coll = (this.isXAxis = c) ? "xAxis" : "yAxis";
            this.opposite = b.opposite;
            this.side = b.side || (this.horiz ? this.opposite ? 0 : 2 : this.opposite ? 1 : 3);
            this.setOptions(b);
            var d = this.options, e = d.type;
            this.labelFormatter = d.labels.formatter || this.defaultLabelFormatter;
            this.userOptions = b;
            this.minPixelPadding = 0;
            this.chart = a;
            this.reversed = d.reversed;
            this.zoomEnabled = d.zoomEnabled !== !1;
            this.categories = d.categories || "category" === e;
            this.names = [];
            this.isLog = "logarithmic" === e;
            this.isDatetimeAxis = "datetime" === e;
            this.isLinked = k(d.linkedTo);
            this.tickmarkOffset = this.categories && "between" === d.tickmarkPlacement && 1 === n(d.tickInterval, 1) ? .5 : 0;
            this.ticks = {};
            this.labelEdge = [];
            this.minorTicks = {};
            this.plotLinesAndBands = [];
            this.alternateBands = {};
            this.len = 0;
            this.minRange = this.userMinRange = d.minRange || d.maxZoom;
            this.range = d.range;
            this.offset = d.offset || 0;
            this.stacks = {};
            this.oldStacks = {};
            this.min = this.max = null;
            this.crosshair = n(d.crosshair, m(a.options.tooltip.crosshairs)[c ? 0 : 1], !1);
            var f, d = this.options.events;
            Tb(this, a.axes) === -1 && (c && !this.isColorAxis ? a.axes.splice(a.xAxis.length, 0, this) : a.axes.push(this),
                    a[this.coll].push(this));
            this.series = this.series || [];
            if (a.inverted && c && this.reversed === K)
                this.reversed = !0;
            this.removePlotLine = this.removePlotBand = this.removePlotBandOrLine;
            for (f in d)
                Yb(this, f, d[f]);
            if (this.isLog)
                this.val2lin = h, this.lin2val = i;
        },
        setOptions: function(a) {
            this.options = b(this.defaultOptions, this.isXAxis ? {} : this.defaultYAxisOptions, [this.defaultTopAxisOptions, this.defaultRightAxisOptions, this.defaultBottomAxisOptions, this.defaultLeftAxisOptions][this.side], b(mb[this.coll], a));
        },
        defaultLabelFormatter: function() {
            var a = this.axis, b = this.value, c = a.categories, d = this.dateTimeLabelFormat, e = mb.lang.numericSymbols, f = e && e.length, g, h = a.options.labels.format, a = a.isLog ? b : a.tickInterval;
            if (h)
                g = u(h, this);
            else if (c)
                g = b;
            else if (d)
                g = nb(d, b);
            else if (f && a >= 1e3)
                for (; f-- && g === K; )
                    c = Math.pow(1e3, f + 1),
                            a >= c && null !== e[f] && (g = r(b / c, -1) + e[f]);
            g === K && (g = T(b) >= 1e4 ? r(b, 0) : r(b, -1, K, ""));
            return g;
        },
        getSeriesExtremes: function() {
            var a = this, b = a.chart;
            a.hasVisibleSeries = !1;
            a.dataMin = a.dataMax = a.ignoreMinPadding = a.ignoreMaxPadding = null;
            a.buildStacks && a.buildStacks();
            Ub(a.series, function(c) {
                if (c.visible || !b.options.chart.ignoreHiddenSeries) {
                    var d;
                    d = c.options.threshold;
                    var e;
                    a.hasVisibleSeries = !0;
                    a.isLog && d <= 0 && (d = null);
                    if (a.isXAxis) {
                        if (d = c.xData, d.length)
                            a.dataMin = S(n(a.dataMin, d[0]), y(d)), a.dataMax = R(n(a.dataMax, d[0]), z(d));
                    } else {
                        c.getExtremes();
                        e = c.dataMax;
                        c = c.dataMin;
                        if (k(c) && k(e))
                            a.dataMin = S(n(a.dataMin, c), c), a.dataMax = R(n(a.dataMax, e), e);
                        if (k(d))
                            if (a.dataMin >= d)
                                a.dataMin = d, a.ignoreMinPadding = !0;
                            else if (a.dataMax < d)
                                a.dataMax = d,
                                        a.ignoreMaxPadding = !0;
                    }
                }
            });
        },
        translate: function(a, b, c, d, e, f) {
            var h = 1, i = 0, j = d ? this.oldTransA : this.transA, d = d ? this.oldMin : this.min, k = this.minPixelPadding, e = (this.options.ordinal || this.isLog && e) && this.lin2val;
            if (!j)
                j = this.transA;
            if (c)
                h *= -1, i = this.len;
            this.reversed && (h *= -1, i -= h * (this.sector || this.len));
            b ? (a = a * h + i, a -= k, a = a / j + d, e && (a = this.lin2val(a))) : (e && (a = this.val2lin(a)),
                    "between" === f && (f = .5), a = h * (a - d) * j + i + h * k + (g(f) ? j * f * this.pointRange : 0));
            return a;
        },
        toPixels: function(a, b) {
            return this.translate(a, !1, !this.horiz, null, !0) + (b ? 0 : this.pos);
        },
        toValue: function(a, b) {
            return this.translate(a - (b ? 0 : this.pos), !0, !this.horiz, null, !0);
        },
        getPlotLinePath: function(a, b, c, d, e) {
            var f = this.chart, g = this.left, h = this.top, i, j, k = c && f.oldChartHeight || f.chartHeight, l = c && f.oldChartWidth || f.chartWidth, m;
            i = this.transB;
            e = n(e, this.translate(a, null, null, c));
            a = c = O(e + i);
            i = j = O(k - e - i);
            if (isNaN(e))
                m = !0;
            else if (this.horiz) {
                if (i = h, j = k - this.bottom, a < g || a > g + this.width)
                    m = !0;
            } else if (a = g, c = l - this.right, i < h || i > h + this.height)
                m = !0;
            return m && !d ? null : f.renderer.crispLine(["M", a, i, "L", c, j], b || 1);
        },
        getLinearTickPositions: function(a, b, c) {
            var d, e = C(P(b / a) * a), f = C(Q(c / a) * a), h = [];
            if (b === c && g(b))
                return [b];
            for (b = e; b <= f; ) {
                h.push(b);
                b = C(b + a);
                if (b === d)
                    break;
                d = b;
            }
            return h;
        },
        getMinorTickPositions: function() {
            var a = this.options, b = this.tickPositions, c = this.minorTickInterval, d = [], e;
            if (this.isLog) {
                e = b.length;
                for (a = 1; a < e; a++)
                    d = d.concat(this.getLogTickPositions(c, b[a - 1], b[a], !0));
            } else if (this.isDatetimeAxis && "auto" === a.minorTickInterval)
                d = d.concat(this.getTimeTicks(this.normalizeTimeTickInterval(c), this.min, this.max, a.startOfWeek)),
                        d[0] < this.min && d.shift();
            else
                for (b = this.min + (b[0] - this.min) % c; b <= this.max; b += c)
                    d.push(b);
            return d;
        },
        adjustForMinRange: function() {
            var a = this.options, b = this.min, c = this.max, d, e = this.dataMax - this.dataMin >= this.minRange, f, g, h, i, j;
            if (this.isXAxis && this.minRange === K && !this.isLog)
                k(a.min) || k(a.max) ? this.minRange = null : (Ub(this.series, function(a) {
                    i = a.xData;
                    for (g = j = a.xIncrement ? 1 : i.length - 1; g > 0; g--)
                        if (h = i[g] - i[g - 1],
                                f === K || h < f)
                            f = h;
                }), this.minRange = S(5 * f, this.dataMax - this.dataMin));
            if (c - b < this.minRange) {
                var l = this.minRange;
                d = (l - c + b) / 2;
                d = [b - d, n(a.min, b - d)];
                if (e)
                    d[2] = this.dataMin;
                b = z(d);
                c = [b + l, n(a.max, b + l)];
                if (e)
                    c[2] = this.dataMax;
                c = y(c);
                c - b < l && (d[0] = c - l, d[1] = n(a.min, c - l), b = z(d));
            }
            this.min = b;
            this.max = c;
        },
        setAxisTranslation: function(a) {
            var b = this, c = b.max - b.min, e = b.axisPointRange || 0, f, g = 0, h = 0, i = b.linkedParent, j = !!b.categories, l = b.transA;
            if (b.isXAxis || j || e)
                i ? (g = i.minPointOffset, h = i.pointRangePadding) : Ub(b.series, function(a) {
                    var i = j ? 1 : b.isXAxis ? a.pointRange : b.axisPointRange || 0, l = a.options.pointPlacement, m = a.closestPointRange;
                    i > c && (i = 0);
                    e = R(e, i);
                    g = R(g, d(l) ? 0 : i / 2);
                    h = R(h, "on" === l ? 0 : i);
                    !a.noSharedTooltip && k(m) && (f = k(f) ? S(f, m) : m);
                }), i = b.ordinalSlope && f ? b.ordinalSlope / f : 1, b.minPointOffset = g *= i,
                        b.pointRangePadding = h *= i, b.pointRange = S(e, c), b.closestPointRange = f;
            if (a)
                b.oldTransA = l;
            b.translationSlope = b.transA = l = b.len / (c + h || 1);
            b.transB = b.horiz ? b.left : b.bottom;
            b.minPixelPadding = l * g;
        },
        setTickPositions: function(a) {
            var b = this, c = b.chart, d = b.options, e = d.startOnTick, f = d.endOnTick, i = b.isLog, j = b.isDatetimeAxis, l = b.isXAxis, m = b.isLinked, o = b.options.tickPositioner, p = d.maxPadding, q = d.minPadding, r = d.tickInterval, s = d.minTickInterval, t = d.tickPixelInterval, u, x = b.categories;
            m ? (b.linkedParent = c[b.coll][d.linkedTo], c = b.linkedParent.getExtremes(), b.min = n(c.min, c.dataMin),
                    b.max = n(c.max, c.dataMax), d.type !== b.linkedParent.options.type && rb(11, 1)) : (b.min = n(b.userMin, d.min, b.dataMin),
                    b.max = n(b.userMax, d.max, b.dataMax));
            if (i)
                !a && S(b.min, n(b.dataMin, b.min)) <= 0 && rb(10, 1), b.min = C(h(b.min)),
                        b.max = C(h(b.max));
            if (b.range && k(b.max))
                b.userMin = b.min = R(b.min, b.max - b.range), b.userMax = b.max,
                        b.range = null;
            b.beforePadding && b.beforePadding();
            b.adjustForMinRange();
            if (!x && !b.axisPointRange && !b.usePercentage && !m && k(b.min) && k(b.max) && (c = b.max - b.min)) {
                if (!k(d.min) && !k(b.userMin) && q && (b.dataMin < 0 || !b.ignoreMinPadding))
                    b.min -= c * q;
                if (!k(d.max) && !k(b.userMax) && p && (b.dataMax > 0 || !b.ignoreMaxPadding))
                    b.max += c * p;
            }
            if (g(d.floor))
                b.min = R(b.min, d.floor);
            if (g(d.ceiling))
                b.max = S(b.max, d.ceiling);
            b.min === b.max || b.min === void 0 || b.max === void 0 ? b.tickInterval = 1 : m && !r && t === b.linkedParent.options.tickPixelInterval ? b.tickInterval = b.linkedParent.tickInterval : (b.tickInterval = n(r, x ? 1 : (b.max - b.min) * t / R(b.len, t)),
                    !k(r) && b.len < t && !this.isRadial && !this.isLog && !x && e && f && (u = !0,
                    b.tickInterval /= 4));
            l && !a && Ub(b.series, function(a) {
                a.processData(b.min !== b.oldMin || b.max !== b.oldMax);
            });
            b.setAxisTranslation(!0);
            b.beforeSetTickPositions && b.beforeSetTickPositions();
            if (b.postProcessTickInterval)
                b.tickInterval = b.postProcessTickInterval(b.tickInterval);
            if (b.pointRange)
                b.tickInterval = R(b.pointRange, b.tickInterval);
            if (!r && b.tickInterval < s)
                b.tickInterval = s;
            if (!j && !i && !r)
                b.tickInterval = w(b.tickInterval, null, v(b.tickInterval), n(d.allowDecimals, !(b.tickInterval > 1 && b.tickInterval < 5 && b.max > 1e3 && b.max < 9999)));
            b.minorTickInterval = "auto" === d.minorTickInterval && b.tickInterval ? b.tickInterval / 5 : d.minorTickInterval;
            b.tickPositions = a = d.tickPositions ? [].concat(d.tickPositions) : o && o.apply(b, [b.min, b.max]);
            if (!a)
                !b.ordinalPositions && (b.max - b.min) / b.tickInterval > R(2 * b.len, 200) && rb(19, !0),
                        a = j ? b.getTimeTicks(b.normalizeTimeTickInterval(b.tickInterval, d.units), b.min, b.max, d.startOfWeek, b.ordinalPositions, b.closestPointRange, !0) : i ? b.getLogTickPositions(b.tickInterval, b.min, b.max) : b.getLinearTickPositions(b.tickInterval, b.min, b.max),
                        u && a.splice(1, a.length - 2), b.tickPositions = a;
            if (!m)
                d = a[0], i = a[a.length - 1], j = b.minPointOffset || 0, e ? b.min = d : b.min - j > d && a.shift(),
                        f ? b.max = i : b.max + j < i && a.pop(), 0 === a.length && k(d) && a.push((i + d) / 2),
                        1 === a.length && (e = T(b.max) > 1e13 ? 1 : .001, b.min -= e, b.max += e);
        },
        setMaxTicks: function() {
            var a = this.chart, b = a.maxTicks || {}, c = this.tickPositions, d = this._maxTicksKey = [this.coll, this.pos, this.len].join("-");
            if (!this.isLinked && !this.isDatetimeAxis && c && c.length > (b[d] || 0) && this.options.alignTicks !== !1)
                b[d] = c.length;
            a.maxTicks = b;
        },
        adjustTickAmount: function() {
            var a = this._maxTicksKey, b = this.tickPositions, c = this.chart.maxTicks;
            if (c && c[a] && !this.isDatetimeAxis && !this.categories && !this.isLinked && this.options.alignTicks !== !1 && this.min !== K) {
                var d = this.tickAmount, e = b.length;
                this.tickAmount = a = c[a];
                if (e < a) {
                    for (; b.length < a; )
                        b.push(C(b[b.length - 1] + this.tickInterval));
                    this.transA *= (e - 1) / (a - 1);
                    this.max = b[b.length - 1];
                }
                if (k(d) && a !== d)
                    this.isDirty = !0;
            }
        },
        setScale: function() {
            var a = this.stacks, b, c, d, e;
            this.oldMin = this.min;
            this.oldMax = this.max;
            this.oldAxisLength = this.len;
            this.setAxisSize();
            e = this.len !== this.oldAxisLength;
            Ub(this.series, function(a) {
                if (a.isDirtyData || a.isDirty || a.xAxis.isDirty)
                    d = !0;
            });
            if (e || d || this.isLinked || this.forceRedraw || this.userMin !== this.oldUserMin || this.userMax !== this.oldUserMax) {
                if (!this.isXAxis)
                    for (b in a)
                        for (c in a[b])
                            a[b][c].total = null, a[b][c].cum = 0;
                this.forceRedraw = !1;
                this.getSeriesExtremes();
                this.setTickPositions();
                this.oldUserMin = this.userMin;
                this.oldUserMax = this.userMax;
                if (!this.isDirty)
                    this.isDirty = e || this.min !== this.oldMin || this.max !== this.oldMax;
            } else if (!this.isXAxis) {
                if (this.oldStacks)
                    a = this.stacks = this.oldStacks;
                for (b in a)
                    for (c in a[b])
                        a[b][c].cum = a[b][c].total;
            }
            this.setMaxTicks();
        },
        setExtremes: function(b, c, d, e, f) {
            var g = this, h = g.chart, d = n(d, !0), f = a(f, {
                min: b,
                max: c
            });
            $b(g, "setExtremes", f, function() {
                g.userMin = b;
                g.userMax = c;
                g.eventArgs = f;
                g.isDirtyExtremes = !0;
                d && h.redraw(e);
            });
        },
        zoom: function(a, b) {
            var c = this.dataMin, d = this.dataMax, e = this.options;
            this.allowZoomOutside || (k(c) && a <= S(c, n(e.min, c)) && (a = K), k(d) && b >= R(d, n(e.max, d)) && (b = K));
            this.displayBtn = a !== K || b !== K;
            this.setExtremes(a, b, !1, K, {
                trigger: "zoom"
            });
            return !0;
        },
        setAxisSize: function() {
            var a = this.chart, b = this.options, c = b.offsetLeft || 0, d = this.horiz, e = n(b.width, a.plotWidth - c + (b.offsetRight || 0)), f = n(b.height, a.plotHeight), g = n(b.top, a.plotTop), b = n(b.left, a.plotLeft + c), c = /%$/;
            c.test(f) && (f = parseInt(f, 10) / 100 * a.plotHeight);
            c.test(g) && (g = parseInt(g, 10) / 100 * a.plotHeight + a.plotTop);
            this.left = b;
            this.top = g;
            this.width = e;
            this.height = f;
            this.bottom = a.chartHeight - f - g;
            this.right = a.chartWidth - e - b;
            this.len = R(d ? e : f, 0);
            this.pos = d ? b : g;
        },
        getExtremes: function() {
            var a = this.isLog;
            return {
                min: a ? C(i(this.min)) : this.min,
                max: a ? C(i(this.max)) : this.max,
                dataMin: this.dataMin,
                dataMax: this.dataMax,
                userMin: this.userMin,
                userMax: this.userMax
            };
        },
        getThreshold: function(a) {
            var b = this.isLog, c = b ? i(this.min) : this.min, b = b ? i(this.max) : this.max;
            c > a || null === a ? a = c : b < a && (a = b);
            return this.translate(a, 0, 1, 0, 1);
        },
        autoLabelAlign: function(a) {
            a = (n(a, 0) - 90 * this.side + 720) % 360;
            return a > 15 && a < 165 ? "right" : a > 195 && a < 345 ? "left" : "center";
        },
        getOffset: function() {
            var a = this, b = a.chart, c = b.renderer, d = a.options, e = a.tickPositions, f = a.ticks, g = a.horiz, h = a.side, i = b.inverted ? [1, 0, 3, 2][h] : h, j, l, m = 0, o, p = 0, q = d.title, r = d.labels, s = 0, t = b.axisOffset, b = b.clipOffset, u = [-1, 1, 1, -1][h], v, w = 1, x = n(r.maxStaggerLines, 5), y, z, A, B, C;
            a.hasData = j = a.hasVisibleSeries || k(a.min) && k(a.max) && !!e;
            a.showAxis = l = j || n(d.showEmpty, !0);
            a.staggerLines = a.horiz && r.staggerLines;
            if (!a.axisGroup)
                a.gridGroup = c.g("grid").attr({
                    zIndex: d.gridZIndex || 1
                }).add(), a.axisGroup = c.g("axis").attr({
                    zIndex: d.zIndex || 2
                }).add(), a.labelGroup = c.g("axis-labels").attr({
                    zIndex: r.zIndex || 7
                }).addClass("highcharts-" + a.coll.toLowerCase() + "-labels").add();
            if (j || a.isLinked) {
                a.labelAlign = n(r.align || a.autoLabelAlign(r.rotation));
                Ub(e, function(b) {
                    f[b] ? f[b].addLabel() : f[b] = new G(a, b);
                });
                if (a.horiz && !a.staggerLines && x && !r.rotation) {
                    for (j = a.reversed ? [].concat(e).reverse() : e; w < x; ) {
                        y = [];
                        z = !1;
                        for (v = 0; v < j.length; v++)
                            A = j[v], B = (B = f[A].label && f[A].label.getBBox()) ? B.width : 0,
                                    C = v % w, B && (A = a.translate(A), y[C] !== K && A < y[C] && (z = !0), y[C] = A + B);
                        if (z)
                            w++;
                        else
                            break;
                    }
                    if (w > 1)
                        a.staggerLines = w;
                }
                Ub(e, function(b) {
                    if (0 === h || 2 === h || {
                        1: "left",
                        3: "right"
                    }[h] === a.labelAlign)
                        s = R(f[b].getLabelSize(), s);
                });
                if (a.staggerLines)
                    s *= a.staggerLines, a.labelOffset = s;
            } else
                for (v in f)
                    f[v].destroy(), delete f[v];
            if (q && q.text && q.enabled !== !1) {
                if (!a.axisTitle)
                    a.axisTitle = c.text(q.text, 0, 0, q.useHTML).attr({
                        zIndex: 7,
                        rotation: q.rotation || 0,
                        align: q.textAlign || {
                            low: "left",
                            middle: "center",
                            high: "right"
                        }[q.align]
                    }).addClass("highcharts-" + this.coll.toLowerCase() + "-title").css(q.style).add(a.axisGroup),
                            a.axisTitle.isNew = !0;
                if (l)
                    m = a.axisTitle.getBBox()[g ? "height" : "width"], o = q.offset, p = k(o) ? 0 : n(q.margin, g ? 5 : 10);
                a.axisTitle[l ? "show" : "hide"]();
            }
            a.offset = u * n(d.offset, t[h]);
            c = 2 === h ? a.tickBaseline : 0;
            g = s + p + (s && u * (g ? n(r.y, a.tickBaseline + 8) : r.x) - c);
            a.axisTitleMargin = n(o, g);
            t[h] = R(t[h], a.axisTitleMargin + m + u * a.offset, g);
            b[i] = R(b[i], 2 * P(d.lineWidth / 2));
        },
        getLinePath: function(a) {
            var b = this.chart, c = this.opposite, d = this.offset, e = this.horiz, f = this.left + (c ? this.width : 0) + d, d = b.chartHeight - this.bottom - (c ? this.height : 0) + d;
            c && (a *= -1);
            return b.renderer.crispLine(["M", e ? this.left : f, e ? d : this.top, "L", e ? b.chartWidth - this.right : f, e ? d : b.chartHeight - this.bottom], a);
        },
        getTitlePosition: function() {
            var a = this.horiz, b = this.left, d = this.top, e = this.len, f = this.options.title, g = a ? b : d, h = this.opposite, i = this.offset, j = c(f.style.fontSize || 12), e = {
                low: g + (a ? 0 : e),
                middle: g + e / 2,
                high: g + (a ? e : 0)
            }[f.align], b = (a ? d + this.height : b) + (a ? 1 : -1) * (h ? -1 : 1) * this.axisTitleMargin + (2 === this.side ? j : 0);
            return {
                x: a ? e : b + (h ? this.width : 0) + i + (f.x || 0),
                y: a ? b - (h ? this.height : 0) + i : e + (f.y || 0)
            };
        },
        render: function() {
            var a = this, b = a.horiz, c = a.reversed, d = a.chart, e = d.renderer, f = a.options, g = a.isLog, h = a.isLinked, j = a.tickPositions, l, m = a.axisTitle, n = a.ticks, o = a.minorTicks, p = a.alternateBands, q = f.stackLabels, r = f.alternateGridColor, s = a.tickmarkOffset, t = f.lineWidth, u = d.hasRendered && k(a.oldMin) && !isNaN(a.oldMin), v = a.hasData, w = a.showAxis, x, y = f.labels.overflow, z = a.justifyLabels = b && y !== !1, A;
            a.labelEdge.length = 0;
            a.justifyToPlot = "justify" === y;
            Ub([n, o, p], function(a) {
                for (var b in a)
                    a[b].isActive = !1;
            });
            if (v || h)
                if (a.minorTickInterval && !a.categories && Ub(a.getMinorTickPositions(), function(b) {
                    o[b] || (o[b] = new G(a, b, "minor"));
                    u && o[b].isNew && o[b].render(null, !0);
                    o[b].render(null, !1, 1);
                }), j.length && (l = j.slice(), (b && c || !b && !c) && l.reverse(), z && (l = l.slice(1).concat([l[0]])),
                        Ub(l, function(b, c) {
                            z && (c = c === l.length - 1 ? 0 : c + 1);
                            if (!h || b >= a.min && b <= a.max)
                                n[b] || (n[b] = new G(a, b)), u && n[b].isNew && n[b].render(c, !0, .1),
                                        n[b].render(c);
                        }), s && 0 === a.min && (n[-1] || (n[-1] = new G(a, -1, null, !0)), n[-1].render(-1))),
                        r && Ub(j, function(b, c) {
                            if (c % 2 === 0 && b < a.max)
                                p[b] || (p[b] = new Ob.PlotLineOrBand(a)), x = b + s,
                                        A = j[c + 1] !== K ? j[c + 1] + s : a.max, p[b].options = {
                                    from: g ? i(x) : x,
                                    to: g ? i(A) : A,
                                    color: r
                                }, p[b].render(), p[b].isActive = !0;
                        }), !a._addedPlotLB)
                    Ub((f.plotLines || []).concat(f.plotBands || []), function(b) {
                        a.addPlotBandOrLine(b);
                    }), a._addedPlotLB = !0;
            Ub([n, o, p], function(a) {
                var b, c, e = [], f = ob ? ob.duration || 500 : 0, g = function() {
                    for (c = e.length; c--; )
                        a[e[c]] && !a[e[c]].isActive && (a[e[c]].destroy(), delete a[e[c]]);
                };
                for (b in a)
                    if (!a[b].isActive)
                        a[b].render(b, !1, 0), a[b].isActive = !1, e.push(b);
                a === p || !d.hasRendered || !f ? g() : f && setTimeout(g, f);
            });
            if (t)
                b = a.getLinePath(t), a.axisLine ? a.axisLine.animate({
                    d: b
                }) : a.axisLine = e.path(b).attr({
                    stroke: f.lineColor,
                    "stroke-width": t,
                    zIndex: 7
                }).add(a.axisGroup), a.axisLine[w ? "show" : "hide"]();
            if (m && w)
                m[m.isNew ? "attr" : "animate"](a.getTitlePosition()), m.isNew = !1;
            q && q.enabled && a.renderStackTotals();
            a.isDirty = !1;
        },
        redraw: function() {
            this.render();
            Ub(this.plotLinesAndBands, function(a) {
                a.render();
            });
            Ub(this.series, function(a) {
                a.isDirty = !0;
            });
        },
        destroy: function(a) {
            var b = this, c = b.stacks, d, e = b.plotLinesAndBands;
            a || Zb(b);
            for (d in c)
                A(c[d]), c[d] = null;
            Ub([b.ticks, b.minorTicks, b.alternateBands], function(a) {
                A(a);
            });
            for (a = e.length; a--; )
                e[a].destroy();
            Ub("stackTotalGroup,axisLine,axisTitle,axisGroup,cross,gridGroup,labelGroup".split(","), function(a) {
                b[a] && (b[a] = b[a].destroy());
            });
            this.cross && this.cross.destroy();
        },
        drawCrosshair: function(a, b) {
            if (this.crosshair)
                if ((k(b) || !n(this.crosshair.snap, !0)) === !1)
                    this.hideCrosshair();
                else {
                    var c, d = this.crosshair, e = d.animation;
                    n(d.snap, !0) ? k(b) && (c = this.chart.inverted != this.horiz ? b.plotX : this.len - b.plotY) : c = this.horiz ? a.chartX - this.pos : this.len - a.chartY + this.pos;
                    c = this.isRadial ? this.getPlotLinePath(this.isXAxis ? b.x : n(b.stackY, b.y)) : this.getPlotLinePath(null, null, null, null, c);
                    if (null === c)
                        this.hideCrosshair();
                    else if (this.cross)
                        this.cross.attr({
                            visibility: "visible"
                        })[e ? "animate" : "attr"]({
                            d: c
                        }, e);
                    else {
                        e = {
                            "stroke-width": d.width || 1,
                            stroke: d.color || "#C0C0C0",
                            zIndex: d.zIndex || 2
                        };
                        if (d.dashStyle)
                            e.dashstyle = d.dashStyle;
                        this.cross = this.chart.renderer.path(c).attr(e).add();
                    }
                }
        },
        hideCrosshair: function() {
            this.cross && this.cross.hide();
        }
    };
    a(H.prototype, {
        getPlotBandPath: function(a, b) {
            var c = this.getPlotLinePath(b), d = this.getPlotLinePath(a);
            d && c ? d.push(c[4], c[5], c[1], c[2]) : d = null;
            return d;
        },
        addPlotBand: function(a) {
            return this.addPlotBandOrLine(a, "plotBands");
        },
        addPlotLine: function(a) {
            return this.addPlotBandOrLine(a, "plotLines");
        },
        addPlotBandOrLine: function(a, b) {
            var c = new Ob.PlotLineOrBand(this, a).render(), d = this.userOptions;
            c && (b && (d[b] = d[b] || [], d[b].push(a)), this.plotLinesAndBands.push(c));
            return c;
        },
        removePlotBandOrLine: function(a) {
            for (var b = this.plotLinesAndBands, c = this.options, d = this.userOptions, e = b.length; e--; )
                b[e].id === a && b[e].destroy();
            Ub([c.plotLines || [], d.plotLines || [], c.plotBands || [], d.plotBands || []], function(b) {
                for (e = b.length; e--; )
                    b[e].id === a && j(b, b[e]);
            });
        }
    });
    H.prototype.getTimeTicks = function(b, c, d, e) {
        var f = [], g = {}, h = mb.global.useUTC, i, j = new zb(c - Bb), l = b.unitRange, m = b.count;
        if (k(c)) {
            l >= qb.second && (j.setMilliseconds(0), j.setSeconds(l >= qb.minute ? 0 : m * P(j.getSeconds() / m)));
            if (l >= qb.minute)
                j[Ib](l >= qb.hour ? 0 : m * P(j[Cb]() / m));
            if (l >= qb.hour)
                j[Jb](l >= qb.day ? 0 : m * P(j[Db]() / m));
            if (l >= qb.day)
                j[Kb](l >= qb.month ? 1 : m * P(j[Fb]() / m));
            l >= qb.month && (j[Lb](l >= qb.year ? 0 : m * P(j[Gb]() / m)), i = j[Hb]());
            l >= qb.year && (i -= i % m, j[Mb](i));
            if (l === qb.week)
                j[Kb](j[Fb]() - j[Eb]() + n(e, 1));
            c = 1;
            Bb && (j = new zb(j.getTime() + Bb));
            i = j[Hb]();
            for (var e = j.getTime(), o = j[Gb](), p = j[Fb](), q = (qb.day + (h ? Bb : 6e4 * j.getTimezoneOffset())) % qb.day; e < d; )
                f.push(e),
                        l === qb.year ? e = Ab(i + c * m, 0) : l === qb.month ? e = Ab(i, o + c * m) : !h && (l === qb.day || l === qb.week) ? e = Ab(i, o, p + c * m * (l === qb.day ? 1 : 7)) : e += l * m,
                        c++;
            f.push(e);
            Ub(Vb(f, function(a) {
                return l <= qb.hour && a % qb.day === q;
            }), function(a) {
                g[a] = "day";
            });
        }
        f.info = a(b, {
            higherRanks: g,
            totalRange: l * m
        });
        return f;
    };
    H.prototype.normalizeTimeTickInterval = function(a, b) {
        var c = b || [["millisecond", [1, 2, 5, 10, 20, 25, 50, 100, 200, 500]], ["second", [1, 2, 5, 10, 15, 30]], ["minute", [1, 2, 5, 10, 15, 30]], ["hour", [1, 2, 3, 4, 6, 8, 12]], ["day", [1, 2]], ["week", [1, 2]], ["month", [1, 2, 3, 4, 6]], ["year", null]], d = c[c.length - 1], e = qb[d[0]], f = d[1], g;
        for (g = 0; g < c.length; g++)
            if (d = c[g], e = qb[d[0]], f = d[1], c[g + 1] && a <= (e * f[f.length - 1] + qb[c[g + 1][0]]) / 2)
                break;
        e === qb.year && a < 5 * e && (f = [1, 2, 5]);
        c = w(a / e, f, "year" === d[0] ? R(v(a / e), 1) : 1);
        return {
            unitRange: e,
            count: c,
            unitName: d[0]
        };
    };
    H.prototype.getLogTickPositions = function(a, b, c, d) {
        var e = this.options, f = this.len, g = [];
        if (!d)
            this._minorAutoInterval = null;
        if (a >= .5)
            a = O(a), g = this.getLinearTickPositions(a, b, c);
        else if (a >= .08)
            for (var f = P(b), j, k, l, m, o, e = a > .3 ? [1, 2, 4] : a > .15 ? [1, 2, 4, 6, 8] : [1, 2, 3, 4, 5, 6, 7, 8, 9]; f < c + 1 && !o; f++) {
                k = e.length;
                for (j = 0; j < k && !o; j++)
                    l = h(i(f) * e[j]), l > b && (!d || m <= c) && m !== K && g.push(m),
                            m > c && (o = !0), m = l;
            }
        else if (b = i(b), c = i(c), a = e[d ? "minorTickInterval" : "tickInterval"],
                a = n("auto" === a ? null : a, this._minorAutoInterval, (c - b) * (e.tickPixelInterval / (d ? 5 : 1)) / ((d ? f / this.tickPositions.length : f) || 1)),
                a = w(a, null, v(a)), g = Xb(this.getLinearTickPositions(a, b, c), h), !d)
            this._minorAutoInterval = a / 5;
        if (!d)
            this.tickInterval = a;
        return g;
    };
    var lc = Ob.Tooltip = function() {
        this.init.apply(this, arguments);
    };
    lc.prototype = {
        init: function(a, b) {
            var d = b.borderWidth, e = b.style, f = c(e.padding);
            this.chart = a;
            this.options = b;
            this.crosshairs = [];
            this.now = {
                x: 0,
                y: 0
            };
            this.isHidden = !0;
            this.label = a.renderer.label("", 0, 0, b.shape || "callout", null, null, b.useHTML, null, "tooltip").attr({
                padding: f,
                fill: b.backgroundColor,
                "stroke-width": d,
                r: b.borderRadius,
                zIndex: 8
            }).css(e).css({
                padding: 0
            }).add().attr({
                y: -9999
            });
            gb || this.label.shadow(b.shadow);
            this.shared = b.shared;
        },
        destroy: function() {
            if (this.label)
                this.label = this.label.destroy();
            clearTimeout(this.hideTimer);
            clearTimeout(this.tooltipTimeout);
        },
        move: function(b, c, d, e) {
            var f = this, g = f.now, h = f.options.animation !== !1 && !f.isHidden && (T(b - g.x) > 1 || T(c - g.y) > 1), i = f.followPointer || f.len > 1;
            a(g, {
                x: h ? (2 * g.x + b) / 3 : b,
                y: h ? (g.y + c) / 2 : c,
                anchorX: i ? K : h ? (2 * g.anchorX + d) / 3 : d,
                anchorY: i ? K : h ? (g.anchorY + e) / 2 : e
            });
            f.label.attr(g);
            if (h)
                clearTimeout(this.tooltipTimeout), this.tooltipTimeout = setTimeout(function() {
                    f && f.move(b, c, d, e);
                }, 32);
        },
        hide: function(a) {
            var b = this, c;
            clearTimeout(this.hideTimer);
            if (!this.isHidden)
                c = this.chart.hoverPoints, this.hideTimer = setTimeout(function() {
                    b.label.fadeOut();
                    b.isHidden = !0;
                }, n(a, this.options.hideDelay, 500)), c && Ub(c, function(a) {
                    a.setState();
                }), this.chart.hoverPoints = null;
        },
        getAnchor: function(a, b) {
            var c, d = this.chart, e = d.inverted, f = d.plotTop, g = 0, h = 0, i, a = m(a);
            c = a[0].tooltipPos;
            this.followPointer && b && (b.chartX === K && (b = d.pointer.normalize(b)), c = [b.chartX - d.plotLeft, b.chartY - f]);
            c || (Ub(a, function(a) {
                i = a.series.yAxis;
                g += a.plotX;
                h += (a.plotLow ? (a.plotLow + a.plotHigh) / 2 : a.plotY) + (!e && i ? i.top - f : 0);
            }), g /= a.length, h /= a.length, c = [e ? d.plotWidth - h : g, this.shared && !e && a.length > 1 && b ? b.chartY - f : e ? d.plotHeight - g : h]);
            return Xb(c, O);
        },
        getPosition: function(a, b, c) {
            var d = this.chart, e = this.distance, f = {}, g, h = ["y", d.chartHeight, b, c.plotY + d.plotTop], i = ["x", d.chartWidth, a, c.plotX + d.plotLeft], j = c.ttBelow || d.inverted && !c.negative || !d.inverted && c.negative, k = function(a, b, c, d) {
                var g = c < d - e, b = d + e + c < b, c = d - e - c;
                d += e;
                if (j && b)
                    f[a] = d;
                else if (!j && g)
                    f[a] = c;
                else if (g)
                    f[a] = c;
                else if (b)
                    f[a] = d;
                else
                    return !1;
            }, l = function(a, b, c, d) {
                if (d < e || d > b - e)
                    return !1;
                else
                    f[a] = d < c / 2 ? 1 : d > b - c / 2 ? b - c - 2 : d - c / 2;
            }, m = function(a) {
                var b = h;
                h = i;
                i = b;
                g = a;
            }, n = function() {
                k.apply(0, h) !== !1 ? l.apply(0, i) === !1 && !g && (m(!0), n()) : g ? f.x = f.y = 0 : (m(!0),
                        n());
            };
            (d.inverted || this.len > 1) && m();
            n();
            return f;
        },
        defaultFormatter: function(a) {
            var b = this.points || m(this), c = b[0].series, d;
            d = [a.tooltipHeaderFormatter(b[0])];
            Ub(b, function(a) {
                c = a.series;
                d.push(c.tooltipFormatter && c.tooltipFormatter(a) || a.point.tooltipFormatter(c.tooltipOptions.pointFormat));
            });
            d.push(a.options.footerFormat || "");
            return d.join("");
        },
        refresh: function(a, b) {
            var c = this.chart, d = this.label, e = this.options, f, g, h = {}, i, j = [];
            i = e.formatter || this.defaultFormatter;
            var h = c.hoverPoints, k, l = this.shared;
            clearTimeout(this.hideTimer);
            this.followPointer = m(a)[0].series.tooltipOptions.followPointer;
            g = this.getAnchor(a, b);
            f = g[0];
            g = g[1];
            l && (!a.series || !a.series.noSharedTooltip) ? (c.hoverPoints = a, h && Ub(h, function(a) {
                a.setState();
            }), Ub(a, function(a) {
                a.setState("hover");
                j.push(a.getLabelConfig());
            }), h = {
                x: a[0].category,
                y: a[0].y
            }, h.points = j, this.len = j.length, a = a[0]) : h = a.getLabelConfig();
            i = i.call(h, this);
            h = a.series;
            this.distance = n(h.tooltipOptions.distance, 16);
            i === !1 ? this.hide() : (this.isHidden && (bc(d), d.attr("opacity", 1).show()),
                    d.attr({
                        text: i
                    }), k = e.borderColor || a.color || h.color || "#606060", d.attr({
                stroke: k
            }), this.updatePosition({
                plotX: f,
                plotY: g,
                negative: a.negative,
                ttBelow: a.ttBelow
            }), this.isHidden = !1);
            $b(c, "tooltipRefresh", {
                text: i,
                x: f + c.plotLeft,
                y: g + c.plotTop,
                borderColor: k
            });
        },
        updatePosition: function(a) {
            var b = this.chart, c = this.label, c = (this.options.positioner || this.getPosition).call(this, c.width, c.height, a);
            this.move(O(c.x), O(c.y), a.plotX + b.plotLeft, a.plotY + b.plotTop);
        },
        tooltipHeaderFormatter: function(a) {
            var b = a.series, c = b.tooltipOptions, d = c.dateTimeLabelFormats, e = c.xDateFormat, f = b.xAxis, h = f && "datetime" === f.options.type && g(a.key), c = c.headerFormat, f = f && f.closestPointRange, i;
            if (h && !e) {
                if (f) {
                    for (i in qb)
                        if (qb[i] >= f || qb[i] <= qb.day && a.key % qb[i] > 0) {
                            e = d[i];
                            break;
                        }
                } else
                    e = d.day;
                e = e || d.year;
            }
            h && e && (c = c.replace("{point.key}", "{point.key:" + e + "}"));
            return u(c, {
                point: a,
                series: b
            });
        }
    };
    var mc;
    ib = L.documentElement.ontouchstart !== K;
    var nc = Ob.Pointer = function(a, b) {
        this.init(a, b);
    };
    nc.prototype = {
        init: function(a, b) {
            var c = b.chart, d = c.events, e = gb ? "" : c.zoomType, c = a.inverted, f;
            this.options = b;
            this.chart = a;
            this.zoomX = f = /x/.test(e);
            this.zoomY = e = /y/.test(e);
            this.zoomHor = f && !c || e && c;
            this.zoomVert = e && !c || f && c;
            this.hasZoom = f || e;
            this.runChartClick = d && !!d.click;
            this.pinchDown = [];
            this.lastValidTouch = {};
            if (Ob.Tooltip && b.tooltip.enabled)
                a.tooltip = new lc(a, b.tooltip), this.followTouchMove = b.tooltip.followTouchMove;
            this.setDOMEvents();
        },
        normalize: function(b, c) {
            var d, e, b = b || window.event, b = _b(b);
            if (!b.target)
                b.target = b.srcElement;
            e = b.touches ? b.touches.length ? b.touches.item(0) : b.changedTouches[0] : b;
            if (!c)
                this.chartPosition = c = Wb(this.chart.container);
            e.pageX === K ? (d = R(b.x, b.clientX - c.left), e = b.y) : (d = e.pageX - c.left,
                    e = e.pageY - c.top);
            return a(b, {
                chartX: O(d),
                chartY: O(e)
            });
        },
        getCoordinates: function(a) {
            var b = {
                xAxis: [],
                yAxis: []
            };
            Ub(this.chart.axes, function(c) {
                b[c.isXAxis ? "xAxis" : "yAxis"].push({
                    axis: c,
                    value: c.toValue(a[c.horiz ? "chartX" : "chartY"])
                });
            });
            return b;
        },
        getIndex: function(a) {
            var b = this.chart;
            return b.inverted ? b.plotHeight + b.plotTop - a.chartY : a.chartX - b.plotLeft;
        },
        runPointActions: function(a) {
            var b = this.chart, c = b.series, d = b.tooltip, e, f, g = b.hoverPoint, h = b.hoverSeries, i, j, k = b.chartWidth, l = this.getIndex(a);
            if (d && this.options.tooltip.shared && (!h || !h.noSharedTooltip)) {
                f = [];
                i = c.length;
                for (j = 0; j < i; j++)
                    if (c[j].visible && c[j].options.enableMouseTracking !== !1 && !c[j].noSharedTooltip && c[j].singularTooltips !== !0 && c[j].tooltipPoints.length && (e = c[j].tooltipPoints[l]) && e.series)
                        e._dist = T(l - e.clientX),
                                k = S(k, e._dist), f.push(e);
                for (i = f.length; i--; )
                    f[i]._dist > k && f.splice(i, 1);
                if (f.length && f[0].clientX !== this.hoverX)
                    d.refresh(f, a), this.hoverX = f[0].clientX;
            }
            c = h && h.tooltipOptions.followPointer;
            if (h && h.tracker && !c) {
                if ((e = h.tooltipPoints[l]) && e !== g)
                    e.onMouseOver(a);
            } else
                d && c && !d.isHidden && (h = d.getAnchor([{}], a), d.updatePosition({
                    plotX: h[0],
                    plotY: h[1]
                }));
            if (d && !this._onDocumentMouseMove)
                this._onDocumentMouseMove = function(a) {
                    if (tb[mc])
                        tb[mc].pointer.onDocumentMouseMove(a);
                }, Yb(L, "mousemove", this._onDocumentMouseMove);
            Ub(b.axes, function(b) {
                b.drawCrosshair(a, n(e, g));
            });
        },
        reset: function(a, b) {
            var c = this.chart, d = c.hoverSeries, e = c.hoverPoint, f = c.tooltip, g = f && f.shared ? c.hoverPoints : e;
            (a = a && f && g) && m(g)[0].plotX === K && (a = !1);
            if (a)
                f.refresh(g), e && e.setState(e.state, !0);
            else {
                if (e)
                    e.onMouseOut();
                if (d)
                    d.onMouseOut();
                f && f.hide(b);
                if (this._onDocumentMouseMove)
                    Zb(L, "mousemove", this._onDocumentMouseMove), this._onDocumentMouseMove = null;
                Ub(c.axes, function(a) {
                    a.hideCrosshair();
                });
                this.hoverX = null;
            }
        },
        scaleGroups: function(a, b) {
            var c = this.chart, d;
            Ub(c.series, function(e) {
                d = a || e.getPlotBox();
                e.xAxis && e.xAxis.zoomEnabled && (e.group.attr(d), e.markerGroup && (e.markerGroup.attr(d),
                        e.markerGroup.clip(b ? c.clipRect : null)), e.dataLabelsGroup && e.dataLabelsGroup.attr(d));
            });
            c.clipRect.attr(b || c.clipBox);
        },
        dragStart: function(a) {
            var b = this.chart;
            b.mouseIsDown = a.type;
            b.cancelClick = !1;
            b.mouseDownX = this.mouseDownX = a.chartX;
            b.mouseDownY = this.mouseDownY = a.chartY;
        },
        drag: function(a) {
            var b = this.chart, c = b.options.chart, d = a.chartX, e = a.chartY, f = this.zoomHor, g = this.zoomVert, h = b.plotLeft, i = b.plotTop, j = b.plotWidth, k = b.plotHeight, l, m = this.mouseDownX, n = this.mouseDownY, o = c.panKey && a[c.panKey + "Key"];
            d < h ? d = h : d > h + j && (d = h + j);
            e < i ? e = i : e > i + k && (e = i + k);
            this.hasDragged = Math.sqrt(Math.pow(m - d, 2) + Math.pow(n - e, 2));
            if (this.hasDragged > 10) {
                l = b.isInsidePlot(m - h, n - i);
                if (b.hasCartesianSeries && (this.zoomX || this.zoomY) && l && !o && !this.selectionMarker)
                    this.selectionMarker = b.renderer.rect(h, i, f ? 1 : j, g ? 1 : k, 0).attr({
                        fill: c.selectionMarkerFill || "rgba(69,114,167,0.25)",
                        zIndex: 7
                    }).add();
                this.selectionMarker && f && (d -= m, this.selectionMarker.attr({
                    width: T(d),
                    x: (d > 0 ? 0 : d) + m
                }));
                this.selectionMarker && g && (d = e - n, this.selectionMarker.attr({
                    height: T(d),
                    y: (d > 0 ? 0 : d) + n
                }));
                l && !this.selectionMarker && c.panning && b.pan(a, c.panning);
            }
        },
        drop: function(b) {
            var c = this.chart, d = this.hasPinched;
            if (this.selectionMarker) {
                var e = {
                    xAxis: [],
                    yAxis: [],
                    originalEvent: b.originalEvent || b
                }, f = this.selectionMarker, g = f.attr ? f.attr("x") : f.x, h = f.attr ? f.attr("y") : f.y, i = f.attr ? f.attr("width") : f.width, j = f.attr ? f.attr("height") : f.height, k;
                if (this.hasDragged || d)
                    Ub(c.axes, function(a) {
                        if (a.zoomEnabled) {
                            var c = a.horiz, d = "touchend" === b.type ? a.minPixelPadding : 0, f = a.toValue((c ? g : h) + d), c = a.toValue((c ? g + i : h + j) - d);
                            !isNaN(f) && !isNaN(c) && (e[a.coll].push({
                                axis: a,
                                min: S(f, c),
                                max: R(f, c)
                            }), k = !0);
                        }
                    }), k && $b(c, "selection", e, function(b) {
                        c.zoom(a(b, d ? {
                            animation: !1
                        } : null));
                    });
                this.selectionMarker = this.selectionMarker.destroy();
                d && this.scaleGroups();
            }
            if (c)
                o(c.container, {
                    cursor: c._cursor
                }), c.cancelClick = this.hasDragged > 10, c.mouseIsDown = this.hasDragged = this.hasPinched = !1,
                        this.pinchDown = [];
        },
        onContainerMouseDown: function(a) {
            a = this.normalize(a);
            a.preventDefault && a.preventDefault();
            this.dragStart(a);
        },
        onDocumentMouseUp: function(a) {
            tb[mc] && tb[mc].pointer.drop(a);
        },
        onDocumentMouseMove: function(a) {
            var b = this.chart, c = this.chartPosition, d = b.hoverSeries, a = this.normalize(a, c);
            c && d && !this.inClass(a.target, "highcharts-tracker") && !b.isInsidePlot(a.chartX - b.plotLeft, a.chartY - b.plotTop) && this.reset();
        },
        onContainerMouseLeave: function() {
            var a = tb[mc];
            if (a)
                a.pointer.reset(), a.pointer.chartPosition = null;
        },
        onContainerMouseMove: function(a) {
            var b = this.chart;
            mc = b.index;
            a = this.normalize(a);
            a.returnValue = !1;
            "mousedown" === b.mouseIsDown && this.drag(a);
            (this.inClass(a.target, "highcharts-tracker") || b.isInsidePlot(a.chartX - b.plotLeft, a.chartY - b.plotTop)) && !b.openMenu && this.runPointActions(a);
        },
        inClass: function(a, b) {
            for (var c; a; ) {
                if (c = l(a, "class"))
                    if (c.indexOf(b) !== -1)
                        return !0;
                    else if (c.indexOf("highcharts-container") !== -1)
                        return !1;
                a = a.parentNode;
            }
        },
        onTrackerMouseOut: function(a) {
            var b = this.chart.hoverSeries, c = (a = a.relatedTarget || a.toElement) && a.point && a.point.series;
            if (b && !b.options.stickyTracking && !this.inClass(a, "highcharts-tooltip") && c !== b)
                b.onMouseOut();
        },
        onContainerClick: function(b) {
            var c = this.chart, d = c.hoverPoint, e = c.plotLeft, f = c.plotTop, b = this.normalize(b);
            b.cancelBubble = !0;
            c.cancelClick || (d && this.inClass(b.target, "highcharts-tracker") ? ($b(d.series, "click", a(b, {
                point: d
            })), c.hoverPoint && d.firePointEvent("click", b)) : (a(b, this.getCoordinates(b)),
                    c.isInsidePlot(b.chartX - e, b.chartY - f) && $b(c, "click", b)));
        },
        setDOMEvents: function() {
            var a = this, b = a.chart.container;
            b.onmousedown = function(b) {
                a.onContainerMouseDown(b);
            };
            b.onmousemove = function(b) {
                a.onContainerMouseMove(b);
            };
            b.onclick = function(b) {
                a.onContainerClick(b);
            };
            Yb(b, "mouseleave", a.onContainerMouseLeave);
            1 === ub && Yb(L, "mouseup", a.onDocumentMouseUp);
            if (ib)
                b.ontouchstart = function(b) {
                    a.onContainerTouchStart(b);
                }, b.ontouchmove = function(b) {
                    a.onContainerTouchMove(b);
                }, 1 === ub && Yb(L, "touchend", a.onDocumentTouchEnd);
        },
        destroy: function() {
            var a;
            Zb(this.chart.container, "mouseleave", this.onContainerMouseLeave);
            ub || (Zb(L, "mouseup", this.onDocumentMouseUp), Zb(L, "touchend", this.onDocumentTouchEnd));
            clearInterval(this.tooltipTimeout);
            for (a in this)
                this[a] = null;
        }
    };
    a(Ob.Pointer.prototype, {
        pinchTranslate: function(a, b, c, d, e, f) {
            (this.zoomHor || this.pinchHor) && this.pinchTranslateDirection(!0, a, b, c, d, e, f);
            (this.zoomVert || this.pinchVert) && this.pinchTranslateDirection(!1, a, b, c, d, e, f);
        },
        pinchTranslateDirection: function(a, b, c, d, e, f, g, h) {
            var i = this.chart, j = a ? "x" : "y", k = a ? "X" : "Y", l = "chart" + k, m = a ? "width" : "height", n = i["plot" + (a ? "Left" : "Top")], o, p, q = h || 1, r = i.inverted, s = i.bounds[a ? "h" : "v"], t = 1 === b.length, u = b[0][l], v = c[0][l], w = !t && b[1][l], x = !t && c[1][l], y, c = function() {
                !t && T(u - w) > 20 && (q = h || T(v - x) / T(u - w));
                p = (n - v) / q + u;
                o = i["plot" + (a ? "Width" : "Height")] / q;
            };
            c();
            b = p;
            b < s.min ? (b = s.min, y = !0) : b + o > s.max && (b = s.max - o, y = !0);
            y ? (v -= .8 * (v - g[j][0]), t || (x -= .8 * (x - g[j][1])), c()) : g[j] = [v, x];
            r || (f[j] = p - n, f[m] = o);
            f = r ? 1 / q : q;
            e[m] = o;
            e[j] = b;
            d[r ? a ? "scaleY" : "scaleX" : "scale" + k] = q;
            d["translate" + k] = f * n + (v - f * u);
        },
        pinch: function(b) {
            var c = this, d = c.chart, e = c.pinchDown, f = c.followTouchMove, g = b.touches, h = g.length, i = c.lastValidTouch, j = c.hasZoom, k = c.selectionMarker, l = {}, m = 1 === h && (c.inClass(b.target, "highcharts-tracker") && d.runTrackerClick || c.runChartClick), o = {};
            (j || f) && !m && b.preventDefault();
            Xb(g, function(a) {
                return c.normalize(a);
            });
            if ("touchstart" === b.type)
                Ub(g, function(a, b) {
                    e[b] = {
                        chartX: a.chartX,
                        chartY: a.chartY
                    };
                }), i.x = [e[0].chartX, e[1] && e[1].chartX], i.y = [e[0].chartY, e[1] && e[1].chartY],
                        Ub(d.axes, function(a) {
                            if (a.zoomEnabled) {
                                var b = d.bounds[a.horiz ? "h" : "v"], c = a.minPixelPadding, e = a.toPixels(n(a.options.min, a.dataMin)), f = a.toPixels(n(a.options.max, a.dataMax)), g = S(e, f), e = R(e, f);
                                b.min = S(a.pos, g - c);
                                b.max = R(a.pos + a.len, e + c);
                            }
                        }), c.res = !0;
            else if (e.length) {
                if (!k)
                    c.selectionMarker = k = a({
                        destroy: sb
                    }, d.plotBox);
                c.pinchTranslate(e, g, l, k, o, i);
                c.hasPinched = j;
                c.scaleGroups(l, o);
                if (!j && f && 1 === h)
                    this.runPointActions(c.normalize(b));
                else if (c.res)
                    c.res = !1,
                            this.reset(!1, 0);
            }
        },
        onContainerTouchStart: function(a) {
            var b = this.chart;
            mc = b.index;
            1 === a.touches.length ? (a = this.normalize(a), b.isInsidePlot(a.chartX - b.plotLeft, a.chartY - b.plotTop) ? (this.runPointActions(a),
                    this.pinch(a)) : this.reset()) : 2 === a.touches.length && this.pinch(a);
        },
        onContainerTouchMove: function(a) {
            (1 === a.touches.length || 2 === a.touches.length) && this.pinch(a);
        },
        onDocumentTouchEnd: function(a) {
            tb[mc] && tb[mc].pointer.drop(a);
        }
    });
    if (M.PointerEvent || M.MSPointerEvent) {
        var oc = {}, pc = !!M.PointerEvent, qc = function() {
            var a, b = [];
            b.item = function(a) {
                return this[a];
            };
            for (a in oc)
                oc.hasOwnProperty(a) && b.push({
                    pageX: oc[a].pageX,
                    pageY: oc[a].pageY,
                    target: oc[a].target
                });
            return b;
        }, rc = function(a, b, c, d) {
            a = a.originalEvent || a;
            if (("touch" === a.pointerType || a.pointerType === a.MSPOINTER_TYPE_TOUCH) && tb[mc])
                d(a),
                        d = tb[mc].pointer, d[b]({
                    type: c,
                    target: a.currentTarget,
                    preventDefault: sb,
                    touches: qc()
                });
        };
        a(nc.prototype, {
            onContainerPointerDown: function(a) {
                rc(a, "onContainerTouchStart", "touchstart", function(a) {
                    oc[a.pointerId] = {
                        pageX: a.pageX,
                        pageY: a.pageY,
                        target: a.currentTarget
                    };
                });
            },
            onContainerPointerMove: function(a) {
                rc(a, "onContainerTouchMove", "touchmove", function(a) {
                    oc[a.pointerId] = {
                        pageX: a.pageX,
                        pageY: a.pageY
                    };
                    if (!oc[a.pointerId].target)
                        oc[a.pointerId].target = a.currentTarget;
                });
            },
            onDocumentPointerUp: function(a) {
                rc(a, "onContainerTouchEnd", "touchend", function(a) {
                    delete oc[a.pointerId];
                });
            },
            batchMSEvents: function(a) {
                a(this.chart.container, pc ? "pointerdown" : "MSPointerDown", this.onContainerPointerDown);
                a(this.chart.container, pc ? "pointermove" : "MSPointerMove", this.onContainerPointerMove);
                a(L, pc ? "pointerup" : "MSPointerUp", this.onDocumentPointerUp);
            }
        });
        t(nc.prototype, "init", function(a, b, c) {
            a.call(this, b, c);
            (this.hasZoom || this.followTouchMove) && o(b.container, {
                "-ms-touch-action": wb,
                "touch-action": wb
            });
        });
        t(nc.prototype, "setDOMEvents", function(a) {
            a.apply(this);
            (this.hasZoom || this.followTouchMove) && this.batchMSEvents(Yb);
        });
        t(nc.prototype, "destroy", function(a) {
            this.batchMSEvents(Zb);
            a.call(this);
        });
    }
    var sc = Ob.Legend = function(a, b) {
        this.init(a, b);
    };
    sc.prototype = {
        init: function(a, c) {
            var d = this, e = c.itemStyle, f = n(c.padding, 8), g = c.itemMarginTop || 0;
            this.options = c;
            if (c.enabled)
                d.itemStyle = e, d.itemHiddenStyle = b(e, c.itemHiddenStyle), d.itemMarginTop = g,
                        d.padding = f, d.initialItemX = f, d.initialItemY = f - 5, d.maxItemWidth = 0, d.chart = a,
                        d.itemHeight = 0, d.lastLineHeight = 0, d.symbolWidth = n(c.symbolWidth, 16), d.pages = [],
                        d.render(), Yb(d.chart, "endResize", function() {
                    d.positionCheckboxes();
                });
        },
        colorizeItem: function(a, b) {
            var c = this.options, d = a.legendItem, e = a.legendLine, f = a.legendSymbol, g = this.itemHiddenStyle.color, c = b ? c.itemStyle.color : g, h = b ? a.legendColor || a.color || "#CCC" : g, g = a.options && a.options.marker, i = {
                fill: h
            }, j;
            d && d.css({
                fill: c,
                color: c
            });
            e && e.attr({
                stroke: h
            });
            if (f) {
                if (g && f.isMarker)
                    for (j in i.stroke = h, g = a.convertAttribs(g), g)
                        d = g[j],
                                d !== K && (i[j] = d);
                f.attr(i);
            }
        },
        positionItem: function(a) {
            var b = this.options, c = b.symbolPadding, b = !b.rtl, d = a._legendItemPos, e = d[0], d = d[1], f = a.checkbox;
            a.legendGroup && a.legendGroup.translate(b ? e : this.legendWidth - e - 2 * c - 4, d);
            if (f)
                f.x = e, f.y = d;
        },
        destroyItem: function(a) {
            var b = a.checkbox;
            Ub(["legendItem", "legendLine", "legendSymbol", "legendGroup"], function(b) {
                a[b] && (a[b] = a[b].destroy());
            });
            b && B(a.checkbox);
        },
        destroy: function() {
            var a = this.group, b = this.box;
            if (b)
                this.box = b.destroy();
            if (a)
                this.group = a.destroy();
        },
        positionCheckboxes: function(a) {
            var b = this.group.alignAttr, c, d = this.clipHeight || this.legendHeight;
            if (b)
                c = b.translateY, Ub(this.allItems, function(e) {
                    var f = e.checkbox, g;
                    f && (g = c + f.y + (a || 0) + 3, o(f, {
                        left: b.translateX + e.checkboxOffset + f.x - 20 + "px",
                        top: g + "px",
                        display: g > c - 6 && g < c + d - 6 ? "" : wb
                    }));
                });
        },
        renderTitle: function() {
            var a = this.padding, b = this.options.title, c = 0;
            if (b.text) {
                if (!this.title)
                    this.title = this.chart.renderer.label(b.text, a - 3, a - 4, null, null, null, null, null, "legend-title").attr({
                        zIndex: 1
                    }).css(b.style).add(this.group);
                a = this.title.getBBox();
                c = a.height;
                this.offsetWidth = a.width;
                this.contentGroup.attr({
                    translateY: c
                });
            }
            this.titleHeight = c;
        },
        renderItem: function(a) {
            var c = this.chart, d = c.renderer, e = this.options, f = "horizontal" === e.layout, g = this.symbolWidth, h = e.symbolPadding, i = this.itemStyle, j = this.itemHiddenStyle, k = this.padding, l = f ? n(e.itemDistance, 20) : 0, m = !e.rtl, o = e.width, p = e.itemMarginBottom || 0, q = this.itemMarginTop, r = this.initialItemX, s = a.legendItem, t = a.series && a.series.drawLegendSymbol ? a.series : a, v = t.options, v = this.createCheckboxForItem && v && v.showCheckbox, w = e.useHTML;
            if (!s) {
                a.legendGroup = d.g("legend-item").attr({
                    zIndex: 1
                }).add(this.scrollGroup);
                a.legendItem = s = d.text(e.labelFormat ? u(e.labelFormat, a) : e.labelFormatter.call(a), m ? g + h : -h, this.baseline || 0, w).css(b(a.visible ? i : j)).attr({
                    align: m ? "left" : "right",
                    zIndex: 2
                }).add(a.legendGroup);
                if (!this.baseline)
                    this.baseline = d.fontMetrics(i.fontSize, s).f + 3 + q, s.attr("y", this.baseline);
                t.drawLegendSymbol(this, a);
                this.setItemEvents && this.setItemEvents(a, s, w, i, j);
                this.colorizeItem(a, a.visible);
                v && this.createCheckboxForItem(a);
            }
            d = s.getBBox();
            g = a.checkboxOffset = e.itemWidth || a.legendItemWidth || g + h + d.width + l + (v ? 20 : 0);
            this.itemHeight = h = O(a.legendItemHeight || d.height);
            if (f && this.itemX - r + g > (o || c.chartWidth - 2 * k - r - e.x))
                this.itemX = r,
                        this.itemY += q + this.lastLineHeight + p, this.lastLineHeight = 0;
            this.maxItemWidth = R(this.maxItemWidth, g);
            this.lastItemY = q + this.itemY + p;
            this.lastLineHeight = R(h, this.lastLineHeight);
            a._legendItemPos = [this.itemX, this.itemY];
            f ? this.itemX += g : (this.itemY += q + h + p, this.lastLineHeight = h);
            this.offsetWidth = o || R((f ? this.itemX - r - l : g) + k, this.offsetWidth);
        },
        getAllItems: function() {
            var a = [];
            Ub(this.chart.series, function(b) {
                var c = b.options;
                if (n(c.showInLegend, !k(c.linkedTo) ? K : !1, !0))
                    a = a.concat(b.legendItems || ("point" === c.legendType ? b.data : b));
            });
            return a;
        },
        render: function() {
            var b = this, c = b.chart, d = c.renderer, e = b.group, f, g, h, i, j = b.box, k = b.options, l = b.padding, m = k.borderWidth, n = k.backgroundColor;
            b.itemX = b.initialItemX;
            b.itemY = b.initialItemY;
            b.offsetWidth = 0;
            b.lastItemY = 0;
            if (!e)
                b.group = e = d.g("legend").attr({
                    zIndex: 7
                }).add(), b.contentGroup = d.g().attr({
                    zIndex: 1
                }).add(e), b.scrollGroup = d.g().add(b.contentGroup);
            b.renderTitle();
            f = b.getAllItems();
            x(f, function(a, b) {
                return (a.options && a.options.legendIndex || 0) - (b.options && b.options.legendIndex || 0);
            });
            k.reversed && f.reverse();
            b.allItems = f;
            b.display = g = !!f.length;
            Ub(f, function(a) {
                b.renderItem(a);
            });
            h = k.width || b.offsetWidth;
            i = b.lastItemY + b.lastLineHeight + b.titleHeight;
            i = b.handleOverflow(i);
            if (m || n) {
                h += l;
                i += l;
                if (j) {
                    if (h > 0 && i > 0)
                        j[j.isNew ? "attr" : "animate"](j.crisp({
                            width: h,
                            height: i
                        })), j.isNew = !1;
                } else
                    b.box = j = d.rect(0, 0, h, i, k.borderRadius, m || 0).attr({
                        stroke: k.borderColor,
                        "stroke-width": m || 0,
                        fill: n || wb
                    }).add(e).shadow(k.shadow), j.isNew = !0;
                j[g ? "show" : "hide"]();
            }
            b.legendWidth = h;
            b.legendHeight = i;
            Ub(f, function(a) {
                b.positionItem(a);
            });
            g && e.align(a({
                width: h,
                height: i
            }, k), !0, "spacingBox");
            c.isResizing || this.positionCheckboxes();
        },
        handleOverflow: function(a) {
            var b = this, c = this.chart, d = c.renderer, e = this.options, f = e.y, f = c.spacingBox.height + ("top" === e.verticalAlign ? -f : f) - this.padding, g = e.maxHeight, h, i = this.clipRect, j = e.navigation, k = n(j.animation, !0), l = j.arrowSize || 12, m = this.nav, o = this.pages, p, q = this.allItems;
            "horizontal" === e.layout && (f /= 2);
            g && (f = S(f, g));
            o.length = 0;
            if (a > f && !e.useHTML) {
                this.clipHeight = h = R(f - 20 - this.titleHeight - this.padding, 0);
                this.currentPage = n(this.currentPage, 1);
                this.fullHeight = a;
                Ub(q, function(a, b) {
                    var c = a._legendItemPos[1], d = O(a.legendItem.getBBox().height), e = o.length;
                    if (!e || c - o[e - 1] > h && (p || c) !== o[e - 1])
                        o.push(p || c), e++;
                    b === q.length - 1 && c + d - o[e - 1] > h && o.push(c);
                    c !== p && (p = c);
                });
                if (!i)
                    i = b.clipRect = d.clipRect(0, this.padding, 9999, 0), b.contentGroup.clip(i);
                i.attr({
                    height: h
                });
                if (!m)
                    this.nav = m = d.g().attr({
                        zIndex: 1
                    }).add(this.group), this.up = d.symbol("triangle", 0, 0, l, l).on("click", function() {
                        b.scroll(-1, k);
                    }).add(m), this.pager = d.text("", 15, 10).css(j.style).add(m), this.down = d.symbol("triangle-down", 0, 0, l, l).on("click", function() {
                        b.scroll(1, k);
                    }).add(m);
                b.scroll(0);
                a = f;
            } else if (m)
                i.attr({
                    height: c.chartHeight
                }), m.hide(), this.scrollGroup.attr({
                    translateY: 1
                }), this.clipHeight = 0;
            return a;
        },
        scroll: function(a, b) {
            var c = this.pages, d = c.length, e = this.currentPage + a, f = this.clipHeight, g = this.options.navigation, h = g.activeColor, g = g.inactiveColor, i = this.pager, j = this.padding;
            e > d && (e = d);
            if (e > 0)
                b !== K && D(b, this.chart), this.nav.attr({
                    translateX: j,
                    translateY: f + this.padding + 7 + this.titleHeight,
                    visibility: "visible"
                }), this.up.attr({
                    fill: 1 === e ? g : h
                }).css({
                    cursor: 1 === e ? "default" : "pointer"
                }), i.attr({
                    text: e + "/" + d
                }), this.down.attr({
                    x: 18 + this.pager.getBBox().width,
                    fill: e === d ? g : h
                }).css({
                    cursor: e === d ? "default" : "pointer"
                }), c = -c[e - 1] + this.initialItemY, this.scrollGroup.animate({
                    translateY: c
                }), this.currentPage = e, this.positionCheckboxes(c);
        }
    };
    Qb = Ob.LegendSymbolMixin = {
        drawRectangle: function(a, b) {
            var c = a.options.symbolHeight || 12;
            b.legendSymbol = this.chart.renderer.rect(0, a.baseline - 5 - c / 2, a.symbolWidth, c, a.options.symbolRadius || 0).attr({
                zIndex: 3
            }).add(b.legendGroup);
        },
        drawLineMarker: function(a) {
            var b = this.options, c = b.marker, d;
            d = a.symbolWidth;
            var e = this.chart.renderer, f = this.legendGroup, a = a.baseline - O(.3 * e.fontMetrics(a.options.itemStyle.fontSize, this.legendItem).b), g;
            if (b.lineWidth) {
                g = {
                    "stroke-width": b.lineWidth
                };
                if (b.dashStyle)
                    g.dashstyle = b.dashStyle;
                this.legendLine = e.path(["M", 0, a, "L", d, a]).attr(g).add(f);
            }
            if (c && c.enabled !== !1)
                b = c.radius, this.legendSymbol = d = e.symbol(this.symbol, d / 2 - b, a - b, 2 * b, 2 * b).add(f),
                        d.isMarker = !0;
        }
    };
    (/Trident\/7\.0/.test(Y) || bb) && t(sc.prototype, "positionItem", function(a, b) {
        var c = this, d = function() {
            b._legendItemPos && a.call(c, b);
        };
        d();
        setTimeout(d);
    });
    I.prototype = {
        init: function(a, c) {
            var d, e = a.series;
            a.series = null;
            d = b(mb, a);
            d.series = a.series = e;
            this.userOptions = a;
            e = d.chart;
            this.margin = this.splashArray("margin", e);
            this.spacing = this.splashArray("spacing", e);
            var f = e.events;
            this.bounds = {
                h: {},
                v: {}
            };
            this.callback = c;
            this.isResizing = 0;
            this.options = d;
            this.axes = [];
            this.series = [];
            this.hasCartesianSeries = e.showAxes;
            var g = this, h;
            g.index = tb.length;
            tb.push(g);
            ub++;
            e.reflow !== !1 && Yb(g, "load", function() {
                g.initReflow();
            });
            if (f)
                for (h in f)
                    Yb(g, h, f[h]);
            g.xAxis = [];
            g.yAxis = [];
            g.animation = gb ? !1 : n(e.animation, !0);
            g.pointCount = g.colorCounter = g.symbolCounter = 0;
            g.firstRender();
        },
        initSeries: function(a) {
            var b = this.options.chart;
            (b = Nb[a.type || b.type || b.defaultSeriesType]) || rb(17, !0);
            b = new b();
            b.init(this, a);
            return b;
        },
        isInsidePlot: function(a, b, c) {
            var d = c ? b : a, a = c ? a : b;
            return d >= 0 && d <= this.plotWidth && a >= 0 && a <= this.plotHeight;
        },
        adjustTickAmounts: function() {
            this.options.chart.alignTicks !== !1 && Ub(this.axes, function(a) {
                a.adjustTickAmount();
            });
            this.maxTicks = null;
        },
        redraw: function(b) {
            var c = this.axes, d = this.series, e = this.pointer, f = this.legend, g = this.isDirtyLegend, h, i, j = this.hasCartesianSeries, k = this.isDirtyBox, l = d.length, m = l, n = this.renderer, o = n.isHidden(), p = [];
            D(b, this);
            o && this.cloneRenderTo();
            for (this.layOutTitles(); m--; )
                if (b = d[m], b.options.stacking && (h = !0, b.isDirty)) {
                    i = !0;
                    break;
                }
            if (i)
                for (m = l; m--; )
                    if (b = d[m], b.options.stacking)
                        b.isDirty = !0;
            Ub(d, function(a) {
                a.isDirty && "point" === a.options.legendType && (g = !0);
            });
            if (g && f.options.enabled)
                f.render(), this.isDirtyLegend = !1;
            h && this.getStacks();
            if (j) {
                if (!this.isResizing)
                    this.maxTicks = null, Ub(c, function(a) {
                        a.setScale();
                    });
                this.adjustTickAmounts();
            }
            this.getMargins();
            j && (Ub(c, function(a) {
                a.isDirty && (k = !0);
            }), Ub(c, function(b) {
                if (b.isDirtyExtremes)
                    b.isDirtyExtremes = !1, p.push(function() {
                        $b(b, "afterSetExtremes", a(b.eventArgs, b.getExtremes()));
                        delete b.eventArgs;
                    });
                (k || h) && b.redraw();
            }));
            k && this.drawChartBox();
            Ub(d, function(a) {
                a.isDirty && a.visible && (!a.isCartesian || a.xAxis) && a.redraw();
            });
            e && e.reset(!0);
            n.draw();
            $b(this, "redraw");
            o && this.cloneRenderTo(!0);
            Ub(p, function(a) {
                a.call();
            });
        },
        get: function(a) {
            var b = this.axes, c = this.series, d, e;
            for (d = 0; d < b.length; d++)
                if (b[d].options.id === a)
                    return b[d];
            for (d = 0; d < c.length; d++)
                if (c[d].options.id === a)
                    return c[d];
            for (d = 0; d < c.length; d++) {
                e = c[d].points || [];
                for (b = 0; b < e.length; b++)
                    if (e[b].id === a)
                        return e[b];
            }
            return null;
        },
        getAxes: function() {
            var a = this, b = this.options, c = b.xAxis = m(b.xAxis || {}), b = b.yAxis = m(b.yAxis || {});
            Ub(c, function(a, b) {
                a.index = b;
                a.isX = !0;
            });
            Ub(b, function(a, b) {
                a.index = b;
            });
            c = c.concat(b);
            Ub(c, function(b) {
                new H(a, b);
            });
            a.adjustTickAmounts();
        },
        getSelectedPoints: function() {
            var a = [];
            Ub(this.series, function(b) {
                a = a.concat(Vb(b.points || [], function(a) {
                    return a.selected;
                }));
            });
            return a;
        },
        getSelectedSeries: function() {
            return Vb(this.series, function(a) {
                return a.selected;
            });
        },
        getStacks: function() {
            var a = this;
            Ub(a.yAxis, function(a) {
                if (a.stacks && a.hasVisibleSeries)
                    a.oldStacks = a.stacks;
            });
            Ub(a.series, function(b) {
                if (b.options.stacking && (b.visible === !0 || a.options.chart.ignoreHiddenSeries === !1))
                    b.stackKey = b.type + n(b.options.stack, "");
            });
        },
        setTitle: function(a, c, d) {
            var e;
            var f = this, g = f.options, h;
            h = g.title = b(g.title, a);
            e = g.subtitle = b(g.subtitle, c), g = e;
            Ub([["title", a, h], ["subtitle", c, g]], function(a) {
                var b = a[0], c = f[b], d = a[1], a = a[2];
                c && d && (f[b] = c = c.destroy());
                a && a.text && !c && (f[b] = f.renderer.text(a.text, 0, 0, a.useHTML).attr({
                    align: a.align,
                    "class": "highcharts-" + b,
                    zIndex: a.zIndex || 4
                }).css(a.style).add());
            });
            f.layOutTitles(d);
        },
        layOutTitles: function(b) {
            var c = 0, d = this.title, e = this.subtitle, f = this.options, g = f.title, f = f.subtitle, h = this.renderer, i = this.spacingBox.width - 44;
            if (d && (d.css({
                width: (g.width || i) + "px"
            }).align(a({
                y: h.fontMetrics(g.style.fontSize, d).b - 3
            }, g), !1, "spacingBox"), !g.floating && !g.verticalAlign))
                c = d.getBBox().height;
            e && (e.css({
                width: (f.width || i) + "px"
            }).align(a({
                y: c + (g.margin - 13) + h.fontMetrics(g.style.fontSize, e).b
            }, f), !1, "spacingBox"), !f.floating && !f.verticalAlign && (c = Q(c + e.getBBox().height)));
            d = this.titleOffset !== c;
            this.titleOffset = c;
            if (!this.isDirtyBox && d)
                this.isDirtyBox = d, this.hasRendered && n(b, !0) && this.isDirtyBox && this.redraw();
        },
        getChartSize: function() {
            var a = this.options.chart, b = a.width, a = a.height, c = this.renderToClone || this.renderTo;
            if (!k(b))
                this.containerWidth = Rb(c, "width");
            if (!k(a))
                this.containerHeight = Rb(c, "height");
            this.chartWidth = R(0, b || this.containerWidth || 600);
            this.chartHeight = R(0, n(a, this.containerHeight > 19 ? this.containerHeight : 400));
        },
        cloneRenderTo: function(a) {
            var b = this.renderToClone, c = this.container;
            a ? b && (this.renderTo.appendChild(c), B(b), delete this.renderToClone) : (c && c.parentNode === this.renderTo && this.renderTo.removeChild(c),
                    this.renderToClone = b = this.renderTo.cloneNode(0), o(b, {
                position: "absolute",
                top: "-9999px",
                display: "block"
            }), b.style.setProperty && b.style.setProperty("display", "block", "important"),
                    L.body.appendChild(b), c && b.appendChild(c));
        },
        getContainer: function() {
            var b, e = this.options.chart, f, g, h;
            this.renderTo = b = e.renderTo;
            h = "highcharts-" + kb++;
            if (d(b))
                this.renderTo = b = L.getElementById(b);
            b || rb(13, !0);
            f = c(l(b, "data-highcharts-chart"));
            !isNaN(f) && tb[f] && tb[f].hasRendered && tb[f].destroy();
            l(b, "data-highcharts-chart", this.index);
            b.innerHTML = "";
            !e.skipClone && !b.offsetWidth && this.cloneRenderTo();
            this.getChartSize();
            f = this.chartWidth;
            g = this.chartHeight;
            this.container = b = p(vb, {
                className: "highcharts-container" + (e.className ? " " + e.className : ""),
                id: h
            }, a({
                position: "relative",
                overflow: "hidden",
                width: f + "px",
                height: g + "px",
                textAlign: "left",
                lineHeight: "normal",
                zIndex: 0,
                "-webkit-tap-highlight-color": "rgba(0,0,0,0)"
            }, e.style), this.renderToClone || b);
            this._cursor = b.style.cursor;
            this.renderer = e.forExport ? new hc(b, f, g, e.style, !0) : new hb(b, f, g, e.style);
            gb && this.renderer.create(this, b, f, g);
        },
        getMargins: function() {
            var a = this.spacing, b, c = this.legend, d = this.margin, e = this.options.legend, f = n(e.margin, 20), g = e.x, h = e.y, i = e.align, j = e.verticalAlign, l = this.titleOffset;
            this.resetMargins();
            b = this.axisOffset;
            if (l && !k(d[0]))
                this.plotTop = R(this.plotTop, l + this.options.title.margin + a[0]);
            if (c.display && !e.floating)
                if ("right" === i) {
                    if (!k(d[1]))
                        this.marginRight = R(this.marginRight, c.legendWidth - g + f + a[1]);
                } else if ("left" === i) {
                    if (!k(d[3]))
                        this.plotLeft = R(this.plotLeft, c.legendWidth + g + f + a[3]);
                } else if ("top" === j) {
                    if (!k(d[0]))
                        this.plotTop = R(this.plotTop, c.legendHeight + h + f + a[0]);
                } else if ("bottom" === j && !k(d[2]))
                    this.marginBottom = R(this.marginBottom, c.legendHeight - h + f + a[2]);
            this.extraBottomMargin && (this.marginBottom += this.extraBottomMargin);
            this.extraTopMargin && (this.plotTop += this.extraTopMargin);
            this.hasCartesianSeries && Ub(this.axes, function(a) {
                a.getOffset();
            });
            k(d[3]) || (this.plotLeft += b[3]);
            k(d[0]) || (this.plotTop += b[0]);
            k(d[2]) || (this.marginBottom += b[2]);
            k(d[1]) || (this.marginRight += b[1]);
            this.setChartSize();
        },
        reflow: function(a) {
            var b = this, c = b.options.chart, d = b.renderTo, e = c.width || Rb(d, "width"), f = c.height || Rb(d, "height"), c = a ? a.target : M, d = function() {
                if (b.container)
                    b.setSize(e, f, !1), b.hasUserSize = null;
            };
            if (!b.hasUserSize && e && f && (c === M || c === L)) {
                if (e !== b.containerWidth || f !== b.containerHeight)
                    clearTimeout(b.reflowTimeout),
                            a ? b.reflowTimeout = setTimeout(d, 100) : d();
                b.containerWidth = e;
                b.containerHeight = f;
            }
        },
        initReflow: function() {
            var a = this, b = function(b) {
                a.reflow(b);
            };
            Yb(M, "resize", b);
            Yb(a, "destroy", function() {
                Zb(M, "resize", b);
            });
        },
        setSize: function(a, b, c) {
            var d = this, e, f, g;
            d.isResizing += 1;
            g = function() {
                d && $b(d, "endResize", null, function() {
                    d.isResizing -= 1;
                });
            };
            D(c, d);
            d.oldChartHeight = d.chartHeight;
            d.oldChartWidth = d.chartWidth;
            if (k(a))
                d.chartWidth = e = R(0, O(a)), d.hasUserSize = !!e;
            if (k(b))
                d.chartHeight = f = R(0, O(b));
            (ob ? ac : o)(d.container, {
                width: e + "px",
                height: f + "px"
            }, ob);
            d.setChartSize(!0);
            d.renderer.setSize(e, f, c);
            d.maxTicks = null;
            Ub(d.axes, function(a) {
                a.isDirty = !0;
                a.setScale();
            });
            Ub(d.series, function(a) {
                a.isDirty = !0;
            });
            d.isDirtyLegend = !0;
            d.isDirtyBox = !0;
            d.layOutTitles();
            d.getMargins();
            d.redraw(c);
            d.oldChartHeight = null;
            $b(d, "resize");
            ob === !1 ? g() : setTimeout(g, ob && ob.duration || 500);
        },
        setChartSize: function(a) {
            var b = this.inverted, c = this.renderer, d = this.chartWidth, e = this.chartHeight, f = this.options.chart, g = this.spacing, h = this.clipOffset, i, j, k, l;
            this.plotLeft = i = O(this.plotLeft);
            this.plotTop = j = O(this.plotTop);
            this.plotWidth = k = R(0, O(d - i - this.marginRight));
            this.plotHeight = l = R(0, O(e - j - this.marginBottom));
            this.plotSizeX = b ? l : k;
            this.plotSizeY = b ? k : l;
            this.plotBorderWidth = f.plotBorderWidth || 0;
            this.spacingBox = c.spacingBox = {
                x: g[3],
                y: g[0],
                width: d - g[3] - g[1],
                height: e - g[0] - g[2]
            };
            this.plotBox = c.plotBox = {
                x: i,
                y: j,
                width: k,
                height: l
            };
            d = 2 * P(this.plotBorderWidth / 2);
            b = Q(R(d, h[3]) / 2);
            c = Q(R(d, h[0]) / 2);
            this.clipBox = {
                x: b,
                y: c,
                width: P(this.plotSizeX - R(d, h[1]) / 2 - b),
                height: R(0, P(this.plotSizeY - R(d, h[2]) / 2 - c))
            };
            a || Ub(this.axes, function(a) {
                a.setAxisSize();
                a.setAxisTranslation();
            });
        },
        resetMargins: function() {
            var a = this.spacing, b = this.margin;
            this.plotTop = n(b[0], a[0]);
            this.marginRight = n(b[1], a[1]);
            this.marginBottom = n(b[2], a[2]);
            this.plotLeft = n(b[3], a[3]);
            this.axisOffset = [0, 0, 0, 0];
            this.clipOffset = [0, 0, 0, 0];
        },
        drawChartBox: function() {
            var a = this.options.chart, b = this.renderer, c = this.chartWidth, d = this.chartHeight, e = this.chartBackground, f = this.plotBackground, g = this.plotBorder, h = this.plotBGImage, i = a.borderWidth || 0, j = a.backgroundColor, k = a.plotBackgroundColor, l = a.plotBackgroundImage, m = a.plotBorderWidth || 0, n, o = this.plotLeft, p = this.plotTop, q = this.plotWidth, r = this.plotHeight, s = this.plotBox, t = this.clipRect, u = this.clipBox;
            n = i + (a.shadow ? 8 : 0);
            if (i || j)
                if (e)
                    e.animate(e.crisp({
                        width: c - n,
                        height: d - n
                    }));
                else {
                    e = {
                        fill: j || wb
                    };
                    if (i)
                        e.stroke = a.borderColor, e["stroke-width"] = i;
                    this.chartBackground = b.rect(n / 2, n / 2, c - n, d - n, a.borderRadius, i).attr(e).addClass("highcharts-background").add().shadow(a.shadow);
                }
            if (k)
                f ? f.animate(s) : this.plotBackground = b.rect(o, p, q, r, 0).attr({
                    fill: k
                }).add().shadow(a.plotShadow);
            if (l)
                h ? h.animate(s) : this.plotBGImage = b.image(l, o, p, q, r).add();
            t ? t.animate({
                width: u.width,
                height: u.height
            }) : this.clipRect = b.clipRect(u);
            if (m)
                g ? g.animate(g.crisp({
                    x: o,
                    y: p,
                    width: q,
                    height: r,
                    strokeWidth: -m
                })) : this.plotBorder = b.rect(o, p, q, r, 0, -m).attr({
                    stroke: a.plotBorderColor,
                    "stroke-width": m,
                    fill: wb,
                    zIndex: 1
                }).add();
            this.isDirtyBox = !1;
        },
        propFromSeries: function() {
            var a = this, b = a.options.chart, c, d = a.options.series, e, f;
            Ub(["inverted", "angular", "polar"], function(g) {
                c = Nb[b.type || b.defaultSeriesType];
                f = a[g] || b[g] || c && c.prototype[g];
                for (e = d && d.length; !f && e--; )
                    (c = Nb[d[e].type]) && c.prototype[g] && (f = !0);
                a[g] = f;
            });
        },
        linkSeries: function() {
            var a = this, b = a.series;
            Ub(b, function(a) {
                a.linkedSeries.length = 0;
            });
            Ub(b, function(b) {
                var c = b.options.linkedTo;
                if (d(c) && (c = ":previous" === c ? a.series[b.index - 1] : a.get(c)))
                    c.linkedSeries.push(b),
                            b.linkedParent = c;
            });
        },
        renderSeries: function() {
            Ub(this.series, function(a) {
                a.translate();
                a.setTooltipPoints && a.setTooltipPoints();
                a.render();
            });
        },
        renderLabels: function() {
            var b = this, d = b.options.labels;
            d.items && Ub(d.items, function(e) {
                var f = a(d.style, e.style), g = c(f.left) + b.plotLeft, h = c(f.top) + b.plotTop + 12;
                delete f.left;
                delete f.top;
                b.renderer.text(e.html, g, h).attr({
                    zIndex: 2
                }).css(f).add();
            });
        },
        render: function() {
            var a = this.axes, b = this.renderer, c = this.options;
            this.setTitle();
            this.legend = new sc(this, c.legend);
            this.getStacks();
            Ub(a, function(a) {
                a.setScale();
            });
            this.getMargins();
            this.maxTicks = null;
            Ub(a, function(a) {
                a.setTickPositions(!0);
                a.setMaxTicks();
            });
            this.adjustTickAmounts();
            this.getMargins();
            this.drawChartBox();
            this.hasCartesianSeries && Ub(a, function(a) {
                a.render();
            });
            if (!this.seriesGroup)
                this.seriesGroup = b.g("series-group").attr({
                    zIndex: 3
                }).add();
            this.renderSeries();
            this.renderLabels();
            this.showCredits(c.credits);
            this.hasRendered = !0;
        },
        showCredits: function(a) {
            if (a.enabled && !this.credits)
                this.credits = this.renderer.text(a.text, 0, 0).on("click", function() {
                    if (a.href)
                        location.href = a.href;
                }).attr({
                    align: a.position.align,
                    zIndex: 8
                }).css(a.style).add().align(a.position);
        },
        destroy: function() {
            var a = this, b = a.axes, c = a.series, d = a.container, e, f = d && d.parentNode;
            $b(a, "destroy");
            tb[a.index] = K;
            ub--;
            a.renderTo.removeAttribute("data-highcharts-chart");
            Zb(a);
            for (e = b.length; e--; )
                b[e] = b[e].destroy();
            for (e = c.length; e--; )
                c[e] = c[e].destroy();
            Ub("title,subtitle,chartBackground,plotBackground,plotBGImage,plotBorder,seriesGroup,clipRect,credits,pointer,scroller,rangeSelector,legend,resetZoomButton,tooltip,renderer".split(","), function(b) {
                var c = a[b];
                c && c.destroy && (a[b] = c.destroy());
            });
            if (d)
                d.innerHTML = "", Zb(d), f && B(d);
            for (e in a)
                delete a[e];
        },
        isReadyToRender: function() {
            var a = this;
            return !eb && M == M.top && "complete" !== L.readyState || gb && !M.canvg ? (gb ? kc.push(function() {
                a.firstRender();
            }, a.options.global.canvasToolsURL) : L.attachEvent("onreadystatechange", function() {
                L.detachEvent("onreadystatechange", a.firstRender);
                "complete" === L.readyState && a.firstRender();
            }), !1) : !0;
        },
        firstRender: function() {
            var a = this, b = a.options, c = a.callback;
            if (a.isReadyToRender()) {
                a.getContainer();
                $b(a, "init");
                a.resetMargins();
                a.setChartSize();
                a.propFromSeries();
                a.getAxes();
                Ub(b.series || [], function(b) {
                    a.initSeries(b);
                });
                a.linkSeries();
                $b(a, "beforeRender");
                if (Ob.Pointer)
                    a.pointer = new nc(a, b);
                a.render();
                a.renderer.draw();
                c && c.apply(a, [a]);
                Ub(a.callbacks, function(b) {
                    b.apply(a, [a]);
                });
                a.cloneRenderTo(!0);
                $b(a, "load");
            }
        },
        splashArray: function(a, b) {
            var c = b[a], c = e(c) ? c : [c, c, c, c];
            return [n(b[a + "Top"], c[0]), n(b[a + "Right"], c[1]), n(b[a + "Bottom"], c[2]), n(b[a + "Left"], c[3])];
        }
    };
    I.prototype.callbacks = [];
    ic = Ob.CenteredSeriesMixin = {
        getCenter: function() {
            var a = this.options, b = this.chart, d = 2 * (a.slicedOffset || 0), e, f = b.plotWidth - 2 * d, g = b.plotHeight - 2 * d, b = a.center, a = [n(b[0], "50%"), n(b[1], "50%"), a.size || "100%", a.innerSize || 0], h = S(f, g), i;
            return Xb(a, function(a, b) {
                i = /%$/.test(a);
                e = b < 2 || 2 === b && i;
                return (i ? [f, g, h, h][b] * c(a) / 100 : a) + (e ? d : 0);
            });
        }
    };
    var tc = function() {
    };
    tc.prototype = {
        init: function(a, b, c) {
            this.series = a;
            this.applyOptions(b, c);
            this.pointAttr = {};
            if (a.options.colorByPoint && (b = a.options.colors || a.chart.options.colors, this.color = this.color || b[a.colorCounter++],
                    a.colorCounter === b.length))
                a.colorCounter = 0;
            a.chart.pointCount++;
            return this;
        },
        applyOptions: function(b, c) {
            var d = this.series, e = d.options.pointValKey || d.pointValKey, b = tc.prototype.optionsToObject.call(this, b);
            a(this, b);
            this.options = this.options ? a(this.options, b) : b;
            if (e)
                this.y = this[e];
            if (this.x === K && d)
                this.x = c === K ? d.autoIncrement() : c;
            return this;
        },
        optionsToObject: function(a) {
            var b = {}, c = this.series, d = c.pointArrayMap || ["y"], e = d.length, g = 0, h = 0;
            if ("number" === typeof a || null === a)
                b[d[0]] = a;
            else if (f(a)) {
                if (a.length > e) {
                    c = typeof a[0];
                    if ("string" === c)
                        b.name = a[0];
                    else if ("number" === c)
                        b.x = a[0];
                    g++;
                }
                for (; h < e; )
                    b[d[h++]] = a[g++];
            } else if ("object" === typeof a) {
                b = a;
                if (a.dataLabels)
                    c._hasPointLabels = !0;
                if (a.marker)
                    c._hasPointMarkers = !0;
            }
            return b;
        },
        destroy: function() {
            var a = this.series.chart, b = a.hoverPoints, c;
            a.pointCount--;
            if (b && (this.setState(), j(b, this), !b.length))
                a.hoverPoints = null;
            if (this === a.hoverPoint)
                this.onMouseOut();
            if (this.graphic || this.dataLabel)
                Zb(this), this.destroyElements();
            this.legendItem && a.legend.destroyItem(this);
            for (c in this)
                this[c] = null;
        },
        destroyElements: function() {
            for (var a = "graphic,dataLabel,dataLabelUpper,group,connector,shadowGroup".split(","), b, c = 6; c--; )
                b = a[c],
                        this[b] && (this[b] = this[b].destroy());
        },
        getLabelConfig: function() {
            return {
                x: this.category,
                y: this.y,
                key: this.name || this.category,
                series: this.series,
                point: this,
                percentage: this.percentage,
                total: this.total || this.stackTotal
            };
        },
        tooltipFormatter: function(a) {
            var b = this.series, c = b.tooltipOptions, d = n(c.valueDecimals, ""), e = c.valuePrefix || "", f = c.valueSuffix || "";
            Ub(b.pointArrayMap || ["y"], function(b) {
                b = "{point." + b;
                if (e || f)
                    a = a.replace(b + "}", e + b + "}" + f);
                a = a.replace(b + "}", b + ":,." + d + "f}");
            });
            return u(a, {
                point: this,
                series: this.series
            });
        },
        firePointEvent: function(a, b, c) {
            var d = this, e = this.series.options;
            (e.point.events[a] || d.options && d.options.events && d.options.events[a]) && this.importEvents();
            "click" === a && e.allowPointSelect && (c = function(a) {
                d.select(null, a.ctrlKey || a.metaKey || a.shiftKey);
            });
            $b(this, a, b, c);
        }
    };
    var uc = function() {
    };
    uc.prototype = {
        isCartesian: !0,
        type: "line",
        pointClass: tc,
        sorted: !0,
        requireSorting: !0,
        pointAttrToOptions: {
            stroke: "lineColor",
            "stroke-width": "lineWidth",
            fill: "fillColor",
            r: "radius"
        },
        axisTypes: ["xAxis", "yAxis"],
        colorCounter: 0,
        parallelArrays: ["x", "y"],
        init: function(b, c) {
            var d = this, e, f, g = b.series, h = function(a, b) {
                return n(a.options.index, a._i) - n(b.options.index, b._i);
            };
            d.chart = b;
            d.options = c = d.setOptions(c);
            d.linkedSeries = [];
            d.bindAxes();
            a(d, {
                name: c.name,
                state: "",
                pointAttr: {},
                visible: c.visible !== !1,
                selected: c.selected === !0
            });
            if (gb)
                c.animation = !1;
            f = c.events;
            for (e in f)
                Yb(d, e, f[e]);
            if (f && f.click || c.point && c.point.events && c.point.events.click || c.allowPointSelect)
                b.runTrackerClick = !0;
            d.getColor();
            d.getSymbol();
            Ub(d.parallelArrays, function(a) {
                d[a + "Data"] = [];
            });
            d.setData(c.data, !1);
            if (d.isCartesian)
                b.hasCartesianSeries = !0;
            g.push(d);
            d._i = g.length - 1;
            x(g, h);
            this.yAxis && x(this.yAxis.series, h);
            Ub(g, function(a, b) {
                a.index = b;
                a.name = a.name || "Series " + (b + 1);
            });
        },
        bindAxes: function() {
            var a = this, b = a.options, c = a.chart, d;
            Ub(a.axisTypes || [], function(e) {
                Ub(c[e], function(c) {
                    d = c.options;
                    if (b[e] === d.index || b[e] !== K && b[e] === d.id || b[e] === K && 0 === d.index)
                        c.series.push(a),
                                a[e] = c, c.isDirty = !0;
                });
                !a[e] && a.optionalAxis !== e && rb(18, !0);
            });
        },
        updateParallelArrays: function(a, b) {
            var c = a.series, d = arguments;
            Ub(c.parallelArrays, "number" === typeof b ? function(d) {
                var e = "y" === d && c.toYData ? c.toYData(a) : a[d];
                c[d + "Data"][b] = e;
            } : function(a) {
                Array.prototype[b].apply(c[a + "Data"], Array.prototype.slice.call(d, 2));
            });
        },
        autoIncrement: function() {
            var a = this.options, b = this.xIncrement, b = n(b, a.pointStart, 0);
            this.pointInterval = n(this.pointInterval, a.pointInterval, 1);
            this.xIncrement = b + this.pointInterval;
            return b;
        },
        getSegments: function() {
            var a = -1, b = [], c, d = this.points, e = d.length;
            if (e)
                if (this.options.connectNulls) {
                    for (c = e; c--; )
                        null === d[c].y && d.splice(c, 1);
                    d.length && (b = [d]);
                } else
                    Ub(d, function(c, f) {
                        null === c.y ? (f > a + 1 && b.push(d.slice(a + 1, f)), a = f) : f === e - 1 && b.push(d.slice(a + 1, f + 1));
                    });
            this.segments = b;
        },
        setOptions: function(a) {
            var c = this.chart, d = c.options.plotOptions, c = c.userOptions || {}, e = c.plotOptions || {}, f = d[this.type];
            this.userOptions = a;
            d = b(f, d.series, a);
            this.tooltipOptions = b(mb.tooltip, mb.plotOptions[this.type].tooltip, c.tooltip, e.series && e.series.tooltip, e[this.type] && e[this.type].tooltip, a.tooltip);
            null === f.marker && delete d.marker;
            return d;
        },
        getCyclic: function(a, b, c) {
            var d = this.userOptions, e = "_" + a + "Index", f = a + "Counter";
            b || (k(d[e]) ? b = d[e] : (d[e] = b = this.chart[f] % c.length, this.chart[f] += 1),
                    b = c[b]);
            this[a] = b;
        },
        getColor: function() {
            this.options.colorByPoint || this.getCyclic("color", this.options.color || cc[this.type].color, this.chart.options.colors);
        },
        getSymbol: function() {
            var a = this.options.marker;
            this.getCyclic("symbol", a.symbol, this.chart.options.symbols);
            if (/^url/.test(this.symbol))
                a.radius = 0;
        },
        drawLegendSymbol: Qb.drawLineMarker,
        setData: function(a, b, c, e) {
            var h = this, i = h.points, j = i && i.length || 0, k, l = h.options, m = h.chart, o = null, p = h.xAxis, q = p && !!p.categories, r = h.tooltipPoints, s = l.turboThreshold, t = this.xData, u = this.yData, v = (k = h.pointArrayMap) && k.length, a = a || [];
            k = a.length;
            b = n(b, !0);
            if (e !== !1 && k && j === k && !h.cropped && !h.hasGroupedData)
                Ub(a, function(a, b) {
                    i[b].update(a, !1, null, !1);
                });
            else {
                h.xIncrement = null;
                h.pointRange = q ? 1 : l.pointRange;
                h.colorCounter = 0;
                Ub(this.parallelArrays, function(a) {
                    h[a + "Data"].length = 0;
                });
                if (s && k > s) {
                    for (c = 0; null === o && c < k; )
                        o = a[c], c++;
                    if (g(o)) {
                        q = n(l.pointStart, 0);
                        l = n(l.pointInterval, 1);
                        for (c = 0; c < k; c++)
                            t[c] = q, u[c] = a[c], q += l;
                        h.xIncrement = q;
                    } else if (f(o))
                        if (v)
                            for (c = 0; c < k; c++)
                                l = a[c], t[c] = l[0], u[c] = l.slice(1, v + 1);
                        else
                            for (c = 0; c < k; c++)
                                l = a[c],
                                        t[c] = l[0], u[c] = l[1];
                    else
                        rb(12);
                } else
                    for (c = 0; c < k; c++)
                        if (a[c] !== K && (l = {
                            series: h
                        }, h.pointClass.prototype.applyOptions.apply(l, [a[c]]), h.updateParallelArrays(l, c),
                                q && l.name))
                            p.names[l.x] = l.name;
                d(u[0]) && rb(14, !0);
                h.data = [];
                h.options.data = a;
                for (c = j; c--; )
                    i[c] && i[c].destroy && i[c].destroy();
                if (r)
                    r.length = 0;
                if (p)
                    p.minRange = p.userMinRange;
                h.isDirty = h.isDirtyData = m.isDirtyBox = !0;
                c = !1;
            }
            b && m.redraw(c);
        },
        processData: function(a) {
            var b = this.xData, c = this.yData, d = b.length, e;
            e = 0;
            var f, g, h = this.xAxis, i, j = this.options;
            i = j.cropThreshold;
            var k = 0, l = this.isCartesian, m, n;
            if (l && !this.isDirty && !h.isDirty && !this.yAxis.isDirty && !a)
                return !1;
            if (h)
                m = h.getExtremes(), n = m.min, m = m.max;
            if (l && this.sorted && (!i || d > i || this.forceCrop))
                if (b[d - 1] < n || b[0] > m)
                    b = [],
                            c = [];
                else if (b[0] < n || b[d - 1] > m)
                    e = this.cropData(this.xData, this.yData, n, m),
                            b = e.xData, c = e.yData, e = e.start, f = !0, k = b.length;
            for (i = b.length - 1; i >= 0; i--)
                d = b[i] - b[i - 1], !f && b[i] > n && b[i] < m && k++,
                        d > 0 && (g === K || d < g) ? g = d : d < 0 && this.requireSorting && rb(15);
            this.cropped = f;
            this.cropStart = e;
            this.processedXData = b;
            this.processedYData = c;
            this.activePointCount = k;
            if (null === j.pointRange)
                this.pointRange = g || 1;
            this.closestPointRange = g;
        },
        cropData: function(a, b, c, d) {
            var e = a.length, f = 0, g = e, h = n(this.cropShoulder, 1), i;
            for (i = 0; i < e; i++)
                if (a[i] >= c) {
                    f = R(0, i - h);
                    break;
                }
            for (; i < e; i++)
                if (a[i] > d) {
                    g = i + h;
                    break;
                }
            return {
                xData: a.slice(f, g),
                yData: b.slice(f, g),
                start: f,
                end: g
            };
        },
        generatePoints: function() {
            var a = this.options.data, b = this.data, c, d = this.processedXData, e = this.processedYData, f = this.pointClass, g = d.length, h = this.cropStart || 0, i, j = this.hasGroupedData, k, l = [], n;
            if (!b && !j)
                b = [], b.length = a.length, b = this.data = b;
            for (n = 0; n < g; n++)
                i = h + n, j ? l[n] = new f().init(this, [d[n]].concat(m(e[n]))) : (b[i] ? k = b[i] : a[i] !== K && (b[i] = k = new f().init(this, a[i], d[n])),
                        l[n] = k), l[n].index = i;
            if (b && (g !== (c = b.length) || j))
                for (n = 0; n < c; n++)
                    if (n === h && !j && (n += g),
                            b[n])
                        b[n].destroyElements(), b[n].plotX = K;
            this.data = b;
            this.points = l;
        },
        getExtremes: function(a) {
            var b = this.yAxis, c = this.processedXData, d, e = [], f = 0;
            d = this.xAxis.getExtremes();
            var g = d.min, h = d.max, i, j, k, l, a = a || this.stackedYData || this.processedYData;
            d = a.length;
            for (l = 0; l < d; l++)
                if (j = c[l], k = a[l], i = null !== k && k !== K && (!b.isLog || k.length || k > 0),
                        j = this.getExtremesFromAll || this.cropped || (c[l + 1] || j) >= g && (c[l - 1] || j) <= h,
                        i && j)
                    if (i = k.length)
                        for (; i--; )
                            null !== k[i] && (e[f++] = k[i]);
                    else
                        e[f++] = k;
            this.dataMin = n(void 0, y(e));
            this.dataMax = n(void 0, z(e));
        },
        translate: function() {
            this.processedXData || this.processData();
            this.generatePoints();
            for (var a = this.options, b = a.stacking, c = this.xAxis, d = c.categories, e = this.yAxis, f = this.points, h = f.length, i = !!this.modifyValue, j = a.pointPlacement, l = "between" === j || g(j), m = a.threshold, a = 0; a < h; a++) {
                var o = f[a], p = o.x, q = o.y, r = o.low, s = b && e.stacks[(this.negStacks && q < m ? "-" : "") + this.stackKey];
                if (e.isLog && q <= 0)
                    o.y = q = null, rb(10);
                o.plotX = c.translate(p, 0, 0, 0, 1, j, "flags" === this.type);
                if (b && this.visible && s && s[p])
                    s = s[p], q = s.points[this.index + "," + a],
                            r = q[0], q = q[1], 0 === r && (r = n(m, e.min)), e.isLog && r <= 0 && (r = null),
                            o.total = o.stackTotal = s.total, o.percentage = s.total && o.y / s.total * 100,
                            o.stackY = q, s.setOffset(this.pointXOffset || 0, this.barW || 0);
                o.yBottom = k(r) ? e.translate(r, 0, 1, 0, 1) : null;
                i && (q = this.modifyValue(q, o));
                o.plotY = "number" === typeof q && 1 / 0 !== q ? e.translate(q, 0, 1, 0, 1) : K;
                o.clientX = l ? c.translate(p, 0, 0, 0, 1) : o.plotX;
                o.negative = o.y < (m || 0);
                o.category = d && d[o.x] !== K ? d[o.x] : o.x;
            }
            this.getSegments();
        },
        animate: function(b) {
            var c = this.chart, d = c.renderer, f;
            f = this.options.animation;
            var g = this.clipBox || c.clipBox, h = c.inverted, i;
            if (f && !e(f))
                f = cc[this.type].animation;
            i = ["_sharedClip", f.duration, f.easing, g.height].join(",");
            b ? (b = c[i], f = c[i + "m"], b || (c[i] = b = d.clipRect(a(g, {
                width: 0
            })), c[i + "m"] = f = d.clipRect(-99, h ? -c.plotLeft : -c.plotTop, 99, h ? c.chartWidth : c.chartHeight)),
                    this.group.clip(b), this.markerGroup.clip(f), this.sharedClipKey = i) : ((b = c[i]) && b.animate({
                width: c.plotSizeX
            }, f), c[i + "m"] && c[i + "m"].animate({
                width: c.plotSizeX + 99
            }, f), this.animate = null);
        },
        afterAnimate: function() {
            var a = this.chart, b = this.sharedClipKey, c = this.group, d = this.clipBox;
            if (c && this.options.clip !== !1) {
                if (!b || !d)
                    c.clip(d ? a.renderer.clipRect(d) : a.clipRect);
                this.markerGroup.clip();
            }
            $b(this, "afterAnimate");
            setTimeout(function() {
                b && a[b] && (d || (a[b] = a[b].destroy()), a[b + "m"] && (a[b + "m"] = a[b + "m"].destroy()));
            }, 100);
        },
        drawPoints: function() {
            var b, c = this.points, d = this.chart, e, f, g, h, i, j, k, l, m = this.options.marker, o = this.pointAttr[""], p, q, r, s = this.markerGroup, t = n(m.enabled, !this.requireSorting || this.activePointCount < .5 * this.xAxis.len / m.radius);
            if (m.enabled !== !1 || this._hasPointMarkers)
                for (g = c.length; g--; )
                    if (h = c[g],
                            e = P(h.plotX), f = h.plotY, l = h.graphic, p = h.marker || {}, q = !!h.marker,
                            b = t && p.enabled === K || p.enabled, r = d.isInsidePlot(O(e), f, d.inverted),
                            b && f !== K && !isNaN(f) && null !== h.y) {
                        if (b = h.pointAttr[h.selected ? "select" : ""] || o, i = b.r, j = n(p.symbol, this.symbol),
                                k = 0 === j.indexOf("url"), l)
                            l[r ? "show" : "hide"](!0).animate(a({
                                x: e - i,
                                y: f - i
                            }, l.symbolName ? {
                                width: 2 * i,
                                height: 2 * i
                            } : {}));
                        else if (r && (i > 0 || k))
                            h.graphic = d.renderer.symbol(j, e - i, f - i, 2 * i, 2 * i, q ? p : m).attr(b).add(s);
                    } else if (l)
                        h.graphic = l.destroy();
        },
        convertAttribs: function(a, b, c, d) {
            var e = this.pointAttrToOptions, f, g, h = {}, a = a || {}, b = b || {}, c = c || {}, d = d || {};
            for (f in e)
                g = e[f], h[f] = n(a[g], b[f], c[f], d[f]);
            return h;
        },
        getAttribs: function() {
            var b = this, c = b.options, d = cc[b.type].marker ? c.marker : c, e = d.states, f = e.hover, g, h = b.color;
            g = {
                stroke: h,
                fill: h
            };
            var i = b.points || [], j, l = [], m, n = b.pointAttrToOptions;
            m = b.hasPointSpecificOptions;
            var o = c.negativeColor, p = d.lineColor, q = d.fillColor;
            j = c.turboThreshold;
            var r;
            c.marker ? (f.radius = f.radius || d.radius + f.radiusPlus, f.lineWidth = f.lineWidth || d.lineWidth + f.lineWidthPlus) : f.color = f.color || gc(f.color || h).brighten(f.brightness).get();
            l[""] = b.convertAttribs(d, g);
            Ub(["hover", "select"], function(a) {
                l[a] = b.convertAttribs(e[a], l[""]);
            });
            b.pointAttr = l;
            h = i.length;
            if (!j || h < j || m)
                for (; h--; ) {
                    j = i[h];
                    if ((d = j.options && j.options.marker || j.options) && d.enabled === !1)
                        d.radius = 0;
                    if (j.negative && o)
                        j.color = j.fillColor = o;
                    m = c.colorByPoint || j.color;
                    if (j.options)
                        for (r in n)
                            k(d[n[r]]) && (m = !0);
                    if (m) {
                        d = d || {};
                        m = [];
                        e = d.states || {};
                        g = e.hover = e.hover || {};
                        if (!c.marker)
                            g.color = g.color || !j.options.color && f.color || gc(j.color).brighten(g.brightness || f.brightness).get();
                        g = {
                            color: j.color
                        };
                        if (!q)
                            g.fillColor = j.color;
                        if (!p)
                            g.lineColor = j.color;
                        m[""] = b.convertAttribs(a(g, d), l[""]);
                        m.hover = b.convertAttribs(e.hover, l.hover, m[""]);
                        m.select = b.convertAttribs(e.select, l.select, m[""]);
                    } else
                        m = l;
                    j.pointAttr = m;
                }
        },
        destroy: function() {
            var a = this, b = a.chart, c = /AppleWebKit\/533/.test(Y), d, e, f = a.data || [], g, h, i;
            $b(a, "destroy");
            Zb(a);
            Ub(a.axisTypes || [], function(b) {
                if (i = a[b])
                    j(i.series, a), i.isDirty = i.forceRedraw = !0;
            });
            a.legendItem && a.chart.legend.destroyItem(a);
            for (e = f.length; e--; )
                (g = f[e]) && g.destroy && g.destroy();
            a.points = null;
            clearTimeout(a.animationTimeout);
            Ub("area,graph,dataLabelsGroup,group,markerGroup,tracker,graphNeg,areaNeg,posClip,negClip".split(","), function(b) {
                a[b] && (d = c && "group" === b ? "hide" : "destroy", a[b][d]());
            });
            if (b.hoverSeries === a)
                b.hoverSeries = null;
            j(b.series, a);
            for (h in a)
                delete a[h];
        },
        getSegmentPath: function(a) {
            var b = this, c = [], d = b.options.step;
            Ub(a, function(e, f) {
                var g = e.plotX, h = e.plotY, i;
                b.getPointSpline ? c.push.apply(c, b.getPointSpline(a, e, f)) : (c.push(f ? "L" : "M"),
                        d && f && (i = a[f - 1], "right" === d ? c.push(i.plotX, h) : "center" === d ? c.push((i.plotX + g) / 2, i.plotY, (i.plotX + g) / 2, h) : c.push(g, i.plotY)),
                        c.push(e.plotX, e.plotY));
            });
            return c;
        },
        getGraphPath: function() {
            var a = this, b = [], c, d = [];
            Ub(a.segments, function(e) {
                c = a.getSegmentPath(e);
                e.length > 1 ? b = b.concat(c) : d.push(e[0]);
            });
            a.singlePoints = d;
            return a.graphPath = b;
        },
        drawGraph: function() {
            var a = this, b = this.options, c = [["graph", b.lineColor || this.color]], d = b.lineWidth, e = b.dashStyle, f = "square" !== b.linecap, g = this.getGraphPath(), h = b.negativeColor;
            h && c.push(["graphNeg", h]);
            Ub(c, function(c, h) {
                var i = c[0], j = a[i];
                if (j)
                    bc(j), j.animate({
                        d: g
                    });
                else if (d && g.length)
                    j = {
                        stroke: c[1],
                        "stroke-width": d,
                        fill: wb,
                        zIndex: 1
                    }, e ? j.dashstyle = e : f && (j["stroke-linecap"] = j["stroke-linejoin"] = "round"),
                            a[i] = a.chart.renderer.path(g).attr(j).add(a.group).shadow(!h && b.shadow);
            });
        },
        clipNeg: function() {
            var a = this.options, b = this.chart, c = b.renderer, d = a.negativeColor || a.negativeFillColor, e, f = this.graph, g = this.area, h = this.posClip, i = this.negClip;
            e = b.chartWidth;
            var j = b.chartHeight, k = R(e, j), l = this.yAxis;
            if (d && (f || g)) {
                d = O(l.toPixels(a.threshold || 0, !0));
                d < 0 && (k -= d);
                a = {
                    x: 0,
                    y: 0,
                    width: k,
                    height: d
                };
                k = {
                    x: 0,
                    y: d,
                    width: k,
                    height: k
                };
                if (b.inverted)
                    a.height = k.y = b.plotWidth - d, c.isVML && (a = {
                        x: b.plotWidth - d - b.plotLeft,
                        y: 0,
                        width: e,
                        height: j
                    }, k = {
                        x: d + b.plotLeft - e,
                        y: 0,
                        width: b.plotLeft + d,
                        height: e
                    });
                l.reversed ? (b = k, e = a) : (b = a, e = k);
                h ? (h.animate(b), i.animate(e)) : (this.posClip = h = c.clipRect(b), this.negClip = i = c.clipRect(e),
                        f && this.graphNeg && (f.clip(h), this.graphNeg.clip(i)), g && (g.clip(h), this.areaNeg.clip(i)));
            }
        },
        invertGroups: function() {
            function a() {
                var a = {
                    width: b.yAxis.len,
                    height: b.xAxis.len
                };
                Ub(["group", "markerGroup"], function(c) {
                    b[c] && b[c].attr(a).invert();
                });
            }
            var b = this, c = b.chart;
            if (b.xAxis)
                Yb(c, "resize", a), Yb(b, "destroy", function() {
                    Zb(c, "resize", a);
                }), a(), b.invertGroups = a;
        },
        plotGroup: function(a, b, c, d, e) {
            var f = this[a], g = !f;
            g && (this[a] = f = this.chart.renderer.g(b).attr({
                visibility: c,
                zIndex: d || .1
            }).add(e));
            f[g ? "attr" : "animate"](this.getPlotBox());
            return f;
        },
        getPlotBox: function() {
            var a = this.chart, b = this.xAxis, c = this.yAxis;
            if (a.inverted)
                b = c, c = this.xAxis;
            return {
                translateX: b ? b.left : a.plotLeft,
                translateY: c ? c.top : a.plotTop,
                scaleX: 1,
                scaleY: 1
            };
        },
        render: function() {
            var a = this, b = a.chart, c, d = a.options, e = (c = d.animation) && !!a.animate && b.renderer.isSVG && n(c.duration, 500) || 0, f = a.visible ? "visible" : "hidden", g = d.zIndex, h = a.hasRendered, i = b.seriesGroup;
            c = a.plotGroup("group", "series", f, g, i);
            a.markerGroup = a.plotGroup("markerGroup", "markers", f, g, i);
            e && a.animate(!0);
            a.getAttribs();
            c.inverted = a.isCartesian ? b.inverted : !1;
            a.drawGraph && (a.drawGraph(), a.clipNeg());
            Ub(a.points, function(a) {
                a.redraw && a.redraw();
            });
            a.drawDataLabels && a.drawDataLabels();
            a.visible && a.drawPoints();
            a.drawTracker && a.options.enableMouseTracking !== !1 && a.drawTracker();
            b.inverted && a.invertGroups();
            d.clip !== !1 && !a.sharedClipKey && !h && c.clip(b.clipRect);
            e && a.animate();
            if (!h)
                e ? a.animationTimeout = setTimeout(function() {
                    a.afterAnimate();
                }, e) : a.afterAnimate();
            a.isDirty = a.isDirtyData = !1;
            a.hasRendered = !0;
        },
        redraw: function() {
            var a = this.chart, b = this.isDirtyData, c = this.group, d = this.xAxis, e = this.yAxis;
            c && (a.inverted && c.attr({
                width: a.plotWidth,
                height: a.plotHeight
            }), c.animate({
                translateX: n(d && d.left, a.plotLeft),
                translateY: n(e && e.top, a.plotTop)
            }));
            this.translate();
            this.setTooltipPoints && this.setTooltipPoints(!0);
            this.render();
            b && $b(this, "updatedData");
        }
    };
    J.prototype = {
        destroy: function() {
            A(this, this.axis);
        },
        render: function(a) {
            var b = this.options, c = b.format, c = c ? u(c, this) : b.formatter.call(this);
            this.label ? this.label.attr({
                text: c,
                visibility: "hidden"
            }) : this.label = this.axis.chart.renderer.text(c, null, null, b.useHTML).css(b.style).attr({
                align: this.textAlign,
                rotation: b.rotation,
                visibility: "hidden"
            }).add(a);
        },
        setOffset: function(a, b) {
            var c = this.axis, d = c.chart, e = d.inverted, f = this.isNegative, g = c.translate(c.usePercentage ? 100 : this.total, 0, 0, 0, 1), c = c.translate(0), c = T(g - c), h = d.xAxis[0].translate(this.x) + a, i = d.plotHeight, f = {
                x: e ? f ? g : g - c : h,
                y: e ? i - h - b : f ? i - g - c : i - g,
                width: e ? c : b,
                height: e ? b : c
            };
            if (e = this.label)
                e.align(this.alignOptions, null, f), f = e.alignAttr, e[this.options.crop === !1 || d.isInsidePlot(f.x, f.y) ? "show" : "hide"](!0);
        }
    };
    H.prototype.buildStacks = function() {
        var a = this.series, b = n(this.options.reversedStacks, !0), c = a.length;
        if (!this.isXAxis) {
            for (this.usePercentage = !1; c--; )
                a[b ? c : a.length - c - 1].setStackedPoints();
            if (this.usePercentage)
                for (c = 0; c < a.length; c++)
                    a[c].setPercentStacks();
        }
    };
    H.prototype.renderStackTotals = function() {
        var a = this.chart, b = a.renderer, c = this.stacks, d, e, f = this.stackTotalGroup;
        if (!f)
            this.stackTotalGroup = f = b.g("stack-labels").attr({
                visibility: "visible",
                zIndex: 6
            }).add();
        f.translate(a.plotLeft, a.plotTop);
        for (d in c)
            for (e in a = c[d], a)
                a[e].render(f);
    };
    uc.prototype.setStackedPoints = function() {
        if (this.options.stacking && !(this.visible !== !0 && this.chart.options.chart.ignoreHiddenSeries !== !1)) {
            var a = this.processedXData, b = this.processedYData, c = [], d = b.length, e = this.options, f = e.threshold, g = e.stack, e = e.stacking, h = this.stackKey, i = "-" + h, j = this.negStacks, k = this.yAxis, l = k.stacks, m = k.oldStacks, n, o, p, q, r, s;
            for (q = 0; q < d; q++) {
                r = a[q];
                s = b[q];
                p = this.index + "," + q;
                o = (n = j && s < f) ? i : h;
                l[o] || (l[o] = {});
                if (!l[o][r])
                    m[o] && m[o][r] ? (l[o][r] = m[o][r], l[o][r].total = null) : l[o][r] = new J(k, k.options.stackLabels, n, r, g);
                o = l[o][r];
                o.points[p] = [o.cum || 0];
                "percent" === e ? (n = n ? h : i, j && l[n] && l[n][r] ? (n = l[n][r], o.total = n.total = R(n.total, o.total) + T(s) || 0) : o.total = C(o.total + (T(s) || 0))) : o.total = C(o.total + (s || 0));
                o.cum = (o.cum || 0) + (s || 0);
                o.points[p].push(o.cum);
                c[q] = o.cum;
            }
            if ("percent" === e)
                k.usePercentage = !0;
            this.stackedYData = c;
            k.oldStacks = {};
        }
    };
    uc.prototype.setPercentStacks = function() {
        var a = this, b = a.stackKey, c = a.yAxis.stacks, d = a.processedXData;
        Ub([b, "-" + b], function(b) {
            var e;
            for (var f = d.length, g, h; f--; )
                if (g = d[f], e = (h = c[b] && c[b][g]) && h.points[a.index + "," + f],
                        g = e)
                    h = h.total ? 100 / h.total : 0, g[0] = C(g[0] * h), g[1] = C(g[1] * h),
                            a.stackedYData[f] = g[1];
        });
    };
    a(I.prototype, {
        addSeries: function(a, b, c) {
            var d, e = this;
            a && (b = n(b, !0), $b(e, "addSeries", {
                options: a
            }, function() {
                d = e.initSeries(a);
                e.isDirtyLegend = !0;
                e.linkSeries();
                b && e.redraw(c);
            }));
            return d;
        },
        addAxis: function(a, c, d, e) {
            var f = c ? "xAxis" : "yAxis", g = this.options;
            new H(this, b(a, {
                index: this[f].length,
                isX: c
            }));
            g[f] = m(g[f] || {});
            g[f].push(a);
            n(d, !0) && this.redraw(e);
        },
        showLoading: function(b) {
            var c = this, d = c.options, e = c.loadingDiv, f = d.loading, g = function() {
                e && o(e, {
                    left: c.plotLeft + "px",
                    top: c.plotTop + "px",
                    width: c.plotWidth + "px",
                    height: c.plotHeight + "px"
                });
            };
            if (!e)
                c.loadingDiv = e = p(vb, {
                    className: "highcharts-loading"
                }, a(f.style, {
                    zIndex: 10,
                    display: wb
                }), c.container), c.loadingSpan = p("span", null, f.labelStyle, e), Yb(c, "redraw", g);
            c.loadingSpan.innerHTML = b || d.lang.loading;
            if (!c.loadingShown)
                o(e, {
                    opacity: 0,
                    display: ""
                }), ac(e, {
                    opacity: f.style.opacity
                }, {
                    duration: f.showDuration || 0
                }), c.loadingShown = !0;
            g();
        },
        hideLoading: function() {
            var a = this.options, b = this.loadingDiv;
            b && ac(b, {
                opacity: 0
            }, {
                duration: a.loading.hideDuration || 100,
                complete: function() {
                    o(b, {
                        display: wb
                    });
                }
            });
            this.loadingShown = !1;
        }
    });
    a(tc.prototype, {
        update: function(a, b, c, d) {
            function g() {
                h.applyOptions(a);
                if (e(a) && !f(a))
                    h.redraw = function() {
                        if (j)
                            a && a.marker && a.marker.symbol ? h.graphic = j.destroy() : j.attr(h.pointAttr[h.state || ""]);
                        if (a && a.dataLabels && h.dataLabel)
                            h.dataLabel = h.dataLabel.destroy();
                        h.redraw = null;
                    };
                k = h.index;
                i.updateParallelArrays(h, k);
                m.data[k] = h.options;
                i.isDirty = i.isDirtyData = !0;
                if (!i.fixedBox && i.hasCartesianSeries)
                    l.isDirtyBox = !0;
                "point" === m.legendType && l.legend.destroyItem(h);
                b && l.redraw(c);
            }
            var h = this, i = h.series, j = h.graphic, k, l = i.chart, m = i.options, b = n(b, !0);
            d === !1 ? g() : h.firePointEvent("update", {
                options: a
            }, g);
        },
        remove: function(a, b) {
            var c = this, d = c.series, e = d.points, f = d.chart, g, h = d.data;
            D(b, f);
            a = n(a, !0);
            c.firePointEvent("remove", null, function() {
                g = Tb(c, h);
                h.length === e.length && e.splice(g, 1);
                h.splice(g, 1);
                d.options.data.splice(g, 1);
                d.updateParallelArrays(c, "splice", g, 1);
                c.destroy();
                d.isDirty = !0;
                d.isDirtyData = !0;
                a && f.redraw();
            });
        }
    });
    a(uc.prototype, {
        addPoint: function(a, b, c, d) {
            var e = this.options, f = this.data, g = this.graph, h = this.area, i = this.chart, j = this.xAxis && this.xAxis.names, k = g && g.shift || 0, l = e.data, m, o = this.xData;
            D(d, i);
            c && Ub([g, h, this.graphNeg, this.areaNeg], function(a) {
                if (a)
                    a.shift = k + 1;
            });
            if (h)
                h.isArea = !0;
            b = n(b, !0);
            d = {
                series: this
            };
            this.pointClass.prototype.applyOptions.apply(d, [a]);
            g = d.x;
            h = o.length;
            if (this.requireSorting && g < o[h - 1])
                for (m = !0; h && o[h - 1] > g; )
                    h--;
            this.updateParallelArrays(d, "splice", h, 0, 0);
            this.updateParallelArrays(d, h);
            if (j && d.name)
                j[g] = d.name;
            l.splice(h, 0, a);
            m && (this.data.splice(h, 0, null), this.processData());
            "point" === e.legendType && this.generatePoints();
            c && (f[0] && f[0].remove ? f[0].remove(!1) : (f.shift(), this.updateParallelArrays(d, "shift"),
                    l.shift()));
            this.isDirtyData = this.isDirty = !0;
            b && (this.getAttribs(), i.redraw());
        },
        remove: function(a, b) {
            var c = this, d = c.chart, a = n(a, !0);
            if (!c.isRemoving)
                c.isRemoving = !0, $b(c, "remove", null, function() {
                    c.destroy();
                    d.isDirtyLegend = d.isDirtyBox = !0;
                    d.linkSeries();
                    a && d.redraw(b);
                });
            c.isRemoving = !1;
        },
        update: function(c, d) {
            var e = this, f = this.chart, g = this.userOptions, h = this.type, i = Nb[h].prototype, j = ["group", "markerGroup", "dataLabelsGroup"], k;
            Ub(j, function(a) {
                j[a] = e[a];
                delete e[a];
            });
            c = b(g, {
                animation: !1,
                index: this.index,
                pointStart: this.xData[0]
            }, {
                data: this.options.data
            }, c);
            this.remove(!1);
            for (k in i)
                i.hasOwnProperty(k) && (this[k] = K);
            a(this, Nb[c.type || h].prototype);
            Ub(j, function(a) {
                e[a] = j[a];
            });
            this.init(f, c);
            f.linkSeries();
            n(d, !0) && f.redraw(!1);
        }
    });
    a(H.prototype, {
        update: function(c, d) {
            var e = this.chart, c = e.options[this.coll][this.options.index] = b(this.userOptions, c);
            this.destroy(!0);
            this._addedPlotLB = K;
            this.init(e, a(c, {
                events: K
            }));
            e.isDirtyBox = !0;
            n(d, !0) && e.redraw();
        },
        remove: function(a) {
            for (var b = this.chart, c = this.coll, d = this.series, e = d.length; e--; )
                d[e] && d[e].remove(!1);
            j(b.axes, this);
            j(b[c], this);
            b.options[c].splice(this.options.index, 1);
            Ub(b[c], function(a, b) {
                a.options.index = b;
            });
            this.destroy();
            b.isDirtyBox = !0;
            n(a, !0) && b.redraw();
        },
        setTitle: function(a, b) {
            this.update({
                title: a
            }, b);
        },
        setCategories: function(a, b) {
            this.update({
                categories: a
            }, b);
        }
    });
    jc = q(uc);
    Nb.line = jc;
    cc.area = b(Pb, {
        threshold: 0
    });
    var vc = q(uc, {
        type: "area",
        getSegments: function() {
            var a = this, b = [], c = [], d = [], e = this.xAxis, f = this.yAxis, g = f.stacks[this.stackKey], h = {}, i, j, k = this.points, l = this.options.connectNulls, m, n;
            if (this.options.stacking && !this.cropped) {
                for (m = 0; m < k.length; m++)
                    h[k[m].x] = k[m];
                for (n in g)
                    null !== g[n].total && d.push(+n);
                d.sort(function(a, b) {
                    return a - b;
                });
                Ub(d, function(b) {
                    var d = 0, k;
                    if (!l || h[b] && null !== h[b].y)
                        if (h[b])
                            c.push(h[b]);
                        else {
                            for (m = a.index; m <= f.series.length; m++)
                                if (k = g[b].points[m + "," + b]) {
                                    d = k[1];
                                    break;
                                }
                            i = e.translate(b);
                            j = f.toPixels(d, !0);
                            c.push({
                                y: null,
                                plotX: i,
                                clientX: i,
                                plotY: j,
                                yBottom: j,
                                onMouseOver: sb
                            });
                        }
                });
                c.length && b.push(c);
            } else
                uc.prototype.getSegments.call(this), b = this.segments;
            this.segments = b;
        },
        getSegmentPath: function(a) {
            var b = uc.prototype.getSegmentPath.call(this, a), c = [].concat(b), d, e = this.options;
            d = b.length;
            var f = this.yAxis.getThreshold(e.threshold), g;
            3 === d && c.push("L", b[1], b[2]);
            if (e.stacking && !this.closedStacks)
                for (d = a.length - 1; d >= 0; d--)
                    g = n(a[d].yBottom, f),
                            d < a.length - 1 && e.step && c.push(a[d + 1].plotX, g), c.push(a[d].plotX, g);
            else
                this.closeSegment(c, a, f);
            this.areaPath = this.areaPath.concat(c);
            return b;
        },
        closeSegment: function(a, b, c) {
            a.push("L", b[b.length - 1].plotX, c, "L", b[0].plotX, c);
        },
        drawGraph: function() {
            this.areaPath = [];
            uc.prototype.drawGraph.apply(this);
            var a = this, b = this.areaPath, c = this.options, d = c.negativeColor, e = c.negativeFillColor, f = [["area", this.color, c.fillColor]];
            (d || e) && f.push(["areaNeg", d, e]);
            Ub(f, function(d) {
                var e = d[0], f = a[e];
                f ? f.animate({
                    d: b
                }) : a[e] = a.chart.renderer.path(b).attr({
                    fill: n(d[2], gc(d[1]).setOpacity(n(c.fillOpacity, .75)).get()),
                    zIndex: 0
                }).add(a.group);
            });
        },
        drawLegendSymbol: Qb.drawRectangle
    });
    Nb.area = vc;
    cc.spline = b(Pb);
    jc = q(uc, {
        type: "spline",
        getPointSpline: function(a, b, c) {
            var d = b.plotX, e = b.plotY, f = a[c - 1], g = a[c + 1], h, i, j, k;
            if (f && g) {
                a = f.plotY;
                j = g.plotX;
                var g = g.plotY, l;
                h = (1.5 * d + f.plotX) / 2.5;
                i = (1.5 * e + a) / 2.5;
                j = (1.5 * d + j) / 2.5;
                k = (1.5 * e + g) / 2.5;
                l = (k - i) * (j - d) / (j - h) + e - k;
                i += l;
                k += l;
                i > a && i > e ? (i = R(a, e), k = 2 * e - i) : i < a && i < e && (i = S(a, e),
                        k = 2 * e - i);
                k > g && k > e ? (k = R(g, e), i = 2 * e - k) : k < g && k < e && (k = S(g, e),
                        i = 2 * e - k);
                b.rightContX = j;
                b.rightContY = k;
            }
            c ? (b = ["C", f.rightContX || f.plotX, f.rightContY || f.plotY, h || d, i || e, d, e],
                    f.rightContX = f.rightContY = null) : b = ["M", d, e];
            return b;
        }
    });
    Nb.spline = jc;
    cc.areaspline = b(cc.area);
    vc = vc.prototype;
    jc = q(jc, {
        type: "areaspline",
        closedStacks: !0,
        getSegmentPath: vc.getSegmentPath,
        closeSegment: vc.closeSegment,
        drawGraph: vc.drawGraph,
        drawLegendSymbol: Qb.drawRectangle
    });
    Nb.areaspline = jc;
    cc.column = b(Pb, {
        borderColor: "#FFFFFF",
        borderRadius: 0,
        groupPadding: .2,
        marker: null,
        pointPadding: .1,
        minPointLength: 0,
        cropThreshold: 50,
        pointRange: null,
        states: {
            hover: {
                brightness: .1,
                shadow: !1,
                halo: !1
            },
            select: {
                color: "#C0C0C0",
                borderColor: "#000000",
                shadow: !1
            }
        },
        dataLabels: {
            align: null,
            verticalAlign: null,
            y: null
        },
        stickyTracking: !1,
        tooltip: {
            distance: 6
        },
        threshold: 0
    });
    jc = q(uc, {
        type: "column",
        pointAttrToOptions: {
            stroke: "borderColor",
            fill: "color",
            r: "borderRadius"
        },
        cropShoulder: 0,
        trackerGroups: ["group", "dataLabelsGroup"],
        negStacks: !0,
        init: function() {
            uc.prototype.init.apply(this, arguments);
            var a = this, b = a.chart;
            b.hasRendered && Ub(b.series, function(b) {
                if (b.type === a.type)
                    b.isDirty = !0;
            });
        },
        getColumnMetrics: function() {
            var a = this, b = a.options, c = a.xAxis, d = a.yAxis, e = c.reversed, f, g = {}, h, i = 0;
            b.grouping === !1 ? i = 1 : Ub(a.chart.series, function(b) {
                var c = b.options, e = b.yAxis;
                if (b.type === a.type && b.visible && d.len === e.len && d.pos === e.pos)
                    c.stacking ? (f = b.stackKey,
                            g[f] === K && (g[f] = i++), h = g[f]) : c.grouping !== !1 && (h = i++), b.columnIndex = h;
            });
            var c = S(T(c.transA) * (c.ordinalSlope || b.pointRange || c.closestPointRange || c.tickInterval || 1), c.len), j = c * b.groupPadding, l = (c - 2 * j) / i, m = b.pointWidth, b = k(m) ? (l - m) / 2 : l * b.pointPadding, m = n(m, l - 2 * b);
            return a.columnMetrics = {
                width: m,
                offset: b + (j + ((e ? i - (a.columnIndex || 0) : a.columnIndex) || 0) * l - c / 2) * (e ? -1 : 1)
            };
        },
        translate: function() {
            var a = this, b = a.chart, c = a.options, d = a.borderWidth = n(c.borderWidth, a.activePointCount > .5 * a.xAxis.len ? 0 : 1), e = a.yAxis, f = a.translatedThreshold = e.getThreshold(c.threshold), g = n(c.minPointLength, 5), h = a.getColumnMetrics(), i = h.width, j = a.barW = R(i, 1 + 2 * d), k = a.pointXOffset = h.offset, l = -(d % 2 ? .5 : 0), m = d % 2 ? .5 : 1;
            b.renderer.isVML && b.inverted && (m += 1);
            c.pointPadding && (j = Q(j));
            uc.prototype.translate.apply(a);
            Ub(a.points, function(c) {
                var d = n(c.yBottom, f), h = S(R(-999 - d, c.plotY), e.len + 999 + d), o = c.plotX + k, p = j, q = S(h, d), r;
                r = R(h, d) - q;
                T(r) < g && g && (r = g, q = O(T(q - f) > g ? d - g : f - (e.translate(c.y, 0, 1, 0, 1) <= f ? g : 0)));
                c.barX = o;
                c.pointWidth = i;
                c.tooltipPos = b.inverted ? [e.len - h, a.xAxis.len - o - p / 2] : [o + p / 2, h + e.pos - b.plotTop];
                p = O(o + p) + l;
                o = O(o) + l;
                p -= o;
                d = T(q) < .5;
                r = O(q + r) + m;
                q = O(q) + m;
                r -= q;
                d && (q -= 1, r += 1);
                c.shapeType = "rect";
                c.shapeArgs = {
                    x: o,
                    y: q,
                    width: p,
                    height: r
                };
            });
        },
        getSymbol: sb,
        drawLegendSymbol: Qb.drawRectangle,
        drawGraph: sb,
        drawPoints: function() {
            var a = this, c = this.chart, d = a.options, e = c.renderer, f = d.animationLimit || 250, g, h;
            Ub(a.points, function(i) {
                var j = i.plotY, l = i.graphic;
                if (j !== K && !isNaN(j) && null !== i.y)
                    g = i.shapeArgs, j = k(a.borderWidth) ? {
                        "stroke-width": a.borderWidth
                    } : {}, h = i.pointAttr[i.selected ? "select" : ""] || a.pointAttr[""], l ? (bc(l),
                            l.attr(j)[c.pointCount < f ? "animate" : "attr"](b(g))) : i.graphic = e[i.shapeType](g).attr(h).attr(j).add(a.group).shadow(d.shadow, null, d.stacking && !d.borderRadius);
                else if (l)
                    i.graphic = l.destroy();
            });
        },
        animate: function(a) {
            var b = this.yAxis, c = this.options, d = this.chart.inverted, e = {};
            if (eb)
                a ? (e.scaleY = .001, a = S(b.pos + b.len, R(b.pos, b.toPixels(c.threshold))),
                        d ? e.translateX = a - b.len : e.translateY = a, this.group.attr(e)) : (e.scaleY = 1,
                        e[d ? "translateX" : "translateY"] = b.pos, this.group.animate(e, this.options.animation),
                        this.animate = null);
        },
        remove: function() {
            var a = this, b = a.chart;
            b.hasRendered && Ub(b.series, function(b) {
                if (b.type === a.type)
                    b.isDirty = !0;
            });
            uc.prototype.remove.apply(a, arguments);
        }
    });
    Nb.column = jc;
    cc.bar = b(cc.column);
    vc = q(jc, {
        type: "bar",
        inverted: !0
    });
    Nb.bar = vc;
    cc.scatter = b(Pb, {
        lineWidth: 0,
        tooltip: {
            headerFormat: '<span style="color:{series.color}">●</span> <span style="font-size: 10px;"> {series.name}</span><br/>',
            pointFormat: "x: <b>{point.x}</b><br/>y: <b>{point.y}</b><br/>"
        },
        stickyTracking: !1
    });
    vc = q(uc, {
        type: "scatter",
        sorted: !1,
        requireSorting: !1,
        noSharedTooltip: !0,
        trackerGroups: ["markerGroup", "dataLabelsGroup"],
        takeOrdinalPosition: !1,
        singularTooltips: !0,
        drawGraph: function() {
            this.options.lineWidth && uc.prototype.drawGraph.call(this);
        }
    });
    Nb.scatter = vc;
    cc.pie = b(Pb, {
        borderColor: "#FFFFFF",
        borderWidth: 1,
        center: [null, null],
        clip: !1,
        colorByPoint: !0,
        dataLabels: {
            distance: 30,
            enabled: !0,
            formatter: function() {
                return this.point.name;
            }
        },
        ignoreHiddenPoint: !0,
        legendType: "point",
        marker: null,
        size: null,
        showInLegend: !1,
        slicedOffset: 10,
        states: {
            hover: {
                brightness: .1,
                shadow: !1
            }
        },
        stickyTracking: !1,
        tooltip: {
            followPointer: !0
        }
    });
    Pb = {
        type: "pie",
        isCartesian: !1,
        pointClass: q(tc, {
            init: function() {
                tc.prototype.init.apply(this, arguments);
                var b = this, c;
                if (b.y < 0)
                    b.y = null;
                a(b, {
                    visible: b.visible !== !1,
                    name: n(b.name, "Slice")
                });
                c = function(a) {
                    b.slice("select" === a.type);
                };
                Yb(b, "select", c);
                Yb(b, "unselect", c);
                return b;
            },
            setVisible: function(a) {
                var b = this, c = b.series, d = c.chart;
                b.visible = b.options.visible = a = a === K ? !b.visible : a;
                c.options.data[Tb(b, c.data)] = b.options;
                Ub(["graphic", "dataLabel", "connector", "shadowGroup"], function(c) {
                    if (b[c])
                        b[c][a ? "show" : "hide"](!0);
                });
                b.legendItem && d.legend.colorizeItem(b, a);
                if (!c.isDirty && c.options.ignoreHiddenPoint)
                    c.isDirty = !0, d.redraw();
            },
            slice: function(a, b, c) {
                var d = this.series;
                D(c, d.chart);
                n(b, !0);
                this.sliced = this.options.sliced = a = k(a) ? a : !this.sliced;
                d.options.data[Tb(this, d.data)] = this.options;
                a = a ? this.slicedTranslation : {
                    translateX: 0,
                    translateY: 0
                };
                this.graphic.animate(a);
                this.shadowGroup && this.shadowGroup.animate(a);
            },
            haloPath: function(a) {
                var b = this.shapeArgs, c = this.series.chart;
                return this.sliced || !this.visible ? [] : this.series.chart.renderer.symbols.arc(c.plotLeft + b.x, c.plotTop + b.y, b.r + a, b.r + a, {
                    innerR: this.shapeArgs.r,
                    start: b.start,
                    end: b.end
                });
            }
        }),
        requireSorting: !1,
        noSharedTooltip: !0,
        trackerGroups: ["group", "dataLabelsGroup"],
        axisTypes: [],
        pointAttrToOptions: {
            stroke: "borderColor",
            "stroke-width": "borderWidth",
            fill: "color"
        },
        singularTooltips: !0,
        getColor: sb,
        animate: function(a) {
            var b = this, c = b.points, d = b.startAngleRad;
            if (!a)
                Ub(c, function(a) {
                    var c = a.graphic, a = a.shapeArgs;
                    c && (c.attr({
                        r: b.center[3] / 2,
                        start: d,
                        end: d
                    }), c.animate({
                        r: a.r,
                        start: a.start,
                        end: a.end
                    }, b.options.animation));
                }), b.animate = null;
        },
        setData: function(a, b, c, d) {
            uc.prototype.setData.call(this, a, !1, c, d);
            this.processData();
            this.generatePoints();
            n(b, !0) && this.chart.redraw(c);
        },
        generatePoints: function() {
            var a, b = 0, c, d, e, f = this.options.ignoreHiddenPoint;
            uc.prototype.generatePoints.call(this);
            c = this.points;
            d = c.length;
            for (a = 0; a < d; a++)
                e = c[a], b += f && !e.visible ? 0 : e.y;
            this.total = b;
            for (a = 0; a < d; a++)
                e = c[a], e.percentage = b > 0 ? e.y / b * 100 : 0, e.total = b;
        },
        translate: function(a) {
            this.generatePoints();
            var b = 0, c = this.options, d = c.slicedOffset, e = d + c.borderWidth, f, g, h, i = c.startAngle || 0, j = this.startAngleRad = W / 180 * (i - 90), i = (this.endAngleRad = W / 180 * (n(c.endAngle, i + 360) - 90)) - j, k = this.points, l = c.dataLabels.distance, c = c.ignoreHiddenPoint, m, o = k.length, p;
            if (!a)
                this.center = a = this.getCenter();
            this.getX = function(b, c) {
                h = N.asin(S((b - a[1]) / (a[2] / 2 + l), 1));
                return a[0] + (c ? -1 : 1) * U(h) * (a[2] / 2 + l);
            };
            for (m = 0; m < o; m++) {
                p = k[m];
                f = j + b * i;
                if (!c || p.visible)
                    b += p.percentage / 100;
                g = j + b * i;
                p.shapeType = "arc";
                p.shapeArgs = {
                    x: a[0],
                    y: a[1],
                    r: a[2] / 2,
                    innerR: a[3] / 2,
                    start: O(1e3 * f) / 1e3,
                    end: O(1e3 * g) / 1e3
                };
                h = (g + f) / 2;
                h > 1.5 * W ? h -= 2 * W : h < -W / 2 && (h += 2 * W);
                p.slicedTranslation = {
                    translateX: O(U(h) * d),
                    translateY: O(V(h) * d)
                };
                f = U(h) * a[2] / 2;
                g = V(h) * a[2] / 2;
                p.tooltipPos = [a[0] + .7 * f, a[1] + .7 * g];
                p.half = h < -W / 2 || h > W / 2 ? 1 : 0;
                p.angle = h;
                e = S(e, l / 2);
                p.labelPos = [a[0] + f + U(h) * l, a[1] + g + V(h) * l, a[0] + f + U(h) * e, a[1] + g + V(h) * e, a[0] + f, a[1] + g, l < 0 ? "center" : p.half ? "right" : "left", h];
            }
        },
        drawGraph: null,
        drawPoints: function() {
            var b = this, c = b.chart.renderer, d, e, f = b.options.shadow, g, h;
            if (f && !b.shadowGroup)
                b.shadowGroup = c.g("shadow").add(b.group);
            Ub(b.points, function(i) {
                e = i.graphic;
                h = i.shapeArgs;
                g = i.shadowGroup;
                if (f && !g)
                    g = i.shadowGroup = c.g("shadow").add(b.shadowGroup);
                d = i.sliced ? i.slicedTranslation : {
                    translateX: 0,
                    translateY: 0
                };
                g && g.attr(d);
                e ? e.animate(a(h, d)) : i.graphic = e = c[i.shapeType](h).setRadialReference(b.center).attr(i.pointAttr[i.selected ? "select" : ""]).attr({
                    "stroke-linejoin": "round"
                }).attr(d).add(b.group).shadow(f, g);
                i.visible !== void 0 && i.setVisible(i.visible);
            });
        },
        sortByAngle: function(a, b) {
            a.sort(function(a, c) {
                return a.angle !== void 0 && (c.angle - a.angle) * b;
            });
        },
        drawLegendSymbol: Qb.drawRectangle,
        getCenter: ic.getCenter,
        getSymbol: sb
    };
    Pb = q(uc, Pb);
    Nb.pie = Pb;
    uc.prototype.drawDataLabels = function() {
        var c = this, d = c.options, e = d.cursor, f = d.dataLabels, g = c.points, h, i, j = c.hasRendered || 0, l, m;
        if (f.enabled || c._hasPointLabels)
            c.dlProcessOptions && c.dlProcessOptions(f),
                    m = c.plotGroup("dataLabelsGroup", "data-labels", f.defer ? "hidden" : "visible", f.zIndex || 6),
                    n(f.defer, !0) && (m.attr({
                opacity: +j
            }), j || Yb(c, "afterAnimate", function() {
                c.visible && m.show();
                m[d.animation ? "animate" : "attr"]({
                    opacity: 1
                }, {
                    duration: 200
                });
            })), i = f, Ub(g, function(d) {
                var g, j = d.dataLabel, o, p, q = d.connector, r = !0;
                h = d.options && d.options.dataLabels;
                g = n(h && h.enabled, i.enabled);
                if (j && !g)
                    d.dataLabel = j.destroy();
                else if (g) {
                    f = b(i, h);
                    g = f.rotation;
                    o = d.getLabelConfig();
                    l = f.format ? u(f.format, o) : f.formatter.call(o, f);
                    f.style.color = n(f.color, f.style.color, c.color, "black");
                    if (j) {
                        if (k(l))
                            j.attr({
                                text: l
                            }), r = !1;
                        else if (d.dataLabel = j = j.destroy(), q)
                            d.connector = q.destroy();
                    } else if (k(l)) {
                        j = {
                            fill: f.backgroundColor,
                            stroke: f.borderColor,
                            "stroke-width": f.borderWidth,
                            r: f.borderRadius || 0,
                            rotation: g,
                            padding: f.padding,
                            zIndex: 1
                        };
                        for (p in j)
                            j[p] === K && delete j[p];
                        j = d.dataLabel = c.chart.renderer[g ? "text" : "label"](l, 0, -999, null, null, null, f.useHTML).attr(j).css(a(f.style, e && {
                            cursor: e
                        })).add(m).shadow(f.shadow);
                    }
                    j && c.alignDataLabel(d, j, f, null, r);
                }
            });
    };
    uc.prototype.alignDataLabel = function(b, c, d, e, f) {
        var g = this.chart, h = g.inverted, i = n(b.plotX, -999), j = n(b.plotY, -999), k = c.getBBox();
        if (b = this.visible && (b.series.forceDL || g.isInsidePlot(i, O(j), h) || e && g.isInsidePlot(i, h ? e.x + 1 : e.y + e.height - 1, h)))
            e = a({
                x: h ? g.plotWidth - j : i,
                y: O(h ? g.plotHeight - i : j),
                width: 0,
                height: 0
            }, e), a(d, {
                width: k.width,
                height: k.height
            }), d.rotation ? c[f ? "attr" : "animate"]({
                x: e.x + d.x + e.width / 2,
                y: e.y + d.y + e.height / 2
            }).attr({
                align: d.align
            }) : (c.align(d, null, e), h = c.alignAttr, "justify" === n(d.overflow, "justify") ? this.justifyDataLabel(c, d, h, k, e, f) : n(d.crop, !0) && (b = g.isInsidePlot(h.x, h.y) && g.isInsidePlot(h.x + k.width, h.y + k.height)));
        if (!b)
            c.attr({
                y: -999
            }), c.placed = !1;
    };
    uc.prototype.justifyDataLabel = function(a, b, c, d, e, f) {
        var g = this.chart, h = b.align, i = b.verticalAlign, j, k;
        j = c.x;
        if (j < 0)
            "right" === h ? b.align = "left" : b.x = -j, k = !0;
        j = c.x + d.width;
        if (j > g.plotWidth)
            "left" === h ? b.align = "right" : b.x = g.plotWidth - j, k = !0;
        j = c.y;
        if (j < 0)
            "bottom" === i ? b.verticalAlign = "top" : b.y = -j, k = !0;
        j = c.y + d.height;
        if (j > g.plotHeight)
            "top" === i ? b.verticalAlign = "bottom" : b.y = g.plotHeight - j,
                    k = !0;
        if (k)
            a.placed = !f, a.align(b, null, e);
    };
    if (Nb.pie)
        Nb.pie.prototype.drawDataLabels = function() {
            var a = this, b = a.data, c, d = a.chart, e = a.options.dataLabels, f = n(e.connectorPadding, 10), g = n(e.connectorWidth, 1), h = d.plotWidth, i = d.plotHeight, j, k, l = n(e.softConnector, !0), m = e.distance, o = a.center, p = o[2] / 2, q = o[1], r = m > 0, s, t, u, v = [[], []], w, x, y, A, B, C = [0, 0, 0, 0], D = function(a, b) {
                return b.y - a.y;
            };
            if (a.visible && (e.enabled || a._hasPointLabels)) {
                uc.prototype.drawDataLabels.apply(a);
                Ub(b, function(a) {
                    a.dataLabel && a.visible && v[a.half].push(a);
                });
                for (A = 2; A--; ) {
                    var E = [], F = [], G = v[A], H = G.length, I;
                    if (H) {
                        a.sortByAngle(G, A - .5);
                        for (B = b = 0; !b && G[B]; )
                            b = G[B] && G[B].dataLabel && (G[B].dataLabel.getBBox().height || 21),
                                    B++;
                        if (m > 0) {
                            t = S(q + p + m, d.plotHeight);
                            for (B = R(0, q - p - m); B <= t; B += b)
                                E.push(B);
                            t = E.length;
                            if (H > t) {
                                c = [].concat(G);
                                c.sort(D);
                                for (B = H; B--; )
                                    c[B].rank = B;
                                for (B = H; B--; )
                                    G[B].rank >= t && G.splice(B, 1);
                                H = G.length;
                            }
                            for (B = 0; B < H; B++) {
                                c = G[B];
                                u = c.labelPos;
                                c = 9999;
                                var J, K;
                                for (K = 0; K < t; K++)
                                    J = T(E[K] - u[1]), J < c && (c = J, I = K);
                                if (I < B && null !== E[B])
                                    I = B;
                                else
                                    for (t < H - B + I && null !== E[B] && (I = t - H + B); null === E[I]; )
                                        I++;
                                F.push({
                                    i: I,
                                    y: E[I]
                                });
                                E[I] = null;
                            }
                            F.sort(D);
                        }
                        for (B = 0; B < H; B++) {
                            c = G[B];
                            u = c.labelPos;
                            s = c.dataLabel;
                            y = c.visible === !1 ? "hidden" : "visible";
                            c = u[1];
                            if (m > 0) {
                                if (t = F.pop(), I = t.i, x = t.y, c > x && null !== E[I + 1] || c < x && null !== E[I - 1])
                                    x = S(R(0, c), d.plotHeight);
                            } else
                                x = c;
                            w = e.justify ? o[0] + (A ? -1 : 1) * (p + m) : a.getX(x === q - p - m || x === q + p + m ? c : x, A);
                            s._attr = {
                                visibility: y,
                                align: u[6]
                            };
                            s._pos = {
                                x: w + e.x + ({
                                    left: f,
                                    right: -f
                                }[u[6]] || 0),
                                y: x + e.y - 10
                            };
                            s.connX = w;
                            s.connY = x;
                            if (null === this.options.size)
                                t = s.width, w - t < f ? C[3] = R(O(t - w + f), C[3]) : w + t > h - f && (C[1] = R(O(w + t - h + f), C[1])),
                                        x - b / 2 < 0 ? C[0] = R(O(-x + b / 2), C[0]) : x + b / 2 > i && (C[2] = R(O(x + b / 2 - i), C[2]));
                        }
                    }
                }
                if (0 === z(C) || this.verifyDataLabelOverflow(C))
                    this.placeDataLabels(), r && g && Ub(this.points, function(b) {
                        j = b.connector;
                        u = b.labelPos;
                        if ((s = b.dataLabel) && s._pos)
                            y = s._attr.visibility, w = s.connX, x = s.connY,
                                    k = l ? ["M", w + ("left" === u[6] ? 5 : -5), x, "C", w, x, 2 * u[2] - u[4], 2 * u[3] - u[5], u[2], u[3], "L", u[4], u[5]] : ["M", w + ("left" === u[6] ? 5 : -5), x, "L", u[2], u[3], "L", u[4], u[5]],
                                    j ? (j.animate({
                                        d: k
                                    }), j.attr("visibility", y)) : b.connector = j = a.chart.renderer.path(k).attr({
                                "stroke-width": g,
                                stroke: e.connectorColor || b.color || "#606060",
                                visibility: y
                            }).add(a.dataLabelsGroup);
                        else if (j)
                            b.connector = j.destroy();
                    });
            }
        }, Nb.pie.prototype.placeDataLabels = function() {
            Ub(this.points, function(a) {
                var a = a.dataLabel, b;
                if (a)
                    (b = a._pos) ? (a.attr(a._attr), a[a.moved ? "animate" : "attr"](b), a.moved = !0) : a && a.attr({
                        y: -999
                    });
            });
        }, Nb.pie.prototype.alignDataLabel = sb, Nb.pie.prototype.verifyDataLabelOverflow = function(a) {
            var b = this.center, c = this.options, d = c.center, e = c = c.minSize || 80, f;
            null !== d[0] ? e = R(b[2] - R(a[1], a[3]), c) : (e = R(b[2] - a[1] - a[3], c),
                    b[0] += (a[3] - a[1]) / 2);
            null !== d[1] ? e = R(S(e, b[2] - R(a[0], a[2])), c) : (e = R(S(e, b[2] - a[0] - a[2]), c),
                    b[1] += (a[0] - a[2]) / 2);
            e < b[2] ? (b[2] = e, this.translate(b), Ub(this.points, function(a) {
                if (a.dataLabel)
                    a.dataLabel._pos = null;
            }), this.drawDataLabels && this.drawDataLabels()) : f = !0;
            return f;
        };
    if (Nb.column)
        Nb.column.prototype.alignDataLabel = function(a, c, d, e, f) {
            var g = this.chart, h = g.inverted, i = a.dlBox || a.shapeArgs, j = a.below || a.plotY > n(this.translatedThreshold, g.plotSizeY), k = n(d.inside, !!this.options.stacking);
            if (i && (e = b(i), h && (e = {
                x: g.plotWidth - e.y - e.height,
                y: g.plotHeight - e.x - e.width,
                width: e.height,
                height: e.width
            }), !k))
                h ? (e.x += j ? 0 : e.width, e.width = 0) : (e.y += j ? e.height : 0, e.height = 0);
            d.align = n(d.align, !h || k ? "center" : j ? "right" : "left");
            d.verticalAlign = n(d.verticalAlign, h || k ? "middle" : j ? "top" : "bottom");
            uc.prototype.alignDataLabel.call(this, a, c, d, e, f);
        };
    Pb = Ob.TrackerMixin = {
        drawTrackerPoint: function() {
            var a = this, b = a.chart, c = b.pointer, d = a.options.cursor, e = d && {
                cursor: d
            }, f = function(c) {
                var d = c.target, e;
                if (b.hoverSeries !== a)
                    a.onMouseOver();
                for (; d && !e; )
                    e = d.point, d = d.parentNode;
                if (e !== K && e !== b.hoverPoint)
                    e.onMouseOver(c);
            };
            Ub(a.points, function(a) {
                if (a.graphic)
                    a.graphic.element.point = a;
                if (a.dataLabel)
                    a.dataLabel.element.point = a;
            });
            if (!a._hasTracking)
                Ub(a.trackerGroups, function(b) {
                    if (a[b] && (a[b].addClass("highcharts-tracker").on("mouseover", f).on("mouseout", function(a) {
                        c.onTrackerMouseOut(a);
                    }).css(e), ib))
                        a[b].on("touchstart", f);
                }), a._hasTracking = !0;
        },
        drawTrackerGraph: function() {
            var a = this, b = a.options, c = b.trackByArea, d = [].concat(c ? a.areaPath : a.graphPath), e = d.length, f = a.chart, g = f.pointer, h = f.renderer, i = f.options.tooltip.snap, j = a.tracker, k = b.cursor, l = k && {
                cursor: k
            }, k = a.singlePoints, m, n = function() {
                if (f.hoverSeries !== a)
                    a.onMouseOver();
            }, o = "rgba(192,192,192," + (eb ? 1e-4 : .002) + ")";
            if (e && !c)
                for (m = e + 1; m--; )
                    "M" === d[m] && d.splice(m + 1, 0, d[m + 1] - i, d[m + 2], "L"),
                            (m && "M" === d[m] || m === e) && d.splice(m, 0, "L", d[m - 2] + i, d[m - 1]);
            for (m = 0; m < k.length; m++)
                e = k[m], d.push("M", e.plotX - i, e.plotY, "L", e.plotX + i, e.plotY);
            j ? j.attr({
                d: d
            }) : (a.tracker = h.path(d).attr({
                "stroke-linejoin": "round",
                visibility: a.visible ? "visible" : "hidden",
                stroke: o,
                fill: c ? o : wb,
                "stroke-width": b.lineWidth + (c ? 0 : 2 * i),
                zIndex: 2
            }).add(a.group), Ub([a.tracker, a.markerGroup], function(a) {
                a.addClass("highcharts-tracker").on("mouseover", n).on("mouseout", function(a) {
                    g.onTrackerMouseOut(a);
                }).css(l);
                if (ib)
                    a.on("touchstart", n);
            }));
        }
    };
    if (Nb.column)
        jc.prototype.drawTracker = Pb.drawTrackerPoint;
    if (Nb.pie)
        Nb.pie.prototype.drawTracker = Pb.drawTrackerPoint;
    if (Nb.scatter)
        vc.prototype.drawTracker = Pb.drawTrackerPoint;
    a(sc.prototype, {
        setItemEvents: function(a, b, c, d, e) {
            var f = this;
            (c ? b : a.legendGroup).on("mouseover", function() {
                a.setState("hover");
                b.css(f.options.itemHoverStyle);
            }).on("mouseout", function() {
                b.css(a.visible ? d : e);
                a.setState();
            }).on("click", function(b) {
                var c = function() {
                    a.setVisible();
                }, b = {
                    browserEvent: b
                };
                a.firePointEvent ? a.firePointEvent("legendItemClick", b, c) : $b(a, "legendItemClick", b, c);
            });
        },
        createCheckboxForItem: function(a) {
            a.checkbox = p("input", {
                type: "checkbox",
                checked: a.selected,
                defaultChecked: a.selected
            }, this.options.itemCheckboxStyle, this.chart.container);
            Yb(a.checkbox, "click", function(b) {
                $b(a, "checkboxClick", {
                    checked: b.target.checked
                }, function() {
                    a.select();
                });
            });
        }
    });
    mb.legend.itemStyle.cursor = "pointer";
    a(I.prototype, {
        showResetZoom: function() {
            var a = this, b = mb.lang, c = a.options.chart.resetZoomButton, d = c.theme, e = d.states, f = "chart" === c.relativeTo ? null : "plotBox";
            this.resetZoomButton = a.renderer.button(b.resetZoom, null, null, function() {
                a.zoomOut();
            }, d, e && e.hover).attr({
                align: c.position.align,
                title: b.resetZoomTitle
            }).add().align(c.position, !1, f);
        },
        zoomOut: function() {
            var a = this;
            $b(a, "selection", {
                resetSelection: !0
            }, function() {
                a.zoom();
            });
        },
        zoom: function(a) {
            var b, c = this.pointer, d = !1, f;
            !a || a.resetSelection ? Ub(this.axes, function(a) {
                b = a.zoom();
            }) : Ub(a.xAxis.concat(a.yAxis), function(a) {
                var e = a.axis, f = e.isXAxis;
                if (c[f ? "zoomX" : "zoomY"] || c[f ? "pinchX" : "pinchY"])
                    b = e.zoom(a.min, a.max),
                            e.displayBtn && (d = !0);
            });
            f = this.resetZoomButton;
            if (d && !f)
                this.showResetZoom();
            else if (!d && e(f))
                this.resetZoomButton = f.destroy();
            b && this.redraw(n(this.options.chart.animation, a && a.animation, this.pointCount < 100));
        },
        pan: function(a, b) {
            var c = this, d = c.hoverPoints, e;
            d && Ub(d, function(a) {
                a.setState();
            });
            Ub("xy" === b ? [1, 0] : [1], function(b) {
                var d = a[b ? "chartX" : "chartY"], f = c[b ? "xAxis" : "yAxis"][0], g = c[b ? "mouseDownX" : "mouseDownY"], h = (f.pointRange || 0) / 2, i = f.getExtremes(), j = f.toValue(g - d, !0) + h, g = f.toValue(g + c[b ? "plotWidth" : "plotHeight"] - d, !0) - h;
                f.series.length && j > S(i.dataMin, i.min) && g < R(i.dataMax, i.max) && (f.setExtremes(j, g, !1, !1, {
                    trigger: "pan"
                }), e = !0);
                c[b ? "mouseDownX" : "mouseDownY"] = d;
            });
            e && c.redraw(!1);
            o(c.container, {
                cursor: "move"
            });
        }
    });
    a(tc.prototype, {
        select: function(a, b) {
            var c = this, d = c.series, e = d.chart, a = n(a, !c.selected);
            c.firePointEvent(a ? "select" : "unselect", {
                accumulate: b
            }, function() {
                c.selected = c.options.selected = a;
                d.options.data[Tb(c, d.data)] = c.options;
                c.setState(a && "select");
                b || Ub(e.getSelectedPoints(), function(a) {
                    if (a.selected && a !== c)
                        a.selected = a.options.selected = !1, d.options.data[Tb(a, d.data)] = a.options,
                                a.setState(""), a.firePointEvent("unselect");
                });
            });
        },
        onMouseOver: function(a) {
            var b = this.series, c = b.chart, d = c.tooltip, e = c.hoverPoint;
            if (e && e !== this)
                e.onMouseOut();
            this.firePointEvent("mouseOver");
            d && (!d.shared || b.noSharedTooltip) && d.refresh(this, a);
            this.setState("hover");
            c.hoverPoint = this;
        },
        onMouseOut: function() {
            var a = this.series.chart, b = a.hoverPoints;
            this.firePointEvent("mouseOut");
            if (!b || Tb(this, b) === -1)
                this.setState(), a.hoverPoint = null;
        },
        importEvents: function() {
            if (!this.hasImportedEvents) {
                var a = b(this.series.options.point, this.options).events, c;
                this.events = a;
                for (c in a)
                    Yb(this, c, a[c]);
                this.hasImportedEvents = !0;
            }
        },
        setState: function(c, d) {
            var e = this.plotX, f = this.plotY, g = this.series, h = g.options.states, i = cc[g.type].marker && g.options.marker, j = i && !i.enabled, k = i && i.states[c], l = k && k.enabled === !1, m = g.stateMarkerGraphic, n = this.marker || {}, o = g.chart, p = g.halo, q, c = c || "";
            q = this.pointAttr[c] || g.pointAttr[c];
            if (!(c === this.state && !d || this.selected && "select" !== c || h[c] && h[c].enabled === !1 || c && (l || j && k.enabled === !1) || c && n.states && n.states[c] && n.states[c].enabled === !1)) {
                if (this.graphic)
                    i = i && this.graphic.symbolName && q.r, this.graphic.attr(b(q, i ? {
                        x: e - i,
                        y: f - i,
                        width: 2 * i,
                        height: 2 * i
                    } : {})), m && m.hide();
                else {
                    if (c && k)
                        if (i = k.radius, n = n.symbol || g.symbol, m && m.currentSymbol !== n && (m = m.destroy()),
                                m)
                            m[d ? "animate" : "attr"]({
                                x: e - i,
                                y: f - i
                            });
                        else if (n)
                            g.stateMarkerGraphic = m = o.renderer.symbol(n, e - i, f - i, 2 * i, 2 * i).attr(q).add(g.markerGroup),
                                    m.currentSymbol = n;
                    if (m)
                        m[c && o.isInsidePlot(e, f, o.inverted) ? "show" : "hide"]();
                }
                if ((e = h[c] && h[c].halo) && e.size) {
                    if (!p)
                        g.halo = p = o.renderer.path().add(g.seriesGroup);
                    p.attr(a({
                        fill: gc(this.color || g.color).setOpacity(e.opacity).get()
                    }, e.attributes))[d ? "animate" : "attr"]({
                        d: this.haloPath(e.size)
                    });
                } else
                    p && p.attr({
                        d: []
                    });
                this.state = c;
            }
        },
        haloPath: function(a) {
            var b = this.series, c = b.chart, d = b.getPlotBox(), e = c.inverted;
            return c.renderer.symbols.circle(d.translateX + (e ? b.yAxis.len - this.plotY : this.plotX) - a, d.translateY + (e ? b.xAxis.len - this.plotX : this.plotY) - a, 2 * a, 2 * a);
        }
    });
    a(uc.prototype, {
        onMouseOver: function() {
            var a = this.chart, b = a.hoverSeries;
            if (b && b !== this)
                b.onMouseOut();
            this.options.events.mouseOver && $b(this, "mouseOver");
            this.setState("hover");
            a.hoverSeries = this;
        },
        onMouseOut: function() {
            var a = this.options, b = this.chart, c = b.tooltip, d = b.hoverPoint;
            if (d)
                d.onMouseOut();
            this && a.events.mouseOut && $b(this, "mouseOut");
            c && !a.stickyTracking && (!c.shared || this.noSharedTooltip) && c.hide();
            this.setState();
            b.hoverSeries = null;
        },
        setState: function(a) {
            var b = this.options, c = this.graph, d = this.graphNeg, e = b.states, b = b.lineWidth, a = a || "";
            if (this.state !== a)
                this.state = a, e[a] && e[a].enabled === !1 || (a && (b = e[a].lineWidth || b + (e[a].lineWidthPlus || 0)),
                        c && !c.dashstyle && (a = {
                            "stroke-width": b
                        }, c.attr(a), d && d.attr(a)));
        },
        setVisible: function(a, b) {
            var c = this, d = c.chart, e = c.legendItem, f, g = d.options.chart.ignoreHiddenSeries, h = c.visible;
            f = (c.visible = a = c.userOptions.visible = a === K ? !h : a) ? "show" : "hide";
            Ub(["group", "dataLabelsGroup", "markerGroup", "tracker"], function(a) {
                if (c[a])
                    c[a][f]();
            });
            if (d.hoverSeries === c)
                c.onMouseOut();
            e && d.legend.colorizeItem(c, a);
            c.isDirty = !0;
            c.options.stacking && Ub(d.series, function(a) {
                if (a.options.stacking && a.visible)
                    a.isDirty = !0;
            });
            Ub(c.linkedSeries, function(b) {
                b.setVisible(a, !1);
            });
            if (g)
                d.isDirtyBox = !0;
            b !== !1 && d.redraw();
            $b(c, f);
        },
        setTooltipPoints: function(a) {
            var b = [], c, d, e = this.xAxis, f = e && e.getExtremes(), g = e ? e.tooltipLen || e.len : this.chart.plotSizeX, h, i, j = [];
            if (!(this.options.enableMouseTracking === !1 || this.singularTooltips)) {
                if (a)
                    this.tooltipPoints = null;
                Ub(this.segments || this.points, function(a) {
                    b = b.concat(a);
                });
                e && e.reversed && (b = b.reverse());
                this.orderTooltipPoints && this.orderTooltipPoints(b);
                a = b.length;
                for (i = 0; i < a; i++)
                    if (e = b[i], c = e.x, c >= f.min && c <= f.max) {
                        h = b[i + 1];
                        c = d === K ? 0 : d + 1;
                        for (d = b[i + 1] ? S(R(0, P((e.clientX + (h ? h.wrappedClientX || h.clientX : g)) / 2)), g) : g; c >= 0 && c <= d; )
                            j[c++] = e;
                    }
                this.tooltipPoints = j;
            }
        },
        show: function() {
            this.setVisible(!0);
        },
        hide: function() {
            this.setVisible(!1);
        },
        select: function(a) {
            this.selected = a = a === K ? !this.selected : a;
            if (this.checkbox)
                this.checkbox.checked = a;
            $b(this, a ? "select" : "unselect");
        },
        drawTracker: Pb.drawTrackerGraph
    });
    a(Ob, {
        Axis: H,
        Chart: I,
        Color: gc,
        Point: tc,
        Tick: G,
        Renderer: hb,
        Series: uc,
        SVGElement: F,
        SVGRenderer: hc,
        arrayMin: y,
        arrayMax: z,
        charts: tb,
        dateFormat: nb,
        format: u,
        pathAnim: pb,
        getOptions: function() {
            return mb;
        },
        hasBidiBug: fb,
        isTouchDevice: cb,
        numberFormat: r,
        seriesTypes: Nb,
        setOptions: function(a) {
            mb = b(!0, mb, a);
            E();
            return mb;
        },
        addEvent: Yb,
        removeEvent: Zb,
        createElement: p,
        discardElement: B,
        css: o,
        each: Ub,
        extend: a,
        map: Xb,
        merge: b,
        pick: n,
        splat: m,
        extendClass: q,
        pInt: c,
        wrap: t,
        svg: eb,
        canvas: gb,
        vml: !eb && !gb,
        product: "Highcharts",
        version: "4.0.4"
    });
}();