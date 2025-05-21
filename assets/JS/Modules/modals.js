function modalListeners(modals, openBtns, closeBtns){
        openBtns.forEach(openBtn => {
            openBtn.addEventListener('click', function(){
                modals.forEach(modal => {
                    if(modal.classList.contains(openBtn.dataset.modal)){
                        modal.classList.add('active');
                    }
                })
            })
        });

        closeBtns.forEach(closeBtn => {
            closeBtn.addEventListener('click', function(){
                modals.forEach(modal => {
                    if(modal.classList.contains(closeBtn.dataset.modal)){
                        modal.classList.remove('active');
                    }
                })
            })
        });
    }

export default modalListeners;