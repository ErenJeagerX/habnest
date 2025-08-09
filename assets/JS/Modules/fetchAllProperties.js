function fetchAllProperties() {
  fetch("fetch-properties.php")
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        const properties = data.properties;
        const propertyList = document.querySelector(".properties-list");
        propertyList.innerHTML = ""; // Clear existing properties
        properties.forEach((property) => {
          propertyList.innerHTML += `
                    <div class="row">
                        <div class="ppty-img">
                            <img src="${property.property_image}" alt="property ${property.id}" class="property_image">
                        </div>
                        <p class="property_name">${property.title.charAt(0).toUpperCase() + property.title.slice(1)}</p>
                        <p class="property_location">Debre Markos</p>
                        <p class="property_status" data-status="${property.status}">
                        <span class="status-text">${property.status.charAt(0).toUpperCase() + property.status.slice(1)}</span>
                        </p>
                        <div class="actions">
                            <a class="action view-ppty" href="../property_details.php?pid=${property.id}" target="_blank">
                                <i class="fas fa-eye view-icon"></i>
                                <div class="action_title">View</div>
                            </a>
                        </div>
                    </div>
                `;
        });
      }
    });
}

export default fetchAllProperties;
