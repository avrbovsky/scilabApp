import { useMutation } from "@tanstack/vue-query";
import api from "../api";

const experimentsList = async ({page, itemsPerPage, sortBy}) => {
    const url = `/experiments?page=${page || 1}&perPage=${itemsPerPage}`;
    const sortByQueryParams = sortBy ? `&sortByKey=${sortBy.key}&sortByOrder=${sortBy.order}` : "";

    try {
        const { data } = await api.get(url + sortByQueryParams);
        return data;
    } catch(err) {
        console.error(err.message);
        
        return err;
    }
};

const experimentCreate = async (experimentData) => {
    const formData = new FormData();
    formData.append('file', experimentData.file);
    formData.append("name", experimentData.name);
    formData.append("context", experimentData.context);
    formData.append("output", experimentData.output);

    try {
        const data = await api.post("/experiments", formData, {
            headers: {
              'Content-Type': 'multipart/form-data'
            },
        });
        
        return data;
    }catch (err) {
        console.error(err.message);
    }
};

const experimentDetail = async (experimentId) => {
    const url = `/experiments/${experimentId}`;
    
    try {
        const { data } = await api.get(url);
        return data;
    } catch(err) {
        console.error(err.message);
        
        return err;
    }
};

export const useExperimentsListMutation = () => useMutation({mutationFn: experimentsList});
export const useExperimentSaveMutation = () => useMutation({mutationFn: experimentCreate});
export const useExperimentDetailMutation = () => useMutation({mutationFn: experimentDetail});