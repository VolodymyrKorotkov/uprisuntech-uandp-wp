import React from 'react'
import I18n from '../../../../../I18n/I18n'
import classNames from 'classnames'
import styles from '../../ResultModal.module.scss'
import global from '../../../../../../App.module.scss'

function PlaceAddress({data = {}}) {
  return (
    <div className={styles.modal_item}>
      <div className={styles.modal_row}>
        <div className={global.semi}><I18n text={'Place'} /></div>
      </div>
      <div className={styles.modal_row}>
        <div className={classNames(global.font_14, global.gray_color)}><I18n text='Property type'/></div>
        <div><I18n text={data?.property_type || ''}/></div> 
      </div>
      <div className={styles.modal_row}>
        <div className={classNames(global.font_14, global.gray_color)}><I18n text='State'/></div>
        <div>{data?.state || ''}</div> 
      </div>
      <div className={styles.modal_row}>
        <div className={classNames(global.font_14, global.gray_color)}><I18n text='City'/></div>
        <div>{data?.city || ''}</div> 
      </div>
      <div className={styles.modal_row}>
        <div className={classNames(global.font_14, global.gray_color)}><I18n text='Street'/></div>
        <div>{data?.street || ''} {data?.street_number || ''}</div> 
      </div>
      <div className={styles.modal_row}>
        <div className={classNames(global.font_14, global.gray_color)}><I18n text='Apartment #'/></div>
        <div>{data?.apartment || ''}</div> 
      </div>
      <div className={styles.modal_row}>
        <div className={classNames(global.font_14, global.gray_color)}><I18n text='Postal code'/></div>
        <div>{data?.postal_code || ''}</div> 
      </div>
    </div>
  )
}

export default PlaceAddress