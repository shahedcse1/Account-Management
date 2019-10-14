!function(a) {
    var b = a.Chart, c = a.addEvent, d = a.removeEvent, e = a.createElement, f = a.discardElement, g = a.css, h = a.merge, i = a.each, j = a.extend, k = Math.max, l = document, m = window, n = a.isTouchDevice, o = a.Renderer.prototype.symbols, p = a.getOptions(), q;
    j(p.lang, {
        printChart: "Print chart",
        downloadPNG: "Download PNG image",
        downloadJPEG: "Download JPEG image",
        downloadPDF: "Download PDF document",
        downloadSVG: "Download SVG vector image",
        contextButtonTitle: "Chart context menu"
    });
    p.navigation = {
        menuStyle: {
            border: "1px solid #A0A0A0",
            background: "#FFFFFF",
            padding: "5px 0"
        },
        menuItemStyle: {
            padding: "0 10px",
            background: "none",
            color: "#303030",
            fontSize: n ? "14px" : "11px"
        },
        menuItemHoverStyle: {
            background: "#4572A5",
            color: "#FFFFFF"
        },
        buttonOptions: {
            symbolFill: "#E0E0E0",
            symbolSize: 14,
            symbolStroke: "#666",
            symbolStrokeWidth: 2,
            symbolX: 12.5,
            symbolY: 10.5,
            align: "right",
            buttonSpacing: 3,
            height: 22,
            theme: {
                fill: "white",
                stroke: "none"
            },
            verticalAlign: "top",
            width: 14
        }
    };
    p.exporting = {
        type: "image/png",
        url: "http://export.highcharts.com/",
        buttons: {
            contextButton: {
                menuClassName: "highcharts-contextmenu",
                symbol: "menu",
                _titleKey: "contextButtonTitle",
                menuItems: [{
                        textKey: "printChart",
                        onclick: function() {
                            this.print();
                        }
                    }, {
                        separator: !0
                    }, {
                        textKey: "downloadPNG",
                        onclick: function() {
                            this.exportChart();
                        }
                    }, {
                        textKey: "downloadJPEG",
                        onclick: function() {
                            this.exportChart({
                                type: "image/jpeg"
                            });
                        }
                    }, {
                        textKey: "downloadPDF",
                        onclick: function() {
                            this.exportChart({
                                type: "application/pdf"
                            });
                        }
                    }, {
                        textKey: "downloadSVG",
                        onclick: function() {
                            this.exportChart({
                                type: "image/svg+xml"
                            });
                        }
                    }]
            }
        }
    };
    a.post = function(a, b, c) {
        var d, a = e("form", h({
            method: "post",
            action: a,
            enctype: "multipart/form-data"
        }, c), {
            display: "none"
        }, l.body);
        for (d in b)
            e("input", {
                type: "hidden",
                name: d,
                value: b[d]
            }, null, a);
        a.submit();
        f(a);
    };
    j(b.prototype, {
        getSVG: function(b) {
            var c = this, d, g, k, m, n = h(c.options, b);
            if (!l.createElementNS)
                l.createElementNS = function(a, b) {
                    return l.createElement(b);
                };
            b = e("div", null, {
                position: "absolute",
                top: "-9999em",
                width: c.chartWidth + "px",
                height: c.chartHeight + "px"
            }, l.body);
            g = c.renderTo.style.width;
            m = c.renderTo.style.height;
            g = n.exporting.sourceWidth || n.chart.width || /px$/.test(g) && parseInt(g, 10) || 600;
            m = n.exporting.sourceHeight || n.chart.height || /px$/.test(m) && parseInt(m, 10) || 400;
            j(n.chart, {
                animation: !1,
                renderTo: b,
                forExport: !0,
                width: g,
                height: m
            });
            n.exporting.enabled = !1;
            n.series = [];
            i(c.series, function(a) {
                k = h(a.options, {
                    animation: !1,
                    enableMouseTracking: !1,
                    showCheckbox: !1,
                    visible: a.visible
                });
                k.isInternal || n.series.push(k);
            });
            d = new a.Chart(n, c.callback);
            i(["xAxis", "yAxis"], function(a) {
                i(c[a], function(b, c) {
                    var e = d[a][c], f = b.getExtremes(), g = f.userMin, f = f.userMax;
                    e && (g !== void 0 || f !== void 0) && e.setExtremes(g, f, !0, !1);
                });
            });
            g = d.container.innerHTML;
            n = null;
            d.destroy();
            f(b);
            g = g.replace(/zIndex="[^"]+"/g, "").replace(/isShadow="[^"]+"/g, "").replace(/symbolName="[^"]+"/g, "").replace(/jQuery[0-9]+="[^"]+"/g, "").replace(/url\([^#]+#/g, "url(#").replace(/<svg /, '<svg xmlns:xlink="http://www.w3.org/1999/xlink" ').replace(/ href=/g, " xlink:href=").replace(/\n/, " ").replace(/<\/svg>.*?$/, "</svg>").replace(/(fill|stroke)="rgba\(([ 0-9]+,[ 0-9]+,[ 0-9]+),([ 0-9\.]+)\)"/g, '$1="rgb($2)" $1-opacity="$3"').replace(/&nbsp;/g, " ").replace(/&shy;/g, "­").replace(/<IMG /g, "<image ").replace(/height=([^" ]+)/g, 'height="$1"').replace(/width=([^" ]+)/g, 'width="$1"').replace(/hc-svg-href="([^"]+)">/g, 'xlink:href="$1"/>').replace(/id=([^" >]+)/g, 'id="$1"').replace(/class=([^" >]+)/g, 'class="$1"').replace(/ transform /g, " ").replace(/:(path|rect)/g, "$1").replace(/style="([^"]+)"/g, function(a) {
                return a.toLowerCase();
            });
            return g = g.replace(/(url\(#highcharts-[0-9]+)&quot;/g, "$1").replace(/&quot;/g, "'");
        },
        exportChart: function(b, c) {
            var b = b || {}, d = this.options.exporting, d = this.getSVG(h({
                chart: {
                    borderRadius: 0
                }
            }, d.chartOptions, c, {
                exporting: {
                    sourceWidth: b.sourceWidth || d.sourceWidth,
                    sourceHeight: b.sourceHeight || d.sourceHeight
                }
            })), b = h(this.options.exporting, b);
            a.post(b.url, {
                filename: b.filename || "chart",
                type: b.type,
                width: b.width || 0,
                scale: b.scale || 2,
                svg: d
            }, b.formAttributes);
        },
        print: function() {
            var a = this, b = a.container, c = [], d = b.parentNode, e = l.body, f = e.childNodes;
            if (!a.isPrinting)
                a.isPrinting = !0, i(f, function(a, b) {
                    if (1 === a.nodeType)
                        c[b] = a.style.display, a.style.display = "none";
                }), e.appendChild(b), m.focus(), m.print(), setTimeout(function() {
                    d.appendChild(b);
                    i(f, function(a, b) {
                        if (1 === a.nodeType)
                            a.style.display = c[b];
                    });
                    a.isPrinting = !1;
                }, 1e3);
        },
        contextMenu: function(a, b, f, h, l, m, n) {
            var o = this, p = o.options.navigation, q = p.menuItemStyle, r = o.chartWidth, s = o.chartHeight, t = "cache-" + a, u = o[t], v = k(l, m), w, x, y, z = function(b) {
                o.pointer.inClass(b.target, a) || x();
            };
            if (!u)
                o[t] = u = e("div", {
                    className: a
                }, {
                    position: "absolute",
                    zIndex: 1e3,
                    padding: v + "px"
                }, o.container), w = e("div", null, j({
                    MozBoxShadow: "3px 3px 10px #888",
                    WebkitBoxShadow: "3px 3px 10px #888",
                    boxShadow: "3px 3px 10px #888"
                }, p.menuStyle), u), x = function() {
                    g(u, {
                        display: "none"
                    });
                    n && n.setState(0);
                    o.openMenu = !1;
                }, c(u, "mouseleave", function() {
                    y = setTimeout(x, 500);
                }), c(u, "mouseenter", function() {
                    clearTimeout(y);
                }), c(document, "mouseup", z), c(o, "destroy", function() {
                    d(document, "mouseup", z);
                }), i(b, function(a) {
                    if (a) {
                        var b = a.separator ? e("hr", null, null, w) : e("div", {
                            onmouseover: function() {
                                g(this, p.menuItemHoverStyle);
                            },
                            onmouseout: function() {
                                g(this, q);
                            },
                            onclick: function() {
                                x();
                                a.onclick.apply(o, arguments);
                            },
                            innerHTML: a.text || o.options.lang[a.textKey]
                        }, j({
                            cursor: "pointer"
                        }, q), w);
                        o.exportDivElements.push(b);
                    }
                }), o.exportDivElements.push(w, u), o.exportMenuWidth = u.offsetWidth, o.exportMenuHeight = u.offsetHeight;
            b = {
                display: "block"
            };
            f + o.exportMenuWidth > r ? b.right = r - f - l - v + "px" : b.left = f - v + "px";
            h + m + o.exportMenuHeight > s && "top" !== n.alignOptions.verticalAlign ? b.bottom = s - h - v + "px" : b.top = h + m - v + "px";
            g(u, b);
            o.openMenu = !0;
        },
        addButton: function(b) {
            var c = this, d = c.renderer, e = h(c.options.navigation.buttonOptions, b), f = e.onclick, g = e.menuItems, i, k, l = {
                stroke: e.symbolStroke,
                fill: e.symbolFill
            }, m = e.symbolSize || 12;
            if (!c.btnCount)
                c.btnCount = 0;
            if (!c.exportDivElements)
                c.exportDivElements = [], c.exportSVGElements = [];
            if (e.enabled !== !1) {
                var n = e.theme, o = n.states, p = o && o.hover, o = o && o.select, r;
                delete n.states;
                f ? r = function() {
                    f.apply(c, arguments);
                } : g && (r = function() {
                    c.contextMenu(k.menuClassName, g, k.translateX, k.translateY, k.width, k.height, k);
                    k.setState(2);
                });
                e.text && e.symbol ? n.paddingLeft = a.pick(n.paddingLeft, 25) : e.text || j(n, {
                    width: e.width,
                    height: e.height,
                    padding: 0
                });
                k = d.button(e.text, 0, 0, r, n, p, o).attr({
                    title: c.options.lang[e._titleKey],
                    "stroke-linecap": "round"
                });
                k.menuClassName = b.menuClassName || "highcharts-menu-" + c.btnCount++;
                e.symbol && (i = d.symbol(e.symbol, e.symbolX - m / 2, e.symbolY - m / 2, m, m).attr(j(l, {
                    "stroke-width": e.symbolStrokeWidth || 1,
                    zIndex: 1
                })).add(k));
                k.add().align(j(e, {
                    width: k.width,
                    x: a.pick(e.x, q)
                }), !0, "spacingBox");
                q += (k.width + e.buttonSpacing) * ("right" === e.align ? -1 : 1);
                c.exportSVGElements.push(k, i);
            }
        },
        destroyExport: function(a) {
            var a = a.target, b, c;
            for (b = 0; b < a.exportSVGElements.length; b++)
                if (c = a.exportSVGElements[b])
                    c.onclick = c.ontouchstart = null,
                            a.exportSVGElements[b] = c.destroy();
            for (b = 0; b < a.exportDivElements.length; b++)
                c = a.exportDivElements[b], d(c, "mouseleave"),
                        a.exportDivElements[b] = c.onmouseout = c.onmouseover = c.ontouchstart = c.onclick = null,
                        f(c);
        }
    });
    o.menu = function(a, b, c, d) {
        return ["M", a, b + 2.5, "L", a + c, b + 2.5, "M", a, b + d / 2 + .5, "L", a + c, b + d / 2 + .5, "M", a, b + d - 1.5, "L", a + c, b + d - 1.5];
    };
    b.prototype.callbacks.push(function(a) {
        var b, d = a.options.exporting, e = d.buttons;
        q = 0;
        if (d.enabled !== !1) {
            for (b in e)
                a.addButton(e[b]);
            c(a, "destroy", a.destroyExport);
        }
    });
}(Highcharts);