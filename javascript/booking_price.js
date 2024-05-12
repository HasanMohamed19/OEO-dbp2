
const setTotalCost = () => {
    $.ajax({
        type: 'GET',
        url: 'ajaxQueries/getClientDiscount.php',
        data: {
            clientId:clientId
        }
    }).then(function(res) {
        let total = calculateTotalPrice(res);
        total = Math.round(total*1000)/1000;
        $('#paymentTotalCost').html('Total: '+total+' BHD');
    });
};

const getDaysBetween = (date1, date2) => {
    let msDelta = new Date(date2).getTime() - new Date(date1).getTime();
    let dayDelta = Math.round(msDelta / (1000 * 3600 * 24));
    return dayDelta;
};

const getHoursBetween = (time1, time2) => {
    let date1 = new Date();
    date1.setHours(parseInt(time1.split(':')[0]));
    date1.setMinutes(parseInt(time1.split(':')[1]));
    let date2 = new Date();
    date2.setHours(parseInt(time2.split(':')[0]));
    date2.setMinutes(parseInt(time2.split(':')[1]));
    
    let msDelta = Math.abs(date2.getTime() - date1.getTime());
    let hourDelta = Math.round(msDelta/(1000 * 3600));
    return hourDelta;
};

const calculateTotalPrice = (discount) => {
    if (hallRentalCharge === null) return;
    let total = 0.0;
    let rentalCharge = hallRentalCharge;
    // must add 1 because daysBetween will return 0 if both
    // dates are the same
    let rentalDurationDays = 1 + getDaysBetween(
            $('#bookingStartDate').val(), 
            $('#bookingEndDate').val()
                    );
    let rentalDurationHourDelta = getHoursBetween(
            $('#bookingStartTime').val(),
            $('#bookingEndTime').val()
                    );
    console.log("DayDifference: "+rentalDurationDays+", Hours: "+rentalDurationHourDelta);
    let rentalDurationHours = rentalDurationDays * rentalDurationHourDelta;
    
    let rentalCost = rentalCharge * rentalDurationHours;
    let cateringCost = calculateCateringCost(getMenuItemSelections());
    
    total = (rentalCost + cateringCost) * discount;
    return total;
};