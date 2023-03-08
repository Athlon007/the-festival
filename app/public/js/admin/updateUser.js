function updateUser(id) {
    const firstName = document.getElementById("firstName").value;
    const lastName = document.getElementById("lastName").value;
    const email = document.getElementById("email").value;

    const data = {
        id: id,
        firstName: firstName,
        lastName: lastName,
        email: email
    }
    fetch("/api/user/updateUser", {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(data),
    }).then(res => res.json())
        .then(data => {
            if (data.success_message) {
                alert(data.success_message)
                // Reload the page to show the updated list of users
                window.location.href = "/manageUsers";
            } else {
                alert(data.error_message)
            }
        }
        )
}