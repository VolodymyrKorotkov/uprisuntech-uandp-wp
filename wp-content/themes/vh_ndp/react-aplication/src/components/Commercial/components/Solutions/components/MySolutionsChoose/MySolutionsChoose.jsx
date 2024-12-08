import React from 'react'
import global from "../../../../../../App.module.scss";
import { FormControl, FormControlLabel, FormLabel, Radio, RadioGroup} from '@mui/material';
import styles from './MySolutionsChoose.module.scss';
import I18n from '../../../../../I18n/I18n';
function MySolutionsChoose({onChange, data}) {
  return (
    <div className={global.box}>
        <div className="row">
          <div className="col-md-6 mb-3 mb-md-0">
            <FormControl>
              <FormLabel id="demo-controlled-radio-buttons-group" className={styles.group_label}><I18n text='Who will choose solutions?'/></FormLabel>
              <RadioGroup
                aria-labelledby="demo-controlled-radio-buttons-group"
                name="controlled-radio-buttons-group"
                value={data.choose_solutions}
                onChange={(e) => {
                  onChange(e.target.value)
                }}
              >
                <FormControlLabel value="Our experts will choose" control={<Radio />} label={<I18n text="Our experts will choose" />} />
                <FormControlLabel value="Choose yourself" control={<Radio />} label={<I18n text="Choose yourself" />} />
              </RadioGroup>
            </FormControl>
          </div>
          <div className="col-md-6">
            <div className={styles.alert}>
              <div className={styles.alert_header}>
                  <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fillRule="evenodd" clipRule="evenodd" d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM9 15V13H11V15H9ZM9 5V11H11V5H9Z" fill="#2A59BD"/>
                </svg>
                <span><I18n text='How it works'/></span>
              </div>
              <p><I18n text='Our expert team collaborates with businesses and communities to seamlessly integrate green solutions, from energy-efficient.'/></p>
            </div>
          </div>
        </div>
      </div>
  )
}

export default MySolutionsChoose
