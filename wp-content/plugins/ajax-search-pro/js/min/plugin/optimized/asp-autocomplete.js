(function (e) {
    e.fn.extend(window.WPD.ajaxsearchpro.plugin, {
        autocomplete: function () {
            let a = this, b = a.n("text").val(); if ("" == a.n("text").val()) a.n("textAutocomplete").val(""); else {
                var f = a.n("textAutocomplete").val(); if ("" == f || 0 != f.indexOf(b)) a.n("textAutocomplete").val(""), a.n("text").val().length >= a.o.autocomplete.trigger_charcount && (f = { action: "ajaxsearchpro_autocomplete", asid: a.o.id, sauto: a.n("text").val(), asp_inst_id: a.o.rid, options: e("form", a.n("searchsettings")).serialize() }, a.postAuto = e.fn.ajax({
                    url: ASP.ajaxurl,
                    method: "POST", data: f, success: function (c) { 0 < c.length && (c = e("<textarea />").html(c).text(), c = c.replace(/^\s*[\r\n]/gm, ""), c = b + c.substr(b.length)); a.n("textAutocomplete").val(c); a.fixAutocompleteScrollLeft() }
                }))
            }
        }, autocompleteGoogleOnly: function () {
            let a = this, b = a.n("text").val(); if ("" == a.n("text").val()) a.n("textAutocomplete").val(""); else {
                var f = a.n("textAutocomplete").val(); if ("" == f || 0 != f.indexOf(b)) {
                    a.n("textAutocomplete").val(""); var c = a.o.autocomplete.lang;["wpml_lang", "polylang_lang", "qtranslate_lang"].forEach(function (d) {
                        0 <
                            e('input[name="' + d + '"]', a.n("searchsettings")).length && 1 < e('input[name="' + d + '"]', a.n("searchsettings")).val().length && (c = e('input[name="' + d + '"]', a.n("searchsettings")).val())
                    }); a.n("text").val().length >= a.o.autocomplete.trigger_charcount && e.fn.ajax({
                        url: "https://clients1.google.com/complete/search", cors: "no-cors", data: { q: b, hl: c, nolabels: "t", client: "hp", ds: "" }, success: function (d) {
                            0 < d[1].length && (d = d[1][0][0].replace(/(<([^>]+)>)/ig, ""), d = e("<textarea />").html(d).text(), d = d.substr(b.length), a.n("textAutocomplete").val(b +
                                d), a.fixAutocompleteScrollLeft())
                        }
                    })
                }
            }
        }, fixAutocompleteScrollLeft: function () { this.n("textAutocomplete").get(0).scrollLeft = this.n("text").get(0).scrollLeft }
    })
})(WPD.dom);
(function (e) {
    let a = window.WPD.ajaxsearchpro.helpers; e.fn.extend(window.WPD.ajaxsearchpro.plugin, {
        initAutocompleteEvent: function () {
            let b = this, f; if (1 == b.o.autocomplete.enabled && !a.isMobile() || 1 == b.o.autocomplete.mobile && a.isMobile()) b.n("text").on("keyup", function (c) {
                b.keycode = c.keyCode || c.which; b.ktype = c.type; let d = 39; e("body").hasClass("rtl") && (d = 37); b.keycode == d && "" != b.n("textAutocomplete").val() ? (c.preventDefault(), b.n("text").val(b.n("textAutocomplete").val()), 0 != b.o.trigger.type && (b.searchAbort(),
                    b.search())) : (clearTimeout(f), null != b.postAuto && b.postAuto.abort(), 1 == b.o.autocomplete.googleOnly ? b.autocompleteGoogleOnly() : f = setTimeout(function () { b.autocomplete(); f = null }, b.o.trigger.autocomplete_delay))
            }), b.n("text").on("keyup mouseup input blur select", function () { b.fixAutocompleteScrollLeft() })
        }
    })
})(WPD.dom);