import displayStatus from "./displayStatus.js";
function slideToggleBtn(btn){
    btn.addEventListener('click', function(){
        if(!btn.classList.contains('active')){
            btn.classList.add('active');
            btn.previousElementSibling.textContent = 'Available';
            btn.parentElement.dataset.status = 'available';
            fetch(`change_status.php?id=${btn.dataset.ppty}&status=rented`)
            .then(res => res.json())
            .then(res => {
                if(res.success){
                    return;
                }
                else {
                    btn.classList.remove('active');
                    btn.previousElementSibling.textContent = 'Rented';
                    btn.parentElement.dataset.status = 'rented';
                    displayStatus('error', 'The Server is busy');
                }
            })
        }
        else {
            btn.classList.remove('active');
            btn.previousElementSibling.textContent = 'Rented';
            btn.parentElement.dataset.status = 'rented';
            fetch(`change_status.php?id=${btn.dataset.ppty}&status=available`)
            .then(res => res.json())
            .then(res => {
                if(res.success){
                    return;
                }
                else {
                    btn.classList.add('active');
                    btn.previousElementSibling.textContent = 'Available';
                    btn.parentElement.dataset.status = 'available';
                    displayStatus('error', 'The Server is busy');
                }
            })
        }
    })
}

export default slideToggleBtn;