import global from '../../../../App.module.scss'
import About from './components/About/About'
import OperatingMode from './components/OperatingMode/OperatingMode'
import LegalAddress from './components/LegalAddress/LegalAddress'
import I18n from '../../../I18n/I18n'

function Organization({data = {}, onSave, municipalityInfo, forseShowList}) {
  return (
    <div>
      <div className={global.header_title}>
        <div className={global.title}><I18n text={'Organization'} /> </div>
        <div className={global.text}>
          {!forseShowList && <I18n text={'* Required sections must be filled in'} />}
        </div>
      </div>

      <About forseShowList={forseShowList} municipalityInfo={municipalityInfo} data={data?.about || {}} onSave={v => {
        onSave({...data, about: v})
      }} />
      <OperatingMode forseShowList={forseShowList}  data={data?.operating_mode || {}}  onSave={v => {
        onSave({...data, operating_mode: v})
      }}/>
      <LegalAddress  forseShowList={forseShowList}  data={data?.legal_address || {}} onSave={v => {
        onSave({...data, legal_address: v})
      }} />
    </div>
  )
}

export default Organization
