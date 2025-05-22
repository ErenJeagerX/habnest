import modalListeners from './modals.js';
import deleteLandlord from './deleteLandlord.js';
function fetchLandlords() {
    const landlordsTable = document.querySelector('.landlords_table');
    const tbody = landlordsTable.querySelector('.tbody');
    fetch('fetch-landlords.php')
    .then(res => res.json())
    .then(users => {
        tbody.innerHTML = '';
        displayUsers(tbody, users);
        initSearchInputListener(tbody, users);
        initModalListeners();
        initDeleteLandlordListeners();
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
                        <div class="action view-landlord" data-id="${user.id}">
                            <i class="fas fa-eye view-icon"></i>
                        </div>
                        <div class="action delete-landlord open-modal" data-modal="modal-delete-landlord" data-id="${user.id}" data-name="${user.first_name}">
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

// modal listeners

function initModalListeners(){
    const modals = document.querySelectorAll('.modal');
    const openBtns = document.querySelectorAll('.open-modal');
    const closeBtns = document.querySelectorAll('.close-modal');
    modalListeners(modals, openBtns, closeBtns);
}

// delete landlord
function initDeleteLandlordListeners() {
    const deleteLandlordBtns = document.querySelectorAll('.delete-landlord');
        deleteLandlordBtns.forEach(btn => {
            btn.addEventListener("click", function(){
                const modals = document.querySelectorAll('.modal');
                const currentId = btn.dataset.id;
                const currentName = btn.dataset.name;
                const modalLandlords = document.querySelector('.modal-delete-landlord');
                const deleteModal = modalLandlords.querySelector('.delete-modal');
                deleteModal.addEventListener('click', async function(){
                    if(currentId && currentName) {
                        const result = await deleteLandlord(currentId, currentName);
                        if(result) {
                            modals.forEach(modal => {
                                if(modal.classList.contains('active')) {
                                    modal.classList.remove('active');
                                }
                            })
                            fetchLandlords();
                        }
                        else {
                            modals.forEach(modal => {
                                if(modal.classList.contains('active')) {
                                    modal.classList.remove('active');
                                }
                            })
                            initModalListeners();
                        }
                    }
                });
            });
        });
}

export default fetchLandlords;