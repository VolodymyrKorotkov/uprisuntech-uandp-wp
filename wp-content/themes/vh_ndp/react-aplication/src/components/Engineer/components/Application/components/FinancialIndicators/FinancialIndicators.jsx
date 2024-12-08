import React from 'react'
import global from '../../../../../../App.module.scss'
import I18n from '../../../../../I18n/I18n'
import ListFinancialIndicators from "../../../../../Commercial/components/FinancialIndicators/ListFinancialIndicators";


function FinancialIndicators({data = {}}) {
  return (<div className={global.card}>
      <div className={global.header}>
        <div className={global.row}>
          <div className={global.title}><I18n text={'Financial indicators'}/></div>
        </div>
      </div>
      <div className={global.body}>
        <ListFinancialIndicators data={data}/>
      </div>
    </div>
  )
}

export default FinancialIndicators
