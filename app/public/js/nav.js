// Returns the navbar items from the API.
function getNavbarItems() {
    return fetch('/api/nav')
        .then(response => response.json())
        .then(data => data)
        .catch(error => console.error(error));
}

// Creates a nav link for the navbar.
function createNavLink(collapseLi, element) {
    // Create the a
    let collapseA = document.createElement('a');
    collapseA.classList.add('nav-link');
    collapseA.setAttribute('href', element.page.href);
    collapseA.textContent = element.page.title;

    // If the current URL contains the href of the page, add the active class to the li.
    if (window.location.href.includes(element.page.href)) {
        collapseA.classList.add('active');
    }

    // Add the a to the li
    collapseLi.appendChild(collapseA);
    return collapseLi
}

// Creates a dropdown menu for the navbar.
function createDropdown(collapseLi, element) {
    collapseLi.classList.add('dropdown');
    // open on hover
    collapseLi.onmouseover = function () {
        collapseLi.classList.add('show');
        collapseLi.children[1].classList.add('show');
    };
    collapseLi.onmouseleave = function () {
        collapseLi.classList.remove('show');
        collapseLi.children[1].classList.remove('show');
    };
    // Create the a
    let collapseA = document.createElement('a');
    collapseA.classList.add('nav-link');
    collapseA.classList.add('dropdown-toggle');
    collapseA.setAttribute('href', element.page.href);
    collapseA.setAttribute('id', 'navbarDropdown-' + element.id);
    collapseA.setAttribute('role', 'button');
    collapseA.setAttribute('data-toggle', 'dropdown');
    collapseA.setAttribute('aria-haspopup', 'true');
    collapseA.setAttribute('aria-expanded', 'false');
    collapseA.textContent = element.page.title;
    collapseLi.appendChild(collapseA);

    // If the current URL contains the href of the page, add the active class to the li.
    if (window.location.href.includes(element.page.href)) {
        collapseA.classList.add('active');
    }

    // Create the dropdown menu
    let collapseDropdownMenu = document.createElement('div');
    collapseDropdownMenu.classList.add('dropdown-menu');
    collapseDropdownMenu.setAttribute('aria-labelledby', 'navbarDropdown-' + element.id);
    // Create the dropdown menu a
    element.children.forEach(child => {
        let collapseDropdownMenuA = document.createElement('a');
        collapseDropdownMenuA.classList.add('dropdown-item');
        collapseDropdownMenuA.setAttribute('href', child.page.href);
        collapseDropdownMenuA.textContent = child.page.title;
        collapseDropdownMenu.appendChild(collapseDropdownMenuA);
    }
    );
    // Add the dropdown menu to the li
    collapseLi.appendChild(collapseDropdownMenu);
    return collapseLi;
}

// Loads the navbar.
function loadNavbar() {
    console.log('Document loaded');
    let nav = document.getElementsByClassName('navbar')[0];
    if (nav == null) {
        console.error('Navbar not found');
        return;
    }

    // Create the collapse button
    let colapseButton = document.createElement('button');
    colapseButton.classList.add('navbar-toggler');
    colapseButton.setAttribute('type', 'button');
    colapseButton.setAttribute('data-toggle', 'collapse');
    colapseButton.setAttribute('data-target', '#navbarNav');
    colapseButton.setAttribute('aria-controls', 'navbarNav');
    colapseButton.setAttribute('aria-expanded', 'false');
    colapseButton.setAttribute('aria-label', 'Toggle navigation');
    // Create the span
    let colapseButtonSpan = document.createElement('span');
    colapseButtonSpan.classList.add('navbar-toggler-icon');
    colapseButton.appendChild(colapseButtonSpan);
    // Add the button to the navbar
    nav.appendChild(colapseButton);

    // Create the collapse div
    let collapseDiv = document.createElement('div');
    collapseDiv.classList.add('collapse');
    collapseDiv.classList.add('navbar-collapse');
    collapseDiv.classList.add('justify-content-md-center');
    collapseDiv.setAttribute('id', 'navbarNav');
    // Create the ul
    let collapseUl = document.createElement('ul');
    collapseUl.classList.add('navbar-nav');

    let navs = getNavbarItems();

    navs.then(data => {
        data.forEach(element => {
            // Create the li
            let collapseLi = document.createElement('li');
            collapseLi.classList.add('nav-item');

            // Check if element is in half of array
            console.log(Math.floor(data.length / 2));
            if (Math.floor(data.length / 2) == data.indexOf(element) - 1) {
                // add logo
                let logo = document.createElement('img');
                logo.setAttribute('src', '/img/logo.png');
                logo.setAttribute('alt', 'Logo');
                logo.classList.add('logo');
                collapseUl.appendChild(logo);
            }

            if (element.children.length > 0) {
                // Add the li to the ul
                collapseUl.appendChild(createDropdown(collapseLi, element));
            } else {
                // Add the li to the ul
                collapseUl.appendChild(createNavLink(collapseLi, element));
            }
        });
    });

    // Add the ul to the collapse div
    collapseDiv.appendChild(collapseUl);
    // Add the collapse div to the navbar
    nav.appendChild(collapseDiv);
}
loadNavbar();