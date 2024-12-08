import { t } from '../../../I18n/I18n'
import * as yup from 'yup'

export const contactSchema = yup.object({
  phone: yup.string()
    .required(t('This field is required'))
    .matches(/^\+38\(0\d{2}\) \d{3} \d{2} \d{2}$/, t('Invalid phone number format +38(099) 999 99 99')),
});
