function displayStatus(status, msg){
    const statusEl = document.querySelector('.status'); 
    statusEl.classList.remove('error');
    statusEl.classList.remove('success');
    statusEl.classList.add(status);
    if(status === 'success') {
        statusEl.innerHTML = `
        <i class="fas fa-check"></i>
        <p>${msg}</p>
        `
    } else if(status === 'error') {
        statusEl.innerHTML = `
        <i class="fas fa-exclamation-circle"></i>
        <p>${msg}</p>
        `
    }
    setTimeout(() => {
        statusEl.innerHTML = '';
        statusEl.classList.remove(status);
    }, 2500);
}

export default displayStatus;