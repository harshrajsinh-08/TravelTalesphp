let planMap;
let planMarker;

function handleSearch() {
  const searchInput = document.getElementById('searchInput');
  const destination = searchInput.value.trim();

  if (!destination) {
    alert('Please enter a city name.');
    return;
  }

  // "Plan Your Trip" section tak smooth scroll karte hain
  const planTripSection = document.getElementById('plan-trip');
  planTripSection.scrollIntoView({ behavior: 'smooth' });

  // Neeche wale input mein bhi same destination set kar dete hain
  document.getElementById('destinationInput').value = destination;

  // Trip data fetch karte hain aur map + card show karte hain
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

  // Plan Trip section tak smooth scroll karte hain
  document.getElementById('plan-trip').scrollIntoView({ behavior: 'smooth' });

  // City ke liye map show karte hain
  showPlanMap(destination); // Leaflet map initialize karta hai searched city ke saath

  // Pehle card ko hidden kar dete hain loading ke time
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

        // City ka header banate hain
        html += `
          <div class="text-center">
            <h3 class="text-3xl font-bold text-gray-800 mb-2">${cityName}</h3>
            <p class="text-gray-500 text-sm italic">Discover top attractions and travel tips</p>
          </div>
        `;

        // City ki image add karte hain agar available hai
        if (data.city_image) {
          html += `
            <img src="${data.city_image}" 
                 class="w-full h-64 object-cover rounded-xl shadow-md" 
                 alt="${cityName}"/>`;
        }

        // Travel information display karte hain
        html += `
          <div class="bg-gray-50 p-4 rounded-lg shadow-sm space-y-2">
            <p class="text-gray-600"><strong>How to Reach:</strong> ${data.how_to_reach || 'Information not available'}</p>
            <p class="text-gray-600"><strong>Nearest Railway Station:</strong> ${data.nearest_station || 'N/A'}</p>
            <p class="text-gray-600"><strong>Nearest Airport:</strong> ${data.nearest_airport || 'N/A'}</p>
          </div>
        `;

        // Attractions ki list banate hain
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

      // Map ke baad card show karte hain
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

  // OpenStreetMap API se city ka location fetch karte hain
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

      // Agar map pehle se nahi hai toh naya banate hain
      if (!planMap) {
        planMap = L.map("map").setView([lat, lon], 12);
        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
          attribution: "&copy; OpenStreetMap contributors",
        }).addTo(planMap);
      } else {
        planMap.setView([lat, lon], 12);
      }

      // Marker add karte hain ya update karte hain
      if (planMarker) {
        planMarker.setLatLng([lat, lon]);
      } else {
        planMarker = L.marker([lat, lon]).addTo(planMap);
      }
    })
    .catch((err) => console.error(err));
}
