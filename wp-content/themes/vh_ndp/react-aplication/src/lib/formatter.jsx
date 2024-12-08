import I18n from "../components/I18n/I18n";
import { Fragment } from "react";

export const arrayToString = (array) => {
    return array?.map((text, index) => (
        <Fragment key={index}>{<I18n text={text} />}{index + 1 < array.length ? ',' : ''}</Fragment>
    ))
}

export const getHeatingConsumptionLabel = (data) => {
    let label = '';

    switch (data?.type_tariff) {
        case 'UAH': {
            if(data.period_for_which_we_enter_data == 'Year average') {
                label = `Year bill (${data.type_tariff})`
            } else if (data.period_for_which_we_enter_data == 'Monthly average') {
                label = `Monthly bill (UAH)`
            } else {
                label = `Monthly bill (UAH)`
            }
            break;
        }

        case 'Gcal': {
            if(data.period_for_which_we_enter_data == 'Year average') {
                label = `Year consumption (${data.type_tariff})`
            } else if(data.period_for_which_we_enter_data == 'Monthly average') {
                label = `Monthly consumption (${data.type_tariff})`
            } else {
                label = `Monthly consumption (${data.type_tariff})`
            }
            break;
        }
    }

    return label;
}
