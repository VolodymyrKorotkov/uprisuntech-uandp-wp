import React from 'react'
import {Section} from "../../../ResultSections";
import {heatingUsageSection} from "../../../../../DataSections";


export default function ListHeatingUsage({data = {}}) {
    return <Section data={{ heating_usage: data }} fields={heatingUsageSection.fields}  />
}