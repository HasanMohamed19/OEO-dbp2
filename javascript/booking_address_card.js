
//      Clear Billing Form
const clearBillingForm = () => {
    // get and clear inputs
    $('#billingForm input').val("");
};
//      Clear Card Form
const clearCardForm = () => {
    // get and clear inputs
    $('#cardForm input').val("");
    $('#cardForm select').prop('selectedIndex', 0);
};

//      Update address and card dropdowns

// the following functions use the 'type' parameter to select either the 
// address or the card, in order to make them reusable

const fillForm = (type, id) => {
    const inputElementName = type === 'Address' ? '#paymentBilling' : '#paymentCard';
    $.ajax({
        type: 'GET',
        url: 'ajaxQueries/get' + type + '.php',
        datatype: 'json',
        data: {
            id: id
        }
    }).then(function (res) {
        let data = JSON.parse(res);
        if (!data)
            return;
        for (let key in data) {
            if (data.hasOwnProperty(key)) {
                $(inputElementName + key).val(data[key]);
//                console.log('Setting '+(inputElementName+key)+' with value '+data[key]);
            }
        }
    });
};

const getOptionElementForDropdown = (type, obj) => {
    // returns option element to be used in dropdown for either Address or Card
    return type === 'Address' ?
            `<option value="${obj.address_id}">${obj.phone_number}, ${obj.city}</option>`
            :
            `<option value="${obj.card_id}">**** **** **** ${obj.card_number.substring(obj.card_number.length - 4)}, ${obj.cardholder_name.split(' ')[0]}</option>`;
};

const updateCardExpiryYearDropdown = () => {
    // updates expiry year dropdown to the current year + next 10 years.
    let currentYear = new Date().getFullYear();
    for (i = currentYear; i <= currentYear + 10; i++) {
        $('#paymentCardExpiryYear').append(
                `<option value="${i}">${i}</option>`);
    }
};

const updateDropdown = (type, selectId = - 1) => {
    // fills dropdown options
    const inputElementName = type === 'Address' ? '#paymentBillingSelection' : '#paymentCardSelection';
    const phpURLName = type === 'Address' ? 'getAddresses.php' : 'getCards.php';
    $.ajax({
        type: 'GET',
        url: 'ajaxQueries/' + phpURLName,
        datatype: 'json',
        data: {
            clientId: clientId
        }
    }).then(function (res) {
        let data = JSON.parse(res);
        $(inputElementName).html("<option selected>Choose Saved " + type + "</option>");
        $.each(data, function (index, obj) {
            $(inputElementName).append(getOptionElementForDropdown(type, obj));
        });
        // selectId is used to automatically select an option after loading
        if (selectId > 0) {
            $(inputElementName).val(selectId);
        }
    });
};

//      Save address and card details on button click

const saveAddress = () => {
    let validation = validateAddress();
    console.log(validation);
    if (validation !== 1) {
        showInvalidAddressError(validation);
        return;
    }
    $('#bookingAddressError').addClass('invisible');

    let building = $('#paymentBillingBuilding').val();
    let street = $('#paymentBillingStreet').val();
    let block = $('#paymentBillingBlock').val();
    let area = $('#paymentBillingArea').val();
    let country = $('#paymentBillingCountry').val();
    let phone = $('#paymentBillingPhone').val();

//    console.log(`Adding Address: ${clientId} ${building} ${street} ${block} ${area} ${country} ${phone}`);

    $(function () {
        $.ajax({
            url: './helpers/get_address_count.php',
            method: 'GET',
            data: {clientId: getCookie('clientId')},
            dataType: 'text', // Expected data type from server
            success: function (response) {
                // Handle successful response
                console.log('address Info:', response);

                // if there is 4 cards don't allow them to add more cards
                if (response < 4) {

                    $.ajax({
                        type: 'POST',
                        url: 'ajaxQueries/saveAddress.php',
                        data: {
                            clientId: clientId,
                            building: building,
                            street: street,
                            block: block,
                            area: area,
                            country: country,
                            phone: phone
                        }
                    }).then(function (res) {
                        if (res > 0) {
                            updateDropdown('Address', res);
//            console.log("Address insert success! ID: " + res);
                        } else {
                            // address could not be saved, handle error
                            showInvalidAddressError("Address could not be saved.");
                        }
                    });

                }  else {
                    // address could not be saved, handle error
                    showInvalidAddressError("Maximum address limit reached (4).");
                }

            },
            error: function (xhr, status, error) {
                // Handle errors
                showInvalidAddressError("Address could not be saved.");
            }
        });
    });


};
const saveCard = () => {
    let validation = validateCard();
    console.log(validation);
    if (validation !== 1) {
        showInvalidCardError(validation);
        return;
    }
    $('#bookingCardError').addClass('invisible');

    let cardNumber = $('#paymentCardNumber').val();
    let cardholderName = $('#paymentCardholderName').val();
    let expiryYear = $('#paymentCardExpiryYear').val();
    let expiryMonth = $('#paymentCardExpiryMonth').val();
    let cvv = $('#paymentCardCVV').val();

    $(function () {
        $.ajax({
            url: './helpers/get_card_count.php',
            method: 'GET',
            data: {clientId: getCookie('clientId')},
            dataType: 'text', // Expected data type from server
            success: function (response) {
                // Handle successful response
                console.log('cardCount Info:', response);

                // if there is 4 cards don't allow them to add more cards
                if (response < 4) {
                    $.ajax({
                        type: 'POST',
                        url: 'ajaxQueries/saveCard.php',
                        data: {
                            cardNumber: cardNumber,
                            cardholderName: cardholderName,
                            expiryYear: expiryYear,
                            expiryMonth: expiryMonth,
                            cvv: cvv,
                            clientId: clientId
                        }
                    }).then(function (res) {
                        if (res > 0) {
                            updateDropdown('Card', res);
                        } else {
                            showInvalidCardError("Card could not be saved.");
                        }
                    });
                } else {
                    // address could not be saved, handle error
                    showInvalidCardError("Maximum card limit reached (4).");
                }

            },
            error: function (xhr, status, error) {
                // Handle errors
                showInvalidCardError("Card could not be saved.");
            }
        });
    });


};

const validateAddressAndCard = () => {
    let validation = validateAddress();
    if (validation !== 1) {
        showInvalidAddressError(validation);
        return false;
    }
    $('#bookingAddressError').addClass('invisible');

    validation = validateCard();
    if (validation !== 1) {
        showInvalidCardError(validation);
        return false;
    }
    $('#bookingCardError').addClass('invisible');
    return true;
};

const validateAddress = () => {
    let building = $('#paymentBillingBuilding').val();
    let street = $('#paymentBillingStreet').val();
    let block = $('#paymentBillingBlock').val();
    let area = $('#paymentBillingArea').val();
    let country = $('#paymentBillingCountry').val();
    let phone = $('#paymentBillingPhone').val();

    if (building === null || building.length === 0)
        return 'Building number cannot be empty.';
    if (street === null || street.length === 0)
        return 'Street number cannot be empty.';
    if (block === null || block.length === 0)
        return 'Block number cannot be empty.';
    if (area === null || area.length === 0)
        return 'Area cannot be empty.';
    if (country === null || country.length === 0)
        return 'Country cannot be empty.';
    if (country.length <= 3)
        return 'Country must be at least 4 characters.';
    if (phone === null || phone.length === 0)
        return 'Phone number cannot be empty.';
    if (phone.length < 8)
        return 'Phone number must be at least 8 digits.';

    return 1;
};
const validateCard = () => {
    let cardNumber = $('#paymentCardNumber').val();
    let cardholderName = $('#paymentCardholderName').val();
    let expiryYear = $('#paymentCardExpiryYear').val();
    let expiryMonth = $('#paymentCardExpiryMonth').val();
    let cvv = $('#paymentCardCVV').val();
    var numberOnlyRegex = /^[0-9]+(\.[0-9]+)?$/;

    if (cardNumber === null || cardNumber.length === 0)
        return 'Card number cannot be empty.';
    if (cardNumber.length !== 16)
        return 'Card number must be 16 digits.';
    if (!numberOnlyRegex.test(cardNumber))
        return 'Card number cannot contain letters.';
    if (cardholderName === null || cardholderName.length === 0)
        return 'Cardholder name cannot be empty.';
    if (expiryYear === null || expiryYear.length === 0 || expiryYear === 'Year')
        return 'Expiry year cannot be empty.';
    if (expiryMonth === null || expiryMonth.length === 0 || expiryMonth === 'Month')
        return 'Expiry month cannot be empty.';
    if (cvv === null || cvv.length === 0)
        return 'CVV cannot be empty.';
    if (cvv.length !== 3)
        return 'CVV must be 3 digits.';

    return 1;
};

const showInvalidAddressError = (message) => {
    $('#bookingAddressError').html(message);
    $('#bookingAddressError').removeClass('invisible');
};
const showInvalidCardError = (message) => {
    $('#bookingCardError').html(message);
    $('#bookingCardError').removeClass('invisible');
};