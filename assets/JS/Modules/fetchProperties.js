import modalListeners from "./modals.js";
import deletePropertyButtonListener from "./deleteProperty.js";
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
                            <div class="action edit-ppty open-modal" data-modal="modal-edit-ppty" data-id="${property.id}">
                                <i class="fas fa-pencil edit-icon"></i>
                                <div class="action_title">Edit</div>
                            </div>
                            <div class="action delete-ppty open-modal" data-modal="modal-delete-ppty" data-id="${property.id}">
                                <i class="fas fa-trash delete-icon"></i>
                                <div class="action_title">Delete</div>
                            </div>
                        </div>
                    </div>
                `;
                // editing functionality
                const editPptyButtons = document.querySelectorAll('.edit-ppty');
                const editPptyForm = document.querySelector('#editPptyForm');
                initEditButtons(editPptyButtons, editPptyForm);
                // put property data into edit modal inputs
                if(+property.id === +editPptyForm.dataset.ppty){
                    editPptyForm.innerHTML = `
                    <div class="flex-container">
                        <div class="ppty-data">
                            <div class="ppty-details">
                                <h3>Property Details</h3>
                                <div class="group-input">
                                    <div class="userInput">
                                        <label for="property_title">Property title</label>
                                        <div class="input-field">
                                            <i class="fas fa-home"></i>
                                            <input type="text" id="property_title" placeholder="e.g. Spacious Apartment" name="title" value="${property.title}">
                                        </div>
                                        <div class="ppty-error hidden" data-input="property_title"></div>
                                    </div>
                                </div>
                                <div class="userInput">
                                    <label for="property_description">Description</label>
                                    <div class="input-field descInputContainer">
                                        <i class="fas fa-home"></i>
                                        <textarea id="property_description" placeholder="Describe your property..." name="description">${property.description}</textarea>
                                        <div class="charcount hidden">
                                            <span class="count">${property.description.length}</span>
                                            <span class="maxcharlength">/ 150</span>
                                        </div>
                                    </div>
                                    <div class="ppty-error hidden" data-input="property_description"></div>
                                </div>
                                <div class="group-input">
                                    <div class="userInput">
                                        <label for="property_price">Price per Month (Br) </label>
                                        <div class="input-field">
                                            <i class="fas fa-dollar"></i>
                                            <input type="text" id="property_price" placeholder="e.g. 3000" name="price" value="${property.price}">
                                        </div>
                                        <div class="ppty-error hidden" data-input="property_price"></div>
                                    </div>
                                    <div class="userInput">
                                        <label>Bedrooms</label>
                                        <div class="select">
                                            <div class="selected">
                                                <div class="selected_text">${property.bedrooms}</div>
                                                <i class="fas fa-chevron-down"></i>
                                            </div>
                                            <div class="options">
                                                <div class="option">1</div>
                                                <div class="option">2</div>
                                                <div class="option">3</div>
                                                <div class="option">4</div>
                                                <div class="option">5+</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ppty-location">
                                <h3>Location</h3>
                                <div class="location-map" id="location-map">
                                </div>
                                <div class="location-data" id="location-data">
                                    <div class="latitude">
                                        <label>Latitude</label>
                                        <div class="location-box latitude-box" data-lat="${property.lat}">${property.lat.toFixed(3)}</div>
                                    </div>
                                    <div class="longitude">
                                        <label>Longitude</label>
                                        <div class="location-box longitude-box" data-lng="${property.lng}">${property.lng.toFixed(3)}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ppty-data ppty-media">
                            <h3>Property Media</h3>
                            <div class="upload-media">
                                <label for="upload-media" id="label_upload">
                                    <i class="fas fa-cloud"></i>
                                    <p>Click to select files</p>
                                </label>
                                <input type="file" id="upload-media" name="files[]" multiple>
                            </div>
                            <div class="uploaded-media">
                                <label>Uploaded images</label>
                                <div class="imgs">
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="submit-btn">Submit</button>
                    `;
                }
            })
            // modal functionality
            const modals = document.querySelectorAll('.modal');
            const openBtns = document.querySelectorAll('.open-modal');
            const closeBtns = document.querySelectorAll('.close-modal');
            modalListeners(modals, openBtns, closeBtns);
            // deleting functionality
            const deleteButtons = document.querySelectorAll('.delete-ppty');
            initDeleteButtons(deleteButtons);
            deletePropertyButtonListener();
        }
    })
}

// delete buttons listener
function initDeleteButtons(deleteBtns) {
    const deletePptyModal = document.querySelector('.modal-delete-ppty');
    deleteBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            deletePptyModal.querySelector('.delete-modal').dataset.ppty = parseInt(btn.dataset.id);
        });
    });
}
// edit buttons listener
function initEditButtons(btns, form) {
    btns.forEach(btn => {
        btn.addEventListener('click', function(){
            form.dataset.ppty = parseInt(btn.dataset.id);
        });
    });
}

export default fetchProperties;