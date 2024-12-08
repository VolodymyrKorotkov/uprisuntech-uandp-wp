import { useEffect, useState } from 'react'
import { FormContainer, SelectElement, useForm, TextFieldElement } from 'react-hook-form-mui';
import { yupResolver } from "@hookform/resolvers/yup";
import { Button } from '@mui/material';
import global from '../../../../../App.module.scss'
import { t, default as I18n } from '../../../../I18n/I18n';
import { regions, field_of_actifity, organization_form } from '../../../../I18n/translate';
import OrganizationSummary from "../summary/OrganizationSummary";
import { projectDescriptionSchemas } from "../validation.schema";
import { NumberField } from "../../../../NumberFields";

function Organization({ forseShowList, data, onSave }) {
  const [viewList, setViewList] = useState(forseShowList ? forseShowList : Boolean(localStorage.getItem('show_ProjectDescription-organization') == 'true'))
  const formContext = useForm({
    defaultValues: data,
    resolver: yupResolver(projectDescriptionSchemas.organization),
    mode: 'all'
  });

  useEffect(() => {
    if (forseShowList) {
      setViewList(true)
    }
  }, [forseShowList])


  const onSubmit = (value) => {
    setViewList(!viewList);
    localStorage.setItem('show_ProjectDescription-organization', !viewList)

    if (!viewList) {
      onSave(value)
    }
  };

  return (
      <FormContainer mode="all" formContext={formContext} defaultValues={data} values={data} onSuccess={onSubmit}>
        <div className={global.card}>
          <div className={global.header}>
            <div className={global.row}>
              <div className={global.title}><I18n text='Organization'/></div>
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
            {!viewList && <>
              <div className='row'>
                <div className='col-md-12'>
                  <SelectElement
                      name="office_availability"
                      label={<I18n text='Availability of a decarbonization office in the region'/>}
                      required
                      options={[
                        {id: 'Yes', label: t('Yes')},
                        {id: 'No', label: t('Not')},
                      ]}
                      fullWidth
                      onChange={(v) => {
                        if (v === 'No') {
                          onSave({...data, 'region': "", 'office_availability': v})
                        } else {
                          onSave({...data, 'office_availability': v})
                        }
                      }}
                  />
                </div>
              </div>
              {formContext.watch('office_availability') === 'Yes' && (
                  <div className='row'>
                    <div className='col-md-12'>
                      <SelectElement
                          name='region'
                          label={<I18n text='Region'/>}
                          options={Object.keys(regions).map(key => ({id: key, label: <I18n text={key}/>}))}
                          fullWidth
                          onChange={(v) => {
                            onSave({...data, 'region': v})
                          }}
                      />
                    </div>
                  </div>
              )}
              <div className='row'>
                <div className='col-md-12'>
                  <TextFieldElement
                      name='issuing_name'
                      label={<I18n text='Name of the body/organization submitting the project'/>}
                      fullWidth
                      required
                      onChange={(e) => {
                        onSave({...data, [e.target.name]: e.target.value})
                      }}
                  />
                </div>
              </div>
              <div className='row'>
                <div className='col-md-12'>
                  <TextFieldElement
                      name='organization_name'
                      label={<I18n text='Name of the organization (legal entity), project owner'/>}
                      fullWidth
                      required
                      onChange={(e) => {
                        onSave({...data, [e.target.name]: e.target.value})
                      }}
                  />
                </div>
              </div>
              <div className='row'>
                <div className='col-md-12'>
                  <NumberField
                    name='edrpou_code'
                    label={<I18n text={formContext.watch('organization_form') == 'Other' ? 'Registration number' : formContext.watch('organization_form') == 'Individual entrepreneur' ? 'Registration number (ІПН)' : 'Registration number (EDRPOU)'} />}
                    fullWidth
                    required
                    onChange={(e) => {
                      onSave({...data, [e.target.name]: e.target.value})
                    }}
                    options={{
                      allowLeadingZeros: true,
                      maxLength: formContext.watch('organization_form') === 'Individual entrepreneur' ? 10 : 8
                    }}
                  />
                </div>
              </div>
              <div className='row'>
                <div className='col-md-12'>
                  <SelectElement
                      name="organization_form"
                      label={<I18n text='Form of organization, project owner'/>}
                      required
                      options={Object.keys(organization_form).map(key => ({id: key, label: <I18n text={key} />}))}
                      fullWidth
                      onChange={(v) => {
                        if(v !== 'Other') {
                          onSave({...data, 'organization_form': v, comment: ''})
                        } else {
                          onSave({...data, 'organization_form': v })
                        }
                      }}
                  />
                </div>
              </div>
              {formContext.watch('organization_form') === 'Other' && (
                <div className='row'>
                  <div className='col-md-12'>
                    <TextFieldElement
                      name='comment'
                      label={<I18n text='Enter the form of ownership of your company'/>}
                      fullWidth
                      required
                      onChange={(e) => {
                        onSave({...data, [e.target.name]: e.target.value})
                      }}
                    />
                  </div>
                </div>
              )}
              <div className='row'>
                <div className='col-md-12'>
                  <SelectElement
                      name="industry"
                      label={<I18n text='Form of ownership'/>}
                      required
                      options={Object.keys(field_of_actifity).map(key => ({id: key, label: <I18n text={key}/>}))}
                      fullWidth
                      onChange={(v) => {
                        onSave({...data, 'industry': v})
                      }}
                  />
                </div>
              </div>
            </>}
            {viewList && <OrganizationSummary data={data}/>}
          </div>
        </div>
      </FormContainer>
  )
}

export default Organization
