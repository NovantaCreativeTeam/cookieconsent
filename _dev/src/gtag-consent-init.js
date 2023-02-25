window.dataLayer = window.dataLayer || [];
function gtag() { window.dataLayer.push(arguments); }
gtag('consent', 'default', {
    'personalization_storage': 'denied',
    'security_storage': 'denied',
    'analytics_storage': 'denied',
    'ad_storage': 'denied'
});

(function($) {
    window.addEventListener('cc:onFirstConsent, cc:onConsent', function(event){
        let consent = {}
        let userPreferences = CookieConsent.getUserPreferences()
        userPreferences.acceptedCategories.forEach(category => {
            consent[category] = 'granted'
        });

        userPreferences.rejectedCategories.forEach(category => {
            consent[category] = 'denied'
        });

        gtag('consent', 'update', consent)
    });

    window.addEventListener('cc:onChange', function(event){
        let consent = {}
        let userPreferences = CookieConsent.getUserPreferences()

        event.detail.changedCategories.forEach(category => {
            consent[category] = userPreferences.acceptedCategories.includes(category) ? 'granted' : 'denied'
        });

        gtag('consent', 'update', consent)
    });
})()