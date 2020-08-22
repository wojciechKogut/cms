
var loc = window.location.pathname;

var dir = loc.split('/');

var baseUrl = 'http://cms.local';


var request = new XMLHttpRequest();

request.open('GET', 'http://api.openweathermap.org/data/2.5/forecast?id=524901&APPID=fcfa8b5404a59c1f3ffd6889255863e5&q=Tarnobrzeg', true);
request.send(null);

request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
        var weather = request.response;
        weather = JSON.parse(weather);
        var time = new Date();
        var temp = weather.list[0].main.temp;
        var city = weather.city.name;



        temp = Math.floor(temp - 273.15);
        temp = temp + "<sup>o</sup>C";

        let hours = time.getHours();

        var weatherImg = document.getElementById('weather_img');

        switch (weather.list[0].weather[0].main) {
            case "Snow":
                 weatherImg.src = baseUrl + dir[1] + '/images/snow.png';
                break;
            case "Clouds":
                 weatherImg.src = baseUrl + dir[1] + '/images/cloud.png';
                break;
            case "Rain":
                 weatherImg.src = baseUrl + dir[1] + '/images/rain.png';
                break;
            case "Clear":
                if (hours > 16) {
                    weatherImg.src = baseUrl + dir[1] + '/images/cloud.png';
                } else {
                    weatherImg.src = baseUrl + dir[1] + '/images/clear.png';
                }
                break;
            default:
                weatherImg.src = baseUrl + dir[1] + '/images/clear.png';
        }
        document.getElementById('degree').innerHTML = temp;
        document.getElementById('city').innerHTML = city;
    }
};


function timer() {
    let time = new Date();
    let day = time.getDay();

    switch (day) {
        case 0:
            day = "Sunday";
            break;
        case 1:
            day = "Monday";
            break;
        case 2:
            day = "Tuesday";
            break;
        case 3:
            day = "Wednesday";
            break;
        case 4:
            day = "Thursday";
            break;
        case 5:
            day = "Friday";
            break;
        case 6:
            day = "Saturday";
            break;
    }
    let hours = (time.getHours() < 10) ? "0" + time.getHours() : time.getHours();
    let minutes = (time.getMinutes() < 10) ? "0" + time.getMinutes() : time.getMinutes();
    let sec = (time.getSeconds() < 10) ? "0" + time.getSeconds() : time.getSeconds();
    time = day + " " + hours + ":" + minutes + ":" + sec;
    document.getElementById('time').innerHTML = time;
}

setInterval(timer, 1000);


// $('#login-form').on('submit', (e) => {
//     e.preventDefault();
//     var form = document.getElementById("login-form");
//     var username = form.username.value;
//     var password = form.password.value;
//     var info = document.getElementsByClassName('info');
//     var user_regExp = /[a-zA-ZąćęłńóśźżĄĘŁŃÓŚŹŻ]{3,}/;
//     var pass_regExp = /.{4,20}/;
//     var errors = {
//         'username': '',
//         'password': ''
//     };

//     if (username == " " || username == null || !user_regExp.test(username)) {
//         info[0].style.color = "red";
//         errors['username'] = "Please fill username with at least 2 characters";
//         info[0].innerHTML = errors['username'];
//     }
//     else {
//         info[0].innerHTML = " ";
//     }

//     if (password == " " || password == null || !pass_regExp.test(password)) {
//         info[1].style.color = "red";
//         errors.password = "Empty password or to short";
//         info[1].innerHTML = errors.password;
//     }
//     else {
//         info[1].innerHTML = " ";
//     }

//     var i = 0;

//     for (var key in errors) {
//         if (errors[key] != "") i++;
//     }

//     if (i === 0) {
//         let data = {
//             username: username,
//             password: password
//         };

//         $.ajax({
//             url: baseUrl + dir[1] + '/users/ajaxCheck/',
//             type: 'post',
//             data: data,
//             success: function (html) {
//                 if (html.indexOf('admin') !== -1) {
//                     window.location = html;
//                 } else {
//                     $('#loginErr').parent().css('display', 'block');
//                     $('#loginErr').text("Invalid username or password");
//                     $('#loginErr').addClass('alert alert-danger');
//                     form.reset();
//                 }
//             }
//         });
//         return true;
//     } else return false;
// });


// function verify() {

    // var form = document.getElementById("login-form");
    // var username = form.username.value;
    // var password = form.password.value;
    // var info = document.getElementsByClassName('info');
    // var user_regExp = /[a-zA-ZąćęłńóśźżĄĘŁŃÓŚŹŻ]{3,}/;
    // var pass_regExp = /.{4,20}/;
    // var errors = {
    //     'username': '',
    //     'password': ''
    // };

    // if (username == " " || username == null || !user_regExp.test(username)) {
    //     info[0].style.color = "red";
    //     errors['username'] = "Please fill username with at least 2 characters";
    //     info[0].innerHTML = errors['username'];
    // }
    // else {
    //     info[0].innerHTML = " ";
    // }

    // if (password == " " || password == null || !pass_regExp.test(password)) {
    //     info[1].style.color = "red";
    //     errors.password = "Empty password or to short";
    //     info[1].innerHTML = errors.password;
    // }
    // else {
    //     info[1].innerHTML = " ";
    // }

    // var i = 0;

    // for (var key in errors) {
    //     if (errors[key] != "") i++;
    // }

    // if (i === 0) {
    //     let data = {
    //         username: username,
    //         password: password
    //     };

    //     $.ajax({
    //         url: baseUrl + dir[1] + '/users/ajaxCheck/',
    //         type: 'post',
    //         data: data,
    //         success: function (html) {
    //             if (html.indexOf('admin') !== -1) {
    //                 window.location = html;
    //             } else {
    //                 $('#loginErr').parent().css('display', 'block');
    //                 $('#loginErr').text("Invalid username or password");
    //                 $('#loginErr').addClass('alert alert-danger');
    //                 form.reset();
    //             }
    //         }
    //     });
    //     return true;
    // } else return false;
    
// }


function ajax() {

    var comment_author = $("#comment_author").val();
    var comment_email = $('#comment_email').val();
    var comment_content = $('#comment_content').val();
    var comment_post_id = $("#post_id").val();
    var warning = $('#warning').val();

    if (comment_author != "" && comment_email != "" && comment_content != "") {

        var dataString = {
            comment_author: comment_author,
            comment_email: comment_email,
            comment_content: comment_content,
            comment_post_id: comment_post_id
        };
       
        $.ajax({
            type: "POST",
            url: "http://cms.local/comments/ajax/",
            dataType: 'json',
            data: dataString,
            cache: false,
            success: function (html) {
                console.log(html);
                $('ul#update').append(html);
                $('ul#update li').fadeIn("slow");
                $('#warning').empty();
                $('#warning').removeClass("alert alert-warning");
            }
        });
    }
    else {
        $('#warning').addClass("alert alert-warning");
        $('#warning').text("Warning! Please fill all fields");
    }
    document.getElementById("myForm").reset();
}





var pathname = window.location.pathname;



function active_nav_menu() {
    let target = $('.navbar-nav  li a[href="' + pathname + '"]');

    //jezeli wystepuje stronicowanie; sprawdzenie czy ostatnia czesc url to numer
    if (!isNaN(pathname.split('/').pop())) {
        let nr = pathname.indexOf('index');
        pathname1 = pathname.substr(0, nr - 1);
        targett = $('.navbar-nav li a[href="' + pathname1 + '"]');
        targett.addClass('activee');
    }
    target.addClass('activee');
}

active_nav_menu();



function active_category() {
    if (isNaN(pathname.split('/').pop())) {
        //tytul z inputa
        var catTitle = $('.catSlug');
        //nr kategorii z url
        var catTitleFromUrl = pathname.split('/').pop();

        for (var index in catTitle) {
            if (catTitle[index].value == catTitleFromUrl) {
                var category = $('.list-group-item a[href="' + pathname + '"]');
                category.closest('li').css({
                    'background-color': catTitle[index].style.color
                });
                category.css('color', '#fff');
            }
        }
    }
}


active_category();







function validate() {

    loginForm = document.getElementById('loginForm');
    errBox = [];

    var username = document.getElementById('username');
    let email = document.getElementById('email');
    let password = document.getElementById('password');
    let submit = document.getElementById('submitForm');

    //check if exists err message, if exists remove (no duplicate errdiv)
    if (x = document.querySelectorAll('.err')) {
        for (let i = 0; i < x.length; i++) {
            x[i].remove();
        }

    }


    //check if empty username
    if (username.value == '')  messageBox('Empty username field', username);
    else if (username.value.length < 3) messageBox('To short', username); 
    else username.style.border = 'none';
    

    //check for email
    if (email.value == '')  messageBox('Empty email field', email);
    //check if valid email
    else if (!validEmail(email.value)) messageBox('Invalid email', email);
    else  email.style.border = 'none';

    //check for password
    if (password.value == '') messageBox('Empty password field', password);
    else if (username.value.length < 3) messageBox('To short', password);
    else password.style.border = 'none';
    
    //check if no err
    return !errBox.length ? true : false;

}


function messageBox(text, divBeforeErr) {
    let div = document.createElement('div');
    div.appendChild(document.createTextNode(text));
    divBeforeErr.style.border = '1px solid red';
    div.className = 'err';
    div.style.color = 'red';
    loginForm.insertBefore(div, divBeforeErr.nextSibling);
    errBox.push(text);

}

function validEmail(email) {
    regex = new RegExp('^[a-z0-9]+(\.[_a-z0-9]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,15})$');
    return regex.test(email);
}

function reply(id) {
    var $input = $('#answer-' + id);
    $($input).toggle();
}


function reply_content(id) {

    var $input = $('#answer-' + id);
    var reply_list = $('#reply-list-' + id);

    $($input).keydown(function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            if ($input.val() != '') {
                console.log(username);
                if (username == '')  $input.replaceWith(`<p style='color:red'>Please login to comment this post</p>`);
                else {
                    var reply_content = $input.val();
                    var post_id = $('#post-id').val();
                    var user_id = $('#user-id').val();
                    var username = $('#username').val();
                    var comment_data = {
                        content: reply_content,
                        comment_id: id,
                        post_id: post_id,
                        user_id: user_id
                    };

                    $.ajax({
                        url: baseUrl + dir[1] + '/comments/reply/',
                        method: 'post',
                        data: comment_data,
                        success: function (html) {
                            $input.css('display', 'none');
                            reply_list.append(html);
                            document.getElementById('reply_form-' + id).reset();
                        }
                    });
                }

            }

            document.getElementById('reply_form-' + id).reset();
        }
    });
}

function like() {
    var userId = $("#user_id").val();
    var postId = $("#post_id").val();

    var data = {
        userId: userId,
        postId: postId
    };

    console.log(data.userId)

    $.ajax({
        url: baseUrl + dir[1] + '/users/like/',
        type: "post",
        data: data,
        success: function(data1) {
               if(data1.userId != 0) {
                    $(".fa-thumbs-o-up").css('cursor', 'default');
                    $(".fa-thumbs-o-up").addClass("like");
                    $(".dropdown-toggle").text('(' + data1.likesToPost + ')');
               }
        },
        error: function(err) {
            console.log(err);
        }
    });
    
}

function showLikes() {
    
}