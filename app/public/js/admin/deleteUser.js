function deleteUser(id) {
    if (confirm("Are you sure you want to delete this user?" + id + "?")) {
        const data = {
            id: id
        }
        fetch("/api/user/deleteUser", {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data),
        }).then(res => res.json())
            .then(data => {
                if (data.success_message) {
                    alert(data.success_message)
                    // Reload the page to show the updated list of users
                    location.reload();
                } else {
                    alert(data.error_message)
                }
            })
    }
    else {
        alert("User not deleted");
    }
}
