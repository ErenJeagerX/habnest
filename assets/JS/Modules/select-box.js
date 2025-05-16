function selectBox(){
    const selectBoxes = document.querySelectorAll('.select');

    selectBoxes.forEach(box => {
        const optionsContainer = box.querySelector('.options');
        const options = box.querySelectorAll('.option')
        const selected = box.querySelector('.selected');

        selected.addEventListener('click', function(e){
            document.querySelectorAll('.options').forEach(opt => {
                if(opt !== optionsContainer) {
                    opt.classList.remove('open'); // if there are any other options opened, they get closed
                }
            });
            options.forEach(option => {
                if(box.querySelector('.selected_text').textContent !== option.textContent){
                    option.classList.remove('hidden'); //if an option is not selected, it gets displayed in the options container
                }
            });
            optionsContainer.classList.toggle('open');
        });

        options.forEach(option => {
            option.addEventListener('click', function(){
                selected.querySelector('.selected_text').textContent = option.textContent;
                optionsContainer.classList.remove('open');
                option.classList.add('hidden');
            })
        });

        document.body.addEventListener('click', function(e){
            if(!e.target.closest('.select')) { // if clicked outside a selectbox
                optionsContainer.classList.remove('open');
            }
        });

    })
}

export default selectBox;