import React, { useState } from 'react'
import styles from './ModalBox.module.scss'
import classNames from 'classnames';

import FormLabel from '@mui/material/FormLabel';
import FormControl from '@mui/material/FormControl';
import FormGroup from '@mui/material/FormGroup';
import FormControlLabel from '@mui/material/FormControlLabel';
import Checkbox from '@mui/material/Checkbox';
import { styled } from '@mui/material/styles';
function ModalBox() {
  return (
    <>
      <div className={styles.modal_box}>
        <div className={styles.modal_wrap}>
        <FormControl>
          <FormLabel className={styles.modal_label}>Category</FormLabel>
          <FormGroup>
            <FormControlLabel className={styles.check}
              control={
                <Checkbox name="gilad" />
              }
              label="Solar panel"
            />
            <FormControlLabel className={styles.check}
              control={
                <Checkbox name="jason" />
              }
              label="Wind Energy Solutions"
            />
            <FormControlLabel className={styles.check}
              control={
                <Checkbox name="antoine" />
              }
              label="Energy Storage"
            />
            <FormControlLabel className={styles.check}
              control={
                <Checkbox name="gilad" />
              }
              label="Electric Vehicle Charging"
            />
            <FormControlLabel className={styles.check}
              control={
                <Checkbox name="jason" />
              }
              label="Energy-efficient Appliances"
            />
            <FormControlLabel className={styles.check}
              control={
                <Checkbox name="antoine" />
              }
              label="Home Energy Management"
            />
           
          </FormGroup>
        </FormControl>
         <div className={styles.check_link}>See all filters</div>
        </div>
        
      </div>
        
    </>
  )
}

export default ModalBox