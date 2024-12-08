import React from 'react'
import { useState } from 'react';
import I18n from '../../../../../I18n/I18n'
import { Button, FormControlLabel, Radio, RadioGroup, Switch } from '@mui/material'
import { FormContainer, TextFieldElement, RadioButtonGroup, useForm } from 'react-hook-form-mui';
import global from '../../../../../../App.module.scss'
import { useEffect } from 'react';

function Incentive({data = {}, onSave, currency, system_price={}, forseListView}) {
  const [viewList, setViewList] = useState(forseListView ? true : Boolean(localStorage.getItem('show_Incentive') == 'true'))
  let total = 0;

  if(system_price?.solution_cost && !isNaN(parseFloat(system_price?.solution_cost))){
    total +=parseFloat(system_price?.solution_cost);
  }

  if(system_price?.installation_cost && !isNaN(parseFloat(system_price?.installation_cost))){
    total +=parseFloat(system_price?.installation_cost);
  } 

  (system_price?.additions || []).map((_i, index) => {
    if(_i?.addition_cost && !isNaN(parseFloat(_i.addition_cost)) && _i?.quantity && !isNaN(parseFloat(_i.quantity))){
      total += parseFloat(_i.addition_cost) * parseFloat(_i.quantity);
    }
  })

  const formContext = useForm({
    defaultValues: data || {},
    values: data || {},
    mode: 'onChange'
  });

  useEffect(() => {
    if(forseListView){
      setViewList(true)
    }
  }, [])


  useEffect(() => {
    if(!data.type){
      onSave({...data, 'type': 'UAH'})
      formContext.setValue('type', 'UAH')
    }
  }, [])

  

  const validateFloat = (value, name) => {
    value = (value || '').replace(',','.')
    const isValidInput = /^\d*\.?\d*$/.test(value);
    if(isValidInput){
      if(parseInt(value) <= 0){
        formContext.setValue(name, '')
        onSave({...data, [name]: ''})
        return;
      }
      if(value.indexOf('.') > -1){
        const leng = value.split('.').pop().length;
        if(leng > 2){
          formContext.setValue(name, parseFloat(value).toFixed(2))
          onSave({...data, [name]: parseFloat(value).toFixed(2)})
        } else {
          formContext.setValue(name, value)
          onSave({...data, [name]: value})
        }
      } else {
        formContext.setValue(name, value)
        onSave({...data, [name]: value})
      }
    } else {
      formContext.setValue(name, '')
      onSave({...data, [name]: ''})
    } 
  }

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

  const onSubmit = (value) => {
    if(viewList){
      setViewList(false);
      localStorage.setItem('show_Incentive', false)
    } else {
      setViewList(true);
      localStorage.setItem('show_Incentive', true)
      onSave(value)
    }
  };

  const result = (data.type || 'UAH') == 'UAH' ? data.incentive ? total - parseFloat(data.incentive) : '' : data.incentive ?  Math.round((total - (total/100 *data.incentive))*100)/100 : '';

  return (
    <FormContainer formContext={formContext} defaultValues={data} values={data} onSuccess={onSubmit}>
      <div className={global.card}>
        <div className={global.header}>
          <div className={global.row}>
            <div className={global.title}><I18n text='Incentive' /></div>
            {!forseListView && <>{!viewList ? <Button className={global.btn} type={'submit'} color={'primary'} startIcon={<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
              <path d="M6.75012 12.1275L3.62262 9L2.55762 10.0575L6.75012 14.25L15.7501 5.25L14.6926 4.1925L6.75012 12.1275Z" fill="#2A59BD"/>
            </svg>}>
              <I18n text='Collapse' />
            </Button> : <Button className={global.btn} type='submit' color={'primary'} startIcon={<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M14.295 2.69253L15.3075 3.70503C15.9 4.29003 15.9 5.24253 15.3075 5.82753L5.385 15.75H2.25V12.615L10.05 4.80753L12.1725 2.69253C12.7575 2.10753 13.71 2.10753 14.295 2.69253ZM3.75 14.25L4.8075 14.295L12.1725 6.92253L11.115 5.86503L3.75 13.23V14.25Z" fill="#2A59BD"/>
            </svg>}>
              <I18n text='Expand' />
            </Button>}</>}
          </div>
        </div>
        <div className={global.body}>
          {!viewList && <>
            <div className='row'>
              <div className='col-md-4'>
                <div style={{display: 'flex', alignItems: 'center', height: 56, justifyContent: 'center'}}>
                  <span style={{marginRight: 16}}>< I18n text={currency}/></span>
                  <Switch className={global.switch} checked={data?.type == '%'} onChange={() => {
                      onSave({...data, 'type': data?.type == 'UAH' ? '%' : 'UAH'})
                  }} />
                  <span style={{marginLeft: 16}}>%</span>
                </div>
              </div>
              <div className='col-md-4'>
                <TextFieldElement
                  name={'incentive'}
                  label={<I18n text={'Incentive'} />}
                  fullWidth
                  // required
                  validation={{
                    max: { 
                      value: data?.type == '%' ? 100 : total, 
                      message: <><I18n text='Number must be less than'/> {data?.type == '%' ? 100 : total}</> 
                    },          
                  }}
                  onChange={(e) => {
                    if(data?.type == '%'){
                      validateInt(e.target.value, 'incentive', 0, 99)
                    } else {
                      validateFloat(e.target.value, 'incentive')
                    }
                  }}
                />
              </div>
              <div className='col-md-4'>
                <TextFieldElement
                  name={'buy_back_electricity_rate'}
                  label={<I18n text={'Buy-back electricity rate'} />}
                  fullWidth
                  // required
                  // validation={{
                  //   required: {
                  //     value: true, 
                  //     message: <I18n text='This field is required'/>},
                  // }}
                  onChange={(e) => {
                    validateFloat(e.target.value, 'buy_back_electricity_rate')
                  }}
                />
              </div>
            </div>
            <div className='row'>
              <div className='col-md-12'>
                <div className={global.block_text}>
                  <span><I18n text={'After incentives'} /></span>
                  <div><span style={{marginRight: 10, textDecoration: 'line-through'}}>{result && result > 0 ? total : ''} {result && result > 0 ? <I18n text={currency}/> : ''}</span>{result && result > 0 ? result : total} <I18n text={currency}/></div>
                </div>
              </div>
            </div>
          </>}
          {viewList && <>
            <div className={global.block_text}>
              <span><I18n text={'Incentive'} /></span>
              <div>{data?.incentive || '0'} {data?.type == 'UAH' ? <I18n text={currency}/> : '%'}</div>
            </div>
            <div className={global.block_text}>
              <span><I18n text={'Buy-back electricity rate'} /></span>
              <div>{data?.buy_back_electricity_rate || '0'} <I18n text={currency}/></div>
            </div>
            <div className={global.block_text}>
              <span><I18n text={'After incentives'} /></span>
              <div>{result && result > 0 ? <span style={{marginRight: 10, textDecoration: 'line-through'}}>{total} <I18n text={currency}/></span> :''} {result && result > 0 ? result : total} <I18n text={currency}/></div>
            </div>
          </>}
        </div>
      </div>
    </FormContainer>
  )
}

export default Incentive