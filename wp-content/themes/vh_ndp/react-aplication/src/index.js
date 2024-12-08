import React from 'react';
import ReactDOM from 'react-dom/client';
import App from './App';
import AppModal from './AppModal';
import AppEngineer from './AppEngineer';

const root = ReactDOM.createRoot(document.getElementById('root'));

if(process.env.REACT_APP_TYPE == 'engineer'){
  root.render(<AppEngineer />);
} else if(process.env.REACT_APP_TYPE == 'modal'){
  root.render(<AppModal /> );
} else {
  root.render( <App />);
}



