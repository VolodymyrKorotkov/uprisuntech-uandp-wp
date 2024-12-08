import React, {forwardRef} from 'react';
import {NumericFormat} from 'react-number-format';
import {TextFieldElement} from 'react-hook-form-mui';


const NumberInput = forwardRef((props, ref) => {
  return (
    <NumericFormat getInputRef={ref} {...props} />
  );
})

export const NumberField = forwardRef(({options, ...props}, ref) => (
  <TextFieldElement
    ref={ref}
    {...props}
    InputProps={{
      inputComponent: NumberInput,
      inputProps: {
        decimalScale: 0,
        allowNegative: false,
        isAllowed: (values) => {

          const { floatValue, value } = values;

          if(!options?.min && !options?.max) {
            return true
          }

          const lessMin = !!options?.min ? floatValue >= options.min : true
          const moreMax = !!options?.max ? floatValue <= options.max : true

          return (value.length < (!!options?.min ? (String(options.min).length) : 0)) || (moreMax && lessMin);
        },
        ...options
      },
      ...props.InputProps
    }}
  />
));


export const CurrencyField = ({ options = {}, ...rest }) => <NumberField
  {...rest}
  options={{
    allowNegative: false,
    decimalSeparator: ',',
    thousandSeparator: ' ',
    decimalScale: 2,
    ...options,
  }}
/>
