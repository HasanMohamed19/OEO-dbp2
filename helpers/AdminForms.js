/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Other/javascript.js to edit this template
 */

function getHallID(button) {
    var hallID = button.getAttribute("data-id");
    var hallIDInput = document.getElementById('hallIdInput');
    hallIDInput.value = hallID; // Set the value directly, no need for setAttribute
}

function validateForm() {
    // Get form inputs
    var Hallname = document.getElementById('hallNameInput').value;
    var rntlCharge = document.getElementById('RntlchargeInput').value;
    var capacity = document.getElementById('CapacityInput').value;
    var imageUpload = document.getElementById('imageUpload');
    var form = document.getElementById('add-form');
    if (imageUpload.files.length === 0 || Hallname === '' || rntlCharge == '' || capacity == '') {
        form.classList.add('was-validated');
        return false; // Prevent form submission
    }
    // If all checks pass, allow form submission
    return true;
}
