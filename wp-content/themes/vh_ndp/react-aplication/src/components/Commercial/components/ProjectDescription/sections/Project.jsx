import {useEffect, useState} from 'react'
import {FormContainer, useForm, TextFieldElement, SelectElement} from 'react-hook-form-mui';
import {yupResolver} from "@hookform/resolvers/yup";
import {Button} from '@mui/material';
import global from '../../../../../App.module.scss'
import {t, default as I18n} from '../../../../I18n/I18n';
import {equipment_manufacturers_types, above_min_requirements} from '../../../../I18n/translate';
import ProjectSummary from "../summary/ProjectSummary";
import ProjectFiles from "../components/ProjectFiles";
import {NumberField} from "../../../../NumberFields";
import {projectDescriptionSchemas} from "../validation.schema";

function Project({forseShowList, data, onSave}) {
  const [viewList, setViewList] = useState(forseShowList ? forseShowList : Boolean(localStorage.getItem('show_ProjectDescription-project') == 'true'))
  const formContext = useForm({
    defaultValues: data,
    resolver: yupResolver(projectDescriptionSchemas.project),
    mode: 'all'
  });

  useEffect(() => {
    if (forseShowList) {
      setViewList(true)
    }
  }, [forseShowList])


  const onSubmit = (value) => {
    setViewList(!viewList);
    localStorage.setItem('show_ProjectDescription-project', !viewList)

    if (!viewList) {
      onSave(value)
    }
  };

  return (
    <FormContainer mode="all" formContext={formContext} defaultValues={data} values={data} onSuccess={onSubmit}>
      <div className={global.card}>
        <div className={global.header}>
          <div className={global.row}>
            <div className={global.title}><I18n text='Project'/></div>
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
                <TextFieldElement
                  name='project_name'
                  label={<I18n text='Project name'/>}
                  fullWidth
                  required
                  helperText={<I18n
                    text='for example:  "Project for the installation of a solar power plant for Vodokanal"'/>}
                  onChange={(e) => {
                    onSave({...data, [e.target.name]: e.target.value})
                  }}
                />
              </div>
            </div>
            <div className="row">
              <div className="col-md-12">
                <SelectElement
                  name="efficiency_project"
                  label={<I18n text='Energy efficiency project (including cogeneration)'/>}
                  required
                  options={[
                    {id: 'Yes', label: <I18n text='Yes'/>},
                    {id: 'No', label: <I18n text='No'/>},
                  ]}
                  fullWidth
                  onChange={(v) => {
                    if (v === 'No') {
                      formContext.setValue('energy_reduction_percent', "")
                      formContext.setValue('pollutant_reduction_percent', "")
                      onSave({
                        ...data,
                        'energy_reduction_percent': "",
                        'pollutant_reduction_percent': "",
                        'efficiency_project': v
                      })
                    } else {
                      onSave({...data, 'efficiency_project': v})
                    }
                  }}
                />
              </div>
            </div>
            {formContext.watch('efficiency_project') === 'Yes' && (
              <>
                <div className="row">
                  <div className="col-md-12">
                    <NumberField
                      name='energy_reduction_percent'
                      helperText={<I18n
                        text='Reduction of the energy intensity of production of a unit of relevant products (services) of the established quality in physical terms compared to the corresponding indicators in force in the previous year (before reconstruction/modernization, and for new production - compared to the indicators of similar production) by 15% or more'/>}
                      label={t('Reduction of the energy intensity of production of a unit of products/services')}
                      fullWidth
                      required
                      InputProps={{endAdornment: '%'}}
                      onChange={(e) => {
                        onSave({...data, [e.target.name]: e.target.value})
                      }}
                      options={{max: 99, min: 15}}
                    />
                  </div>
                </div>
                <div className="row">
                  <div className="col-md-12">
                    <NumberField
                      name='pollutant_reduction_percent'
                      label={<I18n text='Reduction of pollutant emissions by 20% or more'/>}
                      fullWidth
                      required
                      InputProps={{endAdornment: '%'}}
                      onChange={(e) => {
                        onSave({...data, [e.target.name]: e.target.value})
                      }}
                      options={{max: 99, min: 20}}
                    />
                  </div>
                </div>
              </>
            )}
            <div className="row">
              <div className="col-md-12">
                <SelectElement
                  name="alternative_fuels_switching"
                  label={<I18n
                    text='Project on switching to alternative fuels and alternative (renewable) energy sources'/>}
                  required
                  options={[
                    {id: 'Yes', label: <I18n text='Yes'/>},
                    {id: 'No', label: <I18n text='No'/>},
                  ]}
                  fullWidth
                  onChange={(v) => {
                    if (v === 'No') {
                      formContext.setValue('fossil_fuels_substitution_percent', "")
                      formContext.setValue('environment_pollutant_reduction_percent', "")
                      onSave({
                        ...data,
                        'fossil_fuels_substitution_percent': "",
                        'environment_pollutant_reduction_percent': "",
                        'alternative_fuels_switching': v
                      })
                    } else {
                      onSave({...data, 'alternative_fuels_switching': v})
                    }
                  }}
                />
              </div>
            </div>
            {formContext.watch('alternative_fuels_switching') === 'Yes' && (
              <>
                <div className="row">
                  <div className="col-md-12">
                    <NumberField
                      name='fossil_fuels_substitution_percent'
                      helperText={<I18n
                        text='Substitution of fossil fuels for national purposes, except for peat and gas (methane) from coal deposits, with alternative fuels and alternative (renewable) energy sources in terms of electricity generation per 1 MW of electricity by 50% or more'/>}
                      label={t('Substitution of combustible minerals')}
                      fullWidth
                      required
                      InputProps={{endAdornment: '%'}}
                      onChange={(e) => {
                        onSave({...data, [e.target.name]: e.target.value})
                      }}
                      options={{max: 99, min: 50}}
                    />
                  </div>
                </div>
                <div className="row">
                  <div className="col-md-12">
                    <NumberField
                      name='environment_pollutant_reduction_percent'
                      label={<I18n text='Reduction of pollutant emissions into the environment by 20% or more'/>}
                      fullWidth
                      required
                      InputProps={{endAdornment: '%'}}
                      onChange={(e) => {
                        onSave({...data, [e.target.name]: e.target.value})
                      }}
                      options={{max: 99, min: 20}}
                    />
                  </div>
                </div>
              </>
            )}
            <div className="row">
              <div className="col-md-12">
                <SelectElement
                  name="thermal_modernization"
                  label={<I18n text='Project on thermal modernization and energy efficiency of buildings'/>}
                  required
                  options={[
                    {id: 'Yes', label: <I18n text='Yes'/>},
                    {id: 'No', label: <I18n text='No'/>},
                  ]}
                  fullWidth
                  onChange={(v) => {
                    if (v === 'No') {
                      formContext.setValue('above_min_requirements', "")
                      onSave({...data, 'above_min_requirements': "", 'thermal_modernization': v})
                    } else {
                      onSave({...data, 'thermal_modernization': v})
                    }
                  }}
                />
              </div>
            </div>
            {formContext.watch('thermal_modernization') === 'Yes' && (
              <div className="row">
                <div className="col-md-12">
                  <SelectElement
                    name="above_min_requirements"
                    label={t('Achievement of energy efficiency requirements for buildings (class)')}
                    helperText={<I18n
                      text='For thermal modernization and energy efficiency projects in buildings'/>}
                    required
                    options={Object.keys(above_min_requirements).map(key => ({
                      id: key,
                      label: <I18n text={key}/>
                    }))}
                    fullWidth
                    onChange={(v) => {
                      onSave({...data, 'above_min_requirements': v})
                    }}
                  />
                </div>
              </div>
            )}
            <div className="row">
              <div className="col-md-12">
                <SelectElement
                  name="other_direction"
                  label={<I18n text='Does your project represent an area not mentioned in the previous questions?'/>}
                  required
                  options={[
                    {id: 'Yes', label: <I18n text='Yes'/>},
                    {id: 'No', label: <I18n text='No'/>},
                  ]}
                  fullWidth
                  onChange={(v) => {
                    if (v === 'No') {
                      formContext.setValue('other_direction_indicators', "")
                      onSave({...data, 'other_direction_indicators': "", 'other_direction': v})
                    } else {
                      onSave({...data, 'other_direction': v})
                    }
                  }}
                />
              </div>
            </div>
            {formContext.watch('other_direction') === 'Yes' && (
              <div className='row'>
                <div className='col-md-12'>
                  <TextFieldElement
                    name='other_direction_indicators'
                    multiline
                    label={t('Project direction')}
                    minRows={3}
                    required
                    helperText={<I18n
                      text='If you have a different project area, describe the energy resource reduction indicators that will be achieved through its implementation'/>}
                    fullWidth
                    onChange={(e) => {
                      onSave({...data, [e.target.name]: e.target.value})
                    }}
                  />
                </div>
              </div>
            )}
            <div className='row'>
              <div className='col-md-12'>
                <TextFieldElement
                  name='project_description'
                  multiline
                  minRows={3}
                  required
                  label={<I18n text='Project description'/>}
                  helperText={<I18n
                    text='General information about the project. Definition of the problem being solved, as well as ways and means of its implementation. List of proposed measures for energy saving and decarbonization. (from 1 to 200 words)'/>}
                  fullWidth
                  onChange={(e) => {
                    onSave({...data, [e.target.name]: e.target.value})
                  }}
                />
              </div>
            </div>
            <div className='row'>
              <div className='col-md-12'>
                <TextFieldElement
                  name='project_problems'
                  multiline
                  minRows={3}
                  label={<I18n text='What social problems will be solved with the help of this project?'/>}
                  fullWidth
                  onChange={(e) => {
                    onSave({...data, [e.target.name]: e.target.value})
                  }}
                />
              </div>
            </div>
            <div className='row'>
              <div className='col-md-12'>
                <TextFieldElement
                  name='project_analysis'
                  multiline
                  minRows={3}
                  label={<I18n text='Analysis of environmental aspects of the project, if applicable'/>}
                  fullWidth
                  onChange={(e) => {
                    onSave({...data, [e.target.name]: e.target.value})
                  }}
                />
              </div>
            </div>
            <div className="row">
              <div className="col-md-12">
                <SelectElement
                  name="audit_availability"
                  label={<I18n text='The availability of an energy audit for this facility in the last 5 years'/>}
                  required
                  options={[
                    {id: 'Yes', label: t('Yes')},
                    {id: 'No', label: t('Not')},
                  ]}
                  fullWidth
                  onChange={(v) => {
                    onSave({...data, 'audit_availability': v})
                  }}
                />
                {formContext.watch('audit_availability') === 'Yes' && (
                  <ProjectFiles
                    data={data}
                    onSave={onSave}
                    formContext={formContext}
                    name="audit_availability_file"
                  />
                )}
              </div>
            </div>

            <div className="row">
              <div className="col-md-12">
                <SelectElement
                  name="manager_availability"
                  label={<I18n text='Availability of an officially assigned energy manager for the facility:'/>}
                  required
                  options={[
                    {id: 'Yes', label: t('Yes')},
                    {id: 'No', label: t('Not')},
                  ]}
                  fullWidth

                  onChange={(v) => {
                    if (v === 'No') {
                      formContext.setValue('manager_availability_file', "")
                      onSave({...data, 'manager_availability_file': "", 'manager_availability': v})
                    } else {
                      onSave({...data, 'manager_availability': v})
                    }
                  }}
                />
                {formContext.watch('manager_availability') === 'Yes' && (
                    <ProjectFiles
                        data={data}
                        onSave={onSave}
                        formContext={formContext}
                        name="manager_availability_file"
                    />
                )}
              </div>
            </div>

            <div className="row">
              <div className="col-md-12">
                  <SelectElement
                    name="iso_system"
                    label={<I18n text='Implemented energy management system according to ISO 50001'/>}
                    required
                    options={[
                      {id: 'Yes', label: t('Yes')},
                      {id: 'No', label: t('Not')},
                    ]}
                    fullWidth
                    onChange={(v) => {
                      if (v === 'No') {
                        formContext.setValue('iso_system_file', "")
                        onSave({...data, 'iso_system_file': "", 'iso_system': v})
                      } else {
                        onSave({...data, 'iso_system': v})
                      }
                    }}
                  />
                {formContext.watch('iso_system') === 'Yes' && (
                    <ProjectFiles
                        data={data}
                        onSave={onSave}
                        formContext={formContext}
                        name="iso_system_file"
                        helperText={<I18n text="Enter a supporting document for the implementation of the energy management system"/>}
                    />
                )}

              </div>
            </div>
            <div className='row'>
              <div className='col-md-12'>
                <SelectElement
                  name="additional_permits"
                  label={<I18n text='The need to obtain additional permits'/>}
                  required
                  helperText={t('Permits to implement the project')}
                  options={[
                    {id: 'Yes', label: t('Yes')},
                    {id: 'No', label: t('Not')},
                  ]}
                  fullWidth
                  onChange={(v) => {
                    if (v === 'No') {
                      formContext.setValue('permits_comment', "")
                      onSave({...data, 'permits_comment': "", 'additional_permits': v})
                    } else {
                      onSave({...data, 'additional_permits': v})
                    }
                  }}
                />
              </div>
            </div>
            <div className='row'>
              <div className='col-md-12'>
                {formContext.watch("additional_permits") === 'Yes' && (
                  <TextFieldElement
                    name='permits_comment'
                    label={<I18n text='Comment'/>}
                    required
                    helperText={<I18n text='list of licenses and permits required for the project implementation'/>}
                    fullWidth
                    onChange={(e) => {
                      onSave({...data, [e.target.name]: e.target.value})
                    }}
                  />
                )}
              </div>
            </div>
            <div className='row'>
              <div className='col-md-12'>
                  <TextFieldElement
                    name='list_of_state'
                    label={t('Decisions of government and local authorities for the project')}
                    multiline
                    minRows={3}
                    fullWidth
                    helperText={<I18n
                      text="Provide a list of decisions of state and local authorities to be involved in the project implementation"/>}
                    onChange={(e) => {
                      onSave({...data, [e.target.name]: e.target.value})
                    }}
                  />
              </div>
            </div>
            <div className='row'>
              <div className='col-md-12'>
                <NumberField
                  name='project_sustainability'
                  fullWidth
                  label={<I18n text={'Determination of project sustainability, maximum service life, in years'}/>}
                  required
                  onChange={(e) => {
                    onSave({...data, project_sustainability: e.target.value})
                  }}
                  options={{max: 100, min: 1}}
                />
              </div>
            </div>
            <div className='row'>
              <div className='col-md-12'>
                <SelectElement
                  name='equipment_manufacturer'
                  label={<I18n
                    text={'The project is expected to be implemented with the involvement of equipment manufacturers'}/>}
                  required
                  options={Object.keys(equipment_manufacturers_types).map(key => ({
                    id: key,
                    label: <I18n text={key}/>
                  }))}
                  fullWidth
                  onChange={(v) => {
                    onSave({...data, 'equipment_manufacturer': v})
                  }}
                />
              </div>
            </div>
          </>}

          {viewList && <ProjectSummary data={data}/>}
        </div>
      </div>
    </FormContainer>
  )
}

export default Project
