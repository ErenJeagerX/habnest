import modalListeners from './modals.js';
function fetchLandlords() {
    const landlordsTable = document.querySelector('.landlords_table');
    const tbody = landlordsTable.querySelector('.tbody');
    fetch('fetch-landlords.php')
    .then(res => res.json())
    .then(users => {
        displayUsers(tbody, users);
        initSearchInputListener(tbody, users);
        const modals = document.querySelectorAll('.modal');
        const openBtns = document.querySelectorAll('.open-modal');
        const closeBtns = document.querySelectorAll('.close-modal');
        modalListeners(modals, openBtns, closeBtns);
    });
}

// display landlords
function displayUsers(parent, usersArray) { 
    usersArray.forEach(user => {
        parent.innerHTML += `
                <div class="row">
                    <div class="landlord_name_and_pfp">
                        <img src="../${user.profile_pic}" alt="Landlord ${user.id} pfp" class="landlord_pfp">
                        <p class="landlord_name">${user.first_name} ${user.last_name}</p>
                    </div>
                    <p class="phone_number">${user.phone_number}</p>
                    <p class="properties_count">2</p>
                    <p class="last_active">2025-09-08</p>
                    <div class="actions">
                        <div class="action view-landlord">
                            <i class="fas fa-eye view-icon"></i>
                        </div>
                        <div class="action delete-landlord open-modal" data-modal="modal-delete-landlord">
                            <i class="fas fa-trash delete-icon"></i>
                        </div>
                    </div>
                </div> `;
    })
};

// search Landlords

function initSearchInputListener(parent, usersArray){
    const input = document.querySelector('#searchLandlords');

    input.addEventListener('input', function(){
        const filteredUsers = usersArray.filter(user => user.first_name.toLowerCase().includes(input.value.toLowerCase()) || user.last_name.toLowerCase().includes(input.value.toLowerCase()));
        parent.innerHTML = '';
        displayUsers(parent, filteredUsers);
    });
}

export default fetchLandlords;