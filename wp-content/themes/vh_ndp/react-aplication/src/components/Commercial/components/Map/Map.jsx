import React, { useCallback, useEffect, useRef, useState } from 'react'
import {
  useLoadScript,
  Marker,
  GoogleMap
} from "@react-google-maps/api";

const config = {
  googleMapsApiKey: "AIzaSyB9aUxEyR_wIGZSzvzFotwRZ_u5tjuTtlw",
  version: "weekly",
  libraries: ["places"],
};


function Map({lat, lng}) {
  const { isLoaded, loadError } = useLoadScript(config);
  const center = lat && lng ? {lat, lng} : { lat: 50.453624, lng: 30.520287 };
  const marker = lat && lng ? {lat, lng} : null;
  const [position, setPosition] = useState(marker);

  useEffect(() => {
    setPosition(marker)
  }, [lat, lng])
  
  const onLoad = React.useCallback(function callback(map) {
    
  }, [])
  
  if(!isLoaded){
    return null;
  }


  return (
    <GoogleMap
      id="searchbox-example"
      mapContainerStyle={{
        height: "320px",
        width: "100%"
      }}
      zoom={10}
      center={center}
      onLoad={onLoad}
    >
      {Boolean(position) && <Marker
        position={position}
      />}
    </GoogleMap>
  )
}

export default Map