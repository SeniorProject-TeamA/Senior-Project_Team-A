function formhash(form, password) {
    var p = document.createElement("input");            // Create a new element input, this will be our hashed password field.

    form.appendChild(p);                                // Add the new element to our form.
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);

    password.value = "";                                // Make sure the plaintext password doesn't get sent.

    form.submit();                                      // Finally submit the form.
}

function regformhash(form, uid, password, conf) {
     // Check each field has a value
    if (uid.value == '' || password.value == '' || conf.value == '') {
        alert('You must provide all the requested details. Please try again');
        return false;
    }

    // Check that the password is sufficiently long (min 6 chars)
    // The check is duplicated below, but this is included to give more
    // specific guidance to the user
    if (password.value.length < 6) {
        alert('Passwords must be at least 6 characters long.  Please try again');
        form.password.focus();
        return false;
    }

    // At least one number, one lowercase and one uppercase letter
    // At least six characters

    var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/;
    if (!re.test(password.value)) {
        alert('Passwords must contain at least one number, one lowercase and one uppercase letter.  Please try again');
        return false;
    }

    // Check password and confirmation are the same
    if (password.value != conf.value) {
        alert('Your password and confirmation do not match. Please try again');
        form.password.focus();
        return false;
    }

    var p = document.createElement("input");            // Create a new element input, this will be our hashed password field.

    form.appendChild(p);                                // Add the new element to our form.
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);

    password.value = "";                                // Make sure the plaintext password doesn't get sent.
    conf.value = "";

    form.submit();                                      // Finally submit the form.
    return true;
}