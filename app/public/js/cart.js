(function () {
    let Cart = {};
    //Adds one item to the cart order
    Cart.Add = function (itemID) {
        document.getElementById('shopping-circle').classList.remove('d-none');
        document.getElementById('shopping-circle-text').innerHTML = this.count;

        const url = "/api/cart/add/" + itemID;
        return new Promise((resolve, reject) => {
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(response => response.json())
                .then(data => {
                    Cart.UpdateCounter();
                    resolve(data);
                }
                )
                .catch(error => {
                    reject(error);
                }
                );
        });
    };
    //Removes one item from the cart order
    Cart.Remove = function (itemID) {

        const url = apiUrl + '/remove/' + itemID;
        return new Promise((resolve, reject) => {
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(response => response.json())
                .then(data => {
                    Cart.UpdateCounter();
                    resolve(data);
                }
                )
                .catch(error => {
                    reject(error);
                }
                );
        });
    }
    //Gets the cart order from the server
    Cart.Get = function () {
        const url = apiUrl;
        return new Promise((resolve, reject) => {
            fetch(url, {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            }).then(response => response.json())
                .then(data => {
                    resolve(data);
                }
                )
                .catch(error => {
                    reject(error);
                }
                );
        });
    }

    //Updates the counter in the nav bar by getting the count from the cart order from the server
    Cart.UpdateCounter = function () {
        fetch('/api/cart/count',
            {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json'
                }
            }
        ).then(response => response.json())
            .then(data => {
                const cartCircle = document.querySelector('#shopping-circle');
                const cartCircleText = document.querySelector('#shopping-circle-text');
                if (data.count > 0) {
                    cartCircle.classList.remove('d-none');
                }
                else {
                    cartCircle.classList.add('d-none');
                }
                cartCircleText.innerHTML = data.count;

                this.count = data.count;

                console.log("Cart count: " + data.count);
            })
            .catch(error => {
                console.log(error);
            }
            );
    }

    window.Cart = Cart;
    console.log('Cart.js loaded.');
})();
