// Scripts to run on page load
(function() {
	// Track all external links
	jQuery(document).on('click', 'a[href*="//"]:not([href*="' + document.location.host + '"])', function(){
		trackOutboundLink(false, 'outbound-article', jQuery(this).attr('href'));
	});
})(jQuery);