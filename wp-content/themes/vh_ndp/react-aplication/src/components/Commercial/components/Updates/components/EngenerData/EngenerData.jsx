import React from 'react'
import I18n from '../../../../../I18n/I18n'
import global from '../../../../../../App.module.scss'
import SolutionsBody from '../../../ResultModal/components/SolutionsBody/SolutionsBody'
import styles from '../../../ResultModal/ResultModal.module.scss'
import SystemPrice from '../../../../../Engineer/components/ResultModal/components/SystemPrice'
import InstallationDetails from '../../../../../Engineer/components/ResultModal/components/InstallationDetails'
import ElectricityProduction from '../../../../../Engineer/components/ResultModal/components/ElectricityProduction'
import Incentive from '../../../../../Engineer/components/ResultModal/components/Incentive'
import FinancingOption from '../../../../../Engineer/components/ResultModal/components/FinancingOption'
import styles2 from './EngenerData.module.scss'

function EngenerData({application}) {
  return (
    <>
      <div className={global.card}>
        <div className={global.header}>
          <div className={global.row}>
            <div className={global.title}><I18n text={'Proposal'} /></div>
          </div>
        </div>
        <div>
          <div style={{padding: '16px 20px', borderBottom: '1px solid #C5C6D0'}}>
            <div className={styles2.title}><I18n text='Comment'/></div>
            <div>{application?.apply_engineer?.comment}</div>
          </div>
          <div style={{padding: '16px 20px'}}>
            <div className={styles2.title}><I18n text='Proposal'/></div>
            <div className={styles2.block}>
              <a target='_blank' href={application?.apply_engineer?.proposal?.file}>{application?.apply_engineer?.proposal?.file.split('/').pop()}</a>
            </div>
          </div>
        </div>
      </div>
      <div className={global.card}>
        <div className={global.header}>
          <div className={global.row}>
            <div className={global.title}><I18n text={'System design'} /></div>
          </div>
        </div>
        <div>
          <div className={styles.modal_block} style={{padding: '16px 20px', border: 'none'}}>
            <SolutionsBody data={{
              choose_solutions: 'Choose yourself',
              cart: application?.apply_engineer?.system_design?.solutions || {}}} />
          </div>
          <div style={{borderBottom: '1px solid #C5C6D0'}} />
          <SystemPrice data={application?.apply_engineer?.system_design?.system_price || {}} currency={application?.apply_engineer?.currency} />
          <InstallationDetails data={application?.apply_engineer?.system_design?.installation_details || {}} />
        </div>
      </div>
      <div className={global.card}>
        <div className={global.header}>
          <div className={global.row}>
            <div className={global.title}><I18n text={'Economy month by month'} /></div>
          </div>
        </div>
        <div>
          <ElectricityProduction data={application?.apply_engineer?.financial_information?.economy_month_by_month || {}} currency={application?.apply_engineer?.currency} />
          <Incentive 
            data={application?.apply_engineer?.financial_information?.incentive || {}} 
            system_price={application?.apply_engineer?.system_design?.system_price || {}} 
            currency={application?.apply_engineer?.currency} 
          />
          <FinancingOption data={application?.apply_engineer?.financial_information?.financing_option || {}} currency={application?.apply_engineer?.currency} />
                    
        </div>
      </div>
    </>
  )
}

export default EngenerData