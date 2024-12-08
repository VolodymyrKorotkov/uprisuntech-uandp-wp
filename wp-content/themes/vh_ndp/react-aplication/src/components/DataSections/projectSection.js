
export const projectSection = {
    title: 'Project',
    fields: [
        {
            "label": "Project name",
            "field": "project.project_name"
        },
        {
            "label": "Energy efficiency project (including cogeneration)",
            "field": "project.efficiency_project"
        },
        {
            "label": "Reduction of the energy intensity of production of a unit of products/services",
            "field": "project.energy_reduction_percent",
            "condition": (data) => data?.project?.efficiency_project === 'Yes',
        },
        {
            "label": "Reduction of pollutant emissions by 20% or more",
            "field": "project.pollutant_reduction_percent",
            "condition": (data) => data?.project?.efficiency_project === 'Yes',
        },
        {
            "label": "Project on switching to alternative fuels and alternative (renewable) energy sources",
            "field": "project.alternative_fuels_switching"
        },
        {
            "label": "Substitution of combustible minerals",
            "field": "project.fossil_fuels_substitution_percent",
            "condition": (data) => data?.project?.alternative_fuels_switching === 'Yes',
        },
        {
            "label": "Reduction of pollutant emissions into the environment by 20% or more",
            "field": "project.environment_pollutant_reduction_percent",
            "condition": (data) => data?.project?.alternative_fuels_switching === 'Yes',
        },
        {
            "label": "Project on thermal modernization and energy efficiency of buildings",
            "field": "project.thermal_modernization"
        },
        {
            "label": "Achievement of energy efficiency requirements for buildings (class)",
            "field": "project.above_min_requirements",
            "condition": (data) => data?.project?.thermal_modernization === 'Yes',
        },
        {
            "label": "Does your project represent an area not mentioned in the previous questions?",
            "field": "project.other_direction"
        },
        {
            "label": "If you have a different project area, describe the energy resource reduction indicators that will be achieved through its implementation",
            "field": "project.other_direction_indicators",
            "condition": (data) => data?.project?.other_direction === 'Yes',
        },
        {
            "label": "Project description",
            "field": "project.project_description"
        },
        {
            "label": "What social problems will be solved with the help of this project?",
            "field": "project.project_problems"
        },
        {
            "label": "Analysis of environmental aspects of the project, if applicable",
            "field": "project.project_analysis"
        },
        {
            "label": "The availability of an energy audit for this facility in the last 5 years",
            "field": "project.audit_availability"
        },
        {
            "label": "",
            "type": 'files',
            "condition": (data) => data?.project?.audit_availability_file?.length,
            "field": "project.audit_availability_file"
        },
        {
            "label": "Availability of an officially assigned energy manager for the facility:",
            "field": "project.manager_availability"
        },
        {
            "label": "",
            "type": 'files',
            "condition": (data) => data?.project?.manager_availability_file?.length,
            "field": "project.manager_availability_file"
        },
        {
            "label": "Implemented energy management system according to ISO 50001",
            "field": "project.iso_system"
        },
        {
            "label": "",
            "type": 'files',
            "condition": (data) => data?.project?.iso_system_file?.length,
            "field": "project.iso_system_file"
        },
        {
            "label": "The need to obtain additional permits",
            "field": "project.additional_permits"
        },
        {
            "label": "Comment",
            "field": "project.permits_comment",
            "condition": (data) => data?.project?.additional_permits === 'Yes',
        },
        {
            "label": "Decisions of government and local authorities for the project",
            "field": "project.list_of_state"
        },
        {
            "label": "Determination of project sustainability, maximum service life, in years",
            "field": "project.project_sustainability"
        },
        {
            "label": "The project is expected to be implemented with the involvement of equipment manufacturers",
            "field": "project.equipment_manufacturer"
        }
    ]
}
