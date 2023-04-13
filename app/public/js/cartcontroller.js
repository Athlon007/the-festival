// Find spans with following id pattern: cart-counter-*

const total = document.getElementById('total');

const cartCounterSpans = document.querySelectorAll('span[id^="cart-item-counter-"]');
for (let counter of cartCounterSpans) {
    // get the ID part.
    const id = counter.id.split('-')[3];

    const btnAdd = document.getElementById('cart-item-add-' + id);
    const btnRemove = document.getElementById('cart-item-remove-' + id);
    const btnDelete = document.getElementById('cart-item-delete-' + id);

    const cartItemUnitPrice = document.getElementById('cart-item-unit-price-' + id);
    const cartItemTotalPrice = document.getElementById('cart-item-total-price-' + id);

    btnAdd.addEventListener('click', function () {
        const count = parseInt(counter.innerHTML);
        counter.innerHTML = count + 1;
        Cart.Add(id);

        const unitPrice = parseFloat(cartItemUnitPrice.innerHTML);
        cartItemTotalPrice.innerHTML = "&euro; " + ((count + 1) * unitPrice);

        const totalAmount = parseFloat(total.innerHTML.split('€')[1]);
        total.innerHTML = "Total price: &euro; " + (totalAmount + unitPrice);
    });

    btnRemove.addEventListener('click', function () {
        const count = parseInt(counter.innerHTML);
        counter.innerHTML = count - 1;
        Cart.Remove(id);

        const unitPrice = parseFloat(cartItemUnitPrice.innerHTML);
        cartItemTotalPrice.innerHTML = "&euro; " + ((count - 1) * unitPrice);

        const totalAmount = parseFloat(total.innerHTML.split('€')[1]);
        total.innerHTML = "Total price: &euro; " + (totalAmount - unitPrice);

        if (count - 1 <= 0) {
            // remove the div.
            const div = document.getElementById('cart-item-' + id);
            div.parentNode.removeChild(div);
        }
    });

    btnDelete.addEventListener('click', function () {
        const count = parseInt(counter.innerHTML);
        for (let i = 0; i < count; i++) {
            Cart.Remove(id);
        }

        const div = document.getElementById('cart-item-' + id);
        div.parentNode.removeChild(div);
        Cart.Delete(id);

        const unitPrice = parseFloat(cartItemUnitPrice.innerHTML);
        const totalAmount = parseFloat(total.innerHTML.split('€')[1]);
        total.innerHTML = "Total price: &euro; " + (totalAmount - unitPrice * count);
    });
}