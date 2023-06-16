<nav class="nav nav-pills flex-column flex-sm-row" id="admin-nav">
    <a class="flex-sm-fill text-sm-center nav-link" href="/manageTextPages">Text Pages</a>
    <a class="flex-sm-fill text-sm-center nav-link" href="/manageImages">Images</a>
    <a class="flex-sm-fill text-sm-center nav-link" href="/manageUsers">Users</a>

    <a class="flex-sm-fill text-sm-center nav-link" href="/manageJazz">Jazz</a>
    <a class="flex-sm-fill text-sm-center nav-link" href="/manageRestaurants">Restaurants</a>
    <a class="flex-sm-fill text-sm-center nav-link" href="/manageDJs">Dance</a>
    <a class="flex-sm-fill text-sm-center nav-link" href="/manageHistory">History</a>
    <a class="flex-sm-fill text-sm-center nav-link" href="/manageTicketTypes">Ticket Types</a>
    <a class="flex-sm-fill text-sm-center nav-link" href="/managePasses">Passes</a>
    <a class="flex-sm-fill text-sm-center nav-link" href="/manageNavBar">Nav Bar</a>
    <a class="flex-sm-fill text-sm-center nav-link" href="/manageLocations">Locations</a>
    <a class="flex-sm-fill text-sm-center nav-link" href="/viewOrders">Orders</a>
    <a class="flex-sm-fill text-sm-center nav-link" href="/manageApiKeys">API Keys</a>
</nav>

<script>
    // Mark the a active, which has the same href as the current page.
    for (const a of document.getElementById('admin-nav').querySelectorAll('a')) {
        if (window.location.href.includes(a.href)) {
            a.classList.add('active');
        }
    }
    // get href without the domain
    const href = window.location.href.split(window.location.host)[1];
    if (href == '/manage') {
        document.getElementById('admin-nav').querySelectorAll('a')[0].classList.add('active');
    }
</script>