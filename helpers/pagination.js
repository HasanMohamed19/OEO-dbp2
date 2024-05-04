//      Catering Menus Pagination
const enablePagination = (menuType) => {
    const paginationNumbersDiv = document.getElementById("pagination-numbers-"+menuType);
    const paginationList = document.getElementById("pagination-items-"+menuType);
    const listItems = paginationList.querySelectorAll(".cateringItem");
    const firstButton = document.getElementById("pagination-first-"+menuType);
    const lastButton = document.getElementById("pagination-last-"+menuType);

    const paginationLimit = 10;
    const pageCount = Math.ceil(listItems.length / paginationLimit);
    let currentPage;
    
    // if there are no items, dont do anything
    if (listItems.length === 0) {
        return;
    }
    
    //  function declarations
    
    const appendPageNumber = (index) => {
        const pageButton = document.createElement("button");
        pageButton.className = "page-link ms-2 rounded border-2 pagination-number-button-"+menuType;
        pageButton.innerHTML = index;
        pageButton.setAttribute("page-index", index);
        pageButton.setAttribute("type", "button");
        const pageNumber = document.createElement("li");
        pageNumber.className = "page-item pagination-number-"+menuType;
        pageNumber.appendChild(pageButton);
        paginationNumbersDiv.appendChild(pageNumber);
    };
    const setPaginationNumbers = () => {
        paginationNumbersDiv.innerHTML = "";
        for (let i = 1;i <= pageCount; i++) {
            appendPageNumber(i);
        }
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
    const handlePageButtonsStatus = () => {
        if (currentPage === 1) {
            disableButton(firstButton);
        } else {
            enableButton(firstButton);
        }
        if (currentPage === pageCount) {
            disableButton(lastButton);
        } else {
            enableButton(lastButton);
        }
    };
    
    const setCurrentPage = (pageNum) => {
      currentPage = pageNum;  
      
      handleActivePageNumber();
      handlePageButtonsStatus();
      
      const prevRange = (pageNum - 1) * paginationLimit;
      const currRange = pageNum * paginationLimit;
      
      listItems.forEach((item, index) => {
         item.classList.add("hidden");
         if (index >= prevRange && index < currRange) {
             item.classList.remove("hidden");
         }
      });
    };
    
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
    
    const addFirstLastEventListeners = () => {
        firstButton.addEventListener("click", () => {
           setCurrentPage(1); 
        });
        lastButton.addEventListener("click", () => {
           setCurrentPage(pageCount); 
        });
        
    };
    
    
    
    setPaginationNumbers();
    setCurrentPage(1);
    addPageNumberEventListeners();
    addFirstLastEventListeners();
    
};