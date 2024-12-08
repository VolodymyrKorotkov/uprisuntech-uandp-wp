import React, { useEffect, useState } from 'react'
import I18n from '../../../../../I18n/I18n';
import { Autocomplete, Button, FormControlLabel, Radio, RadioGroup } from '@mui/material'
import { SelectElement, TextFieldElement, } from 'react-hook-form-mui'
import global from '../../../../../../App.module.scss'
import styles from './LegalAddress.module.scss'
import AddressAutocomplete from 'mui-address-autocomplete';
import MyMapComponent from '../../../Map/Map'
import List from './List';

function BodyAddress({formContext, viewList, activeTab, onSave, data, typeProjectOther, reloadSearch, onChangeReloadSearch = () => {}}) {
  const [showSearch, setShowSearch] = useState(true);

  useEffect(() => {
    if(reloadSearch){
      setShowSearch(false);
      setTimeout(() => {
        setShowSearch(true)
      }, 100);
      onChangeReloadSearch(false)
    }
  }, [reloadSearch])

  return (
    <div className={global.body}>
      {!viewList && <>
        <div className='row'>
            <div className='col-md-12'>
              <SelectElement
                name={'property_type'}
                label={<I18n text={'Property type'} />}
                required
                options={[
                  {id: 'Own', label: <I18n text={'Own'} />},
                  {id: 'Rent', label: <I18n text={'Rent'} />},
                ]}
                fullWidth
                onChange={(v) => {
                  onSave({...data, 'property_type': v})
                }}
              />
            </div>
          </div>
        {activeTab == 'Tab1' && <>

          <div className='row'>
            <div className='col-md-12'>
              {showSearch && <AddressAutocomplete
                apiKey="AIzaSyB9aUxEyR_wIGZSzvzFotwRZ_u5tjuTtlw"
                label={<I18n text={!typeProjectOther ? 'Search on map *' : 'Search on map'} />}
                noOptionsText={<I18n text={"No options found"}/>}
                defaultValue={[data.street, data.street_number, data.city, data.state, data.postal_code].filter(_i => !!_i).join(', ')}
                fields={['geometry']} // fields will always contain address_components and formatted_address, no need to repeat them
                onChange={(_, value) => {
                  if(value){
                    const address = {
                      city: undefined,
                      state: undefined,
                      street: undefined,
                      street_number: undefined,
                      apartment: undefined,
                      postal_code: undefined,
                      lat: undefined,
                      lng: undefined,
                    };
                    if(value.address_components){

                      value.address_components.forEach(_i =>{
                        if(_i.types.includes("administrative_area_level_1")){
                          address.state = _i.long_name;
                        }
                        if(_i.types.includes("locality")){
                          address.city = _i.long_name;
                        }
                        if(_i.types.includes("route")){
                          address.street = _i.long_name;
                        }
                        if(_i.types.includes("street_number")){
                          address.street_number = _i.long_name;
                        }
                        if(_i.types.includes("postal_code")){
                          address.postal_code = _i.long_name;
                        }

                      })
                    }
                    if(value?.geometry?.location?.lat() && value?.geometry?.location?.lng()){
                      address.lat = value.geometry.location.lat();
                      address.lng = value.geometry.location.lng();
                    }
                    onSave({...data, ...address})
                    Object.entries(address).forEach(([name, value]) => formContext.setValue(name, value));
                  }
                }}
              />}
            </div>
          </div>
        </>}
        {activeTab == 'Tab2' && <>
          <div className='row'>
            <div className='col-md-12'>
              <TextFieldElement
                name={'state'}
                label={<I18n text={'State'} />}
                required
                fullWidth
                onChange={(e) => {
                  onSave({...data, 'state': e.target.value})
                }}
              />
            </div>
          </div>
          <div className='row'>
            <div className='col-md-12'>
              <TextFieldElement
                name={'city'}
                label={<I18n text={'City'} />}
                required
                fullWidth
                onChange={(e) => {
                  onSave({...data, 'city': e.target.value})
                }}
              />
            </div>
          </div>
          <div className='row'>
            <div className='col-md-12'>
              <RadioGroup
                row
                aria-labelledby="demo-row-radio-buttons-group-label"
                name="row-radio-buttons-group"
                defaultValue={'Private house'}
                value={data.apartment_type}
                onChange={(e, value) => {
                  onSave({...data, apartment_type: value})
                }}
              >
                <FormControlLabel value="Apartment" control={<Radio />} label={<I18n text={'Apartment'} />}/>
                <FormControlLabel value="Private house" control={<Radio />} label={<I18n text={'Private house'} />} />
              </RadioGroup>
            </div>
          </div>
          <div className='row'>
            <div className='col-md-8'>
              <TextFieldElement
                name={'street'}
                label={<I18n text={'Street'} />}
                required
                fullWidth
                onChange={(e) => {
                  onSave({...data, 'street': e.target.value})
                }}
              />
            </div>
            <div className='col-md-4 mt-3 mt-md-0'>
              <TextFieldElement
                name={'street_number'}
                label={<I18n text={'№'}/>}
                required
                fullWidth
                onChange={(e) => {
                  onSave({...data, 'street_number': e.target.value})
                }}
              />
            </div>

          </div>
          {data?.apartment_type == 'Private house' || <div className='row'>
            <div className='col-md-12'>
              <TextFieldElement
                name={'apartment'}
                label={<I18n text={data?.apartment_type == 'Private house' ? 'Private house #' : 'Apartment #'} />}
                fullWidth
                onChange={(e) => {
                  onSave({...data, 'apartment': e.target.value})
                }}
              />
            </div>
          </div>}
          <div className='row'>
            <div className='col-md-12'>
              <TextFieldElement
                name={'postal_code'}
                label={<I18n text={'Postal code'} />}
                required
                fullWidth
                onChange={(e) => {
                  onSave({...data, 'postal_code': e.target.value})
                }}
              />
            </div>
          </div>
        </>}
        <div className='row'>
          <div className='col-md-12'>
            <div className={styles.map}>
              <MyMapComponent lat={data.lat} lng={data.lng} />
            </div>
          </div>
        </div>

      </>}
      {viewList && <List data={data} />}
    </div>
  )
}

export default BodyAddress
