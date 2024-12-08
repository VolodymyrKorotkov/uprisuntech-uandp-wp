import { useState } from 'react'
import { FormContainer, SelectElement, useForm } from 'react-hook-form-mui'
import global from '../../../../../../App.module.scss'
import { Button } from '@mui/material';
import I18n from '../../../../../I18n/I18n';
import {NumberField} from "../../../../../NumberFields";

function Roof({data = {}, onSave, forseShowList}) {
  const [viewList, setViewList] = useState(forseShowList ? forseShowList : Boolean(localStorage.getItem('show_Roof') == 'true'))
  const formContext = useForm({
    defaultValues: data || {},
    values: data || {},
    mode: 'onChange'
  });

  const onSubmit = (value) => {
    setViewList(!viewList);
    localStorage.setItem('show_Roof', !viewList)

    if (!viewList) {
      onSave({...data, ...value})
    }
  };

  return (
    <FormContainer mode="all" formContext={formContext} defaultValues={data} values={data} onSuccess={onSubmit}>
      <div className={global.card}>
        <div className={global.header}>
          <div className={global.row}>
            <div className={global.title}><I18n text='Roof' /></div>
            {!forseShowList && <>{!viewList ? <Button className={global.btn} type={'submit'} color={'primary'} startIcon={<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
              <path d="M6.75012 12.1275L3.62262 9L2.55762 10.0575L6.75012 14.25L15.7501 5.25L14.6926 4.1925L6.75012 12.1275Z" fill="#2A59BD"/>
            </svg>}>
              <I18n text='Collapse' />
            </Button> : <Button className={global.btn} type='submit' color={'primary'} startIcon={<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
              <path fillRule="evenodd" clipRule="evenodd" d="M14.295 2.69253L15.3075 3.70503C15.9 4.29003 15.9 5.24253 15.3075 5.82753L5.385 15.75H2.25V12.615L10.05 4.80753L12.1725 2.69253C12.7575 2.10753 13.71 2.10753 14.295 2.69253ZM3.75 14.25L4.8075 14.295L12.1725 6.92253L11.115 5.86503L3.75 13.23V14.25Z" fill="#2A59BD"/>
            </svg>}>

              <I18n text='Expand' />
            </Button>}</>}
          </div>
        </div>
        <div className={global.body}>
          {!viewList && <>
            <div className='row'>
              <div className='col-md-12'>
                <SelectElement
                  name={'roof_type'}
                  label={<I18n text='Roof type' />}
                  disabled={data.i_dont_have_this_information_right_now}
                  options={[
                    {id: 'Composition / Asphalt Shingle', label: <I18n text='Composition / Asphalt Shingle' />},
                    {id: 'Flat Concrete', label: <I18n text='Flat Concrete' />},
                    {id: 'Flat Foam', label: <I18n text='Flat Foam' />},
                    {id: 'Membrane EPDM', label: <I18n text='Membrane EPDM' />},
                    {id: 'Membrane PVC', label: <I18n text='Membrane PVC' />},
                    {id: 'Membrane TPO', label: <I18n text='Membrane TPO' />},
                    {id: 'Metal Decramastic', label: <I18n text='Metal Decramastic' />},
                    {id: 'Metal Shingle', label: <I18n text='Metal Shingle' />},
                    {id: 'Metal Standing Seam', label: <I18n text='Metal Standing Seam' />},
                    {id: 'Metal Stone Coated', label: <I18n text='Metal Stone Coated' />},
                    {id: 'Metal Tin', label: <I18n text='Metal Tin' />},
                    {id: 'Tar and Gravel / Bitumen', label: <I18n text='Tar and Gravel / Bitumen' />},
                    {id: 'Thatched', label: <I18n text='Thatched' />},
                    {id: 'Tile Clay', label: <I18n text='Tile Clay' />},
                    {id: 'Tile Concrete', label: <I18n text='Tile Concrete' />},
                    {id: 'Tile Slate', label: <I18n text='Tile Slate' />},
                    {id: 'Wood / Shake Shingle', label: <I18n text='Wood / Shake Shingle' />},
                    {id: 'Other', label: <I18n text='Other' />},
                    {id: 'Kliplock', label: <I18n text='Kliplock' />},
                  ]}
                  fullWidth
                  onChange={(v) => {
                    onSave({...data, 'roof_type': v})
                  }}
                />
              </div>
            </div>
            <div className='row'>
              <div className='col-md-12'>
                <SelectElement
                  name={'roof_direction'}
                  label={<I18n text='Roof Direction' />}
                  disabled={data.i_dont_have_this_information_right_now}
                  options={[
                    {id: 'South', label: <I18n text='South' />},
                    {id: 'South East', label: <I18n text='South East' />},
                    {id: 'South West', label: <I18n text='South West' />},
                    {id: 'East', label: <I18n text='East' />},
                    {id: 'West', label: <I18n text='West' />},
                    {id: 'North', label: <I18n text='North' />},
                    {id: 'North East', label: <I18n text='North East' />},
                    {id: 'North West', label: <I18n text='North West' />},
                  ]}
                  fullWidth
                  onChange={(v) => {
                    onSave({...data, 'roof_direction': v})
                  }}
                />
              </div>
            </div>
            <div className='row'>
              <div className='col-md-4'>
                <NumberField
                  name={'roof_length'}
                  label={<I18n text='Roof length (m)' />}
                  disabled={data.i_dont_have_this_information_right_now}
                  fullWidth
                  onChange={(e) => {
                    onSave({...data, [e.target.name]: e.target.value})
                  }}
                  options={{
                    allowNegative: false,
                    decimalSeparator: ',',
                    decimalScale: 2,
                  }}
                />
              </div>
              <div className='col-md-4 mt-3 mt-md-0'>
                <NumberField
                  name={'roof_width_depth'}
                  label={<I18n text='Roof width/depth (m)' />}
                  disabled={data.i_dont_have_this_information_right_now}
                  fullWidth
                  onChange={(e) => {
                    onSave({...data, [e.target.name]: e.target.value})
                  }}
                  options={{
                    allowNegative: false,
                    decimalSeparator: ',',
                    decimalScale: 2,
                  }}
                />
              </div>
              <div className='col-md-4 mt-3 mt-md-0'>
                <NumberField
                  name={'roof_pitch'}
                  label={<I18n text='Roof pitch (°)' />}
                  disabled={data.i_dont_have_this_information_right_now}
                  fullWidth
                  onChange={(e) => {
                    onSave({...data, [e.target.name]: e.target.value})
                  }}
                  options={{min: 1, max: 99}}
                />
              </div>
            </div>

          </>}
          {viewList && (data.i_dont_have_this_information_right_now ? <div className={global.block_text}>
              <span><I18n text="I don't have this information right now" /></span>
            </div> : <>
            <div className={global.block_text}>
              <span><I18n text='Roof type' /></span>
              <div><I18n text={data?.roof_type || '-'} /></div>
            </div>
            <div className={global.block_text}>
              <span><I18n text='Roof Direction' /></span>
              <div><I18n text={data?.roof_direction || '-'} /></div>
            </div>
            <div className={global.block_text}>
              <span><I18n text='Roof length' /></span>
              <div>{data?.roof_length || ''}{data?.roof_length ? <I18n text="m" /> : '-'}</div>
            </div>
            <div className={global.block_text}>
              <span><I18n text='Roof width/depth' /></span>
              <div>{data?.roof_width_depth || ''}{data?.roof_width_depth ? <I18n text="m" /> : '-'}</div>
            </div>
            <div className={global.block_text}>
              <span><I18n text='Roof pitch' /></span>
              <div>{data?.roof_pitch && data?.roof_pitch +'°' || '-'}</div>
            </div>

          </>)}
        </div>
      </div>
    </FormContainer>
  )
}

export default Roof
