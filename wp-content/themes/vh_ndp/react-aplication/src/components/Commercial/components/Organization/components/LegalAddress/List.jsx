import React from 'react'
import I18n from '../../../../../I18n/I18n'
import global from '../../../../../../App.module.scss'

function List({data = {}}) {
  return (
    <>
      <div className={global.block_text}>
        <span><I18n text={'Property type'} /></span>
        <div><I18n text={data?.property_type || ''}/></div>
      </div>
      <div className={global.block_text}>
        <span><I18n text={'State'} /></span>
        <div>{data?.state || ''}</div>
      </div>
      <div className={global.block_text}>
        <span><I18n text={'City'} /></span>
        <div>{data?.city || ''}</div>
      </div>
      <div className={global.block_text}>
        <span><I18n text={'Street'} /></span>
        <div>{data?.street || ''} {data?.street_number || ''}</div>
      </div>
      {(data?.apartment &&  data?.apartment_type === 'Apartment') && <div className={global.block_text}>
        <span><I18n text={data?.apartment_type == 'Private house' ? 'Private house #' : 'Apartment #'} /></span>
        <div>{data?.apartment || ''}</div>
      </div>}
      <div className={global.block_text}>
        <span><I18n text={'Postal code'} /></span>
        <div>{data?.postal_code || ''}</div>
      </div>
    </>
  )
}

export default List
