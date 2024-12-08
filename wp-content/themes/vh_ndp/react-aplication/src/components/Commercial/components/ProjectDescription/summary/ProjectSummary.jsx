import { projectSection } from '../../../../DataSections'
import { Section } from '../../ResultSections'

export default function ProjectSummary({data = {}}) {
    return <Section data={{ project: data }} fields={projectSection.fields}  />
}