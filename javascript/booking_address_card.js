
//      Clear Billing Form
const clearBillingForm = () => {
    // get and clear inputs
    $('#billingForm input').val("");
};
//      Clear Card Form
const clearCardForm = () => {
    // get and clear inputs
    $('#cardForm input').val("");
    $('#cardForm select').prop('selectedIndex',0);
};

//      Update address and card dropdowns

const fillForm = (type,id) => {
    const inputElementName = type === 'Address' ? '#paymentBilling' : '#paymentCard';
    $.ajax({
        type: 'GET',
        url: 'ajaxQueries/get'+type+'.php',
        datatype: 'json',
        data: {
            id:id
        }
    }).then(function(res) {
        let data = JSON.parse(res);
        if (!data) return;
        for (let key in data) {
            if (data.hasOwnProperty(key)) {
                $(inputElementName+key).val(data[key]);
//                console.log('Setting '+(inputElementName+key)+' with value '+data[key]);
            }
        }
    });
};
//const fillAddressForm = (addressId) => {
//    $.ajax({
//        type: 'GET',
//        url: 'ajaxQueries/getAddress.php',
//        datatype: 'json',
//        data: {
//            addressId:addressId
//        }
//    }).then(function(res) {
//        let data = JSON.parse(res);
//        if (!data) return;
//        $('#paymentBillingBuilding').val(data.building);
//        $('#paymentBillingStreet').val(data.street);
//        $('#paymentBillingBlock').val(data.block);
//        $('#paymentBillingArea').val(data.city);
//        $('#paymentBillingCountry').val(data.country);
//        $('#paymentBillingPhone').val(data.phone);
//    });
//};

const getOptionElementForDropdown = (type, obj) => {
    // returns option element to be used in dropdown for either Address or Card
    return type === 'Address' ? 
        `<option value="${obj.address_id}">${obj.phone_number}, ${obj.city}</option>`
        :
        `<option value="${obj.card_id}">**** **** **** ${obj.card_number.substring(obj.card_number.length-4)}, ${obj.cardholder_name.split(' ')[0]}</option>`;
};

const updateCardExpiryYearDropdown = () => {
    // updates expiry year dropdown to the current year + next 10 years.
    let currentYear = new Date().getFullYear();
    for (i = currentYear; i <= currentYear+10; i++) {
        $('#paymentCardExpiryYear').append(
                `<option value="${i}">${i}</option>`);
    }
};

const updateDropdown = (type, selectId = -1) => {
    const inputElementName = type === 'Address' ? '#paymentBillingSelection' : '#paymentCardSelection';
    const phpURLName = type === 'Address' ? 'getAddresses.php' : 'getCards.php';
    $.ajax({
        type: 'GET',
        url: 'ajaxQueries/'+phpURLName,
        datatype: 'json',
        data: {
            clientId:clientId
        }
    }).then(function(res) {
        let data = JSON.parse(res);
        $(inputElementName).html("<option selected>Choose Saved "+type+"</option>");
        $.each(data, function(index, obj) {
            $(inputElementName).append(getOptionElementForDropdown(type, obj));
        });
        // selectId is used to automatically select an option after loading
        if (selectId > 0) {
            $(inputElementName).val(selectId);
        }
    });
};
//const updateAddressDropdown = (selectId = -1) => {
//    $.ajax({
//        type: 'GET',
//        url: 'ajaxQueries/getAddresses.php',
//        datatype: 'json',
//        data: {
//            clientId:clientId
//        }
//    }).then(function(res) {
//        let data = JSON.parse(res);
//        $('#paymentBillingSelection').html("<option selected>Choose Saved Address</option>");
//        $.each(data, function(index, obj) {
//            $('#paymentBillingSelection').append(
//                    `<option value="${obj.address_id}">${obj.phone_number}, ${obj.city}</option>`
//                );
//        });
//        // selectId is used to automatically select an option after loading
//        if (selectId > 0) {
//            $('#paymentBillingSelection').val(selectId);
//        }
//    });
//};

//      Save address and card details on button click

const saveAddress = () => {
    let building = $('#paymentBillingBuilding').val();
    let street = $('#paymentBillingStreet').val();
    let block = $('#paymentBillingBlock').val();
    let area = $('#paymentBillingArea').val();
    let country = $('#paymentBillingCountry').val();
    let phone = $('#paymentBillingPhone').val();
    
//    console.log(`Adding Address: ${clientId} ${building} ${street} ${block} ${area} ${country} ${phone}`);
    
    $.ajax({
        type: 'POST',
        url: 'ajaxQueries/saveAddress.php',
        data: {
            clientId:clientId,
            building:building,
            street:street,
            block:block,
            area:area,
            country:country,
            phone:phone
        }
    }).then(function(res) {
        if (res > 0) {
            updateDropdown('Address', res);
//            console.log("Address insert success! ID: " + res);
        } else {
            // address could not be saved, handle error
            console.log("Address insert failed.");
        }
    });
};
const saveCard = () => {
    let cardNumber = $('#paymentCardNumber').val();
    let cardholderName = $('#paymentCardholderName').val();
    let expiryYear = $('#paymentCardExpiryYear').val();
    let expiryMonth = $('#paymentCardExpiryMonth').val();
    let cvv = $('#paymentCardCVV').val();
       
    $.ajax({
        type: 'POST',
        url: 'ajaxQueries/saveCard.php',
        data: {
            cardNumber:cardNumber,
            cardholderName:cardholderName,
            expiryYear:expiryYear,
            expiryMonth:expiryMonth,
            cvv:cvv,
            clientId:clientId
        }
    }).then(function(res) {
        if (res > 0) {
            updateDropdown('Card', res);
//            console.log("Card insert success! ID: " + res);
        } else {
            // address could not be saved, handle error
            console.log("Card insert failed.");
        }
    });
};
