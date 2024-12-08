import { useEffect, useState } from 'react'
import axios from 'axios';
import Navigation from './components/Navigation/Navigation';
import Solutions from './components/Solutions/Solutions';
import ResultModal from './components/ResultModal/ResultModal';
import MobileMenu from './components/MobileMenu/MobileMenu';
import { PlaceOfInstallation, placeOfInstallationSchemas } from './components/PlaceOfInstallation';
import { Organization, organizationsSchemas } from './components/Organization';
import { Contact, contactSchema } from './components/Contact'
import { ResourcesUsage, resourcesUsageSchemas } from './components/ResourcesUsage';
import { FinancialIndicators, financialIndicatorsSchema } from './components/FinancialIndicators';
import { ProjectInformation, projectInfoSchema } from './components/ProjectInformation';
import { ProjectDescription, projectDescriptionSchemas } from './components/ProjectDescription';
import LoginModal from './components/LoginModal/LoginModal';
import Updates from './components/Updates/Updates';
import Spinner from '../Spinner/Spinner';
import NavigateTab from './components/NavigateTab/NavigateTab';
import { useLocalStorage } from "../Hooks";

const domain = process.env.REACT_APP_BUILD == 'true' ? '' : 'https://staging-ndp.netvision.pro';

const isValidSection = async (schemas) => {
  try {
    if (!Array.isArray(schemas)) {
      throw new Error('Schemas must be an arrays');
    }

    const promises = schemas.map(([schema, dataset]) => schema.isValid(dataset));
    const results = await Promise.all(promises);
    return results.every(Boolean);

  } catch {
    return false;
  }
};

function Commercial() {
  const [loadedData, setLoadedData] = useState(true)
  const [loadedDataAttributes, setLoadedDataAttributes] = useState(false)
  const [activeNavigate, setActiveNavigate] = useState('Project information');
  const [openLoginModal, setOpenLoginModal] = useState(false)
  const [open, setOpen] = useState(false)

  const [application, setApplication] = useState(null)
  const [applicationStatus, setApplicationStatus] = useState('')
  const [draftId, setDraftId] = useState(null)
  const [municipalityInfo, setMunicipalityInfo] = useState(null)

  const [contact, setContact] = useState({});
  const [organization, setOrganization] = useLocalStorage('app_organization', {});
  const [resourcesUsage, setResourcesUsage] = useLocalStorage('app_resourcesUsage', {});
  const [projectInformation, setProjectInformation] = useLocalStorage('app_project_information', {});
  const [financialIndicators, setFinancialIndicators] = useLocalStorage('app_financialIndicators', {});
  const [projectDescription, setProjectDescription] = useLocalStorage('app_project_description', {});
  const [solutions, setSolutions] = useLocalStorage('app_solutions', {});
  const [placeOfInstallation, setPlaceOfInstallation] = useLocalStorage('app_placeOfInstallation', {});

  const [list, setList] = useState([])
  const [loaded, setLoaded] = useState(false);
  const [countPages, setCountPages] = useState(1);
  const [currentPage, setCurrentPage] = useState(1);

  const [categories, setCategories] = useState([])
  const [attributes, setAttributes] = useState([])

  const [cartTemp, setCartTemp] = useState([])

  const [filter, setFilter] = useState({
    categories: [],
    attributes: {}
  })

  const getFilters = async () => {
    try {
      setLoadedDataAttributes(true);
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
      let lang = 'uk';
      if(window.location.pathname.indexOf('/en/') > -1){
        lang ='en';
      }
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

      const {data, headers} = await axios.get(domain + `/wp-json/wc/v3/products?lang=${lang}&consumer_key=ck_6e501b96e57f757b7edf38326614b06d3aab6627&consumer_secret=cs_591ee22a9565d16cdef72615a76e43fbb9f1178a&page=${page}&per_page=15` + params)

      setCountPages(headers['x-wp-totalpages'] || 1)
      setCurrentPage(page);
      setList(data);
      setLoaded(true)
    } catch (error) {
      setLoaded(true)
    }
  }

  const getApp = async (id) => {
    try {
      setLoadedData(false)
      const {data} = await axios(domain + '/wp-json/application/v1/get_entry/' + id, {
        headers: {
          'X-WP-Nonce': window?.restNonce
        }
      });
      if(data && data?.apply_info){
        const apply_info = typeof data.apply_info == 'string' ? JSON.parse(data.apply_info) :  data.apply_info;
        console.log("🚀 ~ file: Commercial.jsx:297 ~ getApp ~ apply_info:", apply_info)
        const apply_engineer = typeof data.apply_engineer == 'string' ? JSON.parse(data.apply_engineer) :  data.apply_engineer;
        const feedback = typeof data.feedback == 'string' ? JSON.parse(data.feedback) :  data.feedback;

        if(apply_info.is_municipality){
          localStorage.setItem('municipalityInfoChecked', true)
        }

        setApplication({...data, apply_engineer, feedback, apply_info})
        setApplicationStatus(data?.status || '')
        setPlaceOfInstallation(apply_info.place_of_installation);
        setOrganization(apply_info.organization);
        setResourcesUsage(apply_info.resources_usage);
        setProjectInformation(apply_info?.project_information || {});
        setSolutions(apply_info.solutions);
        setDraftId(id);
        setContact(apply_info.contact)
        setProjectDescription(apply_info.project_description);
        setFinancialIndicators(apply_info.financial_indicators);

        const hasStatus = ['reject', 'rejected', 'submitted', 'return to application', 'returned', 'processed'].includes(data.status);
        const isOtherProject = Boolean(apply_info?.project_information?.project_type === 'Other')

        if(hasStatus && !isOtherProject){
          setActiveNavigate('Updates')
        }

        if(localStorage.getItem('isLoggedIn') == '1'){
          try {
            const current_user = JSON.parse(localStorage.getItem('current_user'));
            const tmp = {
              email: current_user.data.user_email,
              first_name: current_user?.meta?.first_name && current_user?.meta?.first_name[0] ? current_user?.meta?.first_name[0] : '',
              phone: current_user?.meta?.llms_phone && current_user?.meta?.llms_phone[0] ? current_user?.meta?.llms_phone[0] : '',
              last_name: current_user?.meta?.last_name && current_user?.meta?.last_name[0] ? current_user?.meta?.last_name[0] : '',
              middle_name: current_user?.meta?.middle_name && current_user?.meta?.middle_name[0] ? current_user?.meta?.middle_name[0] : '',
            }
            tmp.full_name = [tmp?.last_name, tmp?.first_name, tmp?.middle_name].filter(_i => !!_i).join(' ')
            tmp.phone = (tmp.phone || '').replace(/[^0-9]/g, '');

            if(tmp.phone){
              const p = tmp.phone.length > 9 ? tmp.phone.substring(tmp.phone.length - 9, tmp.phone.length) : tmp.phone;
              tmp.phone = `+38(0${p.substring(0, 2)}) ${p.substring(2, 5)} ${p.substring(5, 7)} ${p.substring(7, 9)}`;
            }

            if(apply_info?.contact?.phone){
              tmp.phone = apply_info?.contact?.phone;
            }
            console.log("🚀 ~ file: Commercial.jsx:343 ~ getApp ~ tmp:", tmp)
            setContact(tmp)
          } catch (error) {
            console.log("🚀 ~ file: Commercial.jsx:162 ~ useEffect ~ error:", error)
          }
        }
      }
      setLoadedData(true)
    } catch (error) {
      console.log("🚀 ~ file: Commercial.jsx:175 ~ getApp ~ error:", error)
      let lang = 'uk';
      if(window.location.pathname.indexOf('/en/') > -1){
        lang ='en';
      }
      window.location.href = lang == 'en' ? '/en/dashboard' : '/dashboard';
      // setLoadedData(true)
    }
  }

  const getCart = async (selectedCart) => {
    try {
      let cart_key = localStorage.getItem('cart_key') ? '?cart_key=' + localStorage.getItem('cart_key') : '';
      if(localStorage.getItem('isLoggedIn') == '1'){
        cart_key = '';
      }
      const {data} = await axios.get(domain + `/wp-json/cocart/v2/cart` + cart_key);
      if(data?.items && data?.items.length > 0){
        const tmp = [];
        data?.items.forEach(_i => {
          tmp.push({
            id: _i.id,
            name: _i.name,
            quantity: _i.quantity.value,
            featured_image: _i?.featured_image || '',
          })
        });
        if(selectedCart){
          setSolutions({
            cart: tmp,
            choose_solutions: 'Choose yourself',
          })
        } else {
          setCartTemp(tmp)
        }
      }
    } catch (error) {

    }
  }

  useEffect(() => {
    getData()
  }, [filter])

  useEffect(() => {
    // axios.defaults.headers.common['X-WP-Nonce'] = window?.restNonce || '123';
    // Отримайте параметри з URL
    if(localStorage.getItem('municipality_info')){
      try {
        let data = JSON.parse(localStorage.getItem('municipality_info'))
        setMunicipalityInfo(data)
      } catch (error) {

      }
    }


    const searchParams = new URLSearchParams(window.location.search);

    getFilters()

    // Отримайте значення параметра за іменем
    const draftId = searchParams.get("draftId") || searchParams.get("id");
    const selectedCart = searchParams.get("selectedCart");

    if(draftId){
      getApp(draftId);
    } else {
      if(localStorage.getItem('isLoggedIn') == '1'){
        try {
          const current_user = JSON.parse(localStorage.getItem('current_user'));
          console.log("🚀 ~ file: Commercial.jsx:112 ~ useEffect ~ current_user:", current_user)
          const tmp = {
            email: current_user.data.user_email,
            first_name: current_user?.meta?.first_name && current_user?.meta?.first_name[0] ? current_user?.meta?.first_name[0] : '',
            phone: current_user?.meta?.llms_phone && current_user?.meta?.llms_phone[0] ? current_user?.meta?.llms_phone[0] : '',
            last_name: current_user?.meta?.last_name && current_user?.meta?.last_name[0] ? current_user?.meta?.last_name[0] : '',
            middle_name: current_user?.meta?.middle_name && current_user?.meta?.middle_name[0] ? current_user?.meta?.middle_name[0] : '',
          }
          tmp.full_name = [tmp?.last_name, tmp?.first_name, tmp?.middle_name].filter(_i => !!_i).join(' ');

          tmp.phone = (tmp.phone || '').replace(/[^0-9]/g, '');
          if(tmp.phone){
            const p = tmp.phone.length > 9 ? tmp.phone.substring(tmp.phone.length - 9, tmp.phone.length) : tmp.phone;
            tmp.phone = `+38(0${p.substring(0, 2)}) ${p.substring(2, 5)} ${p.substring(5, 7)} ${p.substring(7, 9)}`;
          }
          console.log("🚀 ~ file: Commercial.jsx:434 ~ useEffect ~ tmp:", tmp)
          setContact(tmp)
        } catch (error) {
          console.log("🚀 ~ file: Commercial.jsx:162 ~ useEffect ~ error:", error)
        }

      }

      getCart(selectedCart);
    }
  }, [])

  useEffect(() => {
    if(activeNavigate == 'Solutions' && !loadedDataAttributes){
      getFilters();
    }
  }, [activeNavigate])

  const typeProjectOther = Boolean(projectInformation?.project_type == 'Other')

  const handleNavigation = (page) => () => {
    window.scrollTo({
      top: 0,
      behavior: 'smooth'
    });
    setActiveNavigate(page)
  }

  const validateContact  = async (contact) => {
    if(localStorage.getItem('isLoggedIn') != '1'){
      return false;
    }
    return isValidSection([[contactSchema, contact]]);
  }

  const validateSolution = (data) => {
    return new Promise((resolve) => {
      resolve(data.choose_solutions === 'Our experts will choose' ||
        (data.choose_solutions === 'Choose yourself' && data?.cart?.length > 0))
    });
  }


  const links = typeProjectOther ? [
    {
      title: 'Project information',
      valid:  isValidSection([[projectInfoSchema, projectInformation]]),
      onClick: handleNavigation('Project information')
    },
    {
      title: 'Project description',
      valid: isValidSection([
        [projectDescriptionSchemas.organization, projectDescription.organization],
        [projectDescriptionSchemas.legal_address, projectDescription.legal_address],
        [projectDescriptionSchemas.project, projectDescription.project]
      ]),
      onClick: handleNavigation('Project description'),
    },
    {
      title: 'Resources consumption',
      valid: isValidSection([
        [resourcesUsageSchemas.base_year, resourcesUsage.base_year],
        [resourcesUsageSchemas.electricity_usage, resourcesUsage.electricity_usage],
        [resourcesUsageSchemas.gas_usage, resourcesUsage.gas_usage],
        [resourcesUsageSchemas.hot_water_usage, resourcesUsage.hot_water_usage],
        [resourcesUsageSchemas.heating_usage, resourcesUsage.heating_usage],
        [resourcesUsageSchemas.environment(typeProjectOther), resourcesUsage.environment],
      ]),
      onClick: handleNavigation('Resources consumption')
    },
    {
      title: 'Financial indicators',
      valid: isValidSection([[financialIndicatorsSchema, financialIndicators]]),
      onClick: handleNavigation('Financial indicators')
    },
    {
      title: 'Contact',
      valid:  validateContact(contact),
      onClick: handleNavigation('Contact')
    },
  ] : [
    {
      title: 'Project information',
      valid: isValidSection([[projectInfoSchema, projectInformation]]),
      onClick: handleNavigation('Project information')
    },
    {
      title: 'Organization',
      valid: isValidSection([
        [organizationsSchemas.about, organization.about],
        [organizationsSchemas.operating_mode, organization.operating_mode],
        [organizationsSchemas.legal_address, organization.legal_address]
      ]),
      onClick: handleNavigation('Organization')
    },
    {
      title: 'Resources consumption',
      valid: isValidSection([
        [resourcesUsageSchemas.base_year, resourcesUsage.base_year],
        [resourcesUsageSchemas.electricity_usage, resourcesUsage.electricity_usage],
        [resourcesUsageSchemas.gas_usage, resourcesUsage.gas_usage],
        [resourcesUsageSchemas.hot_water_usage, resourcesUsage.hot_water_usage],
        [resourcesUsageSchemas.heating_usage, resourcesUsage.heating_usage],
        [resourcesUsageSchemas.environment(typeProjectOther), resourcesUsage.environment],
      ]),
      onClick: handleNavigation('Resources consumption')
    },
    {
      title: 'Place of installation',
      valid: isValidSection([
        [placeOfInstallationSchemas.place, placeOfInstallation.place],
        [placeOfInstallationSchemas.building_information, placeOfInstallation.building_information],
      ]),
      onClick: handleNavigation('Place of installation')
    },
    {
      title: 'Solutions',
      valid: validateSolution(solutions),
      onClick: handleNavigation('Solutions')
    },
    {
      title: 'Contact',
      valid:  validateContact(contact),
      onClick: handleNavigation('Contact')
    },
  ]

  const onSaveDraft = async () => {

    if(localStorage.getItem('isLoggedIn') != '1'){
      setOpenLoginModal(true)
      return;
    }

    let current_user = {};
    try {
      current_user = JSON.parse(localStorage.getItem('current_user'));
    } catch (error) {

    }

    const data = {
      status: 'draft',
      status_updated_at: new Date(),
      email: contact.email,
      municipality_id: projectInformation.municipalityInfoChecked && municipalityInfo?.id || null,
      date_added: new Date(),
      amount: 0,
      apply_info: {
        is_municipality: projectInformation.municipalityInfoChecked,
        contact,
        organization,
        place_of_installation: placeOfInstallation,
        resources_usage: resourcesUsage,
        project_information: projectInformation,
        project_description: projectDescription,
        solutions,
        financial_indicators: financialIndicators
      }
    }

    if(application?.user_id){
      data.user_id = application?.user_id;
    } else if(current_user?.ID){
      data.user_id = current_user.ID
    }

    sendData(data)
  }

  const onSaveSubmit = () => {
    setOpen(true);
  }

  const sendData = async (body) => {
    try {
      setLoadedData(false)
      const {data} = draftId ?
        await axios.post(domain + '/wp-json/application/v1/update_entry/' + draftId, body, {
          headers: {
            'X-WP-Nonce': window?.restNonce
          }
        }) :
        await axios.post(domain + '/wp-json/application/v1/add_entry', body, {
          headers: {
            'X-WP-Nonce': window?.restNonce
          }
        });
      if(data.success){
        localStorage.clear();
        window.location.href = domain + '/dashboard/applications/';
      }
      setLoadedData(true)
    } catch (error) {
      setLoadedData(true)
    }
  }

  const onSave = async () => {
    let current_user = {};
    try {
      current_user = JSON.parse(localStorage.getItem('current_user'));
    } catch (error) {

    }

    const isOtherProject = Boolean(projectInformation?.project_type === 'Other')

    const data = {
      ...(application ? application : {}),
      status: isOtherProject ? 'processed' : 'pending',
      status_updated_at: new Date(),
      email: contact.email,
      municipality_id: projectInformation.municipalityInfoChecked && municipalityInfo?.id || null,
      amount: 0,
      apply_info: {
        is_municipality: projectInformation.municipalityInfoChecked,
        contact,
        organization,
        place_of_installation: placeOfInstallation,
        resources_usage: resourcesUsage,
        project_information: projectInformation,
        solutions,
        financial_indicators: financialIndicators,
        project_description: projectDescription,
      }
    };

    if(application?.user_id){
      data.user_id = application?.user_id;
    } else if(current_user?.ID){
      data.user_id = current_user.ID
    }

    sendData(data)
  }

  const onChangeFilter = (f) => {
    setFilter(f)
  }

  const forseShowList = ['await', 'pending', 'in progress', 'reject', 'rejected', 'submitted', 'processed', 'return to application', 'returned'].includes(application?.status);

  const renderCurrentSection = (activeNavigate) => {
    switch (activeNavigate) {
      case "Updates":
        return <Updates
          application={application}
          applicationStatus={applicationStatus}
          onClickEdit={() => {
            setApplication({...application, status: 'draft'})
            setActiveNavigate('Project information')
          }}
        />
      case "Contact":
        return <Contact
          forseShowList={forseShowList}
          onSave={setContact}
          contact={contact}
        />
      case "Project information":
        return <ProjectInformation
          municipalityInfo={municipalityInfo}
          forseShowList={forseShowList}
          status={applicationStatus}
          onChangeOrganisation={(v) => {
            const about = {...(organization?.about || {}), ...v}
            setOrganization({...organization, about});
          }}
          onSave={setProjectInformation}
          data={projectInformation}
        />
      case "Project description":
        return <ProjectDescription
          forseShowList={forseShowList}
          onSave={setProjectDescription}
          data={projectDescription}
        />
      case "Financial indicators":
        return <FinancialIndicators
          forseShowList={forseShowList}
          onSave={setFinancialIndicators}
          data={financialIndicators}
        />
      case "Organization":
        return <Organization
          typeProjectOther={typeProjectOther}
          forseShowList={forseShowList}
          municipalityInfo={municipalityInfo}
          onSave={setOrganization}
          data={organization}
        />
      case "Resources consumption":
        return <ResourcesUsage
          typeProjectOther={typeProjectOther}
          forseShowList={forseShowList}
          onSave={setResourcesUsage}
          data={resourcesUsage}
        />
      case "Solutions":
        return <Solutions
          forseShowList={forseShowList}
          data={solutions}
          list={list}
          loaded={loaded}
          countPages={countPages}
          currentPage={currentPage}
          categories={categories}
          attributes={attributes}
          filter={filter}
          cartTemp={cartTemp}
          getData={getData}
          onChangeFilter={onChangeFilter}
          onSave={setSolutions}
        />
      case "Place of installation":
        return <PlaceOfInstallation
          typeProjectOther={typeProjectOther}
          forseShowList={forseShowList}
          legalAddress={organization.legal_address || {}}
          data={placeOfInstallation}
          onSave={setPlaceOfInstallation}
        />
    }
  }

  return (
    <div className='container'>
      <div className='row pb-5 pb-lg-0'>
        {!loadedData && <div style={{
          position: 'fixed', zIndex: 99999999, display: 'flex', alignItems: 'center', justifyContent: 'center',
          top: 0,
          left: 0,
          width: '100%',
          height: '100vh',
          background: 'rgba(255,255,255, 0.4)'
        }} >
          <Spinner/>
        </div>}
        <ResultModal
          data={{
            organization,
            place_of_installation: placeOfInstallation,
            resources_usage: resourcesUsage,
            project_information: projectInformation,
            financial_indicators: financialIndicators,
            project_description: projectDescription,
            solutions,
            contact
          }}
          open={open}
          isProjectTypeOther={typeProjectOther}
          onSave={onSave}
          onClose={() => {setOpen(false)}}
        />
        <LoginModal open={openLoginModal} onClose={() => {setOpenLoginModal(false)}} />
        <div className='d-none d-lg-block col-lg-4'>
          <Navigation
            links={links}
            isOtherProject={typeProjectOther}
            activeNavigate={activeNavigate}
            onSaveDraft={onSaveDraft}
            onSaveSubmit={onSaveSubmit}
            draftId={draftId}
            applicationStatus={applicationStatus}
            status={application?.status}
            onChange={(v) => setActiveNavigate(v)}
          />
        </div>
        <div className='col-lg-8'>
          {renderCurrentSection(activeNavigate)}
          <NavigateTab
            links={links}
            activeNavigate={activeNavigate}
            applicationStatus={applicationStatus}
            status={applicationStatus}
            onChange={(v) => {
              setActiveNavigate(v);
              setTimeout(() => {
                window.scrollTo({
                  top: 0,
                  behavior: 'smooth'
                });
              }, 300);

            }}
            onSaveSubmit={onSaveSubmit}
          />
        </div>
      </div>
      <MobileMenu
        links={links}
        isOtherProject={typeProjectOther}
        activeNavigate={activeNavigate}
        onSaveDraft={onSaveDraft}
        onSaveSubmit={onSaveSubmit}
        draftId={draftId}
        applicationStatus={applicationStatus}
        status={application?.status}
        onChange={(v) => setActiveNavigate(v)}
      />
    </div>
  )
}

export default Commercial
