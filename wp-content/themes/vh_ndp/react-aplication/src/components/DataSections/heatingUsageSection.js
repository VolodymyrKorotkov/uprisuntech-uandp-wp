import {getHeatingConsumptionLabel} from "../../lib/formatter";
const isMonthlyEstimateCondition = (data) => data?.heating_usage?.period_for_which_we_enter_data === 'Monthly estimate (1-12 month)';
const monthlyEstimateSubtext = (data) => data?.heating_usage?.type_tariff;
export const heatingUsageSection = {
    title: 'Heating usage',
    fields: [
        {
            label: 'January',
            condition: isMonthlyEstimateCondition,
            field: "heating_usage.january_day",
            subtext: monthlyEstimateSubtext
        },
        {
            label: 'February',
            condition: isMonthlyEstimateCondition,
            field: "heating_usage.february_day",
            subtext: monthlyEstimateSubtext
        },
        {
            label: 'March',
            condition: isMonthlyEstimateCondition,
            field: "heating_usage.march_day",
            subtext: monthlyEstimateSubtext
        },
        {
            label: 'April',
            condition: isMonthlyEstimateCondition,
            field: "heating_usage.april_day",
            subtext: monthlyEstimateSubtext
        },
        {
            label: 'May',
            condition: isMonthlyEstimateCondition,
            field: "heating_usage.may_day",
            subtext: monthlyEstimateSubtext
        },
        {
            label: 'June',
            condition: isMonthlyEstimateCondition,
            field: "heating_usage.june_day",
            subtext: monthlyEstimateSubtext
        },
        {
            label: 'July',
            condition: isMonthlyEstimateCondition,
            field: "heating_usage.july_day",
            subtext: monthlyEstimateSubtext
        },
        {
            label: 'August',
            condition: isMonthlyEstimateCondition,
            field: "heating_usage.august_day",
            subtext: monthlyEstimateSubtext
        },
        {
            label: 'September',
            condition: isMonthlyEstimateCondition,
            field: "heating_usage.september_day",
            subtext: monthlyEstimateSubtext
        },
        {
            label: 'October',
            condition: isMonthlyEstimateCondition,
            field: "heating_usage.october_day",
            subtext: monthlyEstimateSubtext
        },
        {
            label: 'November',
            condition: isMonthlyEstimateCondition,
            field: "heating_usage.november_day",
            subtext: monthlyEstimateSubtext
        },
        {
            label: 'December',
            condition: isMonthlyEstimateCondition,
            field: "heating_usage.december_day",
            subtext: monthlyEstimateSubtext,
            divider: true
        },
        {
            label: (data) => getHeatingConsumptionLabel(data.heating_usage),
            condition: (data) => !isMonthlyEstimateCondition(data),
            subtext: monthlyEstimateSubtext,
            field: "heating_usage.heating_consumption"
        },
        {
            label: 'Tariff',
            field: "heating_usage.tariff_per",
            subtext: 'UAH per Gcal'
        },
        {
            label: 'Heating supplier',
            field: "heating_usage.heating_supplier",
        },
        {
            label: 'Bill for heating consumption',
            condition: (data) => Boolean(data?.heating_usage?.bill_for_heating_consumption),
            field: "heating_usage.bill_for_heating_consumption",
            type: 'file',
        },
    ]
};