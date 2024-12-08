import {useEffect, useState} from 'react';
import {
    FormContainer,
    SelectElement,
    TextFieldElement,
    MultiSelectElement,
    useForm
} from 'react-hook-form-mui';
import global from '../../../../App.module.scss'
import {t, default as I18n} from '../../../I18n/I18n'
import { financing_mechanisms_fields, planned_project_financing_fields } from "../../../I18n/translate";
import { Button } from '@mui/material';
import {CurrencyField, NumberField} from "../../../NumberFields";
import ListFinancialIndicators from "./ListFinancialIndicators";
import { yupResolver } from "@hookform/resolvers/yup";
import { financialIndicatorsSchema } from "./validation.schema";

function FinancialIndicators({ onSave = () => {}, data = {}, forseShowList }) {
    const [viewList, setViewList] = useState(forseShowList ? forseShowList : Boolean(localStorage.getItem('show_financial_indicators') == 'true'))

    const formContext = useForm({
        defaultValues: data ,
        resolver: yupResolver(financialIndicatorsSchema),
        mode: 'all',
    });

    const onSubmit = (value) => {
        setViewList(!viewList);
        localStorage.setItem('show_financial_indicators', !viewList)

        if (!viewList) {
            onSave(value)
        }
    };

    useEffect(() => {
        if (forseShowList) {
            setViewList(true)
        }
    }, [forseShowList])

    return (
        <div>
            <div className={global.header_title}>
                <div className={global.title}><I18n text='Financial indicators'/></div>
            </div>

            <FormContainer mode="all" formContext={formContext} defaultValues={data}
                           values={data} onSuccess={onSubmit}>

                <div className={global.card}>
                    <div className={global.header}>
                        <div className={global.row}>
                            <div className={global.title}><I18n text='Indicators'/></div>
                            {!forseShowList && <>{!viewList ? (
                              <Button className={global.btn} type='submit' color='primary'
                                      startIcon={<svg xmlns="http://www.w3.org/2000/svg" width="18"
                                                      height="18" viewBox="0 0 18 18" fill="none">
                                          <path
                                            d="M6.75012 12.1275L3.62262 9L2.55762 10.0575L6.75012 14.25L15.7501 5.25L14.6926 4.1925L6.75012 12.1275Z"
                                            fill="#2A59BD"/>
                                      </svg>}>
                                  <I18n text='Collapse'/>
                              </Button>
                            ) : (
                              <Button className={global.btn} type='submit' color='primary'
                                      startIcon={<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                      viewBox="0 0 18 18" fill="none">
                                          <path fillRule="evenodd" clipRule="evenodd"
                                                d="M14.295 2.69253L15.3075 3.70503C15.9 4.29003 15.9 5.24253 15.3075 5.82753L5.385 15.75H2.25V12.615L10.05 4.80753L12.1725 2.69253C12.7575 2.10753 13.71 2.10753 14.295 2.69253ZM3.75 14.25L4.8075 14.295L12.1725 6.92253L11.115 5.86503L3.75 13.23V14.25Z"
                                                fill="#2A59BD"/>
                                      </svg>}>
                                  <I18n text='Expand'/>
                              </Button>
                            )}</>}
                        </div>
                    </div>

                    <div className={global.body}>
                        {!viewList &&
                          <>
                              <div className='row'>
                                  <div className='col-md-6'>
                                      <NumberField
                                        name={'payback_period'}
                                        label={<I18n text={'Payback period, years'}/>}
                                        fullWidth
                                        required
                                        onChange={(e) => {
                                            onSave({...data, [e.target.name]: e.target.value})
                                        }}
                                        options={{max: 100, min: 1}}
                                      />
                                  </div>

                                  <div className='col-md-6 mt-3 mt-md-0'>
                                      <NumberField
                                        name={'internal_rate_of_profitability'}
                                        label={<I18n text={'Internal rate of return, %'}/>}
                                        helperText={t('If calculations are available')}
                                        fullWidth
                                        InputProps={{endAdornment: '%'}}
                                        onChange={(e) => {
                                            onSave({...data, [e.target.name]: e.target.value})
                                        }}
                                        options={{max: 100, min: 1}}
                                      />
                                  </div>
                              </div>
                              <div className='row'>
                                  <div className='col-md-12'>
                                      <CurrencyField
                                        name="project_cost"
                                        label={<I18n text={'Cost of the project, hryvnia'}/>}
                                        fullWidth
                                        helperText={<I18n
                                          text={'The amount is indicated in UAH with kopecks in digital, including VAT'}/>}
                                        required
                                        onChange={(e) => {
                                            onSave({...data, [e.target.name]: e.target.value})
                                        }}
                                      />
                                  </div>
                              </div>
                              <div className='row'>
                                  <div className='col-md-12'>
                                      <CurrencyField
                                        name={'capital_costs_amount'}
                                        label={<I18n text={'Amount of capital costs of the project, hryvnia'}/>}
                                        fullWidth
                                        required
                                        onChange={(e) => {
                                            onSave({...data, [e.target.name]: e.target.value})
                                        }}
                                      />
                                  </div>
                              </div>
                              <div className="row">
                                  <div className='col-md-12'>
                                      <CurrencyField
                                        name={'operating_costs_amount'}
                                        label={<I18n text={'Amount of operating expenses for the project, hryvnia'}/>}
                                        fullWidth
                                        required
                                        onChange={(e) => {
                                            onSave({...data, [e.target.name]: e.target.value})
                                        }}
                                      />
                                  </div>
                              </div>
                              <div className='row'>
                                  <div className='col-md-12'>
                                      <MultiSelectElement
                                        name={'planned_project_financing'}
                                        label={<I18n text={'Planned project financing'}/>}
                                        helperText={t('You can choose several options')}
                                        fullWidth
                                        itemKey={'id'}
                                        required
                                        itemValue={'id'}
                                        itemLabel={'label'}
                                        options={Object.keys(planned_project_financing_fields).map(key => ({
                                            id: key,
                                            label: t(key),
                                            value: t(key),
                                        }))}

                                        inputProps={{
                                            onChange: (e) => {
                                                if (!e.target.value?.includes('Another')) {
                                                    formContext.setValue('planned_project_financing_comment', "")
                                                    onSave({
                                                        ...data,
                                                        "planned_project_financing": e.target.value,
                                                        planned_project_financing_comment: ""
                                                    })
                                                } else {
                                                    onSave({...data, "planned_project_financing": e.target.value})
                                                }

                                            }
                                        }}
                                      />
                                  </div>
                              </div>
                              {
                                data?.planned_project_financing?.find(el => el === 'Another') && (
                                  <div className='row'>
                                      <div className='col-md-12'>
                                          <TextFieldElement
                                            name={'planned_project_financing_comment'}
                                            label={<I18n text={'Comment'}/>}
                                            fullWidth
                                            onChange={(e) => {
                                                onSave({...data, 'planned_project_financing_comment': e.target.value})
                                            }}
                                          />
                                      </div>
                                  </div>
                                )
                              }
                              <div className='row'>
                                  <div className='col-md-12'>
                                      <MultiSelectElement
                                        name={'financing_mechanisms'}
                                        helperText={t('You can choose several options')}
                                        label={<I18n
                                          text={'What financing mechanisms is the project owner willing to consider?'}/>}
                                        fullWidth
                                        itemKey={'id'}
                                        required
                                        itemValue={'id'}
                                        itemLabel={'label'}
                                        options={Object.keys(financing_mechanisms_fields).map(key => ({
                                            id: key,
                                            label: t(key),
                                            value: t(key),
                                        }))}

                                        inputProps={{
                                            onChange: (e) => {
                                                if (!e.target.value?.includes('Another')) {
                                                    formContext.setValue('financing_mechanisms_comment', "")
                                                    onSave({
                                                        ...data,
                                                        "financing_mechanisms": e.target.value,
                                                        financing_mechanisms_comment: ""
                                                    })
                                                } else {
                                                    onSave({...data, "financing_mechanisms": e.target.value})
                                                }

                                            }
                                        }}
                                      />
                                  </div>
                              </div>
                              {
                                data?.financing_mechanisms?.find(el => el === 'Another') && (
                                  <div className='row'>
                                      <div className='col-md-12'>
                                          <TextFieldElement
                                            name={'financing_mechanisms_comment'}
                                            label={<I18n text={'Comment'}/>}
                                            fullWidth
                                            onChange={(e) => {
                                                onSave({...data, 'financing_mechanisms_comment': e.target.value})
                                            }}
                                          />
                                      </div>
                                  </div>
                                )
                              }
                              <div className='row'>
                                  <div className='col-md-12'>
                                      <NumberField
                                        name={'project_implementation_period'}
                                        label={<I18n text={'Project implementation period, full months'}/>}
                                        fullWidth
                                        helperText={<I18n
                                          text={'From the start of development of project documentation to completion of commissioning work'}/>}
                                        required
                                        onChange={(e) => {
                                            onSave({...data, 'project_implementation_period': e.target.value})
                                        }}
                                      />
                                  </div>
                              </div>
                              <div className='row'>
                                  <div className='col-md-12'>
                                      <SelectElement
                                        name={'project_technical_preparation'}
                                        label={<I18n
                                          text={'The need to carry out work related to the technical preparation of the project'}/>}
                                        fullWidth
                                        required
                                        options={[
                                            {id: 'Yes', label: <I18n text={'Yes'}/>},
                                            {id: 'Not', label: <I18n text={'Not'}/>}
                                        ]}
                                        onChange={(v) => {
                                            onSave({...data, 'project_technical_preparation': v})
                                        }}
                                      />
                                  </div>
                              </div>
                              <div className='row'>
                                  <div className='col-md-12'>
                                      <SelectElement
                                        name={'project_technical_preparation_financing'}
                                        label={<I18n
                                          text={'The need for outside funding related to the technical preparation of the project'}/>}
                                        required
                                        fullWidth
                                        options={[
                                            {id: 'Yes', label: <I18n text={'Yes'}/>},
                                            {id: 'Not', label: <I18n text={'Not'}/>}
                                        ]}
                                        onChange={(v) => {
                                            onSave({...data, 'project_technical_preparation_financing': v})
                                        }}
                                      />
                                  </div>
                              </div>
                          </>
                        }
                        {viewList && <ListFinancialIndicators data={data} />}
                    </div>
                </div>
            </FormContainer>
        </div>
    )
}

export default FinancialIndicators
