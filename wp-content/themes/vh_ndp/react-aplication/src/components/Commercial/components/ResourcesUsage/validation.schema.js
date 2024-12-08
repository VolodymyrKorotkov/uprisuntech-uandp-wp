import { t } from '../../../I18n/I18n'
import * as yup from 'yup'

const getMonthFieldRules = () => {
  return yup.string().trim().when('period_for_which_we_enter_data', {
    is: val => val === 'Monthly estimate (1-12 month)',
    then: schema => schema.required(t('This field is required'))
  })
}

const monthlyEstimate = {
  january_day: getMonthFieldRules(),
  february_day: getMonthFieldRules(),
  march_day: getMonthFieldRules(),
  april_day: getMonthFieldRules(),
  may_day: getMonthFieldRules(),
  june_day: getMonthFieldRules(),
  july_day: getMonthFieldRules(),
  august_day: getMonthFieldRules(),
  september_day: getMonthFieldRules(),
  october_day: getMonthFieldRules(),
  november_day: getMonthFieldRules(),
  december_day: getMonthFieldRules(),
}

export const resourcesUsageSchemas = {
  base_year:  yup.object({
    base_year: yup
      .number()
      .transform(value => (isNaN(value) ? undefined : value))
      .required(t('This field is required'))
      .min(new Date().getFullYear() - 6,  t('Value must be between ') + String(new Date().getFullYear() - 6) + t(' and ') + String(new Date().getFullYear() - 1))
      .max(new Date().getFullYear() - 1, t('Value must be between ') + String(new Date().getFullYear() - 6) + t(' and ') + String(new Date().getFullYear() - 1)),
  }),
  electricity_usage: yup.object({
    period_for_which_we_enter_data: yup.string().trim().required(t('This field is required')),
    monthly_electricity_consumption: yup.string().trim().when('period_for_which_we_enter_data', {
      is: val => val !== 'Monthly estimate (1-12 month)',
      then: schema => schema.required(t('This field is required'))
    }),
    ...monthlyEstimate
  }),
  gas_usage: yup.object(monthlyEstimate),
  hot_water_usage: yup.object(monthlyEstimate),
  heating_usage: yup.object(monthlyEstimate),
  environment: (isOtherProjectType) => {
    if(!isOtherProjectType) {
      return yup.object({
        energy_consumption_level: yup
          .number()
          .transform(value => (isNaN(value) ? undefined : value))
          .required(t('This field is required'))
          .min(15, t('Value must be between ') + String(15) + t(' and ') + String(99))
          .max(99, t('Value must be between ') + String(15) + t(' and ') + String(99)),
        planned_reductions: yup
          .number()
          .transform(value => (isNaN(value) ? undefined : value))
          .required(t('This field is required'))
          .min(20, t('Value must be between ') + String(20) + t(' and ') + String(99))
          .max(99, t('Value must be between ') + String(20) + t(' and ') + String(99)),
      })
    }

    return yup.object({})
  }
}
