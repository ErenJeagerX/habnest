function formValidator(){
    //select elements
    const form = document.getElementById('add-landlords');
    const username = document.getElementById('username');
    const fName = document.getElementById('fName');
    const lName = document.getElementById('lName');
    const pwd = document.getElementById('pwd');
    const pNum = document.getElementById('pNum');

    let errors = {
        emptyInput: [],
        invalidNameInput: [],
        nameInputLengthError: [],
        passLengthError: false,
        invalidPNum: false,
        usernameLengthError: false,
        usernameTaken: false,
    };
    const noErrors = {
        emptyInput: [],
        invalidNameInput: [],
        nameInputLengthError: [],
        passLengthError: false,
        invalidPNum: false,
        usernameLengthError: false,
        usernameTaken: false,
    };

    // event listener
    form.addEventListener('submit', function(e){
        e.preventDefault();
        setBackToDefault();
        checkErrors();
        if(checkEquality(errors, noErrors)) {
            fetch('../includes/check-form_errors.php', {
                method: 'POST',
                headers: {
                    "Content-Type" : 'application/json'
                },
                body: JSON.stringify({
                    first_name: {
                        value : fName.value,
                        id : fName.id
                    },
                    last_name: {
                        value : lName.value,
                        id : lName.id
                    },
                    username: {
                        value : username.value,
                        id : username.id
                    },
                    pwd: {
                        value : pwd.value,
                        id : pwd.id
                    },
                    phone_number: {
                        value : pNum.value,
                        id : pNum.id
                    }
                })
            })
            .then(res => res.json())
            .then(data => {
                errors = {...data};
                if(!checkEquality(errors, noErrors)){
                    displayErrors();
                }
            })
        } else {
            displayErrors();
        }
    });

    // functions
    function checkErrors(){
        form.querySelectorAll('input').forEach(input => {
            if(!input.value) {
                errors.emptyInput.push(input.id);
            }
        });

        form.querySelectorAll('.nameInput').forEach(input => {
            if(!isPureString(input.value) && input.value) {
                errors.invalidNameInput.push(input.id);
            } else if(input.value.length < 3 && input.value){
                errors.nameInputLengthError.push(input.id)
            }
        });

        if(username.value.length < 4 && !errors.emptyInput.includes('username')) {
            errors.usernameLengthError = true;
        }

        if(pwd.value.length < 8 && !errors.emptyInput.includes('pwd')) {
            errors.passLengthError = true;
        }

        if((!isPureNum(pNum.value) || pNum.value.length !== 10) && pNum.value) {
            errors.invalidPNum = true;
        }
    }
    // set back to default
    function setBackToDefault() {
        errors.emptyInput = []
        errors.invalidNameInput = [];
        errors.nameInputLengthError = [];
        errors.passLengthError = false;
        errors.invalidPNum = false;
        errors.usernameTaken = false;
        errors.usernameLengthError = false;
    };
    // displayErrors
    function displayErrors(){
        // empty inputs
        form.querySelectorAll('input').forEach(input => {
            const error = new ErrorMsg(`${input.dataset.name} can't be empty`, 'emptyInput', input);
            if(errors.emptyInput.includes(input.id)){
                error.showMsg();
                input.addEventListener('input', function(){
                    if(input.value){
                        error.hideMsg('emptyInput');
                        input.classList.remove('errorMode');
                    } else {
                        error.showMsg();
                    }
                })
            }
        });
        // pwd length
        if(errors.passLengthError) {
            const error = new ErrorMsg("Password must at least be 8 characters", 'length', pwd);
            error.showMsg();
            pwd.addEventListener('input', function(){
                if(pwd.value.length >= 8 || !pwd.value) {
                    error.hideMsg('length');
                    pwd.classList.remove('errorMode');
                } else {
                    error.showMsg();
                }
            });
        }
        // invalid name input
        form.querySelectorAll('.nameInput').forEach(input => {
            if(errors.invalidNameInput.includes(input.id)){
                const error = new ErrorMsg(`${input.dataset.name} must contain only letters`, 'invalidInput', input);
                error.showMsg();
                input.addEventListener('input', function(){
                    if(isPureString(input.value) || !input.value){
                        error.hideMsg('invalidInput');
                        input.classList.remove('errorMode');
                    } else {
                        error.showMsg();
                    }
                })
            }
        })
        // name input length
        form.querySelectorAll('.nameInput').forEach(input => {
            if(errors.nameInputLengthError.includes(input.id)){
                const error = new ErrorMsg(`${input.dataset.name} must at least be 3 characters`, 'invalidInput', input);
                error.showMsg();
                input.addEventListener('input', function(){
                    if(input.value.length >= 3 || !input.value){
                        error.hideMsg('invalidInput');
                        input.classList.remove('errorMode');
                    } else {
                        error.showMsg();
                    }
                })
            }
        })
        // username length
        if(errors.usernameLengthError) {
            const error = new ErrorMsg("Username must at least be 4 characters", 'length', username);
            error.showMsg();
            username.addEventListener('input', function(){
                if(username.value.length >= 4 || !username.value) {
                    error.hideMsg('length');
                    username.classList.remove('errorMode');
                } else {
                    error.showMsg();
                }
            })
        }
        // invalid pNum
        if(errors.invalidPNum) {
            const error = new ErrorMsg('Please enter a correct phone number', 'invalidInput', pNum);
            error.showMsg();
            pNum.addEventListener('input', function(){
                if((isPureNum(pNum.value) && pNum.value.length === 10) || !pNum.value) {
                    error.hideMsg('invalidInput');
                    pNum.classList.remove('errorMode');
                } else {
                    error.showMsg();
                }
            })
        }
        // username Taken
        if(errors.usernameTaken){
            const error = new ErrorMsg('Username taken, try another one', 'invalidInput', username);
            error.showMsg();
            username.addEventListener('input', function(){
                error.hideMsg('invalidInput');
            })
        }
    };
    // showErrorMsg
    function ErrorMsg(msg, errType, input) {
        this.msg = msg;
        this.errType = errType;
        this.input = input;
        this.showMsg = () => {
        [...this.input.parentElement.nextElementSibling.children].forEach(child => {
            if(child.dataset.error === errType) {
                child.textContent = msg;
            }
            input.classList.add('errorMode');
        });
        this.hideMsg = (type) => {
            [...this.input.parentElement.nextElementSibling.children].forEach(child => {
                if(child.textContent){
                    if(child.dataset.error === type) {
                        child.textContent = '';
                    }
                }
            });
        }
        }
    }
    // check objects equality 
    function checkEquality(obj1, obj2) {
        return JSON.stringify(obj1) === JSON.stringify(obj2);
    }
    // regex functions
    function isPureString(str) {
        return /^[A-Za-z]+$/.test(str);
    }

    function isPureNum(str) {
        return /^[0-9]+$/.test(str);
    }
}

export default formValidator;