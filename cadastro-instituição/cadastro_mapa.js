// Inicializa o mapa
const map = L.map("map").setView([-23.5505, -46.6333], 13);

// Adiciona camada base do OpenStreetMap
L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
  attribution: "© OpenStreetMap",
}).addTo(map);

// Cria marcador arrastável
const marker = L.marker([-23.5505, -46.6333], { draggable: true }).addTo(map);

// Seletores dos campos
const latInput = document.getElementById("latitude");
const lonInput = document.getElementById("longitude");
const enderecoInput = document.getElementById("endereco");
const mapsLinkInput = document.getElementById("maps_link");

// Função auxiliar: atualiza o link do Google Maps
function atualizarLinkMaps(lat, lon) {
  const link = `https://www.google.com/maps?q=${lat},${lon}`;
  mapsLinkInput.value = link;
}

// Atualiza dados ao arrastar o marcador
marker.on("dragend", async (e) => {
  const { lat, lng } = e.target.getLatLng();
  latInput.value = lat.toFixed(6);
  lonInput.value = lng.toFixed(6);
  atualizarLinkMaps(lat, lng);

  // Geocodificação reversa (pegar endereço pelo lat/lon)
  const response = await fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`);
  const data = await response.json();
  if (data.display_name) enderecoInput.value = data.display_name;
});

// Atualiza posição ao clicar no mapa
map.on("click", async (e) => {
  const { lat, lng } = e.latlng;
  marker.setLatLng([lat, lng]);
  latInput.value = lat.toFixed(6);
  lonInput.value = lng.toFixed(6);
  atualizarLinkMaps(lat, lng);

  const response = await fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lng}&format=json`);
  const data = await response.json();
  if (data.display_name) enderecoInput.value = data.display_name;
});

// Atualiza mapa ao digitar endereço manualmente
enderecoInput.addEventListener("change", async () => {
  const endereco = enderecoInput.value.trim();
  if (!endereco) return;

  const response = await fetch(
    `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(endereco)}`
  );
  const data = await response.json();

  if (data && data.length > 0) {
    const { lat, lon } = data[0];
    map.setView([lat, lon], 15);
    marker.setLatLng([lat, lon]);
    latInput.value = lat;
    lonInput.value = lon;
    atualizarLinkMaps(lat, lon);
  }
});
