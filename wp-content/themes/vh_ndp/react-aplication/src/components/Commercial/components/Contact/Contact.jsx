import { useEffect, useState } from 'react'
import { FormContainer, TextFieldElement, useForm } from 'react-hook-form-mui'
import { Button, TextField } from '@mui/material'
import {yupResolver} from "@hookform/resolvers/yup";
import global from '../../../../App.module.scss'
import I18n from '../../../I18n/I18n'
import PhoneField from '../../../PhoneField/PhoneField'
import classNames from 'classnames'
import {contactSchema} from './validation.schema'

function setCookie(name, value, daysToExpire = 30) {
  var date = new Date();

  date.setTime(date.getTime() + (daysToExpire * 24 * 60 * 60 * 1000));

  var expires = "expires=" + date.toUTCString();
  document.cookie = name + "=" + value + "; " + expires + "; path=/";
}

function Contact({contact = {}, onSave = () => {}, forseShowList}) {
  const [viewList, setViewList] = useState(forseShowList ? forseShowList : Boolean(localStorage.getItem('show_Contact') == 'true'))

  const formContext = useForm({
    defaultValues: contact,
    resolver: yupResolver(contactSchema),
    mode: 'all'
  });

  const onSubmit = (value) => {
    setViewList(!viewList);
    localStorage.setItem('show_Contact', !viewList)

    if (!viewList) {
      onSave(value)
    }
  };

  const onError = (errors) => {
    if(errors && viewList) {
      setViewList(false);
      localStorage.setItem('show_Contact', false)
    }
  }

  useEffect(() => {
    if(localStorage.getItem('isLoggedIn') != '1'){
      setViewList(true)
    }
  }, [])

  return (
    <div>
      <div className={global.header_title} style={{marginBottom: localStorage.getItem('isLoggedIn') != '1' ? 16 : 24}}>
        <div className={global.title}><I18n text='Contact' /></div>
      </div>

      {localStorage.getItem('isLoggedIn') != '1' && <div style={{marginBottom: 24}}>
        <p style={{
          marginBottom: 16,
          fontSize: 16,
          fontWeight: 400,
          lineHeight: "24px",
        }}><I18n text='Authorization with an additional integrated electronic identification system ID.GOV.UA'/></p>
        <div className={classNames(global.btns, global.btns_blue)} style={{width: '100%'}} onClick={() => {
          setCookie('old_url', window.location.href)
          window.location.href="/wp-json/redirect/v1/redirect/"
        }} ><I18n text={'Login via ID.GOV.UA'}/></div>
      </div>}
      <FormContainer mode="all" formContext={formContext} defaultValues={contact} values={contact} onError={onError} onSuccess={onSubmit}>
        <div className={global.card}>
          <div className={global.header}>
            <div className={global.row}>
              <div className={global.title}><I18n text='Personal data' /></div>
              {!forseShowList && localStorage.getItem('isLoggedIn') == '1' && <>
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
                  <TextField
                    defaultValue={formContext.formState?.defaultValues?.full_name}
                    label={<I18n text={'Full name *'} />}
                    fullWidth
                    disabled
                  />
                  <TextFieldElement
                    type='hidden'
                    name={'full_name'}
                    sx={ {overflow: 'hidden', pointerEvents: 'none'} }
                  />
                </div>
              </div>
              <div className='row'>
                <div className='col-md-12'>
                  <TextField
                    defaultValue={formContext.formState?.defaultValues?.email}
                    label={<I18n text={'Email (login ID) *'} />}
                    fullWidth
                    disabled
                  />
                  <TextFieldElement
                    type='hidden'
                    sx={ {display: 'none'} }
                    name={'email'}
                  />
                  <p className={global.help}><I18n text={'This email will be used for account authorization'} /></p>
                </div>
              </div>
              <div className='row'>
                <div className='col-md-12'>
                  <PhoneField
                    name="phone"
                    label={<I18n text={'Mobile phone'} />}
                    rules={{required: true}}
                    onChange={(e) => {
                      onSave({...contact, 'phone': e.target.value})
                    }}
                  />
                </div>
              </div>
            </>}
            {viewList && <>
              <div className={global.block_text}>
                <span><I18n text='Full name'/></span>
                <div>{contact?.full_name}</div>
              </div>
              <div className={global.block_text}>
                <div>
                  <span><I18n text='Email (login ID)'/></span><br/>
                  <span><I18n text='This email will be used for account authorization'/></span>
                </div>

                <div>{contact.email}</div>
              </div>
              <div className={global.block_text}>
                <span><I18n text='Mobile phone'/></span>
                <div>{contact.phone}</div>
              </div>
            </>}
          </div>
        </div>
      </FormContainer>
    </div>
  )
}

export default Contact
