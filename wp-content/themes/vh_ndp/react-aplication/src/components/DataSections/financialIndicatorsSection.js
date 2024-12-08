import {arrayToString} from "../../lib/formatter";

export const financialIndicatorsSection = {
        fields: [
            {
                label: "Payback period, years",
                field: "payback_period",
            },
            {
                label: "Internal rate of return, %",
                field: "internal_rate_of_profitability",
            },
            {
                label: "Cost of the project, hryvnia",
                field: "project_cost",
            },
            {
                label: "Amount of capital costs of the project, hryvnia",
                field: "capital_costs_amount",
            },
            {
                label: "Amount of operating expenses for the project, hryvnia",
                field: "operating_costs_amount",
            },
            {
                label: "Planned project financing",
                field: "planned_project_financing",
                formatter: arrayToString,
            },
            {
                label: "Comment",
                field: "planned_project_financing_comment",
                condition: (data) => Boolean(data?.planned_project_financing_comment),
            },
            {
                label:
                    "What financing mechanisms is the project owner willing to consider?",
                field: "financing_mechanisms",
                formatter: arrayToString,
            },
            {
                label: "Comment",
                field: "financing_mechanisms_comment",
                condition: (data) => Boolean(data?.financing_mechanisms_comment),
            },
            {
                label: "Project implementation period, full months",
                field: "project_implementation_period",
            },
            {
                label: "The need to carry out work related to the technical preparation of the project",
                field: "project_technical_preparation",
            },
            {
                label: "The need for outside funding related to the technical preparation of the project",
                field: "project_technical_preparation_financing",
            }
        ]
}