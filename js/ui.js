/*
    v. 1.1 — April 10, 2013
                • Code review
                • Added Cntrl/Cmnd + arrows navigation
    v. 1.2 — April 11, 2013
                • Added translation overlay
*/
UI =
{
	init: function()
	{
        UI.initTracking();
        UI.initTranslateOverlay();
        UI.initTravelMap();
        UI.initKeyboardNavigation();
        UI.initImageNumbers();
	    UI.initPanorama();
	    UI.initShareSnippet();
	    $j('body').addClass('x-loaded');

	},

    // GLOBAL: Track all external links
    initTracking: function() {
        // console.log('initTracking');
        jQuery(document).on('click', 'a[href*="//"]:not([href*="' + document.location.host + '"])', function(){
            trackOutboundLink(false, 'outbound-article', jQuery(this).attr('href'));
        });
    },

    // GLOBAL: Show translation overlay while Google Translate is loading
    initTranslateOverlay: function(){
        // console.log('initTranslateOverlay');
        if(/googtrans\/en/.test(window.location.hash) || /rublog\.ca/.test(window.location.hostname)) {
            var $translatePanel = $j('<div class="x-translate-overlay sans-serif"><h2>Ooops, this blog is in Russian</h2><p>Please wait while loading automatic English translation from Google…</p></div>');
                $translatePanel.prepend('<div class="x-floating-link"><small>If that takes a while…</small><a href="javascript:UI.forceTranslation();" class="x-button x-positive-button">Force English Translation</a></div>');
                $translatePanel.prepend('<div class="x-floating-link"><small>Товарищ?</small><a href="javascript:UI.hideTranslation();" class="x-button x-negative-button">Спасибо, не нужно переводить</a></div>');
            $j('#main').prepend($translatePanel);

            var waitTranslation = window.setInterval(function(){
                if($j('html').hasClass('translated-ltr')) {
                    UI.hideTranslation();
                    waitTranslation = window.clearInterval(waitTranslation);
                } else {
                    UI.forceTranslation();
                }
            }, 200);

            // Track event
            trackEvent('Google Website Translator', 'Show Translation Popup', false, false) ;
        }
    },

        forceTranslation: function() {
            $j('iframe.goog-te-menu-frame').first().contents().find('.goog-te-menu2-item span.text:contains("English")').first().click();

            // Track event
            trackEvent('Google Website Translator', 'Force English Translation', false, false) ;
        },

        hideTranslation: function(){
            $j('.x-translate-overlay').remove();

            // Track event
            trackEvent('Google Website Translator', 'Cancel Translation', false, false) ;
        },


    // PAGE: Travel page map/list view toggle handler
	initTravelMap: function(){
        // console.log('initTravelMap');
	    $j('a.travelView').on('click', function(){
	        var $self = $j(this),
                $canvas = $j('#travels'),
                mode = $self.attr('href').replace(/(.*)#/,'');
	        if(!$canvas.length || !mode)
	            return false;
	        $canvas.removeClass().addClass(mode);
	        $j('a.travelView').removeClass('active');
	        $self.addClass('active');
	    });
	},

     // ARCHIVE, POST: Keyboard navigation
    initKeyboardNavigation:function(){
        // console.log('initKeyboardNavigation');

        var $navBar = $j('#nav-below'),
            $navPrev = $navBar.find('a[rel=prev]'),
            $navNext = $navBar.find('a[rel=next]');
        if(!$navBar.length)
            return false;

        // hide arrows if next or prev is missing
        if(!$navPrev.length)
            $navBar.find('.x-prev').hide()
        if(!$navNext.length)
            $navBar.find('.x-next').hide()

        $j(document).keydown(function (e){
            if(!$j('body').hasClass('theater-mode') && (event.metaKey || event.ctrlKey)) {
                switch(e.keyCode) {
                    case 37:
                        e.preventDefault();
                        if($navPrev.length)
                            window.location = $navPrev.attr('href')
                        break;
                    case 39:
                        e.preventDefault();
                        if($navNext.length)
                            window.location = $navNext.attr('href');
                        break;
                }
            }
        });
    },

    // POST: Numbers after image image to reffer to
    initImageNumbers:function(){
        // console.log('initImageNumbers');

        var $postImages = $j('.one-column .entry-content img');
        if($postImages.length < 3)
            return;
        $postImages.each(function(i){
            $j(this).before('<ins id="img_' + (i+1) + '" class="imgNumber"><small>' + (i+1) +'</small></ins>');
        });
    },

    // POST: Panoramic images scrolling feature
	initPanorama:function(){
        // console.log('initPanorama');

        var $img = $j('img.panorama');
	    $img.addClass('panorama-loading');
        $img.wrap('<div class="panorama-canvas"></div>');


		$j('.panorama-canvas img.panorama').one('load', function(){
			var $_img = $j(this),
                $_panorama = $_img.parent('.panorama-canvas');


            UI.stylePanorama($_panorama);
            $j(window).on('resize', function(){
                UI.stylePanorama($_panorama);
            });

			$_img.removeClass('panorama-loading');
            $_panorama.addClass('panorama-ready')
			$_panorama.prop('scrollLeft', $_img.width()/2 - $_panorama.width()/2);
			$_panorama.scrollview({
				grab:"/wp-content/themes/myblog/images/c/openhand.cur",
				grabbing:"/wp-content/themes/myblog/images/c/closedhand.cur"
			});
			$_panorama.after('<span class="panoramaIcon"></span>')

            // Once again fix styling
            UI.stylePanorama($_panorama);

		}).each(function() {
            // If loading from cache
            if(this.complete) $j(this).load();
        });
	},

        stylePanorama:function($panorama){
            var width = $j('body').width(),
                margin = (width - $panorama.parent().width()) / 2;

            $panorama.css({
                'width': width,
                'margin-left': (margin > 0) ? -margin : 0,
                'margin-right': (margin > 0) ? -margin : 0
            });

            // Hide Icon if entire image is shown
            $panorama.next('.panoramaIcon').toggleClass('panoramaIcon--hide', $panorama.find('img.panorama').width() < width);
        },

    // POST: Floating share widget
	initShareSnippet:function(){
        // console.log('initShareSnippet');

        var $container = $j('#container'),
            $widget = $j('#post-widget'),
            $shareSnippet = $j('#ShareSnippet', $widget),
        	shift = 48;

        if(!$shareSnippet.length)
        	return false;

        var top = $container.offset().top - shift,
        	maxTop;

		var updateShareSnippet = function(){
			//maxTop = top + container.height() - $j('dl', shareSnippet).height();
            maxTop = $container.height() - $j('#post-widget:not(.floated)').height()*1.5 - window.innerHeight*.75;

			if(top < document.body.scrollTop){
			    if(document.body.scrollTop < maxTop) { //-shift)
                    $widget.addClass('floated');
                    $shareSnippet.addClass('fixed').css('top', shift);
                }
                else {
                    $shareSnippet.removeClass('fixed').css('top', maxTop - top);
                    $widget.removeClass('floated');
                }
            }
            else {
                $shareSnippet.removeClass('fixed').css('top', shift);
                $widget.addClass('floated');
            }
		};
    	$j(window).bind('load resize scroll', updateShareSnippet);
    }
}

jQuery(function(){
    $j=jQuery.noConflict();
    UI.init();
});

(function() {
    function ScrollView(){ this.initialize.apply(this, arguments) }
    ScrollView.prototype = {
        initialize: function(container, config){
                // setting cursor.
                var gecko = navigator.userAgent.indexOf("Gecko/") != -1;
                var opera = navigator.userAgent.indexOf("Opera/") != -1;
                var mac = navigator.userAgent.indexOf("Mac OS") != -1;
                if (opera) {
                    this.grab = "default";
                    this.grabbing = "move";
                } else if (!(mac && gecko) && config) {
                    if (config.grab) {
                       this.grab = "url(\"" + config.grab + "\"),default";
                    }
                    if (config.grabbing) {
                       this.grabbing = "url(" + config.grabbing + "),move";
                    }
                } else if (gecko) {
                    this.grab = "-moz-grab";
                    this.grabbing = "-moz-grabbing";
                } else {
                    this.grab = "default";
                    this.grabbing = "move";
                }

                // Get container and image.
                this.m = $j(container);
                this.i = this.m.children().css("cursor", this.grab);

                this.isgrabbing = false;

                // Set mouse events.
                var self = this;
                this.i.mousedown(function(e){
                        self.startgrab();
                        this.xp = e.pageX;
                        this.yp = e.pageY;
                        return false;
                }).mousemove(function(e){
                        if (!self.isgrabbing) return true;
                        self.scrollTo(this.xp - e.pageX, this.yp - e.pageY);
                        this.xp = e.pageX;
                        this.yp = e.pageY;
                        return false;
                })
                .mouseout(function(){ self.stopgrab() })
                .mouseup(function(){ self.stopgrab() })
                .dblclick(function(){
                        var _m = self.m;
                        var off = _m.offset();
                        var dx = this.xp - off.left - _m.width() / 2;
                        if (dx < 0) {
                                dx = "+=" + dx + "px";
                        } else {
                                dx = "-=" + -dx + "px";
                        }
                        var dy = this.yp - off.top - _m.height() / 2;
                        if (dy < 0) {
                                dy = "+=" + dy + "px";
                        } else {
                                dy = "-=" + -dy + "px";
                        }
                        _m.animate({ scrollLeft:  dx, scrollTop: dy },
                                "normal", "swing");
                });

                this.centering();
        },
        centering: function(){
                var _m = this.m;
                var w = this.i.width() - _m.width();
                var h = this.i.height() - _m.height();
                _m.scrollLeft(w / 2).scrollTop(h / 2);
        },
        startgrab: function(){
                this.isgrabbing = true;
                this.i.css("cursor", this.grabbing);
        },
        stopgrab: function(){
                this.isgrabbing = false;
                this.i.css("cursor", this.grab);
        },
        scrollTo: function(dx, dy){
                var _m = this.m;
                var x = _m.scrollLeft() + dx;
                var y = _m.scrollTop() + dy;
                _m.scrollLeft(x).scrollTop(y);
        }
    };

    jQuery.fn.scrollview = function(config){
        return this.each(function(){
            new ScrollView(this, config);
        });
    };
})(jQuery);