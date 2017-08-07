e(function ($) {
    Drupal.behaviors.yourName = {
        attach : function(context, settings) {
            $('#arrow-sub-page-left').click(function(){
           //     $('body').attr('style','background-image: url(/sites/default/files/rrr1.jpg');
                change_bg(1);
            });
            $('#arrow-sub-page-right').click(function(){
           //     $('body').attr('style','background-image: url(/sites/default/files/rrr1.jpg');
                change_bg(-1);
            });
            function change_bg(in_val) {
                var curent_id=parseInt($('sub_page_tag').attr('tagcurent'));
                var count_id=parseInt($('sub_page_tag').attr('tagcount'));
                curent_id=curent_id+in_val;
                if(curent_id>count_id) curent_id=1;
                if(curent_id<1) curent_id=count_id;
                $('sub_page_tag').attr('tagcurent',curent_id);
                var init_id=parseInt($('sub_page_tag').attr('tagid'+curent_id));
                slide(init_id);
            }
            var init_id=parseInt($('sub_page_tag').attr('tagid1'));
            if(init_id>0)
            {
                slide(init_id);
            }
            function slide(sid) {
                $('.ibf-lnk').addClass('element-invisible');
                $('.ibf-note').addClass('element-invisible');
                $('.sub-page-id-'+sid).removeClass('element-invisible');
                var url_bg=$('markimg'+sid).attr('value');
                if(url_bg.length>0)
                {
                    //$('body').attr('style','background-image: url('+url_bg+');');
                    $('body').css({'background-image': 'none'});
                    $('body').append('<div class = "bg-overlay"></div>');
                    $('.bg-overlay').css({'background-image' : 'url(' + url_bg + ')'});
                }

            }		
			
			 $(".sf-menu li ul").mouseover(function() {
                $(".sf-menu .menuparent.sfHover ul li").hover(function() {
                    $(".sf-menu .menuparent.sfHover a").removeClass("is-hover"); $(this).parent().parent().children().addClass("is-hover");
                });
            });
            $(".sf-menu").mouseout(function() {
				$(".sf-menu li a").removeClass("is-hover");
			});
			
        }
    };
})(jQuery);