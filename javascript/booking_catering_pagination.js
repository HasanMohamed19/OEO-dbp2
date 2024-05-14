
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
const getMenuId = (name) => {
    if (name === "breakfast" || name === "Breakfast") {
        return 1;
    } else if (name === "lunch" || name === "Lunch") {
        return 2;
    } else if (name === "hot" || name === "Hot Beverages") {
        return 3;
    } else if (name === "cold" || name === "Cold Beverages") {
        return 4;
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
//        resetMenuItems(menuName);
        $.each(data, function(index, obj) {
            addMenuItem(obj.item_id, obj.service_id, obj.name, obj.price, obj.image_path);
            if (isItemAlreadySelected(obj.item_id)) {
                console.log("about to set quantity for "+obj.item_id);
                setItemInput(obj.item_id, menuName);
            }
            menuCount += 1;
        });
//        console.log('checking items for menu '+menuId+' : ' + menuName + ', there are '+menuCount+' items.');
        if (menuCount <= 0) {
            // used to display if no items are found
            toggleMenu(menuName);
        }
        handleCateringCheckboxes(menuName);
//        setCateringSelection();
        console.log(selectedMenuItems);
    });
};

const getServiceIdFromName = (serviceName) => {
    if (serviceName === "breakfast") {return 1;}
    else if (serviceName === "lunch") {return 2;}
    else if (serviceName === "hot") {return 3;}
    else if (serviceName === "cold") {return 4;}
};

const enableCateringMenuTabs = () => {
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
