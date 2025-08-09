import selectBox from "./Modules/select-box.js";
import scrollFunctions from "./Modules/scrollFunctions.js";
import showHidePWD from "./Modules/showHidePWD.js";
import formFunctions from "./Modules/formFunctions.js";
import fetchLandlords from "./Modules/fetchLandlords.JS";
import fetchAllProperties from "./Modules/fetchAllProperties.js";

window.addEventListener('DOMContentLoaded', function(){
    selectBox();
    scrollFunctions();
    showHidePWD();
    formFunctions();
    fetchAllProperties();
    fetchLandlords();
})