(function ($) {
    Drupal.behaviors.yourName = {
        attach : function(context, settings) {

          if(jQuery('body').hasClass('front')){
            setInterval(function(){
              interval();
              }, 5000);

          }

            $('#arrow-sub-page-left').click(function(){
           //     $('body').attr('style','background-image: url(/sites/default/files/rrr1.jpg');
                change_bg(1, 'left');
            });
            $('#arrow-sub-page-right').click(function(){
           //     $('body').attr('style','background-image: url(/sites/default/files/rrr1.jpg');
                change_bg(-1, 'right');
            });
            function change_bg(in_val, direction) {
                var curent_id=parseInt($('sub_page_tag').attr('tagcurent'));
                var count_id=parseInt($('sub_page_tag').attr('tagcount'));

                var bg_id = curent_id;
                curent_id=curent_id+in_val;
                if(curent_id>count_id) curent_id=1;
                if(curent_id<1) curent_id=count_id;
                $('sub_page_tag').attr('tagcurent',curent_id);
                var init_id=parseInt($('sub_page_tag').attr('tagid'+curent_id));
                bg_id = parseInt($('sub_page_tag').attr('tagid'+bg_id));
                slide(init_id, bg_id, direction);
            }
            var init_id=parseInt($('sub_page_tag').attr('tagid1'));
            if(init_id>0)
            {
                slide(init_id);
            }


            function slide(sid, bg_id =  undefined, direction = undefined) {

                if(bg_id === undefined){

                  $('.ibf-lnk').addClass('element-invisible');
                  $('.ibf-note').addClass('element-invisible');
                  $('.sub-page-id-'+sid).removeClass('element-invisible');

                }

                var url_bg=$('markimg'+sid).attr('value');
                var cur_img = $('markimg'+bg_id).attr('value');

                if(url_bg.length>0){

                    if(bg_id === undefined){
                       $('body').attr('style','background-image: url('+url_bg+');');
                    }
                    else{
                      if(jQuery('body').hasClass('not-front')){
                        jQuery('h1').animate({'opacity' : 0}, 500, function(){
                          slide_direction(cur_img, url_bg, direction, sid);
                          });
                        jQuery('.region-content').animate({'opacity' : 0}, 500);
                        jQuery('.region-content-bottom').animate({'opacity' : 0}, 500, function(){

                          });
                      }
                      else{
                        slide_direction(cur_img, url_bg, direction, sid);
                      }


                    }



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



function slide_direction(cur_img, url_bg, direction, sid){


  var markup = jQuery('body').html();
  jQuery('body').append('<div class = "bg_overlay"></div>');
  jQuery('body').append('<div class = "bg_overlay_next"></div>');
  jQuery('body').append('<div class = "markup">'+markup+'</div>');
  jQuery('.bg_overlay').css({'background-image' : 'url('+cur_img+')'});
  jQuery('.bg_overlay_next').css({'background-image' : 'url('+url_bg+')'});


  jQuery('.ibf-lnk').animate({'opacity' : 0}, 500, function(){
    jQuery('.ibf-lnk').addClass('element-invisible');
  });

   jQuery('.ibf-note').animate({'opacity' : 0}, 500, function(){
     jQuery('.ibf-note').addClass('element-invisible');
    });



  var w_width = jQuery('body').width();
  if(direction == 'right'){
    jQuery('.bg_overlay_next').css({'left' : '-'+w_width+'px'});
    jQuery('.bg_overlay').css({'left' : 0});
  }
  else{
    jQuery('.bg_overlay_next').css({'left' : w_width+'px'});
    jQuery('.bg_overlay').css({'left' : 0});
  }

  jQuery('.bg_overlay').animate({'opacity' : 1}, 500, function(){

    if(direction == 'right'){
      jQuery('.bg_overlay').animate({'left' : w_width+'px'}, 1000, 'easeOutCirc');
      jQuery('.bg_overlay_next').animate({'left' : 0}, 1000, 'easeOutCirc', function(){
        remove_overlays(sid);
      });
    }
    else{
      jQuery('.bg_overlay').animate({'left' : '-'+w_width+'px'}, 1000, 'easeOutCirc');
      jQuery('.bg_overlay_next').animate({'left' : 0}, 1000, 'easeOutCirc', function(){
        remove_overlays(sid);
      });

    }

    });

  function remove_overlays(sid){
    jQuery('body').attr('style','background-image: url('+url_bg+');');


      jQuery('.bg_overlay_next').animate({'opacity' : 0}, 500, function(){
        jQuery('.bg_overlay_next').remove();
        jQuery('.bg_overlay').remove();
        jQuery('.markup').remove();
        console.log(sid);
        jQuery('.sub-page-id-'+sid).removeClass('element-invisible');
        jQuery('.sub-page-id-'+sid).animate({'opacity' : 1}, 500);
       });
  }
}

function interval(){
   var elements = document.querySelectorAll(':hover');
   var slide = true;
   elements.forEach(function(item, i, arr) {
    if(jQuery(item).is('article')){
      slide = false;
    }

    if(jQuery(item).is('h1')){
      slide = false;
    }

    if(jQuery(item).is('ul')){
      slide = false;
    }

    if(jQuery(item).hasClass('head-container')){
      slide = false;
    }

    if(jQuery(item).hasClass('footer-images')){
      slide = false;
    }

    if((jQuery(item).is('a')) && (jQuery(item).hasClass('logo'))){
      slide = false;
    }

    if(jQuery(item).is('div[id ^= "arrow-sub-page"]')){
      slide = false;
    }
  });
   
   if(slide == true){
     jQuery('#arrow-sub-page-right').trigger('click');
   }
}


