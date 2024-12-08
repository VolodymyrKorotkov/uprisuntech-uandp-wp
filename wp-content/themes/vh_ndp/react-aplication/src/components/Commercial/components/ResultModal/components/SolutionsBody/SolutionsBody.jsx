import React from 'react'
import I18n from '../../../../../I18n/I18n'
import styles from '../../ResultModal.module.scss'
import classNames from 'classnames'
const domain = process.env.REACT_APP_BUILD == 'true' ? '' : 'https://staging-ndp.netvision.pro';

function SolutionsBody({data = {}}) {
  return (
    <div className={styles.modal_block}>
      {data?.choose_solutions == 'Choose yourself' && (data?.cart || []).length > 0 &&<div className={styles.cart}>
        <div className={styles.cart_header}>
          <div className={styles.cart_header_text}><I18n text={'Solution'} /></div>
          <div className={styles.cart_header_text}><I18n text={'Category'} /></div>
          <div className={styles.cart_header_text}><I18n text={'Quantity'} /></div>
        </div>
        {(data?.cart || []).map(_i =>
          <div className={styles.cart_row}>
            <div className={styles.cart_name}>
              <div className={styles.cart_img}>
                <img
                  src={_i.featured_image || domain + '/wp-content/themes/vh_ndp/assets/img/home/no-image.jpg'}
                  alt="alt"
                  onError={e => (e.target.src = domain + '/wp-content/themes/vh_ndp/assets/img/home/no-image.jpg')}
                />
              </div>
              <div className={classNames(global.font_14, global.medium, styles.cart_head)}>{_i.name}</div>
            </div>
            <div className={classNames(global.font_14, styles.cart_category)}>{_i.category}</div>
            <div className={global.font_14}>{_i.quantity}</div>
          </div>
        )}
      </div>}
      {data?.choose_solutions == 'Our experts will choose' && <div className={styles.cart_message}>
        <div className={styles.title}><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
          <path fillRule="evenodd" clipRule="evenodd" d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM11 17V15H13V17H11ZM11 7V13H13V7H11Z" fill="#2A59BD"/>
        </svg><I18n text='Our experts will choose'/></div>
        <p><I18n text='Our expert team collaborates with businesses and communities to seamlessly integrate green solutions, from energy-efficient.'/></p>
      </div>}
    </div>
  )
}

export default SolutionsBody
