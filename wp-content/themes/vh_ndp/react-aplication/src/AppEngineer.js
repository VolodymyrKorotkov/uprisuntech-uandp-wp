import { useEffect, useState } from 'react';
import styles from './App.module.scss';
import classNames from 'classnames';
import Engineer from './components/Engineer/Engineer';

function AppEngineer() {
  const [type, setType] = useState('');
  useEffect(() => {
    if(localStorage.getItem('isLoggedIn') == '1'){
      setType('login')
    }
  }, [])
  return (
    <div className={classNames(styles.App)}>
      <Engineer />
    </div>
  );
}

export default AppEngineer;
