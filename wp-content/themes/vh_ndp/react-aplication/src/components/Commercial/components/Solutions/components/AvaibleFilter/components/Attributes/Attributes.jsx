import React from 'react'
import styles from '../../AvaibleFilter.module.scss';
import I18n from '../../../../../../../I18n/I18n';

function Attributes({attributes, filter, onChange}) {
  
  const tmp = attributes.filter(_i => filter.attributes[_i.id] && filter.attributes[_i.id].length)

  if(!tmp.length){
    return null;
  }

  return (
    tmp.map(_i => <div>
      <label className={styles.filter_head}>{_i.name}:</label>
      <div className={styles.filter_labels}>
        {_i.terms.filter(_t => filter.attributes[_i.id].includes(_t.id)).map(_t => 
          <div className={styles.filter_label}>
            <span>{_t.name}</span>
            <div className={styles.filter_delete} onClick={() => {
              const tmpFilter = {...filter.attributes};
              tmpFilter[_i.id] = tmpFilter[_i.id].filter(_id => _id != _t.id);
              if(!tmpFilter[_i.id].length){
                delete tmpFilter[_i.id];
              }
              onChange({...filter, attributes: tmpFilter})
            }}>
              <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M14.25 4.8075L13.1925 3.75L9 7.9425L4.8075 3.75L3.75 4.8075L7.9425 9L3.75 13.1925L4.8075 14.25L9 10.0575L13.1925 14.25L14.25 13.1925L10.0575 9L14.25 4.8075Z" fill="#151B2C"/>
              </svg>
            </div>
          </div>
        )}
      </div>
    </div>)
  )
}

export default Attributes