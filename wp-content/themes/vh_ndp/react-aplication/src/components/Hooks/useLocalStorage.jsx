import { useCallback, useState } from 'react';

export const useLocalStorage = (key, initialValue) => {
  const storedValue = localStorage.getItem(key);
  let parsedValue;

  try {
    parsedValue = storedValue ? JSON.parse(storedValue) : initialValue;
  } catch (error) {
    parsedValue = {};
  }

  const [value, setValue] = useState(parsedValue);

  const updateValue = useCallback((newValue) => {
    const updatedValue = newValue instanceof Function ? newValue(value) : newValue;
    setValue(updatedValue);
    localStorage.setItem(key, JSON.stringify(updatedValue));
  }, [value]);

  return [value, updateValue];
}
