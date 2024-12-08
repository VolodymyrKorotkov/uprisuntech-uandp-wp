import React, { useEffect } from 'react'
import { useState } from 'react';
import I18n from '../../../../../I18n/I18n'
import { Button, FormControlLabel, Radio, RadioGroup } from '@mui/material'
import { FormContainer, TextFieldElement, RadioButtonGroup, useForm } from 'react-hook-form-mui';
import global from '../../../../../../App.module.scss'

function EconomyMonthByMonth({data = {}, onSave, currency, forseListView}) {
  const [viewList, setViewList] = useState(forseListView ? true : Boolean(localStorage.getItem('show_EconomyMonthByMonth') == 'true'))

  
  useEffect(() => {
    if(forseListView){
      setViewList(true)
    }
  }, [forseListView])


  const formContext = useForm({
    defaultValues: data || {},
    values: data || {},
    mode: 'all'
  });

  const validateFloat = (value, name) => {
    value = (value || '').replace(',','.').replace('-', '').replace('e', '')
    if(!value){
      formContext.setValue(name, '')
      onSave({...data, [name]: ''})
      return;
    }
    const isValidInput = /^\d*\.?\d*$/.test(value);
    console.log("🚀 ~ validateFloat ~ value:", value, isValidInput)
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
      localStorage.setItem('show_EconomyMonthByMonth', false)
    } else {
      setViewList(true);
      localStorage.setItem('show_EconomyMonthByMonth', true)
      onSave(value)
    }
  };
  return (
    <FormContainer mode="all" formContext={formContext} defaultValues={data} values={data} onSuccess={onSubmit}>
      <div className={global.card}>
        <div className={global.header}>
          <div className={global.row}>
            <div className={global.title}><I18n text='Economy month by month' /></div>
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
              <div className='col-md-12'>
                <strong><I18n text='Electricity production (kWh)' /></strong>
              </div>
            </div>
            <div className='row'>
              <div className='col-md-3'>
                <TextFieldElement
                  name={'january'}
                  label={<I18n text={'January'} />}
                  
                  fullWidth
                  required
                  validation={{
                    required: {
                      value: true, 
                      message: <I18n text='This field is required'/>},
                  }}
                  onChange={(e) => {
                    validateFloat(e.target.value, 'january')
                  }}
                />
              </div>
              <div className='col-md-3'>
                <TextFieldElement
                  name={'february'}
                  label={<I18n text={'February'} />}
                  
                  fullWidth
                  required
                  validation={{
                    required: {
                      value: true, 
                      message: <I18n text='This field is required'/>},
                  }}
                  onChange={(e) => {
                    validateFloat(e.target.value, 'february')
                  }}
                />
              </div>
              <div className='col-md-3'>
                <TextFieldElement
                  name={'march'}
                  label={<I18n text={'March'} />}
                  
                  fullWidth
                  required
                  validation={{
                    required: {
                      value: true, 
                      message: <I18n text='This field is required'/>},
                  }}
                  onChange={(e) => {
                    validateFloat(e.target.value, 'march')
                  }}
                />
              </div>
              <div className='col-md-3'>
                <TextFieldElement
                  name={'april'}
                  label={<I18n text={'April'} />}
                  
                  fullWidth
                  required
                  validation={{
                    required: {
                      value: true, 
                      message: <I18n text='This field is required'/>},
                  }}
                  onChange={(e) => {
                    validateFloat(e.target.value, 'april')
                  }}
                />
              </div>
            </div>
            <div className='row'>
              <div className='col-md-3'>
                <TextFieldElement
                  name={'may'}
                  label={<I18n text={'May'} />}
                  
                  fullWidth
                  required
                  validation={{
                    required: {
                      value: true, 
                      message: <I18n text='This field is required'/>},
                  }}
                  onChange={(e) => {
                    validateFloat(e.target.value, 'may')
                  }}
                />
              </div>
              <div className='col-md-3'>
                <TextFieldElement
                  name={'june'}
                  label={<I18n text={'June'} />}
                  
                  fullWidth
                  required
                  validation={{
                    required: {
                      value: true, 
                      message: <I18n text='This field is required'/>},
                  }}
                  onChange={(e) => {
                    validateFloat(e.target.value, 'june')
                  }}
                />
              </div>
              <div className='col-md-3'>
                <TextFieldElement
                  name={'july'}
                  label={<I18n text={'July'} />}
                  
                  fullWidth
                  required
                  validation={{
                    required: {
                      value: true, 
                      message: <I18n text='This field is required'/>},
                  }}
                  onChange={(e) => {
                    validateFloat(e.target.value, 'july')
                  }}
                />
              </div>
              <div className='col-md-3'>
                <TextFieldElement
                  name={'august'}
                  label={<I18n text={'August'} />}
                  
                  fullWidth
                  required
                  validation={{
                    required: {
                      value: true, 
                      message: <I18n text='This field is required'/>},
                  }}
                  onChange={(e) => {
                    validateFloat(e.target.value, 'august')
                  }}
                />
              </div>
            </div>
            <div className='row'>
              <div className='col-md-3'>
                <TextFieldElement
                  name={'september'}
                  label={<I18n text={'September'} />}
                  
                  fullWidth
                  required
                  validation={{
                    required: {
                      value: true, 
                      message: <I18n text='This field is required'/>},
                  }}
                  onChange={(e) => {
                    validateFloat(e.target.value, 'september')
                  }}
                />
              </div>
              <div className='col-md-3'>
                <TextFieldElement
                  name={'october'}
                  label={<I18n text={'October'} />}
                  
                  fullWidth
                  required
                  validation={{
                    required: {
                      value: true, 
                      message: <I18n text='This field is required'/>},
                  }}
                  onChange={(e) => {
                    validateFloat(e.target.value, 'october')
                  }}
                />
              </div>
              <div className='col-md-3'>
                <TextFieldElement
                  name={'november'}
                  label={<I18n text={'November'} />}
                  
                  fullWidth
                  required
                  validation={{
                    required: {
                      value: true, 
                      message: <I18n text='This field is required'/>},
                  }}
                  onChange={(e) => {
                    validateFloat(e.target.value, 'november')
                  }}
                />
              </div>
              <div className='col-md-3'>
                <TextFieldElement
                  name={'december'}
                  label={<I18n text={'December'} />}
               
                  fullWidth
                  required
                  validation={{
                    required: {
                      value: true, 
                      message: <I18n text='This field is required'/>},
                  }}
                  onChange={(e) => {
                    validateFloat(e.target.value, 'december')
                  }}
                />
              </div>
            </div>
            <div className='row'>
              <div className='col-md-6'>
                <TextFieldElement
                  name={'level_bill_offset'}
                  label={<I18n text={'Level/Bill offset (%)'} />}
                  fullWidth
                  required
                  validation={{
                    required: {
                      value: true, 
                      message: <I18n text='This field is required'/>},
                  }}
                  onChange={(e) => {
                    validateInt(e.target.value, 'level_bill_offset', 0, 100)
                  }}
                />
              </div>
              <div className='col-md-6'>
                <TextFieldElement
                  name={'level'}
                  label={<I18n text={`Level (${currency})`} />}
                  fullWidth
                  required
                  validation={{
                    required: {
                      value: true, 
                      message: <I18n text='This field is required'/>},
                  }}
                  onChange={(e) => {
                    validateFloat(e.target.value, 'level')
                  }}
                />
              </div>
            </div>
          </>}
          {viewList && <>
            <div className='row'>
              <div className='col-md-12'>
                <strong><I18n text='Electricity production (kWh)' /></strong>
              </div>
            </div>
            <div className={global.block_text}>
              <span><I18n text={'January'} /></span>
              <div>{data?.january || ''} <I18n text='kWh'/></div>
            </div>
            <div className={global.block_text}>
              <span><I18n text={'February'} /></span>
              <div>{data?.february || ''} <I18n text='kWh'/></div>
            </div>
            <div className={global.block_text}>
              <span><I18n text={'March'} /></span>
              <div>{data?.march || ''} <I18n text='kWh'/></div>
            </div>
            <div className={global.block_text}>
              <span><I18n text={'April'} /></span>
              <div>{data?.april || ''} <I18n text='kWh'/></div>
            </div>
            <div className={global.block_text}>
              <span><I18n text={'May'} /></span>
              <div>{data?.may || ''} <I18n text='kWh'/></div>
            </div>
            <div className={global.block_text}>
              <span><I18n text={'June'} /></span>
              <div>{data?.june || ''} <I18n text='kWh'/></div>
            </div>
            <div className={global.block_text}>
              <span><I18n text={'July'} /></span>
              <div>{data?.july || ''} <I18n text='kWh'/></div>
            </div>
            <div className={global.block_text}>
              <span><I18n text={'August'} /></span>
              <div>{data?.august || ''} <I18n text='kWh'/></div>
            </div>
            <div className={global.block_text}>
              <span><I18n text={'September'} /></span>
              <div>{data?.september || ''} <I18n text='kWh'/></div>
            </div>
            <div className={global.block_text}>
              <span><I18n text={'October'} /></span>
              <div>{data?.october || ''} <I18n text='kWh'/></div>
            </div>
            <div className={global.block_text}>
              <span><I18n text={'November'} /></span>
              <div>{data?.november || ''} <I18n text='kWh'/></div>
            </div>
            <div className={global.block_text}>
              <span><I18n text={'December'} /></span>
              <div>{data?.december || ''} <I18n text='kWh'/></div>
            </div>
            <hr />
            <div className={global.block_text}>
              <span><I18n text={'Economy level/Bill offset'} /></span>
              <div>{data?.level_bill_offset || ''}%</div>
            </div>
            <div className={global.block_text}>
              <span><I18n text={'Economy level'} /></span>
              <div>{data?.level || ''} <I18n text={currency}/></div>
            </div>
          </>}
        </div>
      </div>
    </FormContainer>
  )
}

export default EconomyMonthByMonth