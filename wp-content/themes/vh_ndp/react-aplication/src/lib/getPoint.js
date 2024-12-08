import * as Geocode from 'react-geocode';


export function getPoint(address) {
  return Geocode.fromAddress(address, 'AIzaSyB9aUxEyR_wIGZSzvzFotwRZ_u5tjuTtlw').then(
    response => {
      const { lat, lng } = response.results[0].geometry.location;
      return { lat, lng };
    },
    error => {
      return null;
    }
  );
}

export function getAddress(placeId) {
  return Geocode.fromPlaceId(placeId, 'AIzaSyB9aUxEyR_wIGZSzvzFotwRZ_u5tjuTtlw').then(
    response => {
      console.log("🚀 ~ file: getPoint.js:22 ~ getAddress ~ response:", response)
      return {};
    },
    error => {
      console.log("🚀 ~ file: getPoint.js:26 ~ getAddress ~ error:", error)
      return null;
    }
  );
}

export function getAddress2(address) {
  return Geocode.fromAddress(address, 'AIzaSyB9aUxEyR_wIGZSzvzFotwRZ_u5tjuTtlw').then(
    response => {
      console.log("🚀 ~ file: getPoint.js:22 ~ getAddress ~ response:", response)
      return {};
    },
    error => {
      console.log("🚀 ~ file: getPoint.js:26 ~ getAddress ~ error:", error)
      return null;
    }
  );
}