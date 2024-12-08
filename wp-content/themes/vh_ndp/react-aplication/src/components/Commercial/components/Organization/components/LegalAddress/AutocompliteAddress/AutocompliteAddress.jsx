import React, { useState } from 'react'
import { AutocompleteElement } from 'react-hook-form-mui'
import { getAddress2 } from '../../../../../../../lib/getPoint';

function AutocompliteAddress() {
  const [options, setOptions] = useState([]);
  return (
    <AutocompleteElement
      options={options}
      name='search_on_map'
      required
      textFieldProps={{
        onChange: (e, value) => {
          getAddress2(e.target.value).then(res => {
            console.log("🚀 ~ file: AutocompliteAddress.jsx:16 ~ getAddress2 ~ res:", res)
            
          })
        },
        value: 'test'
      }}
      onChange={(e, value) => {
        console.log("🚀 ~ file: LegalAddress.jsx:77 ~ LegalAddress ~ value:", value)
        console.log("🚀 ~ file: LegalAddress.jsx:77 ~ LegalAddress ~ e:", e)
        
        
      }}
    />
  )
}

export default AutocompliteAddress