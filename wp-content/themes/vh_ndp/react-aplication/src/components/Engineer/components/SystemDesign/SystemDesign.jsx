import React from 'react'
import I18n from '../../../I18n/I18n'
import { IconButton, Switch } from '@mui/material'
import global from '../../../../App.module.scss'
import Solutions from './components/Solutions/Solutions'
import SystemPrice from './components/SystemPrice/SystemPrice'
import { useEffect } from 'react'
import InstallationDetails from './components/InstallationDetails/InstallationDetails'

function SystemDesign({
  data = {}, 
  onSave,
  list=[],
  countPages,
  categories,
  attributes,
  filter,
  changeFilter,
  currentPage,
  loaded,
  getData,
  forseListView,
  currency,
  onChangeCurrency,
}) {
 

  useEffect(() => {
    if(!currency){
      onChangeCurrency('UAH')
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
          <I18n text={'System design'} /> </div>
        {!forseListView && <div className={global.switch_block}>
          <div className={global.text_UAH}><I18n text='UAH'/></div> 
          <Switch className={global.switch} checked={currency == 'USD'} onChange={() => {
            onChangeCurrency(currency == 'USD' ? 'UAH' : 'USD')
          }} /> <div className={global.text_USD}><I18n text='USD'/></div>
        </div>}
      </div>
      <Solutions
        forseListView={forseListView}
        list={list}
        countPages={countPages}
        currentPage={currentPage}
        categories={categories}
        attributes={attributes}
        filter={filter}
        loaded={loaded}
        getData={getData}
        changeFilter={changeFilter}
        data={data?.solutions || []} 
        onSave={(v) => {
          onSave({...data, solutions: v})
        }}
      />
      <SystemPrice
        forseListView={forseListView}
        data={data?.system_price || {}}
        currency={currency}
        onSave={(v) => {
          onSave({...data, system_price: v})
        }}
      />
      <InstallationDetails
        forseListView={forseListView}
        data={data?.installation_details || {}}
        currency={currency}
        onSave={(v) => {
          onSave({...data, installation_details: v})
        }}
      />
    </div>
  )
}

export default SystemDesign