import React from 'react'
import I18n from '../../../../../I18n/I18n'
import global from '../../../../../../App.module.scss'
function ListGasUsage({data = {}}) {
  return (
    <>
      {data.period_for_which_we_enter_data == 'Monthly estimate (1-12 month)' && <>
        <div className={global.block_text}>
          <span><I18n text={'January'} /></span>
          <div>{data?.january_day || ''} <I18n text={data.type_tariff} /></div>
        </div>
        <div className={global.block_text}>
          <span><I18n text={'February'} /></span>
          <div>{data?.february_day || ''} <I18n text={data.type_tariff} /></div>
        </div>
        <div className={global.block_text}>
          <span><I18n text={'March'} /></span>
          <div>{data?.march_day || ''} <I18n text={data.type_tariff} /></div>
        </div>
        <div className={global.block_text}>
          <span><I18n text={'April'} /></span>
          <div>{data?.april_day || ''} <I18n text={data.type_tariff} /></div>
        </div>
        <div className={global.block_text}>
          <span><I18n text={'May'} /></span>
          <div>{data?.may_day || ''} <I18n text={data.type_tariff} /></div>
        </div>
        <div className={global.block_text}>
          <span><I18n text={'June'} /></span>
          <div>{data?.june_day || ''} <I18n text={data.type_tariff} /></div>
        </div>
        <div className={global.block_text}>
          <span><I18n text={'July'} /></span>
          <div>{data?.july_day || ''} <I18n text={data.type_tariff} /></div>
        </div>
        <div className={global.block_text}>
          <span><I18n text={'August'} /></span>
          <div>{data?.august_day || ''} <I18n text={data.type_tariff} /></div>
        </div>
        <div className={global.block_text}>
          <span><I18n text={'September'} /></span>
          <div>{data?.september_day || ''} <I18n text={data.type_tariff} /></div>
        </div>
        <div className={global.block_text}>
          <span><I18n text={'October'} /></span>
          <div>{data?.october_day || ''} <I18n text={data.type_tariff} /></div>
        </div>
        <div className={global.block_text}>
          <span><I18n text={'November'} /></span>
          <div>{data?.november_day || ''} <I18n text={data.type_tariff} /></div>
        </div>
        <div className={global.block_text}>
          <span><I18n text={'December'} /></span>
          <div>{data?.december_day || ''} <I18n text={data.type_tariff} /></div>
        </div>
        <hr/>
      </>}
    {data.period_for_which_we_enter_data != 'Monthly estimate (1-12 month)' && <div className={global.block_text}>
      <span><I18n text={data.type_tariff == 'm³' ?
            data.period_for_which_we_enter_data == 'Year average' ? 'Year consumption' : 'Monthly consumption'
            : data.period_for_which_we_enter_data == 'Year average' ? 'Year bill' : 'Monthly bill'} /></span>
      <div>{data?.monthly_gas_consumption || ''} {data?.monthly_gas_consumption  ? <I18n text={data.type_tariff == 'm³' ? 'm³' : 'UAH'} /> : '-'}</div>
    </div>}
    <div className={global.block_text}>
      <span><I18n text={'Tariff'} /></span>
      <div>{data?.tariff_per || ''} {data?.tariff_per ? <I18n text={'UAH per m³'} />: '-'}</div>
    </div>
    <div className={global.block_text}>
      <span><I18n text={'Gas supplier'} /></span>
      <div>{data?.gas_supplier || '-'}</div>
    </div>
    {data.bill_for_gas_consumption && <div className={global.block_text}>
      <span><I18n text={'Bill for gas consumption'} /></span>
      <div><a href={data.bill_for_gas_consumption} target='_blank'>{data.bill_for_gas_consumption.split('/').pop()}</a></div>
    </div>}
  </>
  )
}

export default ListGasUsage
