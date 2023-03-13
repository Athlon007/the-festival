//Save changes button
var saveChangesButton = document.getElementById("saveChangesButton");

//Error list
var errorList = document.getElementById("errorList");

//Personal information fields
var firstNameField = document.getElementById("firstName");
var lastNameField = document.getElementById("lastName");
var doBField = document.getElementById("dateOfBirth");
var phoneNumberField = document.getElementById("phoneNumber");

//Account information fields
var emailField = document.getElementById("email");
var passwordField = document.getElementById("password");
var passwordConfirmField = document.getElementById("passwordConfirm");

//Address information fields
var streetNameField = document.getElementById("streetName");
var houseNumberField = document.getElementById("houseNumber");
var extensionField = document.getElementById("extension");
var postalCodeField = document.getElementById("postalCode");
var cityField = document.getElementById("city");
var countryField = document.getElementById("country");

function enableSaveChanges(){
    saveChangesButton.disabled = false;
}

function disableSaveChanges(){
    saveChangesButton.disabled = true;
}

function addressChange(){
    enableSaveChanges();
}

function updateAccount(user){
    
    
    if (passwordField.value){
        if(!checkPassword(user)){
            alert("Confirmed password does not match.");
            return;
        }
    }
}

function checkPassword(user){
    
}