import classNames from "classnames";
import React from "react";
import I18n, {t} from "../../../I18n/I18n";
import styles from "./ResultSection.module.scss";
import global from "../../../../App.module.scss";
import {getValueByNestedKey} from '../../../../lib/utils';

export function Section({fields, data, title, isPreview}) {
    return (
        <div className={classNames(styles.modal_section, isPreview ? styles.modal_item : '')}>
            {title && (
                <div className={styles.modal_row}>
                    <div className={global.semi}><I18n text={t(title)}/></div>
                </div>
            )}
            {
                fields.map((props, idx) => <SectionRow key={idx} data={data} {...props} isPreview={isPreview} />)
            }
        </div>
    )
}

function SectionRow({condition, label, formatter, field, data, type, subtext, divider, isPreview}) {
    const isVisible = condition ? condition(data) : true;
    const value = formatter ? formatter(getValueByNestedKey(data, field), data) : getValueByNestedKey(data, field);
    const title = typeof label === 'function' ? label(data) : label;
    const valueSubText = typeof subtext === 'function' ? subtext(data) : subtext;

    if(!isVisible) {
        return '';
    }

    switch (type) {
        case 'file':
        case 'files': {
            const files = typeof value === 'object' ? value : [value];
            return (
                <div className={classNames(title && styles.block_text, global.gray_color, global.font_15)} >
                    {title ? (<span>{t(title)}</span>) : ""}
                    {
                        files?.map(file => (
                            <p key={file} className='m-1'>
                                <a
                                    href={file}
                                    className={global.blue_link}
                                    target='_blank'
                                >
                                    {file.split('/').pop()}
                                </a>
                            </p>
                        ))
                    }
                </div>
            )
        }

        default: {
            return (
                <>
                    <div className={isPreview ? styles.modal_row : styles.block_text}>
                        <span className={isPreview ? classNames(global.font_14, global.gray_color) : ""} >{t(title)}</span>
                        <div>{value ? t(value) : '-'} { (value && valueSubText) ? t(valueSubText) : ''}</div>
                    </div>
                    { divider && <hr/>}
                </>
            )
        }
    }
}

export function ResultSections({title, data, sections, isPreview = true}) {
    return (
        <div className={styles.modal_box}>
            <h3 className={classNames(global.h3, "mb-3")}>{t(title)}</h3>
            <div className={styles.modal_block}>
                {
                    sections.map((section, idx) => <Section key={idx} isPreview={isPreview} data={data} {...section} />)
                }
            </div>
        </div>
    );
}
