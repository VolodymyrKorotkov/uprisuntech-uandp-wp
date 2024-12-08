import { IconButton } from '@mui/material'
import React from 'react'
import I18n from '../../../I18n/I18n'
import global from '../../../../App.module.scss'
import UploadField from '../../../UploadField/UploadField'

function Proposal({onSave, data={}, forseListView}) {
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
          <I18n text={'Proposal'} />
        </div>
        <div className={global.switch_block}></div>
      </div>
      <div>
        <UploadField
          name={'file'}
          label={<I18n text='Upload proposal' />}
          // required
          disabled={forseListView}
          value={data.file}
          onChange={(v) => {
            onSave({...data, 'file': v})
          }}
        />
      </div>
    </div>
  )
}

export default Proposal