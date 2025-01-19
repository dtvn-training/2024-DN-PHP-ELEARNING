import { create } from 'zustand';

const useAuthStore = create((set) => ({
    authenticated: localStorage.getItem('authenticated') === 'true',
    setAuthenticated: (status) => {
        localStorage.setItem('authenticated', status);
        set({ authenticated: status });
    },
}));

export default useAuthStore;
