const map = {
  mapInput: () => {
    const latBox = document.querySelector(".latitude-box");
    const lngBox = document.querySelector(".longitude-box");
    const map = L.map("location-map").setView([10.33451, 37.72851], 14);
    // connect to Esri Map
    L.tileLayer(
      "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}",
      {
        attribution: "© Esri, Maxar, Earthstar Geographics",
      }
    ).addTo(map);
    // place labels with OpenStreetMap
    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
      opacity: 0.5,
      attribution: "",
    }).addTo(map);

    let marker;

    map.on("click", function (e) {
      const { lat, lng } = e.latlng;
      latBox.textContent = lat.toFixed(3);
      lngBox.textContent = lng.toFixed(3);
      latBox.dataset.lat = lat;
      lngBox.dataset.lng = lng;

      if (marker) {
        marker.remove();
      }
      marker = L.marker([lat, lng]).addTo(map);
    });
  },
  mapOutput: () => {
    console.log('hey');
    const map = L.map("ppty-map").setView([10.33451, 37.72851], 14);
    // connect to EsriMap
    L.tileLayer(
      "https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}",
      {
        attribution: "© Esri, Maxar, Earthstar Geographics",
      }
    ).addTo(map);
    // place labels with OpenStreetMap
    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
      opacity: 0.5,
      attribution: "",
    }).addTo(map);

    const mapElement = document.getElementById("ppty-map");
    const lat = Number(mapElement.dataset.lat);
    const lng = Number(mapElement.dataset.lng);
    if(lat && lng) {
        L.marker([lat, lng]).addTo(map);
    }
  }
};


export default map;
