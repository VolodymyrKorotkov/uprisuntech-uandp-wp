import React, { useState } from 'react'
import global from "../../../../../../App.module.scss";
import styles from './MySolutionsLoad.module.scss';
import classNames from 'classnames';
import I18n from '../../../../../I18n/I18n';

function MySolutionsLoad({uploadCart}) {

  

  return (
    <div className={global.box}>
      <div className={styles.load_text}><I18n text='You have previously chosen solutions. Load them here?'/></div>
      <a href='#' onClick={uploadCart} className={classNames(global.btns, global.btns_blue)}>
        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M15.3397 9.66902C15.1314 11.6264 14.0223 13.4607 12.187 14.5203C9.13793 16.2807 5.23904 15.236 3.47864 12.1869L3.29114 11.8621M2.6596 8.32949C2.86795 6.37207 3.97704 4.53778 5.81228 3.4782C8.8614 1.71779 12.7603 2.7625 14.5207 5.81161L14.7082 6.13637M2.61987 13.5488L3.16891 11.4997L5.21795 12.0488M12.7818 5.94974L14.8308 6.49878L15.3799 4.44974" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span><I18n text='Yes, load my solutions'/></span>
      </a>
    </div>
  )
}

export default MySolutionsLoad