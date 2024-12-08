export const organizationSection = {
    title: 'Organization',
    fields: [
        {
            "label": "Availability of a decarbonization office in the region",
            "field": "organization.office_availability"
        },
        {
            "label": "Region",
            "field": "organization.region",
            "condition": (data) => data?.organization?.office_availability === 'Yes',
        },
        {
            "label": "Name of the body/organization submitting the project",
            "field": "organization.issuing_name"
        },
        {
            "label": "Name of the organization (legal entity), project owner",
            "field": "organization.organization_name"
        },
        {
            "label": "Registration number (EDRPOU)",
            "field": "organization.edrpou_code"
        },
        {
            "label": "Form of organization, project owner",
            "field": "organization.organization_form",
        },
        {
            "label": "Form of ownership of your company",
            "field": "organization.comment",
            "condition": (data) => data?.organization?.organization_form === 'Other',
        },
        {
            "label": "Form of ownership",
            "field": "organization.industry"
        }
    ]
};
