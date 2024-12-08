import React from 'react'
import global from "../../../../../../App.module.scss";
import styles from './MySolutionsCart.module.scss';
import TextField from '@mui/material/TextField';
import classNames from 'classnames';
import Item from './components/Item/Item';
import I18n from '../../../../../I18n/I18n';
function MySolutionsCart({cart = [], deleteItem, updateItemCart}) {
  return (
    <div className={global.cart}>
      <div className={styles.cart_header}>
        <div className={styles.cart_header_text}><I18n text='Solution'/></div>
        <div className={styles.cart_header_text}><I18n text='Category'/></div>
        <div className={styles.cart_header_text}><I18n text='Quantity'/></div>
      </div>
      {cart.map(_i => <Item key={'product_cart_' + _i.id} item={_i} deleteItem={deleteItem} updateItemCart={updateItemCart} />)}
    </div>
  )
}

export default MySolutionsCart