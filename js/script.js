//JavaScript file

"use strict";  

/***********************
 * Switch Piggy Banks
 * ********************/
function switchPiggyBank(clickedItem) {
   var switchPiggyDropDown = document.getElementById('js--switchPiggyName');
    switchPiggyDropDown.hidden = false;
    clickedItem.innerText = "Change PiggyBanks";
    clickedItem.type = "submit";
}

/***********************
 * CRUD operations on Transactions
 * ********************/
function startEditTransaction(clickedItem) {

    var item;
    var itemEdit;
    var amount;   
    var amountEdit;
    var transRawDateTime;
    var transDate;
    var transDateEdit;
    var transTimeEdit;
    var transType;
    var transTypeEdit;
    var transTypeSelected;
    
    var cancelButton;
    var ancestorDiv;

    //define DOM elements
        
    ancestorDiv = clickedItem.parentElement.parentElement;  
      
    item=ancestorDiv.nextElementSibling.children[2].children[0];   
    itemEdit=ancestorDiv.nextElementSibling.children[2].children[1]; 
    amount=ancestorDiv.nextElementSibling.children[3]; 
    amountEdit=ancestorDiv.nextElementSibling.children[4];
    transRawDateTime=ancestorDiv.children[3];
    transRawDateTime.style.backgroundColor="tomato";
    transDate=ancestorDiv.children[0];
    transDateEdit=ancestorDiv.children[1].children[0];
    transTimeEdit=ancestorDiv.children[1].children[1];
    transType=ancestorDiv.nextElementSibling.children[0];
    transTypeEdit=ancestorDiv.nextElementSibling.children[1].children[0];
    transTypeSelected=transTypeEdit.selectedIndex;
    
    if(clickedItem.innerHTML=="Edit") {
        //define DOM elements
        cancelButton=clickedItem.nextElementSibling;

        //convert Javascript dateObject to HTML date format -- REFACTOR to function
        var transDateObject = new Date(transRawDateTime.innerText);
        var month = transDateObject.getMonth()+1;
        var day = transDateObject.getDate();   
        var hour = transDateObject.getHours();
        var minute = transDateObject.getMinutes();  
        var second = transDateObject.getSeconds();  
        month < 10 == true ? month = "0" + month : month = month;
        day < 10 == true ? day = "0" + day : day = day;
        hour < 10 == true ? hour = "0" + hour : hour = hour;
        minute < 10 == true ? minute = "0" + minute : minute = minute;
        second < 10 == true ? second = "0" + second : second = second;

        //reset edit field values
        itemEdit.children[0].value=item.innerText;
        amountEdit.children[0].value=amount.innerText;
        transDateEdit.value=transDateObject.getFullYear()+'-' + month + '-' + day;
        transTimeEdit.value=hour+":"+minute+":"+second;
        transTypeEdit.value=transType.innerText.trim();
        transTypeEdit.selectedIndex=transTypeSelected;

        //hide original data fields / show edit fields       
        item.hidden=true;
        itemEdit.hidden=false;
        itemEdit.children[0].style.fontSize="50%";   
        itemEdit.children[0].style.width="90%";   
        amount.hidden=true;
        amountEdit.hidden=false;
        transDate.hidden=true;
        transDateEdit.hidden=false;
        transTimeEdit.hidden=false;
        transType.style.display = "none";
        transTypeEdit.style.display="block";
        transTypeEdit.parentElement.classList.add('btn');
        transTypeEdit.parentElement.classList.add('btn__primary');
        transTypeEdit.parentElement.classList.add('transactions__lineItem--line2-type');


        //change button text and style
        clickedItem.innerHTML="Save";
        cancelButton.innerHTML="Cancel";
        cancelButton.style="background-color:yellow;color:#333";
        
        return;
    }

    if(clickedItem.innerHTML=="Cancel"){
        //define DOM elements
        cancelButton=clickedItem;

        //reset edit fields values
        itemEdit.value=item.innerText;
        amountEdit.value=amount.innerText;
        transDateEdit.value=transDate.innerText;
        transTypeEdit.value=transType.value;
        transTypeEdit.selectedIndex=transTypeSelected;

        //show original data fields / hide edit fields       
        item.hidden=false;
        itemEdit.hidden=true;
        amount.hidden=false;
        amountEdit.hidden=true;
        transDate.hidden=false;
        transDateEdit.hidden=true;
        transTimeEdit.hidden=true;
        transType.style.display = "block";
        transTypeEdit.style.display="none";
        transTypeEdit.parentElement.classList.remove('btn');
        transTypeEdit.parentElement.classList.remove('btn__primary');
        transTypeEdit.parentElement.classList.remove('transactions__lineItem--line2-type');

        //change button text and style
        clickedItem.previousElementSibling.innerHTML="Edit";
        cancelButton.innerHTML="Delete";
        cancelButton.style="background-color:#A43C3D;color:#eee";
    
        return;       
    }
    if(clickedItem.innerHTML=="Delete"){
        if(!confirm("Delete Item?")) {
            return;
        }
        clickedItem.type="submit";
        return;
    }
    

    if(clickedItem.innerHTML=="Save"){
        //define DOM elements
        cancelButton=clickedItem.nextElementSibling;
        
        //change text and style of buttons
        cancelButton.innerHTML="Delete";
        cancelButton.style="background-color:#A43C3D;color:#eee";
        clickedItem.innerHTML="Edit";
        clickedItem.type="submit";  
    }     
}

/***********************
 * CRUD operations on Piggy Banks
 * ********************/

function startEditPiggyBanks(clickedItem) {
    //declare variables

    var piggyBankName;
    var piggyBankNameEdit;
    var piggyBankOwner;
    var piggyBankOwnerEdit;
    var isDefault;
    var isDefaultEdit;
    
    var cancelButton;
    var ancestorDiv;

    //define DOM elements
        
    ancestorDiv = clickedItem.parentElement.parentElement;  
      
    piggyBankName = ancestorDiv.children[0];
    piggyBankNameEdit = ancestorDiv.children[1];
    piggyBankOwner = ancestorDiv.children[2];
    piggyBankOwnerEdit = ancestorDiv.children[3];
    isDefault = ancestorDiv.children[4];
    isDefaultEdit = ancestorDiv.children[5];
    
    if(clickedItem.innerHTML=="Edit") {
        //define DOM elements
        cancelButton=clickedItem.nextElementSibling;
   
        //reset edit field values
        piggyBankNameEdit.children[0].value=piggyBankName.innerText;
        piggyBankOwnerEdit.children[0].value=piggyBankOwner.innerText;
        isDefaultEdit.children[0].value=isDefault.children[1].value; 

        //hide original data fields / show edit fields 
    
        piggyBankName.hidden = true;
        piggyBankNameEdit.hidden = false;
        piggyBankOwner.hidden = true;
        piggyBankOwnerEdit.hidden = false;
        isDefault.hidden = true;
        isDefaultEdit.hidden = false;
    
        //change button text and style
        clickedItem.innerHTML="Save";
        cancelButton.innerHTML="Cancel";
        cancelButton.style="background-color:yellow;color:#333";
        
        return;
    }

    if(clickedItem.innerHTML=="Cancel"){
        //define DOM elements
        cancelButton=clickedItem;

        //reset edit fields values
        piggyBankNameEdit.children[0].value=piggyBankName.innerText;
        piggyBankOwnerEdit.children[0].value=piggyBankOwner.innerText;
        isDefaultEdit.children[1].value=isDefault.value;

        //show original data fields / hide edit fields       
        piggyBankName.hidden = false;
        piggyBankNameEdit.hidden = true;
        piggyBankOwner.hidden = false;
        piggyBankOwnerEdit.hidden = true;
        isDefault.hidden = false;
        isDefaultEdit.hidden = true;
        isDefault.children[1].disabled = true;

        //change button text and style
        clickedItem.previousElementSibling.innerHTML="Edit";
        cancelButton.innerHTML="Delete";
        cancelButton.style="background-color:#A43C3D;color:#eee";
    
        return;       
    }
    if(clickedItem.innerHTML=="Delete"){
        if(!confirm("Delete Item?")) {
            return;
        }
        clickedItem.type="submit";
        return;
    }
    

    if(clickedItem.innerHTML=="Save"){
        //define DOM elements
        cancelButton=clickedItem.nextElementSibling;
        
        //change text and style of buttons
        cancelButton.innerHTML="Delete";
        cancelButton.style="background-color:#A43C3D;color:#eee";
        clickedItem.innerHTML="Edit";
        clickedItem.type="submit";  
    }     
}

/***********************
 * CRUD operations on profiles
 * ********************/

function startChangeEmail(clickedItem) {
   
    var emailInput;
    var originalEmail;
    var changeSaveEmailButton;
    var cancelChangeEmailButton;

    emailInput = document.getElementById('js--emailInput');
    originalEmail = document.getElementById('js--profileOriginalEmail');
    changeSaveEmailButton = document.getElementById('js--profileChangeSaveEmail');
    cancelChangeEmailButton = document.getElementById('js--profileCancelEmail');

    if (clickedItem.innerText == "Change Email") { 
        emailInput.hidden = false;
        cancelChangeEmailButton.hidden = false;
        clickedItem.innerText = "Save";

    } else if (clickedItem.innerText == "Save") {
        emailInput.hidden = true;
        cancelChangeEmailButton.hidden = true;
        clickedItem.innerText = "Change Email";
        originalEmail.innerText=emailInput.children[1].value;
        changeSaveEmailButton.type = 'Submit';
        
    } else if (clickedItem.innerText == "Cancel") {
        emailInput.children[1].value = "";
        emailInput.hidden = true;
        cancelChangeEmailButton.hidden = true;
        changeSaveEmailButton.innerText = "Change Email";
        return;
    }
}
function startChangePassword(clickedItem) {
   
    var changePassword;
    var newPassword;
    var changePasswordButton;
    var cancelPasswordButton;

    changePassword = document.getElementById('js--profileChangePassword');
    newPassword = document.getElementById('js--profileNewPassword');
    changePasswordButton = document.getElementById('js--profileChangePasswordButton');
    cancelPasswordButton = document.getElementById('js--profileCancelPasswordButton');
    
    if (clickedItem.innerText == "Change Password") { 
        changePassword.hidden = false;
        cancelPasswordButton.hidden = false;
        clickedItem.innerText = "Save";

    } else if (clickedItem.innerText == "Save") {
        changePassword.hidden = true;
        cancelPasswordButton.hidden = true;
        clickedItem.innerText = "Change Password";
        document.getElementById('js--profileOriginalPassword').innerText=newPassword.value;
        changePasswordButton.type = 'Submit';
        return;

    } else if (clickedItem.innerText == "Cancel") {
        changePassword.children[0].value = "";
        changePassword.children[1].value = "";
        changePassword.children[2].value = "";
        changePassword.hidden = true;
        cancelPasswordButton.hidden = true;
        changePasswordButton.innerText = "Change Password";
        return;
    }
}
function startCloseAccount(clickedItem, userEmail) {
    
    if (clickedItem.innerText == "Close Account") { 
        var yesNo = prompt('Close Account? Are you sure? This will delete your user account and all associated Piggy Banks and transactions. Please type your account email below to close the account.');
        if (!(yesNo == null) && !(yesNo =='')) {
            if (yesNo.toUpperCase() == userEmail.toUpperCase()) {
                clickedItem.type = 'submit';
            }else{
                alert("The email entered does not match the email associated with this account. Account has not been closed.");
            }
        }
    }  
}

$(document).ready(function() {
    /* Mobile navigation */
    $('.js--mainNav-icon').click(function() {
        var nav = $('.js--mainNav');
        var icon = $('.js--mainNav-icon i');
        
        nav.slideToggle(200, function() {
            if (nav.is(":hidden")) {
                nav.removeAttr("style");               
            }
        });

        if (icon.hasClass('fa-bars')) {
            icon.addClass('fa-window-close');
            icon.removeClass('fa-bars');
        } else {
            icon.addClass('fa-bars');
            icon.removeClass('fa-window-close');           
        }             
    });
});