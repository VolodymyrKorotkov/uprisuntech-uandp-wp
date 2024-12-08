import React from 'react'
import styles from './Filter.module.scss'
import I18n from '../../../../../../../../../I18n/I18n'
import global from '../../../../../../../../../../App.module.scss'
import { useState } from 'react';
import Categories from '../../../../../../../../../Commercial/components/Solutions/components/Avaible/components/Filters/components/Categories/Categories';
import Attributes from '../../../../../../../../../Commercial/components/Solutions/components/Avaible/components/Filters/components/Attributes/Attributes';
import classNames from 'classnames';
import { useEffect } from 'react';

function Filter({filterData = {}, onChange=() => {}, categories = [], attributes=[]}) {
  const [filter, setFilter] = useState(filterData);

  useEffect(() => {
    setFilter(filterData)
  }, [filterData])

  const onShow = () => {
    onChange(filter);
  }

  const onReset = () => {
    onChange({
      categories: [],
      attributes: {}
    })
  }


  return (
    <div className={styles.Filter}>
      <div className={styles.header}>
        <div className={styles.title}><I18n text='Filters' /></div>
        <div className={styles.btn} onClick={onReset}>
          <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M14 1.41L12.59 0L7 5.59L1.41 0L0 1.41L5.59 7L0 12.59L1.41 14L7 8.41L12.59 14L14 12.59L8.41 7L14 1.41Z" fill="#919094"/>
          </svg>
        </div>
      </div>
      <div className={styles.body}>
        <Categories categories={categories} filter={filter} onChangeFilter={(v) => setFilter(v)} />
        <Attributes attributes={attributes} filter={filter} onChangeFilter={(v) => setFilter(v)} />
      </div>
      <div className={styles.footer}>
        <div className={classNames(global.btns, global.btns_blue, global.btns_transparent, styles.modal_btn)} onClick={onReset}><I18n text='Reset'/></div>
        <div className={classNames(global.btns, global.btns_blue, styles.modal_btn)} onClick={onShow}><I18n text='Show'/></div>
      </div>
    </div>
  )
}

export default Filter