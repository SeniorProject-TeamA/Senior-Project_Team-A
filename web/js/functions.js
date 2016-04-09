// Tootle Popover
$(document).ready(function() {
    var min     = 'glyphicon-minus';
    var max     = 'glyphicon-plus';
    var status  = 'span.glyphicon-menu-right';

    $('[data-toggle="popover"]').popover({trigger: "hover"});

    $('button.min-max').click(function() {
        var glyph = $(this).children('span.glyphicon');
        (glyph.hasClass(min)) ? glyph.toggleClass(min, false).addClass(max) : glyph.toggleClass(max, false).addClass(min);
    });

    function blink() {
        $(status).fadeOut(500);
        $(status).fadeIn(500);
    }

    setInterval(blink, 1000);
});