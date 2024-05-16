const validateAccount = () => {
    let username = $('#username').val();
    let password = $('#password').val();
    let email = $('#email').val();
    let phone = $('#phoneNumber').val();
    
    if (username === null || username.length <= 0)
        return 'Username cannot be empty.';
    
    if (password === null || password.length <= 0)
        return 'Password cannot be empty.';
    
    if (password.length < 8)
        return 'Password must be at least 8 characters long.';
    
    if (email === null || email.length <= 0)
        return 'Email cannot be empty.';
    
    // simple email validation
    if (!/^\S+@\S+$/.test(email))
        return 'Email is invalid.';
    
    if (phone === null || phone.length <= 0)
        return 'Phone number cannot be empty.';
    
    if (phone.length < 8)
        return 'Phone number must be at least 8 numbers.';
    
    return null;
};

const validateDetails = () => {
    let firstName = $('#firstName').val();
    let lastName = $('#lastName').val();
    let gender = $('#gender').val();
    let nationality = $('#nationality').val();
    let dob = $('#dob').val();
    let companyName = $('#companyName').val();
    let website = $('#website').val();
    let city = $('#city').val();
    let size = $('#size').val();
    
    if (firstName === null || firstName.length <= 0)
        return 'First name cannot be empty.';
    
    if (lastName === null || lastName.length <= 0)
        return 'Last name cannot be empty.';
    
    if (gender === null || gender.length <= 0)
        return 'Gender cannot be empty.';
    
    if (nationality === null || nationality.length <= 0)
        return 'Nationality cannot be empty.';
    
    if (firstName === null || firstName.length <= 0)
        return 'First name cannot be empty.';
    
    if (firstName === null || firstName.length <= 0)
        return 'First name cannot be empty.';
    
    return null;
};

const registerUser = () => {
    validateDetails();
    $.ajax({
        type: 'POST',
        url: 'register.php',
        data: {
            submitted: true,
            username: $('#username').val(),
            password: $('#password').val(),
            email: $('#email').val(),
            phone: $('#phoneNumber').val(),
            firstName: $('#firstName').val(),
            lastName: $('#lastName').val(),
            gender: $('#gender').val(),
            nationality: $('#nationality').val(),
            dob: $('#dob').val(),
            companyName: $('#companyName').val(),
            website: $('#website').val(),
            city: $('#city').val(),
            size: $('#size').val()
        }
    }).then(function(res) {
        if (res > 0) {
            console.log('user registered successfully');
        } else {
            
        }
    });
};

const displayError = (message) => {
    $('#errorBox').html(message);
    $('#errorBox').removeClass('d-none');
};

const hideError = () => {
    $('#errorBox').addClass('d-none');
};

var currentPage = 0;

const setPage = (num) => {
    currentPage = num;
    if (currentPage === 0) {
        $('#accountForm').removeClass('d-none');
        $('#detailsForm').addClass('d-none');
        $('#nextBtn').removeClass('d-none');
        $('#backBtn').addClass('d-none');
        $('#regBtn').addClass('d-none');
    } else if (currentPage === 1) {
        $('#accountForm').addClass('d-none');
        $('#detailsForm').removeClass('d-none');
        $('#nextBtn').addClass('d-none');
        $('#backBtn').removeClass('d-none');
        $('#regBtn').removeClass('d-none');
    }
};

$('#nextBtn').on("click", function() {
//    console.log("Clicked next");
    let message = validateAccount();
    if (message !== null) {
        displayError(message);
        return;
    }
    hideError();
    setPage(1);
});

$('#backBtn').on("click", function() {
    hideError();
    setPage(0);
});

$('#regBtn').on("click", function() {
    let message = validateDetails();
    if (message !== null) {
        displayError(message);
        return;
    }
    registerUser();
});

