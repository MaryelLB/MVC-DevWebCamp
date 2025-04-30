if(document.querySelector('#mapa')){
    const lat = 34.04014269778158;
    const lng = -118.26996259717149;
    const zoom = 16;
    var map = L.map('mapa').setView([lat, lng], zoom);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

L.marker([lat, lng]).addTo(map)
    .bindPopup(`
        <h2 class="mapa__heading">DevWebCamp</h2>
        <p class="mapa__texto">Centro de convenciones de los angeles</p>
        `)
    .openPopup();
}