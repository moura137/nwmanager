$(document).ready(function () {

    $("body").on("click", ".input-group.date", function(){

        var $this = $(this);

        $this.datepicker({
            language: "pt-BR",
            format: "dd/mm/yyyy",
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true
        });

        $this.datepicker("show");
    });

    // Minimalize menu
    $("body").on("click", ".navbar-minimalize", function (e) {
        e.preventDefault();
        $("body").toggleClass("mini-navbar");
    });

    // Add body-small class if window less than 768px
    if ($(this).width() < 769) {
        $('body').addClass('body-small')
    } else {
        $('body').removeClass('body-small')
    }

    // Full height of sidebar
    function fix_height() {
        var heightNavTop = 0;

        var heightWithoutNavbar = $("body > #wrapper").height() - heightNavTop - 1;
        $(".sidebard-panel").css("min-height", heightWithoutNavbar + "px");

        var navbarHeigh = $('nav.navbar-default').height();
        var wrapperHeigh = $('#page-wrapper').height();

        if (navbarHeigh > wrapperHeigh) {
            $('#page-wrapper').css("min-height", navbarHeigh + "px");
        }

        if (navbarHeigh < wrapperHeigh) {
            $('#page-wrapper').css("min-height", $(window).height() + "px");
        }

        if ($('body').hasClass('fixed-nav')) {
            $('#page-wrapper').css("min-height", $(window).height() - heightNavTop + "px");
        }

    }

    $(document).on("fix-height", function(event) {
        setTimeout(function() { fix_height(); }, 100);
    });
});
