import { LocalizationProvider } from '@mui/x-date-pickers';
import { useController } from 'react-hook-form';
import dayjs from 'dayjs';
import { DemoContainer } from '@mui/x-date-pickers/internals/demo';
import { AdapterDayjs } from '@mui/x-date-pickers/AdapterDayjs';
import { TimeField } from '@mui/x-date-pickers/TimeField';

function TimeFieldCustom({name, control, label, rules, onChange = () => {}, type}) {
  const {
    field: { ref, ...inputProps },
    fieldState: { invalid, error },
  } = useController({
    name,
    control,
    rules,
  });

  return <LocalizationProvider dateAdapter={AdapterDayjs} localeText={{
    fieldHoursPlaceholder: () => '--',
    fieldMinutesPlaceholder: () => '--',
  }}>
    <DemoContainer components={['TimeField']}>
      <TimeField
        fullWidth
        label={label}
        defaultValue={inputProps?.value && dayjs('2022-04-17T' + inputProps.value).isValid() ? dayjs('2022-04-17T' + inputProps.value) : null}
        value={inputProps?.value && dayjs('2022-04-17T' + inputProps.value).isValid() ? dayjs('2022-04-17T' + inputProps.value) : null}
        onChange={(e) => {
          if(e && e.isValid()){
            inputProps.onChange(e.format('HH:mm')  )
            onChange(e.format('HH:mm'))
          } else {
            inputProps.onChange('')
            onChange('')
          }

        }}
        error={invalid}
        format="HH:mm"
        helperText={invalid && error?.message}
        FormHelperTextProps={{
          error: invalid
        }}

      />
    </DemoContainer>
</LocalizationProvider>
}

export default TimeFieldCustom
