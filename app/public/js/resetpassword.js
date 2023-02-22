const emailField = document.getElementById("emailField");




// function resetPassword() {
//     const data = {
//         email: emailField.value
//     }

//     fetch("/api/resetPassword", {
//         method: 'POST',
//         headers: {'Content-Type': 'application/json'},
//         body: JSON.stringify(data),
//     }).then(res => res.json())
//         .then(data => {
//             if (data.success) {
//                 alert('Email sent!')
//             } else {
//                 alert('Email not sent!')
//             }
//         })
// };
function resetPassword() {
    const data = {
        email: emailField.value
    }

    fetch("/api/resetPassword", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data),
    }).then(res => res.text())
        .then(data => {
            console.log(data); // log the response to the console
            try {
                const jsonData = JSON.parse(data);
                if (jsonData.success) {
                    alert('Email sent!');
                } else {
                    alert('Email not sent!');
                }
            } catch (error) {
                console.error(error);
                alert('An error occurred while parsing the response');
            }
        })
        .catch(error => {
            console.error(error);
            console.log(error.message); // log the error message returned by the server
            alert('An error occurred while fetching the data');
        });
};


