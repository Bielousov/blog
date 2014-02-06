// GA Track links
// Example:
// <a onclick="trackOutboundLink(this, 'Ad Campaign', 'TAL Group', 'Off site', 'http://tal.com'); return false;" href="" />
function trackOutboundLink(link, category, action, label, value) { 
     try { 
    _gaq.push(['_trackEvent', category , action, label, value]); 
    } catch(err){}
     
    setTimeout(function() {
        document.location.href = link.href;
    }, 100);
}


// Safe Email display
// Example:
// showEmailLink("vacancy.tal","gmail.com", '');
function showEmailLink(user, domain, linkText) {
 if (linkText == "") {
  linkText = user + "@" + domain;
 }
 return document.write(" <a href=" + "mail" + "to:" + user + "@" + domain
   + ">" + linkText + "<\/a> ");
}