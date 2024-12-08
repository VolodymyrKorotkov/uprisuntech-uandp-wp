import React from 'react'
import I18n from '../../../../../I18n/I18n'
import global from '../../../../../../App.module.scss'

function Contact({data = {}}) {
  return (
    <div className={global.card}>
      <div className={global.header}>
        <div className={global.row}>
          <div className={global.title}><I18n text={'Contact'} /></div>
        </div>
      </div>
      <div className={global.body}>
        <div className={global.block_text}>
          <span><I18n text='Full name'/></span>
          <div>{data?.last_name} {data?.first_name} {data?.middle_name}</div>
        </div>
        <div className={global.block_text}>
          <div>
            <span><I18n text='Email (login ID)'/></span><br/>
            <span><I18n text='This email will be used for account authorization'/></span>
          </div>
          
          <div>{data.email}</div>
        </div>
        <div className={global.block_text}>
          <span><I18n text='Mobile phone'/></span>
          <div>{data?.phone}</div>
        </div>
      </div>
    </div>
  )
}

export default Contact