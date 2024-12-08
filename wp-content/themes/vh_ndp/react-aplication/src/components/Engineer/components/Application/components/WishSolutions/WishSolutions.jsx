import React from 'react'
import I18n from '../../../../../I18n/I18n'
import global from '../../../../../../App.module.scss'
import SolutionsBody from '../../../../../Commercial/components/ResultModal/components/SolutionsBody/SolutionsBody'
import styles from '../../../../../Commercial/components/ResultModal/ResultModal.module.scss'
import classNames from 'classnames'

function WishSolutions({data}) {
  return (
    <div className={global.card}>
      <div className={global.header}>
        <div className={global.row}>
          <div className={global.title}><I18n text={'Wish solutions'} /></div>
        </div>
      </div>
      <div className={global.body}>
        <div className={classNames(styles.modal,styles.modal_box)}>
          <SolutionsBody data={data} />
        </div>
      </div>
    </div>
  )
}

export default WishSolutions