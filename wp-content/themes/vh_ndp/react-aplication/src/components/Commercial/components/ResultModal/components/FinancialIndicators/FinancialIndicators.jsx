import React from "react";
import { ResultSections } from "../../../ResultSections";
import { financialIndicatorsSection } from "../../../../../DataSections";


const sections = [
    financialIndicatorsSection
];

export default function FinancialIndicators({ data = {} }) {
    return (
        <ResultSections
            data={data}
            sections={sections}
            title="Financial indicators"
        />
    );
}
