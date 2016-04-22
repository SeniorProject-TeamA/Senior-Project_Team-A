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

    // Copy: shipping to billing
    $('input#copy-shipping').on('change', function(){
        if (this.checked) {
            var state = $('#ship-state option:selected').val();

            $("[name='bill-address']").val($("[name='ship-address']").val());
            $("[name='bill-city']").val($("[name='ship-city']").val());
            // $("[name='bill-state']").val($("[name='ship-state']").val());
            $('#bill-state option[value=' + state + ']').attr('selected', 'selected');
            $("[name='bill-zip']").val($("[name='ship-zip']").val());
        }
    });

    // Output: returned status
    $(function(){
        var value = $('input#session-return').val();
        $("#return-status").typed({ strings: [value], typeSpeed: 0 });
    });

});

// -----------------------------------------------------
//              Validation Script(s)
// -----------------------------------------------------

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

// -----------------------------------------------------
//              Dropdown Menu Script(s)
// -----------------------------------------------------

// Clear: all panels in admin screen
function clearPanels() {
    frm = $('#williams');
    $(frm).find('input:text').val('');
    $(frm).find('input:checkbox').attr('checked', false);
    $(frm).find('textarea#order-details').val('');
    $(frm).find('select').prop('selectedIndex', 1);
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

// -----------------------------------------------------
//              Form Submission
// -----------------------------------------------------

// Form submission for mitigating commands from the admin screen to the init.php file
function submitForm(form, command) {
    var proc = document.createElement("input");         // Create a new element input, this will be our hashed password field.

    form.appendChild(proc);
    proc.name = "proc";
    proc.type = "hidden";
    proc.value = command;

    form.submit();

    return false;
}