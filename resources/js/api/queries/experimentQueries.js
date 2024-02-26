import { useMutation } from "@tanstack/vue-query";
import api from "../api";

const experimentsList = async () => {
    const response = await api.get("/experiments");
    return response;
};

export const useExperimentsListMutation = () => useMutation({mutationFn: experimentsList});