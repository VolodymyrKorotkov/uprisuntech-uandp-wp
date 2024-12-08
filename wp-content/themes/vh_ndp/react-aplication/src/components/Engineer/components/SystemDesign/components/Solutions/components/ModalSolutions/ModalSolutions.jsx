import { Modal, Pagination } from '@mui/material'
import React from 'react'
import styles from './ModalSolutions.module.scss'
import global from '../../../../../../../../App.module.scss'
import classNames from 'classnames'
import I18n from '../../../../../../../I18n/I18n'
import Item from '../../../../../../../Commercial/components/Solutions/components/Avaible/components/Item/Item'
import Categories from '../../../../../../../Commercial/components/Solutions/components/AvaibleFilter/components/Categories/Categories'
import Attributes from '../../../../../../../Commercial/components/Solutions/components/AvaibleFilter/components/Attributes/Attributes'
import Filter from './components/Filter/Filter'
import Loaded from '../../../../../../../Commercial/components/Solutions/components/Avaible/components/Loaded/Loaded'
import MySolutionsCart from '../../../../../../../Commercial/components/Solutions/components/MySolutionsCart/MySolutionsCart'


function ModalSolutions({ 
  open, 
  cart, 
  onClose, 
  list=[], 
  addItemCart, 
  updateItemCart, 
  deleteItem, 
  currentPage, 
  countPages, 
  loaded = true, 
  categories=[], 
  attributes=[], 
  filter, 
  onChangeFilter = () => {},
  getData = () => {}
}) {

  return (
    <Modal style={{ zIndex: 997 }} className={global.c_modal_flex} open={open} onClose={onClose}>
      <div className={classNames(global.c_modal, global.c_modal_medium, styles.modal)}>
        <div className={classNames(global.c_modal_header, styles.modal_header)}>
          <div className='row'>
            <div className={global.h3}><I18n text={'Solution'} /></div>
            <div className={global.h5}><I18n text={'Choose available solutions'} /></div>
          </div>
          <div className={classNames(global.c_modal_close, global.static)} onClick={onClose}>
            <svg
              width="24"
              height="24"
              viewBox="0 0 24 24"
              fill="none"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12L19 6.41Z"
                fill="#919094"
              />
            </svg>
          </div>
        </div>
        <div className={classNames(global.c_modal_body, styles.bg_gray, global.modal_table)}>
            <div className={'row'}>
              <div className={classNames('col-md-12', styles.bl_solution)} >
                <div className={styles.title}><I18n text="Solutions"/></div>
                <div className={global.card}>
                  <MySolutionsCart cart={cart} deleteItem={deleteItem} updateItemCart={updateItemCart} />
                </div>
              </div>
              <div className={'col-md-8'}>
                {(!(filter.categories.length == 0 && Object.keys(filter.attributes).length == 0)) && <div className={styles.filter}>
                  <Categories
                    categories={categories} 
                    filter={filter} 
                    onChange={onChangeFilter} 
                  />
                  <Attributes 
                    attributes={attributes} 
                    filter={filter} 
                    onChange={onChangeFilter}  />
                </div>}
                {!loaded && <Loaded />}
                {loaded && <div className="row mb-1">
                  { (Array.isArray(list) ? (list || []) : []).map(_i =>
                    <div key={_i.id} className="col-lg-4 col-md-6">
                      <Item item={_i} addItemCart={addItemCart}/>
                    </div>
                  )}
                </div>}
                {loaded && <div style={{display:'flex', justifyContent: 'center'}}>
                  <Pagination count={countPages} page={currentPage} onChange={(e, page) => {
                    getData(page)
                  }} color="primary" />
                </div>}
              </div>
              <div className='col-md-4'>
                <Filter 
                  categories={categories} 
                  attributes={attributes} 
                  filterData={filter} 
                  onChange={onChangeFilter} 
                />
              </div>
            </div>
        </div>
      </div>
    </Modal>
  )
}

export default ModalSolutions