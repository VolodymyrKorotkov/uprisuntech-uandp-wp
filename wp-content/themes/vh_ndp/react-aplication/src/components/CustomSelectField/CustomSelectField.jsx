import React from 'react'
import { useController } from 'react-hook-form';
import TextField from '@mui/material/TextField';
import Autocomplete, { createFilterOptions } from '@mui/material/Autocomplete';
import { useEffect } from 'react';
import I18n from '../I18n/I18n';

const filter = createFilterOptions();

function CustomSelectField({name, control, label, rules, onChange, options=[]}) {
  console.log("🚀 ~ file: CustomSelectField.jsx:136 ~ CustomSelectField ~ options:", options)
  const [value, setValue] = React.useState(null);
  console.log("🚀 ~ file: CustomSelectField.jsx:12 ~ CustomSelectField ~ value:", value)
  const {
    field: { ref, ...inputProps },
    fieldState: { invalid, error },
  } = useController({
    name,
    control,
    rules,
  });

  useEffect(() => {
    if(inputProps?.value){
      const find = options.find(_i => _i.id == inputProps.value);
      console.log("🚀 ~ file: CustomSelectField.jsx:25 ~ useEffect ~ find:", find)
      if(find){
        setValue(find);
      } else {
        setValue({id: inputProps.value, title: inputProps.value});
      }
    } else {
      setValue(null)
    }
  }, [inputProps.value])



  return (
    <Autocomplete
      value={value}
      onChange={(event, newValue) => {
        if (typeof newValue === 'string') {
          setValue({
            id: newValue,
          });
          onChange(newValue)
          // inputProps.onChange(newValue)
        } else if (newValue && newValue.inputValue) {
          // Create a new value from the user input
          setValue({
            id: newValue.inputValue,
          });
          onChange(newValue.inputValue)
          // inputProps.onChange(newValue.inputValue)
        } else {
          setValue(newValue);
          onChange(newValue?.id || '')
          inputProps.onChange(newValue?.id || '')
        }
      }}
      filterOptions={(options, params) => {
        const filtered = filter(options, params);

        const { inputValue } = params;
        // Suggest the creation of a new value
        const isExisting = options.some((option) => inputValue === option.id);
        if (inputValue !== '' && !isExisting) {
          filtered.push({
            id: inputValue,
            title: inputValue,
          });
        }

        return filtered;
      }}
      selectOnFocus
      clearOnBlur
      handleHomeEndKeys
      options={options}
      getOptionLabel={(option) => {
        // Value selected with enter, right from the input
        if (typeof option === 'string') {
          return option;
        }
        // Add "xxx" option created dynamically
        if (option.inputValue) {
          return option.inputValue;
        }
        // Regular option
        return option.id;
      }}
      renderOption={(props, option) => <li {...props}>{option.title}</li>}
      freeSolo
      renderInput={(params) => (
        <TextField {...params} label={label} />
      )}
    />
  )
}

export default CustomSelectField