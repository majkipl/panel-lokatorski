let event;
let height;

$(function () {
    console.log('STARTER');
});

$(window).on('load', function (e) {
    event = e || window.event;

    starter.main.init();
    starter.main.resize();
});

$(window).resize(function () {
    starter.main.resize();
});

$(window).scroll(function (e) {
    event = e || window.event;
    starter.main.scroll();
});

Array.prototype.shuffle = function () {
    let input = this;

    for (let i = input.length - 1; i >= 0; i--) {

        let randomIndex = Math.floor(Math.random() * (i + 1));
        let itemAtIndex = input[randomIndex];

        input[randomIndex] = input[i];
        input[i] = itemAtIndex;
    }
    return input;
}

function getCookie(name) {
    let cookieArr = document.cookie.split(";");

    for (let i = 0; i < cookieArr.length; i++) {
        let cookiePair = cookieArr[i].split("=");

        if (name == cookiePair[0].trim()) {
            return decodeURIComponent(cookiePair[1]);
        }
    }

    return null;
}

var starter = {
    _var: {
        upload_obj: null,
    },

    _con: {},

    main: {
        init: function () {
            starter.main.click();
            starter.main.error_scroll();

            $('.lds-css').fadeOut();
        },


        click: function () {

            $(document).on('click', '#spending a.remove-cost', function () {
                if (confirm('Czy na pewno usunąć wydatek?')) {
                    return true;
                } else {
                    return false;
                }
            });

            $(document).on('click', '#users a.lock-user', function () {
                if (confirm('Czy na pewno zablokować lokatora?')) {
                    return true;
                } else {
                    return false;
                }
            });

            $(document).on('click', '#users a.unlock-user', function () {
                if (confirm('Czy na pewno odblokować lokatora?')) {
                    return true;
                } else {
                    return false;
                }
            });

            $(document).on('click', 'button.hamburger', function () {
                if ($(this).hasClass("is-active")) {
                    $(this).removeClass("is-active");
                    $('body').removeClass('cbp-spmenu-push-toright');
                    $('#cbp-spmenu-s1').removeClass('cbp-spmenu-open');
                } else {
                    $(this).addClass("is-active");

                    $('body').addClass('cbp-spmenu-push-toright');
                    $('#cbp-spmenu-s1').addClass('cbp-spmenu-open');
                }
                return false;
            });

            $(document).on('click', 'a.popup-open,img.popup-open', function () {
                //close active popup
                $('.popup-show').removeClass('popup-show').fadeOut();
                starter.effects.enableScrolling();

                //open new popup
                var popup_id = $(this).data('popup');

                if (popup_id == 'get-inspired') {
                    var popup = $('section#popup-layout.' + popup_id);
                    $("section#popup-layout." + popup_id + " .popup-body img").attr('src', $(this).attr('href'));
                } else {

                    var popup = $('section#popup-layout.buy');
                    var items = shops['popup-' + popup_id];

                    $("section#popup-layout.buy .list *").remove();
                    //$("section#popup-layout." + popup_id + " .html-body").append(html);

                    $.each(items, function (key, url) {
                        if (url != '#') {
                            //console.log(url);
                            var item = $('<div>').addClass('col-12 col-sm-6 col-md-4 col-lg-3 item');
                            var shop_content = $('<div>').addClass('shop-content');
                            var a = $('<a>').addClass('shop').attr('href', url).attr('title', 'KUP TERAZ').attr('target', '_blank');
                            shop_content.append(a);
                            item.append(shop_content);
                            $("section#popup-layout.buy .list").append(item);
                        }
                    });

                    console.log('zapewne kup teraz');
                }

                popup.addClass('popup-show').fadeIn();

                starter.effects.disableScrolling();

                return false;
            });

        },

        onTouchStart: function () {
            console.log('touch-start');
        },


        resize: function () {

        },

        error_scroll: function () {
            if ($('.has-error input').length) {
                $('.has-error input').get(0).focus();
            }
        },

        scroll: function () {

        },

        validateEmail: function (sEmail) {
            var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
            if (filter.test(sEmail)) {
                return true;
            } else {
                return false;
            }
        },
    },
};
