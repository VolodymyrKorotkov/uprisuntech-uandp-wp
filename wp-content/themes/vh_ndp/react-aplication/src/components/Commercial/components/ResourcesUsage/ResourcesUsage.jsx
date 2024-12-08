import global from '../../../../App.module.scss'
import ElectricityUsage from './components/ElectricityUsage/ElectricityUsage'
import GasUsage from './components/GasUsage/GasUsage'
import HotWaterUsage from './components/HotWaterUsage/HotWaterUsage'
import HeatingUsage from './components/HeatingUsage/HeatingUsage'
import Environment from './components/Environment/Environment'
import I18n from '../../../I18n/I18n'
import BaseYear from './components/BaseYear/BaseYear';

function ResourcesUsage({data = {}, onSave, forseShowList, typeProjectOther}) {
  return (
    <div>
      <div className={global.header_title}>
        <div className={global.title}><I18n text='Resources consumption' /></div>
        <div className={global.text}>
          {!forseShowList && <I18n text='* Required sections must be filled in' />}
        </div>
      </div>
      <BaseYear forseShowList={forseShowList} data={data?.base_year || {}} onSave={v => {
        onSave({...data, base_year: v})
      }}/>
      <ElectricityUsage forseShowList={forseShowList} data={data?.electricity_usage || {}} onSave={v => {
        onSave({...data, electricity_usage: v})
      }} />
      <GasUsage forseShowList={forseShowList} data={data?.gas_usage || {}} onSave={v => {
        onSave({...data, gas_usage: v})
      }} />
      <HotWaterUsage forseShowList={forseShowList} data={data?.hot_water_usage || {}} onSave={v => {
        onSave({...data, hot_water_usage: v})
      }} />
      <HeatingUsage forseShowList={forseShowList} data={data?.heating_usage || {}} onSave={v => {
        onSave({...data, heating_usage: v})
      }} />
      <Environment typeProjectOther={typeProjectOther} forseShowList={forseShowList} data={data?.environment || {}} onSave={v => {
        onSave({...data, environment: v})
      }} />
    </div>
  )
}

export default ResourcesUsage
