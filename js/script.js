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
    var itemOrder;
    var itemEdit;
    var itemOrderEdit;
    var cancelButton;
    
    if(clickedItem.innerHTML=="Edit") {
        //define DOM elements
        item=clickedItem.parentElement.previousElementSibling.children[0];
        itemOrder=item.parentElement.previousElementSibling.children[0];
        itemEdit=clickedItem.parentElement.previousElementSibling.children[1];
        itemOrderEdit=item.parentElement.previousElementSibling.children[1];
        cancelButton=clickedItem.parentElement.nextElementSibling.children[0];

        //confirm edit
        if(!confirm("Editing a " + item.name + " will cause all job listings with that " + item.name + " to be unsearchable by that " + item.name + ". You may wish to add a new " + item.name + " instead.")){
            return;
        }

        //reset edit field values
        itemEdit.value=item.value;
        itemOrderEdit.value=itemOrder.value;

        //show edit fields / hide original data fields
        item.hidden=true;
        itemOrder.hidden=true;
        itemEdit.hidden=false;
        itemOrderEdit.hidden=false;

        //change button text and style
        clickedItem.innerHTML="Save";
        cancelButton.innerHTML="Cancel";
        cancelButton.style="background-color:yellow;color:#333";
        
        return;
    }

    if(clickedItem.innerHTML=="Cancel"){
        //define DOM elements
        item=clickedItem.parentElement.previousElementSibling.previousElementSibling.children[0];
        itemOrder=clickedItem.parentElement.previousElementSibling.previousElementSibling.previousElementSibling.children[0];
        itemEdit=clickedItem.parentElement.previousElementSibling.previousElementSibling.children[1];
        itemOrderEdit=clickedItem.parentElement.previousElementSibling.previousElementSibling.previousElementSibling.children[1];
        cancelButton=clickedItem;

        //reset edit fields values
        itemEdit.value=item.value;
        itemOrderEdit.value=itemOrder.value;

        //show original data fields / hide edit fields
        itemOrder.hidden=false;
        itemOrderEdit.hidden=true;
        item.hidden=false;
        itemEdit.hidden=true;
        clickedItem.parentElement.previousElementSibling.children[0].innerHTML="Edit";
        cancelButton.innerHTML="Delete";
        cancelButton.style="background-color:red;color:#fff";
        return;       
    }
    if(clickedItem.innerHTML=="Delete"){
        if(!confirm("Delete Item?")) {
            return;
        }
        clickedItem.type="submit";
    }
    

    if(clickedItem.innerHTML=="Save"){
        //define DOM elements
        item=clickedItem.parentElement.previousElementSibling.children[0];
        itemOrder=item.parentElement.previousElementSibling.children[0];
        itemEdit=clickedItem.parentElement.previousElementSibling.children[1];
        itemOrderEdit=item.parentElement.previousElementSibling.children[1];
        cancelButton=clickedItem.parentElement.nextElementSibling.children[0];

        //change original data to new edit data
        item.value=itemEdit.value;
        itemOrder.value=itemOrderEdit.value;

        //show original data fields / hide edit fields
        item.hidden=false;
        itemOrder.hidden=false;
        itemEdit.hidden=true;
        itemOrderEdit.hidden=true;

        //change text and style of buttons
        cancelButton.innerHTML="Delete";
        cancelButton.style="background-color:red;color:#fff";
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