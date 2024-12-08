import { useEffect, useState } from 'react'
import { FormContainer, TextFieldElement, SelectElement, TextareaAutosizeElement, useForm } from 'react-hook-form-mui'
import { Button } from '@mui/material';
import {yupResolver} from "@hookform/resolvers/yup";
import global from '../../../../../../App.module.scss'
import I18n from '../../../../../I18n/I18n';
import { field_of_activities_obj, organization_form, type } from '../../../../../I18n/translate';
import PhoneField from '../../../../../PhoneField/PhoneField';
import {organizationsSchemas} from "../../validation.schema";
import {NumberField} from "../../../../../NumberFields";


function About({data = {}, onSave, forseShowList}) {
  const [viewList, setViewList] = useState(forseShowList ? forseShowList : Boolean(localStorage.getItem('show_about') == 'true'))

  const formContext = useForm({
    defaultValues: data,
    resolver: yupResolver(organizationsSchemas.about),
    mode: 'all',
  });


  useEffect(() => {
    if(forseShowList){
      setViewList(true)
    }
  }, [forseShowList])

  const formValues = formContext.getValues();

  const onSubmit = (value) => {
    setViewList(!viewList);
    localStorage.setItem('show_about', !viewList)

    if (!viewList) {
      onSave(value)
    }
  };

  const onError = (errors) => {
    if(errors && viewList) {
      setViewList(false);
      localStorage.setItem('show_about', false)
    }
  }

  return (
    <>
    <FormContainer mode="all" formContext={formContext} defaultValues={data} values={data} onError={onError} onSuccess={onSubmit}>
        <div className={global.card}>
          <div className={global.header}>
            <div className={global.row}>
              <div className={global.title}><I18n text={'About'} /></div>
              {!forseShowList && <>
                {!viewList ? <Button className={global.btn} type={'submit'} color={'primary'} startIcon={<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                  <path d="M6.75012 12.1275L3.62262 9L2.55762 10.0575L6.75012 14.25L15.7501 5.25L14.6926 4.1925L6.75012 12.1275Z" fill="#2A59BD"/>
                </svg>}>
                  <I18n text={'Collapse'} />
                </Button> : <Button className={global.btn} type='submit' color={'primary'} startIcon={<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                  <path fillRule="evenodd" clipRule="evenodd" d="M14.295 2.69253L15.3075 3.70503C15.9 4.29003 15.9 5.24253 15.3075 5.82753L5.385 15.75H2.25V12.615L10.05 4.80753L12.1725 2.69253C12.7575 2.10753 13.71 2.10753 14.295 2.69253ZM3.75 14.25L4.8075 14.295L12.1725 6.92253L11.115 5.86503L3.75 13.23V14.25Z" fill="#2A59BD"/>
                </svg>}>
                  <I18n text={'Expand'} />
                </Button>}
              </>}
            </div>
          </div>
          <div className={global.body}>
            {!viewList && <>
              <div className='row'>
                <div className='col-md-12'>
                  <TextFieldElement
                    name={'company_name'}
                    label={<I18n text={'Company name'} />}
                    required
                    fullWidth
                    onChange={(e) => {
                      onSave({...data, 'company_name': e.target.value})
                    }}
                  />
                </div>
              </div>

              <div className='row'>
                <div className='col-md-12'>
                  <SelectElement
                    name={'organizational_form'}
                    label={<I18n text={'Organizational form'} />}
                    required
                    options={Object.keys(organization_form).map(key => ({id: key, label: <I18n text={key} />}))}
                    fullWidth
                    onChange={(v) => {
                      onSave({...data, 'organizational_form': v})
                    }}
                  />
                </div>
              </div>
              <div className='row'>
                <div className='col-md-12'>
                  <NumberField
                    name={'registration_number'}
                    label={<I18n text={formValues.organizational_form == 'Other' ? 'Registration number' : formValues.organizational_form == 'Individual entrepreneur' ? 'Registration number (ІПН)' : 'Registration number (EDRPOU)'} />}
                    fullWidth
                    required
                    onChange={(e) => {
                      onSave({...data, [e.target.name]: e.target.value})
                    }}
                    options={{
                      allowLeadingZeros: true,
                      maxLength: formValues.organizational_form === 'Individual entrepreneur' ? 10 : 8
                    }}
                  />

                </div>
              </div>
              <div className='row'>
                <div className='col-md-12'>
                  <SelectElement
                    name={'type'}
                    label={<I18n text={'Type'} />}
                    required
                    options={Object.keys(type).map(key => ({id: key, label: <I18n text={key} />}))}
                    fullWidth
                    onChange={(v) => {
                      onSave({...data, 'type': v})
                    }}
                  />
                </div>
              </div>
              <div className='row'>
                <div className='col-md-12'>
                  <SelectElement
                    name={'field_of_activities'}
                    label={<I18n text={'Field of activities'} />}
                    required
                    options={[...Object.keys(field_of_activities_obj).map(key => ({id: key, label: <I18n text={key} />}))]}
                    fullWidth
                    onChange={(v) => {
                      formContext.setValue('type_of_organizations_activities', '')
                      onSave({...data, 'field_of_activities': v, type_of_organizations_activities: ''})
                    }}
                  />
                </div>
              </div>
              <div className='row'>
                <div className='col-md-12'>
                  <SelectElement
                    name={'type_of_organizations_activities'}
                    label={<I18n text={'Type of organization\'s activities'} />}
                    required
                    disabled={!Boolean(formValues.field_of_activities)}
                    options={ formValues.field_of_activities && field_of_activities_obj[formValues.field_of_activities] ? field_of_activities_obj[formValues.field_of_activities].map(key => ({id: key, label: <I18n text={key} />})) : []}
                    fullWidth
                    onChange={(v) => {
                      onSave({...data, 'type_of_organizations_activities': v})
                    }}
                  />
                </div>
              </div>
              <div className='row'>
                <div className='col-md-12'>
                  <TextareaAutosizeElement
                    name={'description_of_organizations_activities'}
                    label={<I18n text={'Description of organization\'s activities'} />}
                    fullWidth
                    helperText={<I18n text='Max. 500 characters'/>}
                    onChange={(v) => {
                      const value = v.target.value;
                      const tmp = value.slice(0, 500);
                      formContext.setValue('description_of_organizations_activities', tmp)
                      onSave({...data, 'description_of_organizations_activities': tmp})
                    }}
                  />
                </div>
              </div>
              <div className='row m_t_col_16'>
                <div className='col-md-4'>
                  <PhoneField
                    name="phone"
                    label={<I18n text={'Phone number'} />}
                    rules={{required: true}}
                    onChange={(e) => {
                      onSave({...data, 'phone': e.target.value})
                    }}
                  />
                </div>
                <div className='col-md-4'>
                  <TextFieldElement
                    name={'email'}
                    label={<I18n text='Email' />}
                    required
                    type='email'
                    placeholder='mail@gmail.com'
                    fullWidth
                    onChange={(v) => {
                      onSave({...data, 'email': v.target.value})
                    }}
                  />
                </div>
                <div className='col-md-4'>
                  <TextFieldElement
                    name={'position'}
                    label={<I18n text='Position' />}
                    required
                    fullWidth
                    onChange={(v) => {
                      onSave({...data, 'position': v.target.value})
                    }}
                  />
                </div>
              </div>
            </>}
            {viewList && <>
              <div className={global.block_text}>
                <span><I18n text='Company name' /></span>
                <div>{data?.company_name || ''}</div>
              </div>
              <div className={global.block_text}>
                <span><I18n text={data.organizational_form == 'Other' ? 'Registration number' : data.organizational_form == 'Individual entrepreneur' ? 'Registration number (ІПН)' : 'Registration number (EDRPOU)'} /></span>
                <div>{data?.registration_number || <span><I18n text='not filled in'/></span>}</div>
              </div>
              <div className={global.block_text}>
                <span><I18n text='Organizational form' /></span>
                <div><I18n text={data?.organizational_form || ''} /></div>
              </div>
              <div className={global.block_text}>
                <span><I18n text='Type' /></span>
                <div><I18n text={data?.type || ''} /></div>
              </div>
              <hr/>
              <div className={global.block_text}>
                <span><I18n text='Field of activities' /></span>
                <div><I18n text={data?.field_of_activities || ''} /></div>
              </div>
              <div className={global.block_text}>
                <span><I18n text='Type of activities' /></span>
                <div><I18n text={data?.type_of_organizations_activities || ''}/></div>
              </div>
              <div className={global.block_text}>
                <div>{data?.description_of_organizations_activities || ''}</div>
              </div>
              <hr/>
              <div className={global.block_text}>
                <span><I18n text='Phone number' /></span>
                <div>{data?.phone || ''}</div>
              </div>
              <div className={global.block_text}>
                <span><I18n text='Email' /></span>
                <div>{data?.email || ''}</div>
              </div>
              <div className={global.block_text}>
                <span><I18n text='Position' /></span>
                <div>{data?.position || ''}</div>
              </div>
            </>}
          </div>
        </div>
      </FormContainer>
    </>
  )
}

export default About
