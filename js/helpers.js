// GA Track links
// Example:
// <a onclick="trackOutboundLink(this, 'Ad Campaign', 'TAL Group', 'Off site', 'http://tal.com');" href="" />
function trackOutboundLink(link, eventCategory, eventAction, eventLabel, eventValue) {
    var analytics = window.__gaTracker || window.ga;

    if (!analytics) {
        return;
    }

    var eventOptions = {};

    if (eventCategory) {
        eventOptions.eventCategory = eventCategory;
    }

    if (eventAction) {
        eventOptions.eventAction = eventAction;
    }

    if (eventLabel) {
        eventOptions.eventLabel = eventLabel;
    }

    if (eventValue) {
        eventOptions.eventValue = eventValue;
    }


    try {
        analytics('send', 'event', eventOptions);
    } catch(err){
        console.log(err);
    }

    return true;
}

// Mirror trackOutboundLink for events
function trackEvent(eventCategory, eventAction, eventLabel, eventValue) {
    return trackOutboundLink(false, eventCategory, eventAction, eventLabel, eventValue);
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