import React from 'react'
import global from '../../../../App.module.scss'
import I18n from '../../../I18n/I18n'

function ListFinancialInformation({financialInformation = {}}) {
  return (
    <>
      <div className={global.block_text}>
        <span><I18n text='Bill offset percentage' /></span>
        <div>{financialInformation?.bill_offset_percentage}%</div>
      </div>
      <div className={global.block_text}>
        <span><I18n text='Preferred system price' /></span>
        <div><I18n text='to' /> {financialInformation.preferred_system_price} <I18n text='USD' /></div>
      </div>
      <div className={global.block_text}>
        <span><I18n text='Preferred term' /></span>
        <div>{financialInformation.preferred_term} <I18n text='years' /></div>
      </div>
    </>
  )
}

export default ListFinancialInformation