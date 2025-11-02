# Weather Page Setup Guide

## Overview
The weather page provides real-time weather information for Indian cities with a clean, responsive design that matches the TravelTales website aesthetic.

## Features
- **Real-time Weather Data**: Current weather conditions for any Indian city
- **5-Day Forecast**: Extended weather predictions
- **Location-based Weather**: Get weather for your current location
- **Popular Cities**: Quick access to weather for major Indian cities
- **Responsive Design**: Works perfectly on desktop and mobile devices
- **Search Suggestions**: Auto-complete for Indian city names

## Files Added
- `weather.php` - Main weather page
- `public/js/weather.js` - Weather functionality and API integration
- `api/weather.php` - Backend API endpoint for weather data
- `WEATHER_SETUP.md` - This setup guide

## Current Implementation
The weather page currently uses **mock data** for demonstration purposes. This allows you to see the full functionality without requiring API keys.

## Setting Up Real Weather Data

### Option 1: OpenWeatherMap API (Recommended)
1. Sign up for a free account at [OpenWeatherMap](https://openweathermap.org/api)
2. Get your free API key
3. Replace `your_openweathermap_api_key_here` in `public/js/weather.js` with your actual API key
4. Update the API calls in `weather.js` to use real endpoints instead of mock data

### Option 2: Other Weather APIs
You can integrate with other weather services like:
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