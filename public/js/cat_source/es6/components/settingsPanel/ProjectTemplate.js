import React, {useContext} from 'react'
import {Select} from '../common/Select'
import {SettingsPanelContext} from './SettingsPanelContext'

export const ProjectTemplate = () => {
  const {projectTemplates, setProjectTemplates} =
    useContext(SettingsPanelContext)

  const currentTemplate = projectTemplates.find(({isSelected}) => isSelected)
  const isModifyingTemplate = projectTemplates.some(
    ({isTemporary}) => isTemporary,
  )

  const options = projectTemplates
    .filter(({isTemporary}) => !isTemporary)
    .map(({id, name}) => ({
      id: id.toString(),
      name,
    }))
  const activeOption = currentTemplate && {
    id: currentTemplate.id.toString(),
    name: `${currentTemplate.name}${isModifyingTemplate ? ' *' : ''}`,
  }

  const onSelect = (option) =>
    setProjectTemplates((prevState) =>
      prevState.map((template) => ({
        ...template,
        isSelected: template.id === parseInt(option.id),
      })),
    )

  return (
    <div className="settings-panel-project-template">
      {options.length > 0 && (
        <Select
          placeholder="Select template"
          label="Project template"
          id="project-template"
          maxHeightDroplist={100}
          options={options}
          activeOption={activeOption}
          onSelect={onSelect}
        />
      )}
    </div>
  )
}
