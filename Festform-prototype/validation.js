// formcheck

// Tjekker om inputs er udfyldt med appropiate data type, skriver en validation besked, tilføjer invalid klassen
const checkInputs = (form)=>{
    let inputsValid = true;
    const subGroups = form.querySelectorAll('.sub-group, .requiredCheck');
    subGroups.forEach(subGroup =>{
        const input = subGroup.querySelector('input');
        const valMessage = subGroup.querySelector('.validation-message');
        if(input.checkValidity()){
            valMessage.classList.remove("invalid");
            input.classList.remove("invalid");
            valMessage.innerHTML = '';
        }
        else{
            valMessage.classList.add("invalid");
            input.classList.add("invalid");
            valMessage.innerHTML = input.validationMessage;
            inputsValid = false;
        }
    });
    if(checkShiftTable() == false){
        inputsValid = false;
    }
    return inputsValid;
};

// Sikre at der er valgt vagtønsker fra skemaet, eller at noshifts checkboxen er afkrydset
const checkShiftTable = ()=>{
    let inputsValid = true;
    const selectedShifts = [];

    document.querySelectorAll('.shift-table td.isSelected').forEach(cell =>{
        const shiftTime = cell.innerHTML;
        const shiftDay = cell.dataset.day;
        const selectedShift = {shiftDay: shiftDay, shiftTime: shiftTime};
        selectedShifts.push(selectedShift);
    });

    const selectedShiftsJson = JSON.stringify(selectedShifts);
    const hiddenInput = document.querySelector('.selectedShifts');
    hiddenInput.value = selectedShiftsJson;

    const noShifts = document.querySelector('.noShifts');
    const noShiftsCheckbox = noShifts.querySelector('input');
    const customValidationMSG = noShifts.querySelector('.validation-message');
    
    if(selectedShifts.length === 0){
        if(noShiftsCheckbox.checked == false){
            customValidationMSG.innerHTML = "Bekræft venligst at du ikke har nogle vagtønsker.";
            customValidationMSG.classList.add("invalid");
            inputsValid = false;
        }else{
            customValidationMSG.innerHTML = '';
            customValidationMSG.classList.remove("invalid");

        }
    }else{
        if(noShiftsCheckbox.checked == true){
            customValidationMSG.innerHTML = "Afkryds ikke her hvis du har vagtønsker";
            customValidationMSG.classList.add("invalid");
            inputsValid = false;
        }else{
            customValidationMSG.innerHTML = '';
            customValidationMSG.classList.remove("invalid");

        }
    }
    return inputsValid;
};


// Forhindre formularen i at blive sendt og siden i at reloade
document.querySelectorAll('.formgroup').forEach(form =>{
    form.addEventListener('submit', (event) =>{
        const checkInputsResult = checkInputs(form);
        if(!checkInputsResult){
            event.preventDefault();
        } 
    });
});
