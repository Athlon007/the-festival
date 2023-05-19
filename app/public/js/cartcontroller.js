const total = document.getElementById('total');

function removeTicket(orderItemId, ticketLinkId){
    const counter = document.getElementById('cart-counter-' + orderItemId);
    const cartItemUnitPrice = document.getElementById('order-item-unit-price-' + orderItemId);
    const cartItemTotalPrice = document.getElementById('order-item-total-price-' + orderItemId);

    const count = parseInt(counter.innerHTML);
        counter.innerHTML = count - 1;
        Cart.Remove(ticketLinkId);

        const unitPrice = parseFloat(cartItemUnitPrice.innerHTML);
        cartItemTotalPrice.innerHTML = "&euro; " + ((count - 1) * unitPrice);

        const totalAmount = parseFloat(total.innerHTML.split('€')[1]);
        total.innerHTML = "Total price: &euro; " + (totalAmount - unitPrice);

        if (count - 1 <= 0) {
            // remove the div.
            const div = document.getElementById('order-item-' + orderItemId);
            div.parentNode.removeChild(div);
        }
}

function addTicket(orderItemId, ticketLinkId){
    const counter = document.getElementById('order-counter-' + orderItemId);
    const cartItemUnitPrice = document.getElementById('order-item-unit-price-' + orderItemId);
    const cartItemTotalPrice = document.getElementById('order-item-total-price-' + orderItemId);

    const count = parseInt(counter.innerHTML);
    counter.innerHTML = count + 1;
    Cart.Add(ticketLinkId);
    const unitPrice = parseFloat(cartItemUnitPrice.innerHTML);
    cartItemTotalPrice.innerHTML = "&euro; " + ((count + 1) * unitPrice);

    const totalAmount = parseFloat(total.innerHTML.split('€')[1]);
    total.innerHTML = "Total price: &euro; " + (totalAmount + unitPrice);
}