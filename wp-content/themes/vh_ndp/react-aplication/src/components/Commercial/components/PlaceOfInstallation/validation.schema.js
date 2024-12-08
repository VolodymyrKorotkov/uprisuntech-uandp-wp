import { t } from '../../../I18n/I18n'
import * as yup from 'yup'

export const placeOfInstallationSchemas = {
  place: yup.object({
    property_type: yup.string().trim().required(t('This field is required')),
    state: yup.string().trim().required(t('This field is required')),
    city: yup.string().trim().required(t('This field is required')),
    street: yup.string().trim().required(t('This field is required')),
    street_number: yup.string().trim().required(t('This field is required')),
    postal_code: yup.string().trim().required(t('This field is required')),
  }),
  building_information: yup.object({
    year_of_construction: yup.number()
      .transform(value => (isNaN(value) ? undefined : value))
      .min(1000,  t('Value must be between ') + String(1000) + t(' and ') + String(2024))
      .max(2024, t('Value must be between ') + String(1000) + t(' and ') + String(2024)),
  })
}
