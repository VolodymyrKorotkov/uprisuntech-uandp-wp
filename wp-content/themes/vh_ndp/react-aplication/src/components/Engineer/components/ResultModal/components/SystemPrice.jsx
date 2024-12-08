import classNames from 'classnames'
import React from 'react'
import I18n from '../../../../I18n/I18n'
import styles from '../ResultModal.module.scss'
import global from '../../../../../App.module.scss'

function SystemPrice({data = {}, currency}) {
  let total = 0;

  if(data?.solution_cost && !isNaN(parseFloat(data?.solution_cost))){
    total +=parseFloat(data?.solution_cost);
  }

  if(data?.installation_cost && !isNaN(parseFloat(data?.installation_cost))){
    total +=parseFloat(data?.installation_cost);
  }

  (data?.additions || []).map((_i, index) => {
    if(_i?.addition_cost && !isNaN(parseFloat(_i.addition_cost)) && _i?.quantity && !isNaN(parseFloat(_i.quantity))){
      total += parseFloat(_i.addition_cost) * parseFloat(_i.quantity);
    }
    
  })
  return (
    <div className={styles.modal_item}>
      <div className={styles.modal_row}>
        <div className={global.semi}><I18n text='System price'/></div>
      </div>
      <div className={styles.modal_row}>
        <div className={classNames(global.font_14, global.gray_color)}><I18n text='Solution cost'/></div>
        <div>{data?.solution_cost || ''} <I18n text={currency}/></div> 
      </div>
      <div className={styles.modal_row}>
        <div className={classNames(global.font_14, global.gray_color)}><I18n text='Installation cost' /></div>
        <div>{data?.installation_cost || ''} <I18n text={currency}/></div> 
      </div>

      {(data?.additions || []).map((_i, index) => 
        <div key={'additions_' + index} className={styles.modal_row}>
          <div className={classNames(global.font_14, global.gray_color)}>{_i.name_of_addition}</div>
          <div>{_i.addition_cost || ''} <I18n text={currency}/></div> 
        </div>
      )}

      <div className={styles.modal_row}>
        <div className={classNames(global.font_14, global.gray_color)}><I18n text='Total cost' /></div>
        <div style={{fontWeight: 'bold'}}>{total} <I18n text={currency}/></div> 
      </div>
      
    </div>
  )
}

export default SystemPrice