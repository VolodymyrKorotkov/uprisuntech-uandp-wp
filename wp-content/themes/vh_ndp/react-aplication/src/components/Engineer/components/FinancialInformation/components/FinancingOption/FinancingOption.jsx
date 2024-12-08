import React, { useEffect } from 'react'
import { useState } from 'react';
import I18n from '../../../../../I18n/I18n'
import { Button, FormControlLabel, Radio, RadioGroup } from '@mui/material'
import { FormContainer, TextFieldElement, RadioButtonGroup, useForm } from 'react-hook-form-mui';
import global from '../../../../../../App.module.scss'

function FinancingOption({data = {}, onSave, currency, forseListView}) {
  const [viewList, setViewList] = useState(forseListView ? true : Boolean(localStorage.getItem('show_FinancingOption') == 'true'))
  const formContext = useForm({
    defaultValues: data || {},
    values: data || {},
    mode: 'all'
  });

  useEffect(() => {
    if(forseListView){
      setViewList(true)
    }
  }, [])

  const validateFloat = (value, name) => {
    if(!isNaN(parseFloat(value))){
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

  const onSubmit = (value) => {
    if(viewList){
      setViewList(false);
      localStorage.setItem('show_FinancingOption', false)
    } else {
      setViewList(true);
      localStorage.setItem('show_FinancingOption', true)
      onSave(value)
    }
  };

  return (
    <FormContainer mode="all" formContext={formContext} defaultValues={data} values={data} onSuccess={onSubmit}>
      <div className={global.card}>
        <div className={global.header}>
          <div className={global.row}>
            <div className={global.title}><I18n text='Financing option' /></div>
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
              <div className='col-md-6'>
                <TextFieldElement
                  name={'term_months'}
                  label={<I18n text={'Term (months)'} />}
                  type='number'
                  fullWidth
                  onChange={(e) => {
                    validateFloat(e.target.value, 'term_months')
                  }}
                />
              </div>
              <div className='col-md-6'>
                    <TextFieldElement
                      name={'down_payment'}
                      label={<I18n text={`Down Payment (${currency})`} />}
                      type='number'
                      fullWidth
                      onChange={(e) => {
                        validateFloat(e.target.value, 'down_payment')
                      }}
                    />
                  </div>
            </div>
            <div className='row'>
              <div className='col-md-6'>
                <TextFieldElement
                  name={'interest_rate'}
                  label={<I18n text={'Interest rate (%)'} />}
                  type='number'
                  fullWidth
                  onChange={(e) => {
                    validateFloat(e.target.value, 'interest_rate')
                  }}
                />
              </div>
              <div className='col-md-6'>
                <TextFieldElement
                  name={'monthly_payment'}
                  label={<I18n text={`Monthly payment (${currency})`} />}
                  type='number'
                  fullWidth
                  onChange={(e) => {
                    validateFloat(e.target.value, 'monthly_payment')
                  }}
                />
              </div>
            </div>
          </>}
          {viewList && <>
            <div className={global.block_text}>
              <span><I18n text={'Term'} /></span>
              <div>{data?.term_months || '-'} {data?.monthly_payment ? <I18n text='month'/> : ''}</div>
            </div>
            <div className={global.block_text}>
              <span><I18n text={'Down Payment'} /></span>
              <div>{data?.down_payment || '-'} {data?.down_payment ? <I18n text={currency}/> : ""}</div>
            </div>
            <div className={global.block_text}>
              <span><I18n text={'Interest rate'} /></span>
              <div>{data?.interest_rate || '-'}{data?.interest_rate ? '%' : ''}</div>
            </div>
            <div className={global.block_text}>
              <span><I18n text={'Monthly payment'} /></span>
              <div>{data?.monthly_payment || '-'} {data?.monthly_payment ? <I18n text={currency}/> : ''}</div>
            </div>
          </>}
        </div>
      </div>
    </FormContainer>
  )
}

export default FinancingOption