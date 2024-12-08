import classNames from 'classnames'
import React from 'react'
import I18n from '../../../../../I18n/I18n'
import styles from '../../ResultModal.module.scss'
import global from '../../../../../../App.module.scss'
import {projectType} from "../../../../../../lib/utils";

function ProjectInformation({data = {}}) {
  return (
    <div className={styles.modal_box}>
      <h3 className={classNames(global.h3, 'mb-3')}><I18n text={'Project type'} /></h3>
      <div className={styles.modal_block}>
        <div className={styles.modal_item}>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text={'Project type'}/></div>
            <div><I18n text={projectType(data?.project_type) || ''}/></div>
          </div>

          {
            data?.project_type === 'Other' && (
                  <div className={styles.modal_row}>
                    <div style={{alignSelf: 'flex-start'}} className={classNames(global.font_14, global.gray_color)}><I18n
                        text={'Project files'}/></div>
                    <div>
                      {data?.files && data?.files.length > 0 && data?.files.map(_i => <p style={{margin: 0}}><a href={_i}
                                                                                                                target='_blank'>{_i.split('/').pop()}</a>
                      </p>) || '-'}</div>
                  </div>
              )
          }

        </div>
      </div>
    </div>
  )
}

export default ProjectInformation
