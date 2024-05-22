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
//    console.log(data);
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
