// Weather API ki configuration
const WEATHER_API_KEY = "0803af3c4dd129fe61e0256095fc930f"; // Yahan apni actual API key daal dena
const WEATHER_API_BASE = "https://api.openweathermap.org/data/2.5";



// Weather page initialize karte hain
document.addEventListener("DOMContentLoaded", function () {
  // City input mein enter key listener add karte hain
  document
    .getElementById("cityInput")
    .addEventListener("keypress", function (e) {
      if (e.key === "Enter") {
        searchWeather();
      }
    });
});



// Loading modal show karte hain
function showLoading() {
  document.getElementById("loadingModal").classList.remove("hidden");
}

// Loading modal hide karte hain
function hideLoading() {
  document.getElementById("loadingModal").classList.add("hidden");
}

// Error modal show karte hain
function showError(message) {
  document.getElementById("errorMessage").textContent = message;
  document.getElementById("errorModal").classList.remove("hidden");
}

// Error modal close karte hain
function closeErrorModal() {
  document.getElementById("errorModal").classList.add("hidden");
}

// User ke enter kiye gaye city ka weather search karte hain
async function searchWeather() {
  const cityInput = document.getElementById("cityInput");
  const city = cityInput.value.trim();

  if (!city) {
    showError("Please enter a city name");
    return;
  }

  await getWeatherData(city);
}







// City name se weather data fetch karte hain
async function getWeatherData(city) {
  showLoading();

  try {
    // Current weather fetch karte hain
    const currentResponse = await fetch(`/api/weather.php?action=current&city=${encodeURIComponent(city)}`);
    if (!currentResponse.ok) {
      throw new Error('Failed to fetch current weather');
    }
    const currentWeatherData = await currentResponse.json();

    if (currentWeatherData.error) {
      throw new Error(currentWeatherData.message);
    }

    displayCurrentWeather(currentWeatherData);

    hideLoading();

    // Weather section show karte hain
    document.getElementById("currentWeatherSection").classList.remove("hidden");

    // Weather section tak scroll karte hain
    document.getElementById("currentWeatherSection").scrollIntoView({
      behavior: "smooth",
      block: "start",
    });
  } catch (error) {
    hideLoading();
    showError("Failed to fetch weather data. Please try again.");
    console.error("Weather API Error:", error);
  }
}



// Current weather display karte hain
function displayCurrentWeather(data) {
  const currentWeatherCard = document.getElementById("currentWeatherCard");

  const weatherIcon = getWeatherIcon(data.weather[0].main);
  const temperature = Math.round(data.main.temp);
  const description = data.weather[0].description;
  const cityName = data.name;
  const country = data.sys.country;

  currentWeatherCard.innerHTML = `
        <div class="flex flex-col md:flex-row items-center justify-between">
            <div class="flex items-center gap-6 mb-4 md:mb-0">
                <div class="weather-icon text-6xl">
                    ${weatherIcon}
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-gray-800">${temperature}°C</h3>
                    <p class="text-xl text-gray-600 capitalize">${description}</p>
                    <p class="text-lg text-gray-500">
                        <i class="bi bi-geo-alt"></i> ${cityName}, ${country}
                    </p>
                </div>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">Last updated</p>
                <p class="text-sm text-gray-600">${new Date().toLocaleTimeString()}</p>
                <div class="mt-4 flex gap-4">
                    <div class="text-center">
                        <p class="text-sm text-gray-500">High</p>
                        <p class="text-lg font-semibold">${Math.round(
                          data.main.temp_max
                        )}°</p>
                    </div>
                    <div class="text-center">
                        <p class="text-sm text-gray-500">Low</p>
                        <p class="text-lg font-semibold">${Math.round(
                          data.main.temp_min
                        )}°</p>
                    </div>
                </div>
            </div>
        </div>
    `;

  // Detail cards update karte hain
  document.getElementById("feelsLike").textContent = `${Math.round(
    data.main.feels_like
  )}°C`;
  document.getElementById("humidity").textContent = `${data.main.humidity}%`;
  document.getElementById("windSpeed").textContent = `${Math.round(
    data.wind.speed * 3.6
  )} km/h`;
  document.getElementById("visibility").textContent = `${(
    data.visibility / 1000
  ).toFixed(1)} km`;
}







// Weather condition ke hisaab se icon return karte hain
function getWeatherIcon(condition) {
  const icons = {
    Clear: "☀️",
    Clouds: "☁️",
    Rain: "🌧️",
    Drizzle: "🌦️",
    Thunderstorm: "⛈️",
    Snow: "❄️",
    Mist: "🌫️",
    Fog: "🌫️",
    Haze: "🌫️",
  };

  return icons[condition] || "🌤️";
}


