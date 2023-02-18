const emailField = document.getElementById("email");
const passwordField = document.getElementById("password");

function AttemptLogin(){

    const data = {
        email: emailField.value,
        password: passwordField.value
    }
    
    fetch("/api/login", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(
            {
            email: emailField.value,
            password: passwordField.value
            }
            )
        })
    .then(data => {
        if(data.success){
            window.location.href = "/dashboard";
        } 
        else {
            alert(data.message);
        }
    })
}