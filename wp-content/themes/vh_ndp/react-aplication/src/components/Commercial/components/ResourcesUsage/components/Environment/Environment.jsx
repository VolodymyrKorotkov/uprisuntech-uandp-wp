import { useState, useEffect } from 'react'
import { Button } from '@mui/material';
import { FormContainer, useForm } from 'react-hook-form-mui'
import {yupResolver} from "@hookform/resolvers/yup";
import global from '../../../../../../App.module.scss'
import { default as I18n } from '../../../../../I18n/I18n'
import {NumberField, CurrencyField} from "../../../../../NumberFields";
import {resourcesUsageSchemas} from '../../validation.schema'

function Environment({data = {}, onSave, forseShowList, typeProjectOther}) {
  const [viewList, setViewList] = useState(forseShowList ? forseShowList : Boolean(localStorage.getItem('show_Environment') == 'true'))
  const formContext = useForm({
    defaultValues: data,
    resolver: yupResolver(resourcesUsageSchemas.environment(typeProjectOther)),
    mode: 'all'
  });

  const onSubmit = (value) => {
    setViewList(!viewList);
    localStorage.setItem('show_Environment', !viewList)

    if (!viewList) {
      onSave(value)
    }
  };

  const onError = (errors) => {
    if(errors && viewList) {
      setViewList(false);
      localStorage.setItem('show_Environment', false)
    }
  }

  return (
    <FormContainer mode="all" formContext={formContext} defaultValues={data} values={data} onError={onError} onSuccess={onSubmit}>
      <div className={global.card}>
        <div className={global.header}>
          <div className={global.row}>
            <div className={global.title}><I18n text={'Environment'} /></div>
            {!forseShowList && <>{!viewList ? <Button className={global.btn} type={'submit'} color={'primary'} startIcon={<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
              <path d="M6.75012 12.1275L3.62262 9L2.55762 10.0575L6.75012 14.25L15.7501 5.25L14.6926 4.1925L6.75012 12.1275Z" fill="#2A59BD"/>
            </svg>}>
              <I18n text={'Collapse'}/>
            </Button> : <Button className={global.btn} type='submit' color={'primary'} startIcon={<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
              <path fillRule="evenodd" clipRule="evenodd" d="M14.295 2.69253L15.3075 3.70503C15.9 4.29003 15.9 5.24253 15.3075 5.82753L5.385 15.75H2.25V12.615L10.05 4.80753L12.1725 2.69253C12.7575 2.10753 13.71 2.10753 14.295 2.69253ZM3.75 14.25L4.8075 14.295L12.1725 6.92253L11.115 5.86503L3.75 13.23V14.25Z" fill="#2A59BD"/>
            </svg>}>
              <I18n text={'Expand'}/>
            </Button>}
            </>}
          </div>
          {!viewList && <div className={global.text_cart_header}>
            <I18n text='Co2 emission is the release of carbon dioxide gas into the atmosphere. Please provide value of CO2 emission by your organization/household per year.'/>
          </div>}
        </div>
        <div className={global.body}>
          {!viewList && <>
            <div className='row'>
              <div className='col-md-12'>
                <CurrencyField
                  name={'current_CO2_emissions'}
                  label={<>
                    <I18n text='Current CO2 emissions'/> {' '} (<I18n text={'t'} />)
                  </>}
                  fullWidth
                  onChange={(e) => {
                    onSave({...data, [e.target.name]: e.target.value})
                  }}
                  options={{
                    min: 1,
                    decimalScale: 2,
                  }}
                />
              </div>
            </div>
            {!typeProjectOther && (
              <>
                <div className='row'>
                  <div className='col-md-12'>
                    <NumberField
                      name={'energy_consumption_level'}
                      label={<I18n
                        text='The level of energy consumption, which is planned to be reduced, but not less than 15%'/>}
                      fullWidth
                      required
                      InputProps={{endAdornment: '%'}}
                      onChange={(e) => {
                        onSave({...data, [e.target.name]: e.target.value})
                      }}
                      options={{min: 15, max: 99}}
                    />
                  </div>
                </div>
                <div className='row'>
                  <div className='col-md-12'>
                    <NumberField
                      name={'planned_reductions'}
                      label={<I18n
                        text='Planned reductions in greenhouse emissions, CO2 emissions, after project implementation, but not less than 20%'/>}
                      fullWidth
                      required
                      InputProps={{endAdornment: '%'}}
                      onChange={(e) => {
                        onSave({...data, [e.target.name]: e.target.value})
                      }}
                      options={{min: 20, max: 99}}
                    />
                  </div>
                </div>
              </>
            )}
          </>}
          {viewList && (data.i_dont_have_this_information_right_now ? <div className={global.block_text}>
            <span><I18n text="I don't have this information right now"/></span>
          </div> : <>
            <div className={global.block_text}>
              <span><I18n text={"Current CO2 emissions"}/></span>
              <div>{data?.current_CO2_emissions || ''} {data?.current_CO2_emissions ? <I18n text={'t'}/> : '-'}</div>
            </div>
            {
              !typeProjectOther && (
                <>
                  <div className={global.block_text}>
                    <span><I18n text={"The level of energy consumption"}/></span>
                    <div>{data?.energy_consumption_level || ''}{' %'}</div>
                  </div>
                  <div className={global.block_text}>
                    <span><I18n text={"Planned reductions in greenhouse emissions"}/></span>
                    <div>{data?.planned_reductions || ''}{' %'}</div>
                  </div>
                </>
              )
            }
          </>)}
        </div>
      </div>
    </FormContainer>
  )
}

export default Environment
