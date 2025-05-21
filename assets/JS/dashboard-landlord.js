import selectBox from "./Modules/select-box.js";
import scrollFunctions from "./Modules/scrollFunctions.js";
import modalListeners from "./Modules/modals.js";
import map from "./Modules/map.js";

window.addEventListener('DOMContentLoaded', function(){
    selectBox();
    scrollFunctions();
    map.mapInput();
    //select
    const modals = document.querySelectorAll('.modal');
    const openBtns = document.querySelectorAll('.open-modal');
    const closeBtns = document.querySelectorAll('.close-modal');
    modalListeners(modals, openBtns, closeBtns);
})