import { useState } from 'react';
import { Button } from '@mui/material';
import { FormContainer, useForm } from 'react-hook-form-mui'
import {yupResolver} from "@hookform/resolvers/yup";
import global from '../../../../../../App.module.scss';
import I18n, { t } from '../../../../../I18n/I18n';
import { NumberField } from "../../../../../NumberFields";
import { resourcesUsageSchemas } from '../../validation.schema'
import ListBaseYear from "./ListBaseYear";

const BaseYear = ({data = {}, onSave, forseShowList}) => {
  const [viewList, setViewList] = useState(forseShowList ? forseShowList : Boolean(localStorage.getItem('show_base_year') == 'true'))

  const formContext = useForm({
    defaultValues: data,
    resolver: yupResolver(resourcesUsageSchemas.base_year),
    mode: 'all'
  });

  const onSubmit = (value) => {
    setViewList(!viewList);
    localStorage.setItem('show_base_year', !viewList)

    if (!viewList) {
      onSave({...data, ...value})
    }
  };

  const onError = (errors) => {
    if(errors && viewList) {
      setViewList(false);
      localStorage.setItem('show_base_year', false)
    }
  }

  return (
    <FormContainer mode="all" formContext={formContext} defaultValues={data} values={data}  onError={onError} onSuccess={onSubmit}>
      <div className={global.card}>
        <div className={global.header}>
          <div className={global.row}>
            <div className={global.title}><I18n text='Base year' /></div>
            {!forseShowList && <>{!viewList ? <Button className={global.btn} type={'submit'} color={'primary'} startIcon={<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
              <path d="M6.75012 12.1275L3.62262 9L2.55762 10.0575L6.75012 14.25L15.7501 5.25L14.6926 4.1925L6.75012 12.1275Z" fill="#2A59BD"/>
            </svg>}>
              <I18n text='Collapse' />

            </Button> : <Button className={global.btn} type='submit' color={'primary'} startIcon={<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
              <path fillRule="evenodd" clipRule="evenodd" d="M14.295 2.69253L15.3075 3.70503C15.9 4.29003 15.9 5.24253 15.3075 5.82753L5.385 15.75H2.25V12.615L10.05 4.80753L12.1725 2.69253C12.7575 2.10753 13.71 2.10753 14.295 2.69253ZM3.75 14.25L4.8075 14.295L12.1725 6.92253L11.115 5.86503L3.75 13.23V14.25Z" fill="#2A59BD"/>
            </svg>}>
              <I18n text='Expand' />
            </Button>}
            </>}
          </div>
        </div>
        <div className={global.body}>
          {!viewList &&
            <>
              <div className='row'>
                <div className='col-md-12'>
                  <NumberField
                    name={'base_year'}
                    fullWidth
                    required
                    label={<I18n text='The year of the basic calculation of energy resource costs in the calculation for the project'/>}
                    onChange={(e) => {
                      onSave({...data, [e.target.name]: e.target.value})
                    }}
                    options={{min: 1000, max: 9999}}
                  />
                </div>
              </div>
            </>
          }
          {viewList && <ListBaseYear data={data}/>}
        </div>
      </div>
    </FormContainer>
  );
};

export default BaseYear;
