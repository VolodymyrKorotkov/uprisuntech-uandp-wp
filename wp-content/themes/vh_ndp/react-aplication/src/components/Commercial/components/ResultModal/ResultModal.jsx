import React from 'react'
import classNames from "classnames";
import { Modal } from '@mui/material'

import I18n from "../../../I18n/I18n";
import global from '../../../../App.module.scss'
import { CrossIcon } from "../../../Icons/CrossIcon";

import styles from './ResultModal.module.scss'

import ResourcesUsage from "./components/ResourcesUsage/ResourcesUsage";
import Place from "./components/Place/Place";
import SolutionsBody from "./components/SolutionsBody/SolutionsBody";
import ProjectInformation from "./components/ProjectInformation/ProjectInformation";
import Organization from "./components/Organization/Organization";
import Contact from "./components/Contact/Contact";
import FinancialIndicators from "./components/FinancialIndicators/FinancialIndicators";
import ProjectDescription from "./components/ProjectDescription/ProjectDescription";


function ResultModal({ open, onClose = () => {}, data, onSave=() => {}, hideActions, title, isProjectTypeOther }) {
  return (
    <Modal style={{zIndex: 9999999}} className={global.c_modal_flex} open={open} onClose={onClose}>
      <div className={classNames(global.c_modal, global.c_modal_medium)}>
		<div className={global.c_modal_header}>
			<div className={global.h3}><I18n text={title ? title : 'Submit application'} /></div>

			<div className={classNames(global.c_modal_close, global.static)} onClick={onClose}>
				<CrossIcon />
			</div>
		</div>

		  <div className={classNames(global.c_modal_body, styles.bg_gray, global.modal_table)}>
			  <div className={styles.modal}>
				<div className={styles.modal_wrap}>
					<ProjectInformation data={data?.project_information || {}} />

					{ !isProjectTypeOther && <Organization data={data?.organization} /> }

					{ isProjectTypeOther && <ProjectDescription data={data?.project_description} styles={styles}/>  }

					<ResourcesUsage data={data?.resources_usage || {}} isProjectTypeOther={isProjectTypeOther} styles={styles}/>

					{ isProjectTypeOther && <FinancialIndicators data={data?.financial_indicators || {}} styles={styles}/>  }

					{ !isProjectTypeOther && <Place data={data?.place_of_installation || {}} /> }

					<Contact data={data?.contact || {}} />

					{ !isProjectTypeOther && (
						<div className={styles.modal_box} style={{marginBottom: 3}}>
							<h3 className={classNames(global.h3, 'mb-3')}><I18n text={'Solutions'}/></h3>
							<SolutionsBody data={data?.solutions || {}}/>
						</div>
					)}

				</div>
			  </div>
		  </div>

          <div className={global.c_modal_footer}>

              {!hideActions && (
				  <div className={classNames(global.c_modal_nav, "justify-content-end")}>
					  <div
						  className={classNames(global.btns, global.btns_blue, global.btns_transparent, global.w_50)}
						  onClick={onClose}>
						  <I18n text='Continue edit'/>
					  </div>

					  <div
						  className={classNames(global.btns, global.btns_blue, global.w_50)}
						  onClick={onSave}
					  >
						  <I18n text='Submit'/>
					  </div>
				  </div>
			  )}
		  </div>
	  </div>
	</Modal>
  )
}

export default ResultModal
