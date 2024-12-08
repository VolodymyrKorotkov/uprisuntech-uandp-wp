import { IconButton, Switch } from '@mui/material'
import React from 'react'
import I18n from '../../../I18n/I18n'
import global from '../../../../App.module.scss'
import { useEffect } from 'react'
import EconomyMonthByMonth from './components/EconomyMonthByMonth/EconomyMonthByMonth'
import Incentive from './components/Incentive/Incentive'
import FinancingOption from './components/FinancingOption/FinancingOption'

function FinancialInformation({
  data = {}, 
  onSave, 
  system_price, 
  forseListView,
  currency,
  onChangeCurrency,
}) {
  

  useEffect(() => {
    if(!currency){
      onChangeCurrency('UAH');
    }
  }, [])
  return (
    <div>
      <div className={global.header_title}>
        <div className={global.title}> 
          <IconButton onClick={() => {
            window.location.href = '/dashboard/requests/'
          }}>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path d="M15.705 7.41L14.295 6L8.295 12L14.295 18L15.705 16.59L11.125 12L15.705 7.41Z" fill="#2A59BD"/>
            </svg>
          </IconButton>
          <I18n text={'Financial information'} /> </div>
        {!forseListView && <div className={global.switch_block}>
          <div className={global.text_UAH}><I18n text='UAH'/> </div> 
          <Switch className={global.switch} checked={currency == 'USD'} onChange={() => {
            onChangeCurrency(currency == 'USD' ? 'UAH' : 'USD')
          }} /> <div className={global.text_USD}><I18n text='USD'/></div>
        </div>}
      </div>
      <EconomyMonthByMonth
        forseListView={forseListView}
        data={data?.economy_month_by_month || {}}
        currency={currency}
        onSave={(v) => {
          onSave({...data, economy_month_by_month: v})
        }} 
      />
      <Incentive
        forseListView={forseListView}
        data={data?.incentive || {}}
        system_price={system_price || {}}
        currency={currency}
        onSave={(v) => {
          onSave({...data, incentive: v})
        }} 
      />
      <FinancingOption
        forseListView={forseListView}
        data={data?.financing_option || {}}
        currency={currency}
        onSave={(v) => {
          onSave({...data, financing_option: v})
        }} 
      />
    </div>
  )
}

export default FinancialInformation