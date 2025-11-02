# Weather Page Setup Guide

## Overview
The weather page provides real-time weather information for Indian cities with a clean, responsive design that matches the TravelTales website aesthetic.

## Features
- **Real-time Weather Data**: Current weather conditions for cities worldwide
- **5-Day Forecast**: Extended weather predictions with detailed information
- **Location-based Weather**: Get weather for your current location using GPS
- **Popular Cities**: Quick access to weather for major Indian cities
- **City Search**: Search for weather in any city with auto-complete suggestions
- **Responsive Design**: Works perfectly on desktop and mobile devices
- **Error Handling**: Graceful error handling with user-friendly messages

## Files Added
- `weather.php` - Main weather page
- `public/js/weather.js` - Weather functionality and API integration
- `api/weather.php` - Backend API endpoint for weather data
- `WEATHER_SETUP.md` - This setup guide

## Current Implementation
The weather page now uses **real weather data** from OpenWeatherMap API. The system fetches live weather information including current conditions and 5-day forecasts.

## Weather Data Source
The application is configured to use OpenWeatherMap API with the following features:
- Real-time current weather data
- 5-day weather forecasts
- Location-based weather (using GPS coordinates)
- Weather data for cities worldwide

## API Key Configuration
The weather system is currently configured with a working OpenWeatherMap API key. If you need to change the API key:

1. Update the API key in `api/weather.php` (line 11):
   ```php
   const OPENWEATHER_API_KEY = 'your_new_api_key_here';
   ```

2. Optionally update the API key in `public/js/weather.js` (line 2) if you plan to make direct client-side calls:
   ```javascript
   const WEATHER_API_KEY = "your_new_api_key_here";
   ```

### Alternative Weather APIs
You can integrate with other weather services by modifying the API endpoints in `api/weather.php`:
- WeatherAPI
- AccuWeather
- Weather Underground

## Navigation Integration
The weather page has been automatically added to the main navigation menu in both desktop and mobile views.

## Usage
1. Visit `/weather.php` on your website
2. Enter a city name or use your current location
3. View current weather and 5-day forecast
4. Click on popular cities for quick weather access

## Customization
- **Colors**: The page uses the same orange theme (`#f97316`) as the rest of the site
- **Icons**: Weather icons can be customized in the `getWeatherIcon()` function
- **Cities**: Popular cities list can be modified in `weather.js`
- **Layout**: All styling follows the existing TailwindCSS patterns

## API Endpoints
- `GET /api/weather.php?action=current&city=Mumbai` - Current weather
- `GET /api/weather.php?action=forecast&city=Mumbai` - 5-day forecast
- `GET /api/weather.php?action=current_coords&lat=19.0760&lon=72.8777` - Weather by coordinates
- `GET /api/weather.php?action=cities` - List of popular cities

## Browser Support
- Modern browsers with JavaScript enabled
- Geolocation API support for location-based weather
- Responsive design for all screen sizes

## Security Notes
- API keys should be stored securely (consider server-side proxy)
- Input validation is implemented for city names
- CORS headers are properly configured

## Future Enhancements
- Weather alerts and warnings
- Historical weather data
- Weather maps integration
- Push notifications for severe weather
- Favorite cities list
- Weather widgets for other pages

## Troubleshooting
- If weather data doesn't load, check browser console for errors
- Ensure JavaScript is enabled
- For location-based weather, allow location permissions
- Check API key validity if using real weather service

The weather page is now fully integrated into your TravelTales website and ready to use!