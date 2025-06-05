import modalListeners from "./modals.js";
function fetchProperties() {
    fetch('fetch_properties.php')
    .then(response => response.json())
    .then(data => {
        if(data.success){
            const properties = data.properties;
            const propertyList = document.querySelector('.properties-list');
            propertyList.innerHTML = ''; // Clear existing properties
            properties.forEach(property => {
                propertyList.innerHTML += `
                    <div class="row">
                        <div class="ppty-img">
                            <img src="${property.property_image}" alt="property ${property.id}" class="property_image">
                        </div>
                        <p class="property_name">${property.title}</p>
                        <p class="property_location">Addis Ababa</p>
                        <p class="property_status" data-status="available">Available</p>
                        <div class="actions">
                            <div class="action view-ppty">
                                <i class="fas fa-eye view-icon"></i>
                                <div class="action_title">View</div>
                            </div>
                            <div class="action edit-ppty">
                                <i class="fas fa-pencil edit-icon"></i>
                                <div class="action_title">Edit</div>
                            </div>
                            <div class="action delete-ppty open-modal" data-modal="modal-delete-ppty" data-id="${property.id}">
                                <i class="fas fa-trash delete-icon"></i>
                                <div class="action_title">Delete</div>
                            </div>
                        </div>
                    </div>
                `
            })
            //select
            const modals = document.querySelectorAll('.modal');
            const openBtns = document.querySelectorAll('.open-modal');
            const closeBtns = document.querySelectorAll('.close-modal');
            modalListeners(modals, openBtns, closeBtns);
            // deleting functionality
            const deleteButtons = document.querySelectorAll('.delete-ppty');
            const deletPptyModal = document.querySelector('.modal-delete-ppty');
            deleteButtons.forEach(btn => {
                btn.addEventListener('click', function() {
                    deletPptyModal.dataset.pptyId = btn.dataset.id;
                })
            });
        }
    })
}

export default fetchProperties;