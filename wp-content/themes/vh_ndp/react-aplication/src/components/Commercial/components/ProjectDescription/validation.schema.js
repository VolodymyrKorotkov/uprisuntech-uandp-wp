import { t } from '../../../I18n/I18n'
import * as yup from 'yup'

const getPercentValidation = (conditionField, min, max) => {
  return yup
    .number()
    .transform(value => (isNaN(value) ? undefined : value))
    .when(conditionField, {
      is: (val) => val === 'Yes',
      then: (schema) => schema
        .required(t('This field is required'))
        .min(min, t('Value must be between ') + String(min) + t(' and ') + String(max))
        .max(max, t('Value must be between ') + String(min) + t(' and ') + String(max)),
    })
}

export const projectDescriptionSchemas = {
  organization: yup.object({
    office_availability: yup.string().trim().required(t('This field is required')),
    issuing_name: yup.string().trim().required(t('This field is required')),
    organization_name: yup.string().trim().required(t('This field is required')),
    edrpou_code: yup
      .string()
      .trim()
      .min(8, t('Field length 8 digits'))
      .max(8, t('Field length 8 digits'))
      .required(t('This field is required'))
      .when('organization_form', {
      is: (val) => val === 'Individual entrepreneur',
      then: (schema) => schema
        .min(10, t('Field length 10 digits'))
        .max(10, t('Field length 10 digits')),
    }),
    organization_form: yup.string().trim().required(t('This field is required')),
    comment: yup.string().trim().when('organization_form', {
      is: (val) => val === 'Other',
      then: (schema) => schema.required(t('This field is required')),
    }),
    industry: yup.string().trim().required(t('This field is required')),
  }),
  legal_address: yup.object({
    state: yup.string().trim().required(t('This field is required')),
    city: yup.string().trim().required(t('This field is required')),
    street: yup.string().trim().required(t('This field is required')),
    street_number: yup.string().trim().required(t('This field is required')),
    postal_code: yup.string().trim().required(t('This field is required')),
  }),
  project: yup.object({
    project_name: yup.string().trim().required(t('This field is required')),
    efficiency_project: yup.string().trim().required(t('This field is required')),
    energy_reduction_percent: getPercentValidation('efficiency_project', 15, 99),
    pollutant_reduction_percent: getPercentValidation('efficiency_project', 20, 99),
    alternative_fuels_switching: yup.string().trim().required(t('This field is required')),
    fossil_fuels_substitution_percent: getPercentValidation('alternative_fuels_switching', 50, 99),
    environment_pollutant_reduction_percent: getPercentValidation('alternative_fuels_switching', 20, 99),
    thermal_modernization: yup.string().trim().required(t('This field is required')),
    above_min_requirements: yup.string().trim().when('thermal_modernization', {
      is: val => val === 'Yes',
      then: schema => schema.required(t('This field is required'))
    }),
    other_direction: yup.string().trim().required(t('This field is required')),
    other_direction_indicators: yup.string().trim().when('other_direction', {
      is: val => val === 'Yes',
      then: schema => schema.required(t('This field is required'))
    }),
    project_description: yup.string().trim().required(t('This field is required'))
      .test('word-count', `${t('Max words count')} - 200`, value => {
        const wordCount = value.trim().split(/\s+/).length;
        return wordCount <= 200;
      }),
    audit_availability: yup.string().trim().required(t('This field is required')),
    manager_availability: yup.string().trim().required(t('This field is required')),
    iso_system: yup.string().trim().required(t('This field is required')),
    additional_permits: yup.string().trim().required(t('This field is required')),
    permits_comment: yup.string().trim().when('additional_permits', {
      is: val => val === 'Yes',
      then: schema => schema.required(t('This field is required'))
    }),
    project_sustainability: yup.number()
      .transform(value => (isNaN(value) ? undefined : value))
      .required(t('This field is required'))
      .min(1, t('Value should be no more than ') + '100')
      .max(100, t('Value should be no more than ') + '100'),
    equipment_manufacturer: yup.string().trim().required(t('This field is required')),
  }),
}
