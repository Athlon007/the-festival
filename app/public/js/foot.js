function onLoad() {
    const navs = fetch('/api/nav')
        .then(response => response.json())
        .then(data => data)
        .catch(error => console.error(error));
}

onLoad();