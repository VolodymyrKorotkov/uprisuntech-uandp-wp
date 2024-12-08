import React, { useEffect, useState } from "react";
import global from "../../../../../../App.module.scss";
import styles from './Avaible.module.scss';
import AvaibleFilter from '../AvaibleFilter/AvaibleFilter';
import classNames from 'classnames';
import Item from "./components/Item/Item";
import Filters from "./components/Filters/Filters";
import { Pagination } from "@mui/material";
import axios from 'axios'
import Loaded from "./components/Loaded/Loaded";
import I18n from "../../../../../I18n/I18n";




function Avaible({addItemCart, list, loaded, countPages, currentPage, getData, categories=[], attributes=[], filter, onChangeFilter = () => {}}) {
  // const [list, setList] = useState([])
  // const [loaded, setLoaded] = useState(false);
  // const [countPages, setCountPages] = useState(1);
  // const [currentPage, setCurrentPage] = useState(1);
  

  // const getData = async (page = 1,) => {
  //   try {
  //     setLoaded(false);

  //     const {data, headers} = await axios.get(domain + `/wp-json/wc/v3/products?consumer_key=ck_6e501b96e57f757b7edf38326614b06d3aab6627&consumer_secret=cs_591ee22a9565d16cdef72615a76e43fbb9f1178a&page=${page}&per_page=15`)

  //     console.log("🚀 ~ file: Avaible.jsx:28 ~ getData ~ headers:", headers)

  //     console.log("🚀 ~ file: Avaible.jsx:24 ~ getData ~ data:", data)
  //     setCountPages(headers['x-wp-totalpages'] || 1)
  //     setCurrentPage(page);
  //     setList(data);
  //     setLoaded(true)
  //   } catch (error) {
  //     setLoaded(true)
  //   }
  // }

  // useEffect(() => {
  //   getData()
  // }, [])


  return (
    <div className={styles.avaible}>
        <div className={classNames(global.header_title, 'mb-3')}>
					<div className={global.h3}><I18n text='Available solutions'/></div>
					<Filters 
            categories={categories} 
            attributes={attributes} 
            filterData={filter}
            onChange={onChangeFilter}
          />
				</div>
        <AvaibleFilter 
          categories={categories} 
          attributes={attributes}
          filterData={filter}
          onChange={onChangeFilter}
        />
        {!loaded && <Loaded />}
        {loaded && <div className="row mb-1">
          {list.map(_i =>
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
  )
}

export default Avaible