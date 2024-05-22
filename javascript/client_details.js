
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

const displayError = (message) => {
    $('#errorBox').html(message);
    $('#errorBox').removeClass('d-none');
};

const hideError = () => {
    $('#errorBox').addClass('d-none');
};

const displaySuccess = (message) => {
    $('#successBox').html(message);
    $('#successBox').removeClass('d-none');
};

const hideSuccess = () => {
    $('#successBox').addClass('d-none');
};



const getClientData = () => {
    // gets ids from hidden input
    let personalId = $('#personalIdInput').val();
    let companyId = $('#companyIdInput').val();
    let clientId = $('#clientIdInput').val();
    let personalChecked = $('#personalDetailsCheck').prop('checked');
    let companyChecked = $('#companyDetailsCheck').prop('checked');
    let data = { 
        submitted: true,
        clientId:clientId
    };
    
    // add personal details if they are selected
    if (personalChecked) {
        data['personalId'] = personalId;
        data['firstName'] = $('#firstName').val();
        data['lastName'] = $('#lastName').val();
        data['gender'] = $('#gender').val();
        data['nationality'] = $('#nationality').val();
        data['dob'] = $('#dob').val();
    }
    // add company details if they are selected
    if (companyChecked) {
        data['companyId'] = companyId;
        data['companyName'] = $('#companyName').val();
        data['website'] = $('#website').val();
        data['city'] = $('#city').val();
        data['size'] = $('#size').val();
    }
    
    return data;
};

const setCompanyId = (companyId) => {
    $('#companyIdInput').val(companyId);
};
const setPersonalId = (personalId) => {
    $('#personalIdInput').val(personalId);
};

const updateClientDetails = () => {
    hideError();
    hideSuccess();
    let errorMessage = validateDetails();
    if (errorMessage !== null) {
        displayError(errorMessage);
        return;
    }
    
    let data = getClientData();
    // send registration request to server
    $.ajax({
        type: 'POST',
        url: 'ajaxQueries/updateClientDetails.php',
        datatype: 'json',
        data: data
    }).then(function(res) {
        let data = JSON.parse(res);
        if (!data.error) {
            console.log('updated client');
            if (data.companyId > 0) {
                setCompanyId(data.companyId);
            } else if (data.companyId === -1) {
                setCompanyId('');
            }
            if (data.personalId > 0) {
                setPersonalId(data.personalId);
            } else if (data.personalId === -1) {
                setPersonalId('');
            }
            displaySuccess("Details have been saved successfully.");
        } else {
            displayError(data.error);
        }
    });
    
};

// checkbox event listeners
$('#personalDetailsCheck')
        .change(handleDetailsCheckboxes);

$('#companyDetailsCheck')
        .change(handleDetailsCheckboxes);