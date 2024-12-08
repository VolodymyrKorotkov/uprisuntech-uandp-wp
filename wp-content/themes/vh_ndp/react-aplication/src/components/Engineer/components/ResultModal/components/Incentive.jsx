import React from 'react'
import I18n from '../../../../I18n/I18n'
import styles from '../ResultModal.module.scss'
import global from '../../../../../App.module.scss'
import classNames from 'classnames'

function Incentive({data, currency, system_price = {}}) {
  let total = 0;

  if(system_price?.solution_cost && !isNaN(parseFloat(system_price?.solution_cost))){
    total +=parseFloat(system_price?.solution_cost);
  }

  if(system_price?.installation_cost && !isNaN(parseFloat(system_price?.installation_cost))){
    total +=parseFloat(system_price?.installation_cost);
  } 

  (system_price?.additions || []).map((_i, index) => {
    if(_i?.addition_cost && !isNaN(parseFloat(_i.addition_cost)) && _i?.quantity && !isNaN(parseFloat(_i.quantity))){
      total += parseFloat(_i.addition_cost) * parseFloat(_i.quantity);
    }
  })

  const result = data.type == 'UAH' ? data.incentive ? total - parseFloat(data.incentive) : '' : data.incentive ?  Math.round((total - (total/100 *data.incentive))*100)/100 : '';



  return (
    <div className={styles.modal_item}>
      <div className={styles.modal_row}>
        <div className={global.semi}><I18n text='Incentive'/></div>
      </div>
      <div className={styles.modal_row}>
        <div className={classNames(global.font_14, global.gray_color)}><I18n text='Incentive'/></div>
        <div>{data?.incentive || '0'} {data?.type == 'UAH' ? <I18n text={currency}/> : '%'}</div> 
      </div>
      <div className={styles.modal_row}>
        <div className={classNames(global.font_14, global.gray_color)}><I18n text='Buy-back electricity rate'/></div>
        <div>{data?.buy_back_electricity_rate || '0'} <I18n text={currency}/></div> 
      </div>
      <div className={styles.modal_row}>
        <div className={classNames(global.font_14, global.gray_color)}><I18n text='After incentives'/></div>
        <div>{result && result > 0 ? <span style={{marginRight: 5, textDecoration: 'line-through', color: '#8A90A5'}}>{total} <I18n text={currency}/></span> : ''} {result} <I18n text={currency}/></div> 
      </div>
    </div>
  )
}

export default Incentive