window.doNotConsentToPixel = window.doNotConsentToPixel || {};
window.doNotConsentToPixel = true;

(function($) {
    ['cc:onFirstConsent', 'cc:onConsent'].forEach((eventName) => {
        window.addEventListener(eventName, (e) => {
            handleFbConsent()
        })
    })

    window.addEventListener('cc:onChange', function(event){
        handleFbConsent()
    });
})()

function handleFbConsent() {
    if(CookieConsent.acceptedCategory('ad_storage')) {
        typeof fbq === "function" ? fbq('consent', 'grant') : window.doNotConsentToPixel = false
    } else {
        typeof fbq === "function" ? fbq('consent', 'revoke') : window.doNotConsentToPixel = true
    }
}