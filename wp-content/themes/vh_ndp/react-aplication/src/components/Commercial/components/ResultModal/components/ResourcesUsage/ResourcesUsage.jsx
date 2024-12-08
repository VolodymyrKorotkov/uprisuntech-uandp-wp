import classNames from 'classnames'
import React from 'react'
import I18n, { t } from '../../../../../I18n/I18n'
import styles from '../../ResultModal.module.scss'
import global from '../../../../../../App.module.scss'
import { getHeatingConsumptionLabel } from '../../../../../../lib/formatter'

function ResourcesUsage({data = {}, isProjectTypeOther}) {
  return (
    <div className={styles.modal_box}>
      <h3 className={classNames(global.h3, 'mb-3')}><I18n text="Resources consumption" /></h3>
      <div className={styles.modal_block}>
        <div className={styles.modal_item}>
          <div className={styles.modal_row}>
            <div className={global.semi}><I18n text={'Base year'}/></div>
          </div>

          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text={'The year of the basic calculation of energy resource costs in the calculation for the project'}/></div>
            <div>{data?.base_year?.base_year || ''}</div>
          </div>

        </div>
        <div className={styles.modal_item}>
          <div className={styles.modal_row}>
            <div className={global.semi}><I18n text="Electricity usage" /></div>
          </div>
            {data?.electricity_usage?.period_for_which_we_enter_data == 'Monthly estimate (1-12 month)' && <>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="January" />, <I18n text={'day / night'} /></div>
                <div>{data?.electricity_usage?.january_day || ''}/{data?.electricity_usage?.january_night || '-'} <I18n text={data.electricity_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="February" />, <I18n text={'day / night'} /></div>
                <div>{data?.electricity_usage?.february_day || ''}/{data?.electricity_usage?.february_night || '-'} <I18n text={data.electricity_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="March" />, <I18n text={'day / night'} /></div>
                <div>{data?.electricity_usage?.march_day || ''}/{data?.electricity_usage?.march_night || '-'} <I18n text={data.electricity_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="April" />, <I18n text={'day / night'} /></div>
                <div>{data?.electricity_usage?.april_day || ''}/{data?.electricity_usage?.april_night || '-'} <I18n text={data.electricity_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="May" />, <I18n text={'day / night'} /></div>
                <div>{data?.electricity_usage?.may_day || ''}/{data?.electricity_usage?.may_night || '-'} <I18n text={data.electricity_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="June" />, <I18n text={'day / night'} /></div>
                <div>{data?.electricity_usage?.june_day || ''}/{data?.electricity_usage?.june_night || '-'} <I18n text={data.electricity_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="July" />, <I18n text={'day / night'} /></div>
                <div>{data?.electricity_usage?.july_day || ''}/{data?.electricity_usage?.july_night || '-'} <I18n text={data.electricity_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="August" />, <I18n text={'day / night'} /></div>
                <div>{data?.electricity_usage?.august_day || ''}/{data?.electricity_usage?.august_night || '-'} <I18n text={data?.electricity_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="September" />, <I18n text={'day / night'} /></div>
                <div>{data?.electricity_usage?.september_day || ''}/{data?.electricity_usage?.september_night || '-'} <I18n text={data.electricity_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="October" />, <I18n text={'day / night'} /></div>
                <div>{data?.electricity_usage?.october_day || ''}/{data?.electricity_usage?.october_night || '-'} <I18n text={data.electricity_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="November" />, <I18n text={'day / night'} /></div>
                <div>{data?.electricity_usage?.november_day || ''}/{data?.electricity_usage?.november_night || '-'} <I18n text={data.electricity_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="December" />, <I18n text={'day / night'} /></div>
                <div>{data?.electricity_usage?.december_day || ''}/{data?.electricity_usage?.december_night || '-'} <I18n text={data.electricity_usage?.type_tariff} /></div>
              </div>
                <hr/>
              </>}


              {data.electricity_usage?.period_for_which_we_enter_data != 'Monthly estimate (1-12 month)' && <>
                <div className={styles.modal_row}>
                  <div className={classNames(global.font_14, global.gray_color)}>
                    <I18n text={data.electricity_usage?.type_tariff == 'kWh' ?
                      data.electricity_usage?.period_for_which_we_enter_data == 'Year average' ? 'Year consumption' : 'Monthly consumption'
                      : data.electricity_usage?.period_for_which_we_enter_data == 'Year average' ? 'Year bill' : 'Monthly bill'} />
                  </div>
                  <div>{data?.electricity_usage?.monthly_electricity_consumption || ''} {data?.electricity_usage?.monthly_electricity_consumption ? <I18n text={data.electricity_usage?.type_tariff} /> : '-'}</div>
                </div>

                {Boolean(data.electricity_usage?.different_tariff_for_night_time_usage) && <div className={styles.modal_row}>
                  <div className={classNames(global.font_14, global.gray_color)}>
                    <I18n text={data.electricity_usage?.type_tariff == 'kWh' ?
                      data.electricity_usage?.period_for_which_we_enter_data == 'Year average' ? 'Year night consumption' : 'Monthly night consumption'
                      :
                      data.electricity_usage?.period_for_which_we_enter_data == 'Year average' ? 'Year night bill' : 'Monthly night bill'} />
                  </div>
                  <div>{data?.electricity_usage?.nightly_electricity_consumption || ''} {data?.electricity_usage?.nightly_electricity_consumption ? <I18n text={data.electricity_usage?.type_tariff} /> : '-'}</div>
                </div>}

              </>}

              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}>
                  <I18n text={'Tariff'} />
                </div>
                <div>{data?.electricity_usage?.tariff_per_kWh || ''} {data?.electricity_usage?.tariff_per_kWh ? <I18n text={'UAH per kWh'} /> : '-'}</div>
              </div>
              {Boolean(data.electricity_usage?.different_tariff_for_night_time_usage) && <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}>
                  <I18n text={'Night time tariff'} />
                </div>
                <div>{data?.electricity_usage?.night_time_tariff || ''} {data?.electricity_usage?.night_time_tariff ? <I18n text={'UAH per kWh'} /> : '-'}</div>
              </div>}
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}>
                  <I18n text={'Electricity supplier'} />
                </div>
                <div>{data?.electricity_usage?.electricity_supplier || '-'}</div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}>
                  <I18n text={'Required voltage'} />
                </div>
                <div>{data?.electricity_usage?.required_voltage || '-'}</div>
              </div>

            {Boolean(data.electricity_usage?.bill_for_electricity_consumption) && <div className={styles.modal_row}>
              <div className={classNames(global.font_14, global.gray_color)}><I18n text="Bill for electricity consumption" /></div>
              <a href={data.electricity_usage?.bill_for_electricity_consumption} className={global.blue_link}>{data.electricity_usage?.bill_for_electricity_consumption.split('/').pop()}</a>
            </div>}
        </div>

        <div className={styles.modal_item}>
          <div className={styles.modal_row}>
            <div className={global.semi}><I18n text="Gas usage" /></div>
          </div>

            {data.gas_usage?.period_for_which_we_enter_data == 'Monthly estimate (1-12 month)' && <>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="January" /></div>
                <div>{data?.gas_usage?.january_day || ''} <I18n text={data.gas_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="February" /></div>
                <div>{data?.gas_usage?.february_day || ''} <I18n text={data.gas_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="March" /></div>
                <div>{data?.gas_usage?.march_day || ''} <I18n text={data.gas_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="April" /></div>
                <div>{data?.gas_usage?.april_day || ''} <I18n text={data.gas_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="May" /></div>
                <div>{data?.gas_usage?.may_day || ''} <I18n text={data.gas_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="June" /></div>
                <div>{data?.gas_usage?.june_day || ''} <I18n text={data.gas_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="July" /></div>
                <div>{data?.gas_usage?.july_day || ''} <I18n text={data.gas_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="August" /></div>
                <div>{data?.gas_usage?.august_day || ''} <I18n text={data?.gas_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="September" /></div>
                <div>{data?.gas_usage?.september_day || ''} <I18n text={data.gas_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="October" /></div>
                <div>{data?.gas_usage?.october_day || ''} <I18n text={data.gas_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="November" /></div>
                <div>{data?.gas_usage?.november_day || ''} <I18n text={data.gas_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="December" /></div>
                <div>{data?.gas_usage?.december_day || ''} <I18n text={data.gas_usage?.type_tariff} /></div>
              </div>

              <hr/>
            </>}
            {data?.gas_usage?.period_for_which_we_enter_data != 'Monthly estimate (1-12 month)' &&<div className={styles.modal_row}>
              <div className={classNames(global.font_14, global.gray_color)}>
              <I18n text={data?.gas_usage?.type_tariff == 'm³' ?
                    data?.gas_usage?.period_for_which_we_enter_data == 'Year average' ? 'Year consumption' : 'Monthly consumption'
                    : data?.gas_usage?.period_for_which_we_enter_data == 'Year average' ? 'Year bill' : 'Monthly bill'} /></div>
              <div>{data?.gas_usage?.monthly_gas_consumption || ''} {data?.gas_usage?.monthly_gas_consumption ? <I18n text={data?.gas_usage?.type_tariff == 'm³' ? 'm³' : 'UAH'} /> : '-'}</div>
            </div>}
            <div className={styles.modal_row}>
              <div className={classNames(global.font_14, global.gray_color)}><I18n text="Tariff" /></div>
              <div>{data?.gas_usage?.tariff_per || ''} {data?.gas_usage?.tariff_per ? <I18n text={'UAH per m³'} /> : '-'}</div>
            </div>
            <div className={styles.modal_row}>
              <div className={classNames(global.font_14, global.gray_color)}><I18n text="Gas supplier" /></div>
              <div>{data?.gas_usage?.gas_supplier || '-'}</div>
            </div>
            {Boolean(data?.gas_usage?.bill_for_gas_consumption) && <div className={styles.modal_row}>
              <div className={classNames(global.font_14, global.gray_color)}><I18n text="Bill for gas consumption" /></div>
              <a href={data?.gas_usage?.bill_for_gas_consumption} className={global.blue_link}>{data?.gas_usage?.bill_for_gas_consumption.split('/').pop()}</a>
            </div>}

        </div>
        <div className={styles.modal_item}>
          <div className={styles.modal_row}>
            <div className={global.semi}><I18n text="Hot water usage" /></div>
          </div>

            {data.hot_water_usage?.period_for_which_we_enter_data == 'Monthly estimate (1-12 month)' && <>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="January" /></div>
                <div>{data?.hot_water_usage?.january_day || ''} <I18n text={data.hot_water_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="February" /></div>
                <div>{data?.hot_water_usage?.february_day || ''} <I18n text={data.hot_water_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="March" /></div>
                <div>{data?.hot_water_usage?.march_day || ''} <I18n text={data.hot_water_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="April" /></div>
                <div>{data?.hot_water_usage?.april_day || ''} <I18n text={data.hot_water_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="May" /></div>
                <div>{data?.hot_water_usage?.may_day || ''} <I18n text={data.hot_water_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="June" /></div>
                <div>{data?.hot_water_usage?.june_day || ''} <I18n text={data.hot_water_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="July" /></div>
                <div>{data?.hot_water_usage?.july_day || ''} <I18n text={data.hot_water_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="August" /></div>
                <div>{data?.hot_water_usage?.august_day || ''} <I18n text={data?.hot_water_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="September" /></div>
                <div>{data?.hot_water_usage?.september_day || ''} <I18n text={data.hot_water_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="October" /></div>
                <div>{data?.hot_water_usage?.october_day || ''} <I18n text={data.hot_water_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="November" /></div>
                <div>{data?.hot_water_usage?.november_day || ''} <I18n text={data.hot_water_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="December" /></div>
                <div>{data?.hot_water_usage?.december_day || ''} <I18n text={data.hot_water_usage?.type_tariff} /></div>
              </div>

              <hr/>
            </>}

            {data?.hot_water_usage?.period_for_which_we_enter_data != 'Monthly estimate (1-12 month)' &&<div className={styles.modal_row}>
              <div className={classNames(global.font_14, global.gray_color)}>
              <I18n text={data?.hot_water_usage?.type_tariff == 'm³' ?
                    data?.hot_water_usage?.period_for_which_we_enter_data == 'Year average' ? 'Year consumption' : 'Monthly consumption'
                    : data?.hot_water_usage?.period_for_which_we_enter_data == 'Year average' ? 'Year bill' : 'Monthly bill'} /></div>
              <div>{data?.hot_water_usage?.monthly_hot_water_consumption || ''} {data?.hot_water_usage?.monthly_hot_water_consumption ? <I18n text={data?.hot_water_usage?.type_tariff == 'm³' ? 'm³' : 'UAH'} /> : '-'}</div>
            </div>}

            <div className={styles.modal_row}>
              <div className={classNames(global.font_14, global.gray_color)}><I18n text="Tariff" /></div>
              <div>{data?.hot_water_usage?.tariff_per || ''} {data?.hot_water_usage?.tariff_per ? <I18n text={'UAH per m³'} /> : '-'}</div>
            </div>
            <div className={styles.modal_row}>
              <div className={classNames(global.font_14, global.gray_color)}><I18n text="Hot water supplier" /></div>
              <div>{data?.hot_water_usage?.hot_water_supplier || '-'}</div>
            </div>
            {Boolean(data?.hot_water_usage?.bill_for_hot_water_consumption) && <div className={styles.modal_row}>
              <div className={classNames(global.font_14, global.gray_color)}><I18n text="Bill for hot water consumption" /></div>
              <a href={data?.hot_water_usage?.bill_for_hot_water_consumption} className={global.blue_link}>{data?.hot_water_usage?.bill_for_hot_water_consumption.split('/').pop()}</a>
            </div>}

        </div>
        <div className={styles.modal_item}>
          <div className={styles.modal_row}>
            <div className={global.semi}><I18n text={'Heating usage'} /></div>
          </div>
            {data.heating_usage?.period_for_which_we_enter_data == 'Monthly estimate (1-12 month)' && <>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="January" /></div>
                <div>{data?.heating_usage?.january_day || ''} <I18n text={data.heating_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="February" /></div>
                <div>{data?.heating_usage?.february_day || ''} <I18n text={data.heating_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="March" /></div>
                <div>{data?.heating_usage?.march_day || ''} <I18n text={data.heating_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="April" /></div>
                <div>{data?.heating_usage?.april_day || ''} <I18n text={data.heating_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="May" /></div>
                <div>{data?.heating_usage?.may_day || ''} <I18n text={data.heating_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="June" /></div>
                <div>{data?.heating_usage?.june_day || ''} <I18n text={data.heating_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="July" /></div>
                <div>{data?.heating_usage?.july_day || ''} <I18n text={data.heating_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="August" /></div>
                <div>{data?.heating_usage?.august_day || ''} <I18n text={data?.heating_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="September" /></div>
                <div>{data?.heating_usage?.september_day || ''} <I18n text={data.heating_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="October" /></div>
                <div>{data?.heating_usage?.october_day || ''} <I18n text={data.heating_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="November" /></div>
                <div>{data?.heating_usage?.november_day || ''} <I18n text={data.heating_usage?.type_tariff} /></div>
              </div>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n text="December" /></div>
                <div>{data?.heating_usage?.december_day || ''} <I18n text={data.heating_usage?.type_tariff} /></div>
              </div>

              <hr/>
            </>}

            {data?.heating_usage?.period_for_which_we_enter_data != 'Monthly estimate (1-12 month)' &&<div className={styles.modal_row}>
              <div className={classNames(global.font_14, global.gray_color)}>
                {t(getHeatingConsumptionLabel(data.heating_usage))}</div>
              <div>{data?.heating_usage?.heating_consumption || ''} {data?.heating_usage?.heating_consumption ? <I18n text={data?.heating_usage?.type_tariff == 'm³' ? 'm³' : data?.heating_usage?.type_tariff} /> : '-'}</div>
            </div>}

            <div className={styles.modal_row}>
              <div className={classNames(global.font_14, global.gray_color)}><I18n text={'Tariff'} /></div>
              <div>{data?.heating_usage?.tariff_per || ''} {data?.heating_usage?.tariff_per ? <I18n text={'UAH per Gcal'} /> : '-'}</div>
            </div>
            <div className={styles.modal_row}>
              <div className={classNames(global.font_14, global.gray_color)}><I18n text={'Heating supplier'} /></div>
              <div>{data?.heating_usage?.heating_supplier || '-'}</div>
            </div>
            {Boolean(data?.heating_usage?.bill_for_heating_consumption) && <div className={styles.modal_row}>
              <div className={classNames(global.font_14, global.gray_color)}><I18n text="Bill for heating consumption" /></div>
              <a href={data?.heating_usage?.bill_for_heating_consumption} className={global.blue_link}>{data?.heating_usage?.bill_for_heating_consumption.split('/').pop()}</a>
            </div>}

        </div>
        <div className={styles.modal_item}>
          <div className={styles.modal_row}>
            <div className={global.semi}><I18n text={'Environment'} /></div>
          </div>

          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text={'Current CO2 emissions'} /></div>
            <div>{data?.environment?.current_CO2_emissions || ''} {data?.environment?.current_CO2_emissions ? <I18n text={'t'} /> : '-'}</div>
          </div>

          {!isProjectTypeOther && (
            <>
              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n
                  text={'The level of energy consumption, which is planned to be reduced'}/></div>
                <div>{data?.environment?.energy_consumption_level || ''} {data?.environment?.energy_consumption_level ?
                  <I18n text={'%'}/> : '-'}</div>
              </div>

              <div className={styles.modal_row}>
                <div className={classNames(global.font_14, global.gray_color)}><I18n
                  text={'Planned reductions in greenhouse emissions, CO2 emissions, after project implementation'}/>
                </div>
                <div>{data?.environment?.planned_reductions || ''} {data?.environment?.energy_consumption_level ?
                  <I18n text={'%'}/> : '-'}</div>
              </div>
            </>
          )}
        </div>
      </div>
    </div>
  )
}

export default ResourcesUsage
