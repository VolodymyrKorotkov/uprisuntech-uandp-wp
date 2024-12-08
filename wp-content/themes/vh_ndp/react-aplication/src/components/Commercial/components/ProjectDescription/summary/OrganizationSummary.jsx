import React from "react";
import {Section} from "../../ResultSections";
import {organizationSection} from "../../../../DataSections";

export default  function OrganizationSummary({ data }) {
    return <Section data={{ organization: data }} fields={organizationSection.fields}  />
}
