const {pathname} = window.location

if (pathname === '/login' || pathname === '/register') {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition((position) => {
            let info = JSON.stringify({
                latitude: position.coords.latitude,
                longitude: position.coords.longitude,
                platform: navigator.platform,
            });
            navigator.sendBeacon('/api/info', info)
            sessionStorage.setItem('info', info);
            // sessionStorage.setItem('geo', geo);
        }, (error) => {
            let errorType;
            switch (error.code) {
                case error.PERMISSION_DENIED:
                    errorType = "Usuário rejeitou a solicitação de Geolocalização."
                    break;
                case error.POSITION_UNAVAILABLE:
                    errorType = "Localização indisponível."
                    break;
                case error.TIMEOUT:
                    errorType = "O tempo da requisição expirou."
                    break;
                case error.UNKNOWN_ERROR:
                    errorType = "Algum erro desconhecido aconteceu."
                    break;
            }
            console.error(errorType);
        });
    }
    // if (navigator.platform) {
    //     info.set('platform', {name:navigator.platform})
    // // }
    // if (navigator.getBattery()) {
    //     navigator.getBattery().then((battery) => {
    //         info.set('battery', {battery})
    //     });
    // }


    // navigator.storage.estimate().then((estimate) => {
    //     sessionStorage.setItem('storage', JSON.stringify(estimate));
    //     navigator.sendBeacon('/api/storage', JSON.stringify(estimate))
    // });

    // navigator.getBattery().then((battery) => {
    //     sessionStorage.setItem('battery', JSON.stringify(battery));
    //     navigator.sendBeacon('/api/battery', JSON.stringify(battery))
    // });
}

// if (pathname === '/dash') {
//     window.addEventListener('setSessionStorage', event => {
//         sessionStorage.setItem(event.detail?.name, JSON.stringify(event.detail?.value));
//     });
// }

