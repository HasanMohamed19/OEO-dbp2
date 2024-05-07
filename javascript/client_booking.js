$(document).ready(function() {
    updateSideMenu();
    updateCateringMenus();
});
window.addEventListener("load", () => {
    // load pages for first menu
   enablePagination("breakfast", ".cateringItem");
    handleCateringCheckboxes("breakfast");
});
// enable catering menu tabs
const triggerTabList = document.querySelectorAll('#cateringTabBar button');
triggerTabList.forEach(triggerEl => {
  const tabTrigger = new bootstrap.Tab(triggerEl);

  triggerEl.addEventListener('click', event => {
//      console.log("CLICKED ON TABBB");
    event.preventDefault();
    const menuType = triggerEl.id.split("-",1)[0];
    enablePagination(menuType, ".cateringItem");
    handleCateringCheckboxes(menuType);
    tabTrigger.show();
  });
});

//      Catering Item Quantity and Checkbox 
// disable quantity box based on checkbox for all menu items
const handleCateringCheckboxes = (menuType) => {
    const paginationList = document.getElementById("pagination-items-"+menuType);
    
    const SetQuantityActive = (index, state) => {
        const quantityElement = paginationList.querySelector("#catering-item-"+menuType+"-"+index+"-quantity");
        quantityElement.disabled = state;
    };
    
    // add event listeners to checkboxes
    paginationList.querySelectorAll(".cateringItemCheck").forEach(checkbox => {
        checkbox.addEventListener('click', () => {
            const index = checkbox.id.split("-", 4)[3];
            const state = checkbox.checked;
            SetQuantityActive(index, !state);
        });
    });
    
};

//      Clear Billing Form
const clearBillingForm = () => {
    // get and clear inputs
    const billingForm = document.getElementById("billingForm");
    billingForm.querySelectorAll("input").forEach(field => {
        field.value = "";
    });
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


//   Update valuse for side menu

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

const updateCateringMenus = () => {
    
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
    
    const addMenuItem = (index, menuId, itemName, itemPrice, itemImagePath) => {
        let menuName = getMenuName(parseInt(menuId));
        $('#pagination-items-'+menuName).append(
                `
        <div id="catering-item-${menuName}-${index}" class="card p-0 cateringItem">
            <img class="card-img-top img-fluid" src="${itemImagePath}">
            <div class="card-body">
                <h3 class="card-title text-center fs-5">${itemName}</h3>
                <p class="card-text text-center"><strong>${itemPrice} BHD</strong></p>
                <div class="row">
                    <div class="col-2 offset-1">
                        <input id="catering-item-${menuName}-${index}-check" class="cateringItemCheck" type="checkbox">
                    </div>
                    <div class="col-8">
                        <input id="catering-item-${menuName}-${index}-quantity" class="form-control cateringItemQuantity" type="number" placeholder="Quantity" disabled>
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
    
    console.log("about to send ajax request");
    $.ajax({
        type: 'GET',
        url: 'ajaxQueries/booking_getMenuItems.php',
        datatype: 'json'
    }).then(function(res) {
        let data = JSON.parse(res);
        let menuCounts = [0,0,0,0];
        $.each(data, function(index, obj) {
            addMenuItem(index, obj.service_id, obj.name, obj.price, obj.image_path);
            menuCounts[parseInt(obj.service_id)-1] += 1;
        });
        $.each(menuCounts, function(index, value) {
            let menuName = getMenuName(parseInt(index)+1);
            console.log('checking items for menu '+index+' : ' + menuName + ', there are '+value+' items.');
            if (value <= 0) {
                // used to display if no items are found
                toggleMenu(menuName);
            } 
        });
    });
};