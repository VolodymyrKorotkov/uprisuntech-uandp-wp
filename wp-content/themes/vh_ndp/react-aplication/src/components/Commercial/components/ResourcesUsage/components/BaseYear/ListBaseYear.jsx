import { Section } from "../../../ResultSections";
import { baseYearSection } from "../../../../../DataSections";

const ListBaseYear = ({ data }) => {
  return <Section data={{ base_year: data }} fields={baseYearSection.fields}  />
}

export default ListBaseYear;
