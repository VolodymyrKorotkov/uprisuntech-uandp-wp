import { TextField } from '@mui/material';
import React from 'react'
import { useController } from 'react-hook-form';

function TextFieldCutom({name, control, label, rules, onChange, type}) {
  const {
    field: { ref, ...inputProps },
    fieldState: { invalid, error },
  } = useController({
    name,
    control,
    rules,
  });
  return (
    <TextField
      {...inputProps}
      variant="outlined" 
      label={label}
      type={type}
      fullWidth 
      required={rules?.required}
      error={invalid}
      helperText={error ? error.message : ''}
      onChange={(e) => {
        inputProps.onChange(e)
        onChange(e)
      }}
    />
  )
}

export default TextFieldCutom