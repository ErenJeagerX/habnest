import selectBox from "./Modules/select-box.js";
import scrollFunctions from "./Modules/scrollFunctions.js";
import modalListeners from "./Modules/modals.js";
import map from "./Modules/map.js";
import addNewPpty from "./Modules/addNewProperty.js";
import fetchProperties from "./Modules/fetchProperties.js";

window.addEventListener('DOMContentLoaded', function(){
    selectBox();
    scrollFunctions();
    fetchProperties();
    map.mapInput();
    addNewPpty();
    //select
    const modals = document.querySelectorAll('.modal');
    const openBtns = document.querySelectorAll('.open-modal');
    const closeBtns = document.querySelectorAll('.close-modal');
    modalListeners(modals, openBtns, closeBtns);
})