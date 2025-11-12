document.addEventListener("DOMContentLoaded", () => {
    const enderecoInput = document.getElementById("endereco");
    const mapsLinkInput = document.getElementById("maps_link");
    const latInput = document.getElementById("latitude");
    const lngInput = document.getElementById("longitude");

    // Coordenadas padrão (São Paulo)
    let lat = -23.55052;
    let lng = -46.633308;

    // Se já existe link salvo com coordenadas
    const link = mapsLinkInput.value;
    const regex = /@(-?\d+\.\d+),(-?\d+\.\d+)/;
    const match = link.match(regex);
    if (match) {
        lat = parseFloat(match[1]);
        lng = parseFloat(match[2]);
    } else {
        // Se não tiver no link, tenta usar os inputs hidden
        if (latInput.value && lngInput.value) {
            lat = parseFloat(latInput.value);
            lng = parseFloat(lngInput.value);
        }
    }

    // Inicializa o mapa
    const map = L.map("map").setView([lat, lng], 15);

    // Camada gratuita OpenStreetMap
    L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
        attribution: "© OpenStreetMap contributors"
    }).addTo(map);

    // Marcador arrastável
    const marker = L.marker([lat, lng], { draggable: true }).addTo(map);

    // Atualiza endereço, link e coordenadas quando marcador é movido
    marker.on("dragend", async () => {
        const { lat, lng } = marker.getLatLng();
        atualizarCamposPorCoordenada(lat, lng);
    });

    // Clicar no mapa também move marcador
    map.on("click", (e) => {
        marker.setLatLng(e.latlng);
        atualizarCamposPorCoordenada(e.latlng.lat, e.latlng.lng);
    });

    // Quando o usuário digita manualmente um endereço
    let timeout = null;
    enderecoInput.addEventListener("input", () => {
        clearTimeout(timeout);
        timeout = setTimeout(async () => {
            const endereco = enderecoInput.value.trim();
            if (!endereco) return;

            try {
                const response = await fetch(
                    `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(endereco)}`
                );
                const data = await response.json();

                if (data.length > 0) {
                    const { lat, lon, display_name } = data[0];
                    const latitude = parseFloat(lat);
                    const longitude = parseFloat(lon);

                    // Atualiza mapa e marcador
                    marker.setLatLng([latitude, longitude]);
                    map.setView([latitude, longitude], 16);

                    // Atualiza link do Google Maps e coordenadas nos inputs
                    mapsLinkInput.value = `https://www.google.com/maps/place/${encodeURIComponent(display_name)}/@${latitude},${longitude},17z`;
                    latInput.value = latitude;
                    lngInput.value = longitude;
                }
            } catch (error) {
                console.error("Erro ao buscar endereço:", error);
            }
        }, 700);
    });

    // Função para atualizar campos quando marcador é movido
    async function atualizarCamposPorCoordenada(lat, lng) {
        try {
            const response = await fetch(
                `https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`
            );
            const data = await response.json();

            if (data && data.display_name) {
                enderecoInput.value = data.display_name;
                mapsLinkInput.value = `https://www.google.com/maps/place/${encodeURIComponent(
                    data.display_name
                )}/@${lat},${lng},17z`;

                // 👉 ESSA É A LINHA QUE FALTAVA
                latInput.value = lat;
                lngInput.value = lng;
            }
        } catch (error) {
            console.error("Erro ao obter endereço reverso:", error);
        }
    }
});
