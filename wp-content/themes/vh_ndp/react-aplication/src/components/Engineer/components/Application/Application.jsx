import React from 'react'
import I18n from '../../../I18n/I18n'
import global from '../../../../App.module.scss'
import GeneralInfo from './components/GeneralInfo/GeneralInfo'
import Place from './components/Place/Place'
import ResourcesUsage from './components/ResourcesUsage/ResourcesUsage'
import WishSolutions from './components/WishSolutions/WishSolutions'
import { IconButton } from '@mui/material'
import ProjectType from './components/ProjectType/ProjectType'
import Contact from './components/Contact/Contact'
import ProjectDescription from "./components/ProjectDescription/ProjectDescription";
import FinancialIndicators from "./components/FinancialIndicators/FinancialIndicators";

function Application({application = {}, isOtherProjectType}) {

  return (
    <div>
      <div className={global.header_title}>
        <div className={global.title}>
          <IconButton onClick={() => {
            window.location.href = '/dashboard/requests/'
          }}>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path d="M15.705 7.41L14.295 6L8.295 12L14.295 18L15.705 16.59L11.125 12L15.705 7.41Z" fill="#2A59BD"/>
            </svg>
          </IconButton> <I18n text={'Application'} /> №{application.id} </div>
        <div className={global.text}>

        </div>
      </div>
      <ProjectType data={application?.apply_info?.project_information || {}} />
      <GeneralInfo application={application} />
      {isOtherProjectType && <ProjectDescription data={application?.apply_info?.project_description || {}}/>}
      {!isOtherProjectType && <Place data={application?.apply_info?.place_of_installation?.place || {}} />}
      <ResourcesUsage data={application?.apply_info?.resources_usage || {}} isOtherProjectType={isOtherProjectType} />
      {isOtherProjectType && <FinancialIndicators data={application?.apply_info?.financial_indicators || {}}/>}
      <Contact data={application?.apply_info?.contact || {}} />
      {!isOtherProjectType && <WishSolutions data={application?.apply_info?.solutions || {}} />}
    </div>
  )
}

export default Application
