import React from 'react'
import I18n from '../../../I18n/I18n'
import global from '../../../../App.module.scss'
import { IconButton, TextField, TextareaAutosize } from '@mui/material'

function Comment({data = '', onSave, forseListView}) {
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
          <I18n text={'Comment'} />
        </div>
        <div className={global.switch_block}></div>
      </div>
      <div>
        <TextField
          fullWidth
          multiline
          style={{background: 'white'}}
          // type=''
          disabled={forseListView}
          minRows={4}
          name='comment'
          value={data}
          label={<I18n text='Your comment'/>}
          onChange={(e) => {
            onSave(e.target.value)
          }}
        />
      </div>
    </div>
  )
}

export default Comment