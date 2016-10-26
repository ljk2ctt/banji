$(function () {
    var colorWep = [{ 'color':'red'},{ 'color':'orange'},{'color':'yellow'},{'color':'green'},{'color':'cyan'},{'color':'blue'},{'color':'purple'},{'color':'black'},{'color':'white'} ];

    //�ı�������ɫ
    $('.colorDropdownMenu li').click(function () {
        $('.num-span').css('color',colorWep[$(this).index()].color);
    });
    $('.colorDropdownMenu li:last-child').click(function () {
        $('.num-span').css('color', 'white');
    });

    // �ı俨ƬͼƬ��ʽ
    $("input[name='input-card']").click(function(){
        $('.ks-vip-img').attr("src",$(this).val());
    });

    //�л��б�����
    $('.listDropdownMenu li a[name="pay"]').click(function(){
        $('.card-unit').css('display','block');
        $('.card-use-hide').css('display','none');
    });
    $('.listDropdownMenu li a[name="use"]').click(function(){
        $('.card-unit').css('display','none');
        $('.card-use-hide').css('display','block');
    });
    $('.listDropdownMenu li a[name="none"]').click(function(){
        $('.card-unit').css('display','none');
        $('.card-use-hide').css('display','none');
    });

    // �ı俨Ƭ������ɫ
    $('.input-miniColor').focus(function () {
        // �ı俨ƬͼƬ��ʽ
        $('.ks-vip-img').attr("src",$("input[name='input-card'][checked]").val());
        var timerColor = setInterval(function () {
            var colorInput = $('.input-miniColor').val();
            if (colorInput) {
                $('.colorVip').css({
                    background: colorInput,
                    display: 'block'
                });
            } else {
                $('.colorVip').css({
                    display: 'none'
                });
            }
        });
        $('.input-miniColor').blur(function () {
            clearInterval(timerColor);
        });
    });

    $('.num-input').focus(function(){
        console.log($('.num-input').val());
        var timerNum = setInterval(function(){
            $('.num-span span').html($('.num-input').val());
        });
        $('.num-input').blur(function(){
            clearInterval(timerNum)
        });
    });


    $("#color").minicolors({
        control: $(this).attr('data-control') || 'hue',
        defaultValue: $(this).attr('data-defaultValue') || '',
        inline: $(this).attr('data-inline') === 'true',
        letterCase: $(this).attr('data-letterCase') || 'lowercase',
        opacity: $(this).attr('data-opacity'),
        position: $(this).attr('data-position') || 'bottom right',
        change: function (hex, opacity) {
            if (!hex) return;
            if (opacity) hex += ', ' + opacity;
            try {
                /* console.log(hex);*/
            } catch (e) {
            }
        },
        theme: 'bootstrap'
    });
});