// Load: JavaScript when DOM is ready!
$(document).ready(function() {
    var min     = 'glyphicon-chevron-up';
    var max     = 'glyphicon-chevron-down';
    var status  = 'span.glyphicon-menu-right';

    // Tootle Popover
    $('[data-toggle="popover"]').popover({trigger: "hover"});

    $('button.min-max').click(function() {
        var glyph = $(this).children('span.glyphicon');
        (glyph.hasClass(min)) ? glyph.toggleClass(min, false).addClass(max) : glyph.toggleClass(max, false).addClass(min);
    });

    // Blinking status
    function blink() {
        $(status).fadeOut(500);
        $(status).fadeIn(500);
    }

    setInterval(blink, 1000);
});

// Input: validation check(s)
function validateInputElement(e) {
    setTimeout(clearAlerts, 3000);                      // Set: timeout to clear alerts

    if ($(e).val() == null || $(e).val() == '') {
        pID = $(e).parents('div.panel-body').attr('id');
        $('#' + pID).find('div.alert:first').show('slow');
        return false;
    }
};

// Input: group validation check(s)
function validateInputGroup(e) {
    var ie = $('div' + e + ' :input').each(function(){}); // Input Elements (Array)
    var v  = 0;

    setTimeout(clearAlerts, 3000);                      // Set: timeout to clear alerts

    for (var i = 0; i < ie.length; i++) {
        if ($(ie[i]).val() == null || $(ie[i]).val() == '') {
            $(ie[i]).parents(e).find('div.alert:eq(' + i + ')').show('slow');
            v = 1;
        }
    }

    if (v > 0) return false;
}

// Clear: validation alerts
function clearAlerts() {
    $("div[style='display': block;']").hide('slow');
}

// Clear: all panels in admin screen
function clearPanels() {
    frm = $('#williams');
    $(frm).find('input:text').val('');
    // $(frm).find('input:checkbox').val('');
    $(frm).find('select').prop('selectedIndex', 0);
    return false;
}

// Close: all panels in admin screen
function closePanels() {
    $('div.collapse').collapse('hide');
    return false;
}

// Open: all panels in admin screen
function openPanels() {
    $('div.collapse').collapse('show');
    return false;
}

function submitForm(form, command) {
    var proc = document.createElement("input");         // Create a new element input, this will be our hashed password field.

    form.appendChild(proc);
    proc.name = "proc";
    proc.type = "hidden";
    proc.value = command;

    form.submit();

    return false;
}