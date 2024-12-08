import React from 'react'
import I18n from '../../../I18n/I18n'
import global from '../../../../App.module.scss'
import EngenerData from './components/EngenerData/EngenerData';
import { Button } from '@mui/material';
import classNames from 'classnames';

function Updates({application, onClickEdit = () => {}, applicationStatus}) {
  let status = applicationStatus;
  let message = application?.feedback && application?.feedback[status] ?  application?.feedback[status] : '';
  let title = ''
  switch (status) {
    case 'reject':
      title = 'Comment about rejected'
      break;
    case 'rejected':
      title = 'Comment about rejected'
      break;
    case 'return to application':
      title = 'Comment about return'
      break;
    case 'returned':
      title = 'Comment about return'
      break;
  
    default:
      break;
  }

  return (
    <div>
      <div className={global.header_title}>
        <div className={global.title}><I18n text={'Updates'} /> </div>
      </div>
      {(status == 'submitted' || status ==  'processed') && <EngenerData application={application} />}
      {(status != 'submitted' && status != 'processed') && <div className={global.card}>
        <div className={global.header}>
          <div className={global.row}>
            <div className={global.title}><I18n text={title} /></div>
          </div>
        </div>
        <div className={global.body}>
          <div>{message}</div>
        </div>
      </div>}
      {(application?.status == 'return to application' || application?.status == 'returned') && <div style={{marginTop: 24}}>
        <div className={classNames(global.btns, global.btns_blue)} onClick={onClickEdit}><I18n text='Edit Application'/></div>
      </div>}
    </div>
  )
}

export default Updates