document.addEventListener('DOMContentLoaded', () => {

    // --- View Details Button Interaction ---
    const detailsButtons = document.querySelectorAll('.btn-details');
    const propertiesContainer = document.querySelector('.all-properties')
    fetchProperties(propertiesContainer);
});


// fetch properties
function fetchProperties(propertiesContainer){
    fetch('./includes/fetch_all_properties.php')
    .then(response => response.json())
    .then(res => {
        if(res.success) {
            const properties = res.properties;
            properties.forEach(property => {
                fetch('./includes/fetch_landlord.php', {
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    method : 'POST',
                    body: new URLSearchParams({
                        landlord_id: property.landlord_id
                    })
                })
                .then(response => response.json())
                .then(res => {
                    if(res.success) {
                        const landlords = res.landlords;
                        landlords.forEach(landlord => {
                            if(+landlord.id === +property.landlord_id) {
                                propertiesContainer.innerHTML += `
                                <article class="property-card">
                                    <div class="card-image">
                                    <img src="./includes/${property.property_image}" alt="Property ${property.id}">
                                    </div>
                                    <div class="card-body">
                                        <p class="price">${property.price}/Month</p>
                                        <h3 class="title">${property.title.charAt(0).toUpperCase() + property.title.slice(1)}</h3>
                                        <!-- <p class="location-text">Cambridge, Massachusetts</p> -->
                                        <hr>
                                        <div class="specs">
                                            <span><i class="fa-solid fa-bed"></i>${property.bedrooms}</span>
                                        </div>
                                            <div class="agent">
                                            <img src="${landlord.profile_pic}" alt="Agent Avatar">
                                            <span>${landlord.first_name} ${landlord.last_name}</span>
                                        </div>
                                        <a class="btn-details" href="./property_details.php?pid=${property.id}">View Details</a>
                                    </div>
                                </article>
                                `;
                            }
                        });
                    }
                });
                const pptyCountElements = document.querySelectorAll('.count');
                pptyCountElements.forEach(countElement => {
                    countElement.textContent = properties.length;
                })
            });
        }
    });
}
