let toggle = document.querySelector('.toggle');
let body = document.querySelector('body');

toggle.addEventListener('click', function(){
    body.classList.toggle('open');
})






var answerCookieInputs = $('#rgpd_modal .modal-body button[data-authorize]');


$(document).ready(function () {
    if (typeof (localStorage.getItem("cookieOK")) == 'undefined' || localStorage.getItem("cookieOK") === null) {
        $('#bandeau_cookie').removeClass('cookie_deactivate');
        $('#acceptCookies').click(function () {
            $('#bandeau_cookie').addClass('cookie_deactivate');
            localStorage.setItem("cookieOK", "ok");
            localStorage.setItem("Analytics", true);
            iziToast.success({
                title: 'Super !',
                message: 'Vous venez d\'accepter l\'utiisation des cookies',
            });
        });
    }
    $('#acceptcookies_modal').click(function () {
        window.location.reload();
    });
});


$(window).on('load', function () {
    var nbAuthorize = 0;
    var nbDenied = 0;
    var n = 0;
    answerCookieInputs.click(function () {
        var name = $(this).data('name');
        var authorize = $(this).data('authorize');
        localStorage.setItem(String(name), Boolean(authorize === true));

        if (Boolean(authorize === true)) {
            $(this).removeClass("deny");
            $(this).addClass("acceptAnwser");
            $(this).addClass("active");
            localStorage.setItem("cookieOK", "ok");
        } else if (Boolean(authorize === false)) {
            $(this).removeClass("deny");
            $(this).addClass("refuseAnswer");
            $(this).addClass("active");
            localStorage.setItem("cookieOK", "ok");
        }
    });


    $('#rgpd_modal').on('hidden.bs.modal', function () {
        console.log("mabite");
        localStorage.setItem("cookieOK", "ok");
        window.location.reload();

        /* Si la personne ferme le modal on met à true toutes les variables qui n'existent pas dans le local storage */
        $.each(answerCookieInputs, function (key, input) {
            var name = $(input).data('name');
            var authorize = $(input).data('authorize');
            if (name === 'undefined' || typeof name === 'undefined') {
                return;
            }

            /* On vérifie si la variable existe */
            if (localStorage.getItem(String(name)) === null) {
                localStorage.setItem(String(name), Boolean(authorize === true));
                $(input).addClass('acceptAnwser');
                $(input).removeClass('deny');
                window.location.reload();
            }
        });
    });


    $.each(answerCookieInputs, function (key, input) {
        var name = $(input).data('name');
        var authorize = $(input).data('authorize');
        if (name === 'undefined' || typeof name === 'undefined') {
            return;
        }
        n++;

        /* On vérifie si la variable existe */
        if (localStorage.getItem(String(name)) !== null) {
            if (localStorage.getItem(String(name)) === "true" && authorize === true) {
                nbAuthorize++;
                /* Cas où on est à true dans la variable et sur le button */
                $(input)
                    .addClass('acceptAnwser')
                    .removeClass('deny');
            } else if (localStorage.getItem(String(name)) === "false" && authorize === false) {
                nbDenied++;
                /* Cas où on est à false dans la variable et sur le button */
                $(input)
                    .addClass('refuseAnswer')
                    .removeClass('deny');
            } else if (localStorage.getItem(String(name)) !== "false" && localStorage.getItem(String(name)) !== "true") {
                /* Cas où il n'y a ni true ni false dans notre variable */
                localStorage.removeItem(String(name));
            } else {
                $(input)
                    .removeClass('acceptAnwser')
                    .removeClass('refuseAnswer')
                    .addClass('deny');
            }
        } else {
            $(input)
                .removeClass('acceptAnwser')
                .removeClass('refuseAnswer')
                .addClass('deny');
        }
    });
});
$('#rgpd_modal .modal-body button').click(function () {
    var id = $(this).prop('id');
    var regex = new RegExp('([A-Za-z]+)(Allow|Denied)');
    var fullmatch = id.match(regex);
    var status = fullmatch[2];
    var type = fullmatch[1];
    var isDenied = (status === 'Denied' ? 1 : 0);
    if (isDenied) {
        $("#" + type + "Allow")
            .removeClass("deny")
            .addClass("refuseAnswer active");
        $("#" + type + "Allow")
            .removeClass("acceptAnwser active")
            .addClass("deny");
    } else {
        $("#" + type + "Allow")
            .removeClass("deny")
            .addClass("acceptAnwser active");
        $("#" + type + "Denied")
            .removeClass("refuseAnswer active")
            .addClass("deny");
    }
});
