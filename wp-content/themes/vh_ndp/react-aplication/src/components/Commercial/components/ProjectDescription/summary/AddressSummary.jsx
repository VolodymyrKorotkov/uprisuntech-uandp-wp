import {Section} from "../../ResultSections";
import {projectAddressSection} from "../../../../DataSections";

export default function AddressSummary({data = {}}) {
    return <Section data={{ legal_address: data }} fields={projectAddressSection.fields}  />
}
