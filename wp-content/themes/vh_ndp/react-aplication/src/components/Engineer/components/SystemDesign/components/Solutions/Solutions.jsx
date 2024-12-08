import React from 'react'
import I18n from '../../../../../I18n/I18n'
import global from '../../../../../../App.module.scss'
import SolutionsBody from '../../../../../Commercial/components/ResultModal/components/SolutionsBody/SolutionsBody'
import styles from './Solutions.module.scss'
import { Button, IconButton, Snackbar } from '@mui/material'
import ModalSolutions from './components/ModalSolutions/ModalSolutions'
import { useState } from 'react'
import CloseIcon from '@mui/icons-material/Close';

function Solutions({
  data = [], 
  onSave,
  list,
  loaded,
  countPages,
  categories,
  attributes,
  filter,
  getData,
  changeFilter,
  currentPage,
  forseListView,
}) {
  const [open, setOpen] = useState(false)
  const [notification, setNotification] = useState([]);


	const handleClose = (index) => () => {
		setNotification(notification.filter((_m, _i) => _i != index))
	}

  const deleteItem = async (item) => {
		try {
			setNotification([...notification, 'Solution was removed'])
			onSave([...data.filter(_i => _i.id != item.id)])
		} catch (error) {
			console.log("🚀 ~ file: Solutions.jsx:35 ~ deleteItem ~ error:", error)
		}
	}

	const addItemCart = async (item) => {
		try {	
			const itemPr = {
				id: item.id,
				name: item.name,
        category: item?.categories[0] && item?.categories[0]?.name || '',
				quantity: 1,
				featured_image: item?.images[0] && item?.images[0].src || '',
			}
			let tmpCart = data || [];
			const find = tmpCart.find(_i => _i.id == itemPr.id);
			if(find){
				tmpCart = tmpCart.map(_i => _i.id == itemPr.id ? {..._i, quantity: _i.quantity + 1} : _i);
				setNotification([...notification, 'Quantity of solutions updated'])
			} else {
				tmpCart.push(itemPr)
				setNotification([...notification, 'Added to my solutions'])
			}
			onSave([...tmpCart])
		} catch (error) {

		}
	}

	const updateItemCart = async (item, quantity) => {
		try {
			onSave([...data.map(_i => _i.id == item.id ? {..._i, quantity} : {..._i})])
			setNotification([...notification, 'Quantity of solutions updated'])
		} catch (error) {
			console.log("🚀 ~ file: Solutions.jsx:58 ~ updateItemCart ~ error:", error)
			
		}
	}

  return (
    <div className={global.card} style={{marginBottom: 24}}>
      <div className={global.header}>
        <div className={global.row}>
          <div className={global.title}><I18n text={'Solutions'} /></div>
          {!forseListView && <Button className={global.btn} type={'submit'} color={'primary'} onClick={() => setOpen(true)} startIcon={<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
            <path d="M15 9.75H9.75V15H8.25V9.75H3V8.25H8.25V3H9.75V8.25H15V9.75Z" fill="#2A59BD"/>
          </svg>}>
            <I18n text={'Add'} />
          </Button>}
        </div>
      </div>
      <div className={global.body}>
        {notification.map((_i, index) => <Snackbar
          open={true}
          key={'n_' + _i + index}
          autoHideDuration={4000}
          onClose={handleClose(index)}
          message={<I18n text={_i}/>}
          anchorOrigin={{
            vertical: 'bottom',
            horizontal: 'right'
          }}
          action={
            <IconButton
              size="small"
              aria-label="close"
              color="inherit"
              onClick={handleClose(index)}
            >
              <CloseIcon fontSize="small" />
            </IconButton>
          }
        />
        )}
        <ModalSolutions 
          cart={data}
          open={open} 
          onClose={() => setOpen(false)}
          deleteItem={deleteItem}
          addItemCart={addItemCart}
          updateItemCart={updateItemCart}
          list={list}
          countPages={countPages}
          currentPage={currentPage}
          categories={categories}
          attributes={attributes}
          loaded={loaded}
          getData={getData}
          filter={filter}
          onChangeFilter={changeFilter}
        />
        {data.length > 0 ? <SolutionsBody data={{
          choose_solutions: 'Choose yourself',
          cart: data
        }} /> : <div className={styles.Solutions_block}>
          <I18n text="No solutions added. Choose available solutions."/>
        </div>}
      </div>
    </div>
  )
}

export default Solutions