import React from 'react'
import global from '../../../../../../App.module.scss'
import I18n from '../../../../../I18n/I18n'
import {projectType} from "../../../../../../lib/utils";

function ProjectType({data = {}}) {
  return (
    <div className={global.card}>
      <div className={global.header}>
        <div className={global.row}>
          <div className={global.title}><I18n text={'Project type'} /></div>
        </div>
      </div>
      <div className={global.body}>
        <div className={global.block_text}>
          <span><I18n text='Project type'/></span>
          <div><I18n text={projectType(data?.project_type) || '-'}/></div>
        </div>
        {/* <div className={global.block_text} style={{alignItems: 'flex-start'}}>
          <span style={{minWidth: 135}}><I18n text='Project description' /></span>
          <div>{data?.description || '-'}</div>
        </div> */}
        <div className={global.block_text}>
          <span style={{alignSelf: 'flex-start'}}><I18n text='Project files' /></span>
          
          <div>
            {data?.files && data?.files.length > 0 && data?.files.map(_i => <p style={{margin: 0}}><a href={_i} target='_blank'>{_i.split('/').pop()}</a></p>) || '-'}
            {/* {data?.file && <a href={data.file} target='_blank'>{data.file.split('/').pop()}</a> || '-'} */}
          </div>
        </div>
      </div>
    </div>
  )
}

export default ProjectType
