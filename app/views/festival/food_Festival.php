<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <meta name=”robots” content="index, follow">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="/css/main.css">
  <link rel="stylesheet" href="/css/main_no_editor.css">
  <link rel="stylesheet" href="/css/icons.css">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css">
  <link rel="stylesheet" href="/css/food_festival.css">
  <title>Example</title>
</head>

<body>

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark"></nav>
  <script type="module" src="/js/nav.js"></script>
  <div style="text-align:center">
    <h1>Yummy!</h1>
    <h3>One time deals can be found in these participating restaurants:</h3>
  </div>

  <div id="background">
    <div class="row g-0 text-center">
      <div class="card" style="width: 18rem;">
        <ul class="list-group list-group-flush">
          <li class="list-group-item">
            <div class="col-md-6 ticketOfTour" style="width: 50%; float:center;">
              <h3>FIlter by type</h3>
              <select class="form-select" id="ticket">
                <?php foreach ($types as $type) { ?>
                  <option value="<?php $type['typeId'] ?>"> <?= $type['typeName'] ?></option>
                <?php } ?>
              </select>
            </div>
          </li>
          <li class="list-group-item">
            <h3>Dates</h3>
            <select class="form-select" id="date" onselect="filterByDate()">
              <option selected>Select ticket</option>
              <option value="27/07/2023">Thu 27/07/2023</option>
              <option value="28/07/2023">Fri 28/07/2023</option>
              <option value="29/07/2023">Sat 29/07/2023</option>
              <option value="30/07/2023">Sun 30/07/2023</option>
            </select>
          </li>
          <li class="list-group-item">
            <h3>Price Range</h3>
            <div class="center">
              <label for="appt">Select a minprice:</label>
              <input type="number" name="number" placeholder="minprice" min="5" />
              <label for="appt">Select a maxprice:</label>
              <input type="number" name="number" placeholder="maxprice" max="50" />
            </div>
          </li>
        </ul>
      </div>

      <div class="col-md-8">
        <div class="scrolable" id="restaurants">

        </div>
      </div>
    </div>
  </div>
  </div>
  </div>

  <script>
    loadData();

    function loadData() {
      const restDiv = document.getElementById('restaurants');
      restDiv.innerHTML = '';

      fetch('/api/restaurants')
        .then(response => response.json())
        .then((events) => {
          appendData(events);
        })
    }

    function appendData(events) {
      const restDiv = document.getElementById('restaurants');
      events.forEach(event => {
        const div = document.createElement('div');
        div.className = 'item';
        div.innerHTML = `
        <div class="card">
          <div class="column">
          <h3>${event.event.restaurant.restaurantName}</h3>
          </div>
          <div class="column">
            <p>${event.event.restaurant.description}</p>
          </div>
          <div class="column">
            <p>${event.event.restaurant.price}</p>
          </div>
          <div class="column">
            <p>${event.event.restaurant.ticketLinkid}</p>
          </div>
            <button class="btn btn-primary addToCartButton" onClick="Cart.Add(${event.id})">Add to cart</button>
        </div>
        `;
        restDiv.appendChild(div);
      });

      function filterByDate() {
        const date = document.getElementById('date').value;
        const url = '/api/restaurants?date=' + date;

        const restDiv = document.getElementById('restaurants');
        restDiv.innerHTML = '';

        fetch(url)
          .then(response => response.json())
          .then((events) => {
            appendData(events);
          })
      }


    }

    function addToCart() {
      Cart.Add(ticketLinkid);
    }
  </script>

  <footer class="foot row bottom"></footer>
  <script type="application/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
  <script type="module" src="/js/nav.js"></script>
  <script type="module" src="/js/foot.js"></script>

</body>

</html>