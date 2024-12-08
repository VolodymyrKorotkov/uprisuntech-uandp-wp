import React from 'react'
import I18n from '../../../../I18n/I18n'
import styles from '../ResultModal.module.scss'
import global from '../../../../../App.module.scss'
import classNames from 'classnames'

function ElectricityProduction({data, currency}) {
  return (
    <div className={styles.modal_item}>
      <div className={styles.modal_row}>
        <div className={global.semi}><I18n text='Electricity production (kWh)'/></div>
      </div>
      <div className='row'>
        <div className='col-md-6'>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='January'/></div>
            <div>{data?.january || ''} <I18n text='kWh'/></div> 
          </div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='February'/></div>
            <div>{data?.february || ''} <I18n text='kWh'/></div> 
          </div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='March'/></div>
            <div>{data?.march || ''} <I18n text='kWh'/></div> 
          </div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='April'/></div>
            <div>{data?.april || ''} <I18n text='kWh'/></div> 
          </div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='May'/></div>
            <div>{data?.may || ''} <I18n text='kWh'/></div> 
          </div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='June'/></div>
            <div>{data?.june || ''} <I18n text='kWh'/></div> 
          </div>
        </div>
        <div className='col-md-6'>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='July'/></div>
            <div>{data?.july || ''} <I18n text='kWh'/></div> 
          </div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='August'/></div>
            <div>{data?.august || ''} <I18n text='kWh'/></div> 
          </div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='September'/></div>
            <div>{data?.september || ''} <I18n text='kWh'/></div> 
          </div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='October'/></div>
            <div>{data?.october || ''} <I18n text='kWh'/></div> 
          </div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='November'/></div>
            <div>{data?.november || ''} <I18n text='kWh'/></div> 
          </div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='December'/></div>
            <div>{data?.december || ''} <I18n text='kWh'/></div> 
          </div>
          
        </div>
      </div>
      <hr />
      <div className={styles.modal_row}>
        <div className={classNames(global.font_14, global.gray_color)}><I18n text='Economy level/Bill offset'/></div>
        <div>{data?.level_bill_offset || ''}%</div> 
      </div>
      <div className={styles.modal_row}>
        <div className={classNames(global.font_14, global.gray_color)}><I18n text='Economy level/Bill offset'/></div>
        <div>{data?.level || ''} <I18n text={currency}/></div> 
      </div>
    </div>
  )
}

export default ElectricityProduction