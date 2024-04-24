function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition, handleError);
  } else {
    console.log("Geolocation is not supported by this browser.");
  }
}

function showPosition(position) {
  const latitude = position.coords.latitude;
  const longitude = position.coords.longitude;
  reverseGeocode(latitude, longitude);
}

function reverseGeocode(latitude, longitude) {
  const apiKey = "YOUR_GOOGLE_MAPS_API_KEY";
  const geocodingUrl = `https://maps.googleapis.com/maps/api/geocode/json?latlng=${latitude},${longitude}&key=${apiKey}`;

  fetch(geocodingUrl)
    .then(response => response.json())
    .then(data => {
      if (data.status === "OK") {
        const formattedAddress = data.results[0].formatted_address;
        document.getElementById("address").value = formattedAddress;
      } else {
        console.log("Reverse geocoding failed:", data.status);
      }
    })
    .catch(error => {
      console.error("Error fetching address:", error);
    });
}

function handleError(error) {
  switch (error.code) {
    case error.PERMISSION_DENIED:
      console.log("User denied the request for Geolocation.");
      break;
    case error.POSITION_UNAVAILABLE:
      console.log("Location information is unavailable.");
      break;
    case error.TIMEOUT:
      console.log("The request to get user location timed out.");
      break;
    case error.UNKNOWN_ERROR:
      console.log("An unknown error occurred.");
      break;
  }
}