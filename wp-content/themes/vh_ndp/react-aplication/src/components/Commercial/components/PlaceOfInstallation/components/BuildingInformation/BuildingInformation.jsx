import { useState } from 'react'
import { FormContainer, useForm } from 'react-hook-form-mui'
import global from '../../../../../../App.module.scss'
import { Button } from '@mui/material';
import I18n from '../../../../../I18n/I18n';
import {NumberField} from "../../../../../NumberFields";
import {yupResolver} from "@hookform/resolvers/yup";
import {placeOfInstallationSchemas} from "../../validation.schema";

function BuildingInformation({data = {}, onSave, forseShowList}) {
  const [viewList, setViewList] = useState(forseShowList ? forseShowList : Boolean(localStorage.getItem('show_BuildingInformation') == 'true'))
  const formContext = useForm({
    defaultValues: data,
    resolver: yupResolver(placeOfInstallationSchemas.building_information),
    mode: 'all'
  })

  const onSubmit = (value) => {
    setViewList(!viewList);
    localStorage.setItem('show_BuildingInformation', !viewList)

    if (!viewList) {
      onSave(value)
    }
  };

  return (
    <FormContainer mode="all" formContext={formContext} defaultValues={data} values={data} onSuccess={onSubmit}>
      <div className={global.card}>
        <div className={global.header}>
          <div className={global.row}>
            <div className={global.title}><I18n text={'Building information'} /></div>
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
              <div className='col-md-4'>
                <NumberField
                  name={'number_of_storeys'}
                  label={<I18n text="Number of storeys" />}
                  fullWidth
                  onChange={(e) => {
                    onSave({...data, [e.target.name]: e.target.value})
                  }}
                />
              </div>
              <div className='col-md-4 mt-3 mt-md-0'>
                <NumberField
                  name={'year_of_construction'}
                  label={<I18n text="Year of construction" />}
                  disabled={data.i_dont_have_this_information_right_now}
                  fullWidth
                  onChange={(e) => {
                    onSave({...data, [e.target.name]: e.target.value})
                  }}
                  options={{min: 1000, max: 9999}}
                />
              </div>
              <div className='col-md-4 mt-3 mt-md-0'>
                <NumberField
                  name={'building_height'}
                  label={<I18n text="Building height (m)" />}
                  disabled={data.i_dont_have_this_information_right_now}
                  fullWidth
                  onChange={(e) => {
                    onSave({...data, [e.target.name]: e.target.value})
                  }}
                />
              </div>
            </div>

          </>}
          {viewList && (data.i_dont_have_this_information_right_now ? <div className={global.block_text}>
              <span><I18n text="I don't have this information right now" /></span>
            </div> : <>
            <div className={global.block_text}>
              <span><I18n text="Number of storeys" /></span>
              <div>{data?.number_of_storeys || '-'}</div>
            </div>
            <div className={global.block_text}>
              <span><I18n text="Year of construction" /></span>
              <div>{data?.year_of_construction || '-'}</div>
            </div>
            <div className={global.block_text}>
              <span><I18n text="Building height" /></span>
              <div>{data?.building_height || ''}{data?.building_height ? <I18n text="m" /> : '-'}</div>
            </div>

          </>)}
        </div>
      </div>
    </FormContainer>
  )
}

export default BuildingInformation
