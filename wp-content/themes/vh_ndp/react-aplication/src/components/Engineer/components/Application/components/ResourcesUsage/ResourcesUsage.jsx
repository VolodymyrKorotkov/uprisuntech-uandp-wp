import React from 'react'
import global from '../../../../../../App.module.scss'
import I18n from '../../../../../I18n/I18n'
import ListElectricityUsage
  from '../../../../../Commercial/components/ResourcesUsage/components/ElectricityUsage/ListElectricityUsage'
import ListGasUsage from '../../../../../Commercial/components/ResourcesUsage/components/GasUsage/ListGasUsage'
import ListHotWaterUsage
  from '../../../../../Commercial/components/ResourcesUsage/components/HotWaterUsage/ListHotWaterUsage'
import ListHeatingUsage
  from '../../../../../Commercial/components/ResourcesUsage/components/HeatingUsage/ListHeatingUsage'
import ListBaseYear from "../../../../../Commercial/components/ResourcesUsage/components/BaseYear/ListBaseYear";

function ResourcesUsage({data = {}, isOtherProjectType}) {
  return (
    <div className={global.card}>
      <div className={global.header}>
        <div className={global.row}>
          <div className={global.title}><I18n text={'Resources consumption'}/></div>
        </div>
      </div>
      <div className={global.body}>
        <div className={global.block_text}>
          <strong><I18n text={'Base year'}/></strong>
        </div>
        <div className={global.block_text}/>
        <ListBaseYear data={data?.base_year || {}}/>
      </div>
      <div className={global.body}>
        <div className={global.block_text}>
          <strong><I18n text={'Electricity usage'}/></strong>
        </div>
        <ListElectricityUsage data={data?.electricity_usage || {}}/>
      </div>
      <div className={global.body}>
        <div className={global.block_text}>
          <strong><I18n text={'Gas usage'}/></strong>
        </div>
        <ListGasUsage data={data?.gas_usage || {}}/>
      </div>
      <div className={global.body}>
        <div className={global.block_text}>
          <strong><I18n text={'Hot water usage'}/></strong>
        </div>
        <ListHotWaterUsage data={data?.hot_water_usage || {}}/>
      </div>
      <div className={global.body}>
        <div className={global.block_text}>
          <strong><I18n text={'Heating usage'}/></strong>
        </div>
        <div className={global.block_text}/>
        <ListHeatingUsage data={data?.heating_usage || {}}/>
      </div>
      <div className={global.body}>
        <div className={global.block_text}>
          <strong><I18n text={'Environment'}/></strong>
        </div>
        <div className={global.block_text}>
          <span><I18n text={"Current CO2 emissions"}/></span>
          <div>{data?.environment?.current_CO2_emissions || ''} {data?.environment?.current_CO2_emissions ?
            <I18n text={'Gt'}/> : '-'}</div>
        </div>
        {!isOtherProjectType && (
          <>
            <div className={global.block_text}>
              <span><I18n text={"The level of energy consumption"}/></span>
              <div>{data?.environment?.energy_consumption_level || ''}{' %'}</div>
            </div>
            <div className={global.block_text}>
              <span><I18n text={"Planned reductions in greenhouse emissions"}/></span>
              <div>{data?.environment?.planned_reductions || ''}{' %'}</div>
            </div>
          </>
        )}
      </div>
    </div>
  )
}

export default ResourcesUsage
