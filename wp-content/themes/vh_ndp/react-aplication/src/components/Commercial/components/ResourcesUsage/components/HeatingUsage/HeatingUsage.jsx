import { useEffect, useState } from 'react'
import {yupResolver} from "@hookform/resolvers/yup";
import { FormContainer, TextFieldElement, SelectElement, useForm } from 'react-hook-form-mui'
import {Button, FormControlLabel, FormHelperText, Radio, RadioGroup} from '@mui/material';
import global from '../../../../../../App.module.scss'
import UploadField from '../../../../../UploadField/UploadField';
import I18n from '../../../../../I18n/I18n'
import ListHeatingUsage from './ListHeatingUsage';
import {CurrencyField, NumberField} from "../../../../../NumberFields";
import {getHeatingConsumptionLabel} from "../../../../../../lib/formatter";
import {resourcesUsageSchemas} from "../../validation.schema";


function HeatingUsage({data = {}, onSave, forseShowList}) {
  const [viewList, setViewList] = useState(forseShowList ? forseShowList : Boolean(localStorage.getItem('show_HeatingUsage') == 'true'))

  const formContext = useForm({
    defaultValues: data,
    resolver: yupResolver(resourcesUsageSchemas.heating_usage),
    mode: 'all'
  });

  useEffect(() => {
    if(!data?.type_tariff){
      onSave({...data, type_tariff: 'Gcal'});
    }
  }, [data])

  const onSubmit = (value) => {
    setViewList(!viewList);
    localStorage.setItem('show_HeatingUsage', !viewList)

    if (!viewList) {
      onSave({...data, ...value})
    }
  };

  const onError = (errors) => {
    if(errors && viewList) {
      setViewList(false);
      localStorage.setItem('show_HeatingUsage', false)
    }
  }

  return (
    <FormContainer mode="all" formContext={formContext} defaultValues={data} values={data} onError={onError} onSuccess={onSubmit}>
      <div className={global.card}>
        <div className={global.header}>
          <div className={global.row}>
            <div className={global.title}><I18n text={'Heating usage'} /></div>
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
        </div>
        <div className={global.body}>
          {!viewList && <>
            <div className='row'>
              <div className='col-md-6'>
                <SelectElement
                  name={'period_for_which_we_enter_data'}
                  label={<I18n text='Period for which we enter data'/>}
                  options={[
                    {id: '', label: ''},
                    {id: 'Year average', label: <I18n text='Year average' />},
                    {id: 'Monthly average', label: <I18n text='Monthly average' />},
                    {id: 'Monthly estimate (1-12 month)', label: <I18n text='Monthly estimate (1-12 month)' />},
                  ]}
                  fullWidth
                  onChange={(v) => {
                    onSave({...data, 'period_for_which_we_enter_data': v})
                  }}
                />
              </div>
              <div className='col-md-6'>
                <RadioGroup
                  row
                  aria-labelledby="demo-radio-buttons-group-label"
                  defaultValue={'UAH'}
                  name="type_tariff"
                  value={data.type_tariff}
                  onChange={(e, value) => {
                    onSave({...data, type_tariff: value})
                  }}
                >
                  <FormControlLabel value="Gcal" control={<Radio />} label={<I18n text="Gcal"/>} />
                  <FormControlLabel value="UAH" control={<Radio />} label={<I18n text="UAH"/>} />
                </RadioGroup>
              </div>
            </div>
            <div className='row'>
              <div className={data.period_for_which_we_enter_data != 'Monthly estimate (1-12 month)' ?'col-md-6' : 'col-md-12'}>
                <CurrencyField
                  name={'tariff_per'}
                  label={<I18n text={`Tariff (UAH per Gcal)`} />}
                  fullWidth
                  onChange={(e) => {
                    onSave({...data, [e.target.name]: e.target.value})
                  }}
                />
              </div>
              {data.period_for_which_we_enter_data != 'Monthly estimate (1-12 month)' &&
                <div className='col-md-6 mt-3 mt-md-0'>
                  <NumberField
                    name={'heating_consumption'}
                    disabled={data.i_dont_have_this_information_right_now}
                    fullWidth
                    label={<I18n text={getHeatingConsumptionLabel(data)}/>}
                    onChange={(e) => {
                      onSave({...data, [e.target.name]: e.target.value})
                    }}
                  />
                </div>}

            </div>
            {data.period_for_which_we_enter_data == 'Monthly estimate (1-12 month)' && <>
              <div className="row">
                <div className="col-md-6 offset-md-6">
                  <FormHelperText>
                    <I18n text="Enter data for month"/>
                  </FormHelperText>
                </div>
              </div>
              <div className='row'>
                <div className='col-md-6' style={{display: 'flex', alignItems: 'center'}}>
                  <I18n text={`January`}/> (<I18n text={data.type_tariff}/>)
                </div>
                <div className='col-md-6 mt-3 mt-md-0'>
                  <NumberField
                    name={'january_day'}
                    label={<I18n text={'Day'}/>}
                    fullWidth
                    required
                    onChange={(e) => {
                      onSave({...data, [e.target.name]: e.target.value})
                    }}
                  />
                </div>
              </div>
              <div className='row'>
                <div className='col-md-6' style={{display: 'flex', alignItems: 'center'}}>
                  <I18n text={`February`}/> (<I18n text={data.type_tariff}/>)
                </div>
                <div className='col-md-6 mt-3 mt-md-0'>
                  <NumberField
                    name={'february_day'}
                    label={<I18n text={'Day'}/>}
                    fullWidth
                    required
                    onChange={(e) => {
                      onSave({...data, [e.target.name]: e.target.value})
                    }}
                  />
                </div>
              </div>
              <div className='row'>
                <div className='col-md-6' style={{display: 'flex', alignItems: 'center'}}>
                  <I18n text={`March`}/> (<I18n text={data.type_tariff}/>)
                </div>
                <div className='col-md-6 mt-3 mt-md-0'>
                  <NumberField
                    name={'march_day'}
                    label={<I18n text={'Day'}/>}
                    fullWidth
                    required
                    onChange={(e) => {
                      onSave({...data, [e.target.name]: e.target.value})
                    }}
                  />

                </div>
              </div>
              <div className='row'>
                <div className='col-md-6' style={{display: 'flex', alignItems: 'center'}}>
                  <I18n text={`April`}/> (<I18n text={data.type_tariff}/>)
                </div>
                <div className='col-md-6 mt-3 mt-md-0'>
                  <NumberField
                    name={'april_day'}
                    label={<I18n text={'Day'}/>}
                    fullWidth
                    required
                    onChange={(e) => {
                      onSave({...data, [e.target.name]: e.target.value})
                    }}
                  />

                </div>
              </div>
              <div className='row'>
                <div className='col-md-6' style={{display: 'flex', alignItems: 'center'}}>
                  <I18n text={`May`}/> (<I18n text={data.type_tariff}/>)
                </div>
                <div className='col-md-6 mt-3 mt-md-0'>
                  <NumberField
                    name={'may_day'}
                    label={<I18n text={'Day'}/>}
                    fullWidth
                    required
                    onChange={(e) => {
                      onSave({...data, [e.target.name]: e.target.value})
                    }}
                  />

                </div>
              </div>
              <div className='row'>
                <div className='col-md-6' style={{display: 'flex', alignItems: 'center'}}>
                  <I18n text={`June`}/> (<I18n text={data.type_tariff}/>)
                </div>
                <div className='col-md-6 mt-3 mt-md-0'>
                  <NumberField
                    name={'june_day'}
                    label={<I18n text={'Day'}/>}
                    fullWidth
                    required
                    onChange={(e) => {
                      onSave({...data, [e.target.name]: e.target.value})
                    }}
                  />

                </div>
              </div>
              <div className='row'>
                <div className='col-md-6' style={{display: 'flex', alignItems: 'center'}}>
                  <I18n text={`July`}/> (<I18n text={data.type_tariff}/>)
                </div>
                <div className='col-md-6 mt-3 mt-md-0'>
                  <NumberField
                    name={'july_day'}
                    label={<I18n text={'Day'}/>}
                    fullWidth
                    required
                    onChange={(e) => {
                      onSave({...data, [e.target.name]: e.target.value})
                    }}
                  />

                </div>
              </div>
              <div className='row'>
                <div className='col-md-6' style={{display: 'flex', alignItems: 'center'}}>
                  <I18n text={`August`}/> (<I18n text={data.type_tariff}/>)
                </div>
                <div className='col-md-6 mt-3 mt-md-0'>
                  <NumberField
                    name={'august_day'}
                    label={<I18n text={'Day'}/>}
                    fullWidth
                    required
                    onChange={(e) => {
                      onSave({...data, [e.target.name]: e.target.value})
                    }}
                  />

                </div>
              </div>
              <div className='row'>
                <div className='col-md-6' style={{display: 'flex', alignItems: 'center'}}>
                  <I18n text={`September`}/> (<I18n text={data.type_tariff}/>)
                </div>
                <div className='col-md-6 mt-3 mt-md-0'>
                  <NumberField
                    name={'september_day'}
                    label={<I18n text={'Day'}/>}
                    fullWidth
                    required
                    onChange={(e) => {
                      onSave({...data, [e.target.name]: e.target.value})
                    }}
                  />

                </div>
              </div>
              <div className='row'>
                <div className='col-md-6' style={{display: 'flex', alignItems: 'center'}}>
                  <I18n text={`October`}/> (<I18n text={data.type_tariff}/>)
                </div>
                <div className='col-md-6 mt-3 mt-md-0'>
                  <NumberField
                    name={'october_day'}
                    label={<I18n text={'Day'}/>}
                    fullWidth
                    required
                    onChange={(e) => {
                      onSave({...data, [e.target.name]: e.target.value})
                    }}
                  />

                </div>
              </div>
              <div className='row'>
                <div className='col-md-6' style={{display: 'flex', alignItems: 'center'}}>
                  <I18n text={`November`}/> (<I18n text={data.type_tariff}/>)
                </div>
                <div className='col-md-6 mt-3 mt-md-0'>
                  <NumberField
                    name={'november_day'}
                    label={<I18n text={'Day'}/>}
                    fullWidth
                    required
                    onChange={(e) => {
                      onSave({...data, [e.target.name]: e.target.value})
                    }}
                  />

                </div>
              </div>
              <div className='row'>
                <div className='col-md-6' style={{display: 'flex', alignItems: 'center'}}>
                  <I18n text={`December`}/> (<I18n text={data.type_tariff}/>)
                </div>
                <div className='col-md-6 mt-3 mt-md-0'>
                  <NumberField
                    name={'december_day'}
                    label={<I18n text={'Day'}/>}
                    fullWidth
                    required
                    onChange={(e) => {
                      onSave({...data, [e.target.name]: e.target.value})
                    }}
                  />

                </div>
              </div>
            </>}

            <div className='row'>
              <div className='col-md-12'>
                <TextFieldElement
                  name={'heating_supplier'}
                  label={<I18n text={'Heating supplier'}/>}
                  disabled={data.i_dont_have_this_information_right_now}
                  fullWidth
                  onChange={(e) => {
                    onSave({...data, 'heating_supplier': e.target.value})
                  }}
                />
              </div>
            </div>

            <div className='row'>
              <div className='col-md-12'>
                <UploadField
                  name={'bill_for_heating_consumption'}
                  label={<I18n text='Bill for heating consumption'/>}
                  disabled={data.i_dont_have_this_information_right_now}
                  value={data.bill_for_heating_consumption}
                  onChange={(v) => {
                    formContext.setValue('bill_for_heating_consumption', v)
                    onSave({...data, 'bill_for_heating_consumption': v})
                  }}
                />
              </div>
            </div>
          </>}
          {viewList && <ListHeatingUsage data={data} /> }
        </div>
      </div>
    </FormContainer>
  )
}

export default HeatingUsage
