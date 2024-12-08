import { useEffect, useState } from 'react'
import { FormContainer, TextFieldElement, SelectElement, useForm } from 'react-hook-form-mui'
import { Button, Checkbox, FormControlLabel, Radio, RadioGroup, FormHelperText } from '@mui/material';
import {yupResolver} from "@hookform/resolvers/yup";
import global from '../../../../../../App.module.scss'
import UploadField from '../../../../../UploadField/UploadField';
import I18n from '../../../../../I18n/I18n'
import { electricity_supplier, required_voltage } from '../../../../../I18n/translate';
import ListElectricityUsage from './ListElectricityUsage';
import {CurrencyField, NumberField} from "../../../../../NumberFields";
import {resourcesUsageSchemas} from '../../validation.schema'


function ElectricityUsage({data = {}, onSave, forseShowList}) {
  const [viewList, setViewList] = useState(forseShowList ? forseShowList : Boolean(localStorage.getItem('show_ElectricityUsage') == 'true'))

  const formContext = useForm({
    defaultValues: data,
    resolver: yupResolver(resourcesUsageSchemas.electricity_usage),
    mode: 'all'
  });

  useEffect(() => {
    if(!data?.type_tariff){
      onSave({...data, type_tariff: 'kWh'});
    }
  }, [data])

  const onSubmit = (value) => {
    setViewList(!viewList);
    localStorage.setItem('show_ElectricityUsage', !viewList)

    if (!viewList) {
      onSave(value)
    }
  };

  const onError = (errors) => {
    if(errors && viewList) {
      setViewList(false);
      localStorage.setItem('show_ElectricityUsage', false)
    }
  }

  return (
    <FormContainer mode="all" formContext={formContext} defaultValues={data} values={data} onError={onError} onSuccess={onSubmit}>
        <div className={global.card}>
          <div className={global.header}>
            <div className={global.row}>
              <div className={global.title}><I18n text='Electricity usage' /></div>
              {!forseShowList && <>{!viewList ? <Button className={global.btn} type={'submit'} color={'primary'} startIcon={<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                <path d="M6.75012 12.1275L3.62262 9L2.55762 10.0575L6.75012 14.25L15.7501 5.25L14.6926 4.1925L6.75012 12.1275Z" fill="#2A59BD"/>
              </svg>}>
              <I18n text='Collapse' />

              </Button> : <Button className={global.btn} type='submit' color={'primary'} startIcon={<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                <path fillRule="evenodd" clipRule="evenodd" d="M14.295 2.69253L15.3075 3.70503C15.9 4.29003 15.9 5.24253 15.3075 5.82753L5.385 15.75H2.25V12.615L10.05 4.80753L12.1725 2.69253C12.7575 2.10753 13.71 2.10753 14.295 2.69253ZM3.75 14.25L4.8075 14.295L12.1725 6.92253L11.115 5.86503L3.75 13.23V14.25Z" fill="#2A59BD"/>
              </svg>}>
              <I18n text='Expand' />
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
                    required
                    options={[
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
                    defaultValue={data?.type_tariff || 'kWh'}
                    name="type_tariff"
                    value={data.type_tariff}
                    onChange={(e, value) => {
                      onSave({...data, type_tariff: value})
                    }}
                  >
                    <FormControlLabel value="kWh" control={<Radio />} label={<I18n text={"kWh"} />} />
                    <FormControlLabel value="UAH" control={<Radio />} label={<I18n text={"UAH"} />} />
                  </RadioGroup>
                </div>
              </div>

              <div className='row'>
                <div className='col-md-6'>
                  <CurrencyField
                    name={'tariff_per_kWh'}
                    label={<I18n text={'Tariff (UAH per kWh)'} />}
                    fullWidth
                    onChange={(e) => {
                      onSave({...data, [e.target.name]: e.target.value})
                    }}
                  />
                </div>
                <div className='col-md-6 mt-3 mt-md-0'>
                  <CurrencyField
                    name={'night_time_tariff'}
                    label={<I18n text={'Night time tariff (UAH per kWh)'} />}
                    disabled={!Boolean(data.different_tariff_for_night_time_usage)}
                    fullWidth
                    onChange={(e) => {
                      onSave({...data, [e.target.name]: e.target.value})
                    }}
                  />
                </div>
              </div>


              <div className='row'>
                <div className='col-md-6'/>
                <div className='col-md-6'>
                  <FormControlLabel control={<Checkbox />} checked={Boolean(data.different_tariff_for_night_time_usage)} onChange={() => {
                    onSave({...data, different_tariff_for_night_time_usage: !Boolean(data.different_tariff_for_night_time_usage)})
                  }} label={<I18n text='Different tariff for night time usage' />} />
                </div>
              </div>

              {data.period_for_which_we_enter_data != 'Monthly estimate (1-12 month)' && <div className='row'>
                <div className='col-md-6'>
                  <NumberField
                    name={'monthly_electricity_consumption'}
                    label={<I18n text={data.type_tariff == 'kWh' ?
                      data.period_for_which_we_enter_data == 'Year average' ? 'Year consumption (kWh)' : 'Monthly consumption (kWh)'
                      : data.period_for_which_we_enter_data == 'Year average' ? 'Year bill (UAH)' : 'Monthly bill (UAH)'} />}

                    required
                    fullWidth
                    onChange={(e) => {
                      onSave({...data, [e.target.name]: e.target.value})
                    }}
                  />
                </div>
                <div className='col-md-6 mt-3 mt-md-0'>
                  <NumberField
                    name={'nightly_electricity_consumption'}
                    label={<I18n text={data.type_tariff == 'kWh' ?
                    data.period_for_which_we_enter_data == 'Year average' ? 'Year night consumption (kWh)' : 'Monthly night consumption (kWh)'
                    :
                    data.period_for_which_we_enter_data == 'Year average' ? 'Year night bill (UAH)' : 'Monthly night bill (UAH)'} />}

                    disabled={!Boolean(data.different_tariff_for_night_time_usage)}
                    fullWidth
                    onChange={(e) => {
                      onSave({...data, [e.target.name]: e.target.value})
                    }}
                  />
                </div>
              </div>}

              {data.period_for_which_we_enter_data == 'Monthly estimate (1-12 month)' && <>
                <div className="row">
                  <div className="col-md-6 offset-md-6">
                    <FormHelperText>
                      <I18n text="Enter data for month" />
                    </FormHelperText>
                  </div>
                </div>
                <div className='row'>
                  <div className='col-md-6' style={{display: 'flex', alignItems: 'center'}}>
                    <I18n text={`January`} /> (<I18n text={data.type_tariff} />)
                  </div>
                  <div className='col-md-6 mt-3 mt-md-0'>
                    <div className='row'>
                      <div className='col-6'>
                        <NumberField
                          name={'january_day'}
                          label={<I18n text={'Day'} />}
                          fullWidth
                          required
                          onChange={(e) => {
                            onSave({...data, [e.target.name]: e.target.value})
                          }}
                        />
                      </div>
                      <div className='col-6'>
                        <NumberField
                          name={'january_night'}
                          label={<I18n text={'Night'} />}
                          disabled={!Boolean(data.different_tariff_for_night_time_usage)}
                          fullWidth
                          onChange={(e) => {
                            onSave({...data, [e.target.name]: e.target.value})
                          }}
                        />
                      </div>
                    </div>

                  </div>
                </div>
                <div className='row'>
                  <div className='col-md-6' style={{display: 'flex', alignItems: 'center'}}>
                    <I18n text={`February`} /> (<I18n text={data.type_tariff} />)
                  </div>
                  <div className='col-md-6 mt-3 mt-md-0'>
                    <div className='row'>
                      <div className='col-6'>
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
                      <div className='col-6'>
                        <NumberField
                          name={'february_night'}
                          label={<I18n text={'Night'}/>}
                          disabled={!Boolean(data.different_tariff_for_night_time_usage)}
                          fullWidth
                          onChange={(e) => {
                            onSave({...data, [e.target.name]: e.target.value})
                          }}
                        />
                      </div>
                    </div>

                  </div>
                </div>
                <div className='row'>
                  <div className='col-md-6' style={{display: 'flex', alignItems: 'center'}}>
                    <I18n text={`March`} /> (<I18n text={data.type_tariff} />)
                  </div>
                  <div className='col-md-6 mt-3 mt-md-0'>
                    <div className='row'>
                      <div className='col-6'>
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
                      <div className='col-6'>
                        <NumberField
                          name={'march_night'}
                          label={<I18n text={'Night'}/>}
                          disabled={!Boolean(data.different_tariff_for_night_time_usage)}
                          fullWidth
                          onChange={(e) => {
                            onSave({...data, [e.target.name]: e.target.value})
                          }}
                        />
                      </div>
                    </div>

                  </div>
                </div>
                <div className='row'>
                  <div className='col-md-6'  style={{display: 'flex', alignItems: 'center'}}>
                    <I18n text={`April`} /> (<I18n text={data.type_tariff} />)
                  </div>
                  <div className='col-md-6 mt-3 mt-md-0'>
                    <div className='row'>
                      <div className='col-6'>
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
                      <div className='col-6'>
                        <NumberField
                          name={'april_night'}
                          label={<I18n text={'Night'}/>}
                          disabled={!Boolean(data.different_tariff_for_night_time_usage)}
                          fullWidth
                          onChange={(e) => {
                            onSave({...data, [e.target.name]: e.target.value})
                          }}
                        />
                      </div>
                    </div>

                  </div>
                </div>
                <div className='row'>
                  <div className='col-md-6'  style={{display: 'flex', alignItems: 'center'}}>
                    <I18n text={`May`} /> (<I18n text={data.type_tariff} />)
                  </div>
                  <div className='col-md-6 mt-3 mt-md-0'>
                    <div className='row'>
                      <div className='col-6'>
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
                      <div className='col-6'>
                        <NumberField
                          name={'may_night'}
                          label={<I18n text={'Night'}/>}
                          disabled={!Boolean(data.different_tariff_for_night_time_usage)}
                          fullWidth
                          onChange={(e) => {
                            onSave({...data, [e.target.name]: e.target.value})
                          }}
                        />
                      </div>
                    </div>

                  </div>
                </div>
                <div className='row'>
                  <div className='col-md-6'  style={{display: 'flex', alignItems: 'center'}}>
                    <I18n text={`June`} /> (<I18n text={data.type_tariff} />)
                  </div>
                  <div className='col-md-6 mt-3 mt-md-0'>
                    <div className='row'>
                      <div className='col-6'>
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
                      <div className='col-6'>
                        <NumberField
                          name={'june_night'}
                          label={<I18n text={'Night'}/>}
                          disabled={!Boolean(data.different_tariff_for_night_time_usage)}
                          fullWidth
                          onChange={(e) => {
                            onSave({...data, [e.target.name]: e.target.value})
                          }}
                        />
                      </div>
                    </div>

                  </div>
                </div>
                <div className='row'>
                  <div className='col-md-6' style={{display: 'flex', alignItems: 'center'}}>
                    <I18n text={`July`} /> (<I18n text={data.type_tariff} />)
                  </div>
                  <div className='col-md-6 mt-3 mt-md-0'>
                    <div className='row'>
                      <div className='col-6'>
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
                      <div className='col-6'>
                        <NumberField
                          name={'july_night'}
                          label={<I18n text={'Night'}/>}
                          disabled={!Boolean(data.different_tariff_for_night_time_usage)}
                          fullWidth
                          onChange={(e) => {
                            onSave({...data, [e.target.name]: e.target.value})
                          }}
                        />
                      </div>
                    </div>

                  </div>
                </div>
                <div className='row'>
                  <div className='col-md-6' style={{display: 'flex', alignItems: 'center'}}>
                    <I18n text={`August`} /> (<I18n text={data.type_tariff} />)
                  </div>
                  <div className='col-md-6 mt-3 mt-md-0'>
                    <div className='row'>
                      <div className='col-6'>
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
                      <div className='col-6'>
                        <NumberField
                          name={'august_night'}
                          label={<I18n text={'Night'}/>}
                          disabled={!Boolean(data.different_tariff_for_night_time_usage)}
                          fullWidth
                          onChange={(e) => {
                            onSave({...data, [e.target.name]: e.target.value})
                          }}
                        />
                      </div>
                    </div>

                  </div>
                </div>
                <div className='row'>
                  <div className='col-md-6' style={{display: 'flex', alignItems: 'center'}}>
                    <I18n text={`September`} /> (<I18n text={data.type_tariff} />)
                  </div>
                  <div className='col-md-6 mt-3 mt-md-0'>
                    <div className='row'>
                      <div className='col-6'>
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
                      <div className='col-6'>
                        <NumberField
                          name={'september_night'}
                          label={<I18n text={'Night'}/>}
                          disabled={!Boolean(data.different_tariff_for_night_time_usage)}
                          fullWidth
                          onChange={(e) => {
                            onSave({...data, [e.target.name]: e.target.value})
                          }}
                        />
                      </div>
                    </div>

                  </div>
                </div>
                <div className='row'>
                  <div className='col-md-6' style={{display: 'flex', alignItems: 'center'}}>
                    <I18n text={`October`} /> (<I18n text={data.type_tariff} />)
                  </div>
                  <div className='col-md-6 mt-3 mt-md-0'>
                    <div className='row'>
                      <div className='col-6'>
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
                      <div className='col-6'>
                        <NumberField
                          name={'october_night'}
                          label={<I18n text={'Night'}/>}
                          disabled={!Boolean(data.different_tariff_for_night_time_usage)}
                          fullWidth
                          onChange={(e) => {
                            onSave({...data, [e.target.name]: e.target.value})
                          }}
                        />
                      </div>
                    </div>

                  </div>
                </div>
                <div className='row'>
                  <div className='col-md-6' style={{display: 'flex', alignItems: 'center'}}>
                    <I18n text={`November`} /> (<I18n text={data.type_tariff} />)
                  </div>
                  <div className='col-md-6 mt-3 mt-md-0'>
                    <div className='row'>
                      <div className='col-6'>
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
                      <div className='col-6'>
                        <NumberField
                          name={'november_night'}
                          label={<I18n text={'Night'}/>}
                          disabled={!Boolean(data.different_tariff_for_night_time_usage)}
                          fullWidth
                          onChange={(e) => {
                            onSave({...data, [e.target.name]: e.target.value})
                          }}
                        />
                      </div>
                    </div>

                  </div>
                </div>
                <div className='row'>
                  <div className='col-md-6'  style={{display: 'flex', alignItems: 'center'}}>
                    <I18n text={`December`} /> (<I18n text={data.type_tariff} />)
                  </div>
                  <div className='col-md-6 mt-3 mt-md-0'>
                    <div className='row'>
                      <div className='col-6'>
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
                      <div className='col-6'>
                        <NumberField
                          name={'december_night'}
                          label={<I18n text={'Night'}/>}
                          disabled={!Boolean(data.different_tariff_for_night_time_usage)}
                          fullWidth
                          onChange={(e) => {
                            onSave({...data, [e.target.name]: e.target.value})
                          }}
                        />
                      </div>
                    </div>

                  </div>
                </div>
              </>}

              <div className='row'>
                <div className='col-md-12'>
                  <TextFieldElement
                    name={'electricity_supplier'}
                    label={<I18n text={'Electricity supplier'} />}
                    fullWidth
                    onChange={(v) => {
                      onSave({...data, 'electricity_supplier': v.target.value})
                    }}
                  />
                </div>
              </div>
              <div className='row'>
                <div className='col-md-12'>
                  <SelectElement
                    name={'required_voltage'}
                    label={<I18n text='Required voltage (V)'/>}
                    options={Object.keys(required_voltage).map(key => ({id: key, label: <I18n text={key} />}))}
                    fullWidth
                    onChange={(v) => {
                      onSave({...data, 'required_voltage': v})
                    }}
                  />
                </div>
              </div>
              <div className='row'>
                <div className='col-md-12'>
                  <UploadField
                    name={'bill_for_electricity_consumption'}
                    label={<I18n text='Bill for electricity consumption' />}
                    value={data.bill_for_electricity_consumption}
                    onChange={(v) => {
                      formContext.setValue('bill_for_electricity_consumption', v)
                      onSave({...data, 'bill_for_electricity_consumption': v})
                    }}
                  />
                </div>
              </div>
            </>}
            {viewList && <ListElectricityUsage data={data} />}
          </div>
        </div>
      </FormContainer>
  )
}

export default ElectricityUsage
