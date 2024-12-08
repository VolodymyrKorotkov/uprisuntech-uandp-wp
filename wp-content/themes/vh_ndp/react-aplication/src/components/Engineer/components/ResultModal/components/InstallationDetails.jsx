import React from 'react'
import I18n from '../../../../I18n/I18n'
import styles from '../ResultModal.module.scss'
import global from '../../../../../App.module.scss'
import classNames from 'classnames'

function InstallationDetails({data = {}}) {
  return (
    <div className={styles.modal_item}>
      <div className={styles.modal_row}>
        <div className={global.semi}><I18n text='Installation details'/></div>
      </div>
      <div className={styles.modal_row}>
        <div className={classNames(global.font_14, global.gray_color)}><I18n text='Place'/></div>
        <div><I18n text={data?.place || ''}/></div> 
      </div>
      <div className={styles.modal_row}>
        <div className={classNames(global.font_14, global.gray_color)}><I18n text='Direction'/></div>
        <div><I18n text={data?.direction || ''}/></div> 
      </div>
      <div className={styles.modal_row}>
        <div className={classNames(global.font_14, global.gray_color)}><I18n text='Parameters of Connection '/></div>
        <div><I18n text={data?.parameters_of_connection || ''}/></div> 
      </div>
      <div className={styles.modal_row}>
        <div className={classNames(global.font_14, global.gray_color)}><I18n text='Link to the presentation'/></div>
        <div><a href={data?.link} style={{display: 'block', maxWidth: 400, overflow: 'hidden', textOverflow: 'ellipsis', whiteSpace: 'nowrap'}} target='_blank'>{data?.link || ''}</a></div> 
      </div>
    </div>
  )
}

export default InstallationDetails