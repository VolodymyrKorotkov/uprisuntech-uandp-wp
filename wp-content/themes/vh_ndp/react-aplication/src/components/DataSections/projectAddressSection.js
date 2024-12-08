export const projectAddressSection = {
    title: 'Legal address of the object',
    fields: [
        {
            "label": "State",
            "field": "legal_address.state"
        },
        {
            "label": "City",
            "field": "legal_address.city"
        },
        {
            "label": "Street",
            "field": "legal_address.street",
            "formatter": (field, data) => `${field} ${data.legal_address.street_number}`
        },
        {
            "label": (data) => data?.legal_address?.apartment_type == 'Private house' ? 'Private house #' : 'Apartment #',
            "field": "legal_address.apartment",
            "condition": (data) => data?.legal_address.apartment &&  data?.legal_address?.apartment_type === 'Apartment',
        },
        {
            "label": 'Postal code',
            "field": "legal_address.postal_code",
        },
    ]
};
