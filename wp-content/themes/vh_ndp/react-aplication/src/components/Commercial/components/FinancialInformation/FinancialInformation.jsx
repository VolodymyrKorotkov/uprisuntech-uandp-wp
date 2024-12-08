import { Button } from '@mui/material';
import React, { useState } from 'react'
import { FormContainer, TextFieldElement, useForm } from 'react-hook-form-mui';
import global from '../../../../App.module.scss'
import I18n from '../../../I18n/I18n'
import ListFinancialInformation from './ListFinancialInformation';

function FinancialInformation({onSave = () => {}, financialInformation = {}, forseShowList}) {
  const [viewList, setViewList] = useState(forseShowList ? forseShowList : Boolean(localStorage.getItem('show_FinancialInformation') == 'true'))
  const formContext = useForm({
    defaultValues: financialInformation || {},
    values: financialInformation || {},
    mode: 'all'
  });


  const validateInt = (value, name, min=0, max) => {
    const isValidInput = /^\d*$/.test(value);
    if(isValidInput && !isNaN(parseInt(value))){
      if(parseInt(value) <= min){
        formContext.setValue(name, '')
        onSave({...financialInformation, [name]: ''})
        return;
      }
      if(max && parseInt(value) > max){
        formContext.setValue(name, max)
        onSave({...financialInformation, [name]: max})
        return;
      }
      
      formContext.setValue(name, value)
      onSave({...financialInformation, [name]: value})
    
    } else {
      formContext.setValue(name, '')
      onSave({...financialInformation, [name]: ''})
    } 
  }
  const onSubmit = (value) => {
    if(viewList){
      setViewList(false);
      localStorage.setItem('show_FinancialInformation', false)
    } else {
      setViewList(true);
      localStorage.setItem('show_FinancialInformation', true)
      onSave(value)
    }
  };
  return (
    <div>
      <div className={global.header_title}>
        <div className={global.title}><I18n text='Financial information' /></div>
        <div className={global.text}>
          {!forseShowList && <I18n text='* Required sections must be filled in' />}
        </div>
      </div>
      {!forseShowList && <div className={global.text_block}>
        <I18n text='Please provide information about your financing preferences:'/><br/>
        <I18n text='The percentage of your bill you would like to save with renewable energy.'/><br/>
        <I18n text='Estimated budget for purchasing renewable energy system'/><br/>
        <I18n text='Repayment period for allocated funding'/><br/>
      </div>}
      <FormContainer mode="all" formContext={formContext} defaultValues={financialInformation} values={financialInformation} onSuccess={onSubmit}>
        <div className={global.card}>
          <div className={global.header}>
            <div className={global.row}>
              <div className={global.title}><I18n text='Financial information' /></div>
              {!forseShowList && <>{!viewList ? <Button className={global.btn} type={'submit'} color={'primary'} startIcon={<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
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
                  <TextFieldElement
                    name={'bill_offset_percentage'}
                    label={<I18n text={"Bill offset percentage"} />}
                    required
                    validation={{
                      required: {
                        value: true, 
                        message: <I18n text='This field is required'/>},
                    }}
                    fullWidth
                    onChange={(e) => {
                      validateInt(e.target.value, 'bill_offset_percentage', 0, 100)
                    }}
                  />
                </div>
              </div>
              <div className='row'>
                <div className='col-md-12'>
                  <TextFieldElement
                    name={'preferred_system_price'}
                    label={<I18n text={"Preferred system price (USD)"} />}

                    required
                    validation={{
                      required: {
                        value: true, 
                        message: <I18n text='This field is required'/>},
                    }}
                    fullWidth
                    onChange={(e) => {
                      validateInt(e.target.value, 'preferred_system_price')
                    }}
                  />
                </div>
              </div>
              <div className='row'>
                <div className='col-md-12'>
                  <TextFieldElement
                    name={'preferred_term'}
                    label={<I18n text={"Preferred term (years)"} />}
                    required
                    validation={{
                      required: {
                        value: true, 
                        message: <I18n text='This field is required'/>},
                    }}
                    fullWidth
                    onChange={(e) => {
                      validateInt(e.target.value, 'preferred_term', 0, 50)
                    }}
                  />
                </div>
              </div>
             
            </>}
            {viewList && <ListFinancialInformation financialInformation={financialInformation} /> }
          </div>
        </div>
      </FormContainer>
    </div>
  )
}

export default FinancialInformation