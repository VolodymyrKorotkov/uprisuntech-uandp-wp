import React, { useCallback, useEffect, useState } from 'react'
import styles from './UploadField.module.scss'
import { useDropzone } from 'react-dropzone';
import axios from 'axios'
import I18n from '../I18n/I18n';
import Spinner from '../Spinner/Spinner';


const domain = process.env.REACT_APP_BUILD == 'true' ? '' : 'http://ndp.loc';

function UploadField({label = '', isXls, isPresentation, onChange = () => {}, value, disabled, maxSize = 26214400, setSizeFile = () => {}}) {
  const [error, setError] = useState('');
  const [size, setSize] = useState(0);
  const [loaded, setLoaded] = useState(true)

  useEffect(() => {
    if(value){
        axios.head(value).then((response) => {
          const fileSize = response.headers['content-length'];
          console.log("🚀 ~ axios.head ~ fileSize:", fileSize, Math.round(40949*100/1048576)/100)
          setSizeFile(fileSize)
          setSize(Math.round(40949*100/1048576)/100)
        }).catch(error => '')
    }
  }, [value])

  const uploadFile = async (file) => {
    console.log("🚀 ~ file: UploadField.jsx:31 ~ uploadFile ~ file:", file)
    try {
      setError('');
      let types = ['application/pdf'];
      if(isXls){
        types.push('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        types.push('application/vnd.ms-excel');
      }

      if(isPresentation) {
        [
          'application/vnd.ms-powerpoint',
          'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
          'application/vnd.openxmlformats-officedocument.presentationml.presentation'
        ].forEach(type => types.push(type))
      }

      if(!types.includes(file.type)){
        setError('Invalid file format');
        return;
      }

      if(maxSize <= file.size){
        setError('The file is too large');
        return;
      }

      const form = new FormData();
      form.append('file', file);
      setLoaded(false)
      const {data} = await axios.post(domain + '/upload.php', form);
      setLoaded(true)
      if(data.path){
        const url = (domain || window.location.origin) + '/' + data.path;
        onChange(url);
      } else {
        setError('Upload failed, please try again')
      }
    } catch (error) {
      setError('Upload failed, please try again')
      setLoaded(true)
    }
  }


  const onChangeFile = (e) => {
    try {
      uploadFile(e.target.files[0])
    } catch (error) {
      console.log("🚀 ~ file: UploadField.jsx:55 ~ onChangeFile ~ error:", error)

    }
  }


  const onDrop = (acceptedFiles) => {
    uploadFile(acceptedFiles[0]);
  };

  const { getRootProps, getInputProps } = useDropzone({ onDrop });

  return (
    <div className={styles.UploadField}>
      <div className={styles.label}>{label}</div>
      <div style={{position: 'relative'}}>
        {disabled && <div className={styles.disabled} />}
        {value && <div className={styles.file}>
          <div className={styles.header}>
            <div className={styles.title}>{value.split('/').pop()}</div>
            <div className={styles.icon} onClick={() => {
              setSizeFile(0);
              onChange('');
            }}>
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path fillRule="evenodd" clipRule="evenodd" d="M15 3V4H20V6H19V19C19 20.1 18.1 21 17 21H7C5.9 21 5 20.1 5 19V6H4V4H9V3H15ZM7 19H17V6H7V19ZM9 8H11V17H9V8ZM15 8H13V17H15V8Z" fill="#45464F"/>
              </svg>
            </div>
          </div>
          {size > 0 && <div className={styles.size}>{size}MB</div>}
          <label className={styles.action}>
            <input type='file' style={{display: 'none'}} onChange={onChangeFile} />
            <I18n text='Replace'/>
          </label>
        </div>}


        {!value && <div {...getRootProps()}  className={styles.dropzone}>
          {!loaded && <div className={styles.spinner}>
            <Spinner />
          </div>}
          <input {...getInputProps()}/>
          <div className={styles.icon}>
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
              <path d="M6.66675 13.3333L10.0001 10M10.0001 10L13.3334 13.3333M10.0001 10V17.5M16.6667 13.9524C17.6847 13.1117 18.3334 11.8399 18.3334 10.4167C18.3334 7.88536 16.2814 5.83333 13.7501 5.83333C13.568 5.83333 13.3976 5.73833 13.3052 5.58145C12.2185 3.73736 10.2121 2.5 7.91675 2.5C4.46497 2.5 1.66675 5.29822 1.66675 8.75C1.66675 10.4718 2.36295 12.0309 3.48921 13.1613" stroke="#2A59BD" strokeWidth="1.66667" strokeLinecap="round" strokeLinejoin="round"/>
            </svg>
          </div>
          <div className={styles.text}><span><I18n text='Click to upload' /></span> <I18n text='or drag and drop' /></div>
          <div className={styles.text2}><I18n text={isXls ? 'pdf, xlsx, xls (max. 25Mb)' : isPresentation ? 'pdf or pptx (max. 25Mb)' : 'PDF only (max. 25Mb)'}/></div>
        </div>}
        {Boolean(error) && <div className={styles.error}><I18n text={error}/></div>}
      </div>
    </div>
  )
}

export default UploadField
