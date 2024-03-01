window.dataLayer = window.dataLayer || [];
function gtag() { window.dataLayer.push(arguments); }

['cc:onConsent'].forEach((eventName) => {
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

        // Consent mode v2
        // ad_personalization & ad_user_data follow ad_storage value
        consent['ad_personalization'] = consent['ad_storage']
        consent['ad_user_data'] = consent['ad_storage']

        gtag('consent', 'update', consent)
    })
})

window.addEventListener('cc:onChange', function(event){
    let consent = {}
    let userPreferences = CookieConsent.getUserPreferences()

    event.detail.changedCategories.forEach(category => {
        if(category === 'analytics_storage') { // analytics storage force
            consent[category] = 'granted'
        } else {
            consent[category] = userPreferences.acceptedCategories.includes(category) ? 'granted' : 'denied'
        }

        if(category === 'ad_storage') {
            consent['ad_personalization'] = consent['ad_storage']
            consent['ad_user_data'] = consent['ad_storage']
        }
    });

    gtag('consent', 'update', consent)
});