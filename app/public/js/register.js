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

function attemptRegister(){

}

function createAddressObject(){
    var housenumber = houseNumberField.value + " " + extensionField.value;
    
    const address = {
        streetName: streetNameField.value,
        houseNumber: housenumber,
        postalCode: postalCodeField.value,
        city: cityField.value,
        country: countryField.value
    }
    return address;
}

function fetchAddress(){    
    var postalCode = postalCodeField.value;
    var houseNumber = houseNumberField.value;

    fetch("https://postcode.tech/api/v1/postcode?postcode=" + postalCode + "&number=" + houseNumber, {
        headers: { "Authorization": "Bearer 1b9faa1d-1521-43ca-af73-4caeb208222b" }
                  
    })
    .then(response => response.json())
    .then(data => {
        if(data.message != null){
            return;
        }
        
        streetNameField.value = data.street;
        cityField.value = data.city;
        countryField.value = "Netherlands";
    })
}