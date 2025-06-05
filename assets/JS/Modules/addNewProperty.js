import displayStatus from './displayStatus.js';
import fetchProperties from './fetchProperties.js';
function addNewPpty(){
    validateForm();
}
// display input errors live
function validateForm() {
    //**** select elements ****//
    const form = document.querySelector('#addNewPptyForm');
    const uploadBtn = form.querySelector('#label_upload');
    const uploadInput = form.querySelector('#upload-media');
    const imageContainer = form.querySelector('.imgs');
    let inputs = form.querySelectorAll('input, textarea');
    inputs = [...inputs].filter(input => !input.type.includes('file'));
    const titleInput = form.querySelector('#property_title');
    const descriptionInput = form.querySelector('#property_description');
    const priceInput = form.querySelector('#property_price');
    const bedroomsEl = form.querySelector('.selected_text');
    const presetLat = 10.33;
    const presetLng = 37.72;
    //**** display error messages live ****//
    // length validation for title and description
    titleInput.addEventListener('input', function() { 
        if (titleInput.value.length < 5 && titleInput.value) {
            showErrorPopup('Title must be at least 5 characters', titleInput);
        } else if (!titleInput.value) {
            showErrorPopup('Title is required', titleInput);
        } 
        else if(titleInput.value.length > 30) { 
            showErrorPopup('Title must be less than 30 characters', titleInput);
            titleInput.value = titleInput.value.slice(0, 30); // limit to 30 characters
        }
        else {
            hideErrorPopup(titleInput);
        }
    });
    descriptionInput.addEventListener('input', function() { 
        if (descriptionInput.value.length < 20 && descriptionInput.value) {
            showErrorPopup('Description must be at least 20 characters', descriptionInput);
        }
        else if (!descriptionInput.value) {
            showErrorPopup('Description is required', descriptionInput);
        } 
        else {
            hideErrorPopup(descriptionInput);
        }
    });
    // invalid price input
    priceInput.addEventListener('input', function() {
        const priceValue = Number(priceInput.value);
        if ((isNaN(priceValue) || priceValue <= 0 ||  priceInput.value.charAt(0) === '0') && priceInput.value) {
            showErrorPopup('Price must be a valid number', priceInput);
        } 
        else if (!priceInput.value) {
            showErrorPopup('Price is required', priceInput);
        }
        else {
            hideErrorPopup(priceInput);
        }
    });
    // description input character count
    descriptionInput.addEventListener('input', function() {
        const charCountEl = form.querySelector('.charcount');
        if(this.value) {
            charCountEl.classList.remove('hidden');
            charCountEl.querySelector('.count').textContent = this.value.length;
            if(this.value.length === 150) {
                charCountEl.querySelector('.count').classList.add('max');
            }
            if(this.value.length > 149) {
                this.value = this.value.slice(0, 149);
            }
        }
        else {
            charCountEl.classList.add('hidden');
        }
    })
    //**** handle image upload ****//
    let images= [];
    let coverIndex = 0;
    uploadInput.addEventListener('change', function(){
        const uploadedImages = form.querySelectorAll('.uploaded-image');
        images = [...uploadInput.files].filter(file => file.type.includes('image/'));
        if(images.length + uploadedImages.length <=3) {
            for(let img of images) {
                if (img.size > 5 * 1024 * 1024) { // 5MB limit
                    displayStatus('error', 'Image size must be less than 5MB');
                    return;
                }
                const uploadedImg = document.createElement('div');
                uploadedImg.className = "uploaded-image";
                uploadedImg.innerHTML = `
                <img src="${URL.createObjectURL(img)}" alt="${img.name}" data-name="${img.name}">      
                <div class="layer">      
                    <div class="cover-btn layer-btn">Set as cover</div>  
                    <div class="delete-btn layer-btn">Delete</div>           
                </div>`
                imageContainer.appendChild(uploadedImg);
            }
            // if 3 images are uploaded, disable the upload input
            if (form.querySelectorAll('.uploaded-image').length === 3) {
                uploadBtn.classList.add('inactive');
                uploadInput.disabled = true;
            }
            // cover buttons functionality
            // cover badge
            const badge = document.createElement('div');
            badge.className = 'badge';
            badge.textContent = 'Cover';
            // set first image as cover
            if(form.querySelector('.uploaded-image')){
                form.querySelector('.uploaded-image').appendChild(badge);
            }
            const coverBtns = document.querySelectorAll('.cover-btn');
            coverBtns.forEach(btn => {
                btn.addEventListener('click', function(){
                    // remove badge from previous cover image
                    form.querySelectorAll('.uploaded-image').forEach(img => {
                        img.querySelector('.badge')?.remove();
                    });
                    // add badge to current cover image
                    this.parentElement.parentElement.appendChild(badge);
                    // change cover image index
                    images.forEach((img, index) => {
                        if(img.name === this.parentElement.parentElement.querySelector('img').dataset.name) {
                            coverIndex = index;
                        }
                    });
                })
            });
            // delete buttons functionality
            const deleteBtns = document.querySelectorAll('.delete-btn');
            deleteBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const imgDiv = this.parentElement.parentElement;
                    imgDiv.remove();
                    const firstImageContainer = form.querySelector('.uploaded-image');
                    // reset cover index if the cover image is deleted
                    if (imgDiv.querySelector('img').dataset.name === images[coverIndex].name) {
                        coverIndex = 0; // reset to first image
                        if (firstImageContainer) {
                            const badge = document.createElement('div');
                            badge.className = 'badge';
                            badge.textContent = 'Cover';
                            firstImageContainer.appendChild(badge);
                        }
                    }
                    // if there are less than 3 images, enable the upload input
                    if (imageContainer.querySelectorAll('.uploaded-image').length < 3) { 
                        uploadBtn.classList.remove('inactive');
                        uploadInput.disabled = false;
                    }
                    // remove image from the images array
                    images = images.filter(img => img.name !== imgDiv.querySelector('img').dataset.name);
                });
            })
        }
        else {
            displayStatus('error', 'Please upload exactly 3 images');
        }
    });
    // **** handle errors on form submission ****//
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        let hasError = false;
        // check for empty inputs
        inputs.forEach(input => {
            if (!input.value.trim()) {
                showErrorPopup(`This field is required`, input);
                hasError = true;
            } else {
                hideErrorPopup(input);
            }
        });
        // check for title and description length
        if (titleInput.value.length < 10 && titleInput.value) {
            showErrorPopup('Title must be at least 10 characters', titleInput);
            hasError = true;
        }
        if (descriptionInput.value.length < 20 && descriptionInput.value) {
            showErrorPopup('Description must be at least 20 characters', descriptionInput);
            hasError = true;
        }
        // check for price input
        const priceValue = Number(priceInput.value);
        if ((isNaN(priceValue) || priceValue <= 0 || priceInput.value.charAt(0) === '0') && priceInput.value) {
            showErrorPopup('Price must be a valid number', priceInput);
            hasError = true;
        }
        // check for uploaded images
        if (imageContainer.querySelectorAll('.uploaded-image').length < 3) {
            displayStatus('error', 'Please upload exactly 3 images');
            hasError = true;
        }
        // check location
        const latitude = document.querySelector('.latitude-box').textContent;
        const longitude = document.querySelector('.longitude-box').textContent;
        if (latitude === presetLat.toString() && longitude === presetLng.toString()) {
            displayStatus('error', 'Please select a valid location');
            hasError = true;
        }
        // check for selected bedrooms
        if(bedroomsEl.textContent === 'Select') {
            displayStatus('error', 'Please select the number of bedrooms'); 
            hasError = true;
        }
        // if no errors, submit the form
        if (!hasError) {
            const formData = new FormData();
            formData.append('title', titleInput.value);
            formData.append('description', descriptionInput.value);
            formData.append('price', priceInput.value);
            formData.append('lat', document.querySelector('.latitude-box').dataset.lat);
            formData.append('lng', document.querySelector('.longitude-box').dataset.lng);
            formData.append('bedrooms', bedroomsEl.textContent);
            formData.append('cover_index', coverIndex);
            // append images to formData
            images.forEach(img => {
                formData.append(`files[]`, img);
            });
            fetch('add_property.php', {
                method: 'POST', // Corrected typo: 'method' instead of 'mothod'
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    displayStatus('success', 'Property added successfully');
                    form.reset();
                    imageContainer.innerHTML = ''; // clear images
                    uploadBtn.classList.remove('inactive');
                    uploadInput.disabled = false;
                    form.querySelector('.charcount').classList.add('hidden');
                    coverIndex = 0; // reset cover index
                    bedroomsEl.textContent = 'Select'; // reset bedrooms selection
                    fetchProperties(); // refresh properties list
                }
                else {
                    displayStatus('error', 'An error occurred adding the property');
                    console.log(data.error);
                }
            })
            .catch(error => {
                displayStatus('error', 'An error occurred while submitting the form');
                console.log(error);
            });
        }
    });
}

// popup error messages
function showErrorPopup(message, input) {
    const popup = input.parentElement.nextElementSibling;
    popup.classList.remove('hidden');
    popup.textContent = message;
}
function hideErrorPopup(input) {
    const popup = input.parentElement.nextElementSibling;
    popup.classList.add('hidden');
}

export default addNewPpty;