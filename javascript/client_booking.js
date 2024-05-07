
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
