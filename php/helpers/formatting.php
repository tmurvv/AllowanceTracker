<?php 

/*
*Format the date
*/

function formatDate($date) {
    //return date('F j, Y, g:i a',strtotime($date));
    return date('F j, Y',strtotime($date));
}

function formatDateHTMLInput($date) {
    return date('Y-m-d', strtotime($date));
}

function concatText($text) {
    return substr($text, 0, 350);
}

function completeMsg($msg) {
    
    switch ($msg) {
        case '':
            break;
        case 'deleted':
            $msg = 'Item Deleted';
            break;
        case 'added':
            $msg = 'Item Added Successfully';
            break;
        case 'updated':
            $msg = 'Item Updated Successfully';
            break;
        default:
            $msg = 'An error occurred';
            break;
    }
    return $msg;
}
