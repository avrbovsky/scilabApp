import { useMutation } from "@tanstack/vue-query";
import api from "../api";

const experimentsList = async () => {
    try {
        const { data } = await api.get("/experiments");
        return data;
    } catch(err) {
        console.error(err.message);
        
        return err;
    }
};

export const useExperimentsListMutation = () => useMutation({mutationFn: experimentsList});