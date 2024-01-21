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
            starter.plugins.ApexCharts.init();

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

    plugins: {
        ApexCharts: {
            init: function () {
                const token = $('meta[name="api-token"]').attr('content');
                if (token) {
                    if ($('#participant').length) {
                        axios.get('/api/user/expense', {
                            headers: {
                                'Authorization': `Bearer ${token}`
                            }
                        })
                            .then((response) => {
                                starter.plugins.ApexCharts.donut(Object.keys(response.data), Object.values(response.data));
                            })
                            .catch((error) => {
                                console.error(error);
                            });
                    }

                    if ($('#balance').length) {
                        axios.get('/api/user/balance', {
                            headers: {
                                'Authorization': `Bearer ${token}`
                            }
                        })
                            .then((response) => {
                                let array = [];

                                $.each(response.data, function (key, value) {
                                    array.push([parseInt(key) * 1000, parseFloat(value.toFixed(2))]);
                                });

                                starter.plugins.ApexCharts.area(array);
                            })
                            .catch((error) => {
                                console.error(error);
                            });
                    }
                }
            },
            donut: function (labels, series) {
                // Generowanie odcieni szarości
                let shadesOfGray = [];
                let step = Math.floor(255 / labels.length);
                for (let i = 0; i < labels.length; i++) {
                    let grayValue = (i * step).toString(16);
                    if (grayValue.length < 2) {
                        grayValue = '0' + grayValue;
                    }
                    shadesOfGray.push('#' + grayValue + grayValue + grayValue);
                }

                const options = {
                    chart: {
                        type: 'donut'
                    },
                    series: series,
                    labels: labels,
                    colors: shadesOfGray, // Dodanie odcieni szarości do opcji wykresu
                    tooltip: {
                        y: {
                            formatter: function (val) {
                                return val + 'zł'; // Formatowanie kwoty w złotówkach
                            }
                        }
                    },
                    legend: {
                        position: 'bottom' // Umieszczenie legendy na dole wykresu
                    }
                };

                var chart = new ApexCharts(document.querySelector("#participant"), options);

                chart.render();
            },
            area: function (data) {
                let firstKey = data[0][0];

                let options = {
                    series: [{
                        name: 'SALDO',
                        color: '#888888',
                        data: data
                    }],
                    chart: {
                        id: 'area-datetime',
                        type: 'area',
                        height: 400,
                        zoom: {
                            autoScaleYaxis: true
                        },
                        defaultLocale: 'pl',
                        locales: [{
                            name: 'pl',
                            options: {
                                months: ['Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień'],
                                shortMonths: ['Sty', 'Lut', 'Mar', 'Kwi', 'Maj', 'Cze', 'Lip', 'Sie', 'Wrz', 'Paź', 'Lis', 'Gru'],
                            }
                        }],
                    },
                    annotations: {
                        yaxis: [{
                            y: 30,
                            borderColor: '#999',
                            label: {
                                show: true,
                                text: 'Support',
                                style: {
                                    color: "#fff",
                                    background: '#888888'
                                }
                            }
                        }],
                        xaxis: [{
                            x: firstKey,
                            borderColor: '#999',
                            yAxisIndex: 0,
                            label: {
                                show: true,
                                text: 'Rally',
                                style: {
                                    color: "#fff",
                                    background: '#888888'
                                }
                            }
                        }]
                    },
                    dataLabels: {
                        enabled: false
                    },
                    markers: {
                        size: 0,
                        style: 'hollow',
                        colors: ['#888888']
                    },
                    xaxis: {
                        type: 'datetime',
                        min: firstKey,
                        tickAmount: 6,
                    },
                    tooltip: {
                        x: {
                            format: 'dd MMM yyyy'
                        },
                        enabledOnSeries: false,
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: 1,
                            opacityFrom: 0.7,
                            opacityTo: 0.9,
                            stops: [0, 100]
                        },
                        colors: ['#888888']
                    },
                    stroke: {
                        show: true,
                        curve: 'straight',
                        lineCap: 'butt',
                        colors: ['#444444'],
                        width: 2,
                        dashArray: 0,
                    },
                };

                let chart = new ApexCharts(document.querySelector("#balance"), options);
                chart.render();

                let currentDate = new Date();
                currentDate.setFullYear(currentDate.getFullYear() - 1);

                chart.zoomX(
                    currentDate.getTime(),
                    Date.now()
                );
            },
        },
    }

};
