import React from 'react'
import global from '../../../../App.module.scss'
import I18n from '../../../I18n/I18n'
import {projectType} from "../../../../lib/utils";

function ListProjectInformation({data = {}}) {
  return (
    <>
      <div className={global.block_text}>
        <span><I18n text='Project type'/></span>
        <div><I18n text={projectType(data?.project_type) || '-'}/></div>
      </div>

      {
        data.project_type === 'Other' && (
          <div className={global.block_text}>
            <span style={{alignSelf: 'flex-start'}}><I18n text='Project files'/></span>
              <div>
                  {data?.files && data?.files.length > 0 && data?.files.map(_i => <p style={{margin: 0}}><a href={_i} target='_blank'>{_i.split('/').pop()}</a></p>) || '-'}
              </div>
          </div>)
        }
    </>
  )
}

export default ListProjectInformation
