import { useState, useMemo } from 'react'
import classNames from 'classnames'
import { Dialog, Portal } from '@mui/material'
import styles from './MobileMenu.module.scss'
import I18n from "../../../I18n/I18n";
import Navigation from "../Navigation/Navigation";

const MobileMenu = ({ onChange, onSaveDraft, onSaveSubmit, links, ...props }) => {
  const [isOpenedMenu, setMenu] = useState(false)

  const toggleMenu = () => setMenu(prev => !prev)
  const closeMenu = () => setMenu(false)

  const handleSectionChanging = (action) => () => {
    closeMenu()
    action?.()
  }

  const navigationLinks = useMemo(
    () => links?.map(link => ({...link, onClick: handleSectionChanging(link.onClick)})),
    [links])

  const sectionsCount = navigationLinks?.length

  const currentSectionNumber = useMemo(
    () => navigationLinks.findIndex(link => link?.title === props?.activeNavigate) + 1,
    [props?.activeNavigate, navigationLinks]
  );

  return (
    <Portal>
      <div className={styles.menu}>
        <div className={styles.menu_row}>
          <div className={styles.count}>
            <span>{currentSectionNumber}</span> / <span>{sectionsCount} <I18n text="Section"/></span>
          </div>
          <div onClick={toggleMenu} className={styles.menu_toggler}>
            {isOpenedMenu ? (
              <div className={classNames(styles.menu_init)}>
                <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M19.25 6.41L17.84 5L12.25 10.59L6.66 5L5.25 6.41L10.84 12L5.25 17.59L6.66 19L12.25 13.41L17.84 19L19.25 17.59L13.66 12L19.25 6.41Z"
                    fill="#2A59BD"/>
                </svg>
                <span><I18n text="Close"/></span>
              </div>
            ) : (
              <div className={classNames(styles.menu_init)}>
                <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fillRule="evenodd" clipRule="evenodd"
                        d="M3.25 8V6H21.25V8H3.25ZM3.25 13H21.25V11H3.25V13ZM3.25 18H21.25V16H3.25V18Z" fill="#2A59BD"/>
                </svg>
                <span><I18n text="Menu"/></span>
              </div>
            )}
          </div>
        </div>
      </div>
      <Dialog
        sx={{
          '& .MuiDialog-container': {alignItems: 'end'}
        }}
        PaperProps={{
          sx: {
            background: 'none',
            boxShadow: 'none',
            paddingBottom: '40px',
            marginX: '12px',
            width: '100%'
          }
        }}
        fullWidth
        onClose={closeMenu}
        open={isOpenedMenu}
      >
        <Navigation
          {...props}
          links={navigationLinks}
          onChange={handleSectionChanging(onChange)}
          onSaveDraft={handleSectionChanging(onSaveDraft)}
          onSaveSubmit={handleSectionChanging(onSaveSubmit)}
        />
      </Dialog>
    </Portal>
  )
}

export default MobileMenu
