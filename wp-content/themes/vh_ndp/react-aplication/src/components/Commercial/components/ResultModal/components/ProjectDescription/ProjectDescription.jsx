import { ResultSections } from "../../../ResultSections";
import { projectSection, organizationSection, projectAddressSection } from '../../../../../DataSections';

const projectDescriptionSections = [ organizationSection, projectAddressSection, projectSection ];
export default function ProjectDescription({ data = {} }) {
    return (
        <ResultSections
            data={data}
            sections={projectDescriptionSections}
            title="Project description"
        />
    );
}
