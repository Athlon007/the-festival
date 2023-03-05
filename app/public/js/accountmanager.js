//Save changes button
var saveChangesButton = document.getElementById("saveChangesButton");

function enableSaveChanges(){
    saveChangesButton.disabled = false;
}

function disableSaveChanges(){
    saveChangesButton.disabled = true;
}

function addressChange(){
    enableSaveChanges();
}

function updateAccount(userId){
    
}