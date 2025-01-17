import { useQuery } from 'react-query';

const fetchFeatures = async () => {
    try {
        const response = await fetch('/data/featureInfo.json');
        return response.json();
    } catch {
        return [];
    }
};

const useFeaturesData = () => {
    return useQuery('features', fetchFeatures);
};

export default useFeaturesData;
