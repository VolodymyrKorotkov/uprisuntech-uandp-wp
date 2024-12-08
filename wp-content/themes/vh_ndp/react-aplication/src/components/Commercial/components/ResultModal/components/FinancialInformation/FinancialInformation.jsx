import classNames from 'classnames'
import React from 'react'
import I18n from '../../../../../I18n/I18n'
import styles from '../../ResultModal.module.scss'
import global from '../../../../../../App.module.scss'

function FinancialInformation({data = {}}) {
  return (
    <div className={styles.modal_box}>
      <h3 className={classNames(global.h3, 'mb-3')}><I18n text={'Financial information'} /></h3>
      <div className={styles.modal_block}>
        <div className={styles.modal_item}>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text={'Bill offset percentage'} /></div>
            <div>{data?.bill_offset_percentage || ''}%</div> 
          </div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text={'Preferred system price'} /></div>
            <div><I18n text='to' />  {data?.preferred_system_price || ''} <I18n text='USD' /></div> 
          </div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text={'Preferred term'} /></div>
            <div>{data?.preferred_term || ''} <I18n text='to' /> </div> 
          </div>
        </div>
      </div>
    </div>
  )
}

export default FinancialInformation