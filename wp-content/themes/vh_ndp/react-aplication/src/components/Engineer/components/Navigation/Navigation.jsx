import React from 'react'
import styles from './Navigation.module.scss'
import { Button } from '@mui/material'
import classNames from 'classnames'
import I18n from '../../../I18n/I18n'

function Navigation({links = [], activeNavigate, status, onGetStarted, onSaveSubmit, onReturnToApplicant, onReject, onCancel}) {
  return (
    <div className={styles.Navigation}>
      <div className={styles.content}>
        {links.map(_i => 
          <div 
            key={_i.title} 
            onClick={_i.disabled ? null : _i.onClick} 
            className={classNames(styles.item, {[styles.active]: _i.title == activeNavigate, [styles.disabled]: _i.disabled})}
          >
            <div className={styles.icon}>
              {_i.valid ? <svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 18 14" fill="none">
                <path d="M6.00003 11.1701L1.83003 7.00009L0.410034 8.41009L6.00003 14.0001L18 2.00009L16.59 0.590088L6.00003 11.1701Z" fill="#2A59BD"/>
              </svg> : 
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 16C14.2091 16 16 14.2091 16 12C16 9.79086 14.2091 8 12 8C9.79086 8 8 9.79086 8 12C8 14.2091 9.79086 16 12 16ZM18 12C18 15.3137 15.3137 18 12 18C8.68629 18 6 15.3137 6 12C6 8.68629 8.68629 6 12 6C15.3137 6 18 8.68629 18 12Z" fill={_i.disabled ? "#8A90A5" :"#2A59BD"}/>
              </svg>}
            </div>
            <div><I18n text={_i.title}/></div>
          </div>
        )}
      </div>
      <div className={styles.button}>
        {(status == 'await' || status =='pending') && <Button fullWidth className={classNames(styles.btn,styles.btn_solid)} onClick={onGetStarted}><I18n text='Get started'/></Button>}
        {status == 'in progress' && <Button fullWidth className={classNames(styles.btn,styles.btn_solid)} onClick={onSaveSubmit} disabled={links.some(_i => !_i.valid)}><I18n text='Submit'/></Button>}
        {status == 'in progress' && <Button fullWidth className={classNames(styles.btn, styles.btn_color)} onClick={onReturnToApplicant}><I18n text='Return to applicant'/></Button>}
        {status == 'in progress' && <Button fullWidth className={classNames(styles.btn, styles.btn_transparent)} onClick={onReject}><I18n text='Reject'/></Button>}
        {(status == 'await' || status =='pending') && <Button fullWidth className={classNames(styles.btn, styles.btn_transparent)} disabled onClick={onCancel}><I18n text='Cancel'/></Button>}

        {(status == 'reject' || status == 'rejected') && <Button fullWidth className={classNames(styles.btn, styles.btn_transparent)} disabled><I18n text='Rejected'/></Button>}
        {(status == 'submitted' || status == 'processed') && <Button fullWidth className={classNames(styles.btn, styles.btn_transparent)} disabled><I18n text='Submitted'/></Button>}
        {(status == 'returned to applicant' || status == 'returned') && <Button fullWidth className={classNames(styles.btn, styles.btn_transparent)} disabled><I18n text='Return to applicant'/></Button>}


      </div>
    </div>
  )
}

export default Navigation