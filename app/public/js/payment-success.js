// Call /api/cart/checkpayment to check if payment is successful
// If successful, Order object should return.
// If not, error_message should return.

let checkPayment = document.getElementById('check-payment');
let paymentSuccess = document.getElementById('payment-success');
let paymentFailed = document.getElementById('payment-failed');

let orderNumber = document.getElementById('order-number');
let orderDate = document.getElementById('order-date');

let failReason = document.getElementById('fail-reason');


fetch("/api/cart/checkpayment", {
    method: "GET",
    headers: {
        "Content-Type": "application/json"
    }
})
    .then((response) => response.json())
    .then(function (data) {
        // Add d-none to checkPayment.
        checkPayment.classList.add('d-none');

        console.log("data", data);
        if (data.error_message) {
            paymentFailed.classList.remove('d-none');
            failReason.textContent = data.error_message;
        } else {
            // Remove d-none from paymentSuccess.
            paymentSuccess.classList.remove('d-none');

            orderNumber.textContent = data.orderId;
            orderDate.textContent = data.orderDate.date.slice(0, -15);
        }
    }
    )
    .catch((error) => {
        console.error("Error:", error);
        checkPayment.classList.add('d-none');
        paymentFailed.classList.remove('d-none');
        failReason.textContent = error.data.error_message ?? "Unknown error.";
    }
    );
