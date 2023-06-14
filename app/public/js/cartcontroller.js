// ------------------------------
// --- Used by /shopping-cart ---
// ------------------------------

// Find spans with following id pattern: cart-counter-*

const total = document.getElementById('total');

const cartCounterSpans = document.querySelectorAll('span[id^="cart-item-counter-"]');
for (let counter of cartCounterSpans) {
    // get the ID part.
    const id = counter.id.split('-')[3];

    const btnAdd = document.getElementById('cart-item-add-' + id);
    const btnRemove = document.getElementById('cart-item-remove-' + id);

    const cartItemUnitPrice = document.getElementById('cart-item-unit-price-' + id);
    const cartItemTotalPrice = document.getElementById('cart-item-total-price-' + id);

    btnAdd.addEventListener('click', function () {
        const count = parseInt(counter.innerHTML);
        counter.innerHTML = count + 1;
        Cart.Add(id);

        const unitPrice = parseFloat(cartItemUnitPrice.innerHTML);
        console.log(unitPrice);
        cartItemTotalPrice.innerHTML = "&euro; " + parseFloat(((count + 1) * unitPrice)).toFixed(0);

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

}

// Get hostname.
const hostname = window.location.hostname;
const protocol = window.location.protocol;
// Format: http://hostnane/shopping-cart?id=cartId
const shareId = document.getElementById('share-id').value;
const shareUrl = protocol + "//" + hostname + "/shopping-cart?id=" + shareId;

const shareUrlText = document.getElementById('share-url-text');
shareUrlText.value = shareUrl;

async function shareMyCart() {
    // Select entire text in the input field and copy it to clipboard.
    shareUrlText.select();
    await navigator.clipboard.writeText(shareUrlText.value);
}