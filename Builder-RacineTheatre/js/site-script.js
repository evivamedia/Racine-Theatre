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

// run on load so it gets the size:
// can't have the same pattern for some reason or it scans the page and makes all the same height. Each row should be separate but it doesn't work that way.
jQuery(window).load(function() {

//$('[class*="eq-"]').eqHeights();
  jQuery('.productions_row [class*="p_"]').eqHeights({parentSelector:'.productions_row'});
/*$('.foo2 [class*="eq-"]').eqHeights();*/

  }); 