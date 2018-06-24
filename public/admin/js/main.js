var loc = window.location.pathname;
var dir = loc.split('/');


function verify() {

    var form = document.getElementById("login-form");
    var username = form.username.value;
    var password = form.password.value;
    var email = form.email.value;
    var info = document.getElementsByClassName('info');
    var user_regExp = /[a-zA-ZąćęłńóśźżĄĘŁŃÓŚŹŻ]{3,}/;
    var pass_regExp = /.{4,20}/;
    var email_regExp = /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
    var errors = {
                    'username': '',
                    'password': '',
                    'email': ''
                };


    if (username == " " || username == null || !user_regExp.test(username)) {
        info[0].style.color = "red";
        errors['username'] = "Please fill username with at least 2 characters";
        info[0].innerHTML = errors['username'];
    } else  info[0].innerHTML = " ";
    
    if (email == " " || email == null || !email_regExp.test(email)) {
        info[1].style.color = "red";
        errors['email'] = "Empty email or invalid syntax";
        info[1].innerHTML = errors['email'];
    } else info[1].innerHTML = " ";


    if (password == " " || password == null || !pass_regExp.test(password)) {
        info[2].style.color = "red";
        errors.password = "Empty password or to short";
        info[2].innerHTML = errors.password;
    } else info[2].innerHTML = " ";

    var i = 0;

    for (var key in errors) {
        if (errors[key] != "") i++;
    }

    if (i != 0) return false; else return true;
}





$(document).ready(function () {
    $("#sidenavToggler").click(function () {
        $("#exampleAccordion").toggle('slow');
    });

});


$('.deleteModal').click(function (e) {
    e.preventDefault();
    var id = $(this).attr('rel');

    $('#myModal').modal('show');
    $('.btnDelete').click(function () {
        console.log(dir[1]);
        //dir[2] - controller; dir[1] - glowny folder
        window.location.href = '/' + dir[1] + '/' + dir[2] + '/destroy/' + id;
    });
});




var pathname = window.location.pathname;

function active_nav() {
    var target = $('#exampleAccordion  li a[href="' + pathname + '"]');

    //jezeli wystepuje stronicowanie; sprawdzenie czy ostatnia czesc url to numer
    if (!isNaN(pathname.split('/').pop())) {
        var nr = pathname.indexOf('index');
        pathname1 = pathname.substr(0, nr - 1);
        targett = $('#exampleAccordion li a[href="' + pathname1 + '"]');
        targett.addClass('activee');
    }

    //dodanie aktywnej klasy do aktualnej strony - navbar menu 
    target.addClass('activee');
}

active_nav();




