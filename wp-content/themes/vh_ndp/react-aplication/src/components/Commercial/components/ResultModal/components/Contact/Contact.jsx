import React from 'react'
import I18n from '../../../../../I18n/I18n'
import classNames from 'classnames'
import styles from '../../ResultModal.module.scss'
import global from '../../../../../../App.module.scss'

function Contact({data = {}}) {
  return (
    <div className={styles.modal_box}>
      <h3 className={classNames(global.h3, 'mb-3')}><I18n text='Contact'/></h3>
      <div className={styles.modal_block}>
        <div className={styles.modal_item}>
          {/* <div className={styles.modal_row}>
            <div className={global.semi}><I18n text='About'/></div>
          </div> */}
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='Full name'/></div>
            <div>{data?.last_name} {data?.first_name} {data?.middle_name}</div> 
          </div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}>
              <I18n text='Email (login ID)'/><br/>
              <I18n text='This email will be used for account authorization'/>
            </div>
            <div>{data.email}</div> 
          </div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='Mobile phone'/></div>
            <div>{data.phone}</div> 
          </div>
        </div>
      </div>
    </div>
  )
}

export default Contact