import global from '../../../../App.module.scss'
import I18n from '../../../I18n/I18n'
import { Organization, Project, LegalAddress } from "./sections";

const ProjectDescription = ({forseShowList, data, onSave}) => (
  <div>
    <div className={global.header_title}>
      <div className={global.title}><I18n text='Project description'/></div>
      <div className={global.text}>
        {!forseShowList && <I18n text='* Required sections must be filled in'/>}
      </div>
    </div>
    <Organization forseShowList={forseShowList} data={data?.organization || {}} onSave={v => {
      onSave({...data, organization: v})
    }}/>
    <LegalAddress forseShowList={forseShowList} data={data?.legal_address || {}} onSave={v => {
      onSave({...data, legal_address: v})
    }}/>
    <Project forseShowList={forseShowList} data={data?.project || {}} onSave={v => {
      onSave({...data, project: v})
    }}/>
  </div>
)

export default ProjectDescription
