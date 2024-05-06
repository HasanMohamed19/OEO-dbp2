let buttons = document.querySelectorAll(".list-group-item-action");
let cardsSection = document.querySelectorAll(".my-account-body > .card");
// buttons.forEach((button) => {
//   button.addEventListener('click', event => {
//     buttons.forEach(button => button.classList.remove('active-side-btn'));
//     if (button.value !== 'reset') {
//       button.classList.add('active-side-btn');
//     }
//   });
// });

// since we dont need the last button we use length-1
function resetButtons() {
    buttons.forEach((button) => {
        button.classList.remove("active-side-btn");
    });
    hideDivs();
}

function hideDivs() {
    cardsSection.forEach((section => {
        section.classList.add("inactive");
    }));
}

for (let i = 0; i < buttons.length-1; i++) {
    const button = buttons[i];
    const section = cardsSection[i];
    button.addEventListener('click', event => {
        resetButtons();
//        if (button.value != "reset") {
            button.classList.add("active-side-btn");
            section.classList.remove("inactive");
//        }
    });
}