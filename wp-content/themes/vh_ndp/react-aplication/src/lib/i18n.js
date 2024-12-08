import React, { useState } from 'react'

function i18n({text}) {
  const [lang, setLang] = useState('en');


  return text || null
}

export default i18n