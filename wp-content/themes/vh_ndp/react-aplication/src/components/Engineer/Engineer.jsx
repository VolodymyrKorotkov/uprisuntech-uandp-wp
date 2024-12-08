import React, { useState } from 'react'
import Navigation from './components/Navigation/Navigation';
import Application from './components/Application/Application';
import axios from 'axios';
import { useEffect } from 'react';
import SystemDesign from './components/SystemDesign/SystemDesign';
import FinancialInformation from './components/FinancialInformation/FinancialInformation';
import Proposal from './components/Proposal/Proposal';
import Comment from './components/Comment/Comment';
import ResultModal from './components/ResultModal/ResultModal';
import FeedbackModal from './components/FeedbackModal/FeedbackModal';
import CloseIcon from '@mui/icons-material/Close';
import { IconButton, Snackbar } from '@mui/material';
import I18n from '../I18n/I18n';
import Spinner from '../Spinner/Spinner';

const domain = process.env.REACT_APP_BUILD == 'true' ? '' : 'https://staging-ndp.netvision.pro';



const validateSystemDesign = (data = {}) => {

  const fieldInstallationDetails = [
    'place',
    'direction',
    'parameters_of_connection',
    'link',
  ]

  const fieldSystemPrice = [
    'solution_cost',
    'installation_cost',
  ]


  if(data?.system_price && data?.system_price?.additions && data?.system_price?.additions.length){
    if(data?.system_price?.additions.some(_i => ['name_of_addition','addition_cost', 'quantity'].some(key => !_i[key]))){
      return false
    }
  }



  return data?.installation_details && !fieldInstallationDetails.some(key => !data['installation_details'][key])
    && data?.system_price && !fieldSystemPrice.some(key => !data['system_price'][key]) ;
}

const validateFinancialInformation = (data) => {
  const fields_economy_month_by_month = [
    'january',
    'february',
    'march',
    'april',
    'may',
    'june',
    'july',
    'august',
    'september',
    'october',
    'november',
    'december',
    'level_bill_offset',
    'level',
  ]


  const fieldsFinancingOption = [
    'term_months',
    'down_payment',
    'interest_rate',
    'monthly_payment',
  ]

  return data?.economy_month_by_month && !fields_economy_month_by_month.some(key => !data.economy_month_by_month[key]);
  // && data?.financing_option && !fieldsFinancingOption.some(key => !data.financing_option[key])
}



function Engineer() {


  const [loadedData, setLoadedData] = useState(false);

  const [activeNavigate, setActiveNavigate] = useState('Application');
  const [currency, setСurrency] = useState('Application');
  const [notification, setNotification] = useState([]);

  const [open, setOpen] = useState(false)
  const [openReject, setOpenReject] = useState(false)
  const [openReturnToApplication, setOpenReturnToApplication] = useState(false)

  const [applyInfo, setApplyInfo] = useState({})
  const [application, setApplication] = useState({})
  const [applyEngineer, setApplyEngineer] = useState({})
  console.log("🚀 ~ Engineer ~ applyEngineer:", applyEngineer)


  const [list, setList] = useState([])

  const [loaded, setLoaded] = useState(false);
  const [countPages, setCountPages] = useState(1);
  const [currentPage, setCurrentPage] = useState(1);

  const [categories, setCategories] = useState([])
  const [attributes, setAttributes] = useState([])

  const [filter, setFilter] = useState({
    categories: [],
    attributes: {}
  })

  const validDisable = () => {
    if(application.status == 'submitted' || application.status == 'processed'){
      return false
    }
    return application.status != 'in progress'
  }

  const links = [
    {
      title: 'Application',
      valid: true,
      onClick: () => {setActiveNavigate('Application')},
    },
    {
      title: 'System design',
      valid: validateSystemDesign(applyEngineer?.system_design || {}),
      disabled: validDisable(),
      onClick: () => {setActiveNavigate('System design')},
    },
    {
      title: 'Financial information',
      valid: validateFinancialInformation(applyEngineer?.financial_information || {}),
      disabled: validDisable(),
      onClick: () => {setActiveNavigate('Financial information')},
    },
    {
      title: 'Proposal',
      valid: Boolean(applyEngineer?.proposal?.file),
      disabled: validDisable(),
      onClick: () => {setActiveNavigate('Proposal')},
    },
    {
      title: 'Comment',
      valid: Boolean(applyEngineer?.comment),
      disabled: validDisable(),
      onClick: () => {setActiveNavigate('Comment')},
    },
  ]

  const getApp = async (id) => {
    try {
      const {data} = await axios(domain + (process.env.REACT_APP_BUILD == 'true' ? '/wp-json/application/v1/get_entry/' : '/wp-json/application/v1/get_entry_debug/') + id,{
        headers: {
          'X-WP-Nonce': window?.restNonce
        }
      });
      if(data && data?.apply_info){
        if(data.status == 'draft'){
          let lang = 'uk';
          if(window.location.pathname.indexOf('/en/') > -1){
            lang ='en';
          }
          window.location.href = (lang == 'en' ? '/en/' : '')+  '/dashboard/requests/';
        }
        const apply_info = typeof data.apply_info == 'string' ? JSON.parse(data.apply_info) :  data.apply_info;
        const apply_engineer = typeof data.apply_engineer == 'string' ? JSON.parse(data.apply_engineer) :  data.apply_engineer;
        setApplication({...data, apply_info, apply_engineer})
        setApplyInfo(apply_info);
        setApplyEngineer(apply_engineer);
      }
      setLoadedData(true)
    } catch (error) {
      console.log("🚀 ~ file: Commercial.jsx:175 ~ getApp ~ error:", error)
      setLoadedData(true)
    }
  }

  const getFilters = async () => {
    try {
      let lang = 'uk';
      if(window.location.pathname.indexOf('/en/') > -1){
        lang ='en';
      }



      const [categories, attributes, terms] = await Promise.all([
        axios.get(domain + `/wp-json/wc/v3/products/categories?hide_empty=true&lang=${lang}&consumer_key=ck_6e501b96e57f757b7edf38326614b06d3aab6627&consumer_secret=cs_591ee22a9565d16cdef72615a76e43fbb9f1178a`),
        axios.get(domain + `/wp-json/wc/v3/products/attributes?lang=${lang}&consumer_key=ck_6e501b96e57f757b7edf38326614b06d3aab6627&consumer_secret=cs_591ee22a9565d16cdef72615a76e43fbb9f1178a`),
        axios.get(domain + `/wp-json/application/v1/woocommerce-terms?lang=${lang}&consumer_key=ck_6e501b96e57f757b7edf38326614b06d3aab6627&consumer_secret=cs_591ee22a9565d16cdef72615a76e43fbb9f1178a`),
      ]);
      const data = attributes.data.map(_i => ({..._i, terms: terms.data.filter(_t => _t.attribute_id == _i.id).map(_t => ({..._t, id: _t.term_id}))}))

      setCategories(categories.data);
      setAttributes(data);
    } catch (error) {
      console.log("🚀 ~ file: Filters.jsx:41 ~ getData ~ error:", error)
    }
  }

  const getData = async (page = 1,) => {
    try {
      setLoaded(false);

      let params = '';

      if(filter.categories.length){
        params += '&category=' + filter.categories.join(',');
      }

      if(Object.keys(filter.attributes).length){

        params += '&attribute=' + Object.keys(filter.attributes).join(',');
        let terms = [];
        Object.keys(filter.attributes).forEach(_i => {
          terms = [...terms, ...filter.attributes[_i]];
        });

        if(terms.length){
          params += '&attribute_term=' + terms.join(',');
        }
      }
      let lang = 'uk';
      if(window.location.pathname.indexOf('/en/') > -1){
        lang ='en';
      }
      const {data, headers} = await axios.get(domain + `/wp-json/wc/v3/products?lang=${lang}&consumer_key=ck_6e501b96e57f757b7edf38326614b06d3aab6627&consumer_secret=cs_591ee22a9565d16cdef72615a76e43fbb9f1178a&page=${page}&per_page=15` + params)

      setCountPages(headers['x-wp-totalpages'] || 1)
      setCurrentPage(page);
      setList(data);
      setLoaded(true)
    } catch (error) {
      setLoaded(true)
    }
  }

  useEffect(() => {
    getData()
  }, [filter])

  useEffect(() => {
    const searchParams = new URLSearchParams(window.location.search);
    getFilters()

    // Отримайте значення параметра за іменем
    const id = searchParams.get("id");

    if(id){
      getApp(id);
    }
  }, [])


  const onGetStarted = async () => {
    try {
      setLoadedData(false)
      const {data} = await axios.post(domain + '/wp-json/application/v1/update_entry/' + application.id, {
        ...application,
        status_updated_at: new Date(),
        status: 'in progress'
      },{
        headers: {
          'X-WP-Nonce': window?.restNonce
        }
      })
      setApplication({...application, status: 'in progress'})
      setLoadedData(true)
    } catch (error) {
      setLoadedData(true)
    }
  }


  const onSaveSubmit = () => {
    setOpen(true)
  }

  const onReturnToApplicant = () => {
    setOpenReturnToApplication(true)
  }



  const onReject = () => {
    setOpenReject(true)
  }


  const onCloseReject = () => {
    setOpenReject(false)
  }


  const onSaveStatusReject = async (comment) => {
    try {
      setLoadedData(false)
      const {data} = await axios.post(domain + '/wp-json/application/v1/update_entry/' + application.id, {
        ...application,
        status_updated_at: new Date(),
        status: 'rejected',
        feedback: {
          reject: comment
        }
      },{
        headers: {
          'X-WP-Nonce': window?.restNonce
        }
      })
      setActiveNavigate('Application')
      setApplication({...application, status: 'rejected'})
      setNotification([...notification, 'Application successfully rejected'])
      setLoadedData(true)
    } catch (error) {
      setLoadedData(true)
      console.log("🚀 ~ file: Engineer.jsx:255 ~ onSaveStatusReject ~ error:", error)

    }
  }

  const onSaveReturnToApplication = async (comment) => {
    try {
      setLoadedData(false)
      const {data} = await axios.post(domain + '/wp-json/application/v1/update_entry/' + application.id, {
        ...application,
        status_updated_at: new Date(),
        status: 'returned',
        feedback: {
          'returned': comment
        }
      },{
        headers: {
          'X-WP-Nonce': window?.restNonce
        }
      })
      setActiveNavigate('Application')
      setApplication({...application, status: 'returned'})
      setNotification([...notification, 'Application successfully returned to applicant'])
      setLoadedData(true)
    } catch (error) {
      setLoadedData(true)
      console.log("🚀 ~ file: Engineer.jsx:255 ~ onSaveStatusReject ~ error:", error)

    }
  }

  const onSaveApplication = async () => {
    try {
      setOpen(false)
      setLoadedData(false)


      let total = 0;

      const system_price = applyEngineer?.system_design?.system_price;

      if(system_price?.solution_cost && !isNaN(parseFloat(system_price?.solution_cost))){
        total +=parseFloat(system_price?.solution_cost);
      }

      if(system_price?.installation_cost && !isNaN(parseFloat(system_price?.installation_cost))){
        total +=parseFloat(system_price?.installation_cost);
      }

      (system_price?.additions || []).map((_i, index) => {
        if(_i?.addition_cost && !isNaN(parseFloat(_i.addition_cost)) && _i?.quantity && !isNaN(parseFloat(_i.quantity))){
          total += parseFloat(_i.addition_cost) * parseFloat(_i.quantity);
        }
      })

      const data = applyEngineer?.financial_information?.incentive;
      const result =
        (data.type || 'UAH') == 'UAH' ?
            data.incentive ? total - parseFloat(data.incentive) : ''
          :
            data.incentive ?  Math.round((total - (total/100 *data.incentive))*100)/100 : '';
      await axios.post(domain + '/wp-json/application/v1/update_entry/' + application.id, {
        ...application,
        status_updated_at: new Date(),
        status: 'processed',
        amount: result,
        currency_code: applyEngineer?.currency,
        apply_engineer: applyEngineer
      })
      setNotification([...notification, 'Application successfully submitted'])
      setApplication({...application, status: 'processed'})
      setLoadedData(true)
    } catch (error) {
      setLoadedData(true)
    }
  }

  const handleClose = (index) => () => {
		setNotification(notification.filter((_m, _i) => _i != index))
	}


  const forseListView =  ['submitted', 'processed'].includes(application.status);
  const isOtherProjectType = application?.apply_info?.project_information?.project_type === 'Other'

  return (
    <div className='container'>
      {!loadedData && <div style={{
        position: 'fixed', zIndex: 999999, display: 'flex', alignItems: 'center', justifyContent: 'center',
        top: 0,
        left: 0,
        width: '100%',
        height: '100vh',
        background: 'rgba(255,255,255, 0.4)'
      }} >
        <Spinner/>
      </div>}
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
      <FeedbackModal
        title="Reject application"
        text="You need to write the reason for reject. Describe the details of your decision."
        btn_title='Reject'
        open={openReject}
        onClose={onCloseReject}
        onSave={onSaveStatusReject}
      />
      <FeedbackModal
        title="Return to applicant"
        text="You need to write the reason for returning to the applicant. Describe the details of your decision."
        btn_title='Return to applicant'
        open={openReturnToApplication}
        onClose={() => {
          setOpenReturnToApplication(false)
        }}
        onSave={onSaveReturnToApplication}
      />
      <ResultModal
        open={open}
        onClose={() => setOpen(false)}
        application={{...application, apply_engineer: applyEngineer}}
        onSave={onSaveApplication}
        onSaveFile={(file)=> {
          const tmp = {...applyEngineer};
          tmp.proposal.file = file
          setApplyEngineer(tmp)
        }}
      />
      <div className='row justify-content-center'>
        {!isOtherProjectType && (
          <div className='col-lg-4 mb-3 mb-lg-0'>
            <Navigation
              links={links}
              status={application.status}
              activeNavigate={activeNavigate}
              onGetStarted={onGetStarted}
              onSaveSubmit={onSaveSubmit}
              onReturnToApplicant={onReturnToApplicant}
              onReject={onReject}
            />
          </div>
        )}
        <div className='col-lg-8'>
          {activeNavigate == 'Application' && <Application application={application} isOtherProjectType={isOtherProjectType} />}
          {activeNavigate == 'Financial information' && <FinancialInformation
            currency={applyEngineer?.currency}
            onChangeCurrency={(v) => {
              setApplyEngineer({...applyEngineer, currency: v})
            }}
            forseListView={forseListView}
            data={applyEngineer?.financial_information || {}}
            system_price={applyEngineer?.system_design?.system_price || {}}
            onSave={(v) => {
              setApplyEngineer({...applyEngineer, financial_information: v})
            }} />}
          {activeNavigate == 'Proposal' && <Proposal
            forseListView={forseListView}
            data={applyEngineer?.proposal || {}}
            onSave={(v) => {
              setApplyEngineer({...applyEngineer, proposal: v})
            }} />}
          {activeNavigate == 'Comment' && <Comment
            forseListView={forseListView}
            data={applyEngineer?.comment || ''}
            onSave={(v) => {
              setApplyEngineer({...applyEngineer, comment: v})
            }} />}
          {activeNavigate == 'System design' && <SystemDesign
            forseListView={forseListView}
            data={applyEngineer?.system_design || {}}
            currency={applyEngineer?.currency}
            onChangeCurrency={(v) => {
              setApplyEngineer({...applyEngineer, currency: v})
            }}
            onSave={(v) => {
              setApplyEngineer({...applyEngineer, system_design: v})
            }}
            list={list}
            countPages={countPages}
            currentPage={currentPage}
            categories={categories}
            attributes={attributes}
            filter={filter}
            loaded={loaded}
            getData={getData}
            changeFilter={(v) => setFilter(v)}
          />}
        </div>
      </div>
    </div>
  )
}

export default Engineer
