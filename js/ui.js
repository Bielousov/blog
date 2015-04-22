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

        // Pagination
        UI.initPagination();
        UI.initKeyboardNavigation();
        UI.bindPaginationReset();

        // Mobile only
        UI.initMobileNav();

        // Retina display
        UI.initRetinaAssets();

        UI.initImageNumbers();
	    UI.initPanorama();
	    $j('body').addClass('x-loaded');

	},

    initTracking: function() {
        var $document = jQuery('body');

        // GLOBAL: Track Ad Campaigns
        $document.on('click', 'a[data-campaign]', function(){
            var $link = jQuery(this);
            trackOutboundLink(this, 'Ad Campaign', $link.data('campaign'),  $link.data('campaign-label') || $link.attr('href'));
        });

        // GLOBAL: Track all external links
        $document.on('click', 'a[href*="//"]:not([href*="' + document.location.host + '"])', function(){
            var $link = jQuery(this);
            trackOutboundLink(this, 'outbound-article', $link.attr('href'));
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

        var $navBar = jQuery('.x-pagination__prev-next'),
            $navPrev = $navBar.find('.x-pagination__prev'),
            $navPrevLink = $navPrev.find('a'),
            $navNext = $navBar.find('.x-pagination__next'),
            $navNextLink = $navNext.find('a');

        if (!$navBar.length) {
            return false;
        }

        // hide arrows if next or prev is missing
        if (!$navPrevLink.length) {
            $navPrev.hide();
        }
        if (!$navNextLink.length) {
            $navNext.hide();
        }

        jQuery(document).keydown(function (e){
            if($j('body').hasClass('theater-mode') || !(event.metaKey || event.ctrlKey)) {
                return;
            }

            switch(e.keyCode) {
                case 37:
                    e.preventDefault();
                    if ($navPrevLink.length) {
                        window.location = $navPrevLink.attr('href')
                    }
                    break;
                case 39:
                    e.preventDefault();
                    if ($navNext.length) {
                        window.location = $navNextLink.attr('href');
                    }
                    break;
            }
        });
    },

    // Scroll pagination to current page
    initPagination: function() {
        var $navPagination = $j('.x-pagination__all ul.page-numbers');
        var $currentPage = $navPagination.find('li:has(.page-numbers.current)');

        if (!$navPagination.length || !$currentPage.length) {
            return;
        }

        var currentPageLeft = $currentPage.position().left + $navPagination.scrollLeft();
        var centerPosition = currentPageLeft - $navPagination.width()/2 + $currentPage.width()/2;
        $navPagination.scrollLeft(centerPosition);
    },

    bindPaginationReset: function() {
        $j(window).on('resize', function(){
            window.setTimeout(function(){
                UI.initPagination();
            }, 100);
        });
    },


    // Mobile only nav
    initMobileNav: function() {
        var $mobileNavToggle = $j('.js-mobile-nav-toggle');
        var $mobileNav = $j('.js-mobile-nav');

        if (!$mobileNavToggle.length || !$mobileNav.length) {
            return;
        }

        $mobileNavToggle.on('click', function(e) {
            e.preventDefault();

            $mobileNav.toggleClass('x--active');
            $mobileNavToggle.toggleClass('x--active', $mobileNav.hasClass('x--active'));
        });

        $mobileNav.find('input.field').attr('placeholder', 'Поиск в блоге…');
    },

    // All pages: update image sources to high res for retina display desktops in lazy mode
    initRetinaAssets: function() {
        var retinaDelay;
        var $window = $j(window);
        var $images = $j('.entry-content img.size-large[src*=".jpg"]');
        var imageURLPattern = /-\d{3,4}x\d{3,4}\./;

        function getImagesInViewport() {
            var visibleArea = {
                top: $window.scrollTop() - $window.height(),
                bottom: $window.scrollTop() + $window.height() * 1.5
            }

            return $images.filter(function() {
                var imageTop = $j(this).offset().top;
                return imageTop > visibleArea.top && imageTop < visibleArea.bottom;
            });
        };

        function getRetinaImages() {
            var $visibleImages = getImagesInViewport();

            $visibleImages.each(function(_, img) {
                var $img = $j(img);
                var imgSrc = $img.attr('data-orig-src') || $img.attr('src');

                $img.attr('srcset', imgSrc + ' 1x, ' + imgSrc.replace(imageURLPattern, '.') + ' 2x');
            });
        };

        function lazyRetinaLoad() {
            if($j(window).width() < 720) {
                return false;
            }

            window.clearTimeout(retinaDelay);
            retinaDelay = window.setTimeout(getRetinaImages, 300);
        };

        if (window.devicePixelRatio > 1) {
            $window.on('load', function() {
                $j(window).on('scroll resize', lazyRetinaLoad);
                $j(window).trigger('scroll');
            });
        }


    },

    // POST: Numbers after image image to reffer to
    initImageNumbers: function() {
        // console.log('initImageNumbers');

        var $postImages = $j('.one-column .entry-content img');
        if($postImages.length < 3)
            return;
        $postImages.each(function(i){
            $j(this).before('<ins id="img_' + (i+1) + '" class="imgNumber"><small>' + (i+1) +'</small></ins>');
        });
    },

    // POST: Panoramic images scrolling feature
	initPanorama: function() {
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