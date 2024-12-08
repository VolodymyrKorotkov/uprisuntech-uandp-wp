import { useEffect, useState } from 'react'
import { Button, Checkbox, FormControlLabel } from '@mui/material';
import { FormContainer, SelectElement, useForm } from 'react-hook-form-mui';
import { yupResolver } from "@hookform/resolvers/yup";
import global from '../../../../App.module.scss'
import I18n from '../../../I18n/I18n'
import ListProjectInformation from './ListProjectInformation';
import UploadsFiles from './components/UploadsFiles/UploadsFiles';
import styles from './ProjectInformation.module.scss'
import { projectInfoSchema } from "./validation.schema";

function ProjectInformation({ forseShowList, data, onSave, municipalityInfo, onChangeOrganisation = () => {}, status = {} }) {
  const [viewList, setViewList] = useState(forseShowList ? forseShowList : Boolean(localStorage.getItem('show_ProjectInformation') == 'true'))

  const formContext = useForm({
    defaultValues: data,
    values: data,
    resolver: yupResolver(projectInfoSchema),
    mode: 'all'
  });


  useEffect(() => {
    if(forseShowList){
      setViewList(true)
    }
  }, [forseShowList])


  const onSubmit = (value) => {
    if(viewList){
      setViewList(false);
      localStorage.setItem('show_ProjectInformation', false)
    } else {
      setViewList(true);
      localStorage.setItem('show_ProjectInformation', true)
      onSave(value)
    }
  };


  return (
    <>
      <div className={styles.ProjectInformation}>
        <div className={global.header_title}>
          <div className={global.title}><I18n text='Project information' /></div>
          <div className={global.text}>
            {!forseShowList && <I18n text='* Required sections must be filled in' />}
          </div>
        </div>
        {municipalityInfo && municipalityInfo.id && <div style={{marginBottom: 24}}>
          <FormControlLabel
            checked={Boolean(data.municipalityInfoChecked)}
            defaultChecked={Boolean(data.municipalityInfoChecked)}
            control={<Checkbox defaultChecked={data.municipalityInfoChecked} checked={data.municipalityInfoChecked}/>}
            label={<><I18n text='Application from the organization'/> “{municipalityInfo.user_organization || municipalityInfo.name}”</>}
            disabled={forseShowList || Boolean(status)}
            onChange={() => {

              const value = !data.municipalityInfoChecked;
              onSave({...data, municipalityInfoChecked: value})

              if(value){
                onChangeOrganisation({
                  company_name: municipalityInfo.user_organization || municipalityInfo.name,
                  registration_number: municipalityInfo.edr
                })
              }
            }}
          />
        </div>}
        <FormContainer mode="all" formContext={formContext} defaultValues={data} values={data} onSuccess={onSubmit}>
          <div className={global.card}>
            <div className={global.header}>
              <div className={global.row}>
                <div className={global.title}><I18n text='Project type' /></div>
                {!forseShowList && <>{!viewList ? <Button className={global.btn} type={'submit'} color={'primary'} startIcon={<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                  <path d="M6.75012 12.1275L3.62262 9L2.55762 10.0575L6.75012 14.25L15.7501 5.25L14.6926 4.1925L6.75012 12.1275Z" fill="#2A59BD"/>
                </svg>}>
                <I18n text='Collapse' />
                </Button> : <Button className={global.btn} type='submit' color={'primary'} startIcon={<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                  <path fillRule="evenodd" clipRule="evenodd" d="M14.295 2.69253L15.3075 3.70503C15.9 4.29003 15.9 5.24253 15.3075 5.82753L5.385 15.75H2.25V12.615L10.05 4.80753L12.1725 2.69253C12.7575 2.10753 13.71 2.10753 14.295 2.69253ZM3.75 14.25L4.8075 14.295L12.1725 6.92253L11.115 5.86503L3.75 13.23V14.25Z" fill="#2A59BD"/>
                </svg>}>
                  <I18n text='Expand' />
                </Button>}</>}
              </div>
            </div>
            <div className={global.body}>
              {!viewList && <>
                <div className='row'>
                  <div className='col-md-12'>
                    <SelectElement
                      name={'project_type'}
                      label={<I18n text='Project type' />}
                      required
                      options={[
                        {id: 'Solar energy', label: <I18n text='Solar energy' />},
                        {id: 'Other', label: <I18n text='Other Type' />},
                      ]}
                      fullWidth
                      onChange={(v) => {
                        onSave({...data, 'project_type': v})
                      }}
                    />
                  </div>
                </div>

                {
                  data.project_type === 'Other' && (
                        <UploadsFiles data={data} onSave={onSave} formContext={formContext} />
                    )
                }

              </>}
              {viewList && <ListProjectInformation data={data} /> }
            </div>
          </div>
        </FormContainer>
      </div>
    </>
  )
}

export default ProjectInformation
