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
var postalCodeField = document.getElementById("postalCode");
var cityField = document.getElementById("city");
var countryField = document.getElementById("country");

function enableSaveChanges(){
    saveChangesButton.disabled = false;
}

function disableSaveChanges(){
    saveChangesButton.disabled = true;
}

function updateAccount(){
    removeAllSpaces();
    //Check if all fields are filled in
    if(!allFieldsFilled()){
        alert("Please fill in all required fields");
        return;
    }

    var address = {
        streetName: streetNameField.value,
        houseNumber: houseNumberField.value,
        postalCode: postalCodeField.value,
        city: cityField.value,
        country: countryField.value
    }

    var data;
    //If a new password is filled in, pass passwords in the data
    if(passwordField.value != ""){
        data = {
            firstName: firstNameField.value,
            lastName: lastNameField.value,
            dateOfBirth: doBField.value,
            phoneNumber: phoneNumberField.value,
            email: emailField.value,
            password: passwordField.value,
            passwordConfirm: passwordConfirmField.value,
            address: address
        }
   }
   //If new password is not filled in, do not pass passwords in the data
   else{
        data = {
            firstName: firstNameField.value,
            lastName: lastNameField.value,
            dateOfBirth: doBField.value,
            phoneNumber: phoneNumberField.value,
            email: emailField.value,
            address: address
        }
    } 
    //Pass the data to the update api
    fetch("/api/user/update-customer", {
        method: "POST",
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
            alert(data.success_message);
            window.location.assign("/");
    })
    .catch(error => {alert(error)});
}


function logout(){
    fetch("/api/user/logout",{
        method: "POST",
        body: JSON.stringify({logout: "true"})
    })
    .then(response => response.json())
    .then(data =>{
            window.location.assign("/home/login");
    })
    .catch(error => {alert(error)});
}

function removeAllSpaces(){
    firstNameField.value = firstNameField.value.replace(/\s/g, '');
    lastNameField.value = lastNameField.value.replace(/\s/g, '');
    streetNameField.value = streetNameField.value.replace(/\s/g, '');
    houseNumberField.value = houseNumberField.value.replace(/\s/g, '');
    postalCodeField.value = postalCodeField.value.replace(/\s/g, '');
    cityField.value = cityField.value.replace(/\s/g, '');
    countryField.value = countryField.value.replace(/\s/g, '');
    emailField.value = emailField.value.replace(/\s/g, '');
}

function allFieldsFilled(){
    return !(firstNameField.value == "" || lastNameField.value == "" || 
    doBField.value == "" || phoneNumberField.value == "" || 
    streetNameField.value == "" || houseNumberField.value == "" || 
    postalCodeField.value == "" || cityField.value == "" || 
    countryField.value == "" || emailField.value == "")
}