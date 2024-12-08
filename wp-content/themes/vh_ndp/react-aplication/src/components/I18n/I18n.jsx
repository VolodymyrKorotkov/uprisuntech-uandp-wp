import React, { useEffect, useState } from 'react'
import translate from './translate';

function I18n({text}) {
  const [lang, setLang] = useState('ua');
  useEffect(() => {
    if(window.location.pathname.indexOf('/en/') > -1){
      setLang('en')
    }
  }, [])


  return <>{translate[lang] && translate[lang][text] || text }</>
}

export const t = (text) => {
  const lang = window.location.pathname.indexOf('/en/') > -1 ? 'en' : 'ua'

  return translate[lang] && translate[lang][text] || text
}

export default I18n

