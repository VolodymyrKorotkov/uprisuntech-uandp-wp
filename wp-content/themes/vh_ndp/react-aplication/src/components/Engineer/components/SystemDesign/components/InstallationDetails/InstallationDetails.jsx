import React, { useEffect } from 'react'
import I18n from '../../../../../I18n/I18n'
import { Button, FormControlLabel, Radio, RadioGroup } from '@mui/material'
import { useState } from 'react';
import { FormContainer, TextFieldElement, RadioButtonGroup, useForm } from 'react-hook-form-mui';
import global from '../../../../../../App.module.scss'

function InstallationDetails({data={}, onSave, forseListView}) {
  const [viewList, setViewList] = useState(forseListView ? true : Boolean(localStorage.getItem('show_InstallationDetails') == 'true'))
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
      localStorage.setItem('show_InstallationDetails', false)
    } else {
      setViewList(true);
      localStorage.setItem('show_InstallationDetails', true)
      onSave(value)
    }
  };

  return (
    <FormContainer mode="all" formContext={formContext} defaultValues={data} values={data} onSuccess={onSubmit}>
      <div className={global.card}>
        <div className={global.header}>
          <div className={global.row}>
            <div className={global.title}><I18n text='Installation details' /></div>
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
                <RadioButtonGroup
                  required
                  validation={{
                    required: {
                      value: true, 
                      message: <I18n text='This field is required'/>},
                  }}
                  label={<strong style={{color: 'black'}}><I18n text='Place' /></strong>}
                  name="place"
                  row
                  options={[
                    {label: <I18n text={"Roof"} />, id: 'Roof'},
                    {label: <I18n text={"Ground"} />, id: 'Ground'},
                  ]}
                  onChange={(value) => {
                    onSave({...data, place: value})
                  }}
                />
              </div>
            </div>
            <div className='row'>
              <div className='col-md-12'>
                <RadioButtonGroup
                  required
                  validation={{
                    required: {
                      value: true, 
                      message: <I18n text='This field is required'/>},
                  }}
                  label={<strong style={{color: 'black'}}><I18n text='Direction' /></strong>}
                  name="direction"
                  row
                  options={[
                    {label: <I18n text={"Vertical"} />, id: 'Vertical'},
                    {label: <I18n text={"Horizontal"} />, id: 'Horizontal'},
                  ]}
                  onChange={(value) => {
                    onSave({...data, direction: value})
                  }}
                />
              </div>
            </div>          
            <div className='row'>
              <div className='col-md-12'>
                <RadioButtonGroup 
                  required
                  validation={{
                    required: {
                      value: true, 
                      message: <I18n text='This field is required'/>},
                  }}
                  label={<strong style={{color: 'black'}}><I18n text='Parameters of Connection' /></strong>}
                  name="parameters_of_connection"
                  row
                  options={[
                    {label: <I18n text={"Parallel"} />, id: 'Parallel'},
                    {label: <I18n text={"Sequential"} />, id: 'Sequential'},
                  ]}
                  onChange={(value) => {
                    onSave({...data, parameters_of_connection : value})
                  }}
                />
              </div>
            </div>
            <div className='row'>
              <div className='col-md-12'>
                <TextFieldElement
                  required
                  validation={{
                    required: {
                      value: true, 
                      message: <I18n text='This field is required'/>
                    },
                    pattern: {
                      value: /^(https?|ftp):\/\/[^\s/$.?#].[^\s]*$/,
                      message: <I18n text='Invalid URL format'/>,
                    },
                  }}
                  name={'link'}
                  label={<I18n text={"Link to the presentation"} />}
                  fullWidth
                  onChange={(e) => {
                    onSave({...data, link: e.target.value})
                  }}
                />
              </div>
            </div>
          </>}
          {viewList && <>
            <div className={global.block_text}>
              <span><I18n text='Place' /></span>
              <div><I18n text={data?.place || ''} /></div>
            </div>
            <div className={global.block_text}>
              <span><I18n text='Direction' /></span>
              <div><I18n text={data?.direction || ''} /></div>
            </div>
            <div className={global.block_text}>
              <span><I18n text='Parameters of Connection' /></span>
              <div><I18n text={data?.parameters_of_connection || ''} /></div>
            </div>
            {Boolean(data?.link) && <div className={global.block_text}>
              <span><I18n text='Link to the presentation' /></span>
              <div><a href={data?.link} target='_blank'>{data?.link || ''}</a></div>
            </div>}
          </> }
        </div>
      </div>
    </FormContainer>
    
  )
}

export default InstallationDetails