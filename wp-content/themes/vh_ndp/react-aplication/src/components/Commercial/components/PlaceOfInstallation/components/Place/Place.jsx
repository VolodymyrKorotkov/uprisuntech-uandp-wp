import { useEffect, useState } from 'react'
import { Button, Checkbox, FormControlLabel } from '@mui/material'
import classNames from 'classnames'
import {FormContainer, useForm} from 'react-hook-form-mui'
import {yupResolver} from "@hookform/resolvers/yup";
import global from '../../../../../../App.module.scss'
import styles from './Place.module.scss'
import BodyAddress from '../../../Organization/components/LegalAddress/BodyAddress'
import { getPoint } from '../../../../../../lib/getPoint'
import I18n from '../../../../../I18n/I18n'
import {placeOfInstallationSchemas} from "../../validation.schema";

function Place({data = {}, onSave = () => {}, legalAddress = {}, forseShowList, typeProjectOther}) {
  const [viewList, setViewList] = useState(forseShowList ? forseShowList : Boolean(localStorage.getItem('show_Place') == 'true'));
  const [activeTab, setActiveTab] = useState('Tab1')
  const [reloadSearch, setReloadSearch] = useState(false)

  const formContext = useForm({
    defaultValues: data,
    resolver: yupResolver(placeOfInstallationSchemas.place),
    mode: 'all'
  })

  useEffect(() => {
    if(!data.apartment_type){
      onSave({...data, apartment_type: 'Private house'});
    }
  }, [])

  useEffect(() => {
    const fields = ['street', 'street_number', 'city', 'postal_code'];
    if(!fields.some(key => !data[key]) && !data.lat && !data.lng){
      getPoint([data.street, data.street_number, data.city, data.postal_code].join(', ')).then(res => {
        console.log("🚀 ~ file: LegalAddress.jsx:22 ~ getPoint ~ res:", res)
        if(res){
          onSave({...data, lat: res.lat, lng: res.lng})
        }
      })
    }
  }, [data])

  const onSubmit = (value) => {

    if(!typeProjectOther){
      if(!value.city || !value.street || !value.street_number || !value.postal_code){
        setActiveTab('Tab2')
        return;
      }
    }

    setViewList(!viewList);
    localStorage.setItem('show_Place', !viewList)

    if (!viewList) {
      onSave({...data, ...value})
    }
  };

  const onError = (errors) => {
    if(errors && viewList) {
      setViewList(false);
      localStorage.setItem('show_Place', false)
    }
  }

  return (
    <FormContainer mode="all" formContext={formContext} defaultValues={data} values={data} onError={onError} onSuccess={onSubmit}>
        <div className={classNames(global.card, styles.Place)}>
          <div className={global.header}>
            <div className={global.row}>
              <div className={global.title}><I18n text={'Place'} /></div>
              {!forseShowList && <>{!viewList ? <Button className={global.btn} type={'submit'} color={'primary'} startIcon={<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                <path d="M6.75012 12.1275L3.62262 9L2.55762 10.0575L6.75012 14.25L15.7501 5.25L14.6926 4.1925L6.75012 12.1275Z" fill="#2A59BD"/>
              </svg>}>
                <I18n text={'Collapse'} />
              </Button> : <Button className={global.btn} type='submit' color={'primary'} startIcon={<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                <path fillRule="evenodd" clipRule="evenodd" d="M14.295 2.69253L15.3075 3.70503C15.9 4.29003 15.9 5.24253 15.3075 5.82753L5.385 15.75H2.25V12.615L10.05 4.80753L12.1725 2.69253C12.7575 2.10753 13.71 2.10753 14.295 2.69253ZM3.75 14.25L4.8075 14.295L12.1725 6.92253L11.115 5.86503L3.75 13.23V14.25Z" fill="#2A59BD"/>
              </svg>}>
                <I18n text={'Expand'} />
              </Button>}</>}
            </div>
            {!viewList && <div className='row'>
              <div className='col-md-12'>
                <FormControlLabel
                  style={{marginLeft: 10}}
                  control={<Checkbox
                    checked={Boolean(data.same_as_legal_address)}
                    onChange={() => {
                      const value = !Boolean(data.same_as_legal_address);
                      if(value){
                        onSave({...data, same_as_legal_address: value, ...legalAddress});
                        Object.entries(legalAddress).forEach(([name, value]) => formContext.setValue(name, value));
                        setReloadSearch(true)
                      } else {
                        const address = {
                          city: '',
                          property_type: '',
                          state: '',
                          street: '',
                          apartment: '',
                          postal_code: '',
                          street_number: '',
                          lat: '',
                          lng: '',
                        };
                        onSave({...data, same_as_legal_address: value, ...address})
                        Object.entries(address).forEach(([name, value]) => formContext.setValue(name, value));
                        setReloadSearch(true)
                      }

                    }}
                  />}
                  label={<I18n text={'Same as legal address'}
                />} />
              </div>
            </div>}
            {!viewList && <div className={styles.tab}>
              <div className={classNames(styles.item, {[styles.active]: activeTab == 'Tab1'})} onClick={() => {setActiveTab('Tab1')}}><I18n text={'Search field'} /></div>
              <div className={classNames(styles.item, {[styles.active]: activeTab == 'Tab2'})} onClick={() => {setActiveTab('Tab2')}}><I18n text={'Address form'} /></div>
            </div>}
          </div>
          <BodyAddress
            formContext={formContext}
            typeProjectOther={typeProjectOther}
            viewList={viewList}
            activeTab={activeTab}
            onSave={onSave}
            data={data}
            reloadSearch={reloadSearch}
            onChangeReloadSearch={(v) => {
              setReloadSearch(v)
            }}
          />
        </div>
    </FormContainer>
  )
}

export default Place
