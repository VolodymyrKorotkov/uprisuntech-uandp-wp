import React from 'react'
import I18n from '../../../../../I18n/I18n'
import global from '../../../../../../App.module.scss'

function ListElectricityUsage({data = {}}) {
  return (
    <>
      {data.period_for_which_we_enter_data == 'Monthly estimate (1-12 month)' && <>
        <div className={global.block_text}>
          <span><I18n text={'January'} />, <I18n text={'day / night'} /></span>
          <div>{data?.january_day || ''}/{data?.january_night || '-'} <I18n text={data.type_tariff} /></div>
        </div>
        <div className={global.block_text}>
          <span><I18n text={'February'} />, <I18n text={'day / night'} /></span>
          <div>{data?.february_day || ''}/{data?.february_night || '-'} <I18n text={data.type_tariff} /></div>
        </div>
        <div className={global.block_text}>
          <span><I18n text={'March'} />, <I18n text={'day / night'} /></span>
          <div>{data?.march_day || ''}/{data?.march_night || '-'} <I18n text={data.type_tariff} /></div>
        </div>
        <div className={global.block_text}>
          <span><I18n text={'April'} />, <I18n text={'day / night'} /></span>
          <div>{data?.april_day || ''}/{data?.april_night || '-'} <I18n text={data.type_tariff} /></div>
        </div>
        <div className={global.block_text}>
          <span><I18n text={'May'} />, <I18n text={'day / night'} /></span>
          <div>{data?.may_day || ''}/{data?.may_night || '-'} <I18n text={data.type_tariff} /></div>
        </div>
        <div className={global.block_text}>
          <span><I18n text={'June'} />, <I18n text={'day / night'} /></span>
          <div>{data?.june_day || ''}/{data?.june_night || '-'} <I18n text={data.type_tariff} /></div>
        </div>
        <div className={global.block_text}>
          <span><I18n text={'July'} />, <I18n text={'day / night'} /></span>
          <div>{data?.july_day || ''}/{data?.july_night || '-'} <I18n text={data.type_tariff} /></div>
        </div>
        <div className={global.block_text}>
          <span><I18n text={'August'} />, <I18n text={'day / night'} /></span>
          <div>{data?.august_day || ''}/{data?.august_night || '-'} <I18n text={data.type_tariff} /></div>
        </div>
        <div className={global.block_text}>
          <span><I18n text={'September'} />, <I18n text={'day / night'} /></span>
          <div>{data?.september_day || ''}/{data?.september_night || '-'} <I18n text={data.type_tariff} /></div>
        </div>
        <div className={global.block_text}>
          <span><I18n text={'October'} />, <I18n text={'day / night'} /></span>
          <div>{data?.october_day || ''}/{data?.october_night || '-'} <I18n text={data.type_tariff} /></div>
        </div>
        <div className={global.block_text}>
          <span><I18n text={'November'} />, <I18n text={'day / night'} /></span>
          <div>{data?.november_day || ''}/{data?.november_night || '-'} <I18n text={data.type_tariff} /></div>
        </div>
        <div className={global.block_text}>
          <span><I18n text={'December'} />, <I18n text={'day / night'} /></span>
          <div>{data?.december_day || ''}/{data?.december_night || '-'} <I18n text={data.type_tariff} /></div>
        </div>
        <hr/>
      </>}
      {data.period_for_which_we_enter_data != 'Monthly estimate (1-12 month)' && <>
        <div className={global.block_text}>
          <span><I18n text={data.type_tariff == 'kWh' ? 
              data.period_for_which_we_enter_data == 'Year average' ? 'Year consumption' : 'Monthly consumption' 
              : data.period_for_which_we_enter_data == 'Year average' ? 'Year bill' : 'Monthly bill'} /></span>
          <div>{data?.monthly_electricity_consumption || '-'} {data?.monthly_electricity_consumption ? <I18n text={data.type_tariff} /> : ''}</div>
        </div>
        {Boolean(data.different_tariff_for_night_time_usage) && <div className={global.block_text}>
          <span>
          <I18n text={data.type_tariff == 'kWh' ? 
            data.period_for_which_we_enter_data == 'Year average' ? 'Year night consumption' : 'Monthly night consumption'
            : 
            data.period_for_which_we_enter_data == 'Year average' ? 'Year night bill' : 'Monthly night bill'} />  
          </span>
          {data?.nightly_electricity_consumption ? <div>{data?.nightly_electricity_consumption || ''} <I18n text={data.type_tariff} /></div> : '-'}
        </div>}
      </>}
      <div className={global.block_text}>
        <span><I18n text={'Tariff'} /></span>
        {data?.tariff_per_kWh ? <div>{data?.tariff_per_kWh || ''} <I18n text={'UAH per kWh'} /></div> : '-'}
      </div>
      {Boolean(data.different_tariff_for_night_time_usage) && <div className={global.block_text}>
        <span><I18n text={'Night time tariff'} /></span>
        {data?.night_time_tariff ? <div>{data?.night_time_tariff || ''} <I18n text={'UAH per kWh'} /></div>: '-'}
      </div>}
      <div className={global.block_text}>
        <span><I18n text={'Electricity supplier'} /></span>
        <div><I18n text={data?.electricity_supplier || '-'} /></div>
      </div>
      <div className={global.block_text}>
        <span><I18n text={'Required voltage'} /></span>
        <div><I18n text={data?.required_voltage || '-'}/></div>
      </div>
      {data.bill_for_electricity_consumption && <div className={global.block_text}>
        <span><I18n text={'Bill for electricity consumption'} /></span>
        <div><a href={data.bill_for_electricity_consumption} target='_blank'>{data.bill_for_electricity_consumption.split('/').pop()}</a></div>
      </div>}
    </>
  )
}

export default ListElectricityUsage