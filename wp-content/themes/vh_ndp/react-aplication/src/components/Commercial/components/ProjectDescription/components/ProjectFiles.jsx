import { useState } from 'react'
import UploadField from '../../../../UploadField/UploadField'
import I18n from '../../../../I18n/I18n'

function ProjectFiles({ data = {}, onSave = () => {}, formContext, name='file', helperText, acceptPresentations }) {
  const [size, setSize] = useState([]);

  const onChangeFile = (v, index) => {
    let files = data[name] || [];
    if(index == -1){
      files.push(v);
    } else {
      if(v){
        files[index] = v
      } else {
        files = files.filter((_i, i) => i != index)
      }
    }
    formContext?.setValue(name, files)
    onSave({...data, [name]: files})
  }

  let sum = 0;
  size.forEach(_i => {
    if(_i && _i > 0){
      sum += _i;
    }
  });

  return (
    <>
      <div className='row'>
        <div className='col-md-12'>
          {(data[name] || []).map((_i, index) =>
            <UploadField
              isPresentation={acceptPresentations}
              name={name}
              label={index == 0 ? <I18n text='Project files' /> : ''}
              setSizeFile={(v) => {
                const tmp = [...size]
                tmp[index] = v;
                setSize(tmp)
              }}
              maxSize={26214400-sum}
              value={_i}
              onChange={v => onChangeFile(v, index)}
            />
          )}
          <UploadField
              isPresentation={acceptPresentations}
              maxSize={26214400-sum}
              name={name}
              value={''}
              onChange={(v) => onChangeFile(v, -1)}
            />
          {!!helperText && <p style={{color: '#8A90A5', fontSize: 14}}>{helperText}</p>}
        </div>
      </div>
    </>
  )
}

export default ProjectFiles
