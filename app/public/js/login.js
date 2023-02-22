const emailField = document.getElementById("email");
const passwordField = document.getElementById("password");

function attemptLogin(){

    if(!emailField.value || !passwordField.value){
        alert("Please fill in all fields.");
        return;
    }

    const data = {
        email: emailField.value,
        password: passwordField.value
    }
    
    fetch("/api/login", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data)
        })
    .then(response => response.json())
    .then(data => {
        if(data.error_message != null){
            alert(data.error_message);
        }
        else{
            alert(data.success_message);
            window.location.assign("/");
        }
    })
}