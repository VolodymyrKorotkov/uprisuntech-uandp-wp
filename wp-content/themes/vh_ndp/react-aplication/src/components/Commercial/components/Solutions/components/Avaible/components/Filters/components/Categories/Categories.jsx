import React, { useState } from 'react'
import styles from './ModalBox.module.scss'
import classNames from 'classnames';

import FormLabel from '@mui/material/FormLabel';
import FormControl from '@mui/material/FormControl';
import FormGroup from '@mui/material/FormGroup';
import FormControlLabel from '@mui/material/FormControlLabel';
import Checkbox from '@mui/material/Checkbox';
import { styled } from '@mui/material/styles';
import I18n from '../../../../../../../../../I18n/I18n';
function Categories({categories = [], filter={}, onChangeFilter = () => {}}) {
  return (
    <>
      <div className={styles.modal_box}>
        <div className={styles.modal_wrap}>
        <FormControl>
          <FormLabel className={styles.modal_label}><I18n text='Category'/></FormLabel>
          <FormGroup>
            {categories.map(_i => <FormControlLabel className={styles.check}
              control={
                <Checkbox name={_i.name} onChange={() => {
                  if((filter.categories || []).includes(_i.id)){
                    onChangeFilter({...filter, categories: (filter.categories || []).filter(_id => _id != _i.id)})
                  } else {
                    onChangeFilter({...filter, categories: [...(filter.categories || []), _i.id]})
                  }
                }} checked={(filter.categories || []).includes(_i.id)} />
              }
              label={_i.name}
            />)}
          </FormGroup>
        </FormControl>
         {/* <div className={styles.check_link}>See all filters</div> */}
        </div>
        
      </div>
        
    </>
  )
}

export default Categories