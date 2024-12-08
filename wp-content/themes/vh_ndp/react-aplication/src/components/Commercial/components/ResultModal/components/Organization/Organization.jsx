import React from 'react'
import I18n from '../../../../../I18n/I18n'
import styles from '../../ResultModal.module.scss'
import global from '../../../../../../App.module.scss'
import classNames from 'classnames'

function Organization({data = {}}) {
  return (
    <div className={styles.modal_box}>
      <h3 className={classNames(global.h3, 'mb-3')}><I18n text='Organization'/></h3>
      <div className={styles.modal_block}>
        <div className={styles.modal_item}>
          <div className={styles.modal_row}>
            <div className={global.semi}><I18n text='About'/></div>
          </div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='Company name'/></div>
            <div>{data?.about?.company_name || ''}</div> 
          </div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='Registration number' /></div>
            <div>{data?.about?.registration_number || <span><I18n text='not filled in'/></span>}</div> 
          </div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='Organizational form' /></div>
            <div><I18n text={data?.about?.organizational_form || ''}/></div> 
          </div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='Type' /></div>
            <div><I18n text={data?.about?.type || ''}/></div> 
          </div>
          <div className={styles.separator}></div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='Field of activities' /></div>
            <div><I18n text={data?.about?.field_of_activities || ''}/></div> 
          </div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text="Type of organization's activities" /></div>
            <div><I18n text={data?.about?.type_of_organizations_activities || ''} /></div> 
          </div>
          <div className={styles.modal_row}>
            <div>{data?.about?.description_of_organizations_activities || ''}</div> 
          </div>
          <div className={styles.separator}></div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='Phone number' /></div>
            <div>{data?.about?.phone || ''}</div> 
          </div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='Email' /></div>
            <div>{data?.about?.email || ''}</div> 
          </div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='Position' /></div>
            <div>{data?.about?.position || ''}</div> 
          </div>
        </div>
        <div className={styles.modal_item}>
          <div className={styles.modal_row}>
            <div className={global.semi}><I18n text='Legal address' /></div>
          </div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='Property type'/></div>
            <div><I18n text={data?.legal_address?.property_type || ''}/></div> 
          </div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='State'/></div>
            <div>{data?.legal_address?.state || ''}</div> 
          </div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='City'/></div>
            <div>{data?.legal_address?.city || ''}</div> 
          </div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='Street'/></div>
            <div>{data?.legal_address?.street || ''} {data?.legal_address?.street_number || ''}</div> 
          </div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='Apartment #'/></div>
            <div>{data?.legal_address?.apartment || ''}</div> 
          </div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='Postal code'/></div>
            <div>{data?.legal_address?.postal_code || ''}</div> 
          </div>
        </div>
        <div className={styles.modal_item}>
          <div className={styles.modal_row}>
            <div className={global.semi}><I18n text='Operating mode'/></div>
          </div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='Working days' /></div>
            <div>{[
                  data?.operating_mode?.monday ? 'Monday' : '',
                  data?.operating_mode?.tuesday ? 'Tuesday' : '',
                  data?.operating_mode?.wednesday ? 'Wednesday' : '',
                  data?.operating_mode?.thursday ? 'Thursday' : '',
                  data?.operating_mode?.friday ? 'Friday' : '',
                  data?.operating_mode?.saturday ? 'Saturday' : '',
                  data?.operating_mode?.sunday ? 'Sunday' : '',
                ].filter(_i => !!_i).map((_i, index) => {
                  return <>{index > 0 ? ', ' : ''}<I18n text={_i} /></>
                }) } 
            </div> 
          </div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='Working hours' /></div>
            <div>{data?.operating_mode?.hours ? data?.operating_mode?.hours + '/' : ''}{data?.operating_mode?.hours && <I18n text='day'/>} { !data?.operating_mode?.hours && data?.operating_mode?.time_from && data?.operating_mode?.time_to ? data?.operating_mode?.time_from + '-' + data?.operating_mode?.time_to : ''  }</div> 
          </div>
        </div>
      </div>
    </div>
  )
}

export default Organization