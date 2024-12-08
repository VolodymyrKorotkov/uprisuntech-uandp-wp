import React, { useEffect, useState } from 'react';
import global from '../../../../App.module.scss';
import { t, default as I18n } from '../../../I18n/I18n';
import { FormContainer, SelectElement, TextFieldElement, useForm } from 'react-hook-form-mui';
import { equipment_manufacturers_types } from '../../../I18n/translate';
import { Button } from '@mui/material';

const TechnicalDisplays = ({forseShowList, data, onSave}) => {
  const [viewList, setViewList] = useState(forseShowList ? forseShowList : Boolean(localStorage.getItem('show_ProjectInformation') == 'true'))

  const formContext = useForm({
    defaultValues: data || {},
    values: data || {},
    mode: 'all'
  });

  const onSubmit = (value) => {
    if(viewList){
      setViewList(false);
      localStorage.setItem('show_technical_display_short_list', false)
    } else {
      setViewList(true);
      localStorage.setItem('show_technical_display_short_list', true)
      onSave({...data, ...value})
    }
  };

  const validateInt = (value, name, min=0, max) => {
    const isValidInput = /^\d*$/.test(value);
    if(isValidInput && !isNaN(parseInt(value))){
      if(parseInt(value) <= min){
        formContext.setValue(name, '')
        onSave({...data, [name]: ''})
        return;
      }
      if(max && parseInt(value) > max){
        formContext.setValue(name, max)
        onSave({...data, [name]: max})
        return;
      }
      formContext.setValue(name, value)
      onSave({...data, [name]: value})
    } else {
      formContext.setValue(name, '')
      onSave({...data, [name]: ''})
    }
  }

  useEffect(() => {
    if(forseShowList){
      setViewList(true)
    }
  }, [forseShowList])

  return (
    <div>
      <div className={global.header_title}>
        <div className={global.title}><I18n text='Technical displays' /></div>
        <div className={global.text}>
          {!forseShowList && <I18n text='* Required sections must be filled in' />}
        </div>
      </div>
      <FormContainer mode="all" formContext={formContext} defaultValues={data} values={data} onSuccess={onSubmit}>
        <div className={global.card}>
          <div className={global.header}>
            <div className={global.row}>
              <div className={global.title}><I18n text='Technical displays'/></div>
              {!forseShowList && <>{!viewList ? (
                <Button className={global.btn} type='submit' color='primary'
                        startIcon={<svg xmlns="http://www.w3.org/2000/svg" width="18"
                                        height="18" viewBox="0 0 18 18" fill="none">
                          <path
                            d="M6.75012 12.1275L3.62262 9L2.55762 10.0575L6.75012 14.25L15.7501 5.25L14.6926 4.1925L6.75012 12.1275Z"
                            fill="#2A59BD"/>
                        </svg>}>
                  <I18n text='Collapse'/>
                </Button>
              ) : (
                <Button className={global.btn} type='submit' color='primary'
                        startIcon={<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                        viewBox="0 0 18 18" fill="none">
                          <path fillRule="evenodd" clipRule="evenodd"
                                d="M14.295 2.69253L15.3075 3.70503C15.9 4.29003 15.9 5.24253 15.3075 5.82753L5.385 15.75H2.25V12.615L10.05 4.80753L12.1725 2.69253C12.7575 2.10753 13.71 2.10753 14.295 2.69253ZM3.75 14.25L4.8075 14.295L12.1725 6.92253L11.115 5.86503L3.75 13.23V14.25Z"
                                fill="#2A59BD"/>
                        </svg>}>
                  <I18n text='Expand'/>
                </Button>
              )}</>}
            </div>
          </div>
          <div className={global.body}>
            {!viewList &&
              <>
                <div className='row'>
                  <div className='col-md-12'>
                    <TextFieldElement
                      name={'basic_calculation_year'}
                      fullWidth
                      type='number'
                      required
                      label={<I18n text='The year of the basic calculation of energy resource costs in the calculation for the project'/>}
                      validation={{
                        required: {
                          value: true,
                          message: t('This field is required')},

                        maxLength: {
                          value: 4,
                          message: t('Field length 4 digits'),
                        },
                        minLength: {
                          value: 4,
                          message: t('Field length 4 digits'),
                        },
                      }}
                      value={data?.basic_calculation_year || ''}
                      onChange={(e) => {
                        validateInt(((e.target.value || '').replace(/\D/g, '') + '').slice(0, 4), 'basic_calculation_year')
                      }}
                    />
                  </div>
                </div>
                <div className='row'>
                  <div className='col-md-6'>

                    <TextFieldElement
                      name={'base_consumption_level'}
                      fullWidth
                      label={<I18n text='The actual level of energy consumption'/>}
                      type='number'
                      helperText={<I18n text='For the base year, taken into account in the project, kWh'/>}
                      required
                      validation={{
                        required: {
                          value: true,
                          message: t('This field is required')},
                      }}
                      value={data?.base_consumption_level || ''}
                      onChange={(e) => {
                        onSave({...data, base_consumption_level: e.target.value})
                      }}
                    />
                  </div>
                  <div className='col-md-6'>
                    <TextFieldElement
                      name={'base_consumption_tariff'}
                      fullWidth
                      required
                      label={<I18n text='Tariff for the base year energy resource'/>}
                      type='number'
                      helperText={<I18n text='Tariff included in the project, UAH per 1 kW/h'/>}
                      validation={{
                        required: {
                          value: true,
                          message: t('This field is required')},
                      }}
                      value={data?.base_consumption_tariff || ''}
                      onChange={(e) => {
                        onSave({...data, base_consumption_tariff: e.target.value})
                      }}
                    />
                  </div>
                </div>
                <div className='row'>
                  <div className='col-md-6'>
                    <TextFieldElement
                      name={'current_consumption_level'}
                      fullWidth
                      label={<I18n text='The actual level of energy consumption of the facility'/>}
                      helperText={<I18n text='Level for 2023, kWh'/>}
                      required
                      type='number'
                      validation={{
                        required: {
                          value: true,
                          message: t('This field is required')},
                      }}
                      value={data?.current_consumption_level || ''}
                      onChange={(e) => {
                        onSave({...data, current_consumption_level: e.target.value})
                      }}
                    />
                  </div>
                  <div className='col-md-6'>
                    <TextFieldElement
                      name={'current_consumption_tariff'}
                      fullWidth
                      label={<I18n text='Tariff for energy resource in 2023, UAH per 1 kW/h'/>}
                      required
                      type='number'
                      validation={{
                        required: {
                          value: true,
                          message: t('This field is required')},
                      }}
                      value={data?.current_consumption_tariff || ''}
                      onChange={(e) => {
                        onSave({...data, current_consumption_tariff: e.target.value})
                      }}
                    />
                  </div>
                </div>
                <div className='row'>
                  <div className='col-md-6'>
                    <TextFieldElement
                      name={'planned_consumption_level'}
                      fullWidth
                      required
                      type='number'
                      label={<I18n text='The level of energy consumption'/>}
                      helperText={<I18n text='The level, which is planned to be reduced, but not less than 15%'/>}
                      validation={{
                        required: {
                          value: true,
                          message: t('This field is required')},
                      }}
                      value={data?.planned_consumption_level || ''}
                      onChange={(e) => {
                        onSave({...data, planned_consumption_level: e.target.value})
                      }}
                    />
                  </div>
                  <div className='col-md-6'>
                    <TextFieldElement
                      name={'planned_consumption_tariff'}
                      fullWidth
                      required
                      type='number'
                      label={<I18n text='Planned reductions in greenhouse emissions, CO2 emissions'/>}
                      helperText={<I18n text='After project implementation, but not less than 20%'/>}
                      validation={{
                        required: {
                          value: true,
                          message: t('This field is required')},
                      }}
                      value={data?.planned_consumption_tariff || ''}
                      onChange={(e) => {
                        onSave({...data, planned_consumption_tariff: e.target.value})
                      }}
                    />
                  </div>
                </div>
                <div className='row'>
                  <div className='col-md-12'>
                    <TextFieldElement
                      name={'project_sustainability'}
                      fullWidth
                      label={<I18n text={'Determination of project sustainability, maximum service life, in years'} />}
                      required
                      type='number'
                      validation={{
                        required: {
                          value: true,
                          message: t('This field is required')},
                      }}
                      value={data?.project_sustainability || ''}
                      onChange={(e) => {
                        onSave({...data, project_sustainability: e.target.value})
                      }}
                    />
                  </div>
                </div>
                <div className='row'>
                  <div className='col-md-12'>
                    <SelectElement
                      name={'equipment_manufacturer'}
                      label={<I18n text={'The project is expected to be implemented with the involvement of equipment manufacturers'} />}
                      required
                      validation={{
                        required: {
                          value: true,
                          message: t('This field is required')},
                      }}
                      options={Object.keys(equipment_manufacturers_types).map(key => ({id: key, label: <I18n text={key} />}))}
                      fullWidth
                      onChange={(v) => {
                        onSave({...data, 'equipment_manufacturer': v})
                      }}
                    />
                  </div>
                </div>
              </>
            }
            {viewList &&
              <>
                <div className={global.block_text}>
                  <span><I18n text='The year of the basic calculation of energy resource costs in the calculation for the project'/></span>
                  <div><I18n text={data?.basic_calculation_year || '-'}/></div>
                </div>
                <div className={global.block_text}>
                  <span><I18n text='The actual level of energy consumption'/></span>
                  <div><I18n text={data?.base_consumption_level || '-'}/></div>
                </div>
                <div className={global.block_text}>
                  <span><I18n text='Tariff for the base year energy resource'/></span>
                  <div><I18n text={data?.base_consumption_tariff || '-'}/></div>
                </div>
                <div className={global.block_text}>
                  <span><I18n text='The actual level of energy consumption of the facility'/></span>
                  <div><I18n text={data?.current_consumption_level || '-'}/></div>
                </div>
                <div className={global.block_text}>
                  <span><I18n text='Tariff for energy resource in 2023, UAH per 1 kW/h'/></span>
                  <div><I18n text={data?.current_consumption_tariff || '-'}/></div>
                </div>
                <div className={global.block_text}>
                  <span><I18n text='The level of energy consumption'/></span>
                  <div><I18n text={data?.planned_consumption_level || '-'}/></div>
                </div>
                <div className={global.block_text}>
                  <span><I18n text='Planned reductions in greenhouse emissions, CO2 emissions'/></span>
                  <div><I18n text={data?.planned_consumption_tariff || '-'}/></div>
                </div>
                <div className={global.block_text}>
                  <span><I18n text='Determination of project sustainability, maximum service life, in years'/></span>
                  <div><I18n text={data?.project_sustainability || '-'}/></div>
                </div>
                <div className={global.block_text}>
                  <span><I18n text='The project is expected to be implemented with the involvement of equipment manufacturers'/></span>
                  <div><I18n text={data?.equipment_manufacturer || '-'}/></div>
                </div>
              </>
            }
          </div>
        </div>
      </FormContainer>
    </div>
  );
};

export default TechnicalDisplays;