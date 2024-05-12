
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
