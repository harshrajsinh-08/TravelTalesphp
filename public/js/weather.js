// Weather API configuration
const WEATHER_API_KEY = "0803af3c4dd129fe61e0256095fc930f"; // Replace with actual API key
const WEATHER_API_BASE = "https://api.openweathermap.org/data/2.5";

// Popular Indian cities for quick weather display
const popularCities = [
  "Mumbai",
  "Delhi",
  "Bangalore",
  "Chennai",
  "Kolkata",
  "Hyderabad",
];

// Initialize weather page
document.addEventListener("DOMContentLoaded", function () {
  // Load popular cities weather on page load
  loadPopularCitiesWeather();

  // Add enter key listener to city input
  document
    .getElementById("cityInput")
    .addEventListener("keypress", function (e) {
      if (e.key === "Enter") {
        searchWeather();
      }
    });

  // Add input listener for city suggestions
  document
    .getElementById("cityInput")
    .addEventListener("input", debounce(showCitySuggestions, 300));
});

// Debounce function to limit API calls
function debounce(func, wait) {
  let timeout;
  return function executedFunction(...args) {
    const later = () => {
      clearTimeout(timeout);
      func(...args);
    };
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
}

// Show loading modal
function showLoading() {
  document.getElementById("loadingModal").classList.remove("hidden");
}

// Hide loading modal
function hideLoading() {
  document.getElementById("loadingModal").classList.add("hidden");
}

// Show error modal
function showError(message) {
  document.getElementById("errorMessage").textContent = message;
  document.getElementById("errorModal").classList.remove("hidden");
}

// Close error modal
function closeErrorModal() {
  document.getElementById("errorModal").classList.add("hidden");
}

// Search weather for entered city
async function searchWeather() {
  const cityInput = document.getElementById("cityInput");
  const city = cityInput.value.trim();

  if (!city) {
    showError("Please enter a city name");
    return;
  }

  await getWeatherData(city);
}

// Search weather by city name (for popular cities)
async function searchWeatherByCity(cityName) {
  document.getElementById("cityInput").value = cityName;
  await getWeatherData(cityName);
}

// Get weather by coordinates (for location-based weather)
async function getWeatherByLocation() {
  if (!navigator.geolocation) {
    showError("Geolocation is not supported by this browser.");
    return;
  }

  showLoading();

  navigator.geolocation.getCurrentPosition(
    async (position) => {
      try {
        const lat = position.coords.latitude;
        const lon = position.coords.longitude;

        // Fetch current weather by coordinates
        const currentResponse = await fetch(`/api/weather.php?action=current_coords&lat=${lat}&lon=${lon}`);
        if (!currentResponse.ok) {
          throw new Error('Failed to fetch current weather');
        }
        const currentWeatherData = await currentResponse.json();

        if (currentWeatherData.error) {
          throw new Error(currentWeatherData.message);
        }

        // Update city input with the location name
        document.getElementById("cityInput").value = currentWeatherData.name;

        // Fetch forecast using the city name
        const forecastResponse = await fetch(`/api/weather.php?action=forecast&city=${encodeURIComponent(currentWeatherData.name)}`);
        if (!forecastResponse.ok) {
          throw new Error('Failed to fetch weather forecast');
        }
        const forecastData = await forecastResponse.json();

        if (forecastData.error) {
          throw new Error(forecastData.message);
        }

        displayCurrentWeather(currentWeatherData);
        displayForecast(forecastData);

        hideLoading();

        // Show weather sections
        document.getElementById("currentWeatherSection").classList.remove("hidden");
        document.getElementById("forecastSection").classList.remove("hidden");

        // Scroll to weather section
        document.getElementById("currentWeatherSection").scrollIntoView({
          behavior: "smooth",
          block: "start",
        });
      } catch (error) {
        hideLoading();
        showError("Failed to fetch weather data for your location. Please try again.");
        console.error("Location Weather API Error:", error);
      }
    },
    (error) => {
      hideLoading();
      let errorMessage = "Unable to retrieve your location. ";
      switch (error.code) {
        case error.PERMISSION_DENIED:
          errorMessage += "Please allow location access and try again.";
          break;
        case error.POSITION_UNAVAILABLE:
          errorMessage += "Location information is unavailable.";
          break;
        case error.TIMEOUT:
          errorMessage += "Location request timed out.";
          break;
        default:
          errorMessage += "An unknown error occurred.";
          break;
      }
      showError(errorMessage);
    },
    {
      timeout: 10000,
      enableHighAccuracy: true
    }
  );
}



// Get weather data by city name
async function getWeatherData(city) {
  showLoading();

  try {
    // Fetch current weather
    const currentResponse = await fetch(`/api/weather.php?action=current&city=${encodeURIComponent(city)}`);
    if (!currentResponse.ok) {
      throw new Error('Failed to fetch current weather');
    }
    const currentWeatherData = await currentResponse.json();

    if (currentWeatherData.error) {
      throw new Error(currentWeatherData.message);
    }

    // Fetch forecast
    const forecastResponse = await fetch(`/api/weather.php?action=forecast&city=${encodeURIComponent(city)}`);
    if (!forecastResponse.ok) {
      throw new Error('Failed to fetch weather forecast');
    }
    const forecastData = await forecastResponse.json();

    if (forecastData.error) {
      throw new Error(forecastData.message);
    }

    displayCurrentWeather(currentWeatherData);
    displayForecast(forecastData);

    hideLoading();

    // Show weather sections
    document.getElementById("currentWeatherSection").classList.remove("hidden");
    document.getElementById("forecastSection").classList.remove("hidden");

    // Scroll to weather section
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



// Display current weather
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

  // Update detail cards
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

// Display 5-day forecast
function displayForecast(data) {
  const forecastContainer = document.getElementById("forecastContainer");
  forecastContainer.innerHTML = "";

  // Group forecast by day (take one forecast per day)
  const dailyForecasts = [];
  const processedDates = new Set();

  data.list.forEach((item) => {
    const date = new Date(item.dt * 1000).toDateString();
    if (!processedDates.has(date) && dailyForecasts.length < 5) {
      dailyForecasts.push(item);
      processedDates.add(date);
    }
  });

  dailyForecasts.forEach((forecast, index) => {
    const date = new Date(forecast.dt * 1000);
    const dayName =
      index === 0
        ? "Today"
        : date.toLocaleDateString("en-US", { weekday: "short" });
    const weatherIcon = getWeatherIcon(forecast.weather[0].main);
    const temp = Math.round(forecast.main.temp);
    const description = forecast.weather[0].description;

    const forecastCard = document.createElement("div");
    forecastCard.className = "forecast-card";
    forecastCard.innerHTML = `
            <h4 class="font-semibold text-gray-800 mb-2">${dayName}</h4>
            <div class="text-4xl mb-2">${weatherIcon}</div>
            <p class="text-2xl font-bold text-gray-800 mb-1">${temp}°C</p>
            <p class="text-sm text-gray-600 capitalize">${description}</p>
            <div class="mt-2 text-xs text-gray-500">
                <p>Humidity: ${forecast.main.humidity}%</p>
            </div>
        `;

    forecastContainer.appendChild(forecastCard);
  });
}

// Load weather for popular cities
async function loadPopularCitiesWeather() {
  for (const city of popularCities) {
    try {
      const response = await fetch(`/api/weather.php?action=current&city=${encodeURIComponent(city)}`);
      if (!response.ok) {
        throw new Error('Failed to fetch weather');
      }
      
      const weatherData = await response.json();
      if (weatherData.error) {
        throw new Error(weatherData.message);
      }

      const cityId = city.toLowerCase();
      const tempElement = document.getElementById(`${cityId}-temp`);
      const descElement = document.getElementById(`${cityId}-desc`);
      
      if (tempElement && descElement) {
        tempElement.textContent = `${Math.round(weatherData.main.temp)}°C`;
        descElement.textContent = weatherData.weather[0].description;
      }
    } catch (error) {
      console.error(`Failed to load weather for ${city}:`, error);
      // Fallback to show placeholder text
      const cityId = city.toLowerCase();
      const tempElement = document.getElementById(`${cityId}-temp`);
      const descElement = document.getElementById(`${cityId}-desc`);
      
      if (tempElement && descElement) {
        tempElement.textContent = '--°C';
        descElement.textContent = 'Unable to load';
      }
    }
  }
}

// Show city suggestions (mock implementation)
function showCitySuggestions() {
  const input = document.getElementById("cityInput");
  const query = input.value.trim().toLowerCase();
  const resultsContainer = document.getElementById("citySearchResults");

  if (query.length < 2) {
    resultsContainer.classList.add("hidden");
    return;
  }

  // Mock Indian cities for suggestions
  const indianCities = [
    "Mumbai",
    "Delhi",
    "Bangalore",
    "Chennai",
    "Kolkata",
    "Hyderabad",
    "Pune",
    "Ahmedabad",
    "Jaipur",
    "Surat",
    "Lucknow",
    "Kanpur",
    "Nagpur",
    "Indore",
    "Thane",
    "Bhopal",
    "Visakhapatnam",
    "Pimpri-Chinchwad",
    "Patna",
    "Vadodara",
    "Ghaziabad",
    "Ludhiana",
    "Agra",
    "Nashik",
  ];

  const suggestions = indianCities
    .filter((city) => city.toLowerCase().includes(query))
    .slice(0, 5);

  if (suggestions.length > 0) {
    resultsContainer.innerHTML = suggestions
      .map(
        (city) =>
          `<div class="px-4 py-2 hover:bg-gray-100 cursor-pointer" onclick="selectCity('${city}')">${city}</div>`
      )
      .join("");
    resultsContainer.classList.remove("hidden");
  } else {
    resultsContainer.classList.add("hidden");
  }
}

// Select city from suggestions
function selectCity(city) {
  document.getElementById("cityInput").value = city;
  document.getElementById("citySearchResults").classList.add("hidden");
  searchWeatherByCity(city);
}

// Get weather icon based on weather condition
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



// Hide city suggestions when clicking outside
document.addEventListener("click", function (e) {
  const cityInput = document.getElementById("cityInput");
  const resultsContainer = document.getElementById("citySearchResults");

  if (!cityInput.contains(e.target) && !resultsContainer.contains(e.target)) {
    resultsContainer.classList.add("hidden");
  }
});
