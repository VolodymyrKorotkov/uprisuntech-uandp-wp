import { useEffect, useState } from 'react';
import styles from './App.module.scss';
import Commercial from './components/Commercial/Commercial';
import I18n from './components/I18n/I18n';
import classNames from 'classnames';
import Login from './components/Login/Login';

function App() {
  const [loaded, setLoaded] = useState(false)
  const [login, setLogin] = useState(false);
  const [type, setType] = useState('');
  useEffect(() => {
    if(localStorage.getItem('isLoggedIn') == '1'){
      setType('login')
    }
    setTimeout(() => {
      setLoaded(true)
    }, 100);
  }, [])


  if(!loaded){
    return null;
  }


  if(login){
    return <div className={classNames(styles.App, {[styles.center]: true})}>
      <Login onBack={() => setLogin(false)} />
    </div>
  }

  return (
    <div className={classNames(styles.App, {[styles.center]: !type})}>
      {!type && <div className={styles.type_aplication}>
        <div className={styles.content}>
          <div className={styles.text}><I18n text='Create Application' /></div>
          <div className={styles.title}><I18n text="Do you have an account?" /></div>
          <div className={styles.actions}>
            <div className={styles.btn} onClick={() => {
              setType('not_login');
              localStorage.setItem('app_type', 'not_login');
            }}>
              <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                <mask id="mask0_4457_3464"  maskUnits="userSpaceOnUse" x="0" y="0" width="40" height="40">
                  <rect width="40" height="40" fill="#D9D9D9"/>
                </mask>
                <g mask="url(#mask0_4457_3464)">
                  <path d="M28.0557 30V10H30.8334V30H28.0557ZM9.16675 30V10L23.7778 20L9.16675 30ZM11.9445 24.7223L18.8612 20L11.9445 15.2778V24.7223Z" fill="#2A59BD"/>
                </g>
              </svg>
              <div className={styles.text}><I18n text={'Do it later'} /></div>
            </div>
            <div className={styles.btn} onClick={() => {
                setLogin(true)
            }}>
              <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                <mask id="mask0_4457_18585"  maskUnits="userSpaceOnUse" x="0" y="0" width="40" height="40">
                  <rect width="40" height="40" fill="#D9D9D9"/>
                </mask>
                <g mask="url(#mask0_4457_18585)">
                  <path d="M7.77775 35C7.02775 35 6.37729 34.7245 5.82637 34.1736C5.27546 33.6227 5 32.9722 5 32.2222V7.77775C5 7.02775 5.27546 6.37729 5.82637 5.82638C6.37729 5.27546 7.02775 5 7.77775 5H19.9722V7.77775H7.77775V32.2222H19.9722V35H7.77775ZM27.3889 27.6389L25.4306 25.6389L29.6806 21.3889H15V18.6111H29.625L25.375 14.3611L27.3333 12.3611L35 20.0278L27.3889 27.6389Z" fill="#2A59BD"/>
                </g>
              </svg>
              <div className={styles.text} ><I18n text={'Login via ID.GOV.UA'} /></div>
            </div>
            
          </div>
        </div>
      </div>}
      {type != '' && <Commercial />}
    </div>
  );
}

export default App;
