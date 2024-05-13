const cateringItemDisplayCount = 10;
const hallId = (new URL(location.href)).searchParams.get('hallId');
const clientId = 1;
var hallRentalCharge; // will be set after side menu loads
var hallCapacity;

$(document).ready(function() {
    enableCateringMenuTabs();
    addPageButtonListeners();
    updateSideMenu();
    // load pages for first menu
    enablePagination(1, ".cateringItem", cateringItemDisplayCount);
    updateDropdown('Address');
    updateDropdown('Card');
    updateCardExpiryYearDropdown();
});

$('#bookingForm').on('submit', function(event) {
    // post request must be made with js to allow sending
    // list of selected menu items as JSON
    event.preventDefault();
    // validate form and get menu items to send with ajax
    let eventInput = getEventInput();
    // get menu items and convert to JSON
    let items = JSON.stringify(getMenuItemSelections());
//    alert("prevented");
    // submit form
    $.ajax({
        type: 'POST',
        url:'client_booking.php',
        data: {
            submitted: true,
            bookingEventName:eventInput['eventName'],
            bookingStartDate:eventInput['startDate'],
            bookingEndDate:eventInput['endDate'],
            bookingStartTime:eventInput['startTime'],
            bookingEndTime:eventInput['endTime'],
            bookingNoAudiences:eventInput['audience'],
            bookingEventNotes:eventInput['notes'],
            bookingHallId:hallId,
            bookingClientId:clientId,
            menuItems:items
        }
    }); // form will redirect to next page in php
});




const checkEventValidity = () => {
    
    
    let audienceNumber = parseInt($("#bookingNoAudiences").val());
    if (audienceNumber === null 
            || audienceNumber > hallCapacity 
            || audienceNumber <= 0) {
        $("#bookingNoAudiences").addClass('is-invalid');
        return false;
    }
    
    let startDate = $("#bookingStartDate").val();
    if (startDate === null) {
        $("#bookingStartDate").addClass('is-invalid');
        return false;
    }
    if (new Date(startDate).getDate() <= new Date().getDate()) {
        $("#bookingStartDate").addClass('is-invalid');
        return false;
    }
    // validate if hall is already booked at this time
    
    return true;
};

//      Previous/Next buttons functionality
const addPageButtonListeners = () => {
    let currentSection = 0;
//    let sections = document.querySelectorAll("#bookingForm > fieldset");
    let sectionButtons = document.querySelectorAll("#bookingProgress > li");
    let nextButton = document.querySelector(".next");
    let saveButton = document.querySelector(".save");
    let previousButton = document.querySelector(".previous");
    for (let i = 0; i < sectionButtons.length; i++) {
    //    console.log("Added listener to " + sectionButtons[i]);
        sectionButtons[i].addEventListener("click", function() {
            console.log('trying to change page. clicked on num: '+i+'. coming from: '+currentSection);
            // if trying to leave first page (event form)
            // send ajax request to validate input and allow 
            // user to continue or not
            if (currentSection === 0 && i !== 0) {
                let event = getEventInput();
                $.ajax({
                    type: 'POST',
                    url: 'ajaxQueries/validate_event.php',
                    data: {
                        event:JSON.stringify(event)
                    }
                }).then(function(res) {
                    console.log("result from validation: "+res);
                    if (res > 0) {
                        checkFirstPageClicked(i);
                        checkLastPageClicked(i);
                        currentSection = changePage(currentSection, i);
                    } else {
                        console.log("Event form invalid");
                    }
                });
            } else {
                checkFirstPageClicked(i);
                checkLastPageClicked(i);
                currentSection = changePage(currentSection, i);
            }
        });
    }
    nextButton.addEventListener("click", function() {
            console.log("Tried to click");
        if (currentSection < sectionButtons.length - 1) {
            sectionButtons[currentSection + 1].click();
            console.log("clicked");
        }
    });

    const checkFirstPageClicked = (nextSection) => {
        if (nextSection === 0) {
            // if clicked on first page, hide previous button
            if (previousButton.className.split(" ").indexOf("hide") < 0) {
                previousButton.classList.add("hide");
            }
        } else {
            // validate event if leaving first page
//            $("#eventFieldSet").addClass('was-validated');
//            console.log(checkEventValidity());
//            if (!checkEventValidity()) {
//                return;
//            }
            // show previous button if leaving first page
            if (previousButton.className.split(" ").indexOf("hide") >= 0) {
                previousButton.classList.remove("hide");
            }
        }
    };
    const checkLastPageClicked = (nextSection) => {
        if (nextSection === sectionButtons.length - 1) {
            console.log("setting total cost now");
            setTotalCost(); // display cost at the bottom if this is last page

            // for last page, show save button instead of next
            if (nextButton.className.split(" ").indexOf("hide") < 0) {
                nextButton.classList.add("hide");
            }
            if (saveButton.className.split(" ").indexOf("hide") >= 0) {
                saveButton.classList.remove("hide");
            }
        } else {
            if (nextButton.className.split(" ").indexOf("hide") >= 0) {
                nextButton.classList.remove("hide");
            }
            if (saveButton.className.split(" ").indexOf("hide") < 0) {
                saveButton.classList.add("hide");
            }
        }
    };
    previousButton.addEventListener("click", function() {
        if (currentSection > 0) {
            sectionButtons[currentSection - 1].click();
        }
    });

    //  add function for complete booking button
    saveButton.addEventListener("click", function() {
        // take user to summary page
    //    window.location.href = "booking_summary.php";
    });
};

const changePage = (currentSection, nextSection) => {
    let sections = document.querySelectorAll("#bookingForm > fieldset");
    let sectionButtons = document.querySelectorAll("#bookingProgress > li");
    let cards = document.querySelectorAll(".clientBookingSidebar > .clientCard");
    updateSideMenu();
    // show selected page
    sections[currentSection].classList.remove("active");
    sectionButtons[currentSection].classList.remove("active");
    // if going to previous section, make current card inactive
    if (currentSection > nextSection && currentSection < cards.length) {
        for (j = currentSection; j>nextSection; j--) {
            cards[j].classList.add("inactive");
        }
    }

    sections[currentSection = nextSection].classList.add("active");
    sectionButtons[currentSection].classList.add("active");
    if (currentSection < cards.length) {
        for (j = 0; j<=currentSection; j++) {
            cards[j].classList.remove("inactive");
        }
    }
    return currentSection;
};


const getEventInput = () => {
    let eventName = $('#bookingEventName').val();
    let startDate = $('#bookingStartDate').val();
    let endDate = $('#bookingEndDate').val();
    let startTime = $('#bookingStartTime').val();
    let endTime = $('#bookingEndTime').val();
    let audience = $('#bookingNoAudiences').val();
    let notes = $('#bookingNotes').val();
    return {
        eventName:eventName,
        startDate:startDate,
        endDate:endDate,
        startTime:startTime,
        endTime:endTime,
        audience:audience,
        notes:notes
    };
};

