import React from 'react'
import global from '../../../../../../App.module.scss'
import I18n from '../../../../../I18n/I18n'
import * as moment from 'moment'


function GeneralInfo({application}) {
  return (
    <div className={global.card}>
      <div className={global.header}>
        <div className={global.row}>
          <div className={global.title}><I18n text={'General info'} /></div>
        </div>
      </div>
      <div className={global.body}>
        <div className={global.block_text}>
          <span><I18n text='Status' /></span>
          <div style={{textTransform: 'capitalize'}}><I18n text={application?.status || '-'}/></div>
        </div>
        {/* <div className={global.block_text}>
          <span><I18n text='Last status change date' /></span>
          <div>{application?.status_updated_at && application?.status_updated_at != '0000-00-00 00:00:00' && application?.status_updated_at && moment(application?.status_updated_at).format('DD/MM/yyyy HH:mm') || '-'}</div>
        </div> */}
        <div className={global.block_text}>
          <span><I18n text='Issue date' /></span>
          <div>{application?.created_at && moment(application?.created_at).format('DD/MM/yyyy HH:mm') || '-'}</div>
        </div>
        <div className={global.block_text}>
          <span><I18n text='Type' /></span>
          <div><I18n text='Commercial' /></div>
        </div>
      </div>
    </div>
  )
}

export default GeneralInfo