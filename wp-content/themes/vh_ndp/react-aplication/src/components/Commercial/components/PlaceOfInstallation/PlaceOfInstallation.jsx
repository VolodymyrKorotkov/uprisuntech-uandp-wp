import React from 'react'
import global from '../../../../App.module.scss'
import Place from './components/Place/Place'
import BuildingInformation from './components/BuildingInformation/BuildingInformation'
import Roof from './components/Roof/Roof'
import I18n from '../../../I18n/I18n'

function PlaceOfInstallation({data = {}, onSave = () => {}, legalAddress, forseShowList, typeProjectOther}) {
  return (
    <div>
      <div className={global.header_title}>
        <div className={global.title}><I18n text={'Place of installation'} /></div>
        <div className={global.text}>
          {!forseShowList && <I18n text='* Required sections must be filled in' />}
        </div>
      </div>
      <Place typeProjectOther={typeProjectOther} data={data?.place || {}} forseShowList={forseShowList} legalAddress={legalAddress} onSave={v => {
        onSave({...data, place: v})
      }} />
      {!typeProjectOther && <BuildingInformation  forseShowList={forseShowList} data={data?.building_information || {}} onSave={v => {
        onSave({...data, building_information: v})
      }} />}
      {!typeProjectOther && <Roof  forseShowList={forseShowList} data={data?.roof || {}} onSave={v => {
        onSave({...data, roof: v})
      }} />}
    </div>
  )
}

export default PlaceOfInstallation