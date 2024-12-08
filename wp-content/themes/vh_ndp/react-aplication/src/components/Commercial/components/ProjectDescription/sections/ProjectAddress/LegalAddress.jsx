import { Button } from '@mui/material'
import classNames from 'classnames'
import { useEffect, useState } from 'react'
import {FormContainer, useForm} from 'react-hook-form-mui'
import global from '../../../../../../App.module.scss'
import I18n from '../../../../../I18n/I18n'
import { getPoint } from '../../../../../../lib/getPoint'
import BodyAddress from './BodyAddress'
import styles from './LegalAddress.module.scss'
import {yupResolver} from "@hookform/resolvers/yup";
import {projectDescriptionSchemas} from "../../validation.schema";

function LegalAddress({data = {}, onSave = () => {}, forseShowList}) {
  const [viewList, setViewList] = useState(forseShowList ? forseShowList : Boolean(localStorage.getItem('show_ProjectDescription-address') == 'true'));
  const [activeTab, setActiveTab] = useState('Tab1')

  const formContext = useForm({
    defaultValues: data,
    values: data,
    resolver: yupResolver(projectDescriptionSchemas.legal_address),
    mode: 'all'
  })

  useEffect(() => {
    if(forseShowList){
      setViewList(true)
    }
  }, [forseShowList])



  useEffect(() => {
    if(!data.apartment_type){
      onSave({...data, apartment_type: 'Private house'});
    }
  }, [])

  useEffect(() => {
    const fields = ['street', 'street_number', 'city', 'postal_code'];
    if(!fields.some(key => !data[key]) && !data.lat && !data.lng){
      getPoint([data.street, data.street_number, data.city, data.postal_code].join(', ')).then(res => {
        if(res){
          onSave({...data, lat: res.lat, lng: res.lng})
        }
      })
    }
  }, [data])

  const onSubmit = (value) => {

    if(!value.city || !value.street || !value.street_number || !value.postal_code){
      setActiveTab('Tab2')
      return;
    }


    if(viewList){
      localStorage.setItem('show_ProjectDescription-address', false)
      setViewList(false);
    } else {
      localStorage.setItem('show_ProjectDescription-address', true)
      setViewList(true);
      onSave({...data,...value})
    }
  };

  return (
    <FormContainer mode="all" formContext={formContext} defaultValues={data} values={data} onSuccess={onSubmit}>
        <div className={classNames(global.card, styles.LegalAddress)}>
          <div className={global.header}>
            <div className={global.row}>
              <div className={global.title}><I18n text={'Legal address of the object'} /></div>
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
            {!forseShowList && <>
              {!viewList && <div className={styles.tab}>
                <div className={classNames(styles.item, {[styles.active]: activeTab == 'Tab1'})} onClick={() => {setActiveTab('Tab1')}}><I18n text={'Search field'} /></div>
                <div className={classNames(styles.item, {[styles.active]: activeTab == 'Tab2'})} onClick={() => {setActiveTab('Tab2')}}><I18n text={'Address form'} /></div>
              </div>}
            </>}
          </div>
          <BodyAddress formContext={formContext} viewList={viewList} activeTab={activeTab} onSave={onSave} data={data}/>
        </div>
    </FormContainer>
  )
}

export default LegalAddress
