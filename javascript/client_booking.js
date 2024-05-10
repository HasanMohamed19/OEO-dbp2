const cateringItemDisplayCount = 10;

$(document).ready(function() {
    updateSideMenu();
    // load pages for first menu
   enablePagination(1, ".cateringItem", cateringItemDisplayCount);
    updateAddressDropdown();
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
        console.log('handling checkboxes');
    const paginationList = document.getElementById("pagination-items-"+menuType);
    
    const SetQuantityActive = (index, state) => {
        const quantityElement = paginationList.querySelector("#catering-item-"+menuType+"-"+index+"-quantity");
        quantityElement.disabled = state;
        console.log('Set quantity state');
    };
    
    // add event listeners to checkboxes
    paginationList.querySelectorAll(".cateringItemCheck").forEach(checkbox => {
        checkbox.addEventListener('click', () => {
            console.log('clicked checkbox');
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
            cards[currentSection].classList.add("inactive");
        }
        
        sections[currentSection = i].classList.add("active");
        sectionButtons[currentSection].classList.add("active");
        if (currentSection < cards.length) {
            cards[currentSection].classList.remove("inactive");
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
    window.location.href = "booking_summary.php";
});


//   Update values for side menu

const updateSideMenu = () => {
    const updateHallDetails = (name, description, type, charge, capacity) => {
        $('#sideMenu-hallName').html(name);
        $('#sideMenu-hallDescription').html(description);
        $('#sideMenu-hallType').html(type);
        $('#sideMenu-rentalCharge').html(charge);
        $('#sideMenu-capacity').html(capacity);
    };
    const updateEventDetails = (name, startDate, endDate, noAudiences) => {
        $('#sideMenu-eventName').html(name);
        $('#sideMenu-startDate').html(startDate);
        $('#sideMenu-endDate').html(endDate);
        $('#sideMenu-noAudiences').html(noAudiences);
    };
    
    // use ajax to acquire the hall and use it to update side menu
    $.ajax({
        type: 'GET',
        url: 'ajaxQueries/booking_getHall.php',
        datatype: 'json'
    }).then(function(res) {
        let data = JSON.parse(res);
//        if (data.error)
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
        console.log($('#pagination-none-'+menuName).attr("class").split(/\s+/));
        $('#pagination-items-'+menuName).toggleClass("hidden");
        $('#pagination-items-'+menuName).toggleClass("d-flex");
        $('#'+menuName+'-tab-pane nav').toggleClass("hidden");
        $('#'+menuName+'-tab-pane nav').toggleClass("d-flex");
        $('#pagination-none-'+menuName).toggleClass("hidden");
    };
    
    console.log("about to send ajax request for menu items");
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
        console.log("Response for menu items: " + data);
        let menuCount = 0;
        let menuName = getMenuName(menuId);
        resetMenuItems(menuName);
        $.each(data, function(index, obj) {
            addMenuItem(obj.item_id, obj.service_id, obj.name, obj.price, obj.image_path);
            menuCount += 1;
        });
        console.log('checking items for menu '+menuId+' : ' + menuName + ', there are '+menuCount+' items.');
        if (menuCount <= 0) {
            // used to display if no items are found
            toggleMenu(menuName);
        }
        handleCateringCheckboxes(menuName);
    });
};

//      Catering Menus Pagination
const enablePagination = (menuId, dataListClass, itemCount) => {
    console.log("Enabling pagination");
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
          console.log("ITEM IS: "+$(this));
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


const fillAddressForm = (addressId) => {
    $.ajax({
        type: 'GET',
        url: 'ajaxQueries/getAddress.php',
        datatype: 'json',
        data: {
            addressId:addressId
        }
    }).then(function(res) {
        let data = JSON.parse(res);
        if (!data) return;
        $('#paymentBillingBuilding').val(data.building);
        $('#paymentBillingStreet').val(data.street);
        $('#paymentBillingBlock').val(data.block);
        $('#paymentBillingArea').val(data.city);
        $('#paymentBillingCountry').val(data.country);
        $('#paymentBillingPhone').val(data.phone);
    });
};

const updateAddressDropdown = () => {
    let _clientId = 1;
    $.ajax({
        type: 'GET',
        url: 'ajaxQueries/getAddresses.php',
        datatype: 'json',
        data: {
            clientId:_clientId
        }
    }).then(function(res) {
        let data = JSON.parse(res);
        $('#paymentBillingSelection').html("<option selected>Choose Saved Address</option>");
        $.each(data, function(index, obj) {
            $('#paymentBillingSelection').append(
                    `<option value="${obj.address_id}">${obj.phone_number}, ${obj.city}</option>`
                );
        });
    });
};

//      Save address and card details on button click

const saveAddress = () => {
    let _clientId = 1;
    let _building = $('#paymentBillingBuilding').val();
    let _street = $('#paymentBillingStreet').val();
    let _block = $('#paymentBillingBlock').val();
    let _area = $('#paymentBillingArea').val();
    let _country = $('#paymentBillingCountry').val();
    let _phone = $('#paymentBillingPhone').val();
    
//    console.log(`Adding Address: ${_clientId} ${_building} ${_street} ${_block} ${_area} ${_country} ${_phone}`);
    
    $.ajax({
        type: 'POST',
        url: 'ajaxQueries/saveAddress.php',
        data: {
            clientId:_clientId,
            building:_building,
            street:_street,
            block:_block,
            area:_area,
            country:_country,
            phone:_phone
        }
    }).then(function(res) {
        if (res > 0) {
            updateAddressDropdown();
            console.log("Address insert success!");
        } else {
            // address could not be saved, handle error
            console.log("Address insert failed.");
        }
    });
};