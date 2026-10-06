const ENV = {
    API_URL: (typeof window !== 'undefined' && window.APP_URL) ? window.APP_URL : (import.meta.env.VITE_HOST || ''),
    API_KEY: (typeof window !== 'undefined' && window.APP_KEY) ? window.APP_KEY : (import.meta.env.VITE_API_KEY || ''),
    GOOGLE_MAP_KEY: (typeof window !== 'undefined' && window.GOOGLE_TOKEN) ? window.GOOGLE_TOKEN : (import.meta.env.VITE_GOOGLE_MAP_KEY || ''),
    DEMO: (typeof window !== 'undefined' && window.APP_DEMO) ? window.APP_DEMO : (import.meta.env.VITE_DEMO || '')
};
export default ENV;