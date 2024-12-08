import { Modal, TextField } from '@mui/material'
import classNames from 'classnames'
import React, { useState } from 'react'
import styles from '../../MySolutionsCart.module.scss';
import global from "../../../../../../../../App.module.scss";
import I18n from '../../../../../../../I18n/I18n';

const domain = process.env.REACT_APP_BUILD == 'true' ? '' : 'https://staging-ndp.netvision.pro';

function Item({item, deleteItem, updateItemCart}) {
  const [open, setOpen] = useState(false)
  const [disabled, setDisabled] = useState(false)


  const handleupdateItemCart = (quantity) => {
    setDisabled(true)
    updateItemCart(item, quantity)
    setTimeout(() => {
      setDisabled(false)
    }, 500);
  }

  return (
    <>
      <div className={styles.cart_body}>
        <div className={styles.cart_row}>
          <div className={styles.cart_name}>
            <div className={styles.cart_img}>
              <img 
                src={item.featured_image} 
                onError={e => (e.target.src = domain + '/wp-content/themes/vh_ndp/assets/img/home/no-image.jpg')} 
                alt="alt" 
                loading="lazy"
              />
            </div>
            <div className={classNames(global.font_14, global.medium, styles.cart_head)}>{item.name}</div>
          </div>
          <div className={classNames(global.font_14, styles.cart_category)}>{item.category}</div>
          <div className={styles.cart_amount}>
            <div className='d-flex align-items-center justify-content-between'>
              <div className={styles.add}>
                <div className={classNames(styles.add_btn, {[styles.disabled]: item.quantity == 1 || disabled})} onClick={() => {
                  if(item.quantity > 1 && !disabled){
                    handleupdateItemCart(item.quantity - 1)
                  }
                }}>
                  <svg width="10" height="2" viewBox="0 0 10 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 2V0H10V2H0Z" fill="white"/>
                  </svg>
                </div>
                <div className={styles.quantity_block}>{item.quantity}</div>
                {/* <TextField
                  type="text"
                  disabled
                  value={item.quantity}
                  InputLabelProps={{
                    shrink: true,
                  }}
                /> */}
                <div className={classNames(styles.add_btn, {[styles.disabled]: disabled})} onClick={() => {
                  if(!disabled){
                    handleupdateItemCart(item.quantity + 1)
                  }
                  
                }}>
                  <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M16 9H9V16H7V9H0V7H7V0H9V7H16V9Z" fill="white"/>
                  </svg>
                </div>
              </div>
              <div className={styles.cart_delete} onClick={() => setOpen(true)}>
                <svg width="16" height="18" viewBox="0 0 16 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M11 0V1H16V3H15V16C15 17.1 14.1 18 13 18H3C1.9 18 1 17.1 1 16V3H0V1H5V0H11ZM3 16H13V3H3V16ZM5 5H7V14H5V5ZM11 5H9V14H11V5Z" fill="#45464F"/>
                </svg>
              </div>
            </div>
          </div>
        </div>
      </div>
      <Modal className={global.c_modal_flex} open={open} onClose={() => {setOpen(false)}}>
        <div className={classNames(global.c_modal, global.c_modal_small)}>
          <div className={global.c_modal_close} onClick={() => setOpen(false)}>
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12L19 6.41Z" fill="#919094"/>
            </svg>
          </div>
          <div className={global.c_modal_box}>
            <div className={global.c_modal_head}><I18n text='Delete solution'/></div>
            <p><I18n text='Are you sure you want to delete solution?'/></p>
            <div className={global.c_modal_nav}>
            <div className={classNames(global.btns, global.btns_blue, global.btns_transparent, global.w_50)} onClick={() => setOpen(false)}><I18n text='Cancel'/></div>
            <div className={classNames(global.btns, global.btns_blue, global.w_50)} onClick={() => {
              deleteItem(item)
              setOpen(false);
            }}><I18n text='Yes, delete'/></div>
            </div>
          </div>
        </div>
      </Modal>
    </>
  )
}

export default Item