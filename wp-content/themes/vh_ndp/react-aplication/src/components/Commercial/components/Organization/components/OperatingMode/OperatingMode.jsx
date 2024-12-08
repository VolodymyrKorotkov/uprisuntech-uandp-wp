import { useEffect, useState } from 'react'
import { Button, Switch } from '@mui/material';
import { FormContainer, useForm } from 'react-hook-form-mui'
import global from '../../../../../../App.module.scss'
import styles from './OperatingMode.module.scss'
import classNames from 'classnames';
import I18n from '../../../../../I18n/I18n';
import TimeField from '../../../../../TimeField/TimeField';
import {yupResolver} from "@hookform/resolvers/yup";
import {organizationsSchemas} from "../../validation.schema";
import {NumberField} from "../../../../../NumberFields";

function OperatingMode({data = {}, onSave, forseShowList}) {
  const [viewList, setViewList] = useState(forseShowList ? forseShowList : Boolean(localStorage.getItem('show_OperatingMode') == 'true'));
  const [activeTab, setActiveTab] = useState('Tab1')

  const formContext = useForm({
    defaultValues: data,
    values: data,
    resolver: yupResolver(organizationsSchemas.operating_mode),
    mode: 'onBlur',
  });

  useEffect(() => {
    if(forseShowList){
      setViewList(true)
    }
  }, [forseShowList])

  const onSubmit = (value) => {
    setViewList(!viewList);
    localStorage.setItem('show_OperatingMode', !viewList)

    if (!viewList) {
      onSave(value)
    }
  };

  const onError = (errors) => {
    if(errors && viewList) {
      setViewList(false);
      localStorage.setItem('show_OperatingMode', false)
    }

    if(errors.time_from || errors.time_to) {
      setActiveTab('Tab2')
    }
  }

  return (
    <FormContainer mode="onBlur" formContext={formContext} defaultValues={data} values={data} onError={onError} onSuccess={onSubmit}>
      <div className={classNames(global.card, styles.OperatingMode)}>
        <div className={global.header}>
          <div className={global.row}>
            <div className={global.title}><I18n text={'Operating mode'} /></div>
            {!forseShowList && <>{!viewList ? <Button className={global.btn} type={'submit'} color={'primary'} startIcon={<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
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
          {!viewList && <div className={styles.tab}>
            <div className={classNames(styles.item, {[styles.active]: activeTab == 'Tab1'})} onClick={() => {setActiveTab('Tab1')}}><I18n text={'Hours a day'} /></div>
            <div className={classNames(styles.item, {[styles.active]: activeTab == 'Tab2'})} onClick={() => {setActiveTab('Tab2')}}><I18n text={'From-To'} /></div>
          </div>}
        </div>
        <div className={global.body}>
          {!viewList && <>
            {activeTab == 'Tab1' && <div className='row'>
              <div className='col-md-12'>
                <NumberField
                  name={'hours'}
                  label={<I18n text={'Hours'} />}
                  required
                  fullWidth
                  onChange={(e) => {
                    onSave({...data, [e.target.name]: e.target.value})
                  }}
                  options={{max: 24, min: 1}}
                />
              </div>
            </div>}
            {activeTab == 'Tab2' && <div className='row'>
              <div className='col-md-6'>
                <TimeField
                  name={'time_from'}
                  label={<I18n text={'Time from'} />}
                  rules={{required: true}}
                  fullWidth
                  onChange={(e) => {
                    onSave({...data, 'time_from': e})
                  }}
                />

              </div>
              <div className='col-md-6'>
                <TimeField
                  name={'time_to'}
                  label={<I18n text={'Time to'} />}
                  rules={{required: true}}
                  fullWidth
                  onChange={(e) => {
                    onSave({...data, 'time_to': e})
                  }}
                />
              </div>
            </div>}
            <div className='row'>
              <div className='col-md-12'>
                <div className={styles.items}>
                  <div className={styles.item}>
                    <Switch className={styles.switch} name="monday" defaultChecked={data.monday} onChange={() => {
                      onSave({...data, 'monday': !data.monday})
                    }} />
                    <div className={styles.text}><I18n text={'Monday'} /></div>
                  </div>
                  <div className={styles.item}>
                    <Switch className={styles.switch}  defaultChecked={data.tuesday} onChange={() => {
                      onSave({...data, 'tuesday': !data.tuesday})
                    }}  />
                    <div className={styles.text}><I18n text={'Tuesday'} /></div>
                  </div>
                  <div className={styles.item}>
                    <Switch className={styles.switch}  defaultChecked={data.wednesday} onChange={() => {
                      onSave({...data, 'wednesday': !data.wednesday})
                    }}  />
                    <div className={styles.text}><I18n text={'Wednesday'} /></div>
                  </div>

                  <div className={styles.item}>
                    <Switch className={styles.switch}  defaultChecked={data.thursday} onChange={() => {
                      onSave({...data, 'thursday': !data.thursday})
                    }}  />
                    <div className={styles.text}><I18n text={'Thursday'} /></div>
                  </div>

                  <div className={styles.item}>
                    <Switch className={styles.switch}  defaultChecked={data.friday} onChange={() => {
                      onSave({...data, 'friday': !data.friday})
                    }}  />
                    <div className={styles.text}><I18n text={'Friday'} /></div>
                  </div>
                  <div className={styles.item}>
                    <Switch className={styles.switch}  defaultChecked={data.saturday} onChange={() => {
                      onSave({...data, 'saturday': !data.saturday})
                    }}  />
                    <div className={styles.text}><I18n text={'Saturday'} /></div>
                  </div>
                  <div className={styles.item}>
                    <Switch className={styles.switch}  defaultChecked={data.sunday} onChange={() => {
                      onSave({...data, 'sunday': !data.sunday})
                    }}  />
                    <div className={styles.text}><I18n text={'Sunday'} /></div>
                  </div>
                </div>
                {!!formContext.formState.errors?.monday && <div style={{color: '#d32f2f', fontSize: '0.75rem', paddingLeft: 14, marginTop: 5}}>{formContext.formState.errors?.monday?.message}</div>}
              </div>
            </div>
          </>}
          {viewList && <>
              <div className={global.block_text}>
                <span><I18n text='Working days' /></span>
                <div>{[
                  data.monday ? 'Monday' : '',
                  data.tuesday ? 'Tuesday' : '',
                  data.wednesday ? 'Wednesday' : '',
                  data.thursday ? 'Thursday' : '',
                  data.friday ? 'Friday' : '',
                  data.saturday ? 'Saturday' : '',
                  data.sunday ? 'Sunday' : '',
                ].filter(_i => !!_i).map((_i, index) => {
                  return <>{index > 0 ? ', ' : ''}<I18n text={_i} /></>
                }) }
              </div>
              </div>
              <div className={global.block_text}>
                <span><I18n text='Working hours' /></span>
                <div>{data?.hours ? data.hours + '/' : ''}{data?.hours && <I18n text='day'/>} { !data?.hours && data?.time_from && data?.time_to ? data?.time_from + '-' + data?.time_to : ''  }</div>
              </div>


            </>}
        </div>
      </div>
    </FormContainer>
  )
}

export default OperatingMode
