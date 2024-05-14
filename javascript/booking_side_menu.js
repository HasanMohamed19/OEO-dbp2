

//   Update values for side menu

const updateSideMenu = () => {
    const updateHallDetails = (name, description, charge, capacity) => {
        $('#sideMenu-hallName').html(name);
        $('#sideMenu-hallDescription').html(description);
        $('#sideMenu-rentalCharge').html(charge + " BHD/hr");
        $('#sideMenu-capacity').html(capacity);
    };
    const updateEventDetails = (name, startDate, endDate, noAudiences) => {
        $('#sideMenu-eventName').html(name);
        $('#sideMenu-startDate').html(startDate);
        $('#sideMenu-endDate').html(endDate);
        $('#sideMenu-noAudiences').html(noAudiences);
    };
    const updateCateringDetails = (selectedMenus, cost) => {
        $('#sideMenu-selectedMenus').html(selectedMenus);
        $('#sideMenu-cost').html(Math.round(cost*1000)/1000+' BHD');
    };
    // get hall id from GET parameter
//    console.log("Read hallId from url is: "+hallId);
    // use ajax to acquire the hall and use it to update side menu
    $.ajax({
        type: 'GET',
        url: 'ajaxQueries/booking_getHall.php',
        datatype: 'json',
        data: {
            hallId:hallId
        }
    }).then(function(res) {
        let data = JSON.parse(res);
//        if (data.error)
        hallRentalCharge = data.rentalCharge;
        hallCapacity = data.capacity;
        updateHallDetails(
                data.hallName,
                data.hallDescription,
                data.rentalCharge,
                data.capacity
            );
    });
    updateEventDetails(
            $('#bookingEventName').val(),
            $('#bookingStartDate').val(),
            $('#bookingEndDate').val(),
            $('#bookingNoAudiences').val()
        );
    
    getMenuItemSelections(); // this updates selectedMenuItems
    if (selectedMenuItems === null || selectedMenuItems.length <= 0) return;
    let menuNamesArray = getCateringSelectedMenus(selectedMenuItems);
    let menuNamesRenamedArray = [];
    if (menuNamesArray['breakfast'] > 0) menuNamesRenamedArray.push("Breakfast");
    if (menuNamesArray['lunch'] > 0) menuNamesRenamedArray.push("Lunch");
    if (menuNamesArray['hot'] > 0) menuNamesRenamedArray.push("Hot Beverages");
    if (menuNamesArray['cold'] > 0) menuNamesRenamedArray.push("Cold Beverages");
    
    let menuNames = Array.isArray(menuNamesRenamedArray) && menuNamesRenamedArray.length !== 0 
        ? menuNamesRenamedArray.join(', ') : 'None';
    
    let cost = calculateCateringCost(selectedMenuItems);
    
    updateCateringDetails(menuNames, cost);
};



