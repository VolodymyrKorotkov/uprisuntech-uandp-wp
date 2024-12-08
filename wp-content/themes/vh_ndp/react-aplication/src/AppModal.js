import { useEffect, useState } from 'react';
import ResultModal from './components/Commercial/components/ResultModal/ResultModal';

function AppModal() {
  const [open, setOpen] = useState(null);
  useEffect(() => {
    window.openResultApplicationModal = (data) => {
      setOpen(data)
    }
  }, [])

  return (<ResultModal
    data={open}
    title='Заявка'
    hideActions
    open={Boolean(open)}
    onClose={() => {setOpen(null)}}
  />
  );
}

export default AppModal;
