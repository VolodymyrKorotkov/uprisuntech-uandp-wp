import { t } from '../../../I18n/I18n'
import * as yup from 'yup'

function convertToMinutes(time) {
  var parts = time.split(":");
  return parseInt(parts[0], 10) * 60 + parseInt(parts[1], 10);
}

export const organizationsSchemas = {
  about: yup.object({
    company_name: yup.string().trim().required(t('This field is required')),
    organizational_form: yup.string().trim().required(t('This field is required')),
    registration_number: yup
      .string()
      .trim()
      .min(8, t('Field length 8 digits'))
      .max(8, t('Field length 8 digits'))
      .required(t('This field is required'))
      .when('organizational_form', {
        is: (val) => val === 'Individual entrepreneur',
        then: (schema) => schema
          .min(10, t('Field length 10 digits'))
          .max(10, t('Field length 10 digits')),
      }),
    type: yup.string().trim().required(t('This field is required')),
    field_of_activities: yup.string().trim().required(t('This field is required')),
    type_of_organizations_activities: yup.string().trim().required(t('This field is required')),
    phone: yup.string()
      .required(t('This field is required'))
      .matches(/^\+38\(0\d{2}\) \d{3} \d{2} \d{2}$/, t('Invalid phone number format +38(099) 999 99 99')),
    email: yup.string()
      .matches(/^(?!.*@(?:.*\.ru|.*\.рф))[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/, t('Invalid email format or restricted domain'))
      .required(t('This field is required')),
    position: yup.string().trim().required(t('This field is required')),
  }),
  operating_mode: yup.object({
    hours: yup.number()
      .transform(value => (isNaN(value) ? undefined : value))
      .required(t('This field is required'))
      .min(0, t('Value must be between ') + String(0) + t(' and ') + String(24))
      .max(24, t('Value must be between ') + String(0) + t(' and ') + String(24))
      .when(['time_from', 'time_to'], {
        is: (time_from, time_to) => !!time_to && !!time_from,
        then: schema => schema.optional()
      }),
    time_from: yup.string().trim()
      .test('time_range',  t('Incorrect time entered'),  (val, ctx) =>
        !val || convertToMinutes(val) < convertToMinutes(ctx.parent.time_to))
      .test('time_dependency', t('This field is required'), (val, ctx) => {
        return !!ctx.parent.hours || (!!val && !ctx.parent.hours)
      }),
    time_to: yup.string().trim()
      .test('time_range',  t('Incorrect time entered'),  (val, ctx) =>
        !val || convertToMinutes(ctx.parent.time_from) < convertToMinutes(val))
      .test('time_dependency', t('This field is required'), (val, ctx) => {
        return !!ctx.parent.hours || (!!val && !ctx.parent.hours)
      }),
    monday: yup.boolean(),
    tuesday: yup.boolean(),
    wednesday: yup.boolean(),
    thursday: yup.boolean(),
    friday: yup.boolean(),
    saturday: yup.boolean(),
    sunday: yup.boolean(),
  }).test('at-least-one-day-selected', (value, ctx) => {
    const { monday, tuesday, wednesday, thursday, friday, saturday, sunday } = value;
    if (!monday && !tuesday && !wednesday && !thursday && !friday && !saturday && !sunday) {
      throw ctx.createError({
        message: t('Choose at least one working day'),
        path: 'monday'
      });
    }
    return true;
  }),
  legal_address: yup.object({
    property_type: yup.string().trim().required(t('This field is required')),
    state: yup.string().trim().required(t('This field is required')),
    city: yup.string().trim().required(t('This field is required')),
    street: yup.string().trim().required(t('This field is required')),
    street_number: yup.string().trim().required(t('This field is required')),
    postal_code: yup.string().trim().required(t('This field is required')),
  }),
}
