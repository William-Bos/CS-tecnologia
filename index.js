// window.addEventListener("load", function() {
//     alert("JS funcionando");
// });

document.getElementById("log").addEventListener("click", function() {
    window.location.href = "http://localhost:8080/cs/login/index.html"; // caminho para a página de login
});

document.getElementById("cadas").addEventListener("click", function() {
    window.location.href = "http://localhost:8080/cs/cadastro-institui%C3%A7%C3%A3o/cadastrocnpj.html"; // caminho para a página de cadastro
});


function calcularDistancia(lat1, lon1, lat2, lon2) {
    const R = 6371; // Raio da Terra em km
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a = 
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
        Math.sin(dLon / 2) * Math.sin(dLon / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return (R * c).toFixed(2); // retorna em km
}

document.addEventListener("DOMContentLoaded", () => {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(pos => {
            const userLat = pos.coords.latitude;
            const userLng = pos.coords.longitude;

            const boxes = Array.from(document.querySelectorAll(".box"));
            boxes.forEach(box => {
                const lat = parseFloat(box.dataset.lat);
                const lng = parseFloat(box.dataset.lng);
                const dist = calcularDistancia(userLat, userLng, lat, lng);
                box.querySelector(".km").textContent = `${dist} km`;
            });

            // Ordena as instituições por distância
            const consultaDiv = document.querySelector(".consulta");
            boxes.sort((a, b) => {
                const distA = parseFloat(a.querySelector(".km").textContent);
                const distB = parseFloat(b.querySelector(".km").textContent);
                return distA - distB;
            });

            boxes.forEach(box => consultaDiv.appendChild(box)); // reordena no HTML

        }, () => {
            console.warn("Usuário não permitiu acesso à localização.");
        });
    } else {
        console.warn("Geolocalização não é suportada neste navegador.");
    }
});

