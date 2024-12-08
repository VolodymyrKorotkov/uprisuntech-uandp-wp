import React, {useEffect, useState} from 'react'
import styles from './NavigateTab.module.scss'
import { Button } from '@mui/material'
import I18n from '../../../I18n/I18n'
import classNames from 'classnames'

function NavigateTab({links = [], activeNavigate, onChange, status, onSaveSubmit}) {
  const [sectionStatuses, setSectionStatuses] = useState({})

  let nav = links.map(_i => _i.title);
  if(status && ['reject', 'rejected', 'return to application', 'submitted', 'processed', 'returned'].includes(status)){
    nav = ['Updates', ...nav];
  }
  const index = nav.indexOf(activeNavigate);
  const prev = (index - 1) > -1 ? nav[index - 1] : '';
  const next = (index + 1) < nav.length ? nav[index + 1] : '';

  let btnTitle = 'Submit';
  switch (status) {
    case 'reject':
      btnTitle = 'Rejected';

      break;
    case 'rejected':
      btnTitle = 'Rejected';

      break;
    case 'return to application':
      btnTitle = 'Returned';

      break;
    case 'returned':
      btnTitle = 'Returned';

      break;
    case 'submitted':
      btnTitle = 'Submitted';

      break;
    case 'processed':
      btnTitle = 'Processed';

      break;
    case 'await':
      btnTitle = 'Submitted';
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
    <div className={styles.NavigateTab}>
      <Button
        type='button'
        color='info'
        className={classNames(styles.btn, styles.btn_transparent)}
        disabled={!prev}
        onClick={() => onChange(prev)}
      >
        <I18n text="Previous"/>
      </Button>
      {Boolean(next) && <Button
        type='button'
        color='primary'
        className={classNames(styles.btn, styles.btn_solid)}
        disabled={!next}
        onClick={() => onChange(next)}
      >
        <I18n text="Next"/>
      </Button>}
      {!Boolean(next) && <Button
        type='button'
        color='primary'
        className={classNames(styles.btn, styles.btn_solid)}
        disabled={(status && status != 'draft') || !Object.values(sectionStatuses).every(Boolean)}
        onClick={onSaveSubmit}
      >
        <I18n text={btnTitle}/>
      </Button>}
    </div>
  )
}

export default NavigateTab
