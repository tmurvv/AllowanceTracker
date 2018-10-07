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