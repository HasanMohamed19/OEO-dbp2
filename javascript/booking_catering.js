
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
            const id = checkbox.id.split("-", 4)[3];
            const state = checkbox.checked;
            SetQuantityActive(id, !state);
            if (!state) {
                removeMenuItem(id);
            }
        });
    });
//    paginationList.querySelectorAll(".cateringItemQuantity").forEach(element => {
//        element.addEventListener('blur', () => {
////            console.log('clicked quantity');
//            const id = element.id.split("-", 4)[3];
//            const state = element.disabled;
//            if (state) return;
//            
//        });
//    });
    
};

const getCateringSelectedMenus = (menuItems) => {
    let menus = {
        'breakfast':0,
        'lunch':0,
        'hot':0,
        'cold':0
    };
    $.each(menuItems, function(index, obj) {
//        console.log(obj.service_id);
        let menu = getMenuName(parseInt(obj.service_id));
        if (menus.hasOwnProperty(menu)) {
            menus[menu] += 1;
        }
    });
//    console.log(menus);
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
    // check if they are already in the array and update
    // quantity if they are
    $('.cateringItemQuantity').each(function(index) {
        if ($(this).prop('disabled')) return;
        let quantity = $(this).val();
        if (quantity <= 0) return;
        let elementId = $(this).attr('id');
        let menuName = elementId.split('-')[2];
        let serviceId = getMenuId(menuName)+"";
        let menuItemId = elementId.split('-')[3];
        if (isItemAlreadySelected(menuItemId)) {
            setItemQuantity(menuItemId, quantity);
            return;
        }
        // read price from html element
        let price = parseFloat($('#catering-item-'+menuName+'-'+menuItemId+' strong')
                .html()
                .split(' ')[0]);
//        console.log(`getting item, Price: ${price}`);
        let menuItem = {
            reservation_menu_item_id:null,
            item_id:menuItemId,
            service_id:serviceId,
            quantity:quantity,
            price:price
        };
        selectedMenuItems.push(menuItem);
    });
};

//const setCateringSelection = () => {
//    $.each(selectedMenuItems, function(index, item) {
//        let itemId = item['item_id'];
//        let quantity = item['quantity'];
//        let serviceId = item['service_id'];
//        let menuName = getMenuName(parseInt(serviceId));
//        $('#catering-item-'+menuName+'-'+itemId+'-check').prop('checked', true);
//        $('#catering-item-'+menuName+'-'+itemId+'-quantity').prop('disabled', false);
//        $('#catering-item-'+menuName+'-'+itemId+'-quantity').val(quantity);
//    });
//};

// check if this item is already in the selectedMenuItems list
const isItemAlreadySelected = (item_id) => {
    if (selectedMenuItems === null) return;
    for (let i = 0; i < selectedMenuItems.length;i++) {
//        console.log("Checking: "+item_id+" === "+selectedMenuItems[i]['item_id']);
        if (item_id === selectedMenuItems[i]['item_id']) {
//            console.log("YES");
            return true;
        }
    }
    return false;
};
const getItemAlreadySelected = (item_id) => {
    if (selectedMenuItems === null) return;
    for (let i = 0; i < selectedMenuItems.length;i++) {
        if (item_id === selectedMenuItems[i]['item_id']) {
            return selectedMenuItems[i];
        }
    }
    return false;
};

const setItemQuantity = (item_id, quantity) => {
    if (selectedMenuItems === null) return;
    for (let i = 0; i < selectedMenuItems.length;i++) {
        if (item_id === selectedMenuItems[i]['item_id']) {
            selectedMenuItems[i]['quantity'] = quantity;
            return;
        }
    }
};

const removeMenuItem = (item_id) => {
    if (selectedMenuItems === null) return;
    for (let i = 0; i < selectedMenuItems.length;i++) {
        if (item_id === selectedMenuItems[i]['item_id']) {
            selectedMenuItems.splice(i,1);
            return;
        }
    }
};

const setItemInput = (item_id, menuName) => {
    let item = getItemAlreadySelected(item_id);
    if (item === false) return;
    let quantity = item['quantity'];
    $('#catering-item-'+menuName+'-'+item_id+'-check').prop('checked', true);
    $('#catering-item-'+menuName+'-'+item_id+'-quantity').prop('disabled', false);
    $('#catering-item-'+menuName+'-'+item_id+'-quantity').val(quantity);
//    console.log("set '#catering-item-"+menuName+"-"+item_id+"-quantity' to "+quantity);
};