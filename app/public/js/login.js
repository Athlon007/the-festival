//Fields
const emailField = document.getElementById("email");
const passwordField = document.getElementById("password");

//Popup window
var popup = document.getElementById("popup");

function attemptLogin(){

    if(!emailField.value || !passwordField.value){
        alert("Please fill in all fields.");
        return;
    }

    const data = {
        email: emailField.value,
        password: passwordField.value
    }
    
    fetch("/api/user/login", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data)
        })
    .then(response => response.json())
    .then(data => {
        
            displaySuccess(data.success_message);
            window.location.assign("/");
        })
    .catch(error => {displayError(error)});
}

function displayError(error){
    errorDiv = document.createElement("div");
    errorDiv.innerHTML = error;
    errorDiv.classList.add("alert");
    errorDiv.classList.add("alert-danger");
    errorDiv.classList.add("p-3");
    errorDiv.setAttribute("role", "alert");
    popup.appendChild(errorDiv);
}

function displaySuccess(success){
    successDiv = document.createElement("div");
    successDiv.innerHTML = success;
    successDiv.classList.add("alert");
    successDiv.classList.add("alert-success");
    successDiv.classList.add("p-3");
    successDiv.setAttribute("role", "alert");
    popup.appendChild(successDiv);
}   