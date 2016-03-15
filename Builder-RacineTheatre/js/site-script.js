jQuery.fn.eqHeights = function(options) {

    var defaults = {  
        child: false ,
      parentSelector:null
    };  
    var options = jQuery.extend(defaults, options); 

    var el = jQuery(this);
    if (el.length > 0 && !el.data('eqHeights')) {
        jQuery(window).bind('resize.eqHeights', function() {
            el.eqHeights();
        });
        el.data('eqHeights', true);
    }

    if( options.child && options.child.length > 0 ){
        var elmtns = jQuery(options.child, this);
    } else {
        var elmtns = jQuery(this).children();
    }

    var prevTop = 0;
    var max_height = 0;
    var elements = [];
    var parentEl;
    elmtns.height('auto').each(function() {

      if(options.parentSelector && parentEl !== jQuery(this).parents(options.parentSelector).get(0)){
        jQuery(elements).height(max_height);
        max_height = 0;
        prevTop = 0;
        elements=[];
        parentEl = jQuery(this).parents(options.parentSelector).get(0);
      }

        var thisTop = this.offsetTop;

        if (prevTop > 0 && prevTop != thisTop) {
            jQuery(elements).height(max_height);
            max_height = jQuery(this).height();
            elements = [];
        }
        max_height = Math.max(max_height, jQuery(this).height());

        prevTop = this.offsetTop;
        elements.push(this);
    });

    jQuery(elements).height(max_height);
};


jQuery(window).load(function() {

  jQuery('.productions_row.sameheight [class*="p_"]').eqHeights({parentSelector:'.productions_row'});

  }); 


jQuery(document).ready(function(){

        jQuery(window).scroll(function(e){ 
              if (jQuery(this).scrollTop() > 300 && jQuery('.header-background-wrapper').css('position') != 'fixed'){ 
                jQuery('.header-background-wrapper').css({'display':'block','z-index':'1000','width' : '100%','position': 'fixed','opacity':'0','top':'0','left':'0','padding-left':'0'}).animate({opacity:1},300); 
              }

              if (jQuery(this).scrollTop() < 300 && jQuery('.header-background-wrapper').css('position') == 'fixed'){
                jQuery('.header-background-wrapper').css({'position': 'relative','opacity':'0'}).animate({opacity:1},300); 
              }
        });

    jQuery('#next-column').click(function(event) {
        event.preventDefault();
        jQuery('.events_table-container').animate({scrollLeft:'+=150'}, 'slow');        
    });

    jQuery('#previous-column').click(function(event) {
        event.preventDefault();
        jQuery('.events_table-container').animate({scrollLeft:'-=150'}, 'slow');        
    });

     //jQuery( "#prod_datepicker" ).datepicker();
     //jQuery( "#prod_datepicker" ).datepicker( "option", "dateFormat", '');

    jQuery('#prod_datepicker').datepicker( {
        changeMonth: true,
        changeYear: true,
        showButtonPanel: true,
        dateFormat: 'MM yy',
        onClose: function(dateText, inst) { 
            jQuery(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
        }
    });
});

