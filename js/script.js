//JavaScript file

"use strict";  

/***********************
 * ONLOAD functions
 * ********************/
window.onload = function() {
    if (window.location.href.match('index.php') != null) {
        insertTodayDateHTML();
        insertTodayTimeHTML();
    }  
}

function insertTodayDateHTML() {
    //declare/define variables
    var htmlDate;
    var todayDate = new Date();    
    var todayMonth = todayDate.getMonth() + 1;
    var todayDay = todayDate.getDate();

    //prepend zeros to months and days
    if (todayMonth < 10) {
        todayMonth = "0" + todayMonth;
    }
    if (todayDay < 10) {
        todayDay = "0" + todayDay;
    }

    //format for html
    htmlDate = todayDate.getFullYear();
    htmlDate += "-";
    htmlDate += todayMonth;
    htmlDate += "-";
    htmlDate += todayDay;
    
    //change in DOM element
    document.getElementById('js--addTransDate').value = htmlDate;
}
function insertTodayTimeHTML() {
    //declare/define variables
    var htmlTime;
    var todayDate = new Date();   
    var todayHours = todayDate.getHours();
    var todayMinutes = todayDate.getMinutes();

    //prepend zeros to hours & minutes
    if (todayHours < 10) {
        todayHours = "0" + todayHours;
    }
    if (todayMinutes < 10) {
        todayMinutes = "0" + todayMinutes;
    }

    //format date for HTML
    htmlTime = todayHours;
    htmlTime += ":";
    htmlTime += todayMinutes;
    
    //change DOM element
    document.getElementById('js--addTransTime').value = htmlTime;
}

/***********************
 * CRUD operations on Transactions
 * ********************/

function checkMinusSign(changedItem) {
    var addTransType = document.getElementById("js--addTransType").value;
    var addTransAmount = document.getElementById("js--addTransAmount").value;
    
    if (addTransType == "Deposit" && addTransAmount < 0) {
        alert("A deposit must be a positive number.");
    }
    if (addTransType == "Withdrawal" && addTransAmount > 0) {
        alert("A withdrawal must be a negative number. Please start with a minus sign.");
    }
}

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
        if (isDefault.children[1].checked == true) {
            alert("Can not delete default PiggyBank. Please choose another default PiggyBank or add a new default PiggyBank before deleting.");
            return;
        }
        if(!confirm("Delete Item?")) {
            return;
        }
        clickedItem.type="submit";
        return;
    }
    

    if(clickedItem.innerHTML=="Save"){
        //define DOM elements
        cancelButton=clickedItem.nextElementSibling;
        
        //enable checkbox for php POST variable value check
        isDefault.children[1].disabled = false;

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

/***********************
 * Mobile Navigation
 * ********************/
function mobileNav() {
    var mainNav = document.getElementById("js--mainNav");
    var mobileIcon = document.getElementById("js--mobileNavIcon");
    
    if (mobileIcon.classList.contains('fa-bars')) {
        mobileIcon.classList.remove('fa-bars');
        mobileIcon.classList.add('fa-window-close');
        mainNav.style.display = "block";
    }else{
        mobileIcon.classList.remove('fa-window-close');
        mobileIcon.classList.add('fa-bars');
        mainNav.style.display = "none";
    }
    
} 


// $(document).ready(function() {
//     /* Mobile navigation */
//     $('.js--mainNav-icon').click(function() {
//         var nav = $('.js--mainNav');
//         var icon = $('#js--mainNav-icon');
        
//         nav.slideToggle(200, function() {
//             if (nav.is(":hidden")) {
//                 nav.removeAttr("style");               
//             }
//         });

//         if (icon.hasClass('fa-bars')) {
//             icon.addClass('fa-window-close');
//             icon.removeClass('fa-bars');
//         } else {
//             icon.addClass('fa-bars');
//             icon.removeClass('fa-window-close');           
//         }             
//     });
// });