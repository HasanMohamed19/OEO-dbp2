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
    
    // simple email validation with regex
    if (!/^\S+@\S+$/.test(email))
        return 'Email is invalid.';
    
    if (phone === null || phone.length <= 0)
        return 'Phone number cannot be empty.';
    
    if (phone.length < 8)
        return 'Phone number must be at least 8 numbers.';
    
    return null;
};

const togglePersonalForm = (value) => {
    $('#firstName').prop('disabled', !value);
    $('#lastName').prop('disabled', !value);
    $('#gender').prop('disabled', !value);
    $('#nationality').prop('disabled', !value);
    $('#dob').prop('disabled', !value);
};

const toggleCompanyForm = (value) => {
    $('#companyName').prop('disabled', !value);
    $('#website').prop('disabled', !value);
    $('#city').prop('disabled', !value);
    $('#size').prop('disabled', !value);
};


const handleDetailsCheckboxes = () => {
    // enable personal/company details forms
    // based on checkboxes
//    console.log("checking boxes");
    let personalFormChecked = $('#personalDetailsCheck')
                                    .prop('checked');
    togglePersonalForm(personalFormChecked);
    
    let companyFormChecked = $('#companyDetailsCheck')
                                    .prop('checked');
    toggleCompanyForm(companyFormChecked);
};

const validateDetails = () => {
    let personalChecked = $('#personalDetailsCheck').prop('checked');
    let companyChecked = $('#companyDetailsCheck').prop('checked');
    let bothUnchecked = ! (personalChecked || companyChecked);
    
    if (bothUnchecked) {
        return 'At least one form must be filled.';
    }
    
    if (personalChecked) {
        let personalFormMessage = validatePersonalDetails();

        if (personalFormMessage !== null) {
            return personalFormMessage;
        }
    }
    
    if (companyChecked) {
        let companyFormMessage = validateCompanyDetails();

        if (companyFormMessage !== null) {
            return companyFormMessage;
        }
    }
    
    return null;
};

const validatePersonalDetails = () => {
    let firstName = $('#firstName').val();
    let lastName = $('#lastName').val();
    let gender = $('#gender').val();
    let nationality = $('#nationality').val();
    let dob = $('#dob').val();
    
    if (firstName === null || firstName.length <= 0)
        return 'First name cannot be empty.';
    
    if (lastName === null || lastName.length <= 0)
        return 'Last name cannot be empty.';
    
    if (gender === null || gender.length <= 0)
        return 'Gender cannot be empty.';
    
    if (gender === 'Gender')
        return 'Gender cannot be empty.';
    
    if (nationality === null || nationality.length <= 0)
        return 'Nationality cannot be empty.';
    
    if (dob === null || dob.length <= 0)
        return 'Date of Birth cannot be empty.';
    
    return null;
};

const validateCompanyDetails = () => {
    let companyName = $('#companyName').val();
//    let website = $('#website').val();
    let city = $('#city').val();
    let size = $('#size').val();
    
    if (companyName === null || companyName.length <= 0)
        return 'Company name cannot be empty.';
    
    if (city === null || city.length <= 0)
        return 'City cannot be empty.';
    
    if (size === null || size.length <= 0)
        return 'Company size cannot be empty.';
    
    return null;
};

const getUserData = () => {
    let personalChecked = $('#personalDetailsCheck').prop('checked');
    let companyChecked = $('#companyDetailsCheck').prop('checked');
    let data = { submitted: true };
    
    // add account information
    data['username'] = $('#username').val();
    data['password'] = $('#password').val();
    data['email'] = $('#email').val();
    data['phone'] = $('#phoneNumber').val();
    
    // add personal details if they are selected
    if (personalChecked) {
        data['firstName'] = $('#firstName').val();
        data['lastName'] = $('#lastName').val();
        data['gender'] = $('#gender').val();
        data['nationality'] = $('#nationality').val();
        data['dob'] = $('#dob').val();
    }
    // add company details if they are selected
    if (companyChecked) {
        data['companyName'] = $('#companyName').val();
        data['website'] = $('#website').val();
        data['city'] = $('#city').val();
        data['size'] = $('#size').val();
    }
    
    return data;
};

const registerUser = () => {
    let errorMessage = validateDetails();
    if (errorMessage !== null) {
        displayError(errorMessage);
        return;
    }
    
    let data = getUserData();
    console.log(data);
    // send registration request to server
    $.ajax({
        type: 'POST',
        url: 'register.php',
        data: data
    }).then(function(res) {
        if (res > 0) {
            console.log('user registered successfully');
        } else {
            displayError(res);
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

//      Pagination code
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
// button event listeners
$('#nextBtn').on("click", function() {
//    console.log("Clicked next");
    let message = validateAccount();
    if (message !== null) {
        displayError(message);
        return;
    }
    handleDetailsCheckboxes();
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

// checkbox event listeners
$('#personalDetailsCheck')
        .change(handleDetailsCheckboxes);

$('#companyDetailsCheck')
        .change(handleDetailsCheckboxes);