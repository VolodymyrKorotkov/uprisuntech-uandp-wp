import classNames from "classnames";
import global from '../../../../App.module.scss'
import { Modal } from '@mui/material'
import React from 'react'
import styles from './ResultModal.module.scss'
import I18n from "../../../I18n/I18n";
import PlaceAddress from "../../../Commercial/components/ResultModal/components/Place/PlaceAddress";
import SolutionsBody from "../../../Commercial/components/ResultModal/components/SolutionsBody/SolutionsBody";
import SystemPrice from "./components/SystemPrice";
import InstallationDetails from "./components/InstallationDetails";
import ElectricityProduction from "./components/ElectricityProduction";
import Incentive from "./components/Incentive";
import FinancingOption from "./components/FinancingOption";
import UploadField from "../../../UploadField/UploadField";

function ResultModal({open, onClose = () => {}, application = {}, onSave=() => {}, hideActions, title, onSaveFile = () => {}}) {
  return (
    <Modal style={{zIndex: 9999999}} className={global.c_modal_flex} open={open} onClose={onClose}>
      <div className={classNames(global.c_modal, global.c_modal_medium)}>
          <div className={global.c_modal_header}>
						<div className={global.h3}><I18n text={title ? title : 'Submit application'} /></div>
						<div className={classNames(global.c_modal_close, global.static)} onClick={onClose}>
							<svg
								width="24"
								height="24"
								viewBox="0 0 24 24"
								fill="none"
								xmlns="http://www.w3.org/2000/svg"
							>
								<path
									d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12L19 6.41Z"
									fill="#919094"
								/>
							</svg>
						</div>
					</div>
          <div className={classNames(global.c_modal_body, styles.bg_gray, global.modal_table)}>
              <div className={styles.modal}>
                <div className={styles.modal_wrap}>
                  <div className={styles.modal_box}>
                    <h3 className={classNames(global.h3, 'mb-3')}><I18n text='Application'/> №{application.id}</h3>
                    <div className={styles.modal_block}>
                      <div className={styles.modal_item}>
                        <div className={styles.modal_row}>
                          <div className={global.semi}><I18n text='General'/></div>
                        </div>
                        <div className={styles.modal_row}>
                          <div className={classNames(global.font_14, global.gray_color)}><I18n text='Status'/></div>
                          <div><I18n text={application?.status || ''}/></div> 
                        </div>
                        <div className={styles.modal_row}>
                          <div className={classNames(global.font_14, global.gray_color)}><I18n text='Last status change date' /></div>
                          <div>{application?.status_updated_at || '-'}</div> 
                        </div>
                        <div className={styles.modal_row}>
                          <div className={classNames(global.font_14, global.gray_color)}><I18n text='Issue date' /></div>
                          <div>{application?.created_at || ''}</div> 
                        </div>
                        <div className={styles.modal_row}>
                          <div className={classNames(global.font_14, global.gray_color)}><I18n text='Type' /></div>
                          <div><I18n text={'Commercial'}/></div> 
                        </div>
                      </div>
                      <PlaceAddress data={application?.apply_info?.place_of_installation?.place} />
                    </div>
                  </div>
                  <div className={styles.modal_box}>
                    <h3 className={classNames(global.h3, 'mb-3')}><I18n text='System design'/></h3>
                    <div className={styles.modal_block}>
                      <SolutionsBody data={{
                        choose_solutions: 'Choose yourself',
                        cart: application?.apply_engineer?.system_design?.solutions || {}}} />
                    </div>
                    <br/>
                    <div className={styles.modal_block}>
                      <SystemPrice data={application?.apply_engineer?.system_design?.system_price || {}} currency={application?.apply_engineer?.currency} />
                      <InstallationDetails data={application?.apply_engineer?.system_design?.installation_details || {}} />
                    </div>
                  </div>
                  <div className={styles.modal_box}>
                    <h3 className={classNames(global.h3, 'mb-3')}><I18n text='Economy month by month'/></h3>
                    
                    <div className={styles.modal_block}>
                      <ElectricityProduction data={application?.apply_engineer?.financial_information?.economy_month_by_month || {}} currency={application?.apply_engineer?.currency} />
                      <Incentive 
                        data={application?.apply_engineer?.financial_information?.incentive || {}} 
                        system_price={application?.apply_engineer?.system_design?.system_price || {}} 
                        currency={application?.apply_engineer?.currency} 
                      />
                      <FinancingOption data={application?.apply_engineer?.financial_information?.financing_option || {}} currency={application?.apply_engineer?.currency} />
                    </div>
                  </div>
                  <div className={styles.modal_box}>
                    <h3 className={classNames(global.h3, 'mb-3')}><I18n text='Proposal'/></h3>
                    <UploadField
                        name={'file'}
                        label={<I18n text='Upload proposal' />}
                        // required
                        value={application?.apply_engineer?.proposal?.file}
                        onChange={(v) => {
                          onSaveFile(v)
                        }}
                      />
                  </div>
                  <div className={styles.modal_box}>
                    <h3 className={classNames(global.h3, 'mb-3')}><I18n text='Comment'/></h3>
                    <p>{application?.apply_engineer?.comment}</p>
                  </div>
                </div>
              </div>
          </div>
          <div className={global.c_modal_footer}>
						{!hideActions && <div className={classNames(global.c_modal_nav, "justify-content-end")}>
              <div className={classNames(global.btns, global.btns_blue, global.btns_transparent, global.w_50)} onClick={onClose}><I18n text='Continue edit' /></div>
              <div className={classNames(global.btns, global.btns_blue, global.w_50)} onClick={onSave}><I18n text='Submit' /></div>
						</div>}
					</div>
      </div>
      
    </Modal>
  )
}

export default ResultModal