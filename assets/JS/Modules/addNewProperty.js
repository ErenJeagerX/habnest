function addNewPpty(){
    uploadedImages();
}

// uploaded images function
function uploadedImages(){
    const form = document.querySelector('#addNewPptyForm');
    const uploadBtn= document.querySelector('#upload-media');
    const imageContainer = form.querySelector('.imgs');
    
    uploadBtn.addEventListener('change', function(){
        const files = uploadBtn.files;
        for(let file of files) {
            const uploadedImg = document.createElement('div');
            uploadedImg.className = "uploaded-image";
            uploadedImg.innerHTML = `
            <img src="${URL.createObjectURL(file)}" alt="">      
            <div class="layer">      
                <div class="cover-btn">Set as cover</div>             
            </div>`
            imageContainer.appendChild(uploadedImg);
        }
        const coverBtns = document.querySelectorAll('.cover-btn');
    
        coverBtns.forEach(btn => {
            btn.addEventListener('click', function(){
                btn.parentElement.classList.add('active');
                console.log(btn.parentElement.classList);
                
            })
        })
    });
}

export default addNewPpty;