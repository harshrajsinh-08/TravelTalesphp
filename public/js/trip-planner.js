let planMap;
let planMarker;
function handleSearch() {
  const searchInput = document.getElementById('searchInput');
  const destination = searchInput.value.trim();

  if (!destination) {
    alert('Please enter a city name.');
    return;
  }

  // Scroll smoothly to the "Plan Your Trip" section
  const planTripSection = document.getElementById('plan-trip');
  planTripSection.scrollIntoView({ behavior: 'smooth' });

  // Set the value of the bottom input to the same destination
  document.getElementById('destinationInput').value = destination;

  // Fetch the trip data and show map + card
  fetchTripData();
}
function fetchTripData(cityName = null) {
  const destinationInput = document.getElementById('destinationInput');
  const destination = cityName || destinationInput.value.trim();
  const card = document.getElementById('location-card');
  const mapContainer = document.getElementById('map');

  if (!destination) {
    alert('Please enter a city name.');
    return;
  }

  // Smooth scroll to Plan Trip section
  document.getElementById('plan-trip').scrollIntoView({ behavior: 'smooth' });

  // --- Show Map for the City ---
  showPlanMap(destination); // This should initialize Leaflet map with the searched city

  // First, make the card hidden while loading
  card.classList.add('hidden', 'opacity-0');

  fetch('api/fetchtrips.php?city=' + encodeURIComponent(destination))
    .then(res => res.json())
    .then(data => {
      let html = "";

      if (!data.attractions || data.attractions.length === 0) {
        html = `
          <div class="text-center text-gray-500 text-lg py-6">
            No attractions found for <span class="font-semibold">${destination}</span>.
          </div>`;
      } else {
        const cityName = destination.toUpperCase();
        html = `<div class="space-y-6">`;

        // City Header
        html += `
          <div class="text-center">
            <h3 class="text-3xl font-bold text-gray-800 mb-2">${cityName}</h3>
            <p class="text-gray-500 text-sm italic">Discover top attractions and travel tips</p>
          </div>
        `;

        // City Image
        if (data.city_image) {
          html += `
            <img src="${data.city_image}" 
                 class="w-full h-64 object-cover rounded-xl shadow-md" 
                 alt="${cityName}"/>`;
        }

        // Travel Info
        html += `
          <div class="bg-gray-50 p-4 rounded-lg shadow-sm space-y-2">
            <p class="text-gray-600"><strong>How to Reach:</strong> ${data.how_to_reach || 'Information not available'}</p>
            <p class="text-gray-600"><strong>Nearest Railway Station:</strong> ${data.nearest_station || 'N/A'}</p>
            <p class="text-gray-600"><strong>Nearest Airport:</strong> ${data.nearest_airport || 'N/A'}</p>
          </div>
        `;

        // Attractions List
        html += `<ul class="space-y-3">`;
        data.attractions.forEach(a => {
          html += `
            <li class="flex justify-between items-center bg-white px-4 py-3 rounded-lg shadow-sm hover:shadow-md transition">
              <span class="text-gray-700 font-medium">${a.name}</span>
              <span class="text-orange-500 font-semibold">${a.price_range}</span>
            </li>`;
        });
        html += `</ul></div>`;
      }

      // --- Show the card after the map ---
      card.innerHTML = html;
      card.classList.remove('hidden');
      setTimeout(() => card.classList.remove('opacity-0'), 50);
    })
    .catch(err => {
      console.error(err);
      alert('Failed to fetch trip data.');
    });
}

function showPlanMap(city) {
  const mapDiv = document.getElementById("map");
  mapDiv.classList.remove("hidden");

  fetch(
    `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(
      city + ", India"
    )}`
  )
    .then((res) => res.json())
    .then((data) => {
      if (!data || data.length === 0) {
        alert("Could not find this location on the map.");
        return;
      }

      const lat = parseFloat(data[0].lat);
      const lon = parseFloat(data[0].lon);

      if (!planMap) {
        planMap = L.map("map").setView([lat, lon], 12);
        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
          attribution: "&copy; OpenStreetMap contributors",
        }).addTo(planMap);
      } else {
        planMap.setView([lat, lon], 12);
      }

      if (planMarker) {
        planMarker.setLatLng([lat, lon]);
      } else {
        planMarker = L.marker([lat, lon]).addTo(planMap);
      }
    })
    .catch((err) => console.error(err));
}
