//JavaScript file

"use strict";

function adminProtect() {
    var chances = 1;
    var pass1 = prompt('Please Enter Your Password',' ');
    while (chances < 7) {
        if (!pass1) {
            history.go(-1);
        }
        if (pass1.toLowerCase() == "admin4014") {
            //open admin window
            window.open("https://take2tech.ca/InnoTech/JobBoard/admin.php");
            break;
        } 
        chances+=1;
        var pass1 = 
        prompt('Password Incorrect, Please Try Again.','Password');
    }
    if (pass1.toLowerCase()!="password" && chances ==7) {
        history.go(-1);
    }
    return " ";
}  

function startEditSelector(clickedItem) {
    var item;
    var itemEdit;
    var amount;   
    var amountEdit;
    var transDate;
    var transDateEdit;
    var transType;
    var transTypeEdit;
    
    var cancelButton;
    var ancestorDiv;

    //define DOM elements
        
    ancestorDiv = clickedItem.parentElement.parentElement.parentElement;       
    item=ancestorDiv.nextElementSibling.children[2];
    itemEdit=ancestorDiv.nextElementSibling.children[3].children[0];
    amount=ancestorDiv.nextElementSibling.children[4];
    amountEdit=ancestorDiv.nextElementSibling.children[5].children[0];
    transDate=ancestorDiv.children[0];
    transDateEdit=ancestorDiv.children[1].children[0];
    transType=ancestorDiv.nextElementSibling.children[0];
    transTypeEdit=ancestorDiv.nextElementSibling.children[1].children[0];   
    
    if(clickedItem.innerHTML=="Edit") {
        //define DOM elements
        cancelButton=clickedItem.nextElementSibling;

        //reset edit field values
        itemEdit.value=item.innerText;
        amountEdit.value=amount.innerText;
        //transDateEdit.value=transDate.innerText;
        //transTypeEdit.value=transType.value;

        //hide original data fields / show edit fields       
        item.hidden=true;
        itemEdit.hidden=false;        
        amount.hidden=true;
        amountEdit.hidden=false;
        transDate.hidden=true;
        transDateEdit.hidden=false;
        transType.hidden=true;
        transTypeEdit.hidden=false;

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
        //transTypeEdit.value=transType.value;

        //show original data fields / hide edit fields       
        item.hidden=false;
        itemEdit.hidden=true;
        amount.hidden=false;
        amountEdit.hidden=true;
        transDate.hidden=false;
        transDateEdit.hidden=true;
        transType.hidden=false;
        transTypeEdit.hidden=true;

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