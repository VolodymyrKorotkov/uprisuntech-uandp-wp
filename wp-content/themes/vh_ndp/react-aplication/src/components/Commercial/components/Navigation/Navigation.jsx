import React, {useEffect, useState} from 'react'
import styles from './Navigation.module.scss'
import { Button } from '@mui/material'
import classNames from 'classnames'
import I18n from '../../../I18n/I18n'

function Navigation({links = [], isOtherProject, activeNavigate, onSaveDraft, onSaveSubmit, draftId, status, applicationStatus, onChange}) {
  const [sectionStatuses, setSectionStatuses] = useState({})
  let btnIcon = null;
  let btnTitle = 'Submit';
  switch (status) {
    case 'reject':
      btnTitle = 'Rejected';
      btnIcon = <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
        <path d="M14.25 4.8075L13.1925 3.75L9 7.9425L4.8075 3.75L3.75 4.8075L7.9425 9L3.75 13.1925L4.8075 14.25L9 10.0575L13.1925 14.25L14.25 13.1925L10.0575 9L14.25 4.8075Z" fill="#151B2C"/>
      </svg>;
      break;
    case 'rejected':
      btnTitle = 'Rejected';
      btnIcon = <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
        <path d="M14.25 4.8075L13.1925 3.75L9 7.9425L4.8075 3.75L3.75 4.8075L7.9425 9L3.75 13.1925L4.8075 14.25L9 10.0575L13.1925 14.25L14.25 13.1925L10.0575 9L14.25 4.8075Z" fill="#151B2C"/>
      </svg>;
      break;
    case 'return to application':
      btnTitle = 'Returned';
      btnIcon = <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18" fill="none">
        <path d="M14.75 5.25V8.25H5.6225L8.3075 5.5575L7.25 4.5L2.75 9L7.25 13.5L8.3075 12.4425L5.6225 9.75H16.25V5.25H14.75Z" fill="#151B2C"/>
      </svg>;
      break;
    case 'returned':
      btnTitle = 'Returned';
      btnIcon = <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18" fill="none">
        <path d="M14.75 5.25V8.25H5.6225L8.3075 5.5575L7.25 4.5L2.75 9L7.25 13.5L8.3075 12.4425L5.6225 9.75H16.25V5.25H14.75Z" fill="#151B2C"/>
      </svg>;
      break;
    case 'submitted':
      btnTitle = 'Submitted';
      btnIcon = <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18" fill="none">
        <path d="M7.25012 12.1274L4.12262 8.99988L3.05762 10.0574L7.25012 14.2499L16.2501 5.24988L15.1926 4.19238L7.25012 12.1274Z" fill="#151B2C"/>
      </svg>;
      break;
    case 'processed':
      btnTitle = 'Processed';
      btnIcon = <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18" fill="none">
        <path d="M7.25012 12.1274L4.12262 8.99988L3.05762 10.0574L7.25012 14.2499L16.2501 5.24988L15.1926 4.19238L7.25012 12.1274Z" fill="#151B2C"/>
      </svg>;
      break;
    case 'await':
      btnTitle = 'Sent';
      break;
    case 'pending':
      btnTitle = 'Submitted';
      break;
    case 'in progress':
      btnTitle = 'In progress';
      break;
    default:
      break;
  }
  const formatData = async () => {
    const results = await Promise.allSettled(links.map(async (item) => {
      return {
        valid: await item.valid,
        title: item.title
      }
    }));

    const formatted = {}
    results.forEach((result, index) => {
      const isValid = result.status === 'fulfilled' ? result.value.valid : false;
      formatted[result.value.title] = isValid;
    });

    setSectionStatuses(formatted);
  };

  useEffect(() => {
    formatData()
  }, [links])

  return (
    <div className={styles.Navigation}>
      <div className={styles.content}>
        {applicationStatus && !isOtherProject && ['reject', 'return to application', 'submitted', 'processed', 'returned'].includes(applicationStatus) && <div onClick={() => {onChange('Updates')}} className={classNames(styles.item, {[styles.active]: 'Updates' == activeNavigate})}>
          <div className={styles.icon}>
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <mask id="mask0_6403_33347" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
              <rect width="24" height="24" fill="#D9D9D9"/>
            </mask>
            <g mask="url(#mask0_6403_33347)">
              <path d="M12 21C10.75 21 9.57917 20.7625 8.4875 20.2875C7.39583 19.8125 6.44583 19.1708 5.6375 18.3625C4.82917 17.5542 4.1875 16.6042 3.7125 15.5125C3.2375 14.4208 3 13.25 3 12C3 10.75 3.2375 9.57917 3.7125 8.4875C4.1875 7.39583 4.82917 6.44583 5.6375 5.6375C6.44583 4.82917 7.39583 4.1875 8.4875 3.7125C9.57917 3.2375 10.75 3 12 3C13.3667 3 14.6625 3.29167 15.8875 3.875C17.1125 4.45833 18.15 5.28333 19 6.35V4H21V10H15V8H17.75C17.0667 7.06667 16.225 6.33333 15.225 5.8C14.225 5.26667 13.15 5 12 5C10.05 5 8.39583 5.67917 7.0375 7.0375C5.67917 8.39583 5 10.05 5 12C5 13.95 5.67917 15.6042 7.0375 16.9625C8.39583 18.3208 10.05 19 12 19C13.75 19 15.2792 18.4333 16.5875 17.3C17.8958 16.1667 18.6667 14.7333 18.9 13H20.95C20.7 15.2833 19.7208 17.1875 18.0125 18.7125C16.3042 20.2375 14.3 21 12 21ZM14.8 16.2L11 12.4V7H13V11.6L16.2 14.8L14.8 16.2Z" fill="#2A59BD"/>
            </g>
          </svg>
          </div>
          <div><I18n text='Updates'/></div>
        </div>}
        {links.map(_i =>
          <div key={_i.title} onClick={_i.onClick} className={classNames(styles.item, {[styles.active]: _i.title == activeNavigate})}>
            <div className={styles.icon}>
              {sectionStatuses?.[_i.title] ? <svg xmlns="http://www.w3.org/2000/svg" width="18" height="14" viewBox="0 0 18 14" fill="none">
                <path d="M6.00003 11.1701L1.83003 7.00009L0.410034 8.41009L6.00003 14.0001L18 2.00009L16.59 0.590088L6.00003 11.1701Z" fill="#2A59BD"/>
              </svg> :
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path fillRule="evenodd" clipRule="evenodd" d="M12 16C14.2091 16 16 14.2091 16 12C16 9.79086 14.2091 8 12 8C9.79086 8 8 9.79086 8 12C8 14.2091 9.79086 16 12 16ZM18 12C18 15.3137 15.3137 18 12 18C8.68629 18 6 15.3137 6 12C6 8.68629 8.68629 6 12 6C15.3137 6 18 8.68629 18 12Z" fill="#2A59BD"/>
              </svg>}
            </div>
            <div><I18n text={_i.title}/></div>
          </div>
        )}

      </div>
      <div className={styles.button}>
        <Button fullWidth className={classNames(styles.btn, styles.btn_transparent)} type={'submit'} color={'primary'} onClick={() => {
          if(status && status !== 'draft'){
            window.location.href = '/dashboard/applications/'
          } else {
            onSaveDraft()
          }
        }}>
          {status && status !== 'draft' ? <I18n text='My applications' /> : <I18n text='To draft' />}
        </Button>
        <Button
          fullWidth
          onClick={onSaveSubmit}
          className={classNames(styles.btn, styles.btn_solid)}
          disabled={(status && status !== 'draft') || !Object.values(sectionStatuses).every(Boolean)}
          type={'submit'}
          color={'primary'}
          startIcon={btnIcon}
        >
          <I18n text={btnTitle} />
        </Button>
      </div>
    </div>
  )
}

export default Navigation
