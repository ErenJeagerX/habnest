import displayStatus from "./displayStatus.js";
import fetchProperties from "./fetchProperties.js";
function deletePropertyButtonListener(){
    const deletePptyModal = document.querySelector('.modal-delete-ppty');
    const deleteButton = deletePptyModal.querySelector('.delete-modal');

    deleteButton.addEventListener('click', function(){
        const propertyId = this.dataset.pptyId;
        fetch('delete_property.php',{
            method: 'POST',
            headers: {
                'Content-type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                'property_id': propertyId
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success){
                displayStatus('success', 'Property deleted successfully');
                fetchProperties(); // Refresh the property list
                deletePptyModal.classList.remove('active'); // Close the modal
            }
            else {
                displayStatus('error', 'Failed to delete property: ' + data.message);
            }
        })
    });
}

export default deletePropertyButtonListener;