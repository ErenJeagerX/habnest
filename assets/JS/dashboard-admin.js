import selectBox from "./Modules/select-box.js";
import scrollFunctions from "./Modules/scrollFunctions.js";
import modals from "./Modules/modals.js";
import showHidePWD from "./Modules/showHidePWD.js";
import formValidator from "./Modules/formValidator.js";

window.addEventListener('DOMContentLoaded', function(){
    selectBox();
    scrollFunctions();
    modals();
    showHidePWD();
    formValidator();
})