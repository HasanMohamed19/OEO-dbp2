const cateringItemDisplayCount = 10;
const hallId = (new URL(location.href)).searchParams.get('hallId');
const clientId = 1;
var hallRentalCharge; // will be set after side menu loads

$('#bookingForm').on('submit', function(event) {
    // post request must be made with js to allow sending
    // list of selected menu items as JSON
    event.preventDefault();
    // validate form and get menu items to send with ajax
    let eventName = $('#bookingEventName').val();
    let startDate = $('#bookingStartDate').val();
    let endDate = $('#bookingEndDate').val();
    let startTime = $('#bookingStartTime').val();
    let endTime = $('#bookingEndTime').val();
    let audience = $('#bookingNoAudiences').val();
    let notes = $('#bookingNotes').val();
    // get menu items and convert to JSON
    let items = JSON.stringify(getMenuItemSelections());
//    alert("prevented");
    // submit form
    $.ajax({
        type: 'POST',
        url:'client_booking.php',
        data: {
            submitted: true,
            bookingEventName:eventName,
            bookingStartDate:startDate,
            bookingEndDate:endDate,
            bookingStartTime:startTime,
            bookingEndTime:endTime,
            bookingNoAudiences:audience,
            bookingEventNotes:notes,
            bookingHallId:hallId,
            bookingClientId:clientId,
            menuItems:items
        }
    }); // form will redirect to next page in php
});

$(document).ready(function() {
    updateSideMenu();
    // load pages for first menu
    enablePagination(1, ".cateringItem", cateringItemDisplayCount);
    updateDropdown('Address');
    updateDropdown('Card');
    updateCardExpiryYearDropdown();
});


const getServiceIdFromName = (serviceName) => {
    if (serviceName === "breakfast") {return 1;}
    else if (serviceName === "lunch") {return 2;}
    else if (serviceName === "hot") {return 3;}
    else if (serviceName === "cold") {return 4;}
};

// enable catering menu tabs
const triggerTabList = document.querySelectorAll('#cateringTabBar button');
triggerTabList.forEach(triggerEl => {
  const tabTrigger = new bootstrap.Tab(triggerEl);

  triggerEl.addEventListener('click', event => {
//      console.log("CLICKED ON TABBB");
    event.preventDefault();
    const menuType = triggerEl.id.split("-",1)[0];
//    updateCateringMenu(getServiceIdFromName(menuType),1,10);
    enablePagination(getServiceIdFromName(menuType), ".cateringItem", cateringItemDisplayCount);
    tabTrigger.show();
  });
});

//      Catering Item Quantity and Checkbox 
// disable quantity box based on checkbox for all menu items
const handleCateringCheckboxes = (menuType) => {
//        console.log('handling checkboxes');
    const paginationList = document.getElementById("pagination-items-"+menuType);
    
    const SetQuantityActive = (index, state) => {
        const quantityElement = paginationList.querySelector("#catering-item-"+menuType+"-"+index+"-quantity");
        quantityElement.disabled = state;
//        console.log('Set quantity state');
    };
    
    // add event listeners to checkboxes
    paginationList.querySelectorAll(".cateringItemCheck").forEach(checkbox => {
        checkbox.addEventListener('click', () => {
//            console.log('clicked checkbox');
            const index = checkbox.id.split("-", 4)[3];
            const state = checkbox.checked;
            SetQuantityActive(index, !state);
        });
    });
    
};

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


//      Previous/Next buttons functionality
let currentSection = 0;
let sections = document.querySelectorAll("#bookingForm > fieldset");
let sectionButtons = document.querySelectorAll("#bookingProgress > li");
let cards = document.querySelectorAll(".clientBookingSidebar > .clientCard");
let nextButton = document.querySelector(".next");
let saveButton = document.querySelector(".save");
let previousButton = document.querySelector(".previous");

for (let i = 0; i < sectionButtons.length; i++) {
//    console.log("Added listener to " + sectionButtons[i]);
    sectionButtons[i].addEventListener("click", function() {
        updateSideMenu();
//        console.log("Clicked on me!!");
        sections[currentSection].classList.remove("active");
        sectionButtons[currentSection].classList.remove("active");
        // if going to previous section, make current card inactive
        if (currentSection > i && currentSection < cards.length) {
            for (j = currentSection; j>i; j--) {
                cards[j].classList.add("inactive");
            }
        }
        
        sections[currentSection = i].classList.add("active");
        sectionButtons[currentSection].classList.add("active");
        if (currentSection < cards.length) {
            for (j = 0; j<=currentSection; j++) {
                cards[j].classList.remove("inactive");
            }
        }
        
        if (i === 0) {
            if (previousButton.className.split(" ").indexOf("hide") < 0) {
                previousButton.classList.add("hide");
            }
        } else {
            if (previousButton.className.split(" ").indexOf("hide") >= 0) {
                previousButton.classList.remove("hide");
            }
        }
        if (i === sectionButtons.length - 1) {
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
    });
}


nextButton.addEventListener("click", function() {
//        console.log("Tried to click");
    if (currentSection < sectionButtons.length - 1) {
        sectionButtons[currentSection + 1].click();
    }
});

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


//   Update values for side menu

const updateSideMenu = () => {
    const updateHallDetails = (name, description, type, charge, capacity) => {
        $('#sideMenu-hallName').html(name);
        $('#sideMenu-hallDescription').html(description);
        $('#sideMenu-hallType').html(type);
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
    console.log("Read hallId from url is: "+hallId);
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
        updateHallDetails(
                data.hallName,
                data.hallDescription,
                "Type",
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
        
    let selectedMenuItems = getMenuItemSelections();
    
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


//      AJAX for catering menu items
const getMenuName = (id) => {
switch (id) {
    case 1:
        return 'breakfast';
    case 2:
        return 'lunch';
    case 3:
        return 'hot';
    case 4:
        return 'cold';
    default:
        return;
}
};
const updateCateringMenu = (menuId, pageNumber, itemCount) => {
    
    const resetMenuItems = (menuName) => {
//        console.log("Reset menu items for "+menuName);
//        $('#pagination-items-'+menuName).html("");
    };
    
    const addMenuItem = (item_id, menuId, itemName, itemPrice, itemImagePath) => {
        let menuName = getMenuName(parseInt(menuId));
        let menuItemAlreadyLoaded = $("#catering-item-"+menuName+"-"+item_id).length !== 0;
        if (menuItemAlreadyLoaded) return;
        $('#pagination-items-'+menuName).append(
                `
        <div id="catering-item-${menuName}-${item_id}" class="card p-0 cateringItem">
            <img class="card-img-top img-fluid" src="${itemImagePath}">
            <div class="card-body">
                <h3 class="card-title text-center fs-5">${itemName}</h3>
                <p class="card-text text-center"><strong>${itemPrice} BHD</strong></p>
                <div class="row">
                    <div class="col-2 offset-1">
                        <input id="catering-item-${menuName}-${item_id}-check" class="cateringItemCheck" type="checkbox">
                    </div>
                    <div class="col-8">
                        <input id="catering-item-${menuName}-${item_id}-quantity" name="catering-item-${item_id}-quantity" class="form-control cateringItemQuantity" type="number" placeholder="Quantity" disabled>
                    </div>
                </div>
            </div>
        </div>
                `
            );
    };
    
    const toggleMenu = (menuName) => {
//        console.log($('#pagination-none-'+menuName).attr("class").split(/\s+/));
        $('#pagination-items-'+menuName).toggleClass("hidden");
        $('#pagination-items-'+menuName).toggleClass("d-flex");
        $('#'+menuName+'-tab-pane nav').toggleClass("hidden");
        $('#'+menuName+'-tab-pane nav').toggleClass("d-flex");
        $('#pagination-none-'+menuName).toggleClass("hidden");
    };
    
//    console.log("about to send ajax request for menu items");
    // this will fetch menu items only for the current page
    $.ajax({
        type: 'GET',
        url: 'ajaxQueries/booking_getMenuItems.php',
        datatype: 'json',
        data: {
            serviceId:menuId,
            pageNum:pageNumber,
            count:itemCount
        }
    }).then(function(res) {
        let data = JSON.parse(res);
//        console.log("Response for menu items: " + data);
        let menuCount = 0;
        let menuName = getMenuName(menuId);
        resetMenuItems(menuName);
        $.each(data, function(index, obj) {
            addMenuItem(obj.item_id, obj.service_id, obj.name, obj.price, obj.image_path);
            menuCount += 1;
        });
//        console.log('checking items for menu '+menuId+' : ' + menuName + ', there are '+menuCount+' items.');
        if (menuCount <= 0) {
            // used to display if no items are found
            toggleMenu(menuName);
        }
        handleCateringCheckboxes(menuName);
    });
};

//      Catering Menus Pagination
const enablePagination = (menuId, dataListClass, itemCount) => {
//    console.log("Enabling pagination");
    const menuType = getMenuName(menuId);
    const paginationNumbersDivs = document.querySelectorAll(".pagination-numbers-"+menuType);
    const paginationList = document.getElementById("pagination-items-"+menuType);
    const firstButtons = document.querySelectorAll(".pagination-first-"+menuType);
    const lastButtons = document.querySelectorAll(".pagination-last-"+menuType);
    let totalItems=0;
    let pageCount=0;
    let currentPage;

    //  function declarations

    const addPageNumberEventListeners = () => {
        document.querySelectorAll(".pagination-number-button-"+menuType).forEach((button) => {
           const pageIndex = Number(button.getAttribute("page-index")); 
           if (pageIndex) {
               button.addEventListener("click", () => {
                  setCurrentPage(pageIndex); 
               });
           }
        });
    };
    
    const appendPageNumber = (index) => {
        const pageButton = document.createElement("button");
        pageButton.className = "page-link ms-2 rounded border-2 pagination-number-button-"+menuType;
        pageButton.innerHTML = index;
        pageButton.setAttribute("page-index", index);
        pageButton.setAttribute("type", "button");
        const pageNumber = document.createElement("li");
        pageNumber.className = "page-item pagination-number-"+menuType;
        pageNumber.appendChild(pageButton);
        // since there can be multiple pagination bars, add numbers to each
        // using cloneNode to create copies of each number element
        paginationNumbersDivs.forEach((div) => {
            div.appendChild(pageNumber.cloneNode(true));
        });
    };
    const setPaginationNumbers = () => {
        paginationNumbersDivs.forEach((div) => {
            div.innerHTML = "";
        });
        $.ajax({
            type: 'GET',
            url: 'ajaxQueries/booking_getMenuItemCount.php',
            datatype: 'text',
            data: {
                serviceId:menuId
            }
        }).then(function(res) {
            let num = parseInt(res);
            totalItems = num;
            pageCount = Math.ceil(totalItems/itemCount);
            for (let i = 1;i <= pageCount; i++) {
                appendPageNumber(i);
            }
            refreshPaginationBars();
            addPageNumberEventListeners();
        });
        
    };

    // will update the active page number
    const handleActivePageNumber = () => {
      document.querySelectorAll(".pagination-number-button-"+menuType).forEach((button) => {
          button.classList.remove("active");

          const pageIndex = Number(button.getAttribute("page-index")); 
           if (pageIndex === currentPage) {
               button.classList.add("active");
           }
      });  
    };

    const disableButton = (button) => {
        button.classList.add("disabled");
        button.setAttribute("disabled", true);
    };
    const enableButton = (button) => {
        button.classList.remove("disabled");
        button.removeAttribute("disabled");
    };
    // enables or disables first/last buttons based on current page
    const handlePageButtonsStatus = () => {
        if (currentPage === 1) {
            firstButtons.forEach((button) => {
                disableButton(button);
            });
        } else {
            firstButtons.forEach((button) => {
                enableButton(button);
            });
        }
        if (currentPage === pageCount) {
            lastButtons.forEach((button) => {
                disableButton(button);
            });
        } else {
            lastButtons.forEach((button) => {
                enableButton(button);
            });
        }
    };
    

    const setCurrentPage = (pageNum) => {
      currentPage = pageNum;  

      updateCateringMenu(menuId, pageNum, itemCount);
      refreshPaginationBars();
      const prevRange = (pageNum - 1) * itemCount;
      const currRange = pageNum * itemCount;
      $('#pagination-items-'+menuType+' '+dataListClass).each(function(index) {
//          console.log("ITEM IS: "+$(this));
         $(this).addClass("hidden");
         if (index >= prevRange && index < currRange) {
             $(this).removeClass("hidden");
         }
      });
    };


    const addFirstLastEventListeners = () => {
        firstButtons.forEach((button) => {
            button.addEventListener("click", () => {
               setCurrentPage(1); 
            });
        });
        
        lastButtons.forEach((button) => {
            button.addEventListener("click", () => {
               setCurrentPage(pageCount); 
            });
        });

    };

    const refreshPaginationBars = () => {
        handlePageButtonsStatus();
        handleActivePageNumber();
    };

    setPaginationNumbers();
    setCurrentPage(1);
    addFirstLastEventListeners();

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

const getCateringSelectedMenus = (menuItems) => {
    let menus = {
        'breakfast':0,
        'lunch':0,
        'hot':0,
        'cold':0
    };
    $.each(menuItems, function(index, obj) {
        console.log(obj.menu);
        if (menus.hasOwnProperty(obj.menu)) {
            menus[obj.menu] += 1;
        }
    });
    console.log(menus);
    return menus;
};

const calculateCateringCost = (menuItems) => {
    // read selected catering items and calculate price using db procedure
    let totalCost = 0.0;
    $.each(menuItems, function(index, obj) {
        totalCost += obj.price * obj.quantity;
    });
    return totalCost;
};

const getMenuItemSelections = () => {
    // loop through all quantity input elements (for catering)
    //  and add active ones to array
    let menuItems = [];
    $('.cateringItemQuantity').each(function(index) {
        if ($(this).prop('disabled')) return;
        let quantity = $(this).val();
        if (quantity <= 0) return;
        let elementId = $(this).attr('id');
        let menuName = elementId.split('-')[2];
        let menuItemId = elementId.split('-')[3];
        // read price from html element
        let price = parseFloat($('#catering-item-'+menuName+'-'+menuItemId+' strong')
                .html()
                .split(' ')[0]);
        console.log(`getting item, Price: ${price}`);
        let menuItem = {
            id:menuItemId,
            menu:menuName,
            quantity:quantity,
            price:price
        };
        menuItems.push(menuItem);
    });
    return menuItems;
};


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