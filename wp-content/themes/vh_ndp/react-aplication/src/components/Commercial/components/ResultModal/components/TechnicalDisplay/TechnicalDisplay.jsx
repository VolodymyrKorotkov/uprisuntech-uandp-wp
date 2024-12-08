import React from 'react';
import styles from '../../ResultModal.module.scss';
import classNames from 'classnames';
import global from '../../../../../../App.module.scss';
import I18n from '../../../../../I18n/I18n';

const TechnicalDisplay = ({data = {}}) => {
  return (
    <div className={styles.modal_box}>
      <h3 className={classNames(global.h3, 'mb-3')}><I18n text={'Project type'} /></h3>
      <div className={styles.modal_block}>
        <div className={styles.modal_item}>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='Specify the year that was chosen for the basic calculation of energy resource costs, which was used in the calculation for the project *' /></div>
            <div><I18n text={data?.basic_calculation_year || ''} /></div>
          </div>
          <div className={styles.modal_row} style={{alignItems: 'flex-start'}}>
            <div className={classNames(global.font_14, global.gray_color)} style={{minWidth: 120}}><I18n text={'The actual level of energy consumption'} /></div>
            <div>{data?.base_consumption_level || '-'}</div>
          </div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='Tariff for the base year energy resource' /></div>
            <div>{data?.base_consumption_tariff || '-'}</div>
          </div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='The actual level of energy consumption of the facility' /></div>
            <div>{data?.current_consumption_level || '-'}</div>
          </div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='Tariff for energy resource in 2023, UAH per 1 kW/h' /></div>
            <div>{data?.current_consumption_tariff || '-'}</div>
          </div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='The level of energy consumption' /></div>
            <div>{data?.planned_consumption_level || '-'}</div>
          </div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='Planned reductions in greenhouse emissions, CO2 emissions' /></div>
            <div>{data?.planned_consumption_tariff || '-'}</div>
          </div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='Determination of project sustainability, maximum service life, in years' /></div>
            <div>{data?.project_sustainability || '-'}</div>
          </div>
          <div className={styles.modal_row}>
            <div className={classNames(global.font_14, global.gray_color)}><I18n text='The project is expected to be implemented with the involvement of equipment manufacturers' /></div>
            <div>{data?.equipment_manufacturer || '-'}</div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default TechnicalDisplay;