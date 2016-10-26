$(function () {
    var navLogo = $('.nav-logo');
    var navBar = $('.nav-bar');
    var menuLogori= $('.menu-logoRi');
    var menuTitle= $('.menu-title');
    var a = [];
    a.push(navBar.width() - 10);
    navLogo.addClass('nav-open');
    var navLogoRight = navLogo.css('right');
    //点击菜单按钮显示隐藏导航栏
    navLogo.click(function () {
        if (a[0] > navBar.width()) {
            navBar.animate({
                width: '12%'
            }, 500);
            $('.page-header').animate({
                width: '88%',
                left: '12%'
            }, 500);
            $('.page-Ri').animate({
                width: '88%'
            }, 500);
            $('.meber-back').animate({
                width: '88%',
                left: '12%'
            }, 500);
            $('.menu-logoLf').animate({
                fontSize: '1.4rem',
                left: ''
            }, 500);
            $('.nav-abl').animate({
                padding: '1rem'
            }, 500);
            navLogo.animate({
                right: navLogoRight
            }, 500);
            menuLogori.fadeIn();
            menuTitle.fadeIn();
            a.splice(0,1,navBar.width());
            navLogo.addClass('nav-open');
            navLogo.removeClass('nav-close');
        }else{
            menuLogori.removeClass('glyphicon-menu-down');
            menuLogori.addClass('glyphicon-menu-up');
            a.splice(0,1,navBar.width());
            navLogo.addClass('nav-close');
            navLogo.removeClass('nav-open');
            navBar.animate({
                width: '4%'
            }, 500);
            $('.page-header').animate({
                width: '96%',
                left: '4%'
            }, 500);
            $('.page-Ri').animate({
                width: '96%'
            }, 500);
            $('.meber-back').animate({
                width: '96%',
                left: '4%'
            }, 500);
            navLogo.animate({
                right: a[0]/ 20
            }, 500);
            $('.menu-logoLf').animate({
                fontSize: '1.6rem',
                left:$('.nav-abl').width()/15
            }, 500);
            menuLogori.fadeOut();
            menuTitle.fadeOut();
            $('.nav-child').removeClass('nav-active').slideUp();
        }

    });
    //表格无内容，显示添加
    if (!$('.page-table tbody').length) {
        $('.card-hide').show();
    } else {
        $('.card-hide').hide();
    }

    //导航栏动画
    $('.nav-abl').click(function () {
        var siblChild = $(this).siblings('.nav-child');
        var menuLogoRiChil = $(this).children('.menu-logoRi');
        if (!siblChild.hasClass('nav-active') && navLogo.hasClass('nav-close')) {
            navLogo.removeClass('nav-close');
            navLogo.removeClass('nav-open');

            $('.page-header').animate({
                width: '88%',
                left: '12%'
            }, 500);
            $('.page-Ri').animate({
                width: '88%'
            }, 500);
            $('.meber-back').animate({
                width: '88%',
                left: '12%'
            }, 500);
            navBar.animate({
                width: '12%'
            }, 500, function () {
                $('.nav-child').removeClass('nav-active').slideUp();
                siblChild.addClass('nav-active').slideDown();
                menuLogoRiChil.removeClass('glyphicon-menu-up');
                menuLogoRiChil.addClass('glyphicon-menu-down');
                navLogo.addClass('nav-open');
            });
        }
        if (!siblChild.hasClass('nav-active')) {

            //导航栏动画
            $('.menu-logoLf').animate({
                fontSize: '1.4rem',
                left: ''
            }, 500);
            menuTitle.fadeIn();
            $('.nav-abl').animate({
                padding: '1rem'
            }, 500);
            menuLogori.fadeIn();
            //隐藏导航栏文字
            menuTitle.fadeIn();
            if ( navLogo.hasClass('nav-open')) {
                //修改箭头图标
                menuLogori.removeClass('glyphicon-menu-down');
                menuLogori.addClass('glyphicon-menu-up');
                menuLogoRiChil.removeClass('glyphicon-menu-up');
                menuLogoRiChil.addClass('glyphicon-menu-down');
                $('.nav-child').removeClass('nav-active').slideUp();
                siblChild.addClass('nav-active').slideDown();
            }
        } else {
            menuLogoRiChil.removeClass('glyphicon-menu-down');
            menuLogoRiChil.addClass('glyphicon-menu-up');
            siblChild.removeClass('nav-active').slideUp();
        }
    });

    /*    if(window.location.search == '?stateweipay'){
     var siblChild = $('.card').siblings('.nav-child');
     var menuLogoRiChil = $('.card').children('.menu-logoRi');
     //导航栏动画
     $('.menu-logoLf').animate({
     fontSize: '1.4rem',
     left: ''
     }, 500);
     menuTitle.fadeIn();
     $('.nav-abl').animate({
     padding: '1rem'
     }, 500);
     menuLogori.fadeIn();
     //隐藏导航栏文字
     menuTitle.fadeIn();
     if ( navLogo.hasClass('nav-open')) {
     //修改箭头图标
     menuLogori.removeClass('glyphicon-menu-down');
     menuLogori.addClass('glyphicon-menu-up');
     menuLogoRiChil.removeClass('glyphicon-menu-up');
     menuLogoRiChil.addClass('glyphicon-menu-down');
     $('.nav-child').removeClass('nav-active').slideUp();
     siblChild.addClass('nav-active').slideDown();
     }
     }*/
    //导航栏高度
    var navBarHeight = navBar.height() + $('.page-Ri').height();
    navBar.css('height', navBarHeight);

  (function ($) {
        $.fn.alertFadin = function (options, callback) {

            var defaults = {
                '_test': '确认删除吗？',
                '_parter': 'body',
                '_this': '.al-mind',
                '_other': '.al-tocuh',
                '_btnBox': '.al-btnbox',
                '_confirmNo': '.confirmNo',
                '_confirmDle': '.confirmDle',
                '_confirmTest': ['返回', '确定'],
                '_confirm': [' btn-default confirmNo', ' btn-danger confirmDle'],
                '_confirmClose': '.al-confirClose',
                '_yuTrue': false,
                '_length': 2,
                '_true': false,
                '_modal': false,
                '_html': '<div class="al-yu"><p>姓名 ：21212121</p><p>手机号 ：1212121212</p><p>到店时间 ：2020-02-02</p></div>'
            };

            var settings = $.extend({}, defaults, options);//将一个空对象做为第一个参数
            if (!settings._modal) {
                return this.each(function () {
                    if (callback) {
                        function okClick() {
                            $(document).on('click', '.confirmDle', function () {
                                $('.al-mind').fadeOut(function () {
                                    $('.al-mind').remove();
                                });
                                $('.al-tocuh').fadeOut(function () {
                                    $('.al-tocuh').remove();
                                });
                                callback();
                            })
                        }
                        function celClick() {
                            $(document).on('click', '.confirmNo', function () {
                                $('.al-mind').fadeOut(function () {
                                    $('.al-mind').remove();
                                });
                                $('.al-tocuh').fadeOut(function () {
                                    $('.al-tocuh').remove();
                                });
                            })
                        }
                        okClick();
                        celClick();
                    }
                    $(settings._parter).append('<div class="al-mind"></div> <div class="al-tocuh"><h1 class="al-test">' + settings._test + '</h1> <span class="al-confirClose">×</span><div class="al-btnbox"></div>' + settings._html + '</div>');
                    if (settings._yuTrue == true) {
                        $('.al-yu').css('display', 'block');
                    }
                    if (settings._true) {
                        for (var i = 0; i < settings._length; i++) {
                            $(settings._btnBox).append('<button class="btn' + settings._confirm[i] + '">' + settings._confirmTest[i] + '</button>');
                        }
                               $(settings._other).on('click', settings._confirmDle, function () {
                            $(settings._this).fadeOut(function () {
                                $(settings._this).remove();
                            });
                            $(settings._other).fadeOut(function () {
                                $(settings._other).remove();
                            });

                            result = true;
                            $(settings._clickParter).attr('result', result);
                        });
                        $(settings._other).on('click', settings._confirmNo, function () {
                            $(settings._this).fadeOut(function () {
                                $(settings._this).remove();
                            });
                            $(settings._other).fadeOut(function () {
                                $(settings._other).remove();
                            });
                            result = false;
                            $(settings._clickParter).attr('result', result);
                        });
                    }

                    $(settings._other).on('click', settings._confirmClose, function () {
                        $(settings._this).fadeOut(function () {
                            $(settings._this).remove();
                        });
                        $(settings._other).fadeOut(function () {
                            $(settings._other).remove();
                        });
                    });
                    $(document).on('click', settings._this, function () {
                        $(settings._this).fadeOut(function () {
                            $(settings._this).remove();
                        });
                        $(settings._other).fadeOut(function () {
                            $(settings._other).remove();
                        });
                    });

                    $(settings._this).fadeIn();
                    $(settings._other).fadeIn();

                });

            } else {
                return false
            }

        };
    })(jQuery);

    myalert=function(options){
        var defaults = {
            '_test': '确认删除吗？',
            '_parter': 'body',
            '_this': '.al-mind',
            '_other': '.al-tocuh',
            '_confirmDle': ' .confirmDle',
            '_confirmDleTest': '确定',
            '_confirmNo': ' .confirmNo',
            '_confirmNoTest': '返回',
            '_confirmClose': '.al-confirClose',
            '_true': false,
            '_modal': false,
            '_clickParter': ''

        };
        if(typeof(options)=='string')
        {
            var test=options;
            options={};
            options._test=test;
        }
        var result = false;
        
        var settings = $.extend({}, defaults, options);//将一个空对象做为第一个参数
        $(settings._parter).append('<div class="al-mind"></div> <div class="al-tocuh"><h1 class="al-test">' + settings._test + '</h1> <span class="al-confirClose">×</span></div>');
        if (settings._true) {
            $(settings._other).append('<button class="btn btn-default confirmNo">'+settings._confirmNoTest+'</button><button class="btn btn-danger confirmDle">'+settings._confirmDleTest+'</button>');
            $(settings._other).on('click', settings._confirmDle, function () {
                $(settings._this).fadeOut(function () {
                    $(settings._this).remove();
                });
                $(settings._other).fadeOut(function () {
                    $(settings._other).remove();
                });
              
                result = true;
                $(settings._clickParter).attr('result', result);
            });
            $(settings._other).on('click', settings._confirmNo, function () {
                $(settings._this).fadeOut(function () {
                    $(settings._this).remove();
                });
                $(settings._other).fadeOut(function () {
                    $(settings._other).remove();
                });
                result = false;
                $(settings._clickParter).attr('result', result);
            });
          
        }
        $(settings._other).on('click', settings._confirmClose, function () {
            $(settings._this).fadeOut(function () {
                $(settings._this).remove();
            });
            $(settings._other).fadeOut(function () {
                $(settings._other).remove();
            });
        });
        $(document).on('click', settings._this, function () {
            $(settings._this).fadeOut(function () {
                $(settings._this).remove();
            });
            $(settings._other).fadeOut(function () {
                $(settings._other).remove();
            });
        });
        $(document).on('click', settings._this, function () {
            $(settings._this).fadeOut(function () {
                $(settings._this).remove();
            });
            $(settings._other).fadeOut(function () {
                $(settings._other).remove();
            });
        });
        $(settings._this).fadeIn();
        $(settings._other).fadeIn();
        setTimeout(function(){$(settings._this).fadeOut();$(settings._other).fadeOut();},2000);
    };


    var tdHeight =  Math.round($('.page-active tr td').height() / 3-5 );
    var tdHeight1 =  Math.round($('.page-active tr td').height() / 3-5)+tdHeight;
    var tdWdith = $('.page-active tr td').width() * $('.page-active tr td').length;

    $('.posi-div').css('top',tdHeight);
    $('.posi-div').css('width',tdWdith);
    $('.posi-div1').css('top',tdHeight1);
    $('.posi-div1').css('width',tdWdith);
    //持有人全选
    $('#checkedAll').click(function () {
        if ($(this).is(':checked')) {
            $('.page-table input').prop('checked', true);
        } else {
            $('.page-table input').removeAttr('checked');
        }
    });
    //持有人单选
    $('.ckeckBox').click(function () {
        if ($(this).is(':checked')) {
            $(this).prop('checked', true);
        } else {
            $(this).removeAttr('checked');
        }
    });
    $('.alRechargeModal').click(function(){
        if (!$('.ckeckBox').is(':checked')) {
            $('.alRechargeModal').alertFadin();
            return false;
        }else{
            $('.alRechargeModal').alertFadin({'_modal':true});

        }

    });

    $('.stateList-hide').click(function(){
        $('.state-hide').toggle();
    });

       var timered = setInterval(function(){
           $('.editorhidden').each(function(){
               $(this).val($(this).prev().find('.trumbowyg-editor').html());
           });
       })

    if(window.screen.width <= '1440'){
        $('.screenLogTop').removeClass('col-lg-6');
        $('.screenLogTop').addClass('col-lg-9');
        $('.screenXiaoTop').removeClass('col-lg-5');
        $('.screenXiaoTop').addClass('col-lg-7');
        $('.screenWeiIndexTop').removeClass('col-lg-4');
        $('.screenWeiIndexTop').addClass('col-lg-6');
        $('.screenOrderDay').removeClass('col-lg-4');
        $('.screenOrderDay').addClass('col-lg-6');

        $('.screenOrderMen').removeClass('col-lg-3');
        $('.screenOrderMen').addClass('col-lg-4');

        $('.screenOrderYin').removeClass('col-lg-4');
        $('.screenOrderYin').addClass('col-lg-5');

        $('.screenOrderZh').removeClass('col-lg-3');
        $('.screenOrderZh').addClass('col-lg-4');

        $('.screenLogBot').removeClass('col-lg-6');
        $('.screenLogBot').addClass('col-lg-9');

        $('.screenShousu').removeClass('col-lg-4');
        $('.screenShousu').addClass('col-lg-6');
 
        $('.screenJiuhuo').removeClass('col-lg-2');
        $('.screenJiuhuo').addClass('col-lg-3');

        $('.screenJiuhuoB').removeClass('col-lg-3');
        $('.screenJiuhuoB').addClass('col-lg-4');

        $('.screenJiuliuD').removeClass('col-lg-5');
        $('.screenJiuliuD').addClass('col-lg-6');
    }

    $('.progress').click(function () {
        if ($(this).next().css('display') == 'none') {
            $('.progress-bt').css('display','none');
            $(this).next().css('display', 'block');
        }else{
            $(this).next().css('display', 'none');
        }
    })

});

