import { t } from '../../../I18n/I18n'
import * as yup from 'yup'

export const financialIndicatorsSchema = yup.object({
  payback_period: yup.string().required(t('This field is required')),
  internal_rate_of_profitability: yup.string().required(t('This field is required')),
  project_cost: yup.string().required(t('This field is required')),
  capital_costs_amount: yup.string().required(t('This field is required')),
  operating_costs_amount: yup.string().required(t('This field is required')),
  planned_project_financing: yup.array().required(t('This field is required')),
  financing_mechanisms: yup.array().required(t('This field is required')),
  project_implementation_period: yup.string().required(t('This field is required')),
  project_technical_preparation: yup.string().required(t('This field is required')),
  project_technical_preparation_financing: yup.string().required(t('This field is required')),
});
