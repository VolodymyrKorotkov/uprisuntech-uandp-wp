import React from 'react'
import styles from '../../AvaibleFilter.module.scss';
import I18n from '../../../../../../../I18n/I18n';
function Categories({categories=[], filter, onChange}) {
  if(!filter?.categories.length){
    return null;
  }

  return (
    <div>
      <label className={styles.filter_head}><I18n text='Category'/>:</label>
      <div className={styles.filter_labels}>
        {categories.filter(_i => (filter.categories || []).includes(_i.id)).map(_i => <div className={styles.filter_label}>
          <span>{_i.name}</span>
          <div className={styles.filter_delete} onClick={() => {
            onChange({...filter, categories: filter.categories.filter(_id => _id != _i.id)})
          }}>
            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M14.25 4.8075L13.1925 3.75L9 7.9425L4.8075 3.75L3.75 4.8075L7.9425 9L3.75 13.1925L4.8075 14.25L9 10.0575L13.1925 14.25L14.25 13.1925L10.0575 9L14.25 4.8075Z" fill="#151B2C"/>
            </svg>
          </div>
        </div>)}
        

      </div>
    </div>
  )
}

export default Categories