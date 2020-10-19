! function(s) {
    s.fn.extend({
        smoothproducts: function() {
            function e() {
                s(".sp-selected").removeClass("sp-selected"), s(".sp-lightbox").fadeOut(function() {
                    s(this).remove()
                })
            }

            function t(s) {
                return s.match(/url\([\"\']{0,1}(.+)[\"\']{0,1}\)+/i)[1]
            }
            s(".sp-loading").hide(), s(".sp-wrap").each(function() {
                if (s(this).addClass("sp-touch"), s("a", this).length > 1) {
                    var e, t, a = !!s("a.sp-default", this)[0];
                    s(this).append('<div class="sp-large"></div><div class="sp-thumbs sp-tb-active"></div>'), s("a", this).each(function(p) {
                        var n = s("img", this).attr("src"),
                            i = s(this).attr("href"),
                            r = "";
                        (0 === p && !a || s(this).hasClass("sp-default")) && (r = ' class="sp-current"', e = i, t = s("img", this)[0].src), s(this).parents(".sp-wrap").find(".sp-thumbs").append('<a href="' + i + '" style="background-image:url(' + n + ')"' + r + "></a>"), s(this).remove()
                    }), s(".sp-large", this).append('<a href="' + e + '" class="sp-current-big"><img src="' + t + '" alt="" /></a>'), s(".sp-wrap").css("display", "inline-block")
                } else s(this).append('<div class="sp-large"></div>'), s("a", this).appendTo(s(".sp-large", this)).addClass(".sp-current-big"), s(".sp-wrap").css("display", "inline-block")
            }), s(document.body).on("click", ".sp-thumbs", function(s) {
                s.preventDefault()
            }), s(document.body).on("mouseover", function(e) {
                s(".sp-wrap").removeClass("sp-touch").addClass("sp-non-touch"), e.preventDefault()
            }), s(document.body).on("touchstart", function() {
                s(".sp-wrap").removeClass("sp-non-touch").addClass("sp-touch")
            }), s(document.body).on("click", ".sp-tb-active a", function(e) {
                e.preventDefault(), s(this).parent().find(".sp-current").removeClass(), s(this).addClass("sp-current"), s(this).parents(".sp-wrap").find(".sp-thumbs").removeClass("sp-tb-active"), s(this).parents(".sp-wrap").find(".sp-zoom").remove();
                var a = s(this).parents(".sp-wrap").find(".sp-large").height(),
                    p = s(this).parents(".sp-wrap").find(".sp-large").width();
                s(this).parents(".sp-wrap").find(".sp-large").css({
                    overflow: "hidden",
                    height: a + "px",
                    width: p + "px"
                }), s(this).addClass("sp-current").parents(".sp-wrap").find(".sp-large a").remove();
                var n = s(this).parent().find(".sp-current").attr("href"),
                    i = t(s(this).parent().find(".sp-current").css("backgroundImage"));
                s(this).parents(".sp-wrap").find(".sp-large").html('<a href="' + n + '" class="sp-current-big"><img src="' + i + '"/></a>'), s(this).parents(".sp-wrap").find(".sp-large").hide().fadeIn(250, function() {
                    var e = s(this).parents(".sp-wrap").find(".sp-large img").height();
                    s(this).parents(".sp-wrap").find(".sp-large").animate({
                        height: e
                    }, "fast", function() {
                        s(".sp-large").css({
                            height: "auto",
                            width: "auto"
                        })
                    }), s(this).parents(".sp-wrap").find(".sp-thumbs").addClass("sp-tb-active")
                })
            }), s(document.body).on("mouseenter", ".sp-non-touch .sp-large", function(e) {
                var t = s("a", this).attr("href");
                s(this).append('<div class="sp-zoom"><img src="' + t + '"/></div>'), s(this).find(".sp-zoom").fadeIn(250), e.preventDefault()
            }), s(document.body).on("mouseleave", ".sp-non-touch .sp-large", function(e) {
                s(this).find(".sp-zoom").fadeOut(250, function() {
                    s(this).remove()
                }), e.preventDefault()
            }), s(document.body).on("click", ".sp-non-touch .sp-zoom", function(e) {
                var t = s(this).html(),
                    a = s(this).parents(".sp-wrap").find(".sp-thumbs a").length,
                    p = s(this).parents(".sp-wrap").find(".sp-thumbs .sp-current").index() + 1;
                s(this).parents(".sp-wrap").addClass("sp-selected"), s("body").append("<div class='sp-lightbox' data-currenteq='" + p + "'>" + t + "</div>"), a > 1 && (s(".sp-lightbox").append("<a href='#' id='sp-prev'></a><a href='#' id='sp-next'></a>"), 1 == p ? s("#sp-prev").css("opacity", ".1") : p == a && s("#sp-next").css("opacity", ".1")), s(".sp-lightbox").fadeIn(), e.preventDefault()
            }), s(document.body).on("click", ".sp-large a", function(e) {
                var t = s(this).attr("href"),
                    a = s(this).parents(".sp-wrap").find(".sp-thumbs a").length,
                    p = s(this).parents(".sp-wrap").find(".sp-thumbs .sp-current").index() + 1;
                s(this).parents(".sp-wrap").addClass("sp-selected"), s("body").append('<div class="sp-lightbox" data-currenteq="' + p + '"><img src="' + t + '"/></div>'), a > 1 && (s(".sp-lightbox").append("<a href='#' id='sp-prev'></a><a href='#' id='sp-next'></a>"), 1 == p ? s("#sp-prev").css("opacity", ".1") : p == a && s("#sp-next").css("opacity", ".1")), s(".sp-lightbox").fadeIn(), e.preventDefault()
            }), s(document.body).on("click", "#sp-next", function(e) {
                e.stopPropagation();
                var a = s(".sp-lightbox").data("currenteq"),
                    p = s(".sp-selected .sp-thumbs a").length;
                if (a >= p);
                else {
                    var n = a + 1,
                        i = s(".sp-selected .sp-thumbs").find("a:eq(" + a + ")").attr("href"),
                        r = t(s(".sp-selected .sp-thumbs").find("a:eq(" + a + ")").css("backgroundImage"));
                    a == p - 1 && s("#sp-next").css("opacity", ".1"), s("#sp-prev").css("opacity", "1"), s(".sp-selected .sp-current").removeClass(), s(".sp-selected .sp-thumbs a:eq(" + a + ")").addClass("sp-current"), s(".sp-selected .sp-large").empty().append("<a href=" + i + '><img src="' + r + '"/></a>'), s(".sp-lightbox img").fadeOut(250, function() {
                        s(this).remove(), s(".sp-lightbox").data("currenteq", n).append('<img src="' + i + '"/>'), s(".sp-lightbox img").hide().fadeIn(250)
                    })
                }
                e.preventDefault()
            }), s(document.body).on("click", "#sp-prev", function(e) {
                e.stopPropagation();
                var a = s(".sp-lightbox").data("currenteq"),
                    a = a - 1;
                if (0 >= a);
                else {
                    1 == a && s("#sp-prev").css("opacity", ".1");
                    var p = a - 1,
                        n = s(".sp-selected .sp-thumbs").find("a:eq(" + p + ")").attr("href"),
                        i = t(s(".sp-selected .sp-thumbs").find("a:eq(" + p + ")").css("backgroundImage"));
                    s("#sp-next").css("opacity", "1"), s(".sp-selected .sp-current").removeClass(), s(".sp-selected .sp-thumbs a:eq(" + p + ")").addClass("sp-current"), s(".sp-selected .sp-large").empty().append("<a href=" + n + '><img src="' + i + '"/></a>'), s(".sp-lightbox img").fadeOut(250, function() {
                        s(this).remove(), s(".sp-lightbox").data("currenteq", a).append('<img src="' + n + '"/>'), s(".sp-lightbox img").hide().fadeIn(250)
                    })
                }
                e.preventDefault()
            }), s(document.body).on("click", ".sp-lightbox", function() {
                e()
            }), s(document).keydown(function(s) {
                return 27 == s.keyCode ? (e(), !1) : void 0
            }), s(".sp-large").mousemove(function(e) {
                var t = s(this).width(),
                    a = s(this).height(),
                    p = s(this).find(".sp-zoom").width(),
                    n = s(this).find(".sp-zoom").height(),
                    i = s(this).parent().offset(),
                    r = e.pageX - i.left,
                    o = e.pageY - i.top,
                    d = Math.floor(r * (t - p) / t),
                    c = Math.floor(o * (a - n) / a);
                s(this).find(".sp-zoom").css({
                    left: d,
                    top: c
                })
            })
        }
    })
}(jQuery), $(".clean-gallery").length > 0 && baguetteBox.run(".clean-gallery", {
    animation: "slideIn"
}), $(".clean-product").length > 0 && $(window).on("load", function() {
    $(".sp-wrap").smoothproducts()
});