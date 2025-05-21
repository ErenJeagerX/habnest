import displayStatus from "./displayStatus.js";
async function deleteLandlord(id, first_name){
    return fetch('delete-landlords.php', {
        method: 'POST',
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({id, first_name})
    })
    .then(res => res.json())
    .then(res => {
        if(res.success) {
            displayStatus('success', 'Landlord deleted successfully');
            return true;
        } else if(res.error) {
            displayStatus('error', `Error occurred deleting landlord ${res.first_name}`);
            return false;
        }
    })
}

export default deleteLandlord;