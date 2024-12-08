import React from 'react';
import styles from './AvaibleFilter.module.scss';
import Categories from './components/Categories/Categories';
import Attributes from './components/Attributes/Attributes';
import I18n from '../../../../../I18n/I18n';
function AvaibleFilter({categories = [], filterData={}, onChange, attributes={}}) {

  if(filterData.categories.length == 0 && Object.keys(filterData.attributes).length == 0){
    return null;
  }


  return (
    <div>
        <div className={styles.filter}>
          <Categories 
            categories={categories} 
            filter={filterData} 
            onChange={onChange} 
          />
          <Attributes 
            attributes={attributes} 
            filter={filterData} 
            onChange={onChange}  />
          {/* <div>
            <label className={styles.filter_head}>Vendors:</label>
            <div className={styles.filter_labels}>
              <div className={styles.filter_label}>
                <span>Benq</span>
                <div className={styles.filter_delete}>
                  <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.25 4.8075L13.1925 3.75L9 7.9425L4.8075 3.75L3.75 4.8075L7.9425 9L3.75 13.1925L4.8075 14.25L9 10.0575L13.1925 14.25L14.25 13.1925L10.0575 9L14.25 4.8075Z" fill="#151B2C"/>
                  </svg>
                </div>
              </div>
              <div className={styles.filter_label}>
                <span>Tesla</span>
                <div className={styles.filter_delete}>
                  <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M14.25 4.8075L13.1925 3.75L9 7.9425L4.8075 3.75L3.75 4.8075L7.9425 9L3.75 13.1925L4.8075 14.25L9 10.0575L13.1925 14.25L14.25 13.1925L10.0575 9L14.25 4.8075Z" fill="#151B2C"/>
                  </svg>
                </div>
              </div>
            </div>
          </div> */}
          <div>
            <button type='button' className={styles.filter_btn} onClick={() => onChange({
              categories: [],
              attributes: {}
            })}><I18n text='Clear all filters'/></button>
          </div>
        </div>
    </div>
  )
}

export default AvaibleFilter