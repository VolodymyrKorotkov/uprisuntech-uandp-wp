import classNames from 'classnames'
import React from 'react'
import I18n from '../../../../../I18n/I18n'
import styles from '../../ResultModal.module.scss'
import global from '../../../../../../App.module.scss'
import PlaceAddress from './PlaceAddress'

function Place({data = {}}) {
  return (
    <div className={styles.modal_box}>
      <h3 className={classNames(global.h3, 'mb-3')}><I18n text={'Place of installation'} /></h3>
      <div className={styles.modal_block}>
        <PlaceAddress data={data?.place} />
        <div className={styles.modal_item}>
          <div className={styles.modal_row}>
            <div className={global.semi}><I18n text='Building information'/></div>
          </div>
          {data?.building_information?.i_dont_have_this_information_right_now ? <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text="I don't have this information right now" /></div>
          </div> : <>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='Number of storeys'/></div>
            <div>{data?.building_information?.number_of_storeys || ''}</div> 
          </div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='Year of construction'/></div>
            <div>{data?.building_information?.year_of_construction || ''}</div> 
          </div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='Building height'/></div>
            <div>{data?.building_information?.building_height || ''}<I18n text="m" /></div> 
          </div>
          </>}
        </div>
        <div className={styles.modal_item}>
          <div className={styles.modal_row}>
            <div className={global.semi}><I18n text="Roof" /></div>
          </div>
          {data?.roof?.i_dont_have_this_information_right_now ? <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text="I don't have this information right now" /></div>
          </div> : <>
            <div className={styles.modal_row}>
              <div className={classNames(global.font_14, global.gray_color)}><I18n text="Roof type" /></div>
              <div><I18n text={data?.roof?.roof_type || ''} /></div> 
            </div>
            <div className={styles.modal_row}>
              <div className={classNames(global.font_14, global.gray_color)}><I18n text="Roof Direction" /></div>
              <div><I18n text={data?.roof?.roof_direction || ''} /></div> 
            </div>
            <div className={styles.modal_row}>
              <div className={classNames(global.font_14, global.gray_color)}><I18n text="Roof length" /></div>
              <div>{data?.roof?.roof_length || ''}<I18n text="m" /></div> 
            </div>
            <div className={styles.modal_row}>
              <div className={classNames(global.font_14, global.gray_color)}><I18n text="Roof width/depth" /></div>
              <div>{data?.roof?.roof_width_depth || ''}<I18n text="m" /></div> 
            </div>
            <div className={styles.modal_row}>
              <div className={classNames(global.font_14, global.gray_color)}><I18n text="Roof pitch" /></div>
              <div>{data?.roof?.roof_pitch || ''}°</div> 
            </div>
          </>}
        </div>
      </div>
    </div>
  )
}

export default Place