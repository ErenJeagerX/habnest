function showHidePWD(){
    const showPwd = document.querySelector('#showPwd');
    const inputPwd = document.querySelector('#pwd');
    // show password
    inputPwd.addEventListener('input', function(){
     if(inputPwd.value) {
         showPwd.classList.remove('hidden');
     } else {
         showPwd.classList.add('hidden');
         showPwd.classList.replace('fa-eye', 'fa-eye-slash');
         inputPwd.setAttribute('type', 'password');
     }
    });
    showPwd.addEventListener('click', function(){
     if(inputPwd.getAttribute('type') === 'password') {
         showPwd.classList.replace('fa-eye-slash', 'fa-eye');
         inputPwd.setAttribute('type', 'text');
     } else {
         showPwd.classList.replace('fa-eye', 'fa-eye-slash');
         inputPwd.setAttribute('type', 'password');
     }
    });
};

export default showHidePWD;