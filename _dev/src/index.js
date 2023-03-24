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
    language: window.cc_config.language
})