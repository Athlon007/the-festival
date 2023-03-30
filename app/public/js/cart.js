(function () {
    const apiUrl = '/api/cart';
    var Cart = {};
    let count = 0;

    Cart.Add = function (itemID) {
        this.count++;
        ocument.getElementById('shopping-circle').classList.remove('d-none');
        document.getElementById('shopping-circle-text').innerHTML = this.count;

        const url = apiUrl + '/' + itemID;
        new Promise((resolve, reject) => {
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



    Cart.Remove = function (itemID) {
        this.count--;
        if (this.count < 0) {
            this.count = 0;
            ocument.getElementById('shopping-circle').classList.add('d-none');
        }
        document.getElementById('shopping-circle-text').innerHTML = this.count;

        const url = apiUrl + '/' + itemID;
        new Promise((resolve, reject) => {
            fetch(url, {
                method: 'DELETE',
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

    Cart.Clear = function () {
        this.count = 0;
        document.getElementById('shopping-circle').classList.add('d-none');

        const url = apiUrl + '/clear';
        new Promise((resolve, reject) => {
            fetch(url, {
                method: 'DELETE',
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

    Cart.Count = function () {
        const url = apiUrl + '/count';
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

    Cart.CountItem = function (itemID) {
        const url = apiUrl + '/count/' + itemID;
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

    Cart.UpdateCounter = function () {
        // get count
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
