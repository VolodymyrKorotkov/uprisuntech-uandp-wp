import { TextField } from '@mui/material';
import React, { useEffect, useState } from 'react'
import { useController } from 'react-hook-form';
import ReactInputMask from 'react-input-mask';

function PhoneField({name, control, label, rules, onChange}) {
  const [show, setShow] = useState(false);

  useEffect(() => {
    setTimeout(() => {
      setShow(true)
    }, 100);
  }, [])
  
  
  const {
    field: { ref, ...inputProps },
    fieldState: { invalid, error },
  } = useController({
    name,
    control,
    rules,
  });

  if(!show){
    return false;
  }


  return (
    <ReactInputMask
      mask="+38(099) 999 99 99"
      maskChar=""
      {...inputProps}
      defaultValue={inputProps.value}
      value={inputProps.value}
      onChange={(e) => {
        inputProps.onChange(e)
        onChange(e)
      }}
    >
      {() => <TextField 
        variant="outlined" 
        label={label} 
        fullWidth
        required={rules?.required}
        error={invalid}
        helperText={error ? error.message : ''}
      />}
    </ReactInputMask>
  )
}

export default PhoneField