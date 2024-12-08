import React from 'react'
import styles from './FeedbackModal.module.scss'
import classNames from 'classnames'
import { Modal, TextField } from '@mui/material'
import I18n from '../../../I18n/I18n'
import global from '../../../../App.module.scss'
import { useState } from 'react'

function FeedbackModal({title = 'Submit application', open=true, onClose = () => {}, onSave = () => {}, text, btn_title}) {

  const [comment, setComment] = useState('')


  const onClick = () => {
    if(comment){
      onSave(comment);
      setComment('')
      onClose()
    }
  }

  return (
    <Modal style={{zIndex: 9999999}} className={global.c_modal_flex} open={open} onClose={onClose}>
      <div className={classNames(global.c_modal, global.c_modal_medium, styles.modal_w)}>
        <div className={global.c_modal_header}>
          <div className={global.h3}><I18n text={title} /></div>
          <div className={classNames(global.c_modal_close, global.static)} onClick={onClose}>
            <svg
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12L19 6.41Z"
                fill="#919094"
              />
            </svg>
          </div>
        </div>
        <div className={classNames(global.c_modal_body, styles.bg_gray, global.modal_table)}>
          <p><I18n text={text}/></p>
          <TextField
            fullWidth
            multiline
            style={{background: 'white'}}
            // type=''
            minRows={8}
            name='comment'
            value={comment}
            label={<I18n text='Your comment'/>}
            onChange={(e) => {
              setComment(e.target.value)
            }}
          />
        </div>
        <div className={global.c_modal_footer}>
						<div className={classNames(global.c_modal_nav, "justify-content-end")}>
              <div className={classNames(global.btns, global.btns_blue, global.btns_transparent, global.w_50)} onClick={onClose}><I18n text='Cancel' /></div>
              <div className={classNames(global.btns, global.btns_blue, global.w_50)} onClick={onClick}><I18n text={btn_title} /></div>
						</div>
					</div>
      </div>
    </Modal>
  )
}

export default FeedbackModal