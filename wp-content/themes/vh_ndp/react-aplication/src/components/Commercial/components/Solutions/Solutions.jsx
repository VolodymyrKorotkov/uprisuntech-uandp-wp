import React, { useEffect, useState } from "react";
import MySolutions from "./components/MySolutions/MySolutions";
import Avaible from "./components/Avaible/Avaible";
import global from '../../../../App.module.scss'
import { IconButton, Snackbar } from "@mui/material";
import CloseIcon from '@mui/icons-material/Close';
import I18n from "../../../I18n/I18n";
import SolutionsBody from "../ResultModal/components/SolutionsBody/SolutionsBody";
import styles from '../ResultModal/ResultModal.module.scss'
import classNames from "classnames";

function Solutions({
	forseShowList,
	data = {},
	onSave = () => {},
	cartTemp = [],
	currentPage,
	list,
	loaded,
	countPages,
	getData,
	categories,
	attributes,
	filter,
	onChangeFilter
}) {
	const [showAvaible, setShowAvaible] = useState(false)
	const [notification, setNotification] = useState([]);


	const handleClose = (index) => () => {
		setNotification(notification.filter((_m, _i) => _i != index))
	}


	useEffect(() => {
		if(data.choose_solutions == 'Choose yourself'){
			setShowAvaible(true)
		} else {
			setShowAvaible(false)
		}
	}, [data])

	const deleteItem = async (item) => {
		try {
			// let cart_key = (localStorage.getItem('cart_key') ? '?cart_key=' + localStorage.getItem('cart_key') : '')
			// if(localStorage.getItem('isLoggedIn') == '1'){
			// 	cart_key = '';
			// }
			// const {data} = await axios.delete(domain + `/wp-json/cocart/v2/cart/item/${item.item_key}` + cart_key);
			setNotification([...notification, 'Solution was removed'])
			onSave({...data, cart: data.cart.filter(_i => _i.id != item.id)})
			// setCart(data.items)
		} catch (error) {
			console.log("🚀 ~ file: Solutions.jsx:35 ~ deleteItem ~ error:", error)

		}
	}

	const addItemCart = async (item) => {
		try {
			// let cart_key = localStorage.getItem('cart_key') ? '&cart_key=' + localStorage.getItem('cart_key') : '';
			// if(localStorage.getItem('isLoggedIn') == '1'){
			// 	cart_key = '';
			// }
			// const {data} = await axios.post(domain + `/wp-json/cocart/v2/cart/add-item?id=${item.id}&quantity=1` + cart_key )
			// localStorage.setItem('cart_key', data.cart_key)
			// setCart(data.items)
			const itemPr = {
				id: item.id,
				name: item.name,
				quantity: 1,
				category: item?.categories[0] && item?.categories[0]?.name || '',
				featured_image: item?.images[0] && item?.images[0].src || '',
			}

			let tmpCart = data.cart || [];

			const find = tmpCart.find(_i => _i.id == itemPr.id);
			if(find){
				tmpCart = tmpCart.map(_i => _i.id == itemPr.id ? {..._i, quantity: _i.quantity + 1} : _i);
				setNotification([...notification, 'Quantity of solutions updated'])
			} else {
				tmpCart.push(itemPr)
				setNotification([...notification, 'Added to my solutions'])
			}
			onSave({...data, cart: tmpCart})
		} catch (error) {

		}
	}

	const updateItemCart = async (item, quantity) => {
		try {
			// let cart_key = localStorage.getItem('cart_key') ? '?cart_key=' + localStorage.getItem('cart_key') : '';
			// if(localStorage.getItem('isLoggedIn') == '1'){
			// 	cart_key = '';
			// }
			// const {data} = await axios.post(domain + `/wp-json/cocart/v2/cart/item/${item.item_key}`+ cart_key, {
			// 	quantity
			// } );
			// setCart(data.items)
			onSave({...data, cart: data.cart.map(_i => _i.id == item.id ? {..._i, quantity} : {..._i})})
			setNotification([...notification, 'Quantity of solutions updated'])
		} catch (error) {
			console.log("🚀 ~ file: Solutions.jsx:58 ~ updateItemCart ~ error:", error)

		}
	}


	if(forseShowList){
		return <div>
			<div className={global.header_title}>
        <div className={global.title}><I18n text={'Solutions'} /> </div>
      </div>
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
		</div>;
	}

	return (
		<div>
			<MySolutions
				cart={data?.cart || []}
				deleteItem={deleteItem}
				data={data}
				cartTemp={cartTemp}
				updateItemCart={updateItemCart}
				showAvaible={showAvaible}
				onSave={onSave}
				onChange={v => {
					onSave({...data, 'choose_solutions': v})
				}}
			/>
			{showAvaible && <Avaible
				addItemCart={addItemCart}
				currentPage={currentPage}
				loaded={loaded}
				list={list}
				categories={categories}
				attributes={attributes}
				countPages={countPages}
				filter={filter}
				getData={getData}
				onChangeFilter={onChangeFilter}
			/>}
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
		</div>
	);
}

export default Solutions;
