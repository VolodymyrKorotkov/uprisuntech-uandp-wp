import React from 'react'
import global from '../../../../../../App.module.scss'
import I18n from '../../../../../I18n/I18n'
import List from '../../../../../Commercial/components/Organization/components/LegalAddress/List'

function Place({data = {}}) {
  return (
    <div className={global.card}>
      <div className={global.header}>
        <div className={global.row}>
          <div className={global.title}><I18n text={'Place'} /></div>
        </div>
      </div>
      <div className={global.body}>
        <List data={data || {}} />
      </div>
    </div>
  )
}

export default Place