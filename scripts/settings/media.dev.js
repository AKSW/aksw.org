$(document).ready( function() {
    
    $('a.lightbox').fancybox({
        'width':    '75%',
        'height':   '75%',
        'centerOnScroll': true,
        'overlayOpacity':   0.3,
        'overlayColor':     '#69c',
        'titlePosition': 'inside'
    });
    
    var gallery_counter = 0;
    
    $('ul.mediagallery').each(function() {
        $(this).find('a.lightbox').attr('rel', 'gallery_'+(gallery_counter++));
    });
    
    $('div.widget_depictions').each(function() {
        var widget_depictions_items = $(this).find('li.widget_depictions_big');
        if (widget_depictions_items.get().length > 1)
        {
            widget_depictions_items.css('width', widget_depictions_items.width()+'px').addClass('rs-carousel-item');
            $(this).children('ul').css('width', (widget_depictions_items.get().length * 100)+'%').addClass('rs-carousel-runner');
            
            $(this).find('a.lightbox').attr('rel', 'gallery_'+(gallery_counter++));

            $(this).carousel({
                itemsPerPage: 1,
                itemsPerTransition: 1,
                pagination: false
            });
        }
    });
    
    $('div.demowheel > ul').each(function() {
        var demowheel_items = $(this).children('li');
        if (demowheel_items.get().length > 1)
        {
            demowheel_items.css('width', demowheel_items.width()+'px').addClass('rs-carousel-item').removeClass('first');
            demowheel_items.css('padding-left', ((demowheel_items.innerWidth() - demowheel_items.width())/2)+'px');
            demowheel_items.css('padding-right', ((demowheel_items.innerWidth() - demowheel_items.width())/2)+'px');
            $(this).css('width', (demowheel_items.get().length * demowheel_items.outerWidth())+'px').addClass('rs-carousel-runner');
            
            $(this).parent('div.demowheel').carousel({
                // itemsPerPage: 1,
                // itemsPerTransition: 1,
                // pagination: false
                speed: 'slow',
                autoScroll: true,
                pause: 6000
            });
        }
    });
    

});
