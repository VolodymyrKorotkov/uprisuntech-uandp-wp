import React, { useState } from 'react'
import styles from './ModalBox.module.scss'
import classNames from 'classnames';

import FormLabel from '@mui/material/FormLabel';
import FormControl from '@mui/material/FormControl';
import FormGroup from '@mui/material/FormGroup';
import FormControlLabel from '@mui/material/FormControlLabel';
import Checkbox from '@mui/material/Checkbox';
import { styled } from '@mui/material/styles';
function Attributes({attributes = [], filter={}, onChangeFilter = () => {}}) {
  return (
    <>
      <div className={styles.modal_box}>
        <div className={styles.modal_wrap}>
          {attributes.map(_i => 
             Boolean((_i.terms || []).length > 0) && <FormControl key={'atr_' + _i.id}>
              <FormLabel className={styles.modal_label}>{_i.name}</FormLabel>
              <FormGroup>
                {(_i.terms || []).map(_t => <FormControlLabel className={styles.check}
                  control={
                    <Checkbox name="gilad" checked={(filter.attributes[_i.id] || []).includes(_t.id)} onChange={() => {
                      if(filter.attributes[_i.id]){
                        if((filter.attributes[_i.id] || []).includes(_t.id)){
                          const tmpAttributes = filter.attributes;
                          tmpAttributes[_i.id] = tmpAttributes[_i.id].filter(_f => _f != _t.id);
                          if(!tmpAttributes[_i.id].length){
                            delete tmpAttributes[_i.id];
                          }
                          onChangeFilter({...filter, attributes: tmpAttributes})
                        } else {
                          const tmpAttributes = filter.attributes;
                          tmpAttributes[_i.id].push(_t.id);
                          onChangeFilter({...filter, attributes: tmpAttributes})
                        }
                      } else {
                        const tmpAttributes = filter.attributes;
                        tmpAttributes[_i.id] = [_t.id]
                        onChangeFilter({...filter, attributes: tmpAttributes})
                      }
                      
                    }} />
                  }
                  label={_t.name}
                />)}
                
              </FormGroup>
            </FormControl>  
          )}
          
        </div>
        
      </div>
        
    </>
  )
}

export default Attributes