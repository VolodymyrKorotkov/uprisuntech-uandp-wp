import React from 'react'
import I18n from '../../../../I18n/I18n'
import styles from '../ResultModal.module.scss'
import global from '../../../../../App.module.scss'
import classNames from 'classnames'

function FinancingOption({data, currency}) {
  return (
    <div className={styles.modal_item}>
      <div className={styles.modal_row}>
        <div className={global.semi}><I18n text='Financing option'/></div>
      </div>
      <div className={styles.modal_row}>
        <div className={classNames(global.font_14, global.gray_color)}><I18n text='Term'/></div>
        <div>{data?.term_months || '-'} {data?.term_months ? <I18n text='month'/> : ''}</div> 
      </div>
      <div className={styles.modal_row}>
        <div className={classNames(global.font_14, global.gray_color)}><I18n text='Down Payment'/></div>
        <div>{data?.down_payment || '-'} {data?.down_payment ? <I18n text={currency}/> : ''}</div> 
      </div>
      <div className={styles.modal_row}>
        <div className={classNames(global.font_14, global.gray_color)}><I18n text='Interest rate'/></div>
        <div>{data?.interest_rate || '-'}{data?.interest_rate ? '%' : ''}</div> 
      </div>
      <div className={styles.modal_row}>
        <div className={classNames(global.font_14, global.gray_color)}><I18n text='Monthly payment'/></div>
        <div>{data?.monthly_payment || '-'} {data?.monthly_payment ? <I18n text={currency}/> : ''}</div> 
      </div>
    </div>
  )
}

export default FinancingOption