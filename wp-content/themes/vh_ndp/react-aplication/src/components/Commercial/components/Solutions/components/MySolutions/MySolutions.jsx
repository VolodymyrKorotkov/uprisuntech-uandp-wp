import React from 'react';
import global from "../../../../../../App.module.scss";
import MySolutionsCart from "../MySolutionsCart/MySolutionsCart";
import MySolutionsChoose from "../MySolutionsChoose/MySolutionsChoose";
import MySolutionsLoad from "../MySolutionsLoad/MySolutionsLoad";
import I18n from '../../../../../I18n/I18n';
import CloseIcon from '@mui/icons-material/Close';
import { IconButton, Snackbar } from '@mui/material';
import { useState } from 'react';
function MySolutions({
		onChange,
		showAvaible,
		cart = [],
		cartTemp = [],
		deleteItem,
		updateItemCart,
		data,
		onSave,
}) {
		const [open, setOpen] = useState(false)
  const handleClose = () => setOpen(false);

		const uploadCart = () => {
			setOpen(true)
			onSave({
				...data,
				choose_solutions: 'Choose yourself',
				cart: cartTemp,
			})
		}

  return (
    <div>
    	<div className="mb-4">
			<div className={global.header_title}>
				<div className={global.title}><I18n text='Solutions' /></div>
			</div>
			<div className={global.card}>
				<div className={global.header}>
					<div className={global.row_single}>
						<div className={global.title}><I18n text='My solutions'/></div>
					</div>
				</div>
				<MySolutionsChoose onChange={onChange} data={data} />
				{showAvaible && cart.length > 0 && <MySolutionsCart cart={cart} deleteItem={deleteItem} updateItemCart={updateItemCart} />}
				{cartTemp.length > 0 && !Boolean(data?.choose_solutions) && <MySolutionsLoad uploadCart={uploadCart} />}
			</div>
		</div>
			<Snackbar
        open={open}
        autoHideDuration={6000}
        onClose={handleClose}
        message={<I18n text="Your solutions have been loaded"/>}
				anchorOrigin={{
					vertical: 'bottom',
					horizontal: 'right'
				}}
        action={
          <IconButton
            size="small"
            aria-label="close"
            color="inherit"
            onClick={handleClose}
          >
            <CloseIcon fontSize="small" />
          </IconButton>
        }
      />
    </div>

  )
}

export default MySolutions
