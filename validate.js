// create a function to validate html form
function validateForm() {
    var fname = document.forms["user_details"] ["first_name"].value;
    var lname = document.forms["user_details"] ["first_name"].value;
    var city = document.forms["user_details"] ["first_name"].value;
    // user_details is the name of the form
    if (fname == null || lname =="" || city ==""){
        alert("all details are required were not supplied");
        return false;
    }
    return true;
}