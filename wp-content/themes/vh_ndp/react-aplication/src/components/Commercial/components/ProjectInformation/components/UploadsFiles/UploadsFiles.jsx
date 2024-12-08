import { useState } from 'react'
import UploadField from '../../../../../UploadField/UploadField'
import I18n from '../../../../../I18n/I18n'

function UploadsFiles({data = {}, onSave = () => {}, formContext}) {

  const [size, setSize] = useState([]);

  const onChangeFile = (v, index) => {
    let files = data?.files || [];
    if(index == -1){
      files.push(v);
    } else {
      if(v){
        files[index] = v
      } else {
        files = files.filter((_i, i) => i != index)
      }
    }
    onSave({...data, files})
    formContext?.setValue('files', files)
  }

  let sum = 0;
  size.forEach(_i => {
    if(_i && !isNaN(parseInt(_i)) && parseInt(_i) > 0){
      sum +=  parseInt(_i);
    }
  });

  console.log("🚀 ~ UploadsFiles ~ sum:", 26214400, sum, size)
  return (
    <>
      <div className='row'>
        <div className='col-md-12'>
          {(data?.files || []).map((_i, index) =>
            <UploadField
              isXls
              isPresentation
              name={'file'}
              label={index == 0 ? <I18n text='Project files' /> : ''}
              // required
              setSizeFile={(v) => {
                const tmp = [...size]
                tmp[index] = v;
                setSize(tmp)
              }}
              maxSize={26214400-sum}
              disabled={!Boolean(data.project_type) || Boolean(data.project_type == 'Solar energy')}
              value={_i}
              onChange={v => onChangeFile(v, index)}
            />
          )}
          <UploadField
              maxSize={26214400-sum}
              isXls
              isPresentation
              name={'file'}
              label={(data?.files || []).length == 0 ? <I18n text='Project files' /> : ''}
              // required
              disabled={!Boolean(data.project_type) || Boolean(data.project_type == 'Solar energy')}
              value={''}
              onChange={(v) => onChangeFile(v, -1)}
            />
          <p style={{color: '#8A90A5', fontSize: 14}}><I18n text="Files with additional information about the project (feasibility study, business plan, presentation materials, energy auditor's report, etc." /></p>
        </div>
      </div>
    </>
  )
}

export default UploadsFiles
