//Cookies PLAMEN 08.01.2024

// Функция за показване на прозореца след закъснение
function showCookieConsentWithDelay() {

    setTimeout(function () {
        $("#cookieForm").hide();
        const cookieConsent = $('#cookieConsent');
        cookieConsent.removeClass('d-none');
    }, 1000);

    $("#cookie-config").on("click", function () {
        $("#cookieForm").fadeToggle("slow");
    });

    let checkboxes = $('#cookieForm input[type="checkbox"]');
    let acceptButton = $('#cookie-btn').hide();

    checkboxes.on('change', function () {
        let anyCheckboxChecked = checkboxes.is(':checked');

        acceptButton.toggle(anyCheckboxChecked);
    });
}

const cookieConsent = document.getElementById('cookieConsent');


// Функция за проверка дали потребителят е съгласен с бисквитките
function hasAcceptedCookies() {
    return localStorage.getItem('cookieConsent') === 'true';
}

// Функция за показване или скриване на прозореца за съгласие
function toggleCookieConsent(adStorageConsent, adUserDataConsent, adPersonalizationConsent, analyticsStorageConsent) {

    adStorageConsent = localStorage.getItem('ad_storage');
    adUserDataConsent = localStorage.getItem('ad_user_data');
    adPersonalizationConsent = localStorage.getItem('ad_personalization');
    analyticsStorageConsent = localStorage.getItem('analytics_storage');

    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}

    const cookieConsent = $('#cookieConsent');

    if (hasAcceptedCookies()) {
        cookieConsent.addClass('d-none');
        //Ако са приети кукитата ъпдейтва горната функция в <head>
        gtag('consent', 'update', {
            'ad_storage': adStorageConsent,
            'ad_user_data': adUserDataConsent,
            'ad_personalization': adPersonalizationConsent,
            'analytics_storage': analyticsStorageConsent
        });

    } else {
        showCookieConsentWithDelay();
    }
}



// Функция за съгласие с бисквитките по избор
function acceptCookies() {

    // Извличане на стойности от чекбоксовете
    let adStorageConsent = document.getElementById("ad_storage").checked ? "granted" : "denied";
    let adUserDataConsent = document.getElementById("ad_user_data").checked ? "granted" : "denied";
    let adPersonalizationConsent = document.getElementById("ad_personalization").checked ? "granted" : "denied";
    let analyticsStorageConsent = document.getElementById("analytics_storage").checked ? "granted" : "denied";

    // Запазване на съгласията в localStorage
    localStorage.setItem('cookieConsent', 'true');
    localStorage.setItem('ad_storage', adStorageConsent);
    localStorage.setItem('ad_user_data', adUserDataConsent);
    localStorage.setItem('ad_personalization', adPersonalizationConsent);
    localStorage.setItem('analytics_storage', analyticsStorageConsent);

    toggleCookieConsent(adStorageConsent, adUserDataConsent, adPersonalizationConsent, analyticsStorageConsent);
}

// Функция за съгласие с всички
function  acceptAll() {
    $("#cookieForm").fadeIn("slow");
    let checkboxes = document.querySelectorAll('#cookieForm input[type="checkbox"]');

    checkboxes.forEach(function (checkbox) {
        checkbox.checked = true;
    });

    // Запазване на съгласията в localStorage
    localStorage.setItem('cookieConsent', 'true');
    localStorage.setItem('ad_storage', 'granted');
    localStorage.setItem('ad_user_data', 'granted');
    localStorage.setItem('ad_personalization', 'granted');
    localStorage.setItem('analytics_storage', 'granted');

    setTimeout(function () {
        toggleCookieConsent("granted", "granted", "granted", "granted");
    }, 1000);
}

// Функция за отказване на всички
function rejectAll() {

    $("#cookie-btn").hide();
    $("#cookieForm").fadeIn("slow");
    let checkboxes = document.querySelectorAll('#cookieForm input[type="checkbox"]');

    checkboxes.forEach(function (checkbox) {
        checkbox.checked = false;
    });

    // Запазване на съгласията в localStorage
    localStorage.setItem('cookieConsent', 'true');
    localStorage.setItem('ad_storage', 'denied');
    localStorage.setItem('ad_user_data', 'denied');
    localStorage.setItem('ad_personalization', 'denied');
    localStorage.setItem('analytics_storage', 'denied');

    setTimeout(function () {
        toggleCookieConsent("denied", "denied", "denied", "denied");
    }, 1000);
}

// Проверка и превключване на прозореца за съгласие при зареждане на страницата
document.addEventListener('DOMContentLoaded', function () {
    const cookieConsent = document.getElementById('cookieConsent');
    toggleCookieConsent();
});

//Cookies PLAMEN




