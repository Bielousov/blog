/*! iSlide - v1.2 - 2015-03-11
* http://www.bielousov.com
* Copyright © 2012 Anton Bielousov; */

iSlide = {
	version: "1.2",
	copyright: '&copy; Anton Bielousov',
	container: Object,
	images: Object,
	imgSelector: '.one-column .entry-content img.size-large[src*=".jpg"]',
	imgPattern: /-\d{3,4}x\d{3,4}\./,
	imgExcludePattern: /-\d{3}x\d{4}\./, // do not include tall images e.g.omage-900x1280.jpg
	title: String,

	pinterest: true,
	useFullscreen: true,

	init: function()
	{
		iSlide.container = false;
		iSlide.title = jQuery('h1.entry-title').text();

		jQuery(iSlide.imgSelector).each(function(i,el){
			if (!iSlide.imgExcludePattern.test(jQuery(el).attr('src'))) {
				jQuery(this).addClass('zoom').after('<span data-src="'+jQuery(el).attr('src')+'" class="zoomIcon"></span>');
			}
		});

		iSlide.images = jQuery(iSlide.imgSelector+'.zoom');

		if (iSlide.images.length === 0) {
			return false;
		}


		iSlide.images.click(function(){
			iSlide.open(jQuery(this).attr('src'));
		});

		jQuery('.zoomIcon').click(function(){
			iSlide.open(jQuery(this).attr('data-src'));
		});
	},

	initEvents: function(){
		jQuery(document).keydown(function(e) {
			if(iSlide.is_active()){
				if(e.keyCode === 27) {
					e.preventDefault();
					iSlide.fullscreen(false);
					iSlide.exit();
				}
				if(e.keyCode === 39) {
					if(event.metaKey || event.ctrlKey)
						e.preventDefault();
					iSlide.next();
				}
				if(e.keyCode === 37) {
					if(event.metaKey || event.ctrlKey)
						e.preventDefault();
					iSlide.previous();
				}
			}
        });

		// Thumbnails click event
        iSlide.container.find('.thumbnails li a').click(function(){
			iSlide.select(jQuery(this).attr('data-index'));

			trackEvent('Slideshow', 'Navigation', 'Thumbnail Click');
		});

        // On fullscreen mode change
        jQuery(document).on("webkitfullscreenchange mozfullscreenchange fullscreenchange",function(){
        	if(iSlide.useFullscreen && iSlide.is_active()) {
				if (document.webkitIsFullScreen || document.mozFullScreen || document.fullscreen) {
					jQuery('body').addClass('fullscreen');
				} else {
					jQuery('body').removeClass('fullscreen');
					iSlide.exit();
				}
			}
        });

        jQuery(window).resize(function(){
        	if (iSlide.is_active()) {
	        	iSlide.loadCurrent();
	        }
        });

    	/*iSlide.container.find('.slide img').bind("contextmenu",function(e){
            return false;
        });*/

        jQuery(window).unload(function() {
		  	if (iSlide.useFullscreen && iSlide.is_active()) {
		  		iSlide.fullscreen(false);
		  	}
		});
	},

	is_active: function() {
		return (jQuery('body').hasClass('theater-mode') && iSlide.container!=false);
	},

	create: function() {
		iSlide.container = jQuery('<section id="Slideshow"></section>');
		iSlide.container.html('<nav><a class="exit">(Esc)<ins></ins></a></nav><ul class="thumbnails" rel="nav"></ul>');
		iSlide.container.find('.exit').on('click', function(){
			iSlide.exit();
		});

		iSlide.images.each(function(i){
			var $img = jQuery(this),
				img_title = ($img.attr('title') ? $img.attr('title') : ''),
				img_src = $img.attr('src'),
				img_url = [
							img_src.replace(iSlide.imgPattern,'-200x200.'),
							img_src,
							img_src.replace(iSlide.imgPattern,'.')
						];

			// NOTE:
			// Yes, script creates 2 images with same source,
			// one is stretched 100% high,
			// the other one is stretched 100% wide
			// CSS does the magic figuring out which should be disaplyed
			// this allows avoiding with and height calculations with script
			// in cost of some performance though.
			iSlide.container.append('<div id="slide-'+i+'" class="slide" data-image="'+img_url[2]+'">'
											+'<ins></ins>'
											+'<div class="meta">'
												+ (iSlide.pinterest ? '<div class="pin"><a href="http://pinterest.com/pin/create/button/?url='+encodeURIComponent(window.location.href.split('#')[0])+'&media='+encodeURIComponent(img_url[1])+'&description='+encodeURIComponent(iSlide.title+(img_title.length>0 ? ' — ' + img_title : ''))+'" class="pin-it-button" count-layout="vertical" always-show-count="true"><img border="0" src="//assets.pinterest.com/images/PinExt.png" title="Pin It" /></a></div>' : '')
												+'<h2>'+iSlide.title+'</h2>'
												+'<p>'+img_title+'</p>'
												+'<small class="copy">'+iSlide.copyright+'</small>'
											+'</div>'
											+'<img class="fit-h" src="'+img_url[1]+'" alt="'+$img.attr('alt')+'" />'
											+'<img class="fit-w" src="'+img_url[1]+'" alt="'+$img.attr('alt')+'" />'
										+'</div>');
			iSlide.container.find('.thumbnails').append('<li><a data-index="'+i+'"><img src="'+img_url[0]+'" /></a></li>');
		});

		// Init interaction events
		iSlide.initEvents();

		// Append Slideshow into body
		iSlide.container.appendTo(jQuery('body'));

		// Load pinterest code
		if(iSlide.pinterest){
			jQuery.getScript("//assets.pinterest.com/js/pinit.js");
		}
	},

	exit: function() {
	    if(!jQuery('body').hasClass('theater-mode'))
	    	return false;

		if(iSlide.useFullscreen){
			window.setTimeout(function() {
				iSlide.fullscreen(false);
			});
		}

		// iSlide.container.fadeOut(100);
		iSlide.container.hide();
		jQuery('body').removeClass('theater-mode');
	},

	open: function(src) {
		if(iSlide.is_active())
			return false;

		var index = 0;
		if(!iSlide.container)
			iSlide.create();

		iSlide.images.each(function(i,el){
			if (jQuery(el).attr('src') === src){
				index = i;
				return;
			}
		});
		iSlide.select(index);
		//iSlide.container.fadeIn(200);
		iSlide.container.show();
		jQuery('body').addClass('theater-mode');
		iSlide.select(index);

		if(iSlide.useFullscreen) {
			window.setTimeout(function() {
				iSlide.fullscreen(true);
			}, 100);
		}

		trackEvent('Slideshow', 'View Slideshow');
	},

	fullscreen: function(a) {
		if(a){
			var docElm = document.documentElement;
			if (docElm.requestFullscreen) {
				docElm.requestFullscreen();
			}
			else if (docElm.mozRequestFullScreen) {
				docElm.mozRequestFullScreen();
			}
			else if (docElm.webkitRequestFullScreen) {
				docElm.webkitRequestFullScreen();
			}

			trackEvent('Slideshow', 'Enter Fullscreen');
		} else {
			if (document.exitFullscreen) {
				document.exitFullscreen();
			}
			else if (document.mozCancelFullScreen) {
				document.mozCancelFullScreen();
			}
			else if (document.webkitCancelFullScreen) {
				document.webkitCancelFullScreen();
			}
		}
	},

	reset: function() {
		iSlide.index = 0;
		iSlide.container.find('.slide.active').removeClass('active');
		iSlide.container.find('.thumbnails li.active').removeClass('active');
	},


	previous: function(){
		if(iSlide.index>0) {
			iSlide.select(parseInt(iSlide.index)-1);

			trackEvent('Slideshow', 'Navigation', 'Previous Slide');
		}
	},

	next: function(){
		if(iSlide.index<iSlide.images.length-1) {
			iSlide.select(parseInt(iSlide.index)+1);

			trackEvent('Slideshow', 'Navigation', 'Next Slide');
		}
	},

	select: function(index){
		iSlide.reset();
		iSlide.index = index;
		var $slide = iSlide.getSlide(iSlide.index),
			$thumb = iSlide.container.find('.thumbnails li a[data-index='+iSlide.index+']').parent();

		$thumb.addClass('active');
		$slide.addClass('active');
		iSlide.container.find('.thumbnails').css('left', '-' + $thumb.position().left + 'px');
		iSlide.loadCurrent();
	},

	loadCurrent: function(){
		if(iSlide.is_active()){
			iSlide.load(iSlide.index, true);
		}
	},

	preload: function(index){
		if(index < iSlide.images.length - 1)
			iSlide.load(parseInt(index) + 1, false);
		if(index > 0)
			iSlide.load(parseInt(index) - 1, false);
	},

	load: function(index, preload) {
		var $slide = iSlide.getSlide(index),
			$thumb = iSlide.container.find('.thumbnails li a[data-index='+index+']').parent(),
			imgUrl = $slide.attr('data-image');
		if($slide.hasClass('loaded') || $slide.hasClass('preloading') || (jQuery(window).width() <= jQuery(iSlide.images.get(index)).width() && jQuery(window).height() <= jQuery(iSlide.images.get(index)).height())){
			if(preload)
				iSlide.preload(index);
			return;
		}

		$slide.addClass('preloading');
		$thumb.addClass('preloading');

		jQuery('<img />')
			.attr({src: imgUrl,
					id: 'preload-slide-'+index,
					class: 'preload'})
			.appendTo($slide)
			.load(function(){
				$slide.find('img.fit-h, img.fit-w').attr('src', imgUrl);
				$slide.removeClass('preloading').addClass('loaded');
				$thumb.removeClass('preloading').addClass('loaded');
				jQuery(this).remove();

				if(preload)
					iSlide.preload(index);
			});
	},

	getSlide: function(index){
		return iSlide.container.find('#slide-'+index);
	}
}

jQuery(function() {
	// Init on load
	iSlide.init();
});