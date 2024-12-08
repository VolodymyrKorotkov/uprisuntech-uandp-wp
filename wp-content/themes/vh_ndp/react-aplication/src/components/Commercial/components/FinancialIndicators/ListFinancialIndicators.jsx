import {Section} from "../ResultSections";
import { financialIndicatorsSection } from "../../../DataSections";

const ListFinancialIndicators = ({ data }) => {
  return <Section data={data} fields={financialIndicatorsSection.fields}  />

}

export default ListFinancialIndicators;
