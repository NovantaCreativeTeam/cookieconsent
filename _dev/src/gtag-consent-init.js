window.dataLayer = window.dataLayer || [];
function gtag() { window.dataLayer.push(arguments); }

['cc:onFirstConsent'].forEach((eventName) => {
    window.addEventListener(eventName, (e) => {
        let consent = {}
        let userPreferences = CookieConsent.getUserPreferences()
        userPreferences.acceptedCategories.forEach(category => {
            consent[category] = 'granted'
        });

        userPreferences.rejectedCategories.forEach(category => {
            consent[category] = 'denied'
        });

        // analytics storage force
        consent['analytics_storage'] = 'granted'

        gtag('consent', 'update', consent)
    })
})

window.addEventListener('cc:onChange', function(event){
    let consent = {}
    let userPreferences = CookieConsent.getUserPreferences()

    event.detail.changedCategories.forEach(category => {
        if(category == 'analytics_storage') { // analytics storage force
            consent[category] = 'granted'    
        } else {
            consent[category] = userPreferences.acceptedCategories.includes(category) ? 'granted' : 'denied'
        }
    });

    gtag('consent', 'update', consent)
});