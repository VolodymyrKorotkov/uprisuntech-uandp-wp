import React, { useState } from 'react'
import styles from './Filters.module.scss'
import { Modal } from '@mui/material';
import classNames from 'classnames';
import ModalBox from "./components/ModalBox/ModalBox";
import global from "../../../../../../../../App.module.scss";
import axios from 'axios';
import { useEffect } from 'react';
import Categories from './components/Categories/Categories';
import I18n from '../../../../../../../I18n/I18n';
import Attributes from './components/Attributes/Attributes';


function Filters({filterData = {}, onChange=() => {}, categories = [], attributes=[]}) {
  const [open, setOpen] = useState(false);

  const [filter, setFilter] = useState(filterData);

  useEffect(() => {
    if(open){
      setFilter(filterData);
    }
  }, [open])


  const onShow = () => {
    onChange(filter);
    setOpen(false)
  }

  const onReset = () => {
    onChange({
      categories: [],
      attributes: {}
    })
    setOpen(false)
  }

  return (
    <>
      <button type="button" className={styles.filter_btn} onClick={() => setOpen(true)}>
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M6.25 13.75V9.25H7.75V10.75H13.75V12.25H7.75V13.75H6.25ZM0.25 12.25V10.75H4.75V12.25H0.25ZM3.25 9.25V7.75H0.25V6.25H3.25V4.75H4.75V9.25H3.25ZM6.25 7.75V6.25H13.75V7.75H6.25ZM9.25 4.75V0.25H10.75V1.75H13.75V3.25H10.75V4.75H9.25ZM0.25 3.25V1.75H7.75V3.25H0.25Z" fill="#2A59BD"/>
        </svg>
        <span><I18n text='Filters'/></span>
      </button>
      <Modal
        open={open}
        onClose={() => {setOpen(false)}}
        // aria-labelledby="modal-modal-title"
        // aria-describedby="modal-modal-description"
      >
        <div className={styles.modal}>
          <div className={styles.modal_header}>
            <div className={global.h3}><I18n text='Filters'/></div>
            <div className={styles.modal_close} onClick={() => {setOpen(false)}}>
              <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M14 1.41L12.59 0L7 5.59L1.41 0L0 1.41L5.59 7L0 12.59L1.41 14L7 8.41L12.59 14L14 12.59L8.41 7L14 1.41Z" fill="#919094"/>
              </svg>
            </div>
          </div>
          <div className={styles.modal_scroll}>
            <Categories categories={categories} filter={filter} onChangeFilter={(v) => setFilter(v)} />
            <Attributes attributes={attributes} filter={filter} onChangeFilter={(v) => setFilter(v)} />
            {/* <ModalBox />
            <ModalBox /> */}
          </div>
          <div className={styles.modal_footer}>
            <div className={classNames(global.btns, global.btns_blue, global.btns_transparent, styles.modal_btn)} onClick={onReset}><I18n text='Reset'/></div>
            <div className={classNames(global.btns, global.btns_blue, styles.modal_btn)} onClick={onShow}><I18n text='Show'/></div>
          </div>
        </div>
      </Modal>
    </>
  )
}

export default Filters