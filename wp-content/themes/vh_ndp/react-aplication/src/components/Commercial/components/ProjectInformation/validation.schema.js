import { t } from '../../../I18n/I18n'
import * as yup from 'yup'

export const projectInfoSchema = yup.object({
  project_type: yup.string().required(t('This field is required')),
});
