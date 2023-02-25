const newPassword = document.getElementById("new-password");
const confirmPassword = document.getElementById("confirm-password");
const params = new URLSearchParams(window.location.search);
const token = params.get('token');
const email = params.get('email');

function  updatePassword(){

    const data = {
        newPassword: newPassword.value,
        confirmPassword: confirmPassword.value,
        token: token,
        email: email
    };

    fetch("/api/user/updatePassword", {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data),
    }).then(res => res.json())
        .then(data => {
            if (data.success_message) {
                alert(data.success_message)
            } else {
                alert(data.error_message)
            }
    })
}