var $ = jQuery.noConflict();
var pagesHtml = {};
var intervalId;
var eventsAttached;

initScrollBar = function() {

    var me = this;

    me.scrollPan = null;
    me.scroller = null;
    me.scrollingElem = null;


    me.scrollerHeight = null;
    me.scrollPanHeight = null;
    me.scrollingElemHeight = null;

    me.scrollPosition = null;
    me.topBound = null;
    me.bottomBound = null;
    me.allowScrolling = false;

    me.allowedDistance = null;
    me.scrollPanFreeDistance = null
    me.multiply = 1;



    me.init = function() {

        me.scrollPan = $('#scroll-pan');
        me.scroller = $('#scroll-item');
        me.scrollingElem = $('#scroll-pan').next();
        me.scrollingElem.css({marginTop: '0px'});


        me.defineProperties(function() {
            if (!eventsAttached) {
                me.attachEvents(function() {
                    me.scrollSelectedToCenter();
                });
            }
        });


    };

    me.defineProperties = function(callBack) {

        var intrId = setInterval(function() {

            if (me.scroller.height() && me.scrollingElem.height()) {

                me.allowScrolling = true;

                me.scrollPan.height($('#post-show-hide').height() - 40);
                me.scrollPanHeight = me.scrollPan.height();

                me.scrollingElemHeight = me.scrollingElem.height();

                me.allowedDistance = me.scrollingElemHeight - $('#post-show-hide').height() + $('#post-show-hide').offset().top;

                if (me.allowedDistance <= 0) {

                    me.cancelScrolling();
                } else {

                    me.scroller.height(me.scrollPanHeight - me.allowedDistance);
                    me.scrollerHeight = me.scroller.height();

                    if (me.scrollerHeight <= 0) {
                        me.scrollerHeight = 40;
                        me.scroller.height(40);
                    }
                    me.scrollPanFreeDistance = me.scrollPanHeight - me.scrollerHeight;
                    me.multiply = me.allowedDistance / me.scrollPanFreeDistance;
                    me.topBound = me.scrollerHeight / 2;
                    me.bottomBound = me.scrollPanHeight - me.scrollerHeight / 2;
                }
                if (callBack && me.allowScrolling) {
                    me.allowScrolling = false;
                    callBack();
                }
                clearInterval(intrId);
            }
        }, 0);

    };

    me.attachEvents = function(callBack) {

        me.allowScrolling = false;

        me.scroller.mousedown(function(e) {
            me.onMouseDown(e);
        });

        $(document).mouseup(function(e) {
            me.onMouseUp(e);
        });

        $(document).mousemove(function(e) {
            me.onMouseMove(e);
            me.onScrollingElemMouseLeave(e);
        });

        $(document).mouseout(function(e) {
            me.onLeaveDocument(e);
        });

        $($('.single-post-list').get(0)).bind('mousewheel', function(e) {
            me.onMouseWheel(e);
        });

        var startValue = parseInt($('.single-post-current').css('margin-top'));

        $(window).scroll(function() {

            var scrollHeight = $('.single-post-current').height() - $(window).height() + 100;
            var windowHeight = $(document).height() - $(window).height();
            var x = scrollHeight / windowHeight;

            $('.single-post-current').css({marginTop: -($(window).scrollTop() * x) + startValue});
        });

        me.scrollingElem.mouseenter(function(e) {
            me.onScrollingElemMouseEnter(e);
        });
        eventsAttached = true;
        if (callBack) {
            callBack();
        }
    };

    me.scrollSelectedToCenter = function() {

        var $container = $('#post-show-hide')
        var $selected = $container.find('.selected').not(':last-child, :first-child');
        var startOffset = $container.offset().top;

        var finalPos = $selected.offset().top - startOffset - $container.height() / 2 + $selected.height() / 2;
        if (finalPos > 0) {
            $('.post-list').animate({'margin-top': -finalPos}, 1000);
        }

    };

    me.onMouseDown = function(e) {
        e.preventDefault();
        me.allowScrolling = true;
        me.shiftY = getOffsetY(e, me.scroller);

    };

    me.onMouseMove = function(e) {
        e.preventDefault();

        var $scrl = me.scroller;

        if (me.allowScrolling) {

            var $scrollPan = me.scrollPan;
            var posY = (e.pageY - $scrollPan.offset().top - me.shiftY);
            var topBound = 0;
            var bottomBoud = Math.floor($scrollPan.height() - $scrl.height());

            if (posY < 0) {
                posY = 0;
            }

            if (posY >= bottomBoud) {
                posY = bottomBoud;
            }


            if (posY >= 0 || posY <= bottomBoud) {
                moveY($scrl, posY);
            }

            var scrollDistance = getScrollDistance();
            doScroll(scrollDistance);
        }
    };

    me.onMouseUp = function(e) {

        e.preventDefault();
        if (me.allowScrolling) {
            me.allowScrolling = false;
        }
    };

    me.onLeaveDocument = function(e) {

        e = e ? e : window.event;
        var from = e.relatedTarget || e.toElement;
        if (!from || from.nodeName == "HTML") {
            if (me.allowScrolling) {
                if (e.clientY < 0) {
                    doScroll(0);
                    me.scroller.css({top: 0});
                } else {
                    doScroll(me.scrollingElemHeight);
                    me.scroller.css({top: me.bottomBound - me.scrollerHeight / 2});
                }
            }
        }
    }

    me.onScrollingElemMouseEnter = function(e) {
        me.scrollPanExists = true;
        me.scrollPan.fadeIn();
    };

    me.onScrollingElemMouseLeave = function(e) {

        if (me.scrollPanExists) {

            var $elem = $($('.single-post-list').get(0));
            var bounds = getBounds();

            if ((e.pageX > bounds.right || e.pageX < bounds.left) && !me.allowScrolling) {
                me.scrollPan.fadeOut();
                me.scrollPanExists = false;
            }
        }
    };

    me.onMouseWheel = function(e) {
        e.preventDefault();

        var dy = e.originalEvent.deltaY;
        var posY = parseInt(me.scroller.css('top')) + dy;

        if (posY < 0) {
            posY = 0;
        }

        if (posY + me.scroller.height() / 2 > me.bottomBound) {
            posY = me.bottomBound - me.scroller.height() / 2;
        }

        moveY(me.scroller, posY);
        var scrollDistance = posY * me.multiply;//  getScrollDistance();
        doScroll(-scrollDistance);
    };

    me.cancelScrolling = function() {
        me.allowScrolling = false;
    };

    //Helper function

    function getCenter($elem) {
        return parseInt($elem.css('top')) + $elem.height() / 2;
    }

    function moveY($elem, pos) {
        $elem.css({top: pos});
    }

    function getOffsetY(e, $elem) {
        return e.pageY - $elem.offset().top;
    }

    function getScrollDistance() {

        var y = getCenter(me.scroller);
        var distance = y - me.topBound;
        var scrollDistance = distance * me.multiply;

        return -scrollDistance;
    }

    function doScroll(distance) {
        me.scrollingElem.css({marginTop: distance + 'px'});
    }

    function getBounds() {

        var $elem = $($('.single-post-list').get(0));

        return {
            left: $elem.offset().left,
            right: $elem.offset().left + $elem.width(),
            top: $elem.offset().top,
            bottom: $elem.offset().top + $elem.height()
        };
    }

    me.init();
};


function flip(selector) {

    $(window).blur(function() {

        $(selector).css({
            transform: 'rotateX(0deg)',
            WebkitTransform: 'rotateX(0deg)',
            '-moz-transform': 'rotateX(0deg)'
        });

        clearInterval(intervalId);

    });

    var count = $(selector).length;
    var currentIndex = 0;

    if (!count) {
        return false;
    }

    $(selector).css({
        transform: 'rotateX(0deg)',
        WebkitTransform: 'rotateX(0deg)',
        '-moz-transform': 'rotateX(0deg)'
    });

    $('.flip').css({
        transform: 'rotateX(0deg)',
        WebkitTransform: 'rotateX(0deg)',
        '-moz-transform': 'rotateX(0deg)'
    });

    var intervalId = setInterval(function() {

        var $currentElem = $($(selector).get(currentIndex));
        var multiple = false;

        if ($currentElem.find('.flip').length > 1) {

            multiple = true;

            if ($currentElem.find('.flipped').length) {

                $currentElem.find('.flip').each(function(index, elem) {

                    var $elem = $(elem);

                    if ($elem.hasClass('flipped')) {

                        $elem.removeClass('flipped');

                        if ($elem.next().length) {

                            $elem.next().addClass('flipped');
                            return false;
                        } else {
                            $($currentElem.find('.flip').get(0)).addClass('flipped');
                            return false;
                        }
                    }
                });
            } else {
                $($currentElem.find('.flip').get(0)).addClass('flipped');
            }

            $animateElem = $currentElem.find('.flip');

        } else {
            $animateElem = $currentElem.find('.flip');
            multiple = false;
        }



        var animation = setInterval(function() {

            var rotateValue = getRotateX($animateElem);
            rotateValue = parseInt(rotateValue) + 5;

            $animateElem.css({
                transform: 'rotateX(' + rotateValue + 'deg)',
                WebkitTransform: 'rotateX(' + rotateValue + 'deg)',
                '-moz-transform': 'rotateX(' + rotateValue + 'deg)',
            });

            if (rotateValue == 270 && multiple) {

                var $flipped = $currentElem.find('.flipped');
                $flipped.hide();
                if ($flipped.next().length) {
                    $flipped.next().show();
                } else {
                    $($currentElem.find('.flip').get(0)).show();
                }

            }

            if (rotateValue == 360) {

                $animateElem.css({
                    transform: 'rotateX(' + 0 + 'deg)',
                    WebkitTransform: 'rotateX(' + 0 + 'deg)',
                    '-moz-transform': 'rotateX(' + 0 + 'deg)',
                });

                clearInterval(animation);
            }
        }, 15);


        if (currentIndex == count - 1) {
            currentIndex = 0
        } else {
            currentIndex++;
        }

    }, 5000);

}


function getRotateX($elem) {

    var str = $elem.attr('style');
    var s = "rotateX(";
    var index = str.indexOf(s) + s.length;
    var numStr = str.slice(index, index + 3);
    var s = '';

    for (var i = 0; i < 3; i++) {
        if (!isNaN(parseInt(numStr[i]))) {
            s += numStr[i];
        }
    }

    return parseInt(s);
}




function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function get_post_show_hide_width() {
    var container = $('#post-show-hide');

    if ($(container).find('.full-width').length) {
        return $(window).width() - $('#nav').width();
    }

    var width = 770;

    if ($('#nav').width() + width > $(window).width()) {
        var width = $(window).width() - $('#nav').width();
    }
    $($('.single-post-current').get(0)).width(width - $($('.single-post-list').get(0)).width() - 40);
    return width;
}

$(document).ready(function() {

    $('.trending_content').bxSlider({
        responcive: false,
        auto: true,
        onSliderLoad: function() {

            var leftPos = $('.bx-pager-item:first-child').offset().left - $('.bx-wrapper').offset().left;
            var rightPos = $('.bx-pager-item:last-child').offset().left - $('.bx-wrapper').offset().left + $('.bx-pager-item:last-child').width() / 8;

            $('.bx-prev').css({left: leftPos - 30});
            $('.bx-next').css({left: rightPos + 30});

        }
    });

    $('.ajax-link-wrapper').each(function(index, elem) {

        var ajaxUrl = $(elem).attr('data-ajax') + '&qcAC=1&ajax=1';
        var pageName = $(elem).attr('data-page-name');

        $.get(ajaxUrl, function(responce) {
            if (responce) {

                pagesHtml[pageName] = responce;
            }
        });
    });

    $('.menu>li>a').click(function(ev) {

        var currentItemHref = $('.current_page_item a').attr('href');
        var href = $(this).attr('href');

        if (currentItemHref == href) {
            return false;
        }

        if (currentItemHref[0] == '#') {

            $('#post-show-hide').width(0);
            $('.page-warpper').width(0);
            $('#blocker').fadeOut(50);
            $('#blocker-black').fadeOut(50);
        }

        if (href[0] == '#') {
            var name = href.substring(1);
            $('[data-page-name="' + name + '"]').click();
            $('.menu>li').removeClass('current_page_item');
            $(this).parent().addClass('current_page_item');
            ev.preventDefault();
        }
    });

    $('.btn-page-exit').live('click', function() {

        $('.menu>li').removeClass('current_page_item');
        $('.menu>li:first-child').addClass('current_page_item');

        if ($(this).parent().parent().hasClass('without-blocker')) {
            $(this).parent().parent().animate({width: 0}, 150);
            $('#blocker-black').fadeOut(50);
            return false;
        }

        if ($('.single-post-list').length) {
            $($('.single-post-list').get(0)).animate({width: 0}, 250, function() {
                $('#post-show-hide').animate({width: 0}, 150, function() {
                    $('#blocker').fadeOut(50, function() {
                        $('#post-show-hide').html('');
                    });
                });
            });

        } else {

            $('#post-show-hide').animate({width: 0}, 150, function() {
                $('#blocker').fadeOut(50, function() {
                    $('#post-show-hide').html('');
                });
            });
        }
    });

    $('[data-page-name="connect"]').click(function(e) {
        $('#blocker-black').fadeIn(250, function() {
            $('#connect').animate({width: "220px"}, 200);
        });
    });

    $('[data-page-name="voice"]').click(function(e) {
        $('#blocker-black').fadeIn(250, function() {
            $('#voice').animate({width: $(window).width() - $('#nav').width()}, 200);
        });
    });
	
	$('[data-page-name="shop"]').click(function(e) {
        $('#blocker-black').fadeIn(250, function() {
            $('#shop').animate({width: $(window).width() - $('#nav').width()}, 200);
        });
    });

    $('.connect-close').click(function() {
        $('#connect').animate({width: "0px"}, 200);
        $('.menu>li').removeClass('current_page_item');
        $('.menu>li:first-child').addClass('current_page_item');
        $('#blocker-black').fadeOut(50);
    });

    $('.ajax-link-wrapper').click(function(e) {
        
        eventsAttached = false;
        var me = this;

        $('#blocker').fadeIn(250, function() {

            var pageName = $(me).attr('data-page-name');
            var ajaxUrl = $(me).attr('data-ajax') + '&ajax=1';
            var html = pagesHtml[pageName];
            if (html) {
                $('#post-show-hide').html(pagesHtml[pageName]);
                $('#post-show-hide').animate({width: get_post_show_hide_width()}, 100);
            } else {
                $.get(ajaxUrl, function(resp) {
                    html = resp;
                    $('#post-show-hide').html(html);
                    $('#post-show-hide').animate({width: get_post_show_hide_width()}, 100);
                });
            }
        });
    });
    
    //shop page
    $(".product").on('click', function(){
        var addToCart = $(this).find('a.add_to_cart_button');
        var dataId = addToCart.data("product_id");
        $.ajax({
            type : 'GET',
            url: '/shop',
            data: {
                prodId: dataId
            }
         });
        
    });
    
    
    flip('.flip-wrapper');
    
   
    
});


$(window).focus(function() {
    if (!intervalId) {
        flip('.flip-wrapper');
    }
});

$(document).on('click', '.post-list li', function(e) {


    var $elem = $(this);
    var scrollHeight = $elem.parent().css('margin-top');

    if (!$elem.hasClass('selected')) {

        $('.post-list li').removeClass('selected');
        $elem.addClass('selected');
        var ajaxUrl = $elem.find('[data-href]').attr('data-href');

        $.get(ajaxUrl + '?ajax=1&sidebar=0', function(html) {
            $('#post-show-hide .btn-page-exit').remove();
            $('.single-post-current').replaceWith(html);
            $elem.parent().css({marginTop: scrollHeight});
        });
    }
});


