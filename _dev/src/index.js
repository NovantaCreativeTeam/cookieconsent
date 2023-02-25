// TODO: Da capire se consent update e consent default va fatto per ogni pagina oppure solo al cambio

CookieConsent.run({
    onModalShow: function(event) {
        const e = document.querySelector("#cc-main .pm")
        let {consentId, consentTimestamp, lastConsentTimestamp } = window.CookieConsent.getCookie();
        if (!window.CookieConsent.validConsent() || !e)
            return;

        consentIdField = e.querySelector('#consent-id')
        consentTimestampField = e.querySelector('#consent-timestamp')
        lastConsentTimestampField = e.querySelector('#last-consent-timestamp')

        consentIdField && (consentIdField.textContent = consentId)
        consentTimestampField && (consentTimestampField.textContent =  new Date(consentTimestamp).toLocaleString())
        lastConsentTimestampField && (lastConsentTimestampField.textContent = new Date(lastConsentTimestamp).toLocaleString())
    },
    categories: window.cc_config.categories,
    disablePageInteraction: window.cc_config.disablePageInteraction,
    autoClearCookies: window.cc_config.autoClearCookies,
    guiOptions: window.cc_config.guiOptions,
    language: {
        default: 'en',
        translations: {
            en: {
                consentModal: {
                    title: 'We use cookies',
                    description: 'Cookie modal description',
                    acceptAllBtn: 'Accept all',
                    acceptNecessaryBtn: 'Reject all',
                    showPreferencesBtn: 'Manage Individual preferences'
                },
                preferencesModal: {
                    title: 'Manage cookie preferences',
                    acceptAllBtn: 'Accept all',
                    acceptNecessaryBtn: 'Reject all',
                    savePreferencesBtn: 'Accept current selection',
                    closeIconLabel: 'Close modal',
                    sections: [
                        {
                            title: 'Somebody said ... cookies?',
                            description: 'I want one!'
                        },
                        ...window.cc_config.sections,
                        {
                            title: "Your consent details",
                            description: '<p>consent id: <span id="consent-id">-</span></p><p>consent date: <span id="consent-timestamp">-</span></p><p>last update: <span id="last-consent-timestamp">-</span></p>'
                        },
                        {
                            title: 'More information',
                            description: 'For any queries in relation to my policy on cookies and your choices, please <a href="#contact-page">contact us</a>'
                        }
                    ]
                }
            }
        }
    }
})