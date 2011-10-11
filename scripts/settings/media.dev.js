$(document).ready( function() {
    
    $('a.lightbox').fancybox({
        'width':    '75%',
        'height':   '75%',
        'centerOnScroll': true,
        'overlayOpacity':   0.3,
        'overlayColor':     '#69c',
        'titlePosition': 'inside'
    });
    
    $('div.widget_depictions').each(function() {
        var widget_depictions_items = $(this).find('li.widget_depictions_big');
        if (widget_depictions_items.get().length > 1)
        {
            widget_depictions_items.css('width', widget_depictions_items.width()+'px').addClass('rs-carousel-item');
            $(this).children('ul').css('width', (widget_depictions_items.get().length * 100)+'%').addClass('rs-carousel-runner');

            $(this).carousel({
                itemsPerPage: 1,
                itemsPerTransition: 1,
                pagination: false
            });
        }
    });

});
