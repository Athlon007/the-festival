//Personal information fields
const firstNameField = document.getElementById("firstName");
const lastNameField = document.getElementById("lastName");
const doBField = document.getElementById("dateOfBirth");
const phoneNumberField = document.getElementById("phoneNumber");

//Address fields
const streetNameField = document.getElementById("streetName");
const houseNumberField = document.getElementById("houseNumber");
const extensionField = document.getElementById("extension");
const postalCodeField = document.getElementById("postalCode");
const cityField = document.getElementById("city");
const countryField = document.getElementById("country");

//Account information fields
const emailField = document.getElementById("email");
const passwordField = document.getElementById("password");
const passwordConfirmField = document.getElementById("passwordConfirm");


function attemptRegister(captcha)
{
    if(!allFieldsFilled()){
        alert("Please fill in all fields");
        return;
    }
    else if(!checkPassword()){
        alert("Confirmed password does not match.");
        return;
    }
    else if(!document.getElementById("termsAcceptance").checked){
        alert("You must agree to our terms and conditions.");
        return;
    }

    const data = {
        firstName: firstNameField.value,
        lastName: lastNameField.value,
        dateOfBirth: doBField.value,
        phoneNumber: phoneNumberField.value,
        email: emailField.value,
        password: passwordField.value,
        address: createAddressObject(),
        captchaResponse: captcha
    }
    
    fetch("/api/user/register", {
        method: "POST",
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if(data.success_message){
            alert(data.success_message);
            window.location.assign("/home/login");
        } 
        else {
            alert(data.error_message);
        }
    });
}

function allFieldsFilled(){
    return !(!firstNameField.value || !lastNameField.value || !doBField.value || !phoneNumberField.value || !streetNameField.value
            || !houseNumberField.value || !postalCodeField.value || !cityField.value || !countryField.value || !emailField.value 
            || !passwordField.value || !passwordConfirmField.value);
}

function checkPassword(){
    return (passwordField.value == passwordConfirmField.value);
}

function createAddressObject(){
    var housenumber = houseNumberField.value + " " + extensionField.value;
    var postCode = postalCodeField.value.replace(" ", "");
    
    var address = {
        streetName: streetNameField.value,
        houseNumber: housenumber,
        postalCode: postCode,
        city: cityField.value,
        country: countryField.value
    }

    return address;
}

function fetchAddress(){    
    var postalCode = postalCodeField.value.replace(" ", "");
    var houseNumber = houseNumberField.value;

    const data = {
        postalCode: postalCode,
        houseNumber: houseNumber
    }

    fetch("/api/address/fetch-address", {
        method: "POST",
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if(data.address){
            streetNameField.value = data.address.street;
            cityField.value = data.address.city;
            countryField.value = "Netherlands";
        }
    });
}

function addError(message){
    const error = document.createElement("li");
    error.innerHTML = message;
    appendChild(error);
    return error;
}