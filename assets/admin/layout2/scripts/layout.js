var Layout=function(){var e="admin/layout2/img/",t="admin/layout2/css/",i=Metronic.getResponsiveBreakpoint("md"),a=function(){var e,t=$(".page-content"),a=$(".page-sidebar"),o=$("body");if(o.hasClass("page-footer-fixed")===!0&&o.hasClass("page-sidebar-fixed")===!1){var s=Metronic.getViewPort().height-$(".page-footer").outerHeight()-$(".page-header").outerHeight();t.height()<s&&t.attr("style","min-height:"+s+"px")}else{if(o.hasClass("page-sidebar-fixed"))e=n(),o.hasClass("page-footer-fixed")===!1&&(e-=$(".page-footer").outerHeight());else{var r=$(".page-header").outerHeight(),d=$(".page-footer").outerHeight();e=Metronic.getViewPort().width<i?Metronic.getViewPort().height-r-d:a.outerHeight()+10,e+r+d<=Metronic.getViewPort().height&&(e=Metronic.getViewPort().height-r-d)}t.attr("style","min-height:"+e+"px")}},o=function(e,t){var a=location.hash.toLowerCase(),o=$(".page-sidebar-menu");if("click"===e||"set"===e?t=$(t):"match"===e&&o.find("li > a").each(function(){var e=$(this).attr("href").toLowerCase();if(e.length>1&&a.substr(1,e.length-1)==e.substr(1))return void(t=$(this))}),t&&0!=t.size()&&"javascript:;"!==t.attr("href").toLowerCase()&&"#"!==t.attr("href").toLowerCase()){parseInt(o.data("slide-speed")),o.data("keep-expanded");o.find("li.active").removeClass("active"),o.find("li > a > .selected").remove(),o.hasClass("page-sidebar-menu-hover-submenu")===!1?o.find("li.open").each(function(){0===$(this).children(".sub-menu").size()&&($(this).removeClass("open"),$(this).find("> a > .arrow.open").removeClass("open"))}):o.find("li.open").removeClass("open"),t.parents("li").each(function(){$(this).addClass("active"),$(this).find("> a > span.arrow").addClass("open"),1===$(this).parent("ul.page-sidebar-menu").size()&&$(this).find("> a").append('<span class="selected"></span>'),1===$(this).children("ul.sub-menu").size()&&$(this).addClass("open")}),"click"===e&&Metronic.getViewPort().width<i&&$(".page-sidebar").hasClass("in")&&$(".page-header .responsive-toggler").click()}},s=function(){$(".page-sidebar").on("click","li > a",function(e){if(!(Metronic.getViewPort().width>=i&&1===$(this).parents(".page-sidebar-menu-hover-submenu").size())){if($(this).next().hasClass("sub-menu")===!1)return void(Metronic.getViewPort().width<i&&$(".page-sidebar").hasClass("in")&&$(".page-header .responsive-toggler").click());if(!$(this).next().hasClass("sub-menu always-open")){var t=$(this).parent().parent(),o=$(this),s=$(".page-sidebar-menu"),n=$(this).next(),r=s.data("auto-scroll"),d=parseInt(s.data("slide-speed")),c=s.data("keep-expanded");c!==!0&&(t.children("li.open").children("a").children(".arrow").removeClass("open"),t.children("li.open").children(".sub-menu:not(.always-open)").slideUp(d),t.children("li.open").removeClass("open"));var l=-200;n.is(":visible")?($(".arrow",$(this)).removeClass("open"),$(this).parent().removeClass("open"),n.slideUp(d,function(){r===!0&&$("body").hasClass("page-sidebar-closed")===!1&&($("body").hasClass("page-sidebar-fixed")?s.slimScroll({scrollTo:o.position().top}):Metronic.scrollTo(o,l)),a()})):($(".arrow",$(this)).addClass("open"),$(this).parent().addClass("open"),n.slideDown(d,function(){r===!0&&$("body").hasClass("page-sidebar-closed")===!1&&($("body").hasClass("page-sidebar-fixed")?s.slimScroll({scrollTo:o.position().top}):Metronic.scrollTo(o,l)),a()})),e.preventDefault()}}}),$(".page-sidebar").on("click"," li > a.ajaxify",function(e){e.preventDefault(),Metronic.scrollTop();var t=$(this).attr("href"),a=$(".page-sidebar ul"),o=($(".page-content"),$(".page-content .page-content-body"));a.children("li.active").removeClass("active"),a.children("arrow.open").removeClass("open"),$(this).parents("li").each(function(){$(this).addClass("active"),$(this).children("a > span.arrow").addClass("open")}),$(this).parents("li").addClass("active"),Metronic.getViewPort().width<i&&$(".page-sidebar").hasClass("in")&&$(".page-header .responsive-toggler").click(),Metronic.startPageLoading();var s=$(this);$.ajax({type:"GET",cache:!1,url:t,dataType:"html",success:function(e){0===s.parents("li.open").size()&&$(".page-sidebar-menu > li.open > a").click(),Metronic.stopPageLoading(),o.html(e),Layout.fixContentHeight(),Metronic.initAjax()},error:function(e,t,i){Metronic.stopPageLoading(),o.html("<h4>Could not load the requested content.</h4>")}})}),$(".page-content").on("click",".ajaxify",function(e){e.preventDefault(),Metronic.scrollTop();var t=$(this).attr("href"),a=($(".page-content"),$(".page-content .page-content-body"));Metronic.startPageLoading(),Metronic.getViewPort().width<i&&$(".page-sidebar").hasClass("in")&&$(".page-header .responsive-toggler").click(),$.ajax({type:"GET",cache:!1,url:t,dataType:"html",success:function(e){Metronic.stopPageLoading(),a.html(e),Layout.fixContentHeight(),Metronic.initAjax()},error:function(e,t,i){a.html("<h4>Could not load the requested content.</h4>"),Metronic.stopPageLoading()}})}),$(document).on("click",".page-header-fixed-mobile .page-header .responsive-toggler",function(){Metronic.scrollTop()})},n=function(){var e=Metronic.getViewPort().height-$(".page-header").outerHeight();return $("body").hasClass("page-footer-fixed")&&(e-=$(".page-footer").outerHeight()),e},r=function(){var e=$(".page-sidebar-menu");return Metronic.destroySlimScroll(e),0===$(".page-sidebar-fixed").size()?void a():void(Metronic.getViewPort().width>=i&&(e.attr("data-height",n()),Metronic.initSlimScroll(e),a()))},d=function(){var e=$("body");e.hasClass("page-sidebar-fixed")&&$(".page-sidebar").on("mouseenter",function(){e.hasClass("page-sidebar-closed")&&$(this).find(".page-sidebar-menu").removeClass("page-sidebar-menu-closed")}).on("mouseleave",function(){e.hasClass("page-sidebar-closed")&&$(this).find(".page-sidebar-menu").addClass("page-sidebar-menu-closed")})},c=function(){var e=$("body");$.cookie&&"1"===$.cookie("sidebar_closed")&&Metronic.getViewPort().width>=i&&($("body").addClass("page-sidebar-closed"),$(".page-sidebar-menu").addClass("page-sidebar-menu-closed")),$("body").on("click",".sidebar-toggler",function(t){var i=$(".page-sidebar"),a=$(".page-sidebar-menu");$(".sidebar-search",i).removeClass("open"),e.hasClass("page-sidebar-closed")?(e.removeClass("page-sidebar-closed"),a.removeClass("page-sidebar-menu-closed"),$.cookie&&$.cookie("sidebar_closed","0")):(e.addClass("page-sidebar-closed"),a.addClass("page-sidebar-menu-closed"),e.hasClass("page-sidebar-fixed")&&a.trigger("mouseleave"),$.cookie&&$.cookie("sidebar_closed","1")),$(window).trigger("resize")}),d(),$(".page-sidebar").on("click",".sidebar-search .remove",function(e){e.preventDefault(),$(".sidebar-search").removeClass("open")}),$(".page-sidebar .sidebar-search").on("keypress","input.form-control",function(e){if(13==e.which)return $(".sidebar-search").submit(),!1}),$(".sidebar-search .submit").on("click",function(e){e.preventDefault(),$("body").hasClass("page-sidebar-closed")&&$(".sidebar-search").hasClass("open")===!1?(1===$(".page-sidebar-fixed").size()&&$(".page-sidebar .sidebar-toggler").click(),$(".sidebar-search").addClass("open")):$(".sidebar-search").submit()}),0!==$(".sidebar-search").size()&&($(".sidebar-search .input-group").on("click",function(e){e.stopPropagation()}),$("body").on("click",function(){$(".sidebar-search").hasClass("open")&&$(".sidebar-search").removeClass("open")}))},l=function(){$(".page-header").on("click",".search-form",function(e){$(this).addClass("open"),$(this).find(".form-control").focus(),$(".page-header .search-form .form-control").on("blur",function(e){$(this).closest(".search-form").removeClass("open"),$(this).unbind("blur")})}),$(".page-header").on("keypress",".hor-menu .search-form .form-control",function(e){if(13==e.which)return $(this).closest(".search-form").submit(),!1}),$(".page-header").on("mousedown",".search-form.open .submit",function(e){e.preventDefault(),e.stopPropagation(),$(this).closest(".search-form").submit()})},h=function(){$("body").on("shown.bs.tab",'a[data-toggle="tab"]',function(){a()})},p=function(){var e=300,t=500;navigator.userAgent.match(/iPhone|iPad|iPod/i)?$(window).bind("touchend touchcancel touchleave",function(i){$(this).scrollTop()>e?$(".scroll-to-top").fadeIn(t):$(".scroll-to-top").fadeOut(t)}):$(window).scroll(function(){$(this).scrollTop()>e?$(".scroll-to-top").fadeIn(t):$(".scroll-to-top").fadeOut(t)}),$(".scroll-to-top").click(function(e){return e.preventDefault(),$("html, body").animate({scrollTop:0},t),!1})},g=function(){var e,t=$(".full-height-content");if(t.hasClass("portlet")){e=Metronic.getViewPort().height-$(".page-header").outerHeight(!0)-$(".page-footer").outerHeight(!0)-$(".page-title").outerHeight(!0)-$(".page-bar").outerHeight(!0),$("body").hasClass("page-header-fixed")&&(e-=$(".page-header").outerHeight(!0));var a=t.find(".portlet-body");if(Metronic.getViewPort().width<i)return void Metronic.destroySlimScroll(a.find(".full-height-content-body"));t.find(".portlet-title")&&(e-=t.find(".portlet-title").outerHeight(!0)),e-=parseInt(a.css("padding-top")),e-=parseInt(a.css("padding-bottom")),t.hasClass("full-height-content-scrollable")?(a.find(".full-height-content-body").css("height",e),Metronic.initSlimScroll(a.find(".full-height-content-body"))):a.css("min-height",e)}};return{initHeader:function(){l()},setSidebarMenuActiveLink:function(e,t){o(e,t)},initSidebar:function(){r(),s(),c(),Metronic.isAngularJsApp()&&o("match"),Metronic.addResizeHandler(r)},initContent:function(){g(),h(),Metronic.addResizeHandler(a),Metronic.addResizeHandler(g)},initFooter:function(){p()},init:function(){this.initHeader(),this.initSidebar(),this.initContent(),this.initFooter()},fixContentHeight:function(){a()},initFixedSidebarHoverEffect:function(){d()},initFixedSidebar:function(){r()},getLayoutImgPath:function(){return Metronic.getAssetsPath()+e},getLayoutCssPath:function(){return Metronic.getAssetsPath()+t}}}();