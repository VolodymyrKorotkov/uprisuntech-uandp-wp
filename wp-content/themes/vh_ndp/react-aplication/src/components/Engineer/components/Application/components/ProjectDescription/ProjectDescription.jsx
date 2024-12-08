import React from 'react'
import global from '../../../../../../App.module.scss'
import I18n from '../../../../../I18n/I18n'
import OrganizationSummary from "../../../../../Commercial/components/ProjectDescription/summary/OrganizationSummary";
import AddressSummary from "../../../../../Commercial/components/ProjectDescription/summary/AddressSummary";
import ProjectSummary from "../../../../../Commercial/components/ProjectDescription/summary/ProjectSummary";

function ProjectDescription({data = {}}) {
  return (
    <div className={global.card}>
      <div className={global.header}>
        <div className={global.row}>
          <div className={global.title}><I18n text={'Project description'} /></div>
        </div>
      </div>
      <div className={global.body}>
        <div className={global.block_text}>
          <strong><I18n text={'Organization'} /></strong>
        </div>
        <div className={global.block_text}/>
        <OrganizationSummary data={data?.organization || {}} />
      </div>
      <div className={global.body}>
        <div className={global.block_text}>
          <strong><I18n text={'Legal address of the object'} /></strong>
        </div>
        <div className={global.block_text}/>
        <AddressSummary data={data?.legal_address || {}} />
      </div>
      <div className={global.body}>
        <div className={global.block_text}>
          <strong><I18n text={'Project'} /></strong>
        </div>
        <div className={global.block_text}/>
        <ProjectSummary data={data?.project || {}} />
      </div>
    </div>
  )
}

export default ProjectDescription
