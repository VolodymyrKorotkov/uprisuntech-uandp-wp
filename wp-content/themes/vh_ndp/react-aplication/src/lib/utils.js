
export function getValueByNestedKey(obj, key) {
    const keys = key.split('.');

    let value = obj;
    for (const k of keys) {
        if (value && typeof value === 'object' && value.hasOwnProperty(k)) {
            value = value[k];
        } else {
            return undefined;
        }
    }

    return value;
}

export const projectType = (projectType) => projectType === 'Other' ? 'Other Type' : projectType;
