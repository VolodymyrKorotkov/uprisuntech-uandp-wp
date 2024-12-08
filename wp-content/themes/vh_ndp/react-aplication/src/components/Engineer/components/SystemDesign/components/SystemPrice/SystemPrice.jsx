import React from 'react'
import I18n from '../../../../../I18n/I18n'
import { Button, IconButton, TextField } from '@mui/material'
import { useState } from 'react'
import global from '../../../../../../App.module.scss'
import { useEffect } from 'react'
import { FormContainer, TextFieldElement, RadioButtonGroup, useForm } from 'react-hook-form-mui';
import classNames from 'classnames'
import styles from './SystemPrice.module.scss'

function SystemPrice({data = {}, onSave, currency, forseListView}) {
  const [viewList, setViewList] = useState(forseListView ? true : Boolean(localStorage.getItem('show_SystemPrice') == 'true'));
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
  
  const onSubmit = (value) => {
    if(viewList){
      setViewList(false);
      localStorage.setItem('show_SystemPrice', false)
    } else {
      setViewList(true);
      localStorage.setItem('show_SystemPrice', true)
      onSave(data)
    }
  };

  let total = 0;

  if(data?.solution_cost && !isNaN(parseFloat(data?.solution_cost))){
    total +=parseFloat(data?.solution_cost);
  }

  if(data?.installation_cost && !isNaN(parseFloat(data?.installation_cost))){
    total +=parseFloat(data?.installation_cost);
  }

  (data?.additions || []).map((_i, index) => {
    if(_i?.addition_cost && !isNaN(parseFloat(_i.addition_cost)) && _i?.quantity && !isNaN(parseFloat(_i.quantity))){
      total += parseFloat(_i.addition_cost) * parseFloat(_i.quantity);
    }
    
  })

  total = Math.round(total*100)/100;

  const validateFloatNotSave = (value) => {
    value = (value || '').replace(',','.')
    const isValidInput = /^\d*\.?\d*$/.test(value);
    if(isValidInput){
      if(parseInt(value) <= 0){
        return '';
      }
      if(value.indexOf('.') > -1){
        const leng = value.split('.').pop().length;
        if(leng > 2){
          return parseFloat(value).toFixed(2)
        } else {
          return value;
        }
      } else {
        return value;
      }
    } else {
      return '';
    } 
  }

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

  return (
    <FormContainer mode="all" formContext={formContext} defaultValues={data} values={data} onSuccess={onSubmit}>
      <div className={classNames(global.card, styles.SystemPrice)}>
        <div className={global.header}>
          <div className={global.row}>
            <div className={global.title}><I18n text={'System price'} /></div>
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
                required
                validation={{
                  required: {
                    value: true, 
                    message: <I18n text='This field is required'/>},
                }}
                name={'solution_cost'}
                label={<I18n text={`Solution cost (${currency})`} />}
                value={data?.solution_cost}
                // type='number'
                fullWidth
                onChange={(e) => {
                  validateFloat(e.target.value, 'solution_cost')
                }}
              />
            </div>
            <div className='col-md-6'>
              <TextFieldElement
                required
                validation={{
                  required: {
                    value: true, 
                    message: <I18n text='This field is required'/>},
                }}
                name={'installation_cost'}
                label={<I18n text={`Installation cost (${currency})`} />}
                // type='number'
                value={data?.installation_cost}
                fullWidth
                onChange={(e) => {
                  // onSave({...data, installation_cost: e.target.value})
                  validateFloat(e.target.value, 'installation_cost')
                  // validateInt(e.target.value, 'bill_offset_percentage', 0, 100)
                  // validateFloat(e.target.value, 'bill_offset_percentage', 0, 100)
                }}
              />
            </div>
          </div>
          {(data?.additions || []).map((_i, index) => <div className='row' key={'additions_' + index}>
            <div className='col-md-4'>
              <TextFieldElement
                required
                validation={{
                  required: {
                    value: true, 
                    message: <I18n text='This field is required'/>},
                }}
                name={`additions[${index}].name_of_addition`}
                label={<I18n text={"Name of addition"} />}
                fullWidth
                value={data.additions[index].name_of_addition}
                onChange={(e) => {
                  const tmp = [...data.additions];
                  tmp[index].name_of_addition = e.target.value;
                  onSave({...data, additions: tmp})
                }}
              />
            </div>
            <div className='col-md-4'>
              <TextFieldElement
                name={`additions[${index}].addition_cost`}
                label={<I18n text={`Addition cost (${currency})`} />}
                // type='number'
                fullWidth
                required
                validation={{
                  required: {
                    value: true, 
                    message: <I18n text='This field is required'/>},
                }}
                value={data.additions[index].addition_cost}
                onChange={(e) => {
                  const value = validateFloatNotSave(e.target.value);
                  const tmp = [...data.additions];
                  tmp[index].addition_cost = value;
                  formContext.setValue(`additions[${index}].addition_cost`, value)
                  onSave({...data, additions: tmp})
                }}
              />
            </div>
            <div className='col-md-4'>
              <div style={{display: 'flex', alignItems: 'center'}}>
                <TextFieldElement
                  name={`additions[${index}].quantity`}
                  label={<I18n text={"Quantity"} />}
                  // type='number'
                  required
                  validation={{
                    required: {
                      value: true, 
                      message: <I18n text='This field is required'/>},
                  }}
                  value={data.additions[index].quantity}
                  fullWidth
                  onChange={(e) => {
                    const value = validateFloatNotSave(e.target.value);
                    const tmp = [...data.additions];
                    tmp[index].quantity = value;
                    onSave({...data, additions: tmp})
                    formContext.setValue(`additions[${index}].quantity`, value)
                    // validateInt(e.target.value, 'bill_offset_percentage', 0, 100)
                  }}
                />
                <IconButton style={{marginLeft: 16}} onClick={() => onSave({...data, additions: data.additions.filter((_f,i) => i != index)})}>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M15 3V4H20V6H19V19C19 20.1 18.1 21 17 21H7C5.9 21 5 20.1 5 19V6H4V4H9V3H15ZM7 19H17V6H7V19ZM9 8H11V17H9V8ZM15 8H13V17H15V8Z" fill="#45464F"/>
                  </svg>
                </IconButton>
              </div>
              
            </div>
          </div>
          )}
          <div className='row'>
            <div className='col-md-12'>
              <div className={styles.actions}>

              
                <Button type='button' onClick={() => {
                  const tmp = data?.additions || [];
                  tmp.push({
                    'name_of_addition': '',
                    'addition_cost': '',
                    'quantity': '',
                  })
                  onSave({...data, additions: tmp})
                }} className={global.btn} color={'primary'} startIcon={<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                    <path d="M15 9.75H9.75V15H8.25V9.75H3V8.25H8.25V3H9.75V8.25H15V9.75Z" fill="#2A59BD"/>
                  </svg>}>
                  <I18n text='Add additions cost' />
                </Button>
              </div>
            </div>
          </div>
          <hr/>
          <div className={global.block_text}>
            <span><I18n text='Total cost' /></span>
            <div>{total} <I18n text={currency}/></div>
          </div>
          </>}
        {viewList && <>
          <div className={global.block_text}>
            <span><I18n text='Solution cost' /></span>
            <div>{data?.solution_cost || ''}<I18n text={currency}/></div>
          </div>
          <div className={global.block_text}>
            <span><I18n text='Installation cost' /></span>
            <div>{data?.installation_cost || ''}<I18n text={currency}/></div>
          </div>
          {(data?.additions || []).map((_i, index) => <div key={'additions_' + index} className={global.block_text}>
            <span>{_i.name_of_addition}</span>
            <div>{_i.addition_cost || ''} <I18n text={currency}/></div>
          </div>
          )}
          <div className={global.block_text}>
            <span><I18n text='Total cost' /></span>
            <div>{total} <I18n text={currency}/></div>
          </div>
        </>}
        </div>
      </div>
    </FormContainer>
  )
}

export default SystemPrice