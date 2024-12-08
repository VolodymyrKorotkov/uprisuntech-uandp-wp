import classNames from 'classnames'
import React from 'react'
import global from '../../../../App.module.scss'
import { Button, Modal } from '@mui/material'
import I18n from '../../../I18n/I18n'
import styles from './LoginModal.module.scss'

function setCookie(name, value, daysToExpire = 30) {
  // Отримати поточну дату
  var date = new Date();

  // Додати кількість днів, на яку ви хочете встановити термін дії кукіса
  date.setTime(date.getTime() + (daysToExpire * 24 * 60 * 60 * 1000));

  // Створити рядок кукіса з іменем, значенням та терміном дії
  var expires = "expires=" + date.toUTCString();
  document.cookie = name + "=" + value + "; " + expires + "; path=/";
}

function LoginModal({open, onClose}) {
  return (
    <Modal style={{zIndex: 9999999}} className={global.c_modal_flex} open={open} onClose={onClose}>
      <div className={classNames(global.c_modal, global.c_modal_medium, styles.LoginModal)}>
        <div className={classNames(global.c_modal_body, styles.bg_gray, global.modal_table)}>
          <div className={styles.title}><I18n text='UANDP Account'/></div>
          <p><I18n text='Authorization with an additional integrated electronic identification system ID.GOV.UA'/></p>
          <div className={styles.actions}>
            <Button onClick={() => {

              setCookie('old_url', window.location.href)
              window.location.href="/wp-json/redirect/v1/redirect/"
            }} fullWidth className={classNames(styles.btn, styles.btn_solid)} type={'submit'} color={'primary'} >
              <I18n text='via ID GOV UA' />
            </Button>
            <Button fullWidth className={classNames(styles.btn, styles.btn_transparent)} type={'submit'} onClick={onClose} color={'primary'} >
              <I18n text='Cancel' />
            </Button>
          </div>
        </div>
      </div>
    </Modal>
  )
}

export default LoginModal